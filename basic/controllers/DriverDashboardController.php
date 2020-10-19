<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\DriverDashboardForm;
use yii\data\ArrayDataProvider;


class DriverDashboardController extends Controller
{
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

        $model = new DriverDashboardForm();

        $allDriverReports = new ArrayDataProvider([
            'allModels' => $model->getDriverReports(),
//            'sort' => [
//                'attributes' => ['aid', 'aname', 'adesc'],
//            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $allDriverRequest = new ArrayDataProvider([
            'allModels' => $model->getDriverRequests(),
//            'sort' => [
//                'attributes' => ['aid', 'aname', 'adesc'],
//            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);


        return $this->render('index', [
            'model'     => $model,
            'myReports' => $this->renderPartial('driver-reports',  ['model' => $model, 'reports' => $allDriverReports ]),
            'myRequest' => $this->renderPartial('driver-request',  ['model' => $model, 'request' => $allDriverRequest, 'companyList' => $model->getAllCompany()]),
        ]);
    }

    public function actionSelectcompany($sc) {
        $model = new DriverDashboardForm();

        return $this->_sendJSONAnswer($model->selectCompany($sc));
    }

    public function actionDeleterequest($rid) {
        $model = new DriverDashboardForm();

        return $this->_sendJSONAnswer($model->DeleteRequest($rid));
    }
}
