<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

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

    public function getResidentList(){
        $query = ResidentRelative::find()->where(['nextofkin_id' => $this->id])->all();
        $str = "";
        foreach ($query as $item){
            $tmp = Resident::find()->where(['id' => $item['resident_id']])->one();
            if ($str == ""){
                $str .= "".$item['relation']." of: <a href='".Yii::$app->homeUrl."resident/view?id=".$tmp['id']."'>".$tmp['fullName']."</a>";
            }
            else{
                $str .= "<br>".$item['relation']." of: <a href='".Yii::$app->homeUrl."resident/view?id=".$tmp['id']."'>".$tmp['fullName']."</a>";
            }
        }
        if ($str == null){
            return "";
        }
        return $str;
    }

}
