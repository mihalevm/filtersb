<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 23.09.20
 * Time: 17:51
 */
//use rmrevin\yii\fontawesome\FA;
//use yii\bootstrap\Modal;
//use yii\helpers\Html;
//use yii\bootstrap\ActiveForm;
//use kartik\date\DatePicker;
use yii\widgets\Pjax;

?>
<br>

<button type="button" class="btn btn-primary pull-right mb-30" onclick="refreshRDrivers()">Обновить</button>
<?php
Pjax::begin(['id' => 'rdrivers_list', 'timeout' => false, 'enablePushState' => false, 'clientOptions' => ['method' => 'POST']]);

echo \yii\grid\GridView::widget([
    'dataProvider' => $drivers,
    'layout' => "{items}<div align='right'>{pager}</div>",
    'rowOptions' => function ($model, $key, $index, $grid) {
        return [
            'id'              => 'rdrv-item-'.$model['id'],
            'class'           => 'driver-item',
            'data-id'         => $model['id'],
            'data-username'   => $model['username'],
            'data-inn'        => $model['inn'],
            'data-firstname'  => $model['firstname'],
            'data-secondname' => $model['secondname'],
            'data-middlename' => $model['middlename'],
            'data-birthday'   => $model['birthday'],
            'data-pserial'    => $model['pserial'],
            'data-pnumber'    => $model['pnumber'],
            'data-dserial'    => $model['dserial'],
            'data-dnumber'    => $model['dnumber'],
            'onclick'         => 'showDialogPropertyDriver(this);',
            ];
    },
    'columns' => [
        [
            'format' => 'ntext',
            'attribute'=>'firstname',
            'label'=>'Имя',
        ],
        [
            'format' => 'ntext',
            'attribute'=>'secondname',
            'label'=>'Фамилия',
        ],
        [
            'format' => 'ntext',
            'attribute'=>'middlename',
            'label'=>'Отчество',
        ],
        [
            'format' => 'ntext',
            'attribute'=>'birthday',
            'label'=>'Дата рождения',
        ],
        [
            'label' => 'Трудоустроен',
            'format' => 'raw',
            'value' => function($data){
                return '<div>'.($data['cnt'] == 0 ? 'Нет':'Да').'</div>';
            }
        ],

    ],
]);
Pjax::end();
?>

<script language="JavaScript">
    function refreshRDrivers() {
        $.pjax.reload({container: "#rdrivers_list", timeout: 2e3});
    }

    document.addEventListener('DOMContentLoaded', function() {
        $("[href='#req-drivers']").click(function () {
            $.pjax.reload({container: "#rdrivers_list", timeout: 2e3});
        });
    });
</script>
