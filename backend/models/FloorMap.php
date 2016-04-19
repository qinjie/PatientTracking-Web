<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "floor_map".
 *
 * @property integer $id
 * @property integer $floor_id
 * @property string $file_type
 * @property string $file_name
 * @property string $file_ext
 * @property string $file_path
 * @property string $thumbnail_path
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Floor $floor
 */
class FloorMap extends \yii\db\ActiveRecord
{
    public $file;
    public $thumbnail;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'floor_map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['floor_id'], 'required'],
            [['floor_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['file_type', 'file_ext'], 'string', 'max' => 10],
            [['file_name'], 'string', 'max' => 30],
            [['file_path', 'thumbnail_path'], 'string', 'max' => 100],
            [['file'], 'file'],
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
            'floor_id' => 'Floor ID',
            'file_type' => 'File Type',
            'file_name' => 'File Name',
            'file_ext' => 'File Ext',
            'file_path' => 'File Path',
            'thumbnail_path' => 'Thumbnail Path',
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
