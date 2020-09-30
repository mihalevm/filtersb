<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 15.09.20
 * Time: 19:55
 */
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\RegisterForm;

class RegisterController extends Controller
{
    public function actionIndex() {
        $model = new RegisterForm();

        $formParams = Yii::$app->request->post('RegisterForm');

        $model->scenario = $formParams['utype'] == 'D' ? 'driver' : 'company';

        if ($model->load(Yii::$app->request->post()) && $model->validate()){

            $model->sendConfirmation();

            return $this->render('confirm', [
                'model' => $model,
            ]);
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }

    }

    public function  actionConfirm($h){
        $model = new RegisterForm();

        if (isset($h)) {
            $model->activateAccount($h);

            return $this->render('confirmed', [
                'model' => $model,
            ]);
        } else {
            return $this->render('index', [
                'model' => $model,
            ]);
        }
    }

}
