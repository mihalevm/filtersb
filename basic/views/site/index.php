<?php

/* @var $this yii\web\View */

$this->title = 'Главная';
?>
<div class="site-index">
    <p><h1 class="text-center company-font-color company-landing-name">Фильтр СБ</h1></p>
    <p><h3 class="text-center company-font-color">Мы скажем больше</h3></p>
    <br/>
    <br/>
    <p class="text-center">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-4 col-lg-offset-1 col-lg-4 text-center"><span class="label label-info fake-bnt bnt-lg-regular" onclick="driverRegister()">Водителям</span><br/><label class="company-font-color mt-10 mb-30">Подробнее о сервисе для Водителей</label></div>
            <div class="col-sm-offset-2 col-sm-4 col-lg-offset-2 col-lg-4 text-center"><span class="label label-info fake-bnt bnt-lg-regular" onclick="companyRegister()">Бизнесу</span><br/><label class="company-font-color mt-10 mb-30">Подробнее о сервисе для Бизнеса</label></div>
        </div>
    </p>
</div>

<script language="JavaScript">
    function driverRegister() {
        window.location.href = window.location.origin + '/register?t=D';
    }

    function companyRegister() {
        window.location.href = window.location.origin + '/register?t=C';
    }
</script>