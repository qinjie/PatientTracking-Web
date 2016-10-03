<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 28/3/15
 * Time: 23:28
 */

namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use api\common\models\Location;
use api\common\models\Notification;
use api\common\models\Resident;
use api\common\models\User;
use backend\models\Marker;
use common\components\AccessRule;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use Yii;

class LocationController extends CustomActiveController
{
    public $modelClass = 'api\common\models\Location';

    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::className(),
            'except' => [],
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

    public function actionPosition($floor_id){
        $topPixel = Marker::find()->where(['floor_id' => $floor_id])->min('pixely');
        $botPixel = Marker::find()->where(['floor_id' => $floor_id])->max('pixely');
        $rightPixel = Marker::find()->where(['floor_id' => $floor_id])->max('pixelx');
        $leftPixel = Marker::find()->where(['floor_id' => $floor_id])->min('pixelx');
        $topCoor = Marker::find()->where(['floor_id' => $floor_id])->max('coory');
        $botCoor = Marker::find()->where(['floor_id' => $floor_id])->min('coory');
        $rightCoor = Marker::find()->where(['floor_id' => $floor_id])->max('coorx');
        $leftCoor = Marker::find()->where(['floor_id' => $floor_id])->min('coorx');
        $query = (new \yii\db\Query())
            ->select('*')
            ->from('location')
            ->where(['floor_id' => $floor_id])
            ->all();
        for ($i = 0; $i < count($query); $i++) {
            if ($query[$i]['resident_id']){
                $query[$i]['resident'] = $this->ResidentDetail($query[$i]['resident_id']);
                $query[$i]['color'] = $this->ResidentColor($query[$i]['resident_id']);
                $query[$i]['signal'] = $this->ResidentSignal($query[$i]['resident_id']);
            }
            if ($query[$i]['user_id']){
                $query[$i]['user'] = $this->UserDetail($query[$i]['user_id']);
                //Color: Green
                $query[$i]['color'] = "009688";
            }
            $query[$i]['pixelx'] = $leftPixel + intval(round(1.0 * ($query[$i]['coorx'] - $leftCoor) * ($rightPixel - $leftPixel) / ($rightCoor - $leftCoor)));
            $query[$i]['pixely'] = $topPixel + intval(round(1.0 * ($query[$i]['coory'] - $topCoor) * ($topPixel - $botPixel) / ($topCoor - $botCoor)));
        }
        return $query;
    }

    private function UserDetail($id){
        return User::find()->where(['id' => $id])->one();
    }

    private function ResidentDetail($id){
        return Resident::find()->where(['id' => $id])->one();
    }

    private function ResidentColor($id){
        if (Notification::find()->where(['resident_id' => $id, 'user_id' => null])->one()){
            //Color: Red
            return "#F44336";
        }
        //Color: Blue
        return "#2196F3";
    }

    private function ResidentSignal($id){
        if (Location::find()->where(['resident_id' => $id])->andWhere('created_at < DATE_SUB(NOW(), INTERVAL '.Yii::$app->params['locationTimeOut'].' second)')->one()){
            return false;
        }
        return true;
    }
}