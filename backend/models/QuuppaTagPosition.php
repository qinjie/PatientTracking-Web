<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "quuppa_tag_position".
 *
 * @property integer $Id
 * @property string $tagId
 * @property string $name
 * @property string $color
 * @property string $positionTS
 * @property string $position
 * @property string $smoothedPosition
 * @property string $positionAccuracy
 * @property string $areaId
 * @property string $areaName
 * @property string $zones
 * @property string $coordinateSystemId
 * @property string $coordinateSystemName
 * @property string $covarianceMatrix
 * @property string $positionX
 * @property string $positionY
 * @property string $positionZ
 * @property string $smoothedPositionX
 * @property string $smoothedPositionY
 * @property string $smoothedPositionZ
 * @property string $created_at
 */
class QuuppaTagPosition extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quuppa_tag_position';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['positionTS'], 'integer'],
            [['positionAccuracy', 'positionX', 'positionY', 'positionZ', 'smoothedPositionX', 'smoothedPositionY', 'smoothedPositionZ'], 'number'],
            [['created_at'], 'safe'],
            [['tagId', 'areaId', 'coordinateSystemId'], 'string', 'max' => 25],
            [['name', 'position', 'smoothedPosition', 'areaName', 'coordinateSystemName', 'covarianceMatrix'], 'string', 'max' => 50],
            [['color'], 'string', 'max' => 10],
            [['zones'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'tagId' => 'Tag ID',
            'name' => 'Name',
            'color' => 'Color',
            'positionTS' => 'Position Ts',
            'position' => 'Position',
            'smoothedPosition' => 'Smoothed Position',
            'positionAccuracy' => 'Position Accuracy',
            'areaId' => 'Area ID',
            'areaName' => 'Area Name',
            'zones' => 'Zones',
            'coordinateSystemId' => 'Coordinate System ID',
            'coordinateSystemName' => 'Coordinate System Name',
            'covarianceMatrix' => 'Covariance Matrix',
            'positionX' => 'Position X',
            'positionY' => 'Position Y',
            'positionZ' => 'Position Z',
            'smoothedPositionX' => 'Smoothed Position X',
            'smoothedPositionY' => 'Smoothed Position Y',
            'smoothedPositionZ' => 'Smoothed Position Z',
            'created_at' => 'Created At',
        ];
    }
}
