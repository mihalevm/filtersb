<?php    
	use yii\helpers\Html;
	use kartik\date\DatePicker;
	use yii\bootstrap\ActiveForm;

	$form = ActiveForm::begin([
		'id' => 'driver-info',
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>",
			'labelOptions' => ['class' => 'col-lg-6 col-lg-offset-1 control-label'],
		],       
	]);    

?>
<br>
<div class="driver-info-content">

	<?= $form->errorSummary($model) ?>

	<?= $form->field($model, 'email')->textInput(['value' => Yii::$app->user->identity->username, 'placeholder' => 'inbox@example.com'])->label('Адрес электронной почты<span class="field-required">*</span>') ?>

	<?= $form->field($model, 'secondName')->textInput(['value' => $profile['secondname'], 'placeholder' => 'Иванов'])->label('Фамилия<span class="field-required">*</span>') ?>

	<?= $form->field($model, 'firstName')->textInput(['value' => $profile['firstname'], 'placeholder' => 'Иван'])->label('Имя<span class="field-required">*</span>') ?>

	<?= $form->field($model, 'thirdName')->textInput(['value' => $profile['middlename'], 'placeholder' => 'Иванович'])->label('Отчество<span class="field-required">*</span>') ?>

	<?= $form->field($model, 'birthDate')->widget(DatePicker::classname(), [		
		'type' => DatePicker::TYPE_INPUT,
		'options' => ['value' => $profile['birthday'], 'placeholder' => '23.02.1982'],
		'pluginOptions' => [
			'autoclose' => true,
			'format' => 'dd.mm.yyyy'
		]
	])->label('Дата рождения<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'sex')->dropDownList(['0' => 'Женский', '1' => 'Мужской'], ['value' => $profile['sex']])->label('Пол<span class="field-required">*</span>')?>

    <?= $form->field($model, 'passportSerial')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999', 'options' => ['placeholder' => '0001', 'value'=>$profile['pserial']]])->label('Серия паспорта<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'passportNumber')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999', 'options' => ['placeholder' => '000001', 'value'=>$profile['pnumber']]])->label('Номер паспорта<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'passportRealeaseDate')->widget(DatePicker::classname(), [
        'type' => DatePicker::TYPE_INPUT,
        'options' => ['value' => $profile['pdate'], 'placeholder' => '23.02.1982'],
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'dd.mm.yyyy'
        ]
    ])->label('Дата выдачи паспорта<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'inn')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999999999', 'options' => ['placeholder' => '000000000001', 'value'=>$profile['inn']]])->label('ИНН<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'licenseSerial')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999', 'options' => ['placeholder' => '0001', 'value'=>$profile['dserial']]])->label('Серия водительского удостоверения<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'licenseNumber')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999', 'options' => ['placeholder' => '000001', 'value'=>$profile['dnumber']]])->label('Номер водительского удостоверения<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'licenseRealeaseDate')->widget(DatePicker::classname(), [
			'type' => DatePicker::TYPE_INPUT,			
			'options' => ['value' => $profile['ddate'], 'placeholder' => '23.02.1982'],
			'pluginOptions' => [
				'autoclose' => true,
				'format' => 'dd.mm.yyyy'
			]
			])->label('Дата выдачи водительского удостоверения<span class="field-required">*</span>') ?>

	<?= $form->field($model, 'agreementPersonalData')->dropDownList(
		['N' => 'Нет', 'Y' => 'Да'], 
		['value' => $profile['agreepersdata']])->label('Cогласие на обработку персональных данных') ?>

	<?= $form->field($model, 'agreementThirdParty')->dropDownList(
		['N' => 'Нет', 'Y' => 'Да'],
		['value' => $profile['agreecheck']])->label('Cогласие на то, что достоверность указанных данных будет проверяться третьими лицами') ?>

	<?= $form->field($model, 'agreementComments')->dropDownList(
		['N' => 'Нет', 'Y' => 'Да'],		
		['value' => $profile['agreecomment']])->label('Cогласие на комментирование со стороны транспортных компаний') ?>

    <div class="form-group col-lg-11 text-right">
        <span class="label label-info fake-bnt mr-10" onclick="goHome()">На главную</span>
        <?= Html::submitButton('Далее', ['class' => 'btn btn-primary', 'name' => 'driver-info-save', 'method' => 'post']) ?>
    </div>


	<?php ActiveForm::end(); ?>
</div>    
