<?php    
	use yii\helpers\Html;
	use kartik\date\DatePicker;
	use yii\bootstrap\ActiveForm;

	$form = ActiveForm::begin([
		'id' => 'driver-previous-work'       
	]);		
?>
<br>
<div class="driver-previous-work-content">
	<?php
		echo '<label class="control-label">Дата приёма и увольнения</label>';
		echo DatePicker::widget([
			'language' => 'ru',
			'name' => 'work-2-employment-date',
			'value' => '',
			'options' => ['placeholder' => '23.02.1982'],
			'type' => DatePicker::TYPE_RANGE,
			'name2' => 'work-2-quit-date',
			'value2' => '',
			'options2' => ['placeholder' => '23.02.1982'],
			'separator'=>' до ', 
			'pluginOptions' => [
				'autoclose' => true,
				'format' => 'dd.mm.yyyy',                                    
			]
		]);                        
	?><br>
	<label>Название организации</label><input type="text" class="form-control"><br>
	<label>Должность</label><input type="text" class="form-control"><br>
	<label>Содержание деятельности</label><textarea class="form-control" rows="5"></textarea><br>
	<label>Причина увольнения</label><input type="text" class="form-control"><br>
	<label>Кто может дать рекомендации с даннного места работы (ФИО, контакт для связи)</label><textarea class="form-control" rows="10"></textarea>
	<br>	
	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'method' => 'post']) ?>
	<?php ActiveForm::end(); ?>
</div>
