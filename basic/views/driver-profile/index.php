<?php

use yii\bootstrap\Tabs;

$this->title = 'Профиль водителя';
?>

<?php
    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Профиль водителя',
                'content' => $driverInfo,
                'active' => ($step == 0),
            ],
            [
                'label' => 'Дополнительная информация',
                'content' => $driverInfoExtended,
                'active' => ($step == 1),
            ],
            [
                'label' => 'Предыдущие места работы',
                'content' => $driverPreviousWork,
                'active' => ($step == 2),
            ],
        ],
    ]);
?>

<script language="JavaScript">
    function goHome() {
        document.location.href = "/";
    };
</script>