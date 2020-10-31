<?php
use yii\widgets\Pjax;
use rmrevin\yii\fontawesome\FAS;
?>

<br>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <div class="row">
                <div class="col-md-12">
                    <?=$dinfo['firstname'].' '.$dinfo['middlename'].' '.$dinfo['secondname']?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <?php if($dinfo['reqby']=='R') { ?>
            <button type="button" class="btn btn-primary pull-right" onclick="DEmployment()">Трудоустроить</button>
            <?php } ?>
            <?php if($dinfo['reqby']=='T') { ?>
            <button type="button" class="btn btn-primary pull-right" onclick="genNewReport()">Новый отчет</button>
            <?php } ?>
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
                        'value' => function($data){
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

<script language="JavaScript">

     $('#reports_list').find('.pagination:first').find('a').click(function (e) {
         e.preventDefault();
         $.get(
             $(this).attr("href"),
             {},
             function (data) {
                 $('#property-driver-modal-tab0').html(data);
             }
         );
     });

    function DEmployment() {
        $.get(
            window.location+'/demployment',
            {id:$('#property-driver').data('did')},
            function (data) {
                refreshRDrivers();
                $('#property-driver').modal('hide');
            }
        );
    }

    function genNewReport() {
        $('#property-driver').data('rid', null);
        redirect_to_Report_Modal();
    }

    function redirect_to_Report_Modal() {
        $('#property-driver').modal('hide');

        var did = $('#property-driver').data('did');

        setTimeout(function () {
            $('#rep-drv-name').text($('#drv-item-'+did).data('firstname')+' '+$('#drv-item-'+did).data('secondname')+' '+$('#drv-item-'+did).data('middlename'));
            $('#generate-report').modal('show');
        }, 800);

    }

    function downloadReport(id) {
        window.open(window.location.origin + '/reportgrabber/getreport?rid='+id, '_blank');
    }

    function completeReport(id) {
        $('#property-driver').data('rid', id);
        redirect_to_Report_Modal();
    }

    function payReport(id) {
        console.log('payReport:'+id);
    }

</script>