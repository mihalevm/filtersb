<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\DriverProfileForm;
use app\models\DriverProfileExtendedForm;
use app\models\DriverProfileWorkplaceForm;

class DriverProfileController extends Controller
{

	public function actionIndex() 
	{
		if ( Yii::$app->user->isGuest ) {
			return $this->redirect('/signin');
		}

		$model = new DriverProfileForm();
		$extendedModel = new DriverProfileExtendedForm();
		$workplaceModel = new DriverProfileWorkplaceForm();
		$dic_tachograph = $extendedModel->getDicTachograph();
		$dic_trailertype = $extendedModel->getDicTrailerType();
		
		if ($model->load(Yii::$app->request->post()) && $model->validate()){
			$model->saveDriverProfile();
		}
		
		if ($extendedModel->load(Yii::$app->request->post()) && $extendedModel->validate()){
			$extendedModel->saveDriverProfileExtended();
		}
		
		if ($workplaceModel->load(Yii::$app->request->post()) && $workplaceModel->validate()){
			$workplaceModel->saveDriverProfileWorkplace();
		}	

		return $this->render('/driver-profile/index', [			                             
		  	'driverInfo' => $this->renderPartial('driver-info', [
				'model'   => $model,
				'profile' => $model->getDriverProfile()
			]),
		  	'driverInfoExtended' => $this->renderPartial('driver-info-extended', [
				'model' => $extendedModel,
				'profile' => $extendedModel->getDriverProfile(),
				'dic_tachograph' => $dic_tachograph,
				'dic_trailertype' => $dic_trailertype
			]),
		  	'driverPreviousWork' => $this->renderPartial('driver-previous-work', [
				'model' => $workplaceModel,
				'profile' => $workplaceModel->getDriverProfileWorkplace(),
			]),
		]);
	}
}
