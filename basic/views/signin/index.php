<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Авторизация';
?>

<div id="wrapper-signin">
    <div class="row">
        <div class="text-center"><h1><?= Html::encode($this->title) ?></h1></div>
    <br>
        <?php $form = ActiveForm::begin([
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}<div class=\"col-sm-5 col-lg-3 mb-10\">{input}</div>",
                'labelOptions' => ['class' => 'col-sm-4 col-lg-offset-4 col-lg-1 control-label-left'],
            ],
        ]); ?>
            <?= $form->errorSummary($model, ["class" => "col-sm-offset-3 col-sm-6 col-lg-offset-5 col-lg-4"]) ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'password')->passwordInput()->label('Пароль') ?>

            <?= $form->field($model, 'rememberMe')->checkbox([
                'template' => "<div class=\"col-sm-9 col-lg-8 text-right\">{input} {label}</div>",
            ])->label('Запомнить') ?>

            <div class="form-group">
                <label class="col-sm-offset-0 col-sm-3 col-lg-offset-4 col-lg-2 text-left custom-link" onclick="restorePageShow()">Забыли пароль?</label>
                <div class="col-sm-offset-1 col-sm-5 col-lg-offset-0 col-lg-2 text-right">
                    <?= Html::submitButton('Вход', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<div id="wrapper-restore">
    <div class="row">
        <div class="text-center"><h1>Восстановление пароля</h1></div>
        <div class="text-center"><h5><i>На указанный Вами адрес будет выслана<br/>ссылка для восстановления пароля.</i></h5></div>
        <br>
        <div class="col-sm-4 col-lg-offset-4 col-lg-1 control-label-left">Email</div>
        <div class="col-sm-5 col-lg-3 mb-10">
            <input type="text" id="restore-email" class="form-control" aria-required="true" aria-invalid="true"/>
        </div>
        <div class="form-group">
            <div class="col-sm-9 col-lg-8 text-right">
                <span class="label label-info fake-bnt mr-10" onclick="backToSignin()">Отмена</span>
                <span class="label label-info fake-bnt" onclick="sendRestoreRequest()">Отправить</span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12 col-lg-12 text-center mt-10">
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