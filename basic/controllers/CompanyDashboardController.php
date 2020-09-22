<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\CompanyDashboardForm;

class CompanyDashboardController extends Controller
{
    public function actionIndex() {
        $model = new CompanyDashboardForm();

        return $this->render('index', [
            'model'   => $model,
        ]);
    }
}
