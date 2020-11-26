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

class RegisterController extends Controller {
    private function _sendJSONAnswer($res){
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $res;

        return $response;
    }

    public function actionIndex() {
        $model = new RegisterForm();

        $formParams   = Yii::$app->request->post('RegisterForm');
        $registerType = Yii::$app->request->get('t');

        $model->scenario = $formParams['utype'] == 'D' ? 'driver' : 'company';

        if ($model->load(Yii::$app->request->post()) && $model->validate()){

            $model->sendConfirmation();

            return $this->render('confirm', [
                'model' => $model,
            ]);
        } else {
            return $this->render('index', [
                'model' => $model,
                'rtype' => (null != $registerType ? $registerType : 'D'),
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

    public function actionPromo(){
        $model = new RegisterForm();
        $r = Yii::$app->request;
        $promo_email = $model->getPromoEmail();

        if (null != $r->post('pemail') && null != $r->post('pname') && null != $promo_email) {
            Yii::$app->mailer->compose('email_promo', [
                    'email' => $r->post('pemail'),
                    'name'  => $r->post('pname'),
            ])
                ->setTo($promo_email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setSubject('Запрос на получение бесплатного отчета')
                ->send();
        }

        return $this->_sendJSONAnswer('1');
    }
}
