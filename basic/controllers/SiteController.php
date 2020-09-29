<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class SiteController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex() {

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->user->identity->utype =='D' ? '/driver-dashboard' : '/company-dashboard' );
        }

        return $this->render('index');
    }
}
