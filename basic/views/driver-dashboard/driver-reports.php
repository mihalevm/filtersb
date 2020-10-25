<?php
use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FAS;
use yii\bootstrap\Modal;

?>

<br>
<div class="container-fluid" id="property-driver" data-did="1" data-rid="">
    <div class="row" id="drv-item-1" data-did="<?=Yii::$app->user->identity->id ?>">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary pull-right" onclick="genNewReport()">Новый отчет</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-md-12">
            <h4>Отчеты</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php
            Pjax::begin(['id' => 'reports_list', 'timeout' => 1000000, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET', 'backdrop' => false]]);

            echo \yii\grid\GridView::widget([
            'dataProvider' => $reports,
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
                        'attribute'=>'cdate',
                        'label'=>'Дата формирования',
                    ],
                    [
                        'label' => 'Действие',
                        'format' => 'raw',
                        'value' => function($data) {
                            $download = '<span onclick="event.stopPropagation();downloadReport('.$data['id'].')" title="Скачать отчет">'.FAS::icon('file-download').'</span>';
                            $update   = intval($data['completed']) ? '' : '<span onclick="event.stopPropagation();completeReport('.$data['id'].')"  title="Завершить формирование отчета">'.FAS::icon('cog').'</span>';

                            return $update.'&nbsp;'.$download;
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
        $('#generate-report').on('shown.bs.modal', function() {
            $('#rep-engine-content').html('');
            $.post(window.location.origin + '/reportgrabber', {
                s: 'S',
                did: <?=Yii::$app->user->identity->id ?>,
            }, function (data) {
                $('#rep-engine-content').html(data);
            });
        });

        $('#generate-report').on('hidden.bs.modal', function () {
            $.pjax.reload({container: "#reports_list", timeout: 2e3});
        });
    });

    function genNewReport() {
        $('#property-driver').modal('hide');

        setTimeout(function () {
//            $('#rep-drv-name').text($('#drv-item-'+did).data('firstname')+' '+$('#drv-item-'+did).data('secondname')+' '+$('#drv-item-'+did).data('middlename'));
            $('.modal-content').css('height','700');
            $('#generate-report').modal('show');
        }, 800);
    }

    function downloadReport(id) {
        window.open(window.location.origin + '/reportgrabber/getreport?rid='+id, '_blank');
    }

    function completeReport(id) {
        $('#property-driver').data('rid', id);
        genNewReport();
    }

</script>