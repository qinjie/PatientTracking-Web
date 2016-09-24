<?php
namespace api\common\models;

use Yii;

class Fcmtoken extends \common\models\Fcmtoken
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
