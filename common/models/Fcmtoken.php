<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "fcmtoken".
 *
 * @property integer $id
 * @property string $mac_address
 * @property string $fcm_token
 */
class Fcmtoken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fcmtoken';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mac_address'], 'required'],
            [['mac_address'], 'string', 'max' => 32],
            [['fcm_token'], 'string', 'max' => 255],
            [['mac_address'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mac_address' => 'Mac Address',
            'fcm_token' => 'Fcm Token',
        ];
    }
}
