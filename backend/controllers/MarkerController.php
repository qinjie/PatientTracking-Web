<?php

namespace backend\controllers;

use backend\models\AlertAreaSearch;
use common\components\AccessRule;
use common\models\CommonFunction;
use common\models\User;
use Yii;
use backend\models\Marker;
use backend\models\MarkerSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MarkerController implements the CRUD actions for Marker model.
 */
class MarkerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [User::ROLE_MANAGER, User::ROLE_ADMIN, User::ROLE_MASTER],
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Marker models.
     * @return mixed
     */
    public function actionIndex()
    {
        $floorList = (new CommonFunction())->getAllFloor();
        return $this->render('index', [
            'floorList' => $floorList,
        ]);
    }

    /**
     * Displays a single Marker model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionFloordetail($id){
        $searchModel = new MarkerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $id);
        $searchModelAlert = new AlertAreaSearch();
        $dataProviderAlert = $searchModelAlert->search(Yii::$app->request->queryParams, $id);
        $floorName = (new CommonFunction())->getFloorName($id);
        $query = Marker::find()->where(['floor_id' => $id])->orderBy('position DESC')->one();
        if ($query == null){
            $nextPosition = 1;
        }
        else{
            $nextPosition = (int) $query['position'] + 1;
        }
        if ($query == null){
            $nextPositionAlert = 1;
        }
        else{
            $nextPositionAlert = (int) $query['position'] + 1;
        }
        return $this->render('floorDetail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'searchModelAlert' => $searchModelAlert,
            'dataProviderAlert' => $dataProviderAlert,
            'floorName' => $floorName,
            'floorId' => $id,
            'nextPosition' => $nextPosition,
            'nextPositionAlert' => $nextPositionAlert,
        ]);
    }

    /**
     * Creates a new Marker model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($x = null, $y = null, $p = null, $f = null)
    {
        $model = new Marker();
        if($x != null){
            $model->pixelx = $x;
        }
        if ($y != null){
            $model->pixely = $y;
        }
        if($p != null){
            $model->position = $p;
        }
        if($f != null){
            $model->floor_id = $f;
        }
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()){
                echo "Success";
            }else{
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Marker model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()){
                return "Success";
            }
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Marker model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $q = Marker::find()->where(['id' => $id])->one();
        $this->findModel($id)->delete();
        if (Yii::$app->getRequest()->isPjax) {
            $searchModel = new MarkerSearch();
            $searchModelAlert = new AlertAreaSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $q['floor_id']);
            $dataProviderAlert = $searchModelAlert->search(Yii::$app->request->queryParams);
            $query = Marker::find()->where(['floor_id' => $q['floor_id']])->orderBy('position DESC')->one();
            if ($query == null){
                $nextPosition = 1;
            }
            else{
                $nextPosition = (int) $query['position'] + 1;
            }
            if ($query == null){
                $nextPositionAlert = 1;
            }
            else{
                $nextPositionAlert = (int) $query['position'] + 1;
            }
            return $this->renderAjax('floorDetail', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'searchModelAlert' => $searchModelAlert,
                'dataProviderAlert' => $dataProviderAlert,
                'nextPosition' => $nextPosition,
                'nextPositionAlert' => $nextPositionAlert,
                'floorId' => $q['floor_id'],
                'floorName' => $q['label'],
            ]);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Marker model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Marker the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Marker::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
