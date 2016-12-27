<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 28/3/15
 * Time: 23:28
 */

namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use backend\models\AlertArea;
use backend\models\Floor;
use backend\models\Tag;
use common\components\AccessRule;
use common\models\Location;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use Yii;

class ResidentLocationController extends CustomActiveController
{
    public $modelClass = 'api\common\models\ResidentLocation';

    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => ['create'],
        ];

        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'ruleConfig' => [
                'class' => AccessRule::className(),
            ],
            'rules' => [
                [
                    'actions' => [],
                    'allow' => true,
                    'roles' => ['?'],
                ],
                [
                    'actions' => ['position'],
                    'allow' => true,
                    'roles' => ['@'],
                ]
            ],
            'denyCallback' => function ($rule, $action) {
                throw new UnauthorizedHttpException('You are not authorized');
            },
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::className(),
            'actions' => [
            ],
        ];

        return $behaviors;
    }

    public function afterAction($action, $result)
    {
        if ($action->id == 'create'){
            $now = date_format(date_create(date('Y-m-d H:i:s')), 'Y-m-d H:i:s');
            if ($action->id == 'create'){
                $q_resident_id = Tag::find()->where(['tagid' => $result['tagid']])->one();
                if ($q_resident_id){
                    $resident_id = $q_resident_id['resident_id'];
                }
                $q_user_id = Tag::find()->where(['tagid' => $result['tagid']])->one();
                if ($q_user_id){
                    $user_id = $q_user_id['user_id'];
                }
                $token = strtok($result['zone'], ",");
                $zones = [];
                while ($token !== false)
                {
                    $zones[] = $token;
                    $token = strtok(" ");
                }
                var_dump($zones); die();
                foreach ($zones as $zone){
                    //if the zone is belong to a floor
                    if ($temp = Floor::find()->where(['quuppa_id' => $zone])->one()){
                        $speed = 0;
                        $azimuth = 0;
                        $outside = 0;
                        //if the tag belong to an created user
                        if ($user_id && Location::find()->where(['user_id' => $user_id])->one()){
                            $result = Yii::$app->db->createCommand()
                                ->update('location', ['resident_id' => $resident_id, 'user_id' => $user_id,
                                    'floor_id' => $temp['id'], 'coorx' => $result['coorx'], 'coory' => $result['coory'],
                                    'zone' => $zone, 'outside' => $outside, 'speed' => $speed, 'azimuth' => $azimuth, 'created_at' => $now],
                                    ['user_id' => $user_id]
                                )->execute();
                        }
                        else{
                            //if the tag belong the a created resident
                            if ($resident_id && Location::find()->where(['resident_id' => $resident_id])->one()){
                                $result = Yii::$app->db->createCommand()
                                    ->update('location', ['resident_id' => $resident_id, 'user_id' => $user_id,
                                        'floor_id' => $temp['id'], 'coorx' => $result['coorx'], 'coory' => $result['coory'],
                                        'zone' => $zone, 'outside' => $outside, 'speed' => $speed, 'azimuth' => $azimuth, 'created_at' => $now],
                                        ['resident_id' => $resident_id]
                                    )->execute();
                            }else{
                                //if the tag is not exists
                                $result = Yii::$app->db->createCommand()
                                    ->insert('location', ['resident_id' => $resident_id, 'user_id' => $user_id,
                                            'floor_id' => $temp['id'], 'coorx' => $result['coorx'], 'coory' => $result['coory'],
                                            'zone' => $zone, 'outside' => $outside, 'speed' => $speed, 'azimuth' => $azimuth, 'created_at' => $now]
                                    )->execute();
                            }
                        }
                    }
                    else{
                        //if the zone is belong to an alert area
                        if ($temp = AlertArea::find()->where(['quuppa_id' => $zone])->one()){
                            $speed = 0;
                            $azimuth = 0;
                            $outside = 1;
                            //if the tag belong to an created user
                            if ($user_id && Location::find()->where(['user_id' => $user_id])->one()){
                                $result = Yii::$app->db->createCommand()
                                    ->update('location', ['resident_id' => $resident_id, 'user_id' => $user_id,
                                        'floor_id' => $temp['floor_id'], 'coorx' => $result['coorx'], 'coory' => $result['coory'],
                                        'zone' => $zone, 'outside' => $outside, 'speed' => $speed, 'azimuth' => $azimuth, 'created_at' => $now],
                                        ['user_id' => $user_id]
                                    )->execute();
                            }
                            else{
                                //if the tag belong the a created resident
                                if ($resident_id && Location::find()->where(['resident_id' => $resident_id])->one()){
                                    $result = Yii::$app->db->createCommand()
                                        ->update('location', ['resident_id' => $resident_id, 'user_id' => $user_id,
                                            'floor_id' => $temp['floor_id'], 'coorx' => $result['coorx'], 'coory' => $result['coory'],
                                            'zone' => $zone, 'outside' => $outside, 'speed' => $speed, 'azimuth' => $azimuth, 'created_at' => $now],
                                            ['resident_id' => $resident_id]
                                        )->execute();
                                    return $this->redirect(Yii::$app->homeUrl.'user/alert?resident_id='.$resident_id.'&last_position='.$temp['floor_id'].'&type=1');
                                }else{
                                    //if the tag is not exists
                                    $result = Yii::$app->db->createCommand()
                                        ->insert('location', ['resident_id' => $resident_id, 'user_id' => $user_id,
                                                'floor_id' => $temp['floor_id'], 'coorx' => $result['coorx'], 'coory' => $result['coory'],
                                                'zone' => $zone, 'outside' => $outside, 'speed' => $speed, 'azimuth' => $azimuth, 'created_at' => $now]
                                        )->execute();
                                }
                            }
                        }
                    }
                }
            }
            return "Created";
        }
        else{
            return $result;
        }
    }
}