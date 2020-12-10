<!DOCTYPE html>

<html>
<head>
    <title>Отчет</title>
</head>
<body>
<p style="width:100%; background-color: black; color: white; padding: 15px;">
    <span style="text-align: left; font-size: 24px; font-weight: 600;">ФильтрСБ</span>
</p>
<hr/>
<div>
    <table style="margin-left: auto; margin-right: auto;" border="0" width="100%">
        <tbody>
        <tr>
            <td style="width: 50%"><i>Дата подачи заявки:</i></td>
            <td><?=$rdate?></td>
        </tr>
        <tr>
            <td style="width: 50%"><i>ФИО:</i></td>
            <td><?=$fio?></td>
        </tr>
        <tr>
            <td style="width: 50%"><i>Адрес эл. почты пользователя:</i></td>
            <td><?=$email?></td>
        </tr>
        </tbody>
    </table>

    <hr style="border-top: 1px lightgrey dotted"/>

    <p><b>Проверка по базе паспортов:</b></p>

    <table style="margin-left: auto; margin-right: auto;" border="0" width="100%">
        <tbody>
        <tr>
            <td style="width: 50%">Статус:</td>
            <td><?php
                if (null !== $pvalidate){
                    if ($pvalidate){
                        echo 'Действителен';
                    }else{
                        echo 'Не действителен';
                    }
                }else{
                    echo 'Не проводилась';
                }
                ?></td>
        </tr>
        </tbody>
    </table>

    <p><b>Выписка из реестра ЕГРЮЛ:</b></p>
    <?php
        if (null !== $egrul){
            $egrul = json_decode($egrul);
            $egrul = $egrul->rows[0];

            if( property_exists($egrul, 'n') ) {
    ?>
    <table style="margin-left: auto; margin-right: auto;" border="0" width="100%">
        <tbody>
        <tr>
            <td style="width: 50%">Наименование:</td>
            <td><?=property_exists($egrul,'o') && intval($egrul->o) > 0 ? 'ИП '.$egrul->n : $egrul->n?></td>
        </tr>
        <tr>
            <td style="width: 50%">Дата прекращения деятельности:</td>
            <td><?=$egrul->e?></td>
        </tr>
        <tr>
            <td style="width: 50%">ОГРНИП:</td>
            <td><?=property_exists($egrul,'o')?$egrul->o : 'Нет'?></td>
        </tr>
        <tr>
            <td style="width: 50%">ИНН:</td>
            <td><?=$egrul->i?></td>
        </tr>
        <tr>
            <td style="width: 50%">Дата присвоения ОГРНИП:</td>
            <td><?=property_exists($egrul,'r')?$egrul->r : 'Не указана'?></td>
        </tr>
        </tbody>
    </table>
    <?php   } else {
                if (property_exists($egrul, 'cnt') && intval($egrul->cnt) == 0){
                    echo '<p style="text-align: center">Указанный ИНН в реестре не найден.</p>';
                }
            }
        } else {
            echo '<p style="text-align: center">Проверка не проводилась.</p>';
        }?>
    <p><b>Проверка водительского удостоверения по базе ГИБДД:</b></p>
    <?php
    if (null !== $gibdd){
        $gibdd = json_decode($gibdd);
        ?>
        <table style="margin-left: auto; margin-right: auto;" border="0" width="100%">
            <tbody>
            <tr>
                <td style="width: 50%">Номер\Серия:</td>
                <td><?=$gibdd->doc->num?></td>
            </tr>
            <tr>
                <td style="width: 50%">Дата выдачи:</td>
                <td><?=$gibdd->doc->date?></td>
            </tr>
            <tr>
                <td style="width: 50%">Категории:</td>
                <td><?=$gibdd->doc->cat?></td>
            </tr>
            <tr>
                <td style="width: 50%">День рождения:</td>
                <td><?=$gibdd->doc->bdate?></td>
            </tr>
            <tr>
                <td style="width: 50%">Дата окончания:</td>
                <td><?=$gibdd->doc->srok?></td>
            </tr>
            <?php
                if (strlen($gibdd->doc->wanted)>0) {
            ?>
            <tr>
                <td style="width: 50%">Документ не действителен и разыскивается с:</td>
                <td><?=$gibdd->doc->wanted?></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else {
        echo '<p style="text-align: center">Проверка не проводилась.</p>';
    }?>

    <p><b>Проверка по базе ФССП:</b></p>
    <?php
    if (null !== $fssp){
        $fssp = json_decode($fssp);

        if (is_array($fssp) || !property_exists($fssp,'empty') ) {
        ?>
    <table style="margin-left: auto; margin-right: auto; padding: 0;" width="100%" cellspacing="0" cellpadding="0">
        <tbody>
        <tr>
            <th style="border: solid 1px lightgray">Номер исполнительного док.</th>
            <th style="border: solid 1px lightgray">Реквизиты</th>
            <th style="border: solid 1px lightgray">Дата окончания</th>
            <th style="border: solid 1px lightgray">Предмет исполнения</th>
            <th style="border: solid 1px lightgray">Отдел ФССП</th>
            <th style="border: solid 1px lightgray">Представитель ФССП</th>
        </tr>
        <?php
        $total_summ = 0;
        foreach ($fssp as $fssp_item){
            $total_summ += $fssp_item->psumm;
        ?>
            <tr>
                <td style="border: solid 1px lightgray"><?=$fssp_item->docnum?></td>
                <td style="border: solid 1px lightgray"><?=$fssp_item->docid?></td>
                <td style="border: solid 1px lightgray"><?=$fssp_item->docedate?></td>
                <td style="border: solid 1px lightgray"><?=$fssp_item->summ?></td>
                <td style="border: solid 1px lightgray"><?=$fssp_item->fssp_div?></td>
                <td style="border: solid 1px lightgray"><?=$fssp_item->fssp_ex?></td>
            </tr>
          <?php } ?>
            </tbody>
            <tfoot>
                <tr>
                    <td style="border: solid 1px lightgray" colspan="3"></td>
                    <td style="border: solid 1px lightgray">Итого: <?=$total_summ?></td>
                    <td style="border: solid 1px lightgray" colspan="2"></td>
                </tr>
            </tfoot>
        </table>

    <?php } else {
            echo '<p style="text-align: center">Результатов не найдено</p>';
        }
    } else {
        echo '<p style="text-align: center">Проверка не проводилась.</p>';
    }?>

</div>

<?php if (null !== $scorista) {
    $packet = json_decode($scorista);
    ?>
    <p><b>Проверка по базе Административныx и уголовныx правонарушений:</b></p>
    <ul>
    <?php
        if ( intval($packet->data->cronos->result) > 0 ) {
            foreach ($packet->data->cronos->cronos as $cronosItems){
                echo '<li>'.$cronosItems.'</li>';
            };
        } else {
            echo '<p>'.$packet->data->cronos->textResult.'</p>';
        }
    ?>
    </ul>
<?php } ?>

</body>
</html>
