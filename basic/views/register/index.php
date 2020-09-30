<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
<br>
    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-5\">{input}</div>",
            'labelOptions' => ['class' => 'col-lg-2 control-label'],
        ],
    ]); ?>
        <?= $form->errorSummary($model) ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

        <?= $form->field($model, 'inn')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999999999','options' => ['value'=>'0']])->label('ИНН') ?>

        <?= $form->field($model, 'utype')->dropDownList(['D' => 'Водитель', 'C' => 'Компания'], ['onchange' => 'show_inn(this)'])->label('Тип') ?>
<br/>
        <div class="form-group">
            <div class="col-lg-offset-5 col-lg-11">
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