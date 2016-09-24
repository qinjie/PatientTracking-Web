<?php

namespace common\models;

use backend\models\Floor;
use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property integer $id
 * @property integer $resident_id
 * @property integer $last_position
 * @property string $created_at
 * @property string $updated_at
 * @property integer $user_id
 * @property integer $type
 *
 * @property Floor $lastPosition
 * @property Resident $resident
 * @property User $user
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['resident_id'], 'required'],
            [['resident_id', 'last_position', 'user_id', 'type'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['last_position'], 'exist', 'skipOnError' => true, 'targetClass' => Floor::className(), 'targetAttribute' => ['last_position' => 'id']],
            [['resident_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resident::className(), 'targetAttribute' => ['resident_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'last_position' => 'Last Position',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'user_id' => 'User ID',
            'type' => 'Type',
        ];
    }

    public function getResidentName(){
        if ($this->resident_id == NULL) return "";
        $query = Resident::find()->where(['id' => $this->resident_id])->one();
        return $query['firstname']." ".$query['lastname'];
    }

    public function getResidentGender(){
        if ($this->resident_id == NULL) return "";
        $query = Resident::find()->where(['id' => $this->resident_id])->one();
        return $query['gender'];
    }

    public function getResidentBirthday(){
        if ($this->resident_id == NULL) return "";
        $query = Resident::find()->where(['id' => $this->resident_id])->one();
        return $query['birthday'];
    }

    public function getFloorName(){
        if ($this->last_position == NULL) return "";
        $query = Floor::find()->where(['id' => $this->last_position])->one();
        return $query['label'];
    }

    public function getAlertType(){
        if ($this->type == 1){
            return "Alert Area";
        }else{
            if ($this->type == 2){
                return "Button pressed";
            }else{
                return "No signal";
            }
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFloor()
    {
        return $this->hasOne(Floor::className(), ['id' => 'last_position']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResident()
    {
        return $this->hasOne(Resident::className(), ['id' => 'resident_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getLocation(){
        return $this->hasOne(Location::className(), ['resident_id' => 'resident_id']);
    }
}
