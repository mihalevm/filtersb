<?php
use yii\bootstrap\Tabs;
use yii\bootstrap\Modal;

$this->title = 'Личный кабинет Водителя';
?>
<br>
<br>
<br>
<div class="">
    <?php
    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Мои Отчеты',
                'content' => $myReports,
                'active' => true,
                'options' =>['id' => 'my-reports'],
            ],
            [
                'label' => 'Запросы на трудоустройство',
                'content' => $myRequest,
                'options' =>['id' => 'my-request'],
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
</script>