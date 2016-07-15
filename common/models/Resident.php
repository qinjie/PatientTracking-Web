<?php

namespace common\models;

use backend\models\Floor;
use backend\models\Tag;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
 * @property string $lastmodified
 *
 * @property ResidentLocation[] $residentLocations
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
            [['birthday', 'lastmodified'], 'safe'],
            [['firstname', 'lastname'], 'string', 'max' => 100],
            [['nric', 'contact'], 'string', 'max' => 20],
            [['gender'], 'string', 'max' => 10],
            [['remark'], 'string', 'max' => 500],
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
            'lastmodified' => 'Lastmodified',
            'fullName' => Yii::t('app', 'Full Name'),
            'floor' => Yii::t('app', 'Floor'),
            'coorx' => 'X',
            'coory' => 'Y',
            'speed' => 'Speed',
            'lastfloor' => 'Last Floor',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResidentLocations()
    {
        return $this->hasMany(ResidentLocation::className(), ['resident_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResidentRelatives()
    {
        return $this->hasMany(ResidentRelative::className(), ['resident_id' => 'id']);
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
        $query = ResidentLocation::find()->where(['resident_id' => $this->id])->orderBy('created_at DESC')->one();
        return $query['coorx'];
    }

    public function getCoory(){
        $query = ResidentLocation::find()->where(['resident_id' => $this->id])->orderBy('created_at DESC')->one();
        return $query['coory'];
    }

    public function getSpeed(){
        $query = ResidentLocation::find()->where(['resident_id' => $this->id])->orderBy('created_at DESC')->one();
        return $query['speed'];
    }

    public function getLastfloor(){
        $query = ResidentLocation::find()->where(['resident_id' => $this->id])->orderBy('created_at DESC')->one();
        $rs = Floor::find()->where(['id' => $query['floor_id']])->one();
        return $rs['label'];
    }
}
