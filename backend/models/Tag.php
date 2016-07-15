<?php

namespace backend\models;

use common\models\Resident;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $label
 * @property string $tagid
 * @property integer $status
 * @property integer $resident_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Resident $resident
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
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
    public function rules()
    {
        return [
            [['label', 'status'], 'required'],
            [['status', 'resident_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['label', 'tagid'], 'string', 'max' => 20],
            [['label'], 'unique'],
            [['resident_id'], 'exist', 'skipOnError' => true, 'targetClass' => Resident::className(), 'targetAttribute' => ['resident_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'label' => 'Label',
            'tagid' => 'Tag ID',
            'status' => 'Status',
            'resident_id' => 'Resident ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'residentName' => Yii::t('app', 'Resident Name'),
            'statusName' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getResident()
    {
        return $this->hasOne(Resident::className(), ['id' => 'resident_id']);
    }

    public function getResidentName(){
        $query = Resident::find()->where(['id' => $this->resident_id])->one();
        return $query['firstname']." ".$query['lastname'];
    }

    public function getStatusName(){
        if ($this->status == 1) return "Active";
        return "Inactive";
    }
}
