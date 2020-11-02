<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
?>
<div class="row">
    <div class="text-center"><h1><?= Html::encode($this->title) ?></h1></div>
<br>
    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-sm-5 col-lg-3 mb-10\">{input}</div>",
            'labelOptions' => ['class' => 'col-sm-offset-3 col-sm-1 col-lg-offset-4 col-lg-1 control-label-left'],
        ],
    ]); ?>
        <?= $form->errorSummary($model, ["class" => "col-sm-offset-3 col-sm-6 col-lg-offset-4 col-lg-4"]) ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

        <?= $form->field($model, 'inn')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999999999','options' => ['value'=>'0']])->label('ИНН') ?>

        <?= $form->field($model, 'utype')->dropDownList(['D' => 'Водитель', 'C' => 'Компания'], ['onchange' => 'show_inn(this)'])->label('Тип') ?>
<br/>
        <div class="form-group">
            <div class="col-sm-9 col-lg-8 text-right">
                <?= Html::submitButton('Регистрация', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
</div>
<script language="JavaScript">

    document.addEventListener('DOMContentLoaded', function(){
        if ( $('#registerform-utype').val() === 'C' ) {$('#registerform-inn').val(''); $('.field-registerform-inn').show()};
        if ( $('#registerform-utype').val() === 'D' ) {$('.field-registerform-inn').hide()};

    });

    function show_inn(o) {
        if ( $(o).val() === 'C' ) {$('#registerform-inn').val(''); $('.field-registerform-inn').show()};
        if ( $(o).val() === 'D' ) {$('#registerform-inn').val('0'); $('.field-registerform-inn').hide()};
    }
</script>