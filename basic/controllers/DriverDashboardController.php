<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\DriverDashboardForm;

class DriverDashboardController extends Controller
{
    public function actionIndex() {
        if ( Yii::$app->user->isGuest ) {
            return $this->redirect('/signin');
        }

        $model = new DriverDashboardForm();

        return $this->render('index', [
            'model'   => $model,
        ]);
    }
}
