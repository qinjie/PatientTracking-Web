<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "floor".
 *
 * @property integer $id
 * @property string $label
 * @property string $description
 * @property double $width
 * @property double $height
 * @property string $created_at
 * @property string $updated_at
 *
 * @property FloorManager[] $floorManagers
 * @property FloorMap[] $floorMaps
 * @property Marker[] $markers
 * @property ResidentLocation[] $residentLocations
 */
class Floor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'floor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['label', 'width', 'height'], 'required'],
            [['width', 'height'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['label'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'description' => 'Description',
            'width' => 'Width',
            'height' => 'Height',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloorManagers()
    {
        return $this->hasMany(FloorManager::className(), ['floorid' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloorMaps()
    {
        return $this->hasMany(FloorMap::className(), ['floor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarkers()
    {
        return $this->hasMany(Marker::className(), ['floor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResidentLocations()
    {
        return $this->hasMany(ResidentLocation::className(), ['floor_id' => 'id']);
    }

    public function getAllFloor(){
        $query = Floor::find()->all();
        return $query;
    }

    public function getResidentCount($id){
        $query = ResidentLocation::find()->where(['floor_id' => $id])->count();
        return $query;
    }

    public function getFloorName($id){
        $query = Floor::find()->where(['id' => $id])->one();
        return $query['label'];
    }

    public function getResidentInFloor($id){
        $query = ResidentLocation::find()->where(['floor_id' => $id])->all();
        return $query;
    }

    public function getResident($id){
        $query = Resident::find()->where(['id' => $id])->one();
        return $query;
    }

    public function getResidentModelByID($id){
        $query = Resident::findOne(['id' => $id]);
        return $query;
    }

    public function getResidentName($id){
        $query = Resident::find()->where(['id' => $id])->one();
        return $query['firstname']." ".$query['lastname'];
    }

    public function getNextofkinNameList($id, $fid){
        $query = ResidentRelative::find()->where(['resident_id' => $id])->all();
        $str = "";
        foreach ($query as $item){
            $tmp = Nextofkin::find()->where(['id' => $item['nextofkin_id']])->one();
            if ($str == ""){
                $str .= "<a href='nextofkindetail?id=".$tmp['id']."&fid=".$fid."&rid=".$id."'>".$tmp['first_name']." ".$tmp['last_name']."</a>";
            } else{
                $str .= "<br>"."<a href='nextofkindetail?id=".$tmp['id']."&fid=".$fid."&rid=".$id."'>".$tmp['first_name']." ".$tmp['last_name']."</a>";
            }
        }
        return $str;
    }

    public function getNextofkinName($id){
        $query = Nextofkin::find()->where(['id' => $id])->one();
        return $query['first_name']." ".$query['last_name'];
    }

    public function getNextofkinModelByID($id){
        $query = Nextofkin::findOne(['id' => $id]);
        return $query;
    }
}
