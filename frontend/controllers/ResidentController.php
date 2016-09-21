<?php

namespace frontend\controllers;

use backend\models\Floor;
use Yii;
use common\models\Resident;
use common\models\ResidentSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ResidentController implements the CRUD actions for Resident model.
 */
class ResidentController extends Controller
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
     * Lists all Resident models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResidentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $roleArray = [];
        $query = Floor::find()->all();
        foreach ($query as $item){
            $roleArray += [$item['id'] => $item['label']];
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'roleArray' => $roleArray,
        ]);
    }

    /**
     * Displays a single Resident model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
            'id' => $id,
        ]);
    }

    public function actionResidentmodal($id)
    {
        return $this->renderAjax('residentModal', [
            'model' => $this->findModel($id),
            'id' => $id,
        ]);
    }

    /**
     * Finds the Resident model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Resident the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Resident::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
