<?php
use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FAS;
use yii\bootstrap\Modal;
use yii\helpers\Html;
?>

<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary pull-right" onclick="sendNewRequest()">Отправить запрос</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-12">
            <h4>Запросы на трудоустройство в компании</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            Pjax::begin(['id' => 'request_list', 'timeout' => 1000000, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET', 'backdrop' => false]]);

            echo \yii\grid\GridView::widget([
            'dataProvider' => $request,
            'layout' => "{items}<div align='right'>{pager}</div>",
            'options' => ['data-pjax' => true ],
            'rowOptions' => function ($model, $key, $index, $grid) {
                return [
                    'id' => 'rep-item-' . $model['id'],
                    'class' => 'driver-item',
                ];
            },
                'columns' => [
                    [
                        'format' => 'raw',
                        'label'  =>'№',
                        'value'  => function ($data, $row) {
                            return $row+1;
                        }
                    ],
                    [
                        'format' => 'ntext',
                        'attribute'=>'rdate',
                        'label'=>'Дата запроса',
                    ],
                    [
                        'format' => 'ntext',
                        'attribute'=>'companyname',
                        'label'=>'Компания',
                    ],
                    [
                        'format' => 'raw',
                        'label'=>'Статус',
                        'value' => function($data){
                            return $data['reqby'] == 'T' ? 'Принят': 'Запрошено';
                        }
                    ],
                    [
                        'label' => 'Действие',
                        'format' => 'raw',
                        'value' => function($data){
                            return '<div onclick="event.stopPropagation();deleteRequest('.$data['id'].')"  title="Удалить запрос на трудоустройство">'.FAS::icon('trash').'</div>';
                        }
                    ],
                ],
            ]);

            Pjax::end();
            ?>
        </div>
    </div>
</div>

<?php
Modal::begin([
    'header' => '<b>Запрос на трудоустройство</b>',
    'id' => 'drequest',
    'size' => 'modal-lg',
]);
?>

<div class='modalContent'>
    <div class="row">
        <div class="col-md-12" id="rep-drv-name">Выберите компании из списка</div>
    </div>
    <div class="row">
        <div class="col-md-12"><hr></div>
    </div>
    <div class="row">
        <div class="col-md-10 col-md-offset-2" id="select_company_list">
        <?php
        Pjax::begin(['id' => 'company_list', 'timeout' => 1000000, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET', 'backdrop' => false]]);

        if (count($companyList)){
            echo Html::checkboxList('companys', [], $companyList, ['separator' => '<br>']);
        } else {
            echo "Список компаний пуст";
        }

        Pjax::end();
        ?>
        </div>
    </div>
    <div class="row control-tools">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary pull-right" onclick="selectCompany()">Подать заявку</button>
        </div>
    </div>
</div>

<?php Modal::end();?>

<script language="JavaScript">
    // document.addEventListener('DOMContentLoaded', function() {
    //     $('#drequest').on('shown.bs.modal', function() {
    //     });
    //
    //     $('#drequest').on('hidden.bs.modal', function () {
    //     });
    // });

    function deleteRequest(id) {
        $.get(window.location.href+'/deleterequest', {rid:id}, function (data) {
            console.log(data);
        }).always(function () {
            $.pjax.reload({container: "#request_list", timeout: 100000});
        });
    }

    function sendNewRequest() {
        $('#company_list').empty();
        $.pjax.reload({container: "#company_list", timeout: 100000});
        $('#drequest').find('.modal-dialog:first').css('width','400');
        $('.modal-content').css('height','700');
        $('#drequest').modal('show');
    }

    function selectCompany() {
        selectedCompany = '';

        $('#select_company_list input:checked').each(function () {
            selectedCompany = selectedCompany+$(this).val()+',';
        }).promise().done(function () {
            selectedCompany = selectedCompany.slice(0, -1);
            if (selectedCompany.length > 0) {
                $.get(window.location.href+'/selectcompany', {sc:selectedCompany}, function (data) {
                    console.log(data);
                }).always(function () {
                    $.pjax.reload({container: "#request_list", timeout: 100000});
                    $('#drequest').modal('hide');
                })
            }
        });
    }
</script>