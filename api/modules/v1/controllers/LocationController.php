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
use api\common\models\Resident;
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

    public function actionPosition($floor_id, $expand = null){
//        $topPixel = Marker::find()->where(['floor_id' => $floor_id])->max('pixely');
//        $botPixel = Marker::find()->where(['floor_id' => $floor_id])->min('pixely');
//        $rightPixel = Marker::find()->where(['floor_id' => $floor_id])->max('pixelx');
//        $leftPixel = Marker::find()->where(['floor_id' => $floor_id])->min('pixelx');
//        $topCoor = Marker::find()->where(['floor_id' => $floor_id])->max('coory');
//        $botCoor = Marker::find()->where(['floor_id' => $floor_id])->min('coory');
//        $rightCoor = Marker::find()->where(['floor_id' => $floor_id])->max('coorx');
//        $leftCoor = Marker::find()->where(['floor_id' => $floor_id])->min('coorx');
        $query = Location::find()->where(['floor_id' => $floor_id]);
        if ($expand){
            $expandList = explode(',', $expand);
            $query->with($expandList);
        }
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}