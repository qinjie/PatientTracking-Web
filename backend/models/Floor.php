<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

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

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                // Modify only created not updated attribute
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
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

}
