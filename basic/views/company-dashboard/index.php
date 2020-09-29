<?php

use yii\bootstrap\Tabs;
use yii\bootstrap\Modal;

$this->title = 'Личный кабинет транспортной компании';
?>
<div class="">
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
</script>