<?php    
    use yii\helpers\Html;
    use kartik\date\DatePicker;
    use yii\bootstrap\ActiveForm;    

    $form = ActiveForm::begin([
        'id' => 'driver-profile-edit-form'       
    ]);
    
    
?>

<div class="driver-profile">
    <table class="table table-borderless">
        <tbody>
            <tr>
                <td>
                    <?= $form->errorSummary($model) ?>
                </td>
            </tr>    
            <tr>
                <th scope="row">Адрес электронной почты*:</th>
                <td>
                    <?= $form->field($model, 'email')->textInput(['value' => Yii::$app->user->identity->username, 'placeholder' => 'inbox@example.com'])->label(false) ?>
                </td>
            </tr>                
            <tr>
                <th scope="row">Фамилия*:</th>
                <td>
                    <?= $form->field($model, 'secondName')->textInput(['value' => $profile['secondname'], 'placeholder' => 'Иванов'])->label(false) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Имя*:</th>
                <td>
                    <?= $form->field($model, 'firstName')->textInput(['value' => $profile['firstname'], 'placeholder' => 'Иван'])->label(false) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Отчество*:</th>
                <td>
                    <?= $form->field($model, 'thirdName')->textInput(['value' => $profile['middlename'], 'placeholder' => 'Иванович'])->label(false) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Дата рождения*:</th>
                <td class="form-group">
                    <?php                            
                        echo DatePicker::widget([
                            'model' => 'birthDate',
                            'name' => 'birth-date',
                            'type' => DatePicker::TYPE_INPUT,
                            'value' => $profile['birthday'],
                            'options' => ['placeholder' => '23.02.1982'],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd.mm.yyyy'
                            ]
                        ]);
                    ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Серия паспорта*:</th>
                <td>                    
                    <?= $form->field($model, 'passportSerial')->textInput(['value' => $profile['pserial'], 'placeholder' => '0001'])->label(false) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Номер паспорта*:</th>
                <td>
                    <?= $form->field($model, 'passportNumber')->textInput(['value' => $profile['pnumber'], 'placeholder' => '000001'])->label(false) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">ИНН*:</th>
                <td>
                    <?= $form->field($model, 'inn')->textInput(['value' => $profile['inn'], 'placeholder' => '25500000000000'])->label(false) ?>
                </td>
            </tr>                
            <tr>
                <th scope="row">Серия водительского удостоверения*:</th>
                <td>
                    <?= $form->field($model, 'licenseSerial')->textInput(['value' => $profile['dserial'], 'placeholder' => '0001'])->label(false) ?>
                </td>
            </tr>
            <tr>
                <th scope="row">Номер водительского удостоверения*:</th>
                <td>
                    <?= $form->field($model, 'licenseSerial')->textInput(['value' => $profile['dnumber'], 'placeholder' => '000001'])->label(false) ?>                    
                </td>
            </tr>
            <tr>
                <th scope="row">Дата выдачи водительского удостоверения*:</th>
                <td id="driver-license-release">
                    <?php                            
                        echo DatePicker::widget([
                            'model' => 'licenseRealeaseDate',
                            'name' => 'license-release-date',
                            'type' => DatePicker::TYPE_INPUT,
                            'value' => $profile['ddate'],
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

<?php ActiveForm::end(); ?>
