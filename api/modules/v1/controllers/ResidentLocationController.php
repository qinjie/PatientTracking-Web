<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 29/3/15
 * Time: 17:58
 */

namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use backend\models\AlertArea;
use backend\models\Floor;
use backend\models\Tag;
use common\models\Location;
use common\models\ResidentLocation;
use Faker\Provider\DateTime;
use Yii;

class ResidentLocationController extends CustomActiveController
{
    public $modelClass = 'api\common\models\ResidentLocation';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator']['except'] = ['view', 'search', 'index', 'create'];
        $behaviors['access']['rules'] = [
            [   // No authentication required
                'actions' => ['view', 'search', 'index', 'create'],
                'allow' => true,
                'roles' => ['?', '@'],
            ],
            [ # all other actions are matched by RBAC rules
                'allow' => true,
                'roles' => ['@'],
                'matchCallback' => function ($rule, $action) {
                    $module = Yii::$app->controller->module->id;
                    $action = Yii::$app->controller->action->id;
                    $controller = Yii::$app->controller->id;
                    $route = "$module/$controller/$action";
                    $post = Yii::$app->request->post();
                    if (Yii::$app->user->can($route)) {
                        return true;
                    }
                    return false;
                }
            ],
        ];

        return $behaviors;
    }

    public function afterAction($action, $result)
    {
        $now = date_format(date_create(date('Y-m-d H:i:s')), 'Y-m-d H:i:s');
        if ($action->id == 'create'){
            $q_resident_id = Tag::find()->where(['tagid' => $result['tagid']])->one();
            $resident_id = $q_resident_id['resident_id'];
            $q_user_id = Tag::find()->where(['tagid' => $result['tagid']])->one();
            $user_id = $q_user_id['user_id'];
            $token = strtok($result['zone'], ",");
            $zones = [];
            while ($token !== false)
            {
                $zones[] = $token;
                $token = strtok(",");
            }
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
                }
            }
        }
    }

    public function actions()
    {
        $actions = parent::actions();
//        unset($actions['create']);
        unset($actions['delete']);
        unset($actions['update']);
        return $actions;
    }
}