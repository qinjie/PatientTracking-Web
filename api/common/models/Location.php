<?php
namespace api\common\models;

use Yii;

class Location extends \common\models\Location
{
    public function extraFields()
    {
        $more = ['resident', 'user'];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
