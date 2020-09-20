<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class DriverProfileController extends Controller
{

  public function actionIndex() 
  {
    return $this->render('/driverprofile/index.php');
  }
}
