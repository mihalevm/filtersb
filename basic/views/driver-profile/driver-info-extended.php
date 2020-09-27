<?php
    use yii\helpers\Html;    
?>

<div class="driver-profile-extended">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th scope="table-danger row">Контактный телефон*:</th>
                    <td>
                        <input type="text" class="form-control" placeholder="+79998884411">
                    </td>
                </tr>                
                <tr>
                    <th scope="row">Телефоны родственников (2 человека)*:</th>
                    <td>
                        <input type="text" class="form-control" placeholder="+79998884411">         
                    </td>
                </tr>
                <tr>
                    <th scope="row">Семейное положение*:</th>
                    <td>
                        <input type="text" class="form-control" placeholder="холост">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Дети, пол и возраст*:</th>
                    <td>
                        <input type="text" class="form-control" placeholder="текст">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Стаж вождения именно по категории “С” (лет)*:</th>
                    <td>
                        <input type="text" class="form-control" placeholder="текст">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Стаж вождения именно по категории “Е” (лет)*:</th>
                    <td>
                        <input type="text" class="form-control" placeholder="текст">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Имеется ли карта тахографа, выбрать из списка (можно выбрать несколько)*:</th>
                    <td> 
                        <!-- Undefined variable: dic_tachograph -->                      
                        <? //Html::dropDownList('tachograph', $dic_tachograph) ?>
                    </td>
                </tr>
                <tr>
                    <th scope="row">Марки транспортных средств, которыми управляли на последних местах работы*:</th>
                    <td>
                        <input type="text" class="form-control" placeholder="текст">
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
                        <input type="text" class="form-control" placeholder="текст">
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
                        <input type="text" class="form-control" placeholder="текст">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Опыт работы (укажите три последних места фактической работы, начиная с последнего в обратном хронологическом порядке)*:</th>
                    <td>
                        <input type="text" class="form-control" placeholder="текст"><br>
                        <input type="text" class="form-control" placeholder="текст"><br>
                        <input type="text" class="form-control" placeholder="текст"><br>
                        <input type="text" class="form-control" placeholder="текст"><br>
                        <input type="text" class="form-control" placeholder="текст"><br>
                        <input type="text" class="form-control" placeholder="текст"><br>
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
    </div>
