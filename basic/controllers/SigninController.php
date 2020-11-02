<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 11.09.20
 * Time: 20:57
 */

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\SigninForm;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;


class SigninController extends Controller {

    private function _sendJSONAnswer($res){
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $res;

        return $response;
    }

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

/**
 * Displays Sign-in form.
 *
 * @return string
**/
    public function actionIndex() {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->user->identity->utype =='D' ? '/driver-dashboard' : '/company-dashboard' );
        }

        $model = new SigninForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Yii::$app->user->identity->utype =='D' ? '/driver-dashboard' : '/company-dashboard' );
        }

        $model->password = '';
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionRestoreRequest($email){
        $model = new SigninForm();

        return $this->_sendJSONAnswer($model->sendRestore($email));
    }

    public function actionRestoreConfirm($h){
        $model = new SigninForm();

        return $this->render('restore', [
            'hash' => ($model->confirmHashIsExist($h)?$h:null),
        ]);
    }

    public function actionRestoreAccept($p, $h){
        $model = new SigninForm();

        return $this->_sendJSONAnswer($model->acceptRestore($p, $h));
    }
}
