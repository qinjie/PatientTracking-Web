<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "marker".
 *
 * @property integer $id
 * @property string $label
 * @property string $mac
 * @property integer $floor_id
 * @property integer $position
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['floor_id', 'position'], 'integer'],
            [['position', 'coorx', 'coory'], 'required'],
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
