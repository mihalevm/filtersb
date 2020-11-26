<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
?>
<?php
if (null != $hash) {
?>
<div class="company-landing-block3">
<div class="row form-wrap">
        <div class="text-center company-font-color"><h4>Восстановление пароля</h4></div>
        <div class="text-center company-font-color"><h5><i>Введите новый пароль<br/>и подтвердите его повторным вводом.</i></h5></div>
        <br>
        <div class="col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10 mb-10">
            <input type="password" id="restore-password-1" class="form-control fa" aria-required="true" aria-invalid="true" placeholder = " Введите пароль"/>
        </div>
    <div class="col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10 mb-10">
        <input type="password" id="restore-password-2" class="form-control fa " aria-required="true" aria-invalid="true" placeholder = " Подтвердите пароль"/>
    </div>

        <div class="form-group">
            <div class="col-sm-11 col-lg-11 text-right mb-10">
                <span class="label label-info fake-bnt bnt-regular mr-10" onclick="backToSignin()">Отмена</span>
                <span class="label label-info fake-bnt bnt-regular" onclick="sendRestoreRequestAccept()">Сменить</span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12 col-lg-12 text-center mt-10 mb-10 company-font-color">
                <h5 id="restore-result"></h5>
            </div>
        </div>
</div>
</div>

<script language="JavaScript">
    function backToSignin() {
        window.location.href = window.location.origin + '/signin';
    }

    function sendRestoreRequestAccept() {
        $('#restore-password-1').removeClass('has-error');
        $('#restore-password-2').removeClass('has-error');

        let p1 = $('#restore-password-1').val();
        let p2 = $('#restore-password-2').val();

        if (p1.length == 0) {
            $('#restore-result').text('Введите пароль');
            $('#restore-password-1').addClass('has-error');
            return;
        }

        if (p2.length == 0) {
            $('#restore-result').text('Введите пароль для подтверждения');
            $('#restore-password-2').addClass('has-error');
            return;
        }

        if (p1.localeCompare(p2)) {
            $('#restore-result').text('Пароли должны совпадать');
            $('#restore-password-1').addClass('has-error');
            $('#restore-password-2').addClass('has-error');
            return;
        }

        if (p1.length < 8) {
            $('#restore-result').text('Пароль должен быть больше либо равен 8 символам');
            $('#restore-password-1').addClass('has-error');
            $('#restore-password-2').addClass('has-error');
            return;
        }

        if (! /^[\x00-\xFF]*$/.test(p1)) {
            $('#restore-result').text('Пароль не должен содержать русские буквы');
            $('#restore-password-1').addClass('has-error');
            $('#restore-password-2').addClass('has-error');
            return;
        }

        $.get(
            window.location.origin + '/signin/restore-accept',
            {
                p: $('#restore-password-1').val(),
                h: '<?= $hash ?>'
            },
            function (data) {
                if (data.hasOwnProperty('status')) {
                    $('#restore-result').text(data.message);

                    if (data.status == 'accepted') {
                        setTimeout(function () {
                            backToSignin();
                        }, 1500)
                    }
                } else {
                    $('#restore-result').text('Ошибка обращения к серверу');
                }
            }
        ).fail(function () {
            $('#restore-result').text('Ошибка обращения к серверу');
        });
    }
</script>
<?php } else {?>
<div class="row">
    <div class="text-center"><h1>Восстановление пароля</h1></div>
    <div class="text-center"><h5><i>Ваша сссылка для восстановления пароля не действительна</i></h5></div>
</div>
<?php }?>
