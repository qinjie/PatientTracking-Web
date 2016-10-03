<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 28/3/15
 * Time: 23:28
 */

namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use common\components\AccessRule;
use common\models\Notification;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use Yii;

class NotificationController extends CustomActiveController
{
    public $modelClass = 'api\common\models\Notification';

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
                    'actions' => [],
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

    public function actionAlert($expand = null){
        $query = Notification::find()->andWhere('user_id IS NULL');
        if ($expand){
            $expandList = explode(',', $expand);
            $query->with($expandList);
        }
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    public function actionCount(){
        return Notification::find()->andWhere('user_id IS NULL')->count();
    }
}