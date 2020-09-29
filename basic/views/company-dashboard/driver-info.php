<br>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <h4>Водитель: <?=$dinfo['firstname']?> <?=$dinfo['secondname']?> <?=$dinfo['middlename']?></h4>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6"><b>Адрес эл. почты</b></div><div class="col-md-6"><?=$dinfo['username']?></div>
        <div class="col-md-6"><b>День рождения</b></div><div class="col-md-6"><?=$dinfo['birthday']?></div>
        <div class="col-md-6"><b>ИНН</b></div><div class="col-md-6"><?=$dinfo['inn']?></div>
        <div class="col-md-6"><b>Паспорт</b></div><div class="col-md-6"><?=$dinfo['pserial']?> <?=$dinfo['pnumber']?></div>
        <div class="col-md-6"><b>Водительское удостоверение</b></div><div class="col-md-6"><?=$dinfo['dserial']?> <?=$dinfo['dnumber']?></div>

    <?php if( $dinfo['active'] == 'Y') { ?>
        <div class="col-md-6"><b>Телефон водителя</b></div><div class="col-md-6"><?=$dinfo['personalphone']?$dinfo['personalphone']:'Нет'?></div>
        <div class="col-md-6"><b>Телефоны родственников</b></div><div class="col-md-6"><?=$dinfo['relphones']?$dinfo['relphones']:'Нет'?></div>
        <div class="col-md-6"><b>Наличие семьи</b></div><div class="col-md-6"><?=$dinfo['familystatus']=='N'?'Нет':'Есть'?></div>
        <div class="col-md-6"><b>Стаж вождения по категории Е</b></div><div class="col-md-6"><?=$dinfo['e_experience']?$dinfo['e_experience']:'Не указан'?></div>
        <div class="col-md-6"><b>Стаж вождения по категории С</b></div><div class="col-md-6"><?=$dinfo['c_experience']?$dinfo['c_experience']:'Не указан'?></div>
        <div class="col-md-6"><b>Карта тахографа</b></div><div class="col-md-6"><?=$dinfo['tachograph']?$dinfo['tachograph']:'Нет'?></div>
        <div class="col-md-6"><b>Опыт вождения транспортных средств</b></div><div class="col-md-6"><?=$dinfo['transporttype']?$dinfo['transporttype']:'Нет'?></div>
        <div class="col-md-6"><b>Опыт вождения прицепов</b></div><div class="col-md-6"><?=$dinfo['trailertype']?$dinfo['trailertype']:'Нет'?></div>
        <div class="col-md-6"><b>Дата окончания загранпаспорта</b></div><div class="col-md-6"><?=$dinfo['fpassdate']?$dinfo['fpassdate']:'Не указана'?></div>
        <div class="col-md-6"><b>Наличие медкнижки</b></div><div class="col-md-6"><?=$dinfo['medbook']=='N'?'Нет':'Есть'?></div>
        <div class="col-md-6"><b>Дата начала работы</b></div><div class="col-md-6"><?=$dinfo['startdate']?$dinfo['startdate']:'Не указана'?></div>
        <div class="col-md-6"><b>Описание предыдущих мест работы</b></div><div class="col-md-6"><?=$dinfo['experience']?></div>
    <?php } ?>

    </div>
</div>
