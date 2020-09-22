<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\DriverDashboardForm;

class DriverDashboardController extends Controller
{
    public function actionIndex() {
        $model = new DriverDashboardForm();

        return $this->render('index', [
            'model'   => $model,
        ]);
    }
}
