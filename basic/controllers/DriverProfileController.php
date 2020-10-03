<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\DriverProfileForm;

class DriverProfileController extends Controller
{

	public function actionIndex() 
	{
		if ( Yii::$app->user->isGuest ) {
			return $this->redirect('/signin');
		}

		$model = new DriverProfileForm();
		$dic_tachograph = $model->getDicTachograph();
		$dic_trailertype = $model->getDicTrailerType();

		header('Content-type: text/plain');

    print_r($model);

    exit;
		
		if ($model->load(Yii::$app->request->post()) && $model->validate()){
			$model->saveDriverProfile();
		}
		
		return $this->render('/driver-profile/index', [                             
		  'driverInfo' => $this->renderPartial('driver-info', ['model' => $model ->getDriverProfile()]),
		  'driverInfoExtended' => $this->renderPartial('driver-info-extended', ['model' => $model,'dic_tachograph' => $dic_tachograph, 'dic_trailertype' => $dic_trailertype]),
		]);
	}
}
