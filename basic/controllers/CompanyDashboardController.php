<?php
namespace app\controllers;

use kartik\form\ActiveForm;
use Yii;
use yii\web\Controller;
use app\models\CompanyDashboardForm;
use yii\data\ArrayDataProvider;

class CompanyDashboardController extends Controller {

    private function _sendJSONAnswer($res){
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $res;

        return $response;
    }

    public function actionIndex() {
        if ( Yii::$app->user->isGuest ) {
            return $this->redirect('/signin');
        }


        $model = new CompanyDashboardForm();

        $allCompanyDrivers = new ArrayDataProvider([
            'allModels' => $model->selectCompanyDrivers('T'),
//            'sort' => [
//                'attributes' => ['aid', 'aname', 'adesc'],
//            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $allRequestedDrivers = new ArrayDataProvider([
            'allModels' => $model->selectCompanyDrivers('R'),
//            'sort' => [
//                'attributes' => ['aid', 'aname', 'adesc'],
//            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        return $this->render('index', [
            'model'    => $model,
            'sdrivers' => $this->renderPartial('selected-drivers',  ['model' => $model, 'drivers' => $allCompanyDrivers   ]),
            'rdrivers' => $this->renderPartial('requested-drivers', ['model' => $model, 'drivers' => $allRequestedDrivers ]),
        ]);
    }

    public function actionAdddriver() {
        if ( Yii::$app->user->isGuest ) {
            return $this->redirect('/signin');
        }

        $model = new CompanyDashboardForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->AddDriver();
            return $this->redirect('/company-dashboard');
        }

        return $this->_sendJSONAnswer(ActiveForm::validate($model));
    }

    public function actionDeletedriver() {
        if ( Yii::$app->user->isGuest ) {
            return $this->redirect('/signin');
        }

        $model = new CompanyDashboardForm();

        if (null != Yii::$app->request->post('id')) {
            $model->deleteDriver(Yii::$app->request->post('id'));
        }

        return $this->_sendJSONAnswer(1);
    }

    public function actionGetdriverinfo($id) {
        if ( Yii::$app->user->isGuest ) {
            return $this->redirect('/signin');
        }

        $model = new CompanyDashboardForm();
        $dinfo = $model->getDriverInfo($id);
        $workplace = null;
        $companyset = null;

        if (null != $dinfo) {
            $workplace = $model->getDriverWorkPlace($dinfo['id']);

            if (null != $dinfo['companyset']){
                $companyset = $model->getSelectedCompanyName($dinfo['companyset']);
            }
        }

        return $this->renderPartial('driver-info', [
            'model'      => $model,
            'dinfo'      => $dinfo,
            'wplace'     => $workplace,
            'companyset' => $companyset,
        ]);
    }

    public function actionGetdriverreport($id) {
        if ( Yii::$app->user->isGuest ) {
            return $this->redirect('/signin');
        }

        $model = new CompanyDashboardForm();

        $allReports = new ArrayDataProvider([
            'allModels' => $model->getCompanyReports($id),
            'sort' => [
                'attributes' => ['cdate'],
            ],
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);


        return $this->renderPartial('driver-reports', [
            'model'   => $model,
            'dinfo'   => $model->getDriverInfo($id),
            'reports' => $allReports,
        ]);
    }

    public function actionGetdrivercoments($id) {
        if ( Yii::$app->user->isGuest ) {
            return $this->redirect('/signin');
        }

        $model = new CompanyDashboardForm();

        $driverComents = new ArrayDataProvider([
            'allModels' => $model->getDriverComents($id),
            'sort' => [
                'attributes' => ['cdate'],
            ],
            'pagination' => [
                'pageSize' => 5,
            ],
        ]);

        return $this->renderPartial('driver-comments', [
            'model'   => $model,
            'coments' => $driverComents,
            'dinfo'   => $model->getDriverInfo($id)
        ]);
    }

    public function actionSavecoment(){
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/signin');
        }
        $r = Yii::$app->request;
        $model = new CompanyDashboardForm();

        if (null != $r->post('did') && null != $r->post('r') && null != $r->post('t')) {
           $model->saveComment($r->post('did'), $r->post('r'), $r->post('t'));
        }

        return $this->_sendJSONAnswer(1);
    }

    public function actionSaverait(){
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/signin');
        }
        $r = Yii::$app->request;
        $model = new CompanyDashboardForm();

        if (null != $r->post('id') && null != $r->post('v')) {
            $model->saveRait($r->post('id'), $r->post('v'));
        }

        return $this->_sendJSONAnswer(1);
    }

    public function actionDemployment($id){
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/signin');
        }

        $model = new CompanyDashboardForm();

        $model->driver_employment($id);

        return $this->_sendJSONAnswer(1);
    }
}
