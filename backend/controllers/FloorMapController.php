<?php

namespace backend\controllers;

use Yii;
use backend\models\FloorMap;
use backend\models\FloorMapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\Floor;
use yii\web\UploadedFile;

/**
 * FloorMapController implements the CRUD actions for FloorMap model.
 */
class FloorMapController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all FloorMap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FloorMapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FloorMap model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FloorMap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FloorMap();
        $items1 = ArrayHelper::map(Floor::find()->all(), 'id', 'label');

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->thumbnail = UploadedFile::getInstance($model, 'thumbnail');
            $model->file_name = $model->floor_id;
            $model->file->saveAs('uploads/'.$model->file_name.'.'.$model->file->extension);
            $model->thumbnail->saveAs('uploads/thumbnail_'.$model->file_name.'.'.$model->thumbnail->extension);
            $model->file_type = 'image/'.$model->file->extension;
            $model->file_ext = $model->file->extension;
            $model->file_path = 'uploads/'.$model->file_name.'.'.$model->file->extension;
            $model->thumbnail_path = 'uploads/thumbnail_'.$model->file_name.'.'.$model->thumbnail->extension;
            $model->created_at = date('Y-m-d H:i:s');
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                return $this->render('create', [
                    'model' => $model,
                    'items1' => $items1,
                ]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'items1' => $items1,
            ]);
        }
    }

    /**
     * Updates an existing FloorMap model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $items1 = ArrayHelper::map(Floor::find()->all(), 'id', 'label');

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->thumbnail = UploadedFile::getInstance($model, 'thumbnail');
            $model->file_name = $model->floor_id;
            $model->file->saveAs('uploads/'.$model->file_name.'.'.$model->file->extension);
            $model->thumbnail->saveAs('uploads/thumbnail_'.$model->file_name.'.'.$model->thumbnail->extension);
            $model->file_type = 'image/'.$model->file->extension;
            $model->file_ext = $model->file->extension;
            $model->file_path = 'uploads/'.$model->file_name.'.'.$model->file->extension;
            $model->thumbnail_path = 'uploads/thumbnail_'.$model->file_name.'.'.$model->thumbnail->extension;
            $model->created_at = date('Y-m-d h:m:s');
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
            else{
                return $this->render('update', [
                    'model' => $model,
                    'items1' => $items1,
                ]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'items1' => $items1,
            ]);
        }
    }

    /**
     * Deletes an existing FloorMap model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FloorMap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FloorMap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FloorMap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
