<?php

namespace backend\controllers;

use common\components\AccessRule;
use common\models\CommonFunction;
use common\models\User;
use Yii;
use common\models\Resident;
use common\models\ResidentSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

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
     * Lists all Resident models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ResidentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
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
        ]);
    }

    /**
     * Creates a new Resident model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Resident();

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file_path = 'uploads/human_images/'.$model->firstname.'_'.$model->lastname.'.'.$model->file->extension;
            $model->thumbnail_path = 'uploads/human_images/thumbnail_'.$model->firstname.'_'.$model->lastname.'.'.$model->file->extension;
            if ($model->save()) {
                $model->file->saveAs('uploads/human_images/'.$model->firstname.'_'.$model->lastname.'.'.$model->file->extension);
                $this->makeThumbnails($model->firstname.'_'.$model->lastname.'.'.$model->file->extension);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Resident model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->file = UploadedFile::getInstance($model, 'file');
            $model->file_path = 'uploads/human_images/'.$model->firstname.'_'.$model->lastname.'.'.$model->file->extension;
            $model->thumbnail_path = 'uploads/human_images/thumbnail_'.$model->firstname.'_'.$model->lastname.'.'.$model->file->extension;
            if ($model->save()) {
                $model->file->saveAs('uploads/human_images/'.$model->firstname.'_'.$model->lastname.'.'.$model->file->extension);
                $this->makeThumbnails($model->firstname.'_'.$model->lastname.'.'.$model->file->extension);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Resident model.
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

    private function makeThumbnails($imgName)
    {
        $uploadsPath = "uploads/human_images/";
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
