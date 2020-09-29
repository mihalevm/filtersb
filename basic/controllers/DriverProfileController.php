<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\DriverProfile;

class DriverProfileController extends Controller
{

	public function actionIndex() 
	{
		$model = new DriverProfile();
		$dic_tachograph = $model->getDicTachograph();
		$dic_trailertype = $model->getDicTrailerType();
		
		return $this->render('/driver-profile/index', [                             
		  'driverInfo' => $this->renderPartial('driver-info', ['model' => $model]),
		  'driverInfoExtended' => $this->renderPartial('driver-info-extended', ['model' => $model,'dic_tachograph' => $dic_tachograph, 'dic_trailertype' => $dic_trailertype]),
		]);
	}
}
