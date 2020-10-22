<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center">
                Внести денежные средства за отчет в размере 400р.
            </h4>
        </div>
    </div>
    <br/>
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-12 text-center">
            <button type="button" class="btn btn-primary" onclick="makePay()">Оплатить</button>
        </div>
    </div>
    <br/>
    <br/>
    <div class="row">
        <div class="col-md-12 text-center">
            <h4 id="pay-init-status"></h4>
        </div>
    </div>

    <div class="row control-tools">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary pull-right" onclick="nexStep('E', null)">Пропустить</button>
        </div>
    </div>
</div>

<script language="JavaScript">
    function makePay() {
        $('#pay-init-status').text('');
        $.get(window.location.origin + '/reportgrabber/makepay', {
            did:$('#drv-item-'+$('#property-driver').data('did')).data('did'),
        }, function (data) {
            if (parseInt(data) > 0){
                $('#pay-init-status').html('<p>Оплата прошла успешно.</p><p>Отчет поставлен в очередь для формирования.</p>');
                setTimeout(function () {
                    nexStep('E', parseInt(data));
                }, 2000);
            } else {
                $('#pay-init-status').text('Ошибка выполнения оплаты.');
            };
        });
    }

    function nexStep(s, rid) {
        $('#rep-engine-content').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.post(window.location.origin + '/reportgrabber', {
            s: s,
            did:$('#drv-item-'+$('#property-driver').data('did')).data('did'),
            rid: rid
        }, function (data) {
            $('#rep-engine-content').html(data);
        });
    }
</script>