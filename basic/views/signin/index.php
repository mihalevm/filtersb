<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
?>

<div id="wrapper-signin" class="company-landing-block3">
    <div class="row form-wrap">
        <br>
        <div class="text-center company-font-color"><h4>Вход в личный кабинет</h4></div>
        <br>
        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "<div class=\"col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10 mb-10\">{input}</div>",
            ],
        ]); ?>
            <?= $form->errorSummary($model, ["class" => "col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10"]) ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => ' Адрес эл. почты']) ?>

            <?= $form->field($model, 'password')->passwordInput(['placeholder' => ' Пароль'])->label('Пароль') ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"col-lg-11 text-right company-font-color\">{input} {label}</div>",
            ])->label('Запомнить') ?>

            <div class="form-group">
                <div class="col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10">
                    <label class="custom-link company-font-color text-right" onclick="restorePageShow()">Забыли пароль?</label>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-12 col-lg-12 text-center">
                    <?=Html::submitButton('Вход', ['class' => 'btn bnt-regular']) ?>
                </div>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div id="wrapper-restore" class="company-landing-block3">
    <div class="row form-wrap">
        <br>
        <div class="text-center company-font-color"><h4>Восстановление пароля</h4></div>
        <div class="text-center company-font-color"><h5><i>На указанный Вами адрес будет выслана<br/>ссылка для восстановления пароля.</i></h5></div>
        <br>
        <div class="col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10 mb-10">
            <input type="text" id="restore-email" class="form-control fa" aria-required="true" aria-invalid="true" placeholder=" Адрес эл. почты"/>
        </div>
        <div class="form-group">
            <div class="col-sm-11 col-lg-11 text-right mb-10">
                <span class="label label-info fake-bnt mr-10 bnt-regular" onclick="backToSignin()">Отмена</span>
                <span class="label label-info fake-bnt bnt-regular" onclick="sendRestoreRequest()">Отправить</span>
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
    function restorePageShow() {
        $('#wrapper-signin').fadeOut(400, function () {
            $('#wrapper-restore').fadeIn(400);
        })
    }

    function backToSignin() {
        $('#wrapper-restore').fadeOut(400, function () {
            $('#wrapper-signin').fadeIn(400);
        })
    }

    function sendRestoreRequest() {
        if ($('#restore-email').val().length>0) {
            $('#restore-email').removeClass('has-error');
            $('#restore-result').html('<div class="spinner-holder" style="top:initial"><i class="fas fa-spinner fa-spin"></i></div>');
            $.get(
                window.location + '/restore-request',
                {email: $('#restore-email').val()},
                function (data) {
                    if (data.hasOwnProperty('status')) {
                        $('#restore-result').text(data.message);

                        if (data.status == 'sended') {
                            setTimeout(function () {
                                window.location.href = window.location.origin + '/signin';
                            }, 1500)
                        }
                    } else {
                        $('#restore-result').text('Ошибка обращения к серверу');
                    }
                }
            ).fail(function () {
                $('#restore-result').text('Ошибка обращения к серверу');
            });
        } else {
            $('#restore-email').addClass('has-error');
            $('#restore-result').text('Укажите Email для восстановления');
        }
    }
</script>