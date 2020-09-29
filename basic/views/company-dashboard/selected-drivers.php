<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 23.09.20
 * Time: 17:51
 */
use rmrevin\yii\fontawesome\FA;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\date\DatePicker;
use yii\widgets\Pjax;
use yii\bootstrap\Tabs;

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
            'label'=>'День рождения',
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
<!--    </div>-->
<!--</div>-->

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
        'enableAjaxValidation' => true,
        'layout' => 'horizontal',
        'action' => '/company-dashboard/adddriver',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-6\">{input}</div>",
            'labelOptions' => ['class' => 'col-lg-5 control-label'],
        ],
    ]); ?>
    <?= $form->errorSummary($model) ?>

    <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

    <?= $form->field($model, 'firstname')->textInput()->label('Имя') ?>

    <?= $form->field($model, 'secondname')->textInput()->label('Фамилия') ?>

    <?= $form->field($model, 'middlename')->textInput()->label('Отчество') ?>

    <?= $form->field($model, 'bdate')->widget(DatePicker::classname(), ['type' => DatePicker::TYPE_INPUT, 'pluginOptions' => ['autoclose'=>true]])->label('День рождения'); ?>

    <?= $form->field($model, 'inn')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999999999'])->label('ИНН') ?>

    <?= $form->field($model, 'pserial')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '99999'])->label('Серия паспорта') ?>

    <?= $form->field($model, 'pnumber')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999'])->label('Номер паспорта') ?>

    <?= $form->field($model, 'dserial')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '99999'])->label('Серия водительского') ?>

    <?= $form->field($model, 'dnumber')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '999999'])->label('Номер водительского') ?>

    <div class="form-group">
        <div class="col-lg-offset-8 col-lg-10">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'add-driver-button']) ?>
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
    });

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
        $('.modal-content').css('height',600);
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
</script>
