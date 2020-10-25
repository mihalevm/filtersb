<?php    
	use yii\helpers\Html;
	use kartik\date\DatePicker;
	use yii\bootstrap\ActiveForm;

	$form = ActiveForm::begin([
		'id' => 'driver-previous-work',
		'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>",
            'labelOptions' => ['class' => 'col-lg-6 col-lg-offset-1 control-label'],
		],        
	]);

	// $worksList;
?>
<br>
<div class="driver-previous-work-content">

	<?= $form->errorSummary($model) ?>

	<?= $form->field($model, 'workplaceList')->dropDownList([
		'0' => 'Первое место работы',
		'1' => 'Второе место работы',
		'2' => 'Третье место работы'])->label('Выберите место работы:') ?>

	<?= $form->field($model, 'selectedWorkId')->hiddenInput(['value' => ($profile != null) ? $profile['id'] : '0'])->label(false) ?>

	<?= $form->field($model, 'workStartDate')->widget(DatePicker::classname(), [		
		'type' => DatePicker::TYPE_INPUT,		 
		'options' => ['value' =>  ($profile != null) ? $profile['sdate'] : '', 'placeholder' => '23.02.1982'],
		'pluginOptions' => [
			'autoclose' => true,
			'format' => 'dd.mm.yyyy'
		]
	])->label('Дата приема на работу*:') ?>	
	
	<?= $form->field($model, 'workEndDate')->widget(DatePicker::classname(), [		
		'type' => DatePicker::TYPE_INPUT,
		'options' => ['value' =>  ($profile != null) ? $profile['edate'] : '', 'placeholder' => '23.02.1982'],
		'pluginOptions' => [
			'autoclose' => true,
			'format' => 'dd.mm.yyyy'
		]
	])->label('Дата увольнения с работы*:') ?>

	<?= $form->field($model, 'company')->textInput(['value' => ($profile != null) ? $profile['company'] : '',])->label('Название организации') ?>
	<?= $form->field($model, 'post')->textInput(['value' => ($profile != null) ? $profile['post'] : '',])->label('Должность') ?>
	<?= $form->field($model, 'action')->textarea(['value' => ($profile != null) ? $profile['action'] : '', 'rows' => '5'] )->label('Содержание деятельности') ?>
	<br>
	<br>
	<br>
	<br>
	<?= $form->field($model, 'dismissal')->textInput(['value' => ($profile != null) ? $profile['dismissal'] : '',])->label('Причина увольнения') ?>
	<?= $form->field($model, 'guarantor')->textarea(['value' => ($profile != null) ? $profile['guarantor'] : '', 'rows' => '10'] )->label('Кто может дать рекомендации с даннного места
	работы (ФИО, контакт для связи)') ?>
	<br>
	<br>
	<br>
	<br>
	<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary pull-right mr-12 mt-10', 'method' => 'post']) ?>

	<?php ActiveForm::end(); ?>
</div>

<script language="JavaScript">
	document.addEventListener('DOMContentLoaded', function() {
		// Preloading data 
		const hidden = $("div[class='form-group field-driverprofileworkplaceform-selectedworkid required']");
		hidden.removeClass("form-group field-driverprofileworkplaceform-selectedworkid required");
		hidden.children().removeClass();
		const worksList = $("#driverprofileworkplaceform-workplacelist");
		const workStartDate = $("#driverprofileworkplaceform-workstartdate");
		const workEndDate = $("#driverprofileworkplaceform-workenddate");
		const company = $("#driverprofileworkplaceform-company");
		const post = $("#driverprofileworkplaceform-post");
		const action = $("#driverprofileworkplaceform-action");
		const dismissal = $("#driverprofileworkplaceform-dismissal");
		const guarantor = $("#driverprofileworkplaceform-guarantor");
		const selectedWorkId = $("#driverprofileworkplaceform-selectedworkid");

		function clearValues() {
			selectedWorkId.val('0');
			workStartDate.val('');
			workEndDate.val(''); 
			company.val('');
			post.val('');
			action.val('');
			dismissal.val('');
			guarantor.val('');
		}

		worksList.change(function(e) {
			if ((worksList.val() != null)) { 
				$.ajax({
					url: "/driver-profile/previous-works-list",
					data: {
						id: worksList.val(),
					},
					method: "GET",						
				}).done(function(data) {								
					const selectedWork = worksList.val();
					if(data != null) {
						if (data[selectedWork] != undefined) {
							selectedWorkId.val(data[selectedWork].id);
							workStartDate.val(data[selectedWork].sdate);
							workEndDate.val(data[selectedWork].edate); 
							company.val(data[selectedWork].company);
							post.val(data[selectedWork].post);
							action.val(data[selectedWork].action);
							dismissal.val(data[selectedWork].dismissal);
							guarantor.val(data[selectedWork].guarantor);
						} else {
							clearValues();
						}						
					} else {
						clearValues();
					}
				}).fail(function(data) {
					console.log("Во время загрузки произошла ошибка!");
				});
			}		
		});
	});
</script>
