<?php

namespace common\models;

use backend\models\Floor;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "location".
 *
 * @property integer $id
 * @property integer $resident_id
 * @property integer $user_id
 * @property integer $floor_id
 * @property double $coorx
 * @property double $coory
 * @property integer $outside
 * @property double $azimuth
 * @property double $speed
 * @property string $created_at
 * @property string $zone
 *
 * @property Resident $resident
 * @property Floor $floor
 */
class Location extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'location';
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
            [['floor_id', 'coorx', 'coory'], 'required'],
            [['resident_id', 'floor_id', 'outside'], 'integer'],
            [['coorx', 'coory', 'azimuth', 'speed'], 'number'],
            [['created_at', 'zone'], 'safe'],
            [['resident_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resident::className(), 'targetAttribute' => ['resident_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'resident_id' => 'Resident',
            'user_id' => 'Username',
            'floor_id' => 'Last floor',
            'coorx' => 'Coorx',
            'coory' => 'Coory',
            'zone' => 'Zone',
            'outside' => 'Outside',
            'azimuth' => 'Azimuth',
            'speed' => 'Speed',
            'created_at' => 'Created At',
            'residentName' => 'Resident Name',
            'userName' => 'Username',
            'floorName' => 'Floor Name',
            'residentGender' => 'Gender',
            'residentBirthday' => 'Birthday',
        ];
    }

    public function getResidentName(){
        if ($this->resident == NULL) return "";
        $query = Resident::find()->where(['id' => $this->resident_id])->one();
        return $query['firstname']." ".$query['lastname'];
    }

    public function getUserName(){
        if ($this->user_id == NULL) return "";
        $query = User::find()->where(['id' => $this->user_id])->one();
        return $query['username'];
    }

    public function getFloorName(){
        if ($this->floor_id == NULL) return "";
        $query = Floor::find()->where(['id' => $this->floor_id])->one();
        return $query['label'];
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

    public function getOutsideName(){
        if ($this->outside == 0) return 'Inside';
        return 'Outside';
    }

    public function getOutsideAlert(){
        if ($this->outside == 0) return 'Time out';
        return 'Outside';
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
    public function getFloor()
    {
        return $this->hasOne(Floor::className(), ['id' => 'floor_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
