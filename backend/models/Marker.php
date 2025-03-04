<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "marker".
 *
 * @property integer $id
 * @property string $label
 * @property string $mac
 * @property integer $floor_id
 * @property integer $position
 * @property integer $pixelx
 * @property integer $pixely
 * @property double $coorx
 * @property double $coory
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Floor $floor
 */
class Marker extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */

    public static function tableName()
    {
        return 'marker';
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
            [['floor_id', 'position', 'pixelx', 'pixely'], 'integer'],
            [['position', 'pixelx', 'pixely', 'coorx', 'coory'], 'required'],
            [['coorx', 'coory'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['label'], 'string', 'max' => 50],
            [['mac'], 'string', 'max' => 20],
            [['floor_id'], 'exist', 'skipOnError' => true, 'targetClass' => Floor::className(), 'targetAttribute' => ['floor_id' => 'id']],
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
            'mac' => 'Mac',
            'floor_id' => 'Floor ID',
            'position' => 'Position',
            'pixelx' => 'Pixelx',
            'pixely' => 'Pixely',
            'coorx' => 'Coorx',
            'coory' => 'Coory',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloor()
    {
        return $this->hasOne(Floor::className(), ['id' => 'floor_id']);
    }
}
