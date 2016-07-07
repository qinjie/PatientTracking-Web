<?php

namespace app\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\base\ErrorException;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;

/**
 * UserController implements the CRUD actions for User model.
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
                'actions' => [
                    'delete' => ['POST'],
                    'check' => ['POST'],
                    'login' => ['POST'],
                    'search' => ['POST'],
                    'resident' => ['POST'],
                    'floor' => ['POST'],
                    'floors' => ['POST'],
                    'takecare' => ['POST'],
                    'alerts' => ['POST'],
                    'receive' => ['POST'],
                    'mappoints' => ['POST']
                ],
            ],
        ];
    }

    /**
     * Android
     */
    public function actionCheck()
    {
        $token = Yii::$app->request->headers->get("token");
        $expire = (new \yii\db\Query())
            ->select(['expire'])
            ->limit(1)
            ->from('usertoken')
            ->where('token = \''.$token.'\'')
            ->all();
        if(count($expire) == 0)
        {
            Yii::$app->response->headers->set('result', 'isNotExist');
            return 'isNotExist';
        }
        if($expire[0]['expire'] > date('Y-m-d H:i:s'))
        {
            Yii::$app->response->headers->set('result', 'isNotExpired');
            return 'isNotExpired';
        }
        Yii::$app->response->headers->set('result', 'isExpired');
        return 'isExpired';
    }
    public function actionLogin()
    {
        $username = Yii::$app->request->post("username");
        $password = Yii::$app->request->post("password");
        $MAC = Yii::$app->request->post("MAC");
        $userId = self::getUserId($username, $password);
        if($userId == -1){
            return [
                'result' => 'wrong'
            ];
        }
        $userTokenId = self::getUserTokenId($userId, $MAC);
        $now = date_create(date('Y-m-d H:i:s'));
        $expire = date_format(date_add($now, date_interval_create_from_date_string('1 months')), 'Y-m-d H:i:s');
        $hashInput = $username.$MAC.$expire;
        $token = hash('md5', $hashInput);
        if($userTokenId == -1)
        {
            Yii::$app->db->createCommand()
                ->insert('usertoken', ['user_id' => $userId, 'token' =>$token, 'ip_address' => $MAC, 'expire' => $expire])->execute();
            return [
                'result' => 'correct',
                'token' => $token
            ];
        }
        Yii::$app->db->createCommand()->update('usertoken', ['expire' => $expire, 'token' => $token], 'id = '.$userTokenId)->execute();
        return [
            'result' => 'correct',
            'token' => $token
        ];
    }
    public function actionSearch()
    {
        if(self::actionCheck() != 'isNotExpired')
            return [];
        $name = Yii::$app->request->post('name');
        $location = Yii::$app->request->post('location');
        $sort = Yii::$app->request->post('sort');
        $drec = Yii::$app->request->post('drec');
        $name = str_ireplace(' ', '', $name);
        $order1 = ''; $order2 = ''; $order3 = ''; $order4 = '';
        if($sort == 'id')
        {
            $order1 = 'id '.$drec;
            $order2 = 'firstname';
            $order3 = 'lastname';
            $order4 = 'floor_id';
        }
        else
        {
            if($sort == 'name')
            {
                $order1 = 'firstname '.$drec;
                $order2 = 'lastname '.$drec;
                $order3 = 'id';
                $order4 = 'floor_id';
            }
            else
            {
                $order1 = 'floor_id '.$drec;
                $order2 = 'firstname';
                $order3 = 'lastname';
                $order4 = 'id';
            }
        }
        $sort = $order1.', '.$order2.', '.$order3.', '.$order4;
        $result = Yii::$app->db
            ->createCommand('select resident.id, firstname, lastname, floor_id, label, coorx, coory
                            from resident, floor, resident_location
                            where resident.id = resident_id
                            and floor.id = floor_id
                            and outside = 0
                            and resident_location.created_at = (
                                select MAX(resident_location.created_at)
                                from resident_location
                                where resident_id = resident.id
                                and outside = 0)
                            and REPLACE(CONCAT(`firstname`, `lastname`), \' \', \'\') like \'%' .$name . '%\'
                            and (\''.$location.'\' = \'all\' or floor_id = \''.$location.'\')
                            order by '.$sort)
            ->queryAll();
        return $result;
    }
    public function actionResident($id)
    {
        if(self::actionCheck() != 'isNotExpired')
            return [];
        $res = self::getResident($id);
        $nex = (new \yii\db\Query())
            ->select(['nextofkin.id', 'nric', 'first_name', 'last_name', 'contact', 'email', 'remark', 'relation'])
            ->from(['nextofkin', 'resident_relative'])
            ->where('resident_relative.resident_id = '.$id)
            ->andWhere('nextofkin.id = resident_relative.nextofkin_id')
            ->all();
        $res[0]['nextofkin'] = $nex;
        return $res[0];
    }
    public function actionFloor($id = 'all')
    {
        if(self::actionCheck() != 'isNotExpired')
            return [];
        $result = Yii::$app->db
            ->createCommand('select floor_alias.id, label, description, width, height, COUNT(resident.id) as `count`
                            from (select * from floor
                            where (\''.$id.'\' = \'all\' or floor.id = \''.$id.'\')) as `floor_alias`
                            left join resident_location
                            on floor_alias.id = floor_id
                            and outside = 0
                            left join resident
                            on resident.id = resident_id
                            and resident_location.created_at = (
                                select MAX(resident_location.created_at)
                                from resident_location
                                where resident_id = resident.id
                                and outside = 0)
                            group by floor_alias.id')
            ->queryAll();
        return $result;
    }
    public function actionFloors()
    {
        if(self::actionCheck() != 'isNotExpired')
            return [];
        $result = (new \yii\db\Query())
            ->select(['floor.id', 'label', 'file_path', 'thumbnail_path'])
            ->from('floor')
            ->leftJoin('floor_map', 'floor.id = floor_id')
            ->orderBy('floor.id')
            ->all();
        return $result;
    }
    public function actionTakecare($id, $username)
    {
        if(self::actionCheck() != 'isNotExpired')
            return 'isExpired';
        if(self::isTakencareof($id))
        {
            $result = (new \yii\db\Query())
                ->select('user_id')
                ->from('user_notification')
                ->where(['notification_id' => $id])
                ->all();
            return self::getUsernameById($result[0]['user_id']);
        }
        $userId = self::getUserIdByUsername($username);
        if($userId == -1)
            return 'failed';
        $now = date_format(date_create(date('Y-m-d H:i:s')), 'Y-m-d H:i:s');
        Yii::$app->db->createCommand()
            ->insert('user_notification', ['user_id' => $userId, 'notification_id' =>$id, 'created_at' => $now])->execute();
        self::updatealert($id);
        return 'success';
    }
    public function actionAlerts($id, $ok)
    {
        if(self::actionCheck() != 'isNotExpired')
            return [];
        $result = Yii::$app->db
            ->createCommand('select * from
                                ((select notification.id, notification.resident_id, firstname, lastname, last_position, user_id, username, COUNT(user_id) as `ok`
                                from notification
                                left join user_notification
                                on notification.id = user_notification.notification_id
                                left join user
                                on user_notification.user_id = user.id
                                join resident
                                on notification.resident_id = resident.id
                                and (\''.$id.'\' = \'all\' or notification.id = \''.$id.'\')
                                group by notification.id
                                order by notification.created_at desc) as `alert_alias`)
                            where (\''.$ok.'\' = \'all\' or alert_alias.ok = \''.$ok.'\')')
            ->queryAll();
        return $result;
    }
    public function actionAlert($resident_id, $last_position = '', $ok = '0', $id = '-1', $user_id = '-1')
    {
        if(!self::isAlertable($resident_id))
            return 'isNotAlertable';
        $query = (new \yii\db\Query())
            ->select(['firstname', 'lastname'])
            ->from('resident')
            ->where(['id' => $resident_id])
            ->all();
        if(count($query) == 0)
            return 'failed';
        $firstname = $query[0]['firstname'];
        $lastname = $query[0]['lastname'];
        if($id == '-1')
        {
            $now = date_format(date_create(date('Y-m-d H:i:s')), 'Y-m-d H:i:s');
            Yii::$app->db->createCommand()->insert('notification', ['resident_id' => $resident_id, 'last_position' => $last_position ,'created_at' => $now])->execute();
            $id = Yii::$app->db->lastInsertID;
        }
        $username = '';
        if($user_id != -'1')
        {
            $username = self::getUsernameById($user_id);
        }
        $data = array( 'message' => ['id' => $id, 'resident_id' => $resident_id, 'firstname' => $firstname, 'lastname' => $lastname, 'last_position' => $last_position, 'ok' => $ok, 'user_id' => $user_id, 'username' => $username]);

        $notification = array( 'title' => 'Urgent', 'body' => 'Patients are in danger!');
        $ids = array();
        $result = (new \yii\db\Query())
            ->select('gcm_token')
            ->from('usertoken')
            ->all();
        for($i = 0; $i < count($result); $i++)
        {
            if($result[$i]['gcm_token'] != NULL)
                array_push($ids, $result[$i]['gcm_token']);
        }

//        self::sendGoogleCloudMessage( $ids, $notification, $data);
        self::sendFirebaseCloudMessage($ids, $notification, $data);
        return 'success';
    }
    public function actionReceive()
    {
        if(self::actionCheck() != 'isNotExpired')
            return [];
        $MAC = Yii::$app->request->post('MAC');
        $gcm_token = Yii::$app->request->post('gcm_token');
        Yii::$app->db->createCommand()->update('usertoken', ['gcm_token' => $gcm_token], 'ip_address = \''.$MAC.'\'')->execute();
        return [];
    }
    public function actionMappoints($floorid)
    {
        if(self::actionCheck() != 'isNotExpired')
            return [];
        $result = (new \yii\db\Query())
            ->select(['pixelx', 'pixely', 'coorx', 'coory'])
            ->from('marker')
            ->where(['floor_id' => $floorid])
            ->all();

        $inf = 9223372036854775807;

        $topLeftPixelx = $inf; $topLeftCoorx = 0.0;
        $topLeftPixely = $inf; $topLeftCoory = 0.0;

        $bottomRightPixelx = -1; $bottomRightCoorx = 0.0;
        $bottomRightPixely = -1; $bottomRightCoory = 0.0;


        for($i = 0; $i < count($result); $i++)
        {
            if($result[$i]['pixelx'] < $topLeftPixelx)
            {
                $topLeftPixelx = $result[$i]['pixelx'];
                $topLeftCoorx = $result[$i]['coorx'];
            }
            if($result[$i]['pixely'] < $topLeftPixely)
            {
                $topLeftPixely = $result[$i]['pixely'];
                $topLeftCoory = $result[$i]['coory'];
            }

            if($result[$i]['pixelx'] > $bottomRightPixelx)
            {
                $bottomRightPixelx = $result[$i]['pixelx'];
                $bottomRightCoorx = $result[$i]['coorx'];
            }
            if($result[$i]['pixely'] > $bottomRightPixely)
            {
                $bottomRightPixely = $result[$i]['pixely'];
                $bottomRightCoory = $result[$i]['coory'];
            }
        }

        $res = Yii::$app->db
            ->createCommand('select resident.id, firstname, coorx, coory
                            from resident, floor, resident_location
                            where resident.id = resident_id
                            and floor.id = floor_id
                            and outside = 0
                            and resident_location.created_at = (
                                select MAX(resident_location.created_at)
                                from resident_location
                                where resident_id = resident.id
                                and outside = 0)
                            and (floor_id = \''.$floorid.'\')')
            ->queryAll();

        $widthPixel = $bottomRightPixelx - $topLeftPixelx;
        $heightPixel = $bottomRightPixely - $topLeftPixely;
        $widthCoor = $bottomRightCoorx - $topLeftCoorx;
        $heightCoor = $bottomRightCoory - $topLeftCoory;

        for($i = 0; $i < count($res); $i++)
        {
            try
            {
                $res[$i]['pixelx'] = $topLeftPixelx + intval(round(1.0*($res[$i]['coorx'] - $topLeftCoorx)/$widthCoor*$widthPixel));
                $res[$i]['pixely'] = $topLeftPixely + intval(round(1.0*($res[$i]['coory'] - $topLeftCoory)/$heightCoor*$heightPixel));
            }
            catch(\Exception $ex)
            {
                return [];
            }

//            $x = rand(min($topLeftCoorx, $bottomRightCoorx) + 1, max($topLeftCoorx, $bottomRightCoorx) - 1);
//            $y = rand(min($topLeftCoory, $bottomRightCoory) + 1, max($topLeftCoory, $bottomRightCoory) - 1);
//            try
//            {
//                $res[$i]['pixelx'] = $topLeftPixelx + intval(round(1.0*($x - $topLeftCoorx)/$widthCoor*$widthPixel));
//                $res[$i]['pixely'] = $topLeftPixely + intval(round(1.0*($y - $topLeftCoory)/$heightCoor*$heightPixel));
//            }
//            catch(\Exception $ex)
//            {
//                return [];
//            }
        }
        return $res;

    }
    private function updatealert($id)
    {
        $result1 = (new \yii\db\Query())
            ->select('resident_id')
            ->from('notification')
            ->where(['id' => $id])
            ->all();
        $result2 = (new \yii\db\Query())
            ->select('user_id')
            ->from('user_notification')
            ->where(['notification_id' => $id])
            ->all();
        if(count($result1) == 0 || count($result2) == 0)
            return '404';
        $resident_id = $result1[0]['resident_id'];
        $user_id= $result2[0]['user_id'];
        self::actionAlert($resident_id, '', '1', $id, $user_id);
        return 'success';
    }
    private function isAlertable($resident_id)
    {
        $notification_id = self::latestNotificationId($resident_id);
        if($notification_id == '-1')
            return true;
        return self::isTakencareof($notification_id);
    }
    private function latestNotificationId($resident_id)
    {
        $result = (new \yii\db\Query())
            ->select('id')
            ->limit(1)
            ->from('notification')
            ->where(['resident_id' => $resident_id])
            ->orderBy('created_at desc')
            ->all();
        if(count($result) == 0)return '-1';
        return $result[0]['id'];
    }
    private function isTakencareof($notification_id)
    {
        $num = (new \yii\db\Query())
            ->select('COUNT(id) as \'count\'')
            ->from('user_notification')
            ->where(['notification_id' => $notification_id])
            ->all();
        return $num[0]['count'] !== '0';
    }
    private function sendGoogleCloudMessage( $ids, $notification, $data)
    {
        // Insert real GCM API key from Google APIs Console
        // https://code.google.com/apis/console/
        $apiKey = 'AIzaSyAhwoQzA2NhAvXJaDXFd11B_91aJrcDHIo';

        // Define URL to GCM endpoint
        $url = 'https://gcm-http.googleapis.com/gcm/send';

        // Set GCM post variables (device IDs and push payload)
        $post = [
            'registration_ids'  => $ids,
            'priority'          => 'high',
//            'notification'      => $notification,
            'data'              => $data
        ];

        // Set CURL request headers (authentication and type)
        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );

        // Initialize curl handle
        $ch = curl_init();

        // Set URL to GCM endpoint
        curl_setopt( $ch, CURLOPT_URL, $url );

        // Set request method to POST
        curl_setopt( $ch, CURLOPT_POST, true );

        // Set our custom headers
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

        // Get the response back as string instead of printing it
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );

        // Set JSON post data
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );

        // Actually send the push
        $result = curl_exec( $ch );

        // Error handling
        if ( curl_errno( $ch ) )
        {
            return 'GCM error: ' . curl_error( $ch );
        }

        // Close curl handle
        curl_close( $ch );

        // Debug GCM response
        return $result;
    }
    private function sendFirebaseCloudMessage( $ids, $notification, $data)
    {
        // Insert real GCM API key from Google APIs Console
        // https://code.google.com/apis/console/
        $apiKey = 'AIzaSyAhwoQzA2NhAvXJaDXFd11B_91aJrcDHIo';

        // Define URL to GCM endpoint
        $url = 'https://fcm.googleapis.com/fcm/send';

        // Set GCM post variables (device IDs and push payload)
        $post = [
            'registration_ids'  => $ids,
            'priority'          => 'high',
//            'notification'      => $notification,
            'data'              => $data
        ];

        // Set CURL request headers (authentication and type)
        $headers = array(
            'Authorization: key=' . $apiKey,
            'Content-Type: application/json'
        );

        // Initialize curl handle
        $ch = curl_init();

        // Set URL to GCM endpoint
        curl_setopt( $ch, CURLOPT_URL, $url );

        // Set request method to POST
        curl_setopt( $ch, CURLOPT_POST, true );

        // Set our custom headers
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

        // Get the response back as string instead of printing it
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );

        // Set JSON post data
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode( $post ) );

        // Actually send the push
        $result = curl_exec( $ch );

        // Error handling
        if ( curl_errno( $ch ) )
        {
            return 'GCM error: ' . curl_error( $ch );
        }

        // Close curl handle
        curl_close( $ch );

        // Debug GCM response
        return $result;
    }
    private function getResident($id)
    {
        $result = (new \yii\db\Query())
            ->select(['*'])
            ->from('resident')
            ->where('id = \''.$id.'\'')
            ->all();
        return $result;
    }
    private function getUsernameById($id)
    {
        $result = (new \yii\db\Query())
            ->select('username')
            ->from('user')
            ->where(['id' => $id])
            ->all();
        if(count($result) == 0)
            return '-1';
        return $result[0]['username'];
    }
    private function getUserIdByUsername($username)
    {
        $result = (new \yii\db\Query())
            ->select(['id'])
            ->limit(1)
            ->from('user')
            ->where('username = \''.$username.'\'')
            ->all();
        if(count($result) == 0)
            return -1;
        return $result[0]['id'];
    }
    private function getUserId($username, $password)
    {
        $result = (new \yii\db\Query())
            ->select(['id'])
            ->limit(1)
            ->from('user')
            ->where('username = \''.$username.'\'')
            ->andWhere('access_token = \''.$password.'\'')
            ->all();
        if(count($result) == 0)
            return -1;
        return $result[0]['id'];
    }
    private function getUserTokenId($userId, $MAC)
    {
        $result = (new \yii\db\Query())
            ->select('id')
            ->limit(1)
            ->from('usertoken')
            ->where('user_id = \''.$userId.'\'')
            ->andWhere('ip_address = \''.$MAC.'\'')
            ->all();
        if(count($result) == 0)
            return -1;
        return $result[0]['id'];
    }
    private function getToken($userId, $MAC)
    {
        $result = (new \yii\db\Query())
            ->select('token')
            ->limit(1)
            ->from('usertoken')
            ->where(['user_id' => $userId, 'ip_address' => $MAC])
            ->all();
        return $result[0]['token'];
    }
}