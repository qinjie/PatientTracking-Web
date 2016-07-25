<?php
namespace api\common\models;

use Yii;

class ResidentLocation extends \backend\models\LocationHistory
{
    public function extraFields()
    {
        $more = [];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
