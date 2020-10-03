<?php    
    use yii\helpers\Html;
    use kartik\date\DatePicker;
    use yii\widgets\ActiveForm;
?>

<div class="driver-profile">
    <table class="table table-borderless">
        <tbody>
            <tr>
                <th scope="row">Адрес электронной почты*:</th>
                <td>
                    <?= Html::tag('input', Html::encode($model['email']), ['class' => 'form-control', 'placeholder' => 'inbox@example.com' ]) ?>
                </td>
            </tr>                
            <tr>
                <th scope="row">Фамилия*:</th>
                <td>
                    <?= Html::tag('input', Html::encode($model->secondName), ['class' => 'form-control', 'placeholder' => 'Иванов' ]) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Имя*:</th>
                <td>
                    <?= Html::tag('input', Html::encode($model->firstName), ['class' => 'form-control', 'placeholder' => 'Иван' ]) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Отчество*:</th>
                <td>
                    <?= Html::tag('input', Html::encode($model->thirdName), ['class' => 'form-control', 'placeholder' => 'Иванович' ]) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Дата рождения*:</th>
                <td>                        
                    <?php                            
                        echo DatePicker::widget([
                            'model' => $model->birthDate,
                            'name' => 'birth-date',
                            'type' => DatePicker::TYPE_INPUT,
                            'value' => '',
                            'options' => ['placeholder' => '23.02.1982'],
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'dd.mm.yyyy'
                            ]
                        ]);
                    ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Серия паспорта*:</th>
                <td>
                    <?= Html::tag('input', Html::encode($model->passportSerial), ['class' => 'form-control', 'placeholder' => '0001' ]) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Номер паспорта*:</th>
                <td>
                    <?= Html::tag('input', Html::encode($model->passportNumber), ['class' => 'form-control', 'placeholder' => '000001' ]) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">ИНН*:</th>
                <td>
                    <?= Html::tag('input', Html::encode($model->inn), ['class' => 'form-control', 'placeholder' => '25500000000000' ]) ?>
                </td>
            </tr>                
            <tr>
                <th scope="row">Серия водительского удостоверения*:</th>
                <td>                        
                    <?= Html::tag('input', Html::encode($model->licenseSerial), ['class' => 'form-control', 'placeholder' => '0001' ]) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Номер водительского удостоверения*:</th>
                <td>                        
                    <?= Html::tag('input', Html::encode($model->licenseNumber), ['class' => 'form-control', 'placeholder' => '000001' ]) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Дата выдачи водительского удостоверения*:</th>
                <td id="driver-license-release">
                    <?php                            
                        echo DatePicker::widget([
                            'model' => $model->licenseRealeaseDate,
                            'name' => 'license-release-date',
                            'type' => DatePicker::TYPE_INPUT,
                            'value' => '',
                            'options' => ['placeholder' => '23.02.1982'],
                            'pluginOptions' => [
                                'autoclose'=>true,
                                'format' => 'dd.mm.yyyy'
                            ]
                        ]);
                    ?>                        
                </td>
            </tr>
        </tbody>        
    </table>
</div>
<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'method' => 'post']) ?>
