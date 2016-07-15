<?php
namespace api\common\models;

use Yii;

class Button extends \backend\models\ButtonHistory
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
