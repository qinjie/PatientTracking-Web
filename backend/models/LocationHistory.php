<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "location_history".
 *
 * @property integer $id
 * @property integer $resident_id
 * @property string $tagid
 * @property integer $floor_id
 * @property double $coorx
 * @property double $coory
 * @property string $zone
 * @property string $created_at
 */
class LocationHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location_history';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                // Modify only created not updated attribute
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
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
            [['coorx', 'coory'], 'number'],
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
            'tagid' => 'Tagid',
            'coorx' => 'Coorx',
            'coory' => 'Coory',
            'zone' => 'Zone',
            'created_at' => 'Created At',
        ];
    }
}
