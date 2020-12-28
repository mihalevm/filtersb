<?php    
	use yii\helpers\Html;
	use yii\bootstrap\ActiveForm;
    use kartik\switchinput\SwitchInput;
    use yii\widgets\MaskedInput;

	$form = ActiveForm::begin([
		'id' => 'driver-address',
		'fieldConfig' => [
            'template'     => '{label}<div class="col-lg-6 col-sm-12">{input}</div>',
            'labelOptions' => ['class' => 'col-lg-6 col-sm-1 control-label text-nowrap company-font-color3'],
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

    <?= $form->field($model, 'rregion')->textInput(['value'=>($raddress && property_exists($raddress,'region') ? $raddress->region : ''), 'data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Область/край', 'data-content' => 'Укажите только название без слов "Область" или "Край". Например: Московская'])->label('Область/край<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'rcity')->textInput(['value'=>($raddress && property_exists($raddress,'city') ? $raddress->city : ''), 'data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Город/Село', 'data-content' => 'Укажите только название без слов и сокращений "Город" или "г.". Например: Москва'])->label('Город/Село<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'rstreet')->textInput(['value'=>($raddress && property_exists($raddress,'street') ? $raddress->street : ''), 'data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Улица', 'data-content' => 'Укажите только название без слов и сокращений "улица" или "ул.". Например: Садовая'])->label('Улица') ?>

    <?= $form->field($model, 'rhouse')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999', 'options' => ['value'=>($raddress && property_exists($raddress,'house') ? $raddress->house : ''), 'data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Дом', 'data-content' => 'Укажите номер дома без букв и сокращений. Только цифра.'] ])->label('Дом') ?>

    <?= $form->field($model, 'rbuild')->textInput(['value'=>($raddress && property_exists($raddress,'build') ? $raddress->build : '')])->label('Строение') ?>

    <?= $form->field($model, 'rflat')->textInput(['value'=>($raddress && property_exists($raddress,'flat') ? $raddress->flat : '')])->label('Квартира') ?>


    <div class="form-group">
        <div class="col-lg-12 col-sm-12 separator">Адрес проживания</div>
    </div>
    <?= $form->field($model, 'dup_address' )->widget(SwitchInput::classname(), ['pluginEvents'=>["switchChange.bootstrapSwitch" => 'function(){duplicateAddress(this)}'] ,'pluginOptions' => ['size' => 'mini', 'onText' => 'Да', 'offText' => 'Нет',], 'options' => ['class' => 'pull-right']])->label('Адреса совпадают') ?>

    <div class="living-address">
        <?= $form->field($model, 'lpostzip')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999', 'options' => ['placeholder' => '604456', 'value'=>($laddress && property_exists($laddress,'postzip') ? $laddress->postzip : '')]])->label('Почтовый интекс') ?>

        <?= $form->field($model, 'lregion')->textInput(['value'=>($laddress && property_exists($laddress,'region') ? $laddress->region : ''), 'data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Область/край', 'data-content' => 'Укажите только название без слов "Область" или "Край". Например: Московская'])->label('Область/край<span class="field-required">*</span>') ?>

        <?= $form->field($model, 'lcity')->textInput(['value'=>($laddress && property_exists($laddress,'city') ? $laddress->city : ''), 'data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Город/Село', 'data-content' => 'Укажите только название без слов и сокращений "Город" или "г.". Например: Москва'])->label('Город/Село<span class="field-required">*</span>') ?>

        <?= $form->field($model, 'lstreet')->textInput(['value'=>($laddress && property_exists($laddress,'street') ? $laddress->street : ''), 'data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Улица', 'data-content' => 'Укажите только название без слов и сокращений "улица" или "ул.". Например: Садовая'])->label('Улица') ?>

        <?= $form->field($model, 'lhouse')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999', 'options' => ['value'=>($laddress && property_exists($laddress,'house') ? $laddress->house : ''), 'data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Дом', 'data-content' => 'Укажите номер дома без букв и сокращений. Только цифра.'] ])->label('Дом') ?>

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

    document.addEventListener('DOMContentLoaded', function() {
        $(function () {
            $("[data-toggle='popover']").popover();
        });
    });
</script>