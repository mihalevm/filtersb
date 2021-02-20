<br>
<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <?=$dinfo['secondname'].' '.$dinfo['firstname'].' '.$dinfo['middlename']?>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
    </div>

    <div class="row driver-info-container">
        <div class="col-md-6 col-sm-6"><b>Адрес эл. почты</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['username']?$dinfo['username']:'Не указан'?></div>
        <div class="col-md-6 col-sm-6"><b>Телефон водителя</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['personalphone']?$dinfo['personalphone']:'Нет'?></div>
        <div class="col-md-6 col-sm-6"><b>Дата рождения</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['birthday']?$dinfo['birthday']:'Не указана'?></div>
        <div class="col-md-6 col-sm-6"><b>Пол</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['sex']?'Мужской':'Женский'?></div>
        <div class="col-md-6 col-sm-6"><b>ИНН</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['inn']?></div>
        <div class="col-md-6 col-sm-6"><b>Паспорт</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['pserial']?> <?=$dinfo['pnumber']?></div>
        <div class="col-md-6 col-sm-6"><b>Дата выдачи паспорта</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['pdate']?$dinfo['pdate']:'Не указана'?></div>
        <div class="col-md-6 col-sm-6"><b>Водительское удостоверение</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['dserial']?>  <?=$dinfo['dnumber']?></div>
        <div class="col-md-6 col-sm-6"><b>Дата выдачи водительского</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['ddate']?$dinfo['ddate']:'Не указана'?></div>
        <div class="col-md-6 col-sm-6"><b>Адрес регистрации</b></div>
        <div class="col-md-6 col-sm-6">
            <?php
                if (null != $dinfo['raddress']) {
                    $raddress = json_decode($dinfo['raddress']);
                    echo (intval($raddress->postzip)>0 ? 'Индекс: '.$raddress->postzip.'; ' : ' ')
                        . ($raddress->region ? $raddress->region . ', ' : ' ')
                        . ($raddress->city   ? $raddress->city . ', ' : ' ')
                        . ($raddress->street ? $raddress->street . ', ' : ' ')
                        . ($raddress->house  ? 'д. ' . $raddress->house . ', ' : ' ')
                        . ($raddress->build  ? 'стр. ' . $raddress->build . ', ' : ' ')
                        . ($raddress->flat   ? 'кв. ' . $raddress->flat : ' ');
                } else {
                    echo 'Не указан';
                }
            ?>
        </div>
        <div class="col-md-6 col-sm-6"><b>Адрес проживания</b></div>
        <div class="col-md-6 col-sm-6">
            <?php
                if (null != $dinfo['laddress']) {
                    $laddress = json_decode($dinfo['laddress']);
                    echo (intval($laddress->postzip)>0 ? 'Индекс: '.$laddress->postzip.'; ' : ' ')
                        .($laddress->region ? $laddress->region.', ' : ' ')
                        .($laddress->city   ? $laddress->city.', ' : ' ')
                        .($laddress->street ? $laddress->street.', ' : ' ')
                        .($laddress->house  ? 'д. '.$laddress->house.', ' : ' ')
                        .($laddress->build  ? 'стр. '.$laddress->build.', ' : ' ')
                        .($laddress->flat   ? 'кв. '. $laddress->flat : ' ');
                } else {
                    echo 'Не указан';
                }
            ?>
        </div>
    <?php if( $dinfo['active'] == 'Y') { ?>
        <div class="col-md-6 col-sm-6"><b>Телефоны родственников</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['relphones']?$dinfo['relphones']:'Нет'?></div>
        <div class="col-md-6 col-sm-6"><b>Наличие семьи</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['familystatus']=='N'?'Нет':'Есть'?></div>
        <div class="col-md-6 col-sm-6"><b>Стаж вождения по категории Е</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['e_experience']?$dinfo['e_experience']:'Не указан'?></div>
        <div class="col-md-6 col-sm-6"><b>Стаж вождения по категории С</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['c_experience']?$dinfo['c_experience']:'Не указан'?></div>
        <div class="col-md-6 col-sm-6"><b>Карта тахографа</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['tachograph']?$dinfo['tachograph']:'Нет'?></div>
        <div class="col-md-6 col-sm-6"><b>Опыт вождения транспортных средств</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['transporttype']?$dinfo['transporttype']:'Нет'?></div>
        <div class="col-md-6 col-sm-6"><b>Опыт вождения прицепов</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['trailertype']?$dinfo['trailertype']:'Нет'?></div>
        <div class="col-md-6 col-sm-6"><b>Дата окончания загранпаспорта</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['fpassdate']?$dinfo['fpassdate']:'Не указана'?></div>
        <div class="col-md-6 col-sm-6"><b>Наличие действующей медкнижки</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['medbook']=='N'?'Нет':'Есть'?></div>
        <div class="col-md-6 col-sm-6"><b>Дата начала работы</b></div><div class="col-md-6 col-sm-6"><?=$dinfo['startdate']?$dinfo['startdate']:'Не указана'?></div>
        <?php
            if (null != $companyset){
                echo '<br/><div class="col-md-12"><div class="separator"><b>Предпочитаемые места работы</b></div></div>';
                foreach ($companyset as $company){
                    echo '<div class="col-md-12 text-center">'.$company.'</div>';
                }
            }

            if (count($wplace)>0){
                echo '<br/><div class="col-md-12"><div class="separator"><b>Описание предыдущих мест работы</b></div></div>';
                $i = 1;
                foreach ($wplace as $wpitem){
                    echo '<div class="col-md-12 text-right"><u><i>Место работы №'.$i.'</i></u></div>';
                    echo '<div class="col-md-6 col-sm-6"><b>Компания</b></div><div class="col-md-6 col-sm-6">'.($wpitem['company']?$wpitem['company']:'Не указана').'</div>';
                    echo '<div class="col-md-6 col-sm-6"><b>Период работы</b></div><div class="col-md-6 col-sm-6">'.($wpitem['sdate']?$wpitem['sdate']:'Не указана').' - '.($wpitem['edate']?$wpitem['edate']:'Не указана').'</div>';
                    echo '<div class="col-md-6 col-sm-6"><b>Должность</b></div><div class="col-md-6 col-sm-6">'.($wpitem['post']?$wpitem['post']:'Не указана').'</div>';
                    echo '<div class="col-md-6 col-sm-6"><b>Обязанности</b></div><div class="col-md-6 col-sm-6">'.($wpitem['action']?$wpitem['action']:'Не указано').'</div>';
                    echo '<div class="col-md-6 col-sm-6"><b>Причина увольнения</b></div><div class="col-md-6 col-sm-6">'.($wpitem['dismissal']?$wpitem['dismissal']:'Не указана').'</div>';
                    echo '<div class="col-md-6 col-sm-6"><b>Рекомендации</b></div><div class="col-md-6 col-sm-6">'.($wpitem['guarantor']?$wpitem['guarantor']:'Не указаны').'</div>';
                    echo '<div class="col-md-12"><hr/></div>';
                    $i++;
                }
            }
        ?>
    <?php } ?>

    </div>
</div>
