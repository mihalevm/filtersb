<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\DriverProfileForm;
use app\models\DriverProfileExtendedForm;
use app\models\DriverProfileWorkplaceForm;
use app\models\DriverProfileAddressForm;

class DriverProfileController extends Controller
{

	public function actionIndex() 
	{
		if ( Yii::$app->user->isGuest ) {
			return $this->redirect('/signin');
		}

        $step           = 0;
		$model          = new DriverProfileForm();
		$extendedModel  = new DriverProfileExtendedForm();
		$workplaceModel = new DriverProfileWorkplaceForm();
		$addressModel   = new DriverProfileAddressForm();

		if ($model->load(Yii::$app->request->post()) && $model->validate()){
			$model->saveDriverProfile();
            $step = 1;
		}
		
		if ($extendedModel->load(Yii::$app->request->post()) && $extendedModel->validate()){
			$extendedModel->saveDriverProfileExtended();
            $step = 2;
		}

        if ($addressModel->load(Yii::$app->request->post()) && $addressModel->validate()){
            $addressModel->saveDriverProfile();
            $step = 3;
        }

		if ($workplaceModel->load(Yii::$app->request->post()) && $workplaceModel->validate()){
			$workplaceModel->saveDriverProfileWorkplace();
			$this->redirect('/');
			return;
		}

		return $this->render('index', [
		  	'driverInfo' => $this->renderPartial('driver-info', [
				'model'   => $model,
				'profile' => $model->getDriverProfile()
			]),
		  	'driverInfoExtended' => $this->renderPartial('driver-info-extended', [
				'model' => $extendedModel,
				'profile' => $extendedModel->getDriverProfile(),
				'dic_tachograph' => $extendedModel->getDicTachograph(),
				'dic_trailertype' => $extendedModel->getDicTrailerType(),
                'companyList' => $extendedModel->getAllCompany(),
			]),
            'driverAddress' => $this->renderPartial('driver-address', [
                'model'   => $addressModel,
                'profile' => $model->getDriverProfile()
            ]),
		  	'driverPreviousWork' => $this->renderPartial('driver-previous-work', [
				'model' => $workplaceModel,
				'profile' => $workplaceModel->getDriverProfileWorkplace()				
			]),
            'step' => $step,
		]);
	}

	public function actionPreviousWorksList()
	{
		if (Yii::$app->user->isGuest) {
            return $this->redirect('/signin');
		}
		
		$model = new DriverProfileWorkplaceForm();
		$workplaceModel = $model->getDriverProfileWorkplaceList();

		return $this-> _sendJSONAnswer($workplaceModel);
	}

	private function _sendJSONAnswer($res)
	{
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $res;

        return $response;
    }
}
