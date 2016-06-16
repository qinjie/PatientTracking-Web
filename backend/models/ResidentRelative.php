<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "resident_relative".
 *
 * @property integer $id
 * @property integer $resident_id
 * @property integer $nextofkin_id
 * @property string $relation
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Resident $resident
 * @property Nextofkin $nextofkin
 */
class ResidentRelative extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resident_relative';
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
            [['resident_id', 'nextofkin_id', 'relation'], 'required'],
            [['resident_id', 'nextofkin_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['relation'], 'string', 'max' => 50],
            [['resident_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resident::className(), 'targetAttribute' => ['resident_id' => 'id']],
            [['nextofkin_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nextofkin::className(), 'targetAttribute' => ['nextofkin_id' => 'id']],
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
            'nextofkin_id' => 'Nextofkin',
            'relation' => 'Relation',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'residentName' => Yii::t('app', 'Resident Name'),
            'nextofkinName' => Yii::t('app', 'Next-of-kin Name'),
        ];
    }

    public function getResidentName(){
        $query = Resident::find()->where(['id' => $this->resident_id])->one();
        return $query['firstname']." ".$query['lastname'];
    }

    public function getNextofkinName(){
        $query = Nextofkin::find()->where(['id' => $this->nextofkin_id])->one();
        return $query['first_name']." ".$query['last_name'];
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
    public function getNextofkin()
    {
        return $this->hasOne(Nextofkin::className(), ['id' => 'nextofkin_id']);
    }

}
