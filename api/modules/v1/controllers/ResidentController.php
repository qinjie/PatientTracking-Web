<?php
/**
 * Created by PhpStorm.
 * User: qj
 * Date: 28/3/15
 * Time: 23:28
 */

namespace api\modules\v1\controllers;

use api\common\controllers\CustomActiveController;
use api\common\models\Resident;
use common\components\AccessRule;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\VerbFilter;
use yii\web\UnauthorizedHttpException;
use Yii;

class ResidentController extends CustomActiveController
{
    public $modelClass = 'api\common\models\Resident';

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

    public function actionSort($expand = null, $name, $location, $sort_value, $sort_type){
        if ($sort_value != 'name'){
            $sort_string = $sort_value.' '.$sort_type;
        }else{
            $sort_string = 'firstname '.$sort_type.', lastname '.$sort_type;
        }
        $query = Resident::find()->joinWith('floor')->andWhere('CONCAT(firstname, \' \', lastname) LIKE \'%'.$name.'%\'')->andWhere('\'all\'=\''.$location.'\' or floor_id = \''.$location.'\'')->orderBy($sort_string);
        if ($expand){
            $expandList = explode(',', $expand);
            $query->with($expandList);
        }
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}