<?php

use yii\bootstrap\Tabs;

$this->title = 'Личный кабинет транспортной компании';
?>
<div class="">
<?php
    echo Tabs::widget([
    'items' => [
        [
            'label' => 'Мои Анкеты',
            'content' => 'Список водителей ТК',
            'active' => true
        ],
        [
            'label' => 'Анкеты желающих',
            'content' => 'Список поданных заявок',
        ],
    ],
]);
?>
</div>

<script language="JavaScript">
</script>