<?php
namespace api\common\models;

use Yii;

class ResidentLocation extends \backend\models\ResidentLocationHistory
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
