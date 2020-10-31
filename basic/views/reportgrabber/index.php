<?php
use yii\helpers\Html;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center lh-15">
                Сейчас будет выполнен поиск информации.<br/>От Вас потребуется введение подтверждающих кодов на отдельных этапах создания отчета.
            </h4>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-12 text-right">
            <?= Html::checkbox('rep-pay', false, [
                'label' => 'Запросить платный отчет',
                'data-toggle'   => 'collapse',
                'data-target'   => '#rep-pay-info',
                'aria-expanded' => 'false',
                'aria-controls' => 'rep-pay-info'
            ]) ?>
            <br/>
            <div class="collapse" id="rep-pay-info">
                <div class="well text-left">
                    <?php
                        if ($payedContent) {
                            echo '<p><b>Внимание! Отчет уже содержит оплаченную часть данных. Вы хотите обновить эти данные?</b></p>';
                        }
                    ?>
                    При запросе платного отчета очень важно правильно заполнить поля профиля сотрудника.<br/>
                    Т.к. при поиске будут сопоставлены указанные Вами данные.<br/>
                    В случае ошибки или не полного заполнения профиля сформированный отчет будет не информативным.<br/>
                    <br/>
                    Стоимость услуги <b><?=($price ? $price.'р.' : 'бесплатно.')?></b> Сначала производится оплата, затем получение отчета.<br/>
                </div>
            </div>
        </div>
    </div>

    <div class="row control-tools">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary pull-right" onclick="nexStep($('input[name=rep-pay]'))">Начать</button>
        </div>
    </div>
</div>

<script language="JavaScript">
    function nexStep(o) {
        $('#rep-engine-content').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');

        if ( $(o).is(':checked') ) {
            $.post(window.location.origin + '/reportgrabber', {
                s: 'prep',
                did: $('#drv-item-'+$('#property-driver').data('did')).data('did'),
                rid: $('#property-driver').data('rid'),
            }, function (data) {
                $('#rep-engine-content').html(data);
            });
        } else {
            $.post(window.location.origin + '/reportgrabber', {
                s: 'E',
                did: $('#drv-item-'+$('#property-driver').data('did')).data('did'),
                rid: $('#property-driver').data('rid'),
            }, function (data) {
                $('#rep-engine-content').html(data);
            });
        }
    }
</script>