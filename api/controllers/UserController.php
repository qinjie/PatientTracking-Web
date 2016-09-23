<?php

namespace app\controllers;

use phpDocumentor\Reflection\Exception;
use Yii;
use yii\filters\VerbFilter;
use yii\rest\Controller;

/**
 * UserController implements API for client
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                // only POST method is allowed for the following request actions
                'actions' => [
                    'delete' => ['POST'],
                    'check' => ['POST'],
                    'login' => ['POST'],
                    'change' => ['POST'],
                    'email' => ['POST'],
                    'receive' => ['POST'],
                    'search' => ['POST'],
                    'resident' => ['POST'],
                    'nearest' => ['POST'],
                    'floor' => ['POST'],
                    'floors' => ['POST'],
                    'alerts' => ['POST'],
                    'alertuntakencare' => ['POST'],
                    'takecare' => ['POST'],
                    'mappoints' => ['POST']
                ],
            ],
        ];
    }

    /*
     * duration of the received token when login successfully
     */
    const session_timeout = '+1 month';

    /*
     * infinity number for calculation
     */
    const inf = 9223372036854775807;

    /**
     * @Description:
     *          - check if the session has been expired or not
     * @request:
     *          - query parameter: none
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: none
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a string value
     *                      1. failed: exception or inconsistent database
     *                      2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                      3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     */
    public function actionCheck()
    {
        try {
            // get token field from request header
            $token = Yii::$app->request->headers->get("token");

            // get expire time corresponding to the above token from usertoken table
            $expire = (new \yii\db\Query())
                ->select(['expire'])
                ->limit(1)
                ->from('usertoken')
                ->where(['token' => $token])
                ->all();

            // inconsistent database
            if (count($expire) == 0) {
                self::serverError();
                return 'failed';
            }

            // check if the session has been expired or not
            if ($expire[0]['expire'] > date('Y-m-d H:i:s')) {

                // set response header result value 'isNotExpired'
                Yii::$app->response->headers->set('result', 'isNotExpired');
                return 'isNotExpired';
            }

            // set response header result value 'isExpired'
            Yii::$app->response->headers->set('result', 'isExpired');
            return 'isExpired';
        } catch (\Exception $e) {
            self::serverError();
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - log in
     * @request:
     *          - query parameter: none
     *          - header: none
     *          - body: a json object with 3 attributes
     *                  {
     *                       "username": "admin",
     *                       "password": "12345678",
     *                       "mac_address": "f8:32:e4:5f:73:f5"
     *                  }
     * @response:
     *          - header: none
     *          - body: a json object with at most 2 attributes
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. wrong: wrong username or password
     *                          3. correct: correct username and password
     *                  + token: token for this log in session only if result = correct
     */
    public function actionLogin()
    {
        try {
            // get username attribute from request body
            $username = Yii::$app->request->post("username");

            // get password attribute from request body
            $password = Yii::$app->request->post("password");

            // get mac_address attribute from request body
            $mac_address = Yii::$app->request->post("mac_address");

            // get id corresponding to the above username from user table
            $user_id = self::getUserIdByUsername($username);

            // exception or inconsistent database
            if ($user_id == 'failed') {
                return [
                    'result' => 'failed'
                ];
            }

            // username does not exist
            if ($user_id == '-1') {
                return [
                    'result' => 'wrong'
                ];
            }

            // get password_hash corresponding to the above user_id from user table
            $password_hash = self::getPasswordHashByUserId($user_id);

            // exception or inconsistent database
            if ($password_hash == 'failed') {
                return [
                    'result' => 'failed'
                ];
            }

            // check password
            if (!Yii::$app->security->validatePassword($password, $password_hash)) {
                return [
                    'result' => 'wrong'
                ];
            }

            // get id corresponding to pair user_id and mac_address from usertoken table
            $userTokenId = self::getUserTokenId($user_id, $mac_address);

            // exception
            if ($userTokenId == 'failed') {
                return [
                    'result' => 'failed'
                ];
            }

            // get current time
            $now = date_create(date('Y-m-d H:i:s'));

            // calculate expire time basing on current time and constant session_timeout
            $expire = date_format(date_add($now, date_interval_create_from_date_string(self::session_timeout)), 'Y-m-d H:i:s');

            // generate hash input for session token
            $hashInput = $username . $mac_address . $expire;

            // generate session token using MD5 hashing algorithm from the above hash input
            $token = hash('md5', $hashInput);

            // check if this is the first time the user corresponding to the above username logs in successfully
            if ($userTokenId == '-1') {

                // insert a new record into usertoken table for the first successful log in
                $result = Yii::$app->db->createCommand()
                    ->insert('usertoken', ['user_id' => $user_id, 'token' => $token, 'mac_address' => $mac_address, 'expire' => $expire])->execute();

                // failed inserting
                if ($result != 1) {
                    return [
                        'result' => 'failed'
                    ];
                }
                return [
                    'result' => 'correct',
                    'token' => $token
                ];
            }

            // update token and expire columns corresponding to userTokenId in usertoken table
            $result = Yii::$app->db->createCommand()->update('usertoken', ['expire' => $expire, 'token' => $token], 'id = ' . $userTokenId)->execute();

            // failed updating
            if ($result != 1) {
                return [
                    'result' => 'failed'
                ];
            }
            return [
                'result' => 'correct',
                'token' => $token
            ];
        } catch (\Exception $e) {
            return [
                'result' => 'failed'
            ];
        }
    }

    /**
     * @Description:
     *          - change password, if it is successful then make all session tokens related to the user in other devices expired
     * @request:
     *          - query parameter: none
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: a json object with 3 attributes
     *                  {
     *                       "username": "admin",
     *                       "current_password": "12345678",
     *                       "new_password": "123456789",
     *                       "mac_address": "f8:32:e4:5f:73:f5"
     *                  }
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a string value
     *                      1. failed: exception or inconsistent database or the session is expired
     *                      2. wrong: wrong username or password
     *                      3. success: update password corresponding to the username successfully
     */
    public function actionChange()
    {
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired')
                return 'failed';

            // get username attribute from request body
            $username = Yii::$app->request->post("username");

            // get current_password attribute from request body
            $current_password = Yii::$app->request->post("current_password");

            // get new_password attribute from request body
            $new_password = Yii::$app->request->post("new_password");

            // get mac_address attribute from request body
            $mac_address = Yii::$app->request->post("mac_address");

            // get id corresponding to the above username from user table
            $user_id = self::getUserIdByUsername($username);

            // exception or inconsistent database
            if ($user_id == 'failed') {
                return 'failed';
            }

            // username does not exist
            if ($user_id == '-1') {
                return 'wrong';
            }

            // get password_hash corresponding to the above user_id from user table
            $password_hash = self::getPasswordHashByUserId($user_id);

            // exception or inconsistent database
            if ($password_hash == 'failed') {
                return 'failed';
            }

            // check if current password the user has input correct or not
            if (!Yii::$app->security->validatePassword($current_password, $password_hash)) {
                return 'wrong';
            }

            // generate password_hash from the above new password
            $password_hash = Yii::$app->security->generatePasswordHash($new_password);

            // update password_hash column corresponding to user_id in user table
            $result = Yii::$app->db->createCommand()->update('user', ['password_hash' => $password_hash], 'id = ' . $user_id)->execute();

            // failed updating
            if ($result != 1) {
                self::serverError();
                return 'failed';
            }

            // make all session tokens related to the user in other devices expired

            // get current time
            $now = date_format(date_create(date('Y-m-d H:i:s')), 'Y-m-d H:i:s');

            // update expire column corresponding to the user and other mac_address rather than the above mac_address in usertoken table
            $res = Yii::$app->db->createCommand()->update('usertoken', ['expire' => $now], 'user_id = ' . $user_id . ' and mac_address != \'' . $mac_address . '\'')->execute();

            return 'success';

        } catch (\Exception $e) {
            self::serverError();
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - get email corresponding to a username in user table
     * @request:
     *          - query parameter:
     *                  + username:
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: none
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a string value
     *                      1. failed: exception or inconsistent database or the session is expired or username does not exist
     *                      2. email of user that has username
     */
    public function actionEmail($username)
    {
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired')
                return 'failed';

            // get email corresponding to username in user table
            $result = (new \yii\db\Query())
                ->select('email')
                ->limit(1)
                ->from('user')
                ->where(['username' => $username])
                ->all();

            // username does not exist
            if (count($result) == 0)
                return 'failed';
            return $result[0]['email'];
        } catch (\Exception $e) {
            self::serverError();
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - receive Firebase Cloud Messaging (FCM) token from client for each device basing on MAC address
     * @request:
     *          - query parameter: none
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: a json object with 2 attributes
     *                  {
     *                       "mac_address": "f8:32:e4:5f:73:f5",
     *                       "fcm_token": "fELcJZln7O4:APA91bEecWKGSCFSSMpg1dQJOMlz7af91bjYw5O8bt5nKTO8z8tqhMTQR...FgMZ"
     *                  }
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a string value
     *                      1. failed: exception or inconsistent database or the session is expired
     *                      2. success: receive FCM token corresponding to the MAC address successfully
     */
    public function actionReceive()
    {
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired')
                return 'failed';

            // get mac_address attribute from request body
            $mac_address = Yii::$app->request->post('mac_address');

            // get fcm_token attribute from request body
            $fcm_token = Yii::$app->request->post('fcm_token');

            // get FCM token id corresponding to the above MAC address from fcmtoken table
            $fcmTokenId = self::getFcmTokenId($mac_address);

            // exception or inconsistent database
            if ($fcmTokenId == 'failed') {
                self::serverError();
                return 'failed';
            }
            $result = 1;

            // if this is the first time receive FCM token from device corresponding to the MAC address
            if ($fcmTokenId == '-1') {

                // insert a new record into fcmtoken table for the first successful receiving FCM token for the device corresponding to the MAC address
                $result = Yii::$app->db->createCommand()
                    ->insert('fcmtoken', ['mac_address' => $mac_address, 'fcm_token' => $fcm_token])->execute();
            } else {

                // update fcmtoken column for the device corresponding to the MAC address in fcmtoken table
                $result = Yii::$app->db->createCommand()->update('fcmtoken', ['fcm_token' => $fcm_token], 'id = ' . $fcmTokenId)->execute();
            }

            //failed inserting or updating
            if ($result != 1) {
                self::serverError();
                return 'failed';
            }
            return 'success';
        } catch (\Exception $e) {
            self::serverError();
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - search resident basing on name, floor id within location timeout and sort the returned result list
     * @request:
     *          - query parameter: none
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: a json object with 4 attributes
     *                  + name: key word for search resident name
     *                  + location: id number of floor, 'all' for all floors
     *                  + sort:
     *                          1. id: sort by resident id
     *                          2. name: sort by resident name
     *                          3. floor_id: sort by floor id
     *                  + drec:
     *                          1. asc: sort the result in ascending order
     *                          2. desc: sort the result descending order
     *
     *                  => example json object for getting all residents detected within location timeout
     *
     *                  {
     *                       "name": "",
     *                       "location": "all",
     *                       "sort": '"id",
     *                       "drec": "asc"
     *                  }
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a json array of searched residents
     *
     *               [
     *                 {
     *                   "id": "13",
     *                   "firstname": "Mark",
     *                   "lastname": "Zuckerberg",
     *                   "floor_id": "1",
     *                   "label": "Floor 1",
     *                   "coorx": "-1.31",
     *                   "coory": "8.11"
     *                 },
     *                 {
     *                   "id": "42",
     *                   "firstname": "Tim",
     *                   "lastname": "Cook",
     *                   "floor_id": "1",
     *                   "label": "Floor 1",
     *                   "coorx": "-1.95",
     *                   "coory": "7.95"
     *                 }
     *              ]
     */
    public function actionSearch()
    {
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired')
                return [];

            // get name attribute from request body
            $name = Yii::$app->request->post('name');

            // get location attribute from request body
            $location = Yii::$app->request->post('location');

            // get sort attribute from request body
            $sort = Yii::$app->request->post('sort');

            // get drec attribute from request body
            $drec = Yii::$app->request->post('drec');

            // normalize the name received as key word for searching resident
            $name = str_ireplace(' ', '', $name);

            // sort result by order1 then order 2 then order 3 then order 4
            $order1 = '';
            $order2 = '';
            $order3 = '';
            $order4 = '';

            // define order values basing on the sort value
            if ($sort == 'id') {
                $order1 = 'id ' . $drec;
                $order2 = 'firstname';
                $order3 = 'lastname';
                $order4 = 'floor_id';
            } else {
                if ($sort == 'name') {
                    $order1 = 'firstname ' . $drec;
                    $order2 = 'lastname ' . $drec;
                    $order3 = 'id';
                    $order4 = 'floor_id';
                } else {
                    $order1 = 'floor_id ' . $drec;
                    $order2 = 'firstname';
                    $order3 = 'lastname';
                    $order4 = 'id';
                }
            }

            // create sort sql query in string format
            $sort = $order1 . ', ' . $order2 . ', ' . $order3 . ', ' . $order4;

            // query data to search resident basing on name, floor id within location timeout and sort the result
            //$result = Yii::$app->db
            //    ->createCommand('select resident.id, firstname, lastname, floor_id, label, coorx, coory
            //               from resident, floor, location
            //                where resident.id = resident_id
            //                and floor.id = floor_id
            //                and outside = 0
            //                and location.created_at >= ((NOW() - INTERVAL ' . Yii::$app->params['locationTimeOut'] . ' SECOND))
            //                and REPLACE(CONCAT(`firstname`, `lastname`), \' \', \'\') like \'%' . $name . '%\'
            //                and (\'' . $location . '\' = \'all\' or floor_id = \'' . $location . '\')
            //                order by ' . $sort)
            //    ->queryAll();

            $cmd = Yii::$app->db
                ->createCommand("select resident.id, firstname, lastname, floor_id, label, coorx, coory
                            from resident, floor, location
                            where resident.id = resident_id
                            and floor.id = floor_id
                            and outside = 0
							and REPLACE(CONCAT(`firstname`, `lastname`), ' ', '') like :name
							and ('all'=:location or floor_id = :location)
                            order by :sort");
            $cmd->bindValue(':location', $location);
            $cmd->bindValue(':sort', $sort);
            $cmd->bindValue(':name', '%'.$name.'%');
            $result = $cmd->queryAll();
            return $result;
        } catch (\Exception $e) {
            self::serverError();
            return [];
        }
    }

    /**
     * @Description:
     *          - get resident detail by resident id
     * @request:
     *          - query parameter:
     *                  + id: id of a resident
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: none
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a json object of the resident detail corresponding to the resident id
     *
     *               {
     *                 "id": "13",
     *                 "firstname": "Mark",
     *                 "lastname": "Zuckerberg",
     *                 "nric": "NRIC 1",
     *                 "gender": "male",
     *                 "birthday": "1950-01-01",
     *                 "contact": "",
     *                 "remark": " ",
     *                 "lastmodified": "2016-08-01 11:01:17",
     *                 "nextofkin": [
     *                               {
     *                                 "id": "1",
     *                                 "nric": "S123456",
     *                                 "first_name": "NextOfKin 1 FirstName",
     *                                 "last_name": "NextOfKin 1 LastName",
     *                                 "contact": "813534",
     *                                 "email": "abc@gmail.com",
     *                                 "remark": "dadadada\ndadada\nxxx\nccvdvdvd",
     *                                 "relation": "Mother2"
     *                               },
     *                               {
     *                                 "id": "12",
     *                                 "nric": "abcd",
     *                                 "first_name": "Duc",
     *                                 "last_name": "Do",
     *                                 "contact": "",
     *                                 "email": "",
     *                                 "remark": "",
     *                                 "relation": "Brother"
     *                               },
     *                               {
     *                                 "id": "33",
     *                                 "nric": "1234",
     *                                 "first_name": "NP",
     *                                 "last_name": "Poly",
     *                                 "contact": "",
     *                                 "email": "",
     *                                 "remark": "",
     *                                 "relation": "Neighbor"
     *                               },
     *                               {
     *                                 "id": "42",
     *                                 "nric": "222",
     *                                 "first_name": "ABC",
     *                                 "last_name": "DEF",
     *                                 "contact": "",
     *                                 "email": "",
     *                                 "remark": "",
     *                                 "relation": "Brother"
     *                               }
     *                             ]
     *              }
     */
    public function actionResident($id)
    {
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired')
                return (object)[];

            // get resident detail corresponding to the id from resident table
            $res = self::getResident($id);

            // if the resident corresponding to the id does not exist or exception when query
            if (count($res) == 0) {
                return (object)[];
            }

            // query data for nexofkin of the resident
            $nex = (new \yii\db\Query())
                ->select(['nextofkin.id', 'nric', 'first_name', 'last_name', 'contact', 'email', 'remark', 'relation'])
                ->from(['nextofkin', 'resident_relative'])
                ->where('resident_relative.resident_id = ' . $id)
                ->andWhere('nextofkin.id = resident_relative.nextofkin_id')
                ->all();

            // assign the $nex result as a attribute named 'nextofkin' in $res
            $res[0]['nextofkin'] = $nex;

            // return result as a object
            return $res[0];
        } catch (\Exception $e) {
            self::serverError();
            return (object)[];
        }
    }

    /**
     * @Description:
     *          - get the nearest resident to the username's location
     * @request:
     *          - query parameter:
     *                  + username
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: none
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a json object of the nearest resident to the username's location or unknown object
     *
     *               {
     *                 "id": "13",
     *                 "firstname": "Mark",
     *                 "lastname": "Zuckerberg",
     *                 "distance": "1.0254131"
     *              }
     */
    public function actionNearest($username)
    {
        // create unknown object - username's location is not detected or no resident is in the same floor with the username
        $unknown = (object)[
            'firstname' => 'unknown',
            'lastname' => '',
            'distance' => 'unknown'
        ];
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired') {
                return $unknown;
            }

            // get id corresponding to the query parameter username from user table
            $user_id = self::getUserIdByUsername($username);

            // exception or inconsistent database or username does not exist
            if ($user_id == 'failed' || $user_id == '-1') {
                self::serverError();
                return $unknown;
            }

            // get user location from location table basing on user_id
            $user = self::getUserLocationByUserId($user_id);

            // exception or the user's location is not detected
            if ($user == 'failed') {
                return $unknown;
            }

            // get all residents that are in the same floor with the user
            $residentList = self::getResidentByFloorId($user['floor_id']);

            // exception
            if ($residentList == 'failed') {
                self::serverError();
                return $unknown;
            }

            // assign distance variable to infinity in order to find the smallest distance
            $distance = self::inf;

            // just initialize value for residentId variable, nothing important
            $residentId = -1;

            // find the nearest resident to the user
            for ($i = 0; $i < count($residentList); $i++) {

                // distance between the user and the current resident of for loop in the residentList
                $val = sqrt(pow($user['coorx'] - $residentList[$i]['coorx'], 2) + pow($user['coory'] - $residentList[$i]['coory'], 2));

                // if the above distance is smaller than the smallest distance has been found in the first $i residents: 0 -> $i - 1
                // then we find the nearer result
                // note: by using < comparison, if there are more than one residents who have the same nearest distance then the first one appears in the list is chosen
                if ($val < $distance) {

                    // assign the better result to $distance and the corresponding resident id to $residentId
                    $distance = $val;
                    $residentId = $residentList[$i]['resident_id'];
                }
            }

            // that $distance equals to the initial infinity means no resident found in the same floor with the user
            // we can check whether ($residentId == -1) instead
            if ($distance == self::inf)
                return $unknown;

            // get resident information corresponding to the $residentId
            $res = self::getResident($residentId);

            // exception or no resident has resident id equals to $residentId
            if (count($res) == 0) {
                return $unknown;
            }

            // get the nearest resident object
            $resident = $res[0];

            // assign the nearest distance as a attribute named 'distance' in the above resident object
            $resident['distance'] = $distance;
            return $resident;

        } catch (\Exception $e) {
            self::serverError();
            return $unknown;
        }
    }

    /**
     * @Description:
     *          - get floor list information and the number of resident in each floor by the id of the floor
     * @request:
     *          - query parameter:
     *                  + id: id of a floor (id is an integer number or 'all' ( for all floors))
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: none
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a json array of floor information corresponding to floor id, in case id != 'all', the array contain at most 1 object
     *
     *               [
     *                 {
     *                   "id": "1",
     *                   "label": "Floor 1",
     *                   "description": "This is floor 1",
     *                   "width": "122",
     *                   "height": "20",
     *                   "count": "7"
     *                 }
     *               ]
     */
    public function actionFloor($id = 'all')
    {
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired')
                return [];

            // query floor information by the id and
            // 'count' is the number of resident detected in the floor within the location timeout
            $result = Yii::$app->db
                ->createCommand('select floor_alias.id, label, description, width, height, COUNT(resident.id) as `count`
                            from (select * from floor
                            where (\'' . $id . '\' = \'all\' or floor.id = \'' . $id . '\')) as `floor_alias`
                            left join location
                            on floor_alias.id = floor_id
                            and outside = 0
                            left join resident
                            on resident.id = resident_id
                            and location.created_at >= ((NOW() - INTERVAL ' . Yii::$app->params['locationTimeOut'] . ' SECOND))
                            group by floor_alias.id')
                ->queryAll();
            return $result;
        } catch (\Exception $e) {
            self::serverError();
            return [];
        }
    }

    /**
     * @Description:
     *          - get all floors' basic information
     * @request:
     *          - query parameter: none
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: none
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a json array of all floors's basic information
     *
     *               [
     *                 {
     *                   "id": "1",
     *                   "label": "Floor 1",
     *                   "file_path": "uploads/1.png",
     *                   "thumbnail_path": "uploads/thumbnail_1.png",
     *                   "count": "3"
     *                 },
     *                 {
     *                   "id": "2",
     *                   "label": "Floor 2",
     *                   "file_path": null,
     *                   "thumbnail_path": null
     *                   "count": "3"
     *                 }
     *               ]
     */
    public function actionFloors()
    {
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired')
                return [];

            // query all floors' basic information: id, label, file_path, thumbnail_path
            $result = (new \yii\db\Query())
                ->select(['floor.id', 'label', 'file_path', 'thumbnail_path'])
                ->from('floor')
                ->leftJoin('floor_map', 'floor.id = floor_id')
                ->orderBy('floor.id')
                ->all();
            for ($i = 0; $i < count($result); $i++) {
                $count = (new \yii\db\Query())
                    ->select('count(*) as count')
                    ->from('location')
                    ->where(['floor_id' => $result[$i]['id']])
                    ->all();
                $alert = (new \yii\db\Query())
                    ->select('count(*) as alert')
                    ->from('notification')
                    ->where(['last_position' => $result[$i]['id']])
                    ->andWhere('user_id is NULL')
                    ->all();
                $result[$i]['count'] = $count[0]['count'];
                $result[$i]['ongoing_alerts'] = $alert[0]['alert'];
            }
            return $result;
        } catch (\Exception $e) {
            self::serverError();
            return [];
        }
    }

    /**
     * @Description:
     *          - get all alerts basing on id and takencare or untakencare status, in order to get information of a specific notification use ok = 'all'
     *          - also get user_id and username who has taken care of a notification
     * @request:
     *          - query parameter:
     *                  + id: notification id (id is an integer number or 'all' (for all notifications))
     *                  + ok: 'all' for all notifications corresponding to the above id parameter,
     *                         otherwise for all notifications corresponding to the above id parameter that has not been taken care of
     *                         (note: in order to get information of a specific notification use id = an integer and ok = 'all')
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: none
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a json array of all notifications corresponding to described id and ok parameters, in case id != 'all', the array contain at most 1 object
     *
     *          => example result for id = '13' and ok = 'all'
     *          "ok" attribute in the below json object is different from 'ok' parameter, it shows the status of whether the notification has been taken care of not
     *              + "1" : already taken care of
     *              + "0" : not yet taken care of
     *
     *               [
     *                 {
     *                   "id": "13",
     *                   "resident_id": "1",
     *                   "firstname": "Mark",
     *                   "lastname": "Zuckerberg",
     *                   "last_position": "floor 7",
     *                   "user_id": null,
     *                   "username": null,
     *                   "ok": "0"
     *                 }
     *               ]
     */
    public function actionAlerts($id, $ok)
    {
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired')
                return [];

            // query all notifications corresponding to id and ok parameter and sort them in descending order by updated time
            // and user_id and username who has taken care of the notification
            $result = (new \yii\db\Query())
                ->select(['notification.id', 'notification.resident_id', 'firstname', 'lastname', 'last_position', 'user_id', 'username', 'notification.created_at', 'floor.label as last_position_label', 'notification.type'])
                ->from('notification')
                ->leftJoin('user', 'notification.user_id = user.id')
                ->innerJoin('resident', 'notification.resident_id = resident.id')
                ->leftJoin('floor', 'notification.last_position = floor.id')
                ->andWhere('\'' . $id . '\' =  \'all\' or notification.id = \'' . $id . '\'')
                ->andWhere('\'' . $ok . '\' = \'all\' or user_id is NULL')
                ->orderBy('notification.updated_at desc')
                ->all();

            // assign value to 'ok' attribute for each notification
            for ($i = 0; $i < count($result); $i++) {

                // if the notification has not been taken care of by any user
                if ($result[$i]['user_id'] == NULL) {
                    $result[$i]['ok'] = '0';
                } else {
                    $result[$i]['ok'] = '1';
                }
            }
            return $result;
        } catch (\Exception $e) {
            self::serverError();
            return [];
        }
    }

    /**
     * @Description:
     *          - handle request of pushing a notification to devices
     * @request:
     *          - query parameter:
     *                  + resident_id: id of resident that is related to the pushing notification request
     *                  + last_position: newest position that the system has detected the resident in case of notifying a new notification related to the resident
     *                  + ok: status of the notification whether it is new (= '0') or some user already taken care of it (= '1')
     *                  + id: -1 if the request requests a new notification
     *                        otherwise notification id in the database related to the request
     *                  + user_id: id of the user that has taken care of the resident,
     *                             in case user_id = '-1', the id parameter also should equals '-1' and it means the request requests a new notification related to the resident
     *                  + mac_address: MAC address of the target device that will receive the notification,
     *                                 'all' for all devices
     *                                 specific MAC address: only for resending notification if user logs in the device
     *                  + type: Type of alert
     *                      1: Resident go to alert area
     *                      2: Resident press the button
     *                      3: Resident go out of tracking area
     *
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: none
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a string value
     *               1. failed: exception or inconsistent database
     *               2. isNotAlertable: the pushing notification request is not accepted because there is a notification related to the resident has not been taken care
     *               3. success: the pushing notification request is accepted and successfully send the notification to target devices
     */
    public function actionAlert($resident_id, $last_position = '', $ok = '0', $id = '-1', $user_id = '-1', $mac_address = 'all', $type = 1)
    {
        try {
            // if the request requests a new notification for all devices but there exists an untakencare notification related to the resident
            if (!self::isAlertable($resident_id) && $mac_address == 'all')
                return 'isNotAlertable';

            // get some basic information of the resident
            $query = (new \yii\db\Query())
                ->select(['firstname', 'lastname'])
                ->from('resident')
                ->where(['id' => $resident_id])
                ->all();

            // if resident_id does not exits in resident table
            if (count($query) == 0) {
                self::serverError();
                return 'failed';
            }

            // get firstname of the resident from the above result
            $firstname = $query[0]['firstname'];

            // get lastname of the resident from the above result
            $lastname = $query[0]['lastname'];

            // if the request requests a new notification
            if ($id == '-1') {
                // get current date time
                $now = date_format(date_create(date('Y-m-d H:i:s')), 'Y-m-d H:i:s');

                // insert a new record into notification table for a new notification related to the resident
                $result = Yii::$app->db->createCommand()
                    ->insert('notification', ['resident_id' => $resident_id, 'last_position' => $last_position, 'created_at' => $now, 'updated_at' => $now, 'type' => $type])->execute();

                // failed inserting
                if ($result != 1) {
                    self::serverError();
                    return 'failed';
                }

                // get the id which is automatically generated when inserting a new notification record into notification table
                $id = Yii::$app->db->lastInsertID;
            }

            // just assign a default value to username variable, nothing important
            $username = '';

            // if the user corresponding to the user_id take an action to take care the resident
            if ($user_id != '-1') {
                // get username corresponding to the user_id
                $username = self::getUsernameById($user_id);

                // exception or inconsistent database
                if ($username == 'failed') {
                    self::serverError();
                    return 'failed';
                }
            }

            // prepare data to push a notification to target devices
            $data = array('message' => ['id' => $id, 'resident_id' => $resident_id, 'firstname' => $firstname, 'lastname' => $lastname, 'last_position' => $last_position, 'ok' => $ok, 'user_id' => $user_id, 'username' => $username]);

            // prepare notification to push a notification to target devices
            $notification = array('title' => 'Urgent', 'body' => 'Patients are in danger!');

            // $ids contains all FCM tokens that are registered by target devices
            $ids = array();

            // get FCM tokens corresponding to target devices basing on MAC address
            $result = (new \yii\db\Query())
                ->select('fcm_token')
                ->from('fcmtoken')
                ->where('\'' . $mac_address . '\' =  \'all\' or mac_address = \'' . $mac_address . '\'')
                ->all();

            // add NOT NULL fcm_token into $ids array
            for ($i = 0; $i < count($result); $i++) {
                if ($result[$i]['fcm_token'] != NULL) {
                    array_push($ids, $result[$i]['fcm_token']);
                }
            }

            // push a notification to all devices which have registered FCM token that contained in $ids with $notification and $data content
            self::sendFirebaseCloudMessage($ids, $notification, $data);
            return 'success';
        } catch (\Exception $e) {
            self::serverError();
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - push all untakencare notifications to a specific device
     * @request:
     *          - query parameter:
     *                  + mac_address: MAC address of the target device that will receive the notifications
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: none
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a string value
     *               1. failed: exception or inconsistent database or the session is expired
     *               2. success: successfully push all untakencare notifications to the target device
     */
    public function actionAlertuntakencare($mac_address)
    {
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired')
                return 'failed';

            // query all notifications have not been taken care of and sort in ascending order by created time
            $notificationList = (new \yii\db\Query())
                ->select(['*'])
                ->from('notification')
                ->where('user_id is NULL')
                ->orderBy('created_at asc')
                ->all();

            // request pushing notification to the target device
            for ($i = 0; $i < count($notificationList); $i++) {

                // get the current notification in the for loop
                $notification = $notificationList[$i];

                // call actionAlert function to notify to the target device
                $result = self::actionAlert($notification['resident_id'], $notification['last_position'], '0', $notification['id'], '-1', $mac_address);

                // exception or inconsistent database
                if ($result == 'failed') {
                    return 'failed';
                }
            }
            return 'success';
        } catch (\Exception $e) {
            self::serverError();
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - take care of an untakencare notification
     * @request:
     *          - query parameter:
     *                  + id: id of the untakencare notification
     *                  + username: who wants to take the notification
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: none
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: a string value
     *               1. failed: exception or inconsistent database or the session is expired
     *               2. success: successfully take care of the notification
     *               3. a different username: in case the notification has already taken care of by another username
     */
    public function actionTakecare($id, $username)
    {
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired')
                return 'failed';

            // if the notification has already been taken care of
            if (self::isTakencareof($id)) {

                // query the user_id which related to the user who has taken care of the notification from notification table
                $result = (new \yii\db\Query())
                    ->select('user_id')
                    ->from('notification')
                    ->where(['id' => $id])
                    ->all();

                // inconsistent database
                if (count($result) == 0) {
                    self::serverError();
                    return 'failed';
                }

                // get username corresponding to the above user_id
                $username = self::getUsernameById($result[0]['user_id']);

                // exception or inconsistent database
                if ($username == 'failed') {
                    self::serverError();
                    return 'failed';
                }
                return $username;
            }

            // get user_id corresponding to the username parameter from user table
            $user_id = self::getUserIdByUsername($username);

            // exception or inconsistent database
            if ($user_id == '-1' || $user_id == 'failed') {
                self::serverError();
                return 'failed';
            }

            // get the current date time
            $now = date_format(date_create(date('Y-m-d H:i:s')), 'Y-m-d H:i:s');

            // update user_id and updated_at columns corresponding to the id parameter in notification table
            $result = Yii::$app->db->createCommand()->update('notification', ['user_id' => $user_id, 'updated_at' => $now], 'id = ' . $id)->execute();
            if ($result != 1) {
                self::serverError();
                return 'failed';
            }
            return self::updatealert($id);
        } catch (\Exception $e) {
            self::serverError();
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - get positions (coordinates in the real system and corresponding pixels in the map) in a specific floor map for all residents and a specific user
     * @request:
     *          - query parameter:
     *                  + floor_id: id of a floor
     *                  + username: who need to be located in the floor corresponding to the above floor_id
     *          - header:
     *                  + token: token for checking session timeout
     *          - body: none
     * @response:
     *          - header:
     *                  + result:
     *                          1. failed: exception or inconsistent database
     *                          2. isExpired: token has expired (expire value corresponding to the token <= now)
     *                          3. isNotExpired: token has not expired (expire value corresponding to the token > now)
     *          - body: json array of all residents detected within location timeout and their positions in the floor,
     *                  the position of the user corresponding to the username is added as the last object with "id" attribute equals "-1"
     *                      only if the user is detected within location timeout in the floor
     *                [
     *                 {
     *                   "id": "1",
     *                   "firstname": "First Name x1",
     *                   "coorx": "6",
     *                   "coory": "0",
     *                   "pixelx": 865,
     *                   "pixely": 1,
     *                   "color": -16776961
     *                  },
     *                  {
     *                   "id": -1,
     *                   "coorx": "3",
     *                   "coory": "4",
     *                   "color": -16711936,
     *                   "pixelx": 433,
     *                   "pixely": 363
     *                  }
     *                ]
     */
    public function actionMappoints($floor_id, $username)
    {
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired') {
                return [];
            }

            // get all markers' information of the map corresponding to floor_id form marker table
            $result = (new \yii\db\Query())
                ->select(['pixelx', 'pixely', 'coorx', 'coory'])
                ->from('marker')
                ->where(['floor_id' => $floor_id])
                ->all();

            // assign infinity and -1 to topLeft and bottomRight's pixels and coordinates in order to define the top left and bottom right points of the map
            $topLeftPixelx = self::inf;
            $topLeftCoorx = 0.0;
            $topLeftPixely = self::inf;
            $topLeftCoory = 0.0;

            $bottomRightPixelx = -1;
            $bottomRightCoorx = 0.0;
            $bottomRightPixely = -1;
            $bottomRightCoory = 0.0;


            for ($i = 0; $i < count($result); $i++) {

                // comparison for finding the smallest x-pixel in all markers and the corresponding x-coordinate in the real system
                if ($result[$i]['pixelx'] < $topLeftPixelx) {
                    $topLeftPixelx = $result[$i]['pixelx'];
                    $topLeftCoorx = $result[$i]['coorx'];
                }
                // comparison for finding the smallest y-pixel in all markers and the corresponding y-coordinate in the real system
                if ($result[$i]['pixely'] < $topLeftPixely) {
                    $topLeftPixely = $result[$i]['pixely'];
                    $topLeftCoory = $result[$i]['coory'];
                }

                // comparison for finding the largest x-pixel in all markers and the corresponding x-coordinate in the real system
                if ($result[$i]['pixelx'] > $bottomRightPixelx) {
                    $bottomRightPixelx = $result[$i]['pixelx'];
                    $bottomRightCoorx = $result[$i]['coorx'];
                }

                // comparison for finding the largest y-pixel in all markers and the corresponding y-coordinate in the real system
                if ($result[$i]['pixely'] > $bottomRightPixely) {
                    $bottomRightPixely = $result[$i]['pixely'];
                    $bottomRightCoory = $result[$i]['coory'];
                }
            }

            // query coordinates and some basic information of all residents detected within location timeout in the floor corresponding to the floor_id parameter
            $res = Yii::$app->db
                ->createCommand('select resident.id, firstname, coorx, coory
                            from resident, location
                            where resident.id = resident_id
                            and (floor_id = \'' . $floor_id . '\')
                            and outside = 0')
                ->queryAll();
            // and location.created_at >= (NOW() - INTERVAL ' . Yii::$app->params['locationTimeOut'] . ' SECOND)

            // calculate the width of the map in pixel corresponding to the markers (not the real width)
            $widthPixel = $bottomRightPixelx - $topLeftPixelx;

            // calculate the height of the map in pixel corresponding to the markers (not the real height)
            $heightPixel = $bottomRightPixely - $topLeftPixely;

            // calculate the width of the floor in meter corresponding to the markers (not the real width)
            $widthCoor = $bottomRightCoorx - $topLeftCoorx;

            // calculate the height of the floor in meter corresponding to the markers (not the real height)
            $heightCoor = $bottomRightCoory - $topLeftCoory;

            // get id corresponding to the query parameter username from user table
            $user_id = self::getUserIdByUsername($username);

            // exception or inconsistent database or username does not exist
            if ($user_id == 'failed' || $user_id == '-1') {
                self::serverError();
                return [];
            }

            // get user location by user_id from location table
            $user = self::getUserLocationByUserId($user_id);

            // exception or the user is not detected by the system within location timeout
            if ($user == 'failed') {
//                return [];
            }
            else{
                // if the user is currently in the floor that has id equals floor_id
                if ($user['floor_id'] == $floor_id) {
                    // get the number of resident in the array $res
                    $cnt = count($res);

                    // add a ($cnt + 1)-th element (user-element) into $res describing the user's position information

                    // set attribute 'id' to '-1' in order to distinguish with the residents
                    $res[$cnt]['id'] = -1;

                    // assign the 'coorx' and 'coory' attributes of the user-element
                    $res[$cnt]['coorx'] = $user['coorx'];
                    $res[$cnt]['coory'] = $user['coory'];

                    // set green color for the user when displaying it on the map
                    $res[$cnt]['color'] = -16711936;
                }
            }

            for ($i = 0; $i < count($res); $i++) {

                // calculate pixel positions of the resident basing on the above top left point and the above calculated widths and heights in pixel and meter of the map
                $res[$i]['pixelx'] = $topLeftPixelx + intval(round(1.0 * ($res[$i]['coorx'] - $topLeftCoorx) / $widthCoor * $widthPixel));
                $res[$i]['pixely'] = $topLeftPixely + intval(round(1.0 * ($res[$i]['coory'] - $topLeftCoory) / $heightCoor * $heightPixel));

                // for testing purpose
//                $x = rand(min($topLeftCoorx, $bottomRightCoorx) + 1, max($topLeftCoorx, $bottomRightCoorx) - 1);
//                $y = rand(min($topLeftCoory, $bottomRightCoory) + 1, max($topLeftCoory, $bottomRightCoory) - 1);
//
//                $res[$i]['pixelx'] = $topLeftPixelx + intval(round(1.0 * ($x - $topLeftCoorx) / $widthCoor * $widthPixel));
//                $res[$i]['pixely'] = $topLeftPixely + intval(round(1.0 * ($y - $topLeftCoory) / $heightCoor * $heightPixel));

                // set color for the resident when displaying it on the map
                if ($res[$i]['id'] != -1) {

                    // if there is currently no untakencare notification related to the resident
                    if (self::isAlerted($res[$i]['id'])) {
                        // set red color
                        $res[$i]['color'] = -65536;
                    } else {
                        // set blue color
                        $res[$i]['color'] = -16776961;
                    }

                }
            }
            return $res;
        } catch (\Exception $e) {
            self::serverError();
            return [];
        }
    }

    private function isAlerted($resident_id){
        try {
            $result = (new \yii\db\Query())
                ->select(['id'])
                ->from('notification')
                ->where(['resident_id' => $resident_id])
                ->andWhere('user_id is not NULL')
                ->all();
            if (count($result) > 0) {
                return true;
            }
            return false;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @Description:
     *          - get number of alert
     */

    public function actionAlertcount()
    {
        try {
            // check session timeout
            if (self::actionCheck() != 'isNotExpired')
                return 'failed';
            $query = (new \yii\db\Query())
                ->select(['count(*) as num'])
                ->from('notification')
                ->andWhere('user_id is NULL')
                ->all();
            return $query[0]['num'];
        } catch (\Exception $e) {
            self::serverError();
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - push a updated notification corresponding to the $id parameter to all registered devices
     * @parameter:
     *          + $id: notification id
     * @return string
     *              1. failed: exception or inconsistent database
     *              2. isNotAlertable: the notification is already taken care of
     *              3. success: successfully update the notification
     */
    private function updatealert($id)
    {
        try {
            // query resident_id and user_id corresponding to the id parameter from notification table
            $result = (new \yii\db\Query())
                ->select(['resident_id', 'user_id'])
                ->from('notification')
                ->where(['id' => $id])
                ->all();

            // the id does not exist in notification table
            if (count($result) == 0)
                return 'failed';

            // get resident_id from the above result
            $resident_id = $result[0]['resident_id'];

            // get user_id from the above result
            $user_id = $result[0]['user_id'];

            // call alert function to push a updated notification to all registered devices
            return self::actionAlert($resident_id, '', '1', $id, $user_id, 'all');
        } catch (\Exception $e) {
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - check if the resident if alertable or not,
     *            in other words  check if there is an untakencare notification related to the resident or not
     * @parameter:
     *          + $resident_id: id of a resident
     * @return bool
     *              1. true: alertable
     *              2. false: not alertable
     */
    private function isAlertable($resident_id)
    {
        try {
            $result = (new \yii\db\Query())
                ->select(['id'])
                ->from('notification')
                ->where(['resident_id' => $resident_id])
                ->andWhere('updated_at >= (NOW() - INTERVAL ' . Yii::$app->params['alertTimeOut'] . ' SECOND)')
                ->all();
            if (count($result) > 0) {
                return false;
            }
            // get the latest notification id that related to the resident_id parameter
            $notification_id = self::latestNotificationId($resident_id);

            // if there is no notification related to the resident_id
            if ($notification_id == '-1')
                return true;

            // exception occurs when querying database
            if ($notification_id == 'failed')
                return false;

            // return whether the notification corresponding to the above notification_id has been taken care of by any user or not
            return self::isTakencareof($notification_id);
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @Description:
     *          - get the latest notification id that related to the resident_id parameter
     * @parameter:
     *          + $resident_id: id of a resident
     * @return string
     *              1. -1: no notification_id related to the resident_id in notification table
     *              2. failed: exception
     *              3. the latest notification_id related to the resident_id in notification table
     */
    private function latestNotificationId($resident_id)
    {
        try {
            // query all notification_id related to the resident_id from notification table and sort the result in descending order by created time
            $result = (new \yii\db\Query())
                ->select('id')
                ->limit(1)
                ->from('notification')
                ->where(['resident_id' => $resident_id])
                ->orderBy('created_at desc')
                ->all();

            // no notification_id related to the resident_id found
            if (count($result) == 0) {
                return '-1';
            }
            return $result[0]['id'];
        } catch (\Exception $e) {
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - check if the notification has been taken care of or not
     * @parameter:
     *          + $id: id of a notification
     * @return bool
     *              1. true: already taken care of
     *              2. false: not yet taken care of
     */
    private function isTakencareof($id)
    {
        try {
            // get user_id corresponding to the id parameter from notification table
            $result = (new \yii\db\Query())
                ->select('user_id')
                ->limit(1)
                ->from('notification')
                ->where(['id' => $id])
                ->all();

            // if the user_id corresponding to the id != NULL then the notification has been taken care of by the user
            return $result[0]['user_id'] != NULL;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @Description:
     *          - send a notification to devices using Firebase Cloud Messaging
     * @parameter:
     *          + $ids: array of all FCM tokens that are registered by devices
     *          + $notification: notification to push a notification to target devices (currently this parameter is not in use)
     *          + $data: data to push a notification to target devices
     * @return mixed|string
     */
    private function sendFirebaseCloudMessage($ids, $notification, $data)
    {
        try {
            // Insert real FCM API key from Google APIs Console
            // https://code.google.com/apis/console/
            $apiKey = 'AIzaSyAhwoQzA2NhAvXJaDXFd11B_91aJrcDHIo';

            // Define URL to FCM endpoint
            $url = 'https://fcm.googleapis.com/fcm/send';

            // Set FCM post variables (device IDs and push payload)
            $post = [
                'registration_ids' => $ids,
                'priority' => 'high',
//            'notification'      => $notification,
                'data' => $data
            ];

            // Set CURL request headers (authentication and type)
            $headers = array(
                'Authorization: key=' . $apiKey,
                'Content-Type: application/json'
            );

            // Initialize curl handle
            $ch = curl_init();

            // Set URL to FCM endpoint
            curl_setopt($ch, CURLOPT_URL, $url);

            // Set request method to POST
            curl_setopt($ch, CURLOPT_POST, true);

            // Set our custom headers
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            // Get the response back as string instead of printing it
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Ignore SSL verification
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            // Set JSON post data
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));

            // Actually send the push
            $result = curl_exec($ch);

            // Error handling
            if (curl_errno($ch)) {
                return 'FCM error: ' . curl_error($ch);
            }

            // Close curl handle
            curl_close($ch);

            // Debug FCM response
            return $result;
        } catch (\Exception $e) {
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - get a resident information in resident table
     * @parameter:
     *          + $id: id of a resident
     * @return array
     */
    private function getResident($id)
    {
        try {
            // query all columns corresponding to the id parameter from resident table
            $result = (new \yii\db\Query())
                ->select(['*'])
                ->limit(1)
                ->from('resident')
                ->where(['id' => $id])
                ->all();
            return $result;
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * @Description:
     *          - get coordinates of all residents in a specific floor
     * @parameter:
     *          + $floor_id: id of a floor
     * @return array|string
     */
    private function getResidentByFloorId($floor_id)
    {
        try {
            // query resident_id, coorx and coory columns corresponding to the floor_id parameter
            // user_id equals NULL for querying only resident information
            $result = (new \yii\db\Query())
                ->select(['resident_id', 'coorx', 'coory'])
                ->from('location')
                ->where(['floor_id' => $floor_id])
                ->andWhere(['user_id' => NULL])
                ->all();
            return $result;
        } catch (\Exception $e) {
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - get the username of a user from user table by id
     * @parameter:
     *          + $id: id of a user
     * @return string
     */
    private function getUsernameById($id)
    {
        try {
            // query username corresponding to the id parameter from user table
            $result = (new \yii\db\Query())
                ->select('username')
                ->limit(1)
                ->from('user')
                ->where(['id' => $id])
                ->all();

            // if the id does not exist in user table
            if (count($result) == 0)
                return 'failed';
            return $result[0]['username'];
        } catch (\Exception $e) {
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - get the id of a user from user table by username
     * @parameter:
     *          + $username
     * @return string
     */
    private function getUserIdByUsername($username)
    {
        try {
            // query id corresponding to the username parameter from user table
            $result = (new \yii\db\Query())
                ->select(['id'])
                ->limit(1)
                ->from('user')
                ->where(['username' => $username])
                ->all();

            // if the username does not exist in user table
            if (count($result) == 0)
                return '-1';
            return $result[0]['id'];
        } catch (\Exception $e) {
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - get position (coordinates in some floor) of a specific user
     * @parameter:
     *          + $user_id: id of a user
     * @return string or an three-attribute object
     *              {
     *                "floor_id": "1",
     *                "coorx": "3",
     *                "coory": "4"
     *               }
     */
    private function getUserLocationByUserId($user_id)
    {
        try {
            // query floor_id and coordinates detected within location timeout corresponding to the user_id parameter from location table
            $result = (new \yii\db\Query())
                ->select(['floor_id', 'coorx', 'coory'])
                ->limit(1)
                ->from('location')
                ->where(['user_id' => $user_id])
                ->andWhere('location.created_at >= (NOW() - INTERVAL ' . Yii::$app->params['locationTimeOut'] . ' SECOND)')
                ->all();

            // if no position information of the user found within location timeout
            if (count($result) == 0)
                return 'failed';
            return $result[0];
        } catch (\Exception $e) {
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - get password_hash of a user from user table by id
     * @parameter:
     *          + $id: id of a user
     * @return string
     */
    private function getPasswordHashByUserId($id)
    {
        try {
            // query password_hash corresponding to the id parameter from user table
            $result = (new \yii\db\Query())
                ->select(['password_hash'])
                ->limit(1)
                ->from('user')
                ->where(['id' => $id])
                ->all();

            // if the id does not exist in user table
            if (count($result) == 0)
                return 'failed';
            return $result[0]['password_hash'];
        } catch (\Exception $e) {
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - get the id of a record from usertoken table by pair of user_id and MAC address
     * @parameter:
     *          + $user_id: id of a user
     *          + $mac_address: MAC address of a device
     * @return string
     */
    private function getUserTokenId($user_id, $mac_address)
    {
        try {
            // query id corresponding to the pair of two parameter from usertoken
            $result = (new \yii\db\Query())
                ->select('id')
                ->limit(1)
                ->from('usertoken')
                ->where(['user_id' => $user_id])
                ->andWhere(['mac_address' => $mac_address])
                ->all();

            // if no record corresponding to user_id and mac_address found in usertoken table
            if (count($result) == 0)
                return '-1';
            return $result[0]['id'];
        } catch (\Exception $e) {
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - get the id of a record from fcmtoken table by MAC address
     * @parameter:
     *          + $mac_address: MAC address of a device
     * @return string
     */
    private function getFcmTokenId($mac_address)
    {
        try {
            // query id corresponding to the mac_address parameter from fcmtoken
            $result = (new \yii\db\Query())
                ->select('id')
                ->limit(1)
                ->from('fcmtoken')
                ->where(['mac_address' => $mac_address])
                ->all();

            // if the mac_address does not exist in fcmtoken table
            if (count($result) == 0)
                return '-1';
            return $result[0]['id'];
        } catch (\Exception $e) {
            return 'failed';
        }
    }

    /**
     * @Description:
     *          - set response header 'result' value 'failed' in case exception occurs
     */
    private function serverError()
    {
        // set response header 'result' value 'failed' in case exception occurs
        Yii::$app->response->headers->set('result', 'failed');
    }
}