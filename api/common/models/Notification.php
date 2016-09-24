<?php
namespace api\common\models;

use Yii;

class Notification extends \common\models\Notification
{
    public function extraFields()
    {
        $more = ['resident', 'user', 'location'];
        $fields = array_merge(parent::fields(), $more);
        return $fields;
    }
}
