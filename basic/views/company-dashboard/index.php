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
            'content' => $sdrivers,
            'active' => true
        ],
        [
            'label' => 'Анкеты желающих',
            'content' => $rdrivers,
        ],
    ],
]);
?>
</div>

<script language="JavaScript">
</script>