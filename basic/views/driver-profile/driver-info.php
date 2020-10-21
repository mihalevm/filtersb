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

	<?= $form->field($model, 'email')->textInput(['value' => Yii::$app->user->identity->username, 'placeholder' => 'inbox@example.com'])->label('Адрес электронной почты*:') ?>

	<?= $form->field($model, 'secondName')->textInput(['value' => $profile['secondname'], 'placeholder' => 'Иванов'])->label('Фамилия*:') ?>

	<?= $form->field($model, 'firstName')->textInput(['value' => $profile['firstname'], 'placeholder' => 'Иван'])->label('Имя*:') ?>

	<?= $form->field($model, 'thirdName')->textInput(['value' => $profile['middlename'], 'placeholder' => 'Иванович'])->label('Отчество*:') ?>

	<?= $form->field($model, 'birthDate')->widget(DatePicker::classname(), [		
		'type' => DatePicker::TYPE_INPUT,
		'options' => ['value' => $profile['birthday'], 'placeholder' => '23.02.1982'],
		'pluginOptions' => [
			'autoclose' => true,
			'format' => 'dd.mm.yyyy'
		]
	])->label('Дата рождения*:') ?>

	<?= $form->field($model, 'passportSerial')->textInput(['value' => $profile['pserial'], 'placeholder' => '0001'])->label('Серия паспорта*:') ?>

	<?= $form->field($model, 'passportNumber')->textInput(['value' => $profile['pnumber'], 'placeholder' => '000001'])->label('Номер паспорта*:') ?>

	<?= $form->field($model, 'inn')->textInput(['value' => $profile['inn'], 'placeholder' => '25500000000000'])->label('ИНН*:') ?>

	<?= $form->field($model, 'licenseSerial')->textInput(['value' => $profile['dserial'], 'placeholder' => '0001'])->label('Серия водительского удостоверения*:') ?>

	<?= $form->field($model, 'licenseNumber')->textInput(['value' => $profile['dnumber'], 'placeholder' => '000001'])->label('Номер водительского удостоверения*:') ?>

		<?= $form->field($model, 'licenseRealeaseDate')->widget(DatePicker::classname(), [		
			'type' => DatePicker::TYPE_INPUT,			
			'options' => ['value' => $profile['ddate'], 'placeholder' => '23.02.1982'],
			'pluginOptions' => [
				'autoclose' => true,
				'format' => 'dd.mm.yyyy'
			]
			])->label('Дата выдачи водительского удостоверения*:') ?>

	<?= $form->field($model, 'agreementPersonalData')->dropDownList(
		['N' => 'Нет', 'Y' => 'Да'], 
		['value' => $profile['agreepersdata']])->label('Cогласие на обработку персональных данных.') ?>

	<?= $form->field($model, 'agreementThirdParty')->dropDownList(
		['N' => 'Нет', 'Y' => 'Да'],
		['value' => $profile['agreecheck']])->label('Cогласие на то, что достоверность указанных данных будет проверяться третьими лицами.') ?>

	<?= $form->field($model, 'agreementComments')->dropDownList(
		['N' => 'Нет', 'Y' => 'Да'],		
		['value' => $profile['agreecomment']])->label('Cогласие на комментирование со стороны транспортных компаний.') ?>

	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right mr-12 mt-10', 'name' => 'driver-info-save', 'method' => 'post']) ?>

	<?php ActiveForm::end(); ?>
</div>    
