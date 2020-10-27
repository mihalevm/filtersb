<div class="container-fluid">
    <div class="row">
<?php
if ($session['error'] == 200) {
?>
        <div class="col-md-4 col-md-offset-4 text-left">Введите код с картинки</div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <input class="form-control" id="captcha_str" placeholder="" type="text" data-sid="<?=$session['cookies']?>" autocomplete="off" required >
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-3 col-md-offset-4"><img id="captcha" alt="" src="<?=$session['captcha']?>"/></div>
        <div class="col-md-1 captcha-refresh">
            <button type="button" class="btn btn-primary glyphicon glyphicon-refresh pull-right" onclick="repeatStep()" title="Обновить"></button>
        </div>
    </div>
    <br/>
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <button type="button" class="btn btn-primary pull-right" onclick="requestData()">Отправить</button>
        </div>
    </div>
<?php
} else {
?>
    <div class="col-md-12 text-center"><h4>Ошибка обращения к серверу ФССП</h4></div>
<?php
}
?>
    </div>

    <div class="row control-tools">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary pull-right" style="display:<?= $session['error'] == 200?'block':'none' ?>" id="nextStep" onclick="nexStep()">Далее</button>
            <button type="button" class="btn btn-primary pull-right" style="display:<?= $session['error'] != 200?'block':'none' ?>" id="skipStep" onclick="nexStep()">Пропустить</button>
            <button type="button" class="btn btn-primary pull-right mr-12" style="display:<?= $session['error'] != 200?'block':'none' ?>" id="repeatStep" onclick="repeatStep()">Повторить</button>
        </div>
    </div>
    <br/>
    <div class="row">
        <b><div class="col-md-12 text-center" id="rep-fssp-result"></div></b>
    </div>
</div>

<script language="JavaScript">

    $('#captcha_str').keypress(function (o) {
        $('#captcha_str').removeClass('has-error');
    })

    function repeatStep() {
        $('#rep-engine-content').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.post(window.location.origin + '/reportgrabber', {
            s: 'F',
            rid:<?=$rid?>,
            did:$('#drv-item-'+$('#property-driver').data('did')).data('did'),
        }, function (data) {
            $('#rep-engine-content').html(data);
        });
    }

    function requestData() {
        if ($('#captcha_str').val()) {
            $('#rep-fssp-result').html('<div class="spinner-holder-data"><i class="fas fa-spinner fa-spin"></i></div>');

            $.post(window.location.origin + '/reportgrabber', {
                s: 'F',
                rid:<?=$rid?>,
                did: $('#drv-item-' + $('#property-driver').data('did')).data('did'),
                sid: $('#captcha_str').data('sid'),
                code: $('#captcha_str').val()
            }, function (r) {
                if (parseInt(r.error) == 200){
                    $('#rep-fssp-result').html(r.data);
                    $('#skipStep').hide();
                    $('#repeatStep').hide();
                    $('#nextStep').show();
                } else {
                    $('#rep-fssp-result').html(r.data);
                    $('#nextStep').hide();
                    $('#skipStep').show();
                    $('#repeatStep').show();
                }
            });
        } else {
            $('#captcha_str').addClass('has-error');
        }
    }
    
    function nexStep() {
        $('#rep-engine-content').html('<div class="spinner-holder"><i class="fas fa-spinner fa-spin"></i></div>');
        $.post(window.location.origin + '/reportgrabber', {
            s: 'P',
            rid:<?=$rid?>,
            did:$('#drv-item-'+$('#property-driver').data('did')).data('did'),
        }, function (data) {
            $('#rep-engine-content').html(data);
        });
    }
</script>