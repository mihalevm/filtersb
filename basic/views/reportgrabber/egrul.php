<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center">
<?php
    if (intval($result) > 0) {
        echo "Данные из базы ЕГРЮЛ получены.";
    } else {
        echo $message;
    }
?>
            </h4>
        </div>
    </div>
    <div class="row control-tools">
        <div class="col-md-12">
<?php
    if ($result) {
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
            s: 'E',
            did:$('#drv-item-'+$('#property-driver').data('did')).data('did'),
            rid:<?=$result?>
        }, function (data) {
            $('#rep-engine-content').html(data);
        });
    }

    function nexStep() {
        $('#rep-engine-content').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.post(window.location.origin + '/reportgrabber', {
            s: 'F',
            did:$('#drv-item-'+$('#property-driver').data('did')).data('did'),
            rid:<?=$result?>
        }, function (data) {
            $('#rep-engine-content').html(data);
        });
    }
</script>