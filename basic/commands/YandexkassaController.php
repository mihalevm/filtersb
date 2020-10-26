<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 23.10.20
 * Time: 14:49
 */

namespace app\commands;

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\PaymentForm;

class YandexkassaController extends Controller {

    public function actionIndex(){
        $model = new PaymentForm();

        $model->checkPaymentsStatus();

        return ExitCode::OK;
    }

}