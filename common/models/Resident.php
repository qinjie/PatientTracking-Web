<?php

namespace common\models;

use backend\models\Floor;
use backend\models\Tag;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Html;

/**
 * This is the model class for table "resident".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 * @property string $nric
 * @property string $gender
 * @property string $birthday
 * @property string $contact
 * @property string $remark
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Location[] $location
 * @property ResidentRelative[] $residentRelatives
 * @property Tag[] $tags
 */
class Resident extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resident';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['firstname', 'lastname', 'nric'], 'required'],
            [['birthday', 'created_at', 'updated_at'], 'safe'],
            [['firstname', 'lastname'], 'string', 'max' => 100],
            [['nric', 'contact'], 'string', 'max' => 20],
            [['gender'], 'string', 'max' => 10],
            [['remark'], 'string', 'max' => 500],
        ];
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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'nric' => 'Nric',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'contact' => 'Contact',
            'remark' => 'Remark',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'fullName' => Yii::t('app', 'Full Name'),
            'floor' => Yii::t('app', 'Floor'),
            'coorx' => 'X',
            'coory' => 'Y',
            'lastTime' => 'Last signal',
            'speed' => 'Speed',
            'lastFloor' => 'Last Floor',
            'lastFloorId' => 'Last Floor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocation()
    {
        return $this->hasMany(Location::className(), ['resident_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResidentRelatives()
    {
        return $this->hasMany(ResidentRelative::className(), ['resident_id' => 'id']);
    }

    public function getNextOfKin(){
        return $this->hasMany(Nextofkin::className(), ['id' => 'nextofkin_id'])
            ->viaTable('resident_relative', ['resident_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['resident_id' => 'id']);
    }

    public function getFullName(){
        return $this->firstname." ".$this->lastname;
    }

    public function getCoorx(){
        $query = Location::find()->where(['resident_id' => $this->id])->orderBy('created_at DESC')->one();
        return $query['coorx'];
    }

    public function getCoory(){
        $query = Location::find()->where(['resident_id' => $this->id])->orderBy('created_at DESC')->one();
        return $query['coory'];
    }

    public function getLastTime(){
        $query = Location::find()->where(['resident_id' => $this->id])->orderBy('created_at DESC')->one();
        return $query['created_at'];
    }

    public function getSpeed(){
        $query = Location::find()->where(['resident_id' => $this->id])->orderBy('created_at DESC')->one();
        return $query['speed'];
    }

    public function getLastFloor(){
        $query = Location::find()->where(['resident_id' => $this->id])->orderBy('created_at DESC')->one();
        $rs = Floor::find()->where(['id' => $query['floor_id']])->one();
        return $rs['label'];
    }
    public function getLastFloorId(){
        $query = Location::find()->where(['resident_id' => $this->id])->orderBy('created_at DESC')->one();
        return $query['floor_id'];
    }

    public function getAzimuth(){
        $query = Location::find()->where(['resident_id' => $this->id])->orderBy('created_at DESC')->one();
        return $query['azimuth'];
    }
}
