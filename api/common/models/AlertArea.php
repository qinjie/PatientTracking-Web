<?php
namespace api\common\models;

use Yii;

class AlertArea extends \backend\models\AlertArea
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
