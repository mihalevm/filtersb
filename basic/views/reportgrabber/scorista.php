<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center">
<?php
    if ($result['code'] == 200) {
        echo "<p>Данне сотрудника заполнены верно.</p><p>Сейчас вы будете перенаправлены на страницу оплаты.</p>";
    } else {
        echo $result['message'];
    }
?>
            </h4>
        </div>
    </div>
    <div class="row control-tools">
        <div class="col-md-12">
<?php
    if ($result['code'] === 200) {
?>
        <button type="button" class="btn btn-primary pull-right" onclick="nexStep()">Далее</button>
<?php
    } else {
?>
        <button type="button" class="btn btn-primary pull-right" onclick="skipStep()">Пропустить</button>
<?php
    }
?>
        </div>
    </div>
</div>

<script language="JavaScript">
    $(document).ready(function () {
        setTimeout(function () {
            nexStep();
        }, 3000);
    });

    function skipStep() {
        $('#rep-engine-content').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.post(window.location.origin + '/reportgrabber', {
            s: 'E',
            did:$('#drv-item-'+$('#property-driver').data('did')).data('did'),
        }, function (data) {
            $('#rep-engine-content').html(data);
        });
    }

    function nexStep() {
        $('#rep-engine-content').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.post(window.location.origin + '/reportgrabber', {
            s: 'pay',
            did:$('#drv-item-'+$('#property-driver').data('did')).data('did'),
        }, function (data) {
            $('#rep-engine-content').html(data);
        });
    }
</script>