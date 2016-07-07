<?php

namespace backend\controllers;

use Yii;
use common\models\ResidentRelative;
use common\models\ResidentRelativeSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Resident;
use common\models\Nextofkin;

/**
 * ResidentRelativeController implements the CRUD actions for ResidentRelative model.
 */
class ResidentRelativeController extends Controller
{
    /**
     * @inheritdoc
     */
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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ResidentRelative models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResidentRelativeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ResidentRelative model.
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
     * Creates a new ResidentRelative model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ResidentRelative();
        $items1 = ArrayHelper::map(Resident::find()->orderBy('firstname', 'lastname')->all(), 'id', 'fullName');
        $items2 = ArrayHelper::map(Nextofkin::find()->orderBy('first_name', 'last_name')->all(), 'id', 'full_Name');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'items1' => $items1,
                'items2' => $items2,
            ]);
        }
    }

    /**
     * Updates an existing ResidentRelative model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $items1 = ArrayHelper::map(Resident::find()->orderBy('firstname', 'lastname')->all(), 'id', 'fullName');
        $items2 = ArrayHelper::map(Nextofkin::find()->orderBy('first_name', 'last_name')->all(), 'id', 'full_Name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'items1' => $items1,
                'items2' => $items2,
            ]);
        }
    }

    /**
     * Deletes an existing ResidentRelative model.
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
     * Finds the ResidentRelative model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ResidentRelative the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ResidentRelative::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
