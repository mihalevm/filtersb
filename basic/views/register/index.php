<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
?>

<div class="row company-landing-block3">
<div class="col-lg-6 col-md-12 col-sm-12 company-landing-header1">
    <div class="col-lg-12 col-md-12 col-sm-offset-1 col-sm-12 company-font-color">
<?php if($rtype == 'D') {?>
        <p><h2>Лучший сервис для эффективного поиска работы</h2></p>
        <br/>
        <p><label>С «Фильтр СБ» поиск работы становится быстрым и удобным</label></p>
<?php } else {?>
    <p><h2>Лучший сервис для эффективного подбора водителей</h2></p>
    <br/>
    <p><label>С «Фильтр СБ» подбор персонала становится быстрым и удобным</label></p>
<?php } ?>
    </div>
</div>

<div class="col-lg-6 col-md-12 col-sm-12 form-wrap-1">
    <br>
    <div class="text-center company-font-color"><h4>Зарегестрироваться</h4></div>
    <br>
    <?php $form = ActiveForm::begin([
        'id' => 'register-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "<div class=\"col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10 mb-10\">{input}</div>",
        ],
    ]); ?>
        <?= $form->errorSummary($model, ["class" => "col-sm-offset-1 col-sm-10 col-lg-offset-1 col-lg-10"]) ?>

        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'placeholder' => ' Адрес эл. почты']) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => ' Пароль'])->label('Пароль') ?>

        <?= $form->field($model, 'inn')->widget(\yii\widgets\MaskedInput::className(), ['mask' => '9999999999','options' => ['value'=>'0', 'placeholder' => ' ИНН']])->label('ИНН') ?>

        <?= $form->field($model, 'utype')->dropDownList(['D' => 'Водитель', 'C' => 'Компания'], ['onchange' => 'show_inn(this)', 'value' => $rtype])->label('Тип') ?>

        <?= $form->field($model, 'confirmagree')->checkbox([
            'template' => "<div class=\"col-sm-12 col-lg-offset-1 col-lg-10 mb-10 company-font-color agree-text text-center\">{input} {label}</div>",
        ])->label('Разрешить обработку <a href="">персональных данных</a>') ?>
    <br/>
        <div class="form-group">
            <div class="col-sm-12 col-lg-12 mb-10 text-center">
                <?= Html::submitButton('Получить доступ', ['class' => 'btn bnt-regular', 'name' => 'register-button']) ?>
            </div>
        </div>
        <br/>
    <?php ActiveForm::end(); ?>
</div>
</div>

<div class="row company-landing-block1">
    <div class="col-lg-12 col-sm-12 text-center">
        <h1><b>Причины</b></h1>
        <br>
        <label class="company-font-color2 mb-30">Почему это необходимо для вас?</label>
        <br>
<?php if($rtype == 'D') {?>
        <div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 company-landing-block2">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-handshake"></span> Быстрый поиск работы</div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-growth"></span> Уникальная система проф.оценки</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-bigdata"></span> Решение вопросов онлайн</div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-contract"></span> Актуальная история о водителе</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-mobilemoney"></span>Выгодные предложения работодателей</div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-balance"></span> Детализация нарушений</div>
            </div>
        </div>
    </div>
<?php  } else {?>
        <div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 company-landing-block2">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-handshake"></span> Довольные клиенты после качественного отбора водителей</div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-growth"></span> Уникальная система проф.оценки</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-bigdata"></span> Проверка по различным базам по СБ</div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-contract"></span> Актуальная история о водителе</div>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-mobilemoney"></span>Инструмент для управления персоналом</div>
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-balance"></span> Детализация нарушений</div>
            </div>
        </div>
    </div>
<?php  }?>
</div>

<div class="row company-landing-block3">
    <div class="col-lg-12 col-sm-12 text-center">
        <h1 class="company-font-color"><b>Преимущества</b></h1>
        <br>
        <label class="company-font-color2 mb-30">С сервисом Фильтр СБ вы получите:</label>
        <br>

<?php if($rtype == 'D') {?>
    <div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 company-landing-block2">
        <div class="row">
            <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu3"></span> Информацию о себе, в том виде, в котором видят вас СБ</div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu3"></span> Базу заинтересованных в водителях работодателей</div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu3"></span> Способ улучшения своей электронной характеристики</div>
        </div>
    </div>
<?php  } else {?>
        <div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 company-landing-block2">
            <div class="row">
                <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu3"></span> Действительность паспорта гражданина</div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu3"></span> Информация о ранее выданных паспортах</div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu3"></span> Наличие административных и уголовных дел с указанием «тяжелых» статей</div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu3"></span> Действительность водительского удостоверения</div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu3"></span> Наличие задолженности с указанием общей суммы</div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu3"></span> Электронная характеристика с указанием комментариев</div>
            </div>
        </div>
<?php  }?>
    </div>
