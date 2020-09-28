<?php    
    use yii\helpers\Html;
    use kartik\date\DatePicker;    
?>

<div class="driver-profile">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="table-danger row">Адрес электронной почты*:</th>
                <td>
                    <?= Html::tag('input', Html::encode($model->email), ['class' => 'form-control', 'placeholder' => 'inbox@example.com' ]) ?>                        
                </td>
            </tr>                
            <tr>
                <th scope="row">Фамилия*:</th>
                <td>
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
                    <?php                            
                        echo DatePicker::widget([
                            'name' => 'driver-birth-date-picker',
                            'type' => DatePicker::TYPE_INPUT,
                            'value' => '23.02.1982',
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'dd-mm-yyyy'
                            ]
                        ]);
                    ?>                   
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
                    <?php                            
                        echo DatePicker::widget([
                            'name' => 'driver-license-release-date-picker',
                            'type' => DatePicker::TYPE_INPUT,
                            'value' => '23.02.1982',
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'dd-mm-yyyy'
                            ]
                        ]);
                    ?>                        
                </td>
            </tr>
        </tbody>        
    </table>
</div>
