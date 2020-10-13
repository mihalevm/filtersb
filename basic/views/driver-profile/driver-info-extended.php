<?php
	use yii\helpers\Html;
	use kartik\date\DatePicker;
	use yii\bootstrap\ActiveForm;
	use yii\jui\AutoComplete;	
	//use yii\helpers\ArrayHelper;

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
	<?= $form->field($model, 'mainNumber')->textInput(['value' => $profile['personalphone'], 'placeholder' => '+79998884411'])->label('Контактный телефон*:') ?>

	<?= $form->field($model, 'relativesNumbers')->textInput(['value' => $profile['relphones'], 'placeholder' => '+79998884411, +79998884411'])->label('Телефоны родственников (2 человека)*:') ?>

	<?= $form->field($model, 'tachograph')->widget(\yii\jui\AutoComplete::classname(), [
		'clientOptions' => [						
			'source' => [ $dic_tachograph[1], $dic_tachograph[2], $dic_tachograph[3] ], // Пока не нашел варианта добавлять полностью весь список
		],
	])->label('Имеется ли карта тахографа, выбрать из списка (можно выбрать несколько)*:') ?>	

	<textarea class="form-control" rows="10"></textarea>
	<?= Html::dropDownList('international-passport', 'null', ['0' => 'Нет', '1' => 'Да']) ?>
	<?= Html::dropDownList('conviction', 'null', ['0' => 'Нет', '1' => 'Да']) ?>
	<textarea class="form-control" rows="10"></textarea>
	<?= Html::dropDownList('med-card', 'null', ['0' => 'Нет', '1' => 'Да']) ?>
	<textarea class="form-control" rows="5"></textarea>                  

	<?= Html::dropDownList('fly-in-accept', 'null', ['0' => 'Нет', '1' => 'Да']) ?>                
	<div class="form-check">
		<input type="checkbox" class="form-check-input" id="agreement-personal-data">
		<label class="form-check-label" for="agreement-personal-data">Cогласие на обработку персональных данных.</label>
	</div>
	<div class="form-check">
		<input type="checkbox" class="form-check-input" id="agreement-third-party">
		<label class="form-check-label" for="agreement-third-party">Cогласие на то, что достоверность указанных данных будет проверяться третьими лицами.</label>
	</div>
	<div class="form-check">
		<input type="checkbox" class="form-check-input" id="agreement-comments">
		<label class="form-check-label" for="agreement-comments">Cогласие на комментирование со стороны транспортных компаний.</label>
	</div>
	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'method' => 'post']) ?>
</div>
