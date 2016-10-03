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

class QuuppaButtonController extends CustomActiveController
{
    public $modelClass = 'api\common\models\Button';

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
            $query = Tag::find()->where(['tagid' => $result['tagid']])->one();
            $location = Location::find()->where(['resident_id' => $query['resident_id']])->one();
            if ($location){
                return $this->redirect(Yii::$app->homeUrl.'user/alert?resident_id='.$location['resident_id'].'&last_position='.$location['floor_id'].'&type=2');
            }
        }
        else{
            return $result;
        }
    }
}