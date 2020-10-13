<?php    
	use yii\helpers\Html;
	use kartik\date\DatePicker;
	use yii\bootstrap\ActiveForm;

	$form = ActiveForm::begin([
		'id' => 'driver-info',
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>",
			'labelOptions' => ['class' => 'col-lg-6 control-label'],
		],       
	]);    
?>
<br>
<div>
	<?= $form->errorSummary($model) ?>

	<?= $form->field($model, 'email')->textInput(['value' => Yii::$app->user->identity->username, 'placeholder' => 'inbox@example.com'])->label('Адрес электронной почты*:') ?>

	<?= $form->field($model, 'secondName')->textInput(['value' => $profile['secondname'], 'placeholder' => 'Иванов'])->label('Фамилия*:') ?>

	<?= $form->field($model, 'firstName')->textInput(['value' => $profile['firstname'], 'placeholder' => 'Иван'])->label('Имя*:') ?>

	<?= $form->field($model, 'thirdName')->textInput(['value' => $profile['middlename'], 'placeholder' => 'Иванович'])->label('Отчество*:') ?>

	<div class="form-group field-driverprofileform-birthdate">
		<?php
			echo '<label class="col-lg-6 control-label" for="driverprofileform-birthdate">Дата рождения*:</label>'; 
			echo '<div class="col-lg-6">';
			echo DatePicker::widget([
				'model' => 'birthDate',
				'name' => 'birth-date',			
				'type' => DatePicker::TYPE_INPUT,	
				'value' => $profile['birthday'],
				'options' => ['placeholder' => '23.02.1982'],
				'pluginOptions' => [
					'autoclose' => true,
					'format' => 'dd.mm.yyyy'
				]
			]);
			echo '</div>';
		?>
	</div>

	<?= $form->field($model, 'passportSerial')->textInput(['value' => $profile['pserial'], 'placeholder' => '0001'])->label('Серия паспорта*:') ?>

	<?= $form->field($model, 'passportNumber')->textInput(['value' => $profile['pnumber'], 'placeholder' => '000001'])->label('Номер паспорта*:') ?>

	<?= $form->field($model, 'inn')->textInput(['value' => $profile['inn'], 'placeholder' => '25500000000000'])->label('ИНН*:') ?>

	<?= $form->field($model, 'licenseSerial')->textInput(['value' => $profile['dserial'], 'placeholder' => '0001'])->label('Серия водительского удостоверения*:') ?>

	<?= $form->field($model, 'licenseNumber')->textInput(['value' => $profile['dnumber'], 'placeholder' => '000001'])->label('Номер водительского удостоверения*:') ?>

	<div class="form-group field-driverprofileform-licenserealeasedate">
		<?php
			echo '<label class="col-lg-6 control-label" for="driverprofileform-licensereleasedate">Дата рождения*:</label>'; 
			echo '<div class="col-lg-6">';
			echo DatePicker::widget([
				'model' => 'licenseRealeaseDate',
				'name' => 'license-release-date',
				'type' => DatePicker::TYPE_INPUT,
				'value' => $profile['ddate'],
				'options' => ['placeholder' => '23.02.1982'],
				'pluginOptions' => [
					'autoclose'=>true,
					'format' => 'dd.mm.yyyy'
				]
			]);
			echo '</div>';
		?>
	</div>      

	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'driver-info-save', 'method' => 'post']) ?>

	<?php ActiveForm::end(); ?>
</div>    
