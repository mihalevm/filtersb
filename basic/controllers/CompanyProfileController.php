<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\CompanyProfileForm;

class CompanyProfileController extends Controller
{
    public function actionIndex() {
        if ( Yii::$app->user->isGuest ) {
            return $this->redirect('/signin');
        }

        $model = new CompanyProfileForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->saveCompanyProfile();
        }

        return $this->render('index', [
            'model'   => $model,
            'profile' => $model->getCompanyProfile()
        ]);
    }
}
