<?php
namespace api\common\models;

use Yii;

class QuuppaTagPosition extends \common\models\QuuppaTagPosition
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }

}
