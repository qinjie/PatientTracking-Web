<?php

namespace backend\models;

use common\models\Resident;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "button".
 *
 * @property integer $id
 * @property string $tagid
 * @property string $created_at
 */
class Button extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'button';
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
            [['tagid'], 'required'],
            [['tagid'], 'string', 'max' => 500],
            [['created_at', 'residentName'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tagid' => 'Tagid',
            'created_at' => 'Created At',
        ];
    }

    public function getResidentName(){
        $tag = Tag::find()->where(['mac' => $this->tagid])->one();
        $query = Resident::find()->where(['id' => $tag['resident_id']])->one();
        return $query['firstname']." ".$query['lastname'];
    }

}
