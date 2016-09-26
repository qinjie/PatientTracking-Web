<?php
namespace api\common\models;

use Yii;

class Marker extends \backend\models\Marker
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
