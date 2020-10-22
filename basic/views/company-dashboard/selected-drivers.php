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
            'format' => 'ntext',
            'attribute'=>'firstname',
            'label'=>'Имя',
        ],
        [
            'format' => 'ntext',
            'attribute'=>'secondname',
            'label'=>'Фамилия',
        ],
        [
            'format' => 'ntext',
            'attribute'=>'middlename',
            'label'=>'Отчество',
        ],
        [
            'format' => 'ntext',
            'attribute'=>'birthday',
            'label'=>'Дата рождения',
        ],
        [
            'label' => 'Трудоустроен',
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
            'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>",
            'labelOptions' => ['class' => 'col-lg-5 control-label'],
        ],
    ]); ?>
    <?= $form->errorSummary($model) ?>
<div name="driver-item-tab-1">
    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'phone')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9-999-999-9999'])->label('Номер телефона<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'firstname')->textInput()->label('Имя<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'secondname')->textInput()->label('Фамилия<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'middlename')->textInput()->label('Отчество<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'bdate')->widget(DatePicker::classname(), ['type' => DatePicker::TYPE_INPUT, 'pluginOptions' => ['autoclose'=>true]])->label('Дата рождения<span class="field-required">*</span>'); ?>

    <?= $form->field($model, 'inn')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999999999'])->label('ИНН<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'pdate')->widget(DatePicker::classname(), ['type' => DatePicker::TYPE_INPUT, 'pluginOptions' => ['autoclose'=>true]])->label('Дата выдачи паспорта<span class="field-required">*</span>'); ?>

    <?= $form->field($model, 'pserial')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999'])->label('Серия паспорта<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'pnumber')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999'])->label('Номер паспорта<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'dserial')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999'])->label('Серия водительского<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'dnumber')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999'])->label('Номер водительского<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'ddate')->widget(DatePicker::classname(), ['type' => DatePicker::TYPE_INPUT, 'pluginOptions' => ['autoclose'=>true]])->label('Дата выдачи водительского<span class="field-required">*</span>'); ?>

    <div class="form-group">
        <div class="col-lg-offset-9 col-lg-10">
            <span class="label label-info fake-bnt" onclick="nextDriverParams()">Далее</span>
        </div>
    </div>
</div>

<div name="driver-item-tab-2" style="display: none">
    <div class="separator">Адрес регистрации</div>
    <?= $form->field($model, 'rpostzip')->textInput()->label('Почтовый индекс') ?>

    <?= $form->field($model, 'rregion')->textInput()->label('Область/край<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'rcity')->textInput()->label('Город<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'rstreet')->textInput()->label('Улица<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'rhouse')->textInput()->label('Дом') ?>

    <?= $form->field($model, 'rbuild')->textInput()->label('Строение') ?>

    <?= $form->field($model, 'rflat')->textInput()->label('Квартира') ?>

    <div class="separator">Адрес проживания</div>
    <?= $form->field($model, 'dup_address')->widget(SwitchInput::classname(), ['pluginEvents'=>["switchChange.bootstrapSwitch" => 'function(){duplicateAddress(this)}'] ,'pluginOptions' => ['size' => 'mini', 'onText' => 'Да', 'offText' => 'Нет',], 'options' => ['class' => 'pull-right']])->label('Адреса совпадают') ?>

    <div class="living-address">
    <?= $form->field($model, 'lpostzip')->textInput()->label('Почтовый индекс') ?>

    <?= $form->field($model, 'lregion')->textInput()->label('Область/край<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'lcity')->textInput()->label('Город<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'lstreet')->textInput()->label('Улица<span class="field-required">*</span>') ?>

    <?= $form->field($model, 'lhouse')->textInput()->label('Дом') ?>

    <?= $form->field($model, 'lbuild')->textInput()->label('Строение') ?>

    <?= $form->field($model, 'lflat')->textInput()->label('Квартира') ?>
    </div>
    <div class="form-group">
        <div class="col-lg-offset-8 col-lg-10">
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
        $("[href*='property-driver-modal-tab']").on('shown.bs.tab', function (e) {
            var t = $(e.target).attr("href")
            if (t === '#property-driver-modal-tab0') {
                getDriverReports();
            }
            if (t === '#property-driver-modal-tab1') {
                getDriverInfo();
            }
            if (t === '#property-driver-modal-tab2') {
                getDriverComents();
            }
        });

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
            }, function (data) {
                $('#rep-engine-content').html(data);
            });
        });
    });

    function duplicateAddress(o) {
        if ($(o).prop('checked')) {
            $('.living-address').hide();
        } else {
            $('.living-address').show();
        }
    }

    function getDriverReports() {
        $('#property-driver-modal-tab0').html('');
        $.get(
            window.location.href+'/getdriverreport',
            { id : $('#property-driver').data('did') },
            function (data) {
                $('#property-driver-modal-tab0').html(data);
            }
        )
    }

    function getDriverInfo() {
        $('#property-driver-modal-tab1').html('');
        $.get(
            window.location.href+'/getdriverinfo',
            { id : $('#property-driver').data('did') },
            function (data) {
                $('#property-driver-modal-tab1').html(data);
            }
        )
    }

    function getDriverComents() {
        $('#property-driver-modal-tab2').html('');
        $.get(
            window.location.href+'/getdrivercoments',
            { id : $('#property-driver').data('did') },
            function (data) {
                $('#property-driver-modal-tab2').html(data);
            }
        )
    }

    function showDialogPropertyDriver(o) {
        $('#property-driver').data('did', $(o).data('id'));
        getDriverReports();
        $('.modal-content').css('height', 600);
        $('#property-driver').modal('show');

    }

    function showDialogDeleteDriver(i) {
        $('#delete-driver-label').text($('#drv-item-'+i).data('firstname')+' '+$('#drv-item-'+i).data('secondname')+' '+$('#drv-item-'+i).data('middlename'));
        $('#delete-driver-label').data('drv', i);
        $('.modal-content').css('height',180);
        $('#delete-driver').modal('show');

        return false;
    }

    function deleteDriver() {
        if ( parseInt($('#delete-driver-label').data('drv')) > 0 ) {
            $.post(window.location.href + '/deletedriver', {
                id: $('#delete-driver-label').data('drv'),
            }, function (data) {
                $('#delete-driver').modal('hide');
                $.pjax.reload({container: "#drivers_list", timeout: 2e3});
            });
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
