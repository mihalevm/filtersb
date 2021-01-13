<?php
use rmrevin\yii\fontawesome\FA;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;
use kartik\date\DatePicker;
use yii\widgets\Pjax;
use kartik\switchinput\SwitchInput;

?>
<br><button type="button" class="btn btn-primary pull-right mb-30" data-toggle="modal" data-target="#edit-driver">Добавить водителя</button>
<?php
Pjax::begin(['id' => 'drivers_list', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]);

echo \yii\grid\GridView::widget([
    'dataProvider' => $drivers,
    'layout' => "{items}<div align='right'>{pager}</div>",
    'rowOptions' => function ($model, $key, $index, $grid) {
        return [
            'id'              => 'drv-item-'.$model['id'],
            'class'           => 'driver-item',
            'data-id'         => $model['id'],
            'data-did'        => $model['did'],
            'data-username'   => $model['username'],
            'data-inn'        => $model['inn'],
            'data-firstname'  => $model['firstname'],
            'data-secondname' => $model['secondname'],
            'data-middlename' => $model['middlename'],
            'data-birthday'   => $model['birthday'],
            'data-pserial'    => $model['pserial'],
            'data-pnumber'    => $model['pnumber'],
            'data-dserial'    => $model['dserial'],
            'data-dnumber'    => $model['dnumber'],
            'onclick'         => 'showDialogPropertyDriver(this);',
        ];
    },
    'columns' => [
        [
            'label' => 'Сотрудник',
            'format' => 'raw',
            'value' => function($data){
                return $data['secondname'].' '.$data['firstname'].' '.$data['middlename'];
            }
        ],
        [
            'format' => 'ntext',
            'attribute'=>'birthday',
            'label'=>'Дата рождения',
        ],
        [
            'label' => 'По совместительству',
            'format' => 'raw',
            'value' => function($data){
                return '<div>'.($data['cnt'] == 0 ? 'Нет':'Да').'</div>';
            }
        ],
        [
            'label' => 'Действие',
            'format' => 'raw',
            'value' => function($data){
                return '<div onclick="event.stopPropagation();showDialogDeleteDriver('.$data['id'].')">'.FA::icon('trash-alt').'</div>';
            }
        ],
    ],
]);
Pjax::end();
?>

<?php
Modal::begin([
    'header' => '<b>Добавление водителя</b>',
    'id' => 'edit-driver',
    'size' => 'modal-md',
    'options' =>[
        'data-backdrop' => 'static',
        'data-keyboard' => 'false'
        ]
]);
?>

<div id='modalContent'>
    <?php $form = ActiveForm::begin([
        'id' => 'add-driver-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'layout' => 'horizontal',
        'action' => '/company-dashboard/adddriver',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-6 col-sm-12\">{input}</div>",
            'labelOptions' => ['class' => 'col-lg-6 col-sm-1 control-label text-nowrap'],
        ],
    ]); ?>
    <?= $form->errorSummary($model) ?>
<div name="driver-item-tab-1">
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '+9-999-999-9999'])->label('Номер телефона<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'secondname')->textInput()->label('Фамилия<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'firstname')->textInput()->label('Имя<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'middlename')->textInput()->label('Отчество<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'bdate')->widget(DatePicker::classname(), ['type' => DatePicker::TYPE_INPUT, 'pluginOptions' => ['autoclose'=>true]])->label('Дата рождения<span class="field-required">*</span>'); ?>

    <?= $form->field($model, 'sex')->dropDownList(['0' => 'Женский', '1' => 'Мужской',], ['options'=>['1'=>['selected'=>true]]])->label('Пол<span class="field-required">*</span>')?>

    <?= $form->field($model, 'inn')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999999999'])->label('ИНН<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'pserial')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999'])->label('Серия паспорта<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'pnumber')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999'])->label('Номер паспорта<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'pdate')->widget(DatePicker::classname(), ['type' => DatePicker::TYPE_INPUT, 'pluginOptions' => ['autoclose'=>true]])->label('Дата выдачи паспорта<span class="field-required">*</span>'); ?>

    <?= $form->field($model, 'dserial')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999'])->label('Серия водительского<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'dnumber')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999'])->label('Номер водительского<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'ddate')->widget(DatePicker::classname(), ['type' => DatePicker::TYPE_INPUT, 'pluginOptions' => ['autoclose'=>true]])->label('Дата выдачи водительского<span class="field-required">*</span>'); ?>

    <div class="form-group">
        <div class="col-sm-offset-10 col-sm-12 col-lg-offset-10 col-lg-12 mt-10">
            <span class="label label-info fake-bnt" onclick="nextDriverParams()">Далее</span>
        </div>
    </div>
</div>

