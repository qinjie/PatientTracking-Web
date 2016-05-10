<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }






    /**
     * Android
     */
    public $enableCsrfValidation = true;
    public function beforeAction($action)
    {
        if (in_array($action->id, ['check', 'login'])) {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }
    public function actionCheck()
    {
        $token = Yii::$app->request->post("token");
        $expire = (new \yii\db\Query())
            ->select(['expire'])
            ->limit(1)
            ->from('usertoken')
            ->where('token = \''.$token.'\'')
            ->all();
        if(count($expire) == 0)
            return 'isNotExist';
        if($expire[0]['expire'] > date('Y-m-d H:i:s'))
            return 'isNotExpired';
        return 'isExpired';
    }
    public function actionLogin()
    {
        $username = Yii::$app->request->post("username");
        $pasword = Yii::$app->request->post("password");
        $MAC = Yii::$app->request->post("MAC");
        $userId = self::getUserId($username, $pasword);
        if($userId == -1)
            return '{"result" : "wrong"}';
        $userTokenId = self::getUserTokenId($userId, $MAC);
        $now = date_create(date('Y-m-d H:i:s'));
        $expire = date_format(date_add($now, date_interval_create_from_date_string('1 minutes')), 'Y-m-d H:i:s');
        if($userTokenId == -1)
        {
            $hashInput = $username.$MAC;
            $token = hash('md5', $hashInput);
            Yii::$app->db->createCommand()
                ->insert('usertoken', ['user_id' => $userId, 'token' =>$token, 'ip_address' => $MAC, 'expire' => $expire])->execute();
            return '{"result" : "correct", "token" : "'.$token.'"}';
        }
        else
        {
            Yii::$app->db->createCommand()->update('usertoken', ['expire' => $expire], 'id = '.$userTokenId)->execute();
            $token = self::getToken($userId);
            return '{"result" : "correct", "token" : "'.$token.'"}';
        }
    }
    public function actionSearch($name = '', $location = 'all', $sortParam = 'resident_id', $drec = 'asc')
    {
        $name = str_ireplace(' ', '', $name);
        $order1 = ''; $order2 = ''; $order3 = ''; $order4 = '';
        if($sortParam == 'resident_id')
        {
            $order1 = 'resident_id '.$drec;
            $order2 = 'firstname';
            $order3 = 'lastname';
            $order4 = 'floor_id';
        }
        else
        {
            if($sortParam == 'name')
            {
                $order1 = 'firstname '.$drec;
                $order2 = 'lastname '.$drec;
                $order3 = 'resident_id';
                $order4 = 'floor_id';
            }
            else
            {
                $order1 = 'floor_id '.$drec;
                $order2 = 'firstname';
                $order3 = 'lastname';
                $order4 = 'resident_id';
            }
        }
        $sortParam = $order1.', '.$order2.', '.$order3.', '.$order4;
        $result = Yii::$app->db
            ->createCommand('select resident_id, firstname, lastname, floor_id, label, coorx, coory
                                            from resident, floor, resident_location
                                            where resident.id = resident_id
                                            and floor.id = floor_id
                                            and outside = 0
                                            and resident_location.created_at = (
                                                select MAX(resident_location.created_at)
                                                from resident_location
                                                where resident_id = resident.id
                                                and outside = 0)
                                            and CONCAT(`firstname`, `lastname`) like \'%' .$name . '%\'
                                and (\''.$location.'\' = \'all\' or floor_id = \''.$location.'\')
                                order by '.$sortParam)
            ->queryAll();
        return json_encode($result);
    }
    public function actionResidentname($id)
    {
        $result = (new \yii\db\Query())
            ->select(['firstname', 'lastname'])
            ->from('resident')
            ->where(['id' => $id])
            ->all();
        return json_encode($result[0]);
    }
    public function actionResident($id)
    {
        $res = $this->getResident($id);
        $nex = (new \yii\db\Query())
            ->select(['nextofkin.id', 'nric', 'first_name', 'last_name', 'contact', 'email', 'remark', 'relation'])
            ->from(['nextofkin', 'resident_relative'])
            ->where('resident_relative.resident_id = '.$id)
            ->andWhere('nextofkin.id = resident_relative.nextofkin_id')
            ->all();
        return '{"resident" : '.json_encode($res).', "nextofkin" : '.json_encode($nex).'}';
    }
    public function getResident($id)
    {
        $result = (new \yii\db\Query())
            ->select(['*'])
            ->from('resident')
            ->where('id = \''.$id.'\'')
            ->all();
        return $result;
    }
    public function actionFloor($id = 'all')
    {
        $result = Yii::$app->db
            ->createCommand('select floor.id, label, description, width, height, COUNT(resident.id) as `count`
                            from floor
                            left join resident_location
                            on floor.id = floor_id
                            and outside = 0
                            and (\''.$id.'\' = \'all\' or floor.id = \''.$id.'\')
                            left join resident
                            on resident.id = resident_id
                            and resident_location.created_at = (
                            select MAX(resident_location.created_at)
                            from resident_location
                            where resident_id = resident.id
                            and outside = 0)
                            group by floor.id')
            ->queryAll();
        return json_encode($result);
    }
    public function actionFloors()
    {
        $result = (new \yii\db\Query())
            ->select(['id', 'label'])
            ->from('floor')
            ->all();
        return json_encode($result);
    }
    public function actionTakecare($id, $username)
    {
        $userId = self::getUserIdByUsername($username);
        if($userId == -1) return 'failed';
        $now = date_format(date_create(date('Y-m-d H:i:s')), 'Y-m-d H:i:s');
        Yii::$app->db->createCommand()
            ->insert('user_notification', ['user_id' => $userId, 'notification_id' =>$id, 'created_at' => $now])->execute();
        self::actionUpdatealert($id);
        return 'success';
    }
    public function actionUpdatealert($id)
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
    public function actionAlerts($id = 'all')
    {
        $result = Yii::$app->db
            ->createCommand('select notification.id, notification.resident_id, firstname, lastname, last_position, user_id, COUNT(user_id) as `ok`
                            from notification
                            left join user_notification
                            on notification.id = user_notification.notification_id
                            join resident
                            on notification.resident_id = resident.id
                            and (\''.$id.'\' = \'all\' or notification.id = \''.$id.'\')
                            group by notification.id')
            ->queryAll();
        return json_encode($result);
    }
    public function actionAlert($resident_id, $last_position = '', $ok = '0', $id = '-1', $user_id = '')
    {
        $query = (new \yii\db\Query())
            ->select(['firstname', 'lastname'])
            ->from('resident')
            ->where(['id' => $resident_id])
            ->all();
        if(count($query) == 0)
            return;
        $firstname = $query[0]['firstname'];
        $lastname = $query[0]['lastname'];
        if($id == '-1')
        {
            $now = date_format(date_create(date('Y-m-d H:i:s')), 'Y-m-d H:i:s');
            Yii::$app->db->createCommand()->insert('notification', ['resident_id' => $resident_id, 'last_position' => $last_position ,'created_at' => $now])->execute();
            $id = Yii::$app->db->lastInsertID;
        }
        $data = array( 'message' => ['id' => $id, 'resident_id' => $resident_id, 'firstname' => $firstname, 'lastname' => $lastname, 'last_position' => $last_position, 'ok' => $ok, 'user_id' => $user_id]);

        $notification = array( 'title' => 'Urgent', 'body' => 'Patients are in danger!');
        $ids = array();
        $result = (new \yii\db\Query())
            ->select('gcm_token')
            ->from('usertoken')
            ->where('ip_address = \'f8:32:e4:5f:73:f5\'')
            ->all();
        for($i = 0; $i < count($result); $i++)
        {
            array_push($ids, $result[$i]['gcm_token']);
        }

        self::sendGoogleCloudMessage( $ids, $notification, $data);
    }
    public function sendGoogleCloudMessage( $ids, $notification, $data)
    {
        // Insert real GCM API key from Google APIs Console
        // https://code.google.com/apis/console/
        $apiKey = 'AIzaSyCi3IcCKBV6t8bO_JJUVWWpvAv86gyeWfI';

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
    public function actionGetusername($id)
    {
        $result = (new \yii\db\Query())
            ->select('username')
            ->from('user')
            ->where(['id' => $id])
            ->all();
        if(count($result) == 0)
            return '404';
        return $result[0]['username'];
    }
    public function actionReceive($MAC, $gcm_token)
    {
        Yii::$app->db->createCommand()->update('usertoken', ['gcm_token' => $gcm_token], 'ip_address = \''.$MAC.'\'')->execute();
    }
    public function getUserIdByUsername($username)
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
    public function getUserId($username, $password)
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
    public function getUserTokenId($userId, $MAC)
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
    public function getToken($userId)
    {
        $result = (new \yii\db\Query())
            ->select('token')
            ->limit(1)
            ->from('usertoken')
            ->where('user_id = '.$userId)
            ->all();
        return $result[0]['token'];
    }
}