<?php
/**
 * Created by PhpStorm.
 * User: intern
 * Date: 18/4/16
 * Time: 11:11 AM
 */

namespace frontend\controllers;

use backend\models\NextofkinSearch;
use Yii;
use yii\web\Controller;
use backend\models\ResidentSearch;

class ResidentController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new ResidentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNextofkin(){
        $searchModel = new NextofkinSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('nextofkin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}