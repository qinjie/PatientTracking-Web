<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "resident_location_history".
 *
 * @property integer $id
 * @property integer $resident_id
 * @property string $tagid
 * @property integer $floor_id
 * @property double $coorx
 * @property double $coory
 * @property string $zone
 * @property integer $outside
 * @property double $azimuth
 * @property double $speed
 * @property string $created_at
 */
class ResidentLocationHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resident_location_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['resident_id', 'floor_id', 'outside'], 'integer'],
            [['coorx', 'coory', 'azimuth', 'speed'], 'number'],
            [['created_at'], 'safe'],
            [['tagid'], 'string', 'max' => 20],
            [['zone'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resident_id' => 'Resident ID',
            'tagid' => 'Tagid',
            'floor_id' => 'Floor ID',
            'coorx' => 'Coorx',
            'coory' => 'Coory',
            'zone' => 'Zone',
            'outside' => 'Outside',
            'azimuth' => 'Azimuth',
            'speed' => 'Speed',
            'created_at' => 'Created At',
        ];
    }
}
