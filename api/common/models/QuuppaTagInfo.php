<?php
namespace api\common\models;

use Yii;

class QuuppaTagInfo extends \common\models\QuuppaTagInfo
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }

}
