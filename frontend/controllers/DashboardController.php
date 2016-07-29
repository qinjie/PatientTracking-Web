<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 13/4/16
 * Time: 4:15 PM
 */

namespace frontend\controllers;
use backend\models\User;
use backend\models\UserSearch;
use common\models\LocationSearch;
use Yii;
use common\models\CommonFunction;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DashboardController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $floorList = (new CommonFunction())->getAllFloor();
        return $this->render('index',
            [
                'floorList' => $floorList,
            ]);
    }

    public function actionFloordetail($id){
        $searchModel = new LocationSearch();
        $dataProvider = $searchModel->searchFloor(Yii::$app->request->queryParams, $id);
        $searchModelUser = new LocationSearch();
        $dataProviderUser = $searchModelUser->searchUserFloor(Yii::$app->request->queryParams, $id);
        $floorName = (new CommonFunction())->getFloorName($id);
        return $this->render('floorDetail',
            [
                'id' => $id,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'searchModelUser' => $searchModelUser,
                'dataProviderUser' => $dataProviderUser,
                'floorName' => $floorName,
            ]);
    }

    public function actionAlertdetail(){
        $searchModel = new LocationSearch();
        $dataProvider = $searchModel->searchAlert(Yii::$app->request->queryParams);
        return $this->render('alertDetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionViewuser($id)
    {
        return $this->render('viewUser', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUsermodal($id)
    {
        return $this->renderAjax('userModal', [
            'model' => $this->findModel($id),
        ]);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}