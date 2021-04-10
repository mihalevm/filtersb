<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Modal;

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
    <div class="text-center company-font-color"><h4>Зарегистрироваться</h4></div>
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
        ])->label('Разрешить обработку <span data-toggle="modal" data-target="#license-text">персональных данных</span>') ?>
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
                <div class="col-lg-6 col-md-6 col-sm-12 mb-30 text-left"><span class="icon icon-bigdata"></span> Проверка по различным базам СБ</div>
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
        <h2 class="company-font-color mb-30"><a href="tel:+79625558998">+7 (962) 555-89-98</a></h2>
        <br>
        <h5 class="company-font-color">Ответим на все интересующие вопросы</h5>
    </div>
</div>

<?php
Modal::begin([
    'header' => '<b>Согласие на обработку персональных данных</b>',
    'id'     => 'license-text',
    'size'   => 'modal-lg'
]);
?>

<div class='modalContent'>
    <div class="licence-text-container">
        <p style="text-align:center"><strong>Согласие на обработку персональных данных</strong></p>
        <p><em><strong>1.</strong> Предоставление информации Клиентом:</em></p>
        <p><br />
        <strong>1.1.</strong> При регистрации на сайте filtersb.ru (далее - &quot;Сайт&quot;) Клиент предоставляет следующую информацию:<br />
        фамилия, имя, отчество получателя Заказа, адрес для доставки Заказа, номер контактного телефона, а также иную информацию, которая может потребоваться для исполнения услуги.<br />
        В случае внесения данных третьим лицом оно подтвержает, что имеет все необходимые согласия от имени и по поручению которого осуществляется этот ввод от лица, чьи данные вводятся в формы проверки на Сайте.</p>
        <p><strong>1.2.</strong> Предоставляя свои персональные данные Клиент соглашается на их обработку (вплоть до отзыва Клиентом своего согласия на обработку его персональных данных) компанией ООО &quot;ФИЛЬТРСБ&quot; (далее - &quot;Продавец&quot;), в целях исполнения Продавцом и/или его партнерами своих обязательств перед клиентом, продажи товаров и предоставления услуг, предоставления справочной информации, а также в целях продвижения товаров, работ и услуг, а также соглашается на получение сообщений рекламно-информационного характера и сервисных сообщений.&nbsp;<br />
        При обработке персональных данных Клиента Продавец руководствуется Федеральным законом &quot;О персональных данных&quot;, Федеральным законом &quot;О рекламе&quot; и локальными нормативными документами.</p>
        <p><strong>1.2.1.</strong> Если Клиент желает уточнения его персональных данных, их блокирования или уничтожения в случае, если персональные данные являются неполными, устаревшими, неточными, незаконно полученными или не являются необходимыми для заявленной цели обработки, либо в случае желания клиента отозвать свое согласие на обработку персональных данных или устранения неправомерных действий ООО &quot;ФИЛЬТРСБ&quot; в отношении его персональных данных то он должен направить официальный запрос Продавцу на адрес электронной почты: abuse@filtersb.ru.</p>
        <p>Если Клиент желает удалить свою учетную запись на Сайте, Клиент обращается к нам по адресу электронной почты abuse@filtersb.ru, с соответствующей просьбой. Данное действие не подразумевает отзыв согласия Клиента на обработку его персональных данных, который согласно действующему законодательству происходит в порядке, предусмотренном абзацем 1 настоящего пункта.</p>
        <p><strong>1.3. </strong>Использование информации предоставленной Клиентом и получаемой Продавцом.</p>
        <p><strong>1.3.1</strong> Продавец использует предоставленные Клиентом данные в течение всего срока регистрации Клиента на Сайте в целях:<br />
        &nbsp; &nbsp; регистрации/авторизации Клиента на Сайте;<br />
        &nbsp; &nbsp; обработки Заказов Клиента и для выполнения своих обязательств перед Клиентом;<br />
        &nbsp; &nbsp; оценки и анализа работы Сайта;<br />
        &nbsp; &nbsp; информирования клиента об акциях, скидках и специальных предложениях.</p>
        <p>&nbsp;</p>
        <p><em><strong>2. </strong>Предоставление и передача информации, полученной Продавцом:</em></p>
        <p>&nbsp;</p>
        <p><strong>2.1. </strong>Продавец обязуется не передавать полученную от Клиента информацию третьим лицам. Не считается нарушением предоставление Продавцом информации агентам и третьим лицам, действующим на основании договора с Продавцом, для исполнения обязательств перед Клиентом и только в рамках договоров. Не считается нарушением настоящего пункта передача Продавцом третьим лицам данных о Клиенте в обезличенной форме в целях оценки и анализа работы Сайта, анализа покупательских особенностей Клиента и предоставления персональных рекомендаций.</p>
        <p><strong>2.2.</strong> Не считается нарушением обязательств передача информации в соответствии с обоснованными и применимыми требованиями законодательства Российской Федерации.</p>
        <p><strong>2.3. </strong>Продавец вправе использовать технологию &quot;cookies&quot;. &quot;Cookies&quot; не содержат конфиденциальную информацию и не передаются третьим лицам.</p>
        <p><strong>2.4. </strong>Продавец получает информацию об ip-адресе посетителя Сайта abuse@filtersb.ru и сведения о том, по ссылке с какого интернет-сайта посетитель пришел. Данная информация не используется для установления личности посетителя.</p>
        <p><strong>2.5.</strong> Продавец не несет ответственности за сведения, предоставленные Клиентом на Сайте в общедоступной форме.</p>
        <p><strong>2.6.</strong> Продавец при обработке персональных данных принимает необходимые и достаточные организационные и технические меры для защиты персональных данных от неправомерного доступа к ним, а также от иных неправомерных действий в отношении персональных данных.</p>
        <p>&nbsp;</p>
        <p><em><strong>3.</strong> Хранение и использование информации Клиентом</em></p>
        <p>&nbsp;</p>
        <p><strong>3.1.</strong> Клиент обязуется не сообщать третьим лицам логин и пароль, используемые им для идентификации на Сайте.</p>
        <p><strong>3.2.</strong> Клиент обязуется обеспечить должную осмотрительность при хранении и использовании логина и пароля (в том числе, но не ограничиваясь: использовать лицензионные антивирусные программы, использовать сложные буквенно-цифровые сочетания при создании пароля, не предоставлять в распоряжение третьих лиц компьютер или иное оборудование с введенными на нем логином и паролем Клиента и т.п.)</p>
        <p><strong>3.3. </strong>В случае возникновения у Продавца подозрений относительно использования учетной записи Клиента третьим лицом или вредоносным программным обеспечением Продавец вправе в одностороннем порядке изменить пароль Клиента.</p>
    </div>
</div>

<?php Modal::end();?>


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