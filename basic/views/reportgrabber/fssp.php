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
            <input class="form-control" id="captcha_str" placeholder="" type="text" data-sid="<?=$session['cookies']?>"required >
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
        <div class="col-md-12">Ошибка обращения к серверу ФССП</div>
<?php
}
?>
    </div>

    <div class="row control-tools">
        <div class="col-md-12">
<?php
if ($session['error'] == 200) {
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
        $('#rep-fssp-result').text('');

        if ($('#captcha_str').val()) {
            $.post(window.location.origin + '/reportgrabber', {
                s: 'F',
                rid:<?=$rid?>,
                did: $('#drv-item-' + $('#property-driver').data('did')).data('did'),
                sid: $('#captcha_str').data('sid'),
                code: $('#captcha_str').val()
            }, function (r) {
                if (parseInt(r.code) == 200){
                    $('#rep-engine-content').html(r.data);
                } else {
                    $('#rep-fssp-result').text(r.data);
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