<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center">
<?php
    if (intval($result) > 0) {
        echo "Данные из базы ГИБДД получены.";
    } else {
        echo $result;
    }
?>
            </h4>
        </div>
    </div>
    <div class="row control-tools">
        <div class="col-md-12">
<?php
    if (intval($result) > 0) {
?>
        <button type="button" class="btn btn-primary pull-right" onclick="nexStep()">Далее</button>
<?php
    } else {
?>
        <button type="button" class="btn btn-primary pull-right" onclick="repeatStep()">Повторить</button>
<?php
    }
?>
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