<?php

/* @var $this yii\web\View */

$this->title = 'Профиль водителя';
?>

<div class="site-index">
    <br/>
    <p><h2 style="text-align: center">Профиль водителя</h2></p>
    <br>
    <br>
    <div class="driver-profile">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th scope="table-danger row">Адрес электронной почты*:</th>
                    <td>
                        <input type="email" class="form-control" placeholder="name@example.com">
                    </td>
                </tr>                
                <tr>
                    <th scope="row">Фамилия*:</th>
                    <td>
                    <!-- <input type="text" class="form-control" placeholder=""> -->
                        <input type="text" class="form-control" placeholder="Иванов">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Имя*:</th>
                    <td>                       
                        <input type="text" class="form-control" placeholder="Иван">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Отчество*:</th>
                    <td>                    
                        <input type="text" class="form-control" placeholder="Иванович">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Дата рождения*:</th>
                    <td>                        
                        <input type="text" class="form-control" placeholder="1.01.2000">                 
                    </td>
                </tr>
                <tr>
                    <th scope="row">Серия паспорта*:</th>
                    <td>                        
                        <input type="text" class="form-control" placeholder="0001">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Номер паспорта*:</th>
                    <td>                        
                        <input type="text" class="form-control" placeholder="000001">
                    </td>
                </tr>
                <tr>
                    <th scope="row">ИНН*:</th>
                    <td>                        
                        <input type="text" class="form-control" placeholder="25500000000000">
                    </td>
                </tr>                
                <tr>
                    <th scope="row">Серия и номер водительского удостоверения*:</th>
                    <td>                        
                        <input type="text" class="form-control" placeholder="АВ0000000001">
                    </td>
                </tr>
                <tr>
                    <th scope="row">Дата выдачи водительского удостоверения*:</th>
                    <td id="driver-license-release">
                        <div class="input-group date">
                            <input type="text" class="form-control" value="01-01-2010">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>        
        </table>
    </div>
    <br>
    <h3>Дополнительная информация о водителе</h3>
    <div class="driver-profile-extended">
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <th scope="table-danger row">Контактный телефон*:</th>
                    <td></td>
                </tr>                
                <tr>
                    <th scope="row">Телефоны родственников (2 человека)*:</th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">Семейное положение*:</th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">Дети, пол и возраст*:</th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">Стаж вождения именно по категории “С” (лет)*:</th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">Стаж вождения именно по категории “Е” (лет)*:</th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">Имеется ли карта тахографа, выбрать из списка (можно выбрать несколько)*:</th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">Марки транспортных средств, которыми управляли на последних местах работы*:</th>
                    <td></td>
                </tr>                
                <tr>
                    <th scope="row">Имеется ли у вас загран.паспорт*:</th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">Сведения о судимости, арестах (да/нет, если есть год и статья)*:</th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">Наличие долгов, неоплаченных счетов, выплаты алиментов*:</th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">Наличие медицинской книжки (да/нет)*:</th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">Когда вы готовы приступить к работе*:</th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">Опыт работы (укажите три последних места фактической работы, начиная с последнего в обратном хронологическом порядке)*:</th>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row">Выберите из списка организации, в которой хотели бы работать (перечислить ТК и дать возможность указать свой, если нет в списке)*:</th>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>