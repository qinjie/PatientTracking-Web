<?php
namespace api\common\models;

use Yii;

class Tag extends \backend\models\Tag
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }

}
