<?php    
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use kartik\switchinput\SwitchInput;
    use yii\widgets\MaskedInput;

	$form = ActiveForm::begin([
		'id' => 'driver-address',
		'fieldConfig' => [
            'template'     => '{label}<div class="col-lg-6 col-sm-12">{input}</div>',
            'labelOptions' => ['class' => 'col-lg-6 col-sm-1 control-label text-nowrap'],
		],       
	]);    
    $raddress = json_decode($profile['raddress']);
    $laddress = json_decode($profile['laddress']);
?>
<br>
<div class="driver-address-content">

	<?= $form->errorSummary($model) ?>

    <div class="form-group">
        <div class="separator">Адрес регистрации</div>
    </div>
    <?= $form->field($model, 'rpostzip')->widget(MaskedInput::className(), ['mask' => '999999', 'options' => ['placeholder' => '604456', 'value'=>($raddress && property_exists($raddress,'postzip') ? $raddress->postzip : '')]])->label('Почтовый интекс') ?>

    <?= $form->field($model, 'rregion')->textInput(['value'=>($raddress && property_exists($raddress,'region') ? $raddress->region : '')])->label('Область/край<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'rcity')->textInput(['value'=>($raddress && property_exists($raddress,'city') ? $raddress->city : '')])->label('Город<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'rstreet')->textInput(['value'=>($raddress && property_exists($raddress,'street') ? $raddress->street : '')])->label('Улица<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'rhouse')->textInput(['value'=>($raddress && property_exists($raddress,'house') ? $raddress->house : '')])->label('Дом') ?>

    <?= $form->field($model, 'rbuild')->textInput(['value'=>($raddress && property_exists($raddress,'build') ? $raddress->build : '')])->label('Строение') ?>

    <?= $form->field($model, 'rflat')->textInput(['value'=>($raddress && property_exists($raddress,'flat') ? $raddress->flat : '')])->label('Квартира') ?>


    <div class="form-group">
        <div class="col-lg-12 col-sm-12 separator">Адрес проживания</div>
    </div>
    <?= $form->field($model, 'dup_address' )->widget(SwitchInput::classname(), ['pluginEvents'=>["switchChange.bootstrapSwitch" => 'function(){duplicateAddress(this)}'] ,'pluginOptions' => ['size' => 'mini', 'onText' => 'Да', 'offText' => 'Нет',], 'options' => ['class' => 'pull-right']])->label('Адреса совпадают') ?>

    <div class="living-address">
        <?= $form->field($model, 'lpostzip')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999', 'options' => ['placeholder' => '604456', 'value'=>($laddress && property_exists($laddress,'postzip') ? $laddress->postzip : '')]])->label('Почтовый интекс') ?>

        <?= $form->field($model, 'lregion')->textInput(['value'=>($laddress && property_exists($laddress,'region') ? $laddress->region : '')])->label('Область/край<span class="field-required">*</span>') ?>

        <?= $form->field($model, 'lcity')->textInput(['value'=>($laddress && property_exists($laddress,'city') ? $laddress->city : '')])->label('Город<span class="field-required">*</span>') ?>

        <?= $form->field($model, 'lstreet')->textInput(['value'=>($laddress && property_exists($laddress,'street') ? $laddress->street : '')])->label('Улица<span class="field-required">*</span>') ?>

        <?= $form->field($model, 'lhouse')->textInput(['value'=>($laddress && property_exists($laddress,'house') ? $laddress->house : '')])->label('Дом') ?>

        <?= $form->field($model, 'lbuild')->textInput(['value'=>($laddress && property_exists($laddress,'build') ? $laddress->build : '')])->label('Строение') ?>

        <?= $form->field($model, 'lflat')->textInput(['value'=>($laddress && property_exists($laddress,'flat') ? $laddress->flat : '')])->label('Квартира') ?>
    </div>

    <div class="form-group">
        <div class="col-sm-12 col-lg-12 mt-10 pull-right">
            <?= Html::submitButton('Далее', ['class' => 'btn btn-primary pull-right', 'name' => 'driver-address', 'method' => 'post']) ?>
            <span class="label label-info fake-bnt mr-10 pull-right" onclick="goHome()">На главную</span>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<script language="JavaScript">
    function duplicateAddress(o) {
        if ($(o).prop('checked')) {
            $('.living-address').hide();
        } else {
            $('.living-address').show();
        }
    }
</script>