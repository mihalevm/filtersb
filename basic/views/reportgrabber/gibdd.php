<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 text-center">
<?php
    if (intval($result) > 0) {
        echo '<h4>Данные из базы ГИБДД получены.</h4><br/>Нажмите кнопку "Далее" для формирования отчета.';
    } else {
        echo $result;
    }
?>
        </div>
    </div>
    <div class="row control-tools">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary pull-right" style="display:<?= intval($result) > 0?'block':'none' ?>" id="nextStep" onclick="nexStep()">Далее</button>
            <button type="button" class="btn btn-primary pull-right" style="display:<?= intval($result) == 0?'block':'none' ?>" id="skipStep" onclick="nexStep()">Пропустить</button>
            <button type="button" class="btn btn-primary pull-right mr-12" style="display:<?= intval($result) == 0?'block':'none' ?>" id="repeatStep" onclick="repeatStep()">Повторить</button>
        </div>
    </div>
</div>

<script language="JavaScript">
    function repeatStep() {
        $('#rep-engine-content').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.post(window.location.origin + '/reportgrabber', {
            s: 'G',
            did:$('#drv-item-'+$('#property-driver').data('did')).data('did'),
            rid:<?=$rid?>
        }, function (data) {
            $('#rep-engine-content').html(data);
        });
    }

    function nexStep() {
        $('#rep-engine-content').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.post(window.location.origin + '/reportgrabber', {
            s: 'finish',
            did:$('#drv-item-'+$('#property-driver').data('did')).data('did'),
            rid:<?=$rid?>
        }, function (data) {
            $('#rep-engine-content').html(data);
        });
    }
</script>