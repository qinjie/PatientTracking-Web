<?php
namespace api\common\models;

use Yii;

class Button extends \backend\models\Button
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
