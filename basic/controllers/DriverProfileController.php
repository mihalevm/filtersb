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

        return $this->render('/driver-profile/index', [          
          'dic_tachograph' => $dic_tachograph,
          'driverInfo' => $this->renderPartial('driver-info'),
          'driverInfoExtended' => $this->renderPartial('driver-info-extended'),
        ]);
    }
}
