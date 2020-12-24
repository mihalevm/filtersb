<?php
use yii\widgets\Pjax;
use yii\helpers\Html;
use rmrevin\yii\fontawesome\FAS;

?>
<br>
<?php if ($dinfo['agreecomment'] == 'Y') { ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4>Оставьте отзыв</h4><hr>
        </div>
        <div class="col-lg-12">
            <div class="input-group">
                <div class="input-group-btn">
                    <button id="rait_up" class="btn btn-default" type="button" title="Положительно" onclick="setComentRait(1)"><?=FAS::icon('thumbs-up')?></button>
                    <button id="rait_down" class="btn btn-default" type="button" title="Отрицательно" onclick="setComentRait(-1)"><?=FAS::icon('thumbs-down')?></button>
                </div>
                <input id="coment_text" type="text" class="form-control text-left" placeholder="Текст отзыва">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" onclick="saveComent()"><?=FAS::icon('sign-in-alt')?></button>
                </span>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <?php
            Pjax::begin(['id' => 'coments_list', 'timeout' => 1000000, 'enablePushState' => false, 'clientOptions' => ['method' => 'GET', 'backdrop' => false]]);

            echo \yii\grid\GridView::widget([
                'dataProvider' => $coments,
                'layout' => "{items}<div align='right'>{pager}</div>",
                'options' => ['data-pjax' => true ],
                'rowOptions' => function ($model, $key, $index, $grid) {
                    return [
                        'class' => 'driver-item',
                    ];
                },
                'columns' => [
                    [
                        'format' => 'ntext',
                        'attribute'=>'cdate',
                        'label'=>'Дата',
                        'headerOptions' => ['style' => 'width:150px'],
                    ],
                    [
                        'format' => 'raw',
                        'label'=>'Оценка',
                        'headerOptions' => ['style' => 'width:80px'],
                        'value' => function($data){
                            $content = '';

                            if ($data['cid'] == Yii::$app->user->identity->id){
                                $content = Html::dropDownList('rait_status', $data['rait'], [-1 => '', 1 => '', 0 => ''], ['onchange' => 'change_rait(this, '.$data['id'].')']);
                            } else {
                                if ( $data['rait'] ==  0 ) {$content = FAS::icon('question-circle');};
                                if ( $data['rait'] ==  1 ) {$content = FAS::icon('thumbs-up');};
                                if ( $data['rait'] == -1 ) {$content = FAS::icon('thumbs-down');};
                            }

                            return $content;
                        }
                    ],
                    [
                        'format' => 'ntext',
                        'attribute'=>'coment',
                        'label'=>'Текст отзыва',
                    ],
                ],
            ]);

            Pjax::end();
            ?>
        </div>
    </div>
</div>
<?php } else { ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center">Коментарии отключены пользователем</h4><hr>
        </div>
    </div>
</div>
<?php }; ?>
<script language="JavaScript">
    if (typeof coment_rait === 'undefined') {
        var coment_rait = 0;
    }

    $('#coments_list').find('.pagination:first').find('a').click(function (e) {
        e.preventDefault();
        $.get(
            $(this).attr("href"),
            {},
            function (data) {
                $('#property-driver-modal-tab2').html(data);
            }
        );
    });

    function setComentRait(v) {
        coment_rait = v;

        if (v == 1) {
            $('#rait_up').addClass('rait-up');
            $('#rait_down').removeClass('rait-down');
        } else {
            $('#rait_up').removeClass('rait-up');
            $('#rait_down').addClass('rait-down');
        }
    };

    function saveComent() {
        // console.log('Save coment:'+$('#coment_text').val());
        // console.log('Coment rait:'+coment_rait);
        $.post(
            window.location+'/savecoment',
            {did:<?=$dinfo['id']?>, r:coment_rait, t:$('#coment_text').val()},
            function (data) {
                $.get(
                    window.location.href+'/getdrivercoments',
                    { id : $('#property-driver').data('did') },
                    function (data) {
                        $('#property-driver-modal-tab2').html(data);
                    }
                );
            }
        ).always(function () {
            coment_rait = 0;
        });
    }

    function change_rait(o, id) {
        $.post(
            window.location+'/saverait',
            {id: id, v:$(o).val()}
        );
    }
</script>