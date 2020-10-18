<?php    
	use yii\helpers\Html;
	use kartik\date\DatePicker;
	use yii\bootstrap\ActiveForm;

	$form = ActiveForm::begin([
		'id' => 'driver-previous-work',
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>",
			'labelOptions' => ['class' => 'col-lg-6 control-label'],
		],        
	]);
?>
<br>
<div class="driver-previous-work-content">

	<?= $form->errorSummary($model) ?>

	<?= $form->field($model, 'workplaceList')->dropDownList(['0' => 'Первое место работы', '1' => 'Второе место работы', '1' => 'Третье место работы'])->label('Выберите место работы:') ?>

	<?= $form->field($model, 'workStartDate')->widget(DatePicker::classname(), [		
		'type' => DatePicker::TYPE_INPUT,		
		'options' => ['value' =>  $profile['sdate'], 'placeholder' => '23.02.1982'],
		'pluginOptions' => [
			'autoclose' => true,
			'format' => 'dd.mm.yyyy'
		]
	])->label('Дата приема на работу*:') ?>	
	
	<?= $form->field($model, 'workEndDate')->widget(DatePicker::classname(), [		
		'type' => DatePicker::TYPE_INPUT,		
		'value' => $profile['edate'],
		'options' => ['value' =>  $profile['sdate'], 'placeholder' => '23.02.1982'],
		'pluginOptions' => [
			'autoclose' => true,
			'format' => 'dd.mm.yyyy'
		]
	])->label('Дата увольнения с работы*:') ?>

	<?= $form->field($model, 'company')->textInput(['value' => $profile['company'],])->label('Название организации') ?>
	<?= $form->field($model, 'post')->textInput(['value' => $profile['post'],])->label('Должность') ?>
	<?= $form->field($model, 'action')->textarea(['value' => $profile['action'], 'rows' => '5'] )->label('Содержание деятельности') ?>
	<br>
	<br>
	<br>
	<br>
	<?= $form->field($model, 'dismissal')->textInput(['value' => $profile['dismissal'],])->label('Причина увольнения') ?>
	<?= $form->field($model, 'guarantor')->textarea(['value' => $profile['guarantor'], 'rows' => '10'] )->label('Содержание деятельности') ?>
	<br>
	<br>
	<br>
	<br>
	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'method' => 'post']) ?>
	<?php ActiveForm::end(); ?>
</div>
