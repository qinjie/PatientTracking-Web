<?php
namespace api\common\models;

use Yii;

class Resident extends \common\models\Resident
{
    public function extraFields()
    {
        $more = ['location', 'nextOfKin'];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
