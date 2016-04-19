<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "nextofkin".
 *
 * @property integer $id
 * @property string $nric
 * @property string $first_name
 * @property string $last_name
 * @property string $contact
 * @property string $email
 * @property string $remark
 * @property string $created_at
 * @property string $updated_at
 *
 * @property ResidentRelative[] $residentRelatives
 */
class Nextofkin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nextofkin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nric', 'first_name', 'last_name'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['nric', 'contact'], 'string', 'max' => 20],
            [['first_name', 'last_name'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 50],
            [['remark'], 'string', 'max' => 500],
            [['nric'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nric' => 'Nric',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'contact' => 'Contact',
            'email' => 'Email',
            'remark' => 'Remark',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'full_Name' => Yii::t('app', 'Full Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResidentRelatives()
    {
        return $this->hasMany(ResidentRelative::className(), ['nextofkin_id' => 'id']);
    }

    public function getFull_Name(){
        return $this->first_name." ".$this->last_name;
    }

}
