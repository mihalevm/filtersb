<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Редактирование профиля';
?>
<br/>
<br/>
<br/>
    <?php $form = ActiveForm::begin([
        'id' => 'company-edit-profile-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}<div class='col-sm-12 col-lg-4'>{input}</div>",
            'labelOptions' => ['class' => 'col-sm-1 col-lg-4 control-label text-nowrap text-sm-left company-font-color'],
        ],
    ]); ?>
        <?= $form->errorSummary($model) ?>

        <?= $form->field($model, 'companyname')->textInput(['autofocus' => true, 'value' => $profile['companyname']])->label('Название компании') ?>

        <?= $form->field($model, 'inn')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999999999', 'options' => ['value'=>$profile['inn']]])->label('ИНН') ?>

        <?= $form->field($model, 'firstname')->textInput(['value' => $profile['firstname']])->label('Имя') ?>

        <?= $form->field($model, 'secondname')->textInput(['value' => $profile['secondname']])->label('Фамилия') ?>

        <?= $form->field($model, 'middlename')->textInput(['value' => $profile['middlename']])->label('Отчество') ?>

        <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9-999-999-9999', 'options' => ['value'=>$profile['personalphone']]])->label('Контактный телефон') ?>

        <?= $form->field($model, 'email')->textInput(['value' => Yii::$app->user->identity->username]) ?>

        <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

        <div class="form-group">
            <div class="col-sm-offset-10 col-sm-12 col-lg-offset-7 mt-10">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'register-button']) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
