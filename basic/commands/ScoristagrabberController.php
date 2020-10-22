<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 21.10.20
 * Time: 20:53
 * Use from comand line: php yii scoristagrabber
 */

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\ScoristaForm;

class ScoristagrabberController extends Controller {

    public function actionIndex(){
        $model = new ScoristaForm();

        $model->addOrder();
        $model->getRequestedContent();

        return ExitCode::OK;
    }

}