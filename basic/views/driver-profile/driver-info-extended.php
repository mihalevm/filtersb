<?php
    use yii\helpers\Html;
    use kartik\date\DatePicker;
?>

<div class="driver-profile-extended">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="table-danger row">Контактный телефон*:</th>
                <td>
                    <?= Html::tag('input', Html::encode($model->mainNumber), ['class' => 'form-control', 'placeholder' => '+79998884411' ]) ?>
                </td>
            </tr>                
            <tr>
                <th scope="row">Телефоны родственников (2 человека)*:</th>
                <td>
                    <label>тел №1: </label><?= Html::tag('input', Html::encode($model->relativesNumber1), ['class' => 'form-control', 'placeholder' => '+79998884411' ]) ?><br>
                    <label>тел №2: </label><?= Html::tag('input', Html::encode($model->relativesNumber2), ['class' => 'form-control', 'placeholder' => '+79998884411' ]) ?>
                </td>                
            </tr>
            <tr>
                <th scope="row">Семейное положение*:</th>
                <td>
                    <?= Html::dropDownList('med-card', 'null', ['0' => 'Холост(а)', '1' => 'В браке']) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Дети, пол и возраст*:</th>
                <td>
                    <textarea class="form-control" rows="10"></textarea>                        
                </td>
            </tr>
            <tr>
                <th scope="row">Стаж вождения именно по категории “С” (лет)*:</th>
                <td>
                    <input type="text" class="form-control" placeholder="10">
                </td>
            </tr>
            <tr>
                <th scope="row">Стаж вождения именно по категории “Е” (лет)*:</th>
                <td>
                    <input type="text" class="form-control" placeholder="10">
                </td>
            </tr>
            <tr>
                <th scope="row" >Имеется ли карта тахографа, выбрать из списка (можно выбрать несколько)*:</th>
                <td>                                     
                    <?= Html::dropDownList('tachograph', $dic_tachograph[3], $dic_tachograph) ?>
                </td>
            </tr>
            <tr>
                <th scope="row" >Какими прицепами управляли, выбрать из списка (можно выбрать несколько)*</th>
                <td id="trailers-pick">
                    <?= Html::dropDownList('tachograph', $dic_trailertype[1], $dic_trailertype) ?><br><br>
                    <label>Свой вариант:</label><input type="text" class="form-control">
                </td>
            </tr>
            <tr>
                <th scope="row">Марки транспортных средств, которыми управляли на последних местах работы*:</th>
                <td>
                    <textarea class="form-control" rows="10"></textarea>
                </td>
            </tr>                
            <tr>
                <th scope="row">Имеется ли у вас загран.паспорт*:</th>
                <td>                        
                    <?= Html::dropDownList('international-passport', 'null', ['0' => 'Нет', '1' => 'Да']) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Сведения о судимости, арестах (да/нет, если есть год и статья)*:</th>
                <td>
                    <?= Html::dropDownList('conviction', 'null', ['0' => 'Нет', '1' => 'Да']) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Наличие долгов, неоплаченных счетов, выплаты алиментов*:</th>
                <td>
                    <textarea class="form-control" rows="10"></textarea>  
                </td>
            </tr>
            <tr>
                <th scope="row">Наличие медицинской книжки (да/нет)*:</th>
                <td>
                    <?= Html::dropDownList('med-card', 'null', ['0' => 'Нет', '1' => 'Да']) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Когда вы готовы приступить к работе*:</th>
                <td>
                    <textarea class="form-control" rows="5"></textarea>
                </td>
            </tr>
            <tr>
                <th scope="row" style="word-wrap: break-word;min-width: 160px;max-width: 160px;">Опыт работы (укажите три последних места фактической работы, начиная с последнего в обратном хронологическом порядке)*:</th>
                <td>
                    <?php
                        echo '<label class="control-label">Дата приёма и увольнения</label>';
                        echo DatePicker::widget([
                            'language' => 'ru',
                            'name' => 'work-1-employment-date',
                            'value' => '',
                            'options' => ['placeholder' => '23.02.1982'],
                            'type' => DatePicker::TYPE_RANGE,
                            'name2' => 'work-1-quit-date',
                            'value2' => '',
                            'options2' => ['placeholder' => '26.02.1982'],
                            'separator'=>' до ', 
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd.mm.yyyy',                                    
                            ]
                        ]);                        
                    ?><br>
                    <label>Название организации</label><input type="text" class="form-control"><br>
                    <label>Должность</label><input type="text" class="form-control"><br>
                    <label>Содержание деятельности</label><textarea class="form-control" rows="5"></textarea><br>
                    <label>Причина увольнения</label><input type="text" class="form-control"><br>
                    <label>Кто может дать рекомендации с даннного места работы (ФИО, контакт для связи)</label><textarea class="form-control" rows="10"></textarea>
                    <br>
                    <p>
                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Добавить место работы
                        </a>
                    </p>
                    <div class="collapse" id="collapseExample2">
                        <div class="card card-body">
                            <?php
                                echo '<label class="control-label">Дата приёма и увольнения</label>';
                                echo DatePicker::widget([
                                    'language' => 'ru',
                                    'name' => 'work-2-employment-date',
                                    'value' => '',
                                    'options' => ['placeholder' => '23.02.1982'],
                                    'type' => DatePicker::TYPE_RANGE,
                                    'name2' => 'work-2-quit-date',
                                    'value2' => '',
                                    'options2' => ['placeholder' => '23.02.1982'],
                                    'separator'=>' до ', 
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'dd.mm.yyyy',                                    
                                    ]
                                ]);                        
                            ?><br>
                            <label>Название организации</label><input type="text" class="form-control"><br>
                            <label>Должность</label><input type="text" class="form-control"><br>
                            <label>Содержание деятельности</label><textarea class="form-control" rows="5"></textarea><br>
                            <label>Причина увольнения</label><input type="text" class="form-control"><br>
                            <label>Кто может дать рекомендации с даннного места работы (ФИО, контакт для связи)</label><textarea class="form-control" rows="10"></textarea>
                        </div>                       
                    </div><br>
                    <p>
                        <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample">
                            Добавить место работы
                        </a>
                    </p>
                    <div class="collapse" id="collapseExample3">
                        <div class="card card-body">
                            <?php
                                echo '<label class="control-label">Дата приёма и увольнения</label>';
                                echo DatePicker::widget([
                                    'language' => 'ru',
                                    'name' => 'work-3-employment-date',
                                    'value' => '',
                                    'options' => ['placeholder' => '23.02.1982'],
                                    'type' => DatePicker::TYPE_RANGE,
                                    'name2' => 'work-3-quit-date',
                                    'value2' => '',
                                    'options2' => ['placeholder' => '23.02.1982'],
                                    'separator'=>' до ', 
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'format' => 'dd.mm.yyyy',                                    
                                    ]
                                ]);                        
                            ?><br>
                            <label>Название организации</label><input type="text" class="form-control"><br>
                            <label>Должность</label><input type="text" class="form-control"><br>
                            <label>Содержание деятельности</label><textarea class="form-control" rows="5"></textarea><br>
                            <label>Причина увольнения</label><input type="text" class="form-control"><br>
                            <label>Кто может дать рекомендации с даннного места работы (ФИО, контакт для связи)</label><textarea class="form-control" rows="10"></textarea>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th scope="row">Согласна ли ваша семья/близкие родственники работе вахтовым методом*: </th>
                <td>
                    <?= Html::dropDownList('fly-in-accept', 'null', ['0' => 'Нет', '1' => 'Да']) ?>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="agreement-personal-data">
        <label class="form-check-label" for="agreement-personal-data">Cогласие на обработку персональных данных.</label>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="agreement-third-party">
        <label class="form-check-label" for="agreement-third-party">Cогласие на то, что достоверность указанных данных будет проверяться третьими лицами.</label>
    </div>
    <div class="form-check">
        <input type="checkbox" class="form-check-input" id="agreement-comments">
        <label class="form-check-label" for="agreement-comments">Cогласие на комментирование со стороны транспортных компаний.</label>
    </div><br>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'method' => 'post']) ?>    
</div> 