</div>

<div class="row company-landing-block1">
    <div class="col-lg-12 col-sm-12 text-center">
        <h1><b>Процедура</b></h1>
        <br>
        <label class="company-font-color2 mb-30">Как это работает?</label>
        <br>
<?php if($rtype == 'D') {?>
    <div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 company-landing-block2">
        <div class="row">
            <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu2"></span> Заполняете анкету на сервисе</div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu2"></span> Проверяете свою анкету и получаете отчет</div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu2"></span> Выбираете транспортные компании, в которой хотели бы работать</div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu2"></span> Сервис автоматически направляет ваш отчет работодателю, сэкономив время на проверку вашей анкеты по СБ</div>
        </div>
    </div>
<?php  } else {?>
        <div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 company-landing-block2">
            <div class="row">
                <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu2"></span> 1.Получаете запрос от водителя на трудоустройство с готовым отчетом по СБ</div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-bu2"></span> 2. Заполняете анкету водителя, далее получаете отчет</div>
            </div>
        </div>
<?php  }?>
    </div>
</div>

<div class="row company-landing-block3">
    <div class="col-lg-12 col-sm-12 text-center">
        <h1 class="company-font-color"><b>О нас</b></h1>
        <br>
        <label class="company-font-color2 mb-30">Почему мы?</label>
        <br>

        <div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12 company-landing-block2">
            <div class="row">
                <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-search"></span> Проверили более 1000 кандидатов</div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-fn_transfer"></span> Отчет составляется от 3мин до 24ч, вам не придется ждать неделями</div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-sm-12 mb-30 text-left"><span class="icon icon32 icon-transfer"></span> Возврат средств в течении 48 часов, в случае отсутствия или недостоверности данных</div>
            </div>
        </div>
    </div>
</div>

<div class="row company-landing-block1">
    <div class="col-lg-12 col-sm-12 text-center">
        <h1><b>Получите демо-доступ</b></h1>
        <br>
        <label class="company-font-color2 mb-30">Мы дарим Вам 1 бесплатный отчёт</label>
        <br>
        <div class="col-lg-offset-1 col-lg-10 col-md-12 col-sm-12">
            <div id="promo-form" class="row mb-30">
                <div class="col-lg-offset-3 col-lg-2 col-md-4 col-sm-4 text-center mb-30">
                    <input type="text" id="promo_email" class="form-control fa" placeholder=" Ваша эл. почта"/>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 text-center mb-30">
                    <input type="text" id="promo_name" class="form-control fa" placeholder=" Ваше имя"/>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-4 text-center mb-30">
                    <span class="label label-info fake-bnt company-landing-promo-bnt bnt-regular" onclick="requestPromo()">Получить</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row company-landing-block3">
    <div class="col-lg-12 col-sm-12 text-center">
        <h3 class="company-font-color"><b>Наши контакты</b></h3>
        <br>
        <h2 class="company-font-color mb-30">+7 (962) 555-89-98</h2>
        <br>
        <h5 class="company-font-color">Ответим на все интересующие вопросы</h5>
    </div>
</div>

<script language="JavaScript">

    document.addEventListener('DOMContentLoaded', function(){
        if ( $('#registerform-utype').val() === 'C' ) {$('#registerform-inn').val(''); $('.field-registerform-inn').show()};
        if ( $('#registerform-utype').val() === 'D' ) {$('.field-registerform-inn').hide()};

    });

    function show_inn(o) {
        if ( $(o).val() === 'C' ) {$('#registerform-inn').val(''); $('.field-registerform-inn').show()};
        if ( $(o).val() === 'D' ) {$('#registerform-inn').val('0'); $('.field-registerform-inn').hide()};
    }
    
    function requestPromo() {
        $('#promo_email').removeClass('has-error');
        $('#promo_name').removeClass('has-error');

        if ( $('#promo_email').val().length == 0 ) {
            $('#promo_email').addClass('has-error');
            return;
        }

        if ( $('#promo_name').val().length == 0 ) {
            $('#promo_name').addClass('has-error');
            return;
        }

        $.post(
            window.location.origin + '/register/promo',
            {
                pemail: $('#promo_email').val(),
                pname:  $('#promo_name').val()
            },
            function (r) {
                if (parseInt(r) == 1) {
                    $('#promo-form').html('<h4>Ваш запрос отправлен.<br/>Мы рассмотрим Вашу заявку в течении 24 часов.</h4>')
                }
            }
        );
    }
</script>