<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            // 'auth_key',
            // 'password_hash',
            // 'access_token',
            // 'password_reset_token',
            'email:email',
            [
                'attribute'=>'status',
                'value'=>'statusName',
                'filter'=>array(0 => 'Deleted', 1 => 'Blocked', 5 => 'Waiting', 10 => 'Active'),
            ],
            [
                'attribute'=>'role',
                'value'=>'roleName',
                'filter'=>array(10 => 'User', 20 => 'Manager', 30 => 'Admin', 40 => 'Master'),
            ],
            // 'email_confirm_token:email',
            // 'allowance',
            // 'timestamp:datetime',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
