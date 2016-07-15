<?php

namespace backend\controllers;

use common\components\AccessRule;
use common\models\CommonFunction;
use common\models\User;
use Yii;
use backend\models\FloorMap;
use backend\models\FloorMapSearch;
use yii\filters\AccessControl;
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
            $model->file_name = $model->floor_id;
            $model->file->saveAs('uploads/'.$model->file_name.'.'.$model->file->extension);
            $model->file_type = 'image/'.$model->file->extension;
            $model->file_ext = $model->file->extension;
            $model->file_path = 'uploads/'.$model->file_name.'.'.$model->file->extension;
            $this->makeThumbnails($model->file_name.'.'.$model->file_ext);
            $model->thumbnail_path = 'uploads/thumbnail_'.$model->file_name.'.'.$model->file->extension;
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
            $model->file_name = $model->floor_id;
            $model->file->saveAs('uploads/'.$model->file_name.'.'.$model->file->extension);
            $model->file_type = 'image/'.$model->file->extension;
            $model->file_ext = $model->file->extension;
            $model->file_path = 'uploads/'.$model->file_name.'.'.$model->file->extension;
            $this->makeThumbnails($model->file_name.'.'.$model->file_ext);
            $model->thumbnail_path = 'uploads/thumbnail_'.$model->file_name.'.'.$model->file->extension;
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
        (new CommonFunction())->deleteFloorMap($id);
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

    private function makeThumbnails($imgName)
    {
        $uploadsPath = "uploads/";
        $imgPath = $uploadsPath.$imgName;
        $thumb_before_word = "thumbnail_";
        $arr_image_details = getimagesize($imgPath);
        $original_width = $arr_image_details[0];
        $original_height = $arr_image_details[1];
        if ($original_width > 2*$original_height) {
            $thumbnail_width = 200;
            $thumbnail_height = intval($original_height*200/$original_width);
        } else {
            $thumbnail_height = 100;
            $thumbnail_width = intval($original_width*100/$original_height);
        }
        if ($arr_image_details[2] == 1) {
            $imgt = "imagegif";
            $imgcreatefrom = "imagecreatefromgif";
        }
        if ($arr_image_details[2] == 2) {
            $imgt = "imagejpeg";
            $imgcreatefrom = "imagecreatefromjpeg";
        }
        if ($arr_image_details[2] == 3) {
            $imgt = "imagepng";
            $imgcreatefrom = "imagecreatefrompng";
        }
        if ($imgt) {
            $old_image = $imgcreatefrom($imgPath);
            $new_image = imagecreatetruecolor($thumbnail_width, $thumbnail_height);
            imagealphablending( $new_image, false );
            imagesavealpha( $new_image, true );
            imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $thumbnail_width, $thumbnail_height, $original_width, $original_height);
            $imgt($new_image, $uploadsPath.$thumb_before_word.$imgName);
        }
    }
}
