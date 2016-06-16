<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "resident_location".
 *
 * @property integer $id
 * @property integer $resident_id
 * @property integer $floor_id
 * @property double $coorx
 * @property double $coory
 * @property integer $outside
 * @property double $azimuth
 * @property double $speed
 * @property string $created_at
 *
 * @property Resident $resident
 * @property Floor $floor
 */
class ResidentLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resident_location';
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                // Modify only created not updated attribute
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created', 'modified'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['modified'],
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
            [['resident_id', 'floor_id', 'coorx', 'coory'], 'required'],
            [['resident_id', 'floor_id', 'outside'], 'integer'],
            [['coorx', 'coory', 'azimuth', 'speed'], 'number'],
            [['created_at'], 'safe'],
            [['resident_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resident::className(), 'targetAttribute' => ['resident_id' => 'id']],
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
            'floor_id' => 'Floor',
            'coorx' => 'Coorx',
            'coory' => 'Coory',
            'outside' => 'Outside',
            'azimuth' => 'Azimuth',
            'speed' => 'Speed',
            'created_at' => 'Created At',
            'residentName' => Yii::t('app', 'Resident Name'),
            'floorName' => Yii::t('app', 'Floor Name'),
            'residentGender' => 'Gender',
            'residentBirthday' => 'Birthday',
        ];
    }
    
    public function getResidentName(){
        $query = Resident::find()->where(['id' => $this->resident_id])->one();
        return $query['firstname']." ".$query['lastname'];
    }

    public function getFloorName(){
        $query = Floor::find()->where(['id' => $this->floor_id])->one();
        return $query['label'];
    }

    public function getResidentGender(){
        $query = Resident::find()->where(['id' => $this->floor_id])->one();
        return $query['gender'];
    }

    public function getResidentBirthday(){
        $query = Resident::find()->where(['id' => $this->floor_id])->one();
        return $query['birthday'];
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
}
