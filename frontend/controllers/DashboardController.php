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
use backend\models\CommonFunction;
use yii\web\Controller;

class DashboardController extends Controller
{

    public function actionIndex()
    {
        $floorList = (new CommonFunction())->getAllFloor();
        return $this->render('index',
            [
                'floorList' => $floorList,
            ]);
    }

    public function actionFloordetail($id){
        $searchModel = new ResidentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        $floorName = (new CommonFunction())->getFloorName($id);
        return $this->render('floorDetail',
            [
                'id' => $id,
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'floorName' => $floorName,
            ]);
    }

    public function actionResidentdetail($id, $fid=null){
        $model = (new CommonFunction())->getResidentModel($id);
        if ($fid != null){
            $floorName = (new CommonFunction())->getFloorName($fid);
        }
        else{
            $floorName = null;
        }
        return $this->render('residentDetail', [
            'id' => $id,
            'fid' => $fid,
            'model' => $model,
            'floorName' => $floorName,
        ]);
    }

    public function actionAlertdetail(){
        $searchModel = new ResidentSearch();
        $dataProvider = $searchModel->searchAlert(Yii::$app->request->queryParams);
        return $this->render('alertDetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNextofkindetail($id, $fid, $rid){
        $nextofkinName = (new CommonFunction())->getNextofkinName($id);
        $floorName = (new CommonFunction())->getFloorName($fid);
        $residentName = (new CommonFunction())->getResidentName($rid);
        $model = (new CommonFunction())->getNextofkinModel($id);
        return $this->render('nextofkinDetail',
            [
                'id' => $id,
                'fid' => $fid,
                'rid' => $rid,
                'nextofkinName' => $nextofkinName,
                'floorName' => $floorName,
                'residentName' => $residentName,
                'model' => $model,
            ]);
    }
}