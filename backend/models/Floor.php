<?php

namespace backend\models;

use common\models\Location;
use Yii;

/**
 * This is the model class for table "floor".
 *
 * @property integer $id
 * @property string $quuppa_id
 * @property string $label
 * @property string $description
 * @property double $width
 * @property double $height
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AlertArea[] $alertAreas
 * @property FloorManager[] $floorManagers
 * @property FloorMap $floorMap
 * @property Location[] $locations
 * @property Marker[] $markers
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
            [['quuppa_id'], 'string', 'max' => 20],
            [['label'], 'string', 'max' => 50],
            [['description'], 'string', 'max' => 500],
            [['label'], 'unique'],
            [['quuppa_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quuppa_id' => 'Quuppa ID',
            'label' => 'Name',
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
    public function getAlertAreas()
    {
        return $this->hasMany(AlertArea::className(), ['floor_id' => 'id']);
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
    public function getFloorMap()
    {
        return $this->hasOne(FloorMap::className(), ['floor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocations()
    {
        return $this->hasMany(Location::className(), ['floor_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMarkers()
    {
        return $this->hasMany(Marker::className(), ['floor_id' => 'id']);
    }
}
