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
                'active' => true
            ],
            [
                'label' => 'Дополнительная информация',
                'content' => $driverInfoExtended,
            ],
        ],
    ]);
?>
