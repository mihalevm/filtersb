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
	<p>
		<a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
			Первое место работы
		</a>
	</p>
	<div class="collapse" id="collapseExample">
		<div class="card card-body">
		<?php
			echo '<label class="control-label">Дата приёма и увольнения</label>';
			echo DatePicker::widget([
				'language' => 'ru',
				'name' => 'work-1-employment-date',
				'value' => '',
				'options' => ['placeholder' => '23.02.1982'],
				'type' => DatePicker::TYPE_RANGE,
				'name2' => 'work-1-quit-date',
				'value2' => '',
				'options2' => ['placeholder' => '26.02.1982'],
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
		</div>
	</div><br>
	<p>
		<a class="btn btn-primary" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
			Второе место работы
		</a>
	</p>
	<div class="collapse" id="collapseExample2">
		<div class="card card-body">
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
		</div>                       
	</div><br>
	<p>
		<a class="btn btn-primary" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample">
			Третье место работы
		</a>
	</p>
	<div class="collapse" id="collapseExample3">
		<div class="card card-body">
			<?php
				echo '<label class="control-label">Дата приёма и увольнения</label>';
				echo DatePicker::widget([
					'language' => 'ru',
					'name' => 'work-3-employment-date',
					'value' => '',
					'options' => ['placeholder' => '23.02.1982'],
					'type' => DatePicker::TYPE_RANGE,
					'name2' => 'work-3-quit-date',
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
			</div></div><br>

	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'method' => 'post']) ?>
	<?php ActiveForm::end(); ?>
</div>