<div name="driver-item-tab-2" style="display: none">
    <div class="form-group">
        <div class="separator">Адрес регистрации</div>
    </div>
    <?= $form->field($model, 'rpostzip')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999'] )->label('Почтовый индекс') ?>

    <?= $form->field($model, 'rregion')->textInput(['data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Область/край', 'data-content' => 'Укажите только название без слов "Область" или "Край". Например: Московская'])->label('Область/край<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'rcity')->textInput(['data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Город/Село', 'data-content' => 'Укажите только название без слов и сокращений "Город" или "г.". Например: Москва'])->label('Город/Село<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'rstreet')->textInput(['data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Улица', 'data-content' => 'Укажите только название без слов и сокращений "улица" или "ул.". Например: Садовая'])->label('Улица') ?>

    <?= $form->field($model, 'rhouse')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999', 'options' => ['data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Дом', 'data-content' => 'Укажите номер дома без букв и сокращений. Только цифра.'] ])->label('Дом') ?>

    <?= $form->field($model, 'rbuild')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999'])->label('Строение') ?>

    <?= $form->field($model, 'rflat')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999'])->label('Квартира') ?>

    <div class="form-group">
        <div class="col-lg-12 col-sm-12 separator">Адрес проживания</div>
    </div>
    <?= $form->field($model, 'dup_address' )->widget(SwitchInput::classname(), ['pluginEvents'=>["switchChange.bootstrapSwitch" => 'function(){duplicateAddress(this)}'] ,'pluginOptions' => ['size' => 'mini', 'onText' => 'Да', 'offText' => 'Нет',], 'options' => ['class' => 'pull-right']])->label('Адреса совпадают') ?>

    <div class="living-address">
    <?= $form->field($model, 'lpostzip')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999'])->label('Почтовый индекс') ?>

    <?= $form->field($model, 'lregion')->textInput(['data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Область/край', 'data-content' => 'Укажите только название без слов "Область" или "Край". Например: Московская'])->label('Область/край<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'lcity')->textInput(['data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Город/Село', 'data-content' => 'Укажите только название без слов и сокращений "Город" или "г.". Например: Москва'])->label('Город/Село<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'lstreet')->textInput(['data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Улица', 'data-content' => 'Укажите только название без слов и сокращений "улица" или "ул.". Например: Садовая'])->label('Улица') ?>

    <?= $form->field($model, 'lhouse')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999', 'options' => ['data-toggle' => 'popover', 'data-placement' => 'top', 'data-trigger' => 'focus', 'title' => 'Дом', 'data-content' => 'Укажите номер дома без букв и сокращений. Только цифра.'] ])->label('Дом') ?>

    <?= $form->field($model, 'lbuild')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999'])->label('Строение') ?>

    <?= $form->field($model, 'lflat')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999'])->label('Квартира') ?>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-8 col-sm-12 col-lg-offset-8 col-lg-10 mt-10">
            <span class="label label-info fake-bnt" onclick="nextDriverParams()">Назад</span>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'add-driver-button']) ?>
        </div>
    </div>
</div>
    <?php ActiveForm::end(); ?>
</div>

<?php Modal::end();?>

<?php
Modal::begin([
    'header' => '<b>Удалить водителя?</b>',
    'id' => 'delete-driver',
    'size' => 'modal-sm',
]);
?>

<div class='modalContent'>
    <br>
    <b><p class="text-center" id="delete-driver-label" data-drv=""></p></b>
    <br>
    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Отмена</button>&nbsp;
    <button type="button" class="btn btn-primary pull-right mr-10" onclick="deleteDriver()">Удалить</button>
</div>

<?php Modal::end();?>

<?php
Modal::begin([
    'header' => '<b>Создание отчета</b>',
    'id' => 'generate-report',
    'size' => 'modal-lg',
    'options' =>[
        'data-backdrop' => 'static',
        'data-keyboard' => 'false'
    ]
]);
?>

<div class='modalContent'>
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12" id="rep-drv-name"></div>
            </div>
        </div>
        <div class="col-md-8">
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"><hr></div>
    </div>
    <div class="row">
        <div class="col-md-12" id="rep-engine-content"></div>
    </div>
</div>

<?php Modal::end();?>


<script language="JavaScript">
    document.addEventListener('DOMContentLoaded', function() {
        $("[href='#my-drivers']").click(function () {
            $.pjax.reload({container: "#drivers_list", timeout: 2e3});
        });

        $('#edit-driver').on('shown.bs.modal', function() {
            $('#add-driver-form').yiiActiveForm('resetForm');
            $('#edit-driver').find('.modal-content').css('height', 'auto');
            nextDriverParams(true);
        });

        $('#generate-report').on('shown.bs.modal', function() {
            $('#rep-engine-content').html('');
            $.post(window.location.origin + '/reportgrabber', {
                s: 'S',
                did: $('#drv-item-'+$('#property-driver').data('did')).data('did'),
                rid: $('#property-driver').data('rid'),
            }, function (data) {
                $('#rep-engine-content').html(data);
            });
        });

        $(function () {
            $("[data-toggle='popover']").popover();
        });
    });

    function duplicateAddress(o) {
        if ($(o).prop('checked')) {
            $('.living-address').hide();
            if (window.innerWidth < 1099) {
                $('div[name="driver-item-tab-2"]').css('height','635');
            }
        } else {
            if (window.innerWidth < 1099) {
                $('div[name="driver-item-tab-2"]').css('height','1050');
            }
            $('.living-address').show();
        }
    }

    function nextDriverParams(start = null) {
        if (null == start) {
            if ($("[name='driver-item-tab-2']").first().css('display') == 'none') {
                $("[name='driver-item-tab-1']").first().hide();
                $("[name='driver-item-tab-2']").first().show();
            } else {
                $("[name='driver-item-tab-2']").first().hide();
                $("[name='driver-item-tab-1']").first().show();
            }
        } else {
            if ($("[name='driver-item-tab-1']").first().css('display') == 'none') {
                $("[name='driver-item-tab-2']").first().hide();
                $("[name='driver-item-tab-1']").first().show();
            }
        }

        return false;
    }
</script>
