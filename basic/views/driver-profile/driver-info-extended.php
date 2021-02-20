<?php
	use yii\helpers\Html;
	use kartik\date\DatePicker;
	use yii\bootstrap\ActiveForm;
	use dosamigos\multiselect\MultiSelect;
	use kartik\select2\Select2;

	$form = ActiveForm::begin([
		'id' => 'driver-info-extended',
		'fieldConfig' => [
            'template'     => '{label}<div class="col-lg-6 col-sm-12 component-correction">{input}</div>',
            'labelOptions' => ['class' => 'col-lg-6 col-sm-1 control-label text-nowrap company-font-color3'],
		], 
	]);	
?>
<br>
<div class="driver-info-extended-content">

	<?= $form->errorSummary($model) ?>

    <?= $form->field($model, 'mainNumber')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+9-999-999-9999', 'options' => ['placeholder' => '+79998884411', 'value'=>$profile['personalphone']]])->label('Контактный телефон<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'relativesNumbers')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+9-999-999-9999, +9-999-999-9999', 'options' => ['placeholder' => '+79998884411, +79998884411', 'value'=>$profile['relphones']]])->label('Телефоны родственников (2 человека)<span class="field-required">*</span>') ?>

	<?= $form->field($model, 'familyStatus')->dropDownList(
		['N' => 'Холост', 'Y' => 'В браке'], 
		['value' => $profile['familystatus']])->label('Семейное положение<span class="field-required">*</span>') ?>

	<?= $form->field($model, 'childs')->textarea(['value' => $profile['childs'], 'rows' => '5'] )->label('Дети, пол и возраст<span class="field-required">*</span>') ?>
		<br>
		<br>
		<br>
		<br>
    <?= $form->field($model, 'categoryC')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '99', 'options' => ['placeholder' => '10', 'value'=>$profile['c_experience']]])->label('Стаж вождения именно по категории “С” (лет)<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'categoryE')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '99', 'options' => ['placeholder' => '10', 'value'=>$profile['e_experience']]])->label('Стаж вождения именно по категории “Е” (лет)<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'tachograph')->widget(Select2::classname(), [
        'data'  => array_merge($dic_tachograph, $profile['tachograph']),
        'maintainOrder' => true,
        'options' => [
            'multiple' => true,
            'value' => $profile['tachograph'],
        ],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ])->label('Перечислите имеющиеся карты тахографа<span class="field-required">*</span><br/><span class="help-notification">Напишите свой вариант и нажмите Enter</span>'); ?>

    <?= $form->field($model, 'companyset')->widget(MultiSelect::className(),[
        'data'    => $companyList,
        'options' => [
                'value'   => explode(',',$profile['companyset']),
                'multiple' => 'multiple'
        ],
        'clientOptions' => [
            'nonSelectedText' => 'Ничего не выбрано',
            'allSelectedText' => 'Выбраны все варианты',
            'nSelectedText'   => 'Выбрано несколько вариантов',
            'buttonWidth'     => '100%',
            'buttonContainer' => '<div class="btn-group bnt-container"/>',
        ],
    ])->label('Предпочитаемые места работы') ?>

	<?= $form->field($model, 'marks')->textarea(['value' => $profile['transporttype'], 'rows' => '5'] )
        ->label('Перечислите марки ТС которыми управляли<span class="field-required">*</span>') ?>
		<br>
		<br>
		<br>
		<br>

    <?= $form->field($model, 'trailertype')->widget(Select2::classname(), [
        'data'  => array_merge($dic_trailertype, $profile['trailertype']),
        'maintainOrder' => true,
        'options' => [
            'multiple' => true,
            'value'    => $profile['trailertype'],
        ],
        'pluginOptions' => [
            'tags' => true,
            'tokenSeparators' => [',', ' '],
            'maximumInputLength' => 10
        ],
    ])->label('Перечислите типы прицепов которыми управляли<span class="field-required">*</span><br/><span class="help-notification">Напишите свой вариант и нажмите Enter</span>'); ?>

	<?= $form->field($model, 'interPassportExpireDate')->widget(DatePicker::classname(), [
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
		'options' => [
		    'value' => $profile['fpassdate'],
            'placeholder' => 'Нет',
        ],
		'pluginOptions' => [
			'autoclose' => true,
			'format' => 'dd.mm.yyyy'
		]
	])->label('Дата окончания загран.паспорта') ?>

	<?= $form->field($model, 'medCard')->dropDownList(['0' => 'Нет', '1' => 'Да'])->label('Наличие действующей медицинской книжки<span class="field-required">*</span>') ?>

	<?= $form->field($model, 'startDate')->widget(DatePicker::classname(), [		
		'type' => DatePicker::TYPE_INPUT,		
		'options' => ['value' => $profile['startdate'], 'placeholder' => '23.02.1982'],
		'pluginOptions' => [
			'autoclose' => true,
			'format' => 'dd.mm.yyyy'
		]
	])->label('Когда вы готовы приступить к работе<span class="field-required">*</span>') ?>
	
	<?= $form->field($model, 'flyInAccept')->dropDownList(['0' => 'Нет', '1' => 'Да'])->label('Согласна ли ваша семья/близкие родственники работе вахтовым методом<span class="field-required">*</span>') ?>

    <div class="form-group">
        <div class="col-sm-12 col-lg-12 mt-10 pull-right">
            <?= Html::submitButton('Далее', ['class' => 'btn btn-primary pull-right', 'name' => 'driver-info-extended-save', 'method' => 'post']) ?>
            <span class="label label-info fake-bnt mr-10 pull-right" onclick="goHome()">На главную</span>
        </div>
    </div>

	<?php ActiveForm::end(); ?>
</div>


<script language="JavaScript">
	document.addEventListener('DOMContentLoaded', function() {
		$( "#driverprofileextendedform-tachograph" ).focus(function(){
			if (this.value == "") {
				$(this).autocomplete("search");
			}
		});
		$( "#driverprofileextendedform-trailertype" ).focus(function(){
			if (this.value == "") {
				$(this).autocomplete("search");
			}
		});
	})
</script>
