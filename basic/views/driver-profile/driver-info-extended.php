<?php
	use yii\helpers\Html;
	use kartik\date\DatePicker;
	use yii\bootstrap\ActiveForm;
	use yii\jui\AutoComplete;		

	$form = ActiveForm::begin([
		'id' => 'driver-info-extended',
		'fieldConfig' => [
			'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>",
			'labelOptions' => ['class' => 'col-lg-6 control-label'],
		], 
	]);	

?>
<br>
<div class="driver-info-extended-content">

	<?= $form->errorSummary($model) ?>

	<?= $form->field($model, 'mainNumber')->textInput(['value' => $profile['personalphone'], 'placeholder' => '+79998884411'])->label('Контактный телефон*:') ?>

	<?= $form->field($model, 'relativesNumbers')->textInput(['value' => $profile['relphones'], 'placeholder' => '+79998884411, +79998884411'])->label('Телефоны родственников (2 человека)*:') ?>

	<?= $form->field($model, 'familyStatus')->dropDownList(
		['N' => 'Нет', 'Y' => 'Да'], 
		['value' => $profile['familystatus']])->label('Семейное положение*:') ?>

	<?= $form->field($model, 'childs')->textarea(['value' => $profile['childs'], 'rows' => '5'] )->label('Дети, пол и возраст*:') ?>
		<br>
		<br>
		<br>
		<br>
	<?= $form->field($model, 'categoryC')->textInput(['value' => $profile['c_experience'], 'placeholder' => '10'])->label('Стаж вождения именно по категории “С” (лет)*:') ?>

	<?= $form->field($model, 'categoryE')->textInput(['value' => $profile['e_experience'], 'placeholder' => '10'])->label('Стаж вождения именно по категории “Е” (лет)*:') ?>

	<?= $form->field($model, 'tachograph')->widget(\yii\jui\AutoComplete::classname(), [
		'clientOptions' => [						
			'source' => [ $dic_tachograph[1], $dic_tachograph[2], $dic_tachograph[3] ], // Need to change
		],
		'options' => [
			'value' => $profile['tachograph']
		]		
	])->label('Имеется ли карта тахографа, выбрать из списка (можно выбрать несколько)*:*') ?>	

	<?= $form->field($model, 'marks')->textarea(['value' => $profile['transporttype'], 'rows' => '5'] )->label('Марки транспортных средств, которыми управляли на последних местах работы*:') ?>
		<br>
		<br>
		<br>
		<br>

	<?= $form->field($model, 'trailertype')->widget(\yii\jui\AutoComplete::classname(), [
		'clientOptions' => [						
			'source' => [ $dic_trailertype[1], $dic_trailertype[2], $dic_trailertype[3] ], // Need to change
		],
		'options' => [
			'value' => $profile['trailertype']	
		]		
	])->label('Какими прицепами управляли, выбрать из списка (можно выбрать несколько):*') ?>	

	<?= $form->field($model, 'interPassportExpireDate')->widget(DatePicker::classname(), [		
		'type' => DatePicker::TYPE_INPUT,		
		'options' => ['value' => $profile['fpassdate'], 'placeholder' => '23.02.1982'],
		'pluginOptions' => [
			'autoclose' => true,
			'format' => 'dd.mm.yyyy'
		]
	])->label('Дата окончания загран.паспорта*:') ?>

	<?= $form->field($model, 'medCard')->dropDownList(['0' => 'Нет', '1' => 'Да'])->label('Наличие медицинской книжки*:') ?>

	<?= $form->field($model, 'startDate')->widget(DatePicker::classname(), [		
		'type' => DatePicker::TYPE_INPUT,		
		'options' => ['value' => $profile['startdate'], 'placeholder' => '23.02.1982'],
		'pluginOptions' => [
			'autoclose' => true,
			'format' => 'dd.mm.yyyy'
		]
	])->label('Когда вы готовы приступить к работе*:') ?>
	
	<?= $form->field($model, 'flyInAccept')->dropDownList(['0' => 'Нет', '1' => 'Да'])->label('Согласна ли ваша семья/близкие родственники работе вахтовым методом*:') ?>

	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'driver-info-extended-save', 'method' => 'post']) ?>

	<?php ActiveForm::end(); ?>
</div>
