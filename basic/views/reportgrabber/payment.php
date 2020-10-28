<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center">
                Внести денежные средства за отчет в размере <?=($price ? $price.'р.' : 'бесплатно.')?>
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
            rid: $('#property-driver').data('rid')
        }, function (data) {
            if (parseInt(data.code) == 200 ){
                $('#pay-init-status').html('<p>Сейчас Вы будете переадресованы на страницу оплаты.</p>');
                setTimeout(function () {
                    window.open(data.rurl, '_blank');
                    nexStep('E', parseInt(data.rid));
                }, 2000);
            } else {
                $('#pay-init-status').text('Ошибка размещения заказа.');
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