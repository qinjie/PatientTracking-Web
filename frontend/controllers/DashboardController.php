<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 13/4/16
 * Time: 4:15 PM
 */

namespace frontend\controllers;
use backend\models\ResidentSearch;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

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
                        'actions' => ['logout'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionFloordetail($id){
        $searchModel = new ResidentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        return $this->render('floorDetail',
            [
                'id' => $id,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }

    public function actionResidentdetail($id, $fid){
        return $this->render('residentDetail', ['id' => $id, 'fid' => $fid]);
    }

    public function actionNextofkindetail($id, $fid, $rid){
        return $this->render('nextofkinDetail', ['id' => $id, 'fid' => $fid, 'rid' => $rid]);
    }
}