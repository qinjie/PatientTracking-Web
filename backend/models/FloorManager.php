<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "floor_manager".
 *
 * @property integer $id
 * @property integer $userid
 * @property integer $floorid
 * @property string $created_at
 *
 * @property User $user
 * @property Floor $floor
 */
class FloorManager extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'floor_manager';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userid', 'floorid'], 'required'],
            [['userid', 'floorid'], 'integer'],
            [['created_at'], 'safe'],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userid' => 'id']],
            [['floorid'], 'exist', 'skipOnError' => true, 'targetClass' => Floor::className(), 'targetAttribute' => ['floorid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userid' => 'Userid',
            'floorid' => 'Floorid',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloor()
    {
        return $this->hasOne(Floor::className(), ['id' => 'floorid']);
    }
}
