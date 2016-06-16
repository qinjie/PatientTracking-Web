<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AlertArea */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alert-area-form">

    <?php $form = ActiveForm::begin(['id' => $model->formName()]); ?>

    <?= $form->field($model, 'floor_id')->textInput()->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'position')->textInput()->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'pixelx')->textInput() ?>

    <?= $form->field($model, 'pixely')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput()->hiddenInput()->label(false) ?>

    <?= $form->field($model, 'updated_at')->textInput()->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS

    $('form#{$model->formName()}').on('beforeSubmit', function (e) {
        var \$form = $(this);
        $.post(
            \$form.attr("action"),
            \$form.serialize()
        ).done(function (result) {
           if (result == "Success"){
               $(document).find('#modal').modal('hide');
               $.pjax.reload({container:'#PjaxGrid'});
               var Pos = (document).getElementById('nextPosAlert');
               Pos.value = parseInt(Pos.value) + 1;
           }else{
               $(\$form).trigger("reset");
           }
        }).fail(function () {
            console.log("Server error");
        });
        return false;
    })

JS;
$this->registerJs($script);
?>
