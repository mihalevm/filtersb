<?php

use yii\bootstrap\Tabs;
use yii\bootstrap\Modal;

$this->title = 'Личный кабинет транспортной компании';
?>
<div>
<?php
    echo Tabs::widget([
    'items' => [
        [
            'label' => 'Мои Анкеты',
            'content' => $sdrivers,
            'active' => true,
            'options' =>['id' => 'my-drivers'],
        ],
        [
            'label' => 'Анкеты желающих',
            'content' => $rdrivers,
            'options' =>['id' => 'req-drivers'],
        ],
    ],
]);
?>
</div>

<?php
Modal::begin([
    'header' => '<b>Подробно о водителе</b>',
    'id' => 'property-driver',
    'size' => 'modal-lg',
]);
?>

<div class='modalContent'>
    <?php
    echo Tabs::widget([
        'options' => [
            'id' => 'property-driver-modal',
        ],
        'items' => [
            [
                'label'  => 'О водителе',
                'active' => true
            ],
            [
                'label' => 'Анкета',
            ],
            [
                'label' => 'Отзывы',
            ],
        ],
    ]);
    ?>
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
    });

    function getDriverReports() {
        $('#property-driver-modal a:first').tab('show');
        $('#property-driver-modal-tab0').tab('show');
        $('#property-driver-modal-tab0').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.get(
            window.location.href+'/getdriverreport',
            { id : $('#property-driver').data('did') },
            function (data) {
                $('#property-driver-modal-tab0').html(data);
            }
        )
    }

    function getDriverInfo() {
        $('#property-driver-modal-tab1').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.get(
            window.location.href+'/getdriverinfo',
            { id : $('#property-driver').data('did') },
            function (data) {
                $('#property-driver-modal-tab1').html(data);
            }
        )
    }

    function getDriverComents() {
        $('#property-driver-modal-tab2').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
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
/*
    function getDriverReports() {
        $('#property-driver-modal-tab0').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.get(
            window.location.href+'/getdriverreport',
            { id : $('#property-driver').data('did') },
            function (data) {
                $('#property-driver-modal-tab0').html(data);
            }
        )
    }

    function getDriverInfo() {
        $('#property-driver-modal-tab1').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.get(
            window.location.href+'/getdriverinfo',
            { id : $('#property-driver').data('did') },
            function (data) {
                $('#property-driver-modal-tab1').html(data);
            }
        )
    }

    function getDriverComents() {
        $('#property-driver-modal-tab2').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
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
*/
</script>