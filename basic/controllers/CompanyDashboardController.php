<?php
namespace app\controllers;

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
        $model = new CompanyDashboardForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->AddDriver();
            return $this->redirect('/company-dashboard');
        }
    }

    public function actionDeletedriver() {
        $model = new CompanyDashboardForm();

        if (null != Yii::$app->request->post('id')) {
            $model->deleteDriver(Yii::$app->request->post('id'));
        }

        return $this->_sendJSONAnswer(1);
    }

}
