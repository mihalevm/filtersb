<?php

use yii\bootstrap\Tabs;

$this->title = 'Профиль водителя';
?>
<br/>
<?php
    echo Tabs::widget([
        'items' => [
            [
                'label' => 'Общая информация',
                'content' => $driverInfo,
                'active' => ($step == 0),
            ],
            [
                'label' => 'Дополнительная информация',
                'content' => $driverInfoExtended,
                'active' => ($step == 1),
            ],
            [
                'label' => 'Адреса регистрация/проживание',
                'content' => $driverAddress,
                'active' => ($step == 2),
            ],
            [
                'label' => 'Предыдущие места работы',
                'content' => $driverPreviousWork,
                'active' => ($step == 3),
            ],
        ],
    ]);
?>

<script language="JavaScript">
    function goHome() {
        document.location.href = "/";
    };
</script>