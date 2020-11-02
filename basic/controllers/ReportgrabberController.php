<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\EgrulForm;
use app\models\FsspForm;
use app\models\PcheckForm;
use app\models\GibddForm;
use app\models\RepGeneratorForm;
use app\models\ScoristaForm;
use app\models\PaymentForm;

class ReportgrabberController extends Controller {

    private function _sendJSONAnswer($res){
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $res;

        return $response;
    }

    private function _sendPDFDoc($res){
        $response = Yii::$app->response;
        $response->headers->add('appliction','octet-stream');
        $response->headers->add('Content-disposition','attachment; filename="doc01.pdf"');
        $response->format = \yii\web\Response::FORMAT_RAW;
        $response->data = $res;

        return $response;
    }

    public function actionIndex() {
        if ( Yii::$app->user->isGuest ) {
            return $this->redirect('/signin');
        }

        $r = Yii::$app->request;
        $renderView = 'error';
        $params = [];

        if ( null != $r->post('s') && null != $r->post('did') && intval($r->post('did')) > 0 ) {
            if ( $r->post('s') == 'S') {
                $payedContent = false;

                $payModel = new PaymentForm();
                $reportPrice = $payModel->getScoristaPrice();

                if (null != $r->post('rid') && intval($r->post('rid'))>0){
                    $model= new RepGeneratorForm();
                    $conetnt = $model->getDocAttrs($r->post('rid'));
                    $payedContent = null != $conetnt['scorista'];
                }

                $renderView = 'index';

                $params = [
                    'payedContent'  => $payedContent,
                    'price' => $reportPrice,
                ];
            }
            if ( $r->post('s') == 'E') {
                $model = new EgrulForm();

                $res = $model->EgrulRequest($r->post('did'), $r->post('rid'));

                if (intval($res['code']) > 0 || null !=$res['message'] ) {
                    $renderView = 'egrul';

                    $params = [
                        'result'  => $res['code'],
                        'rid'     => $res['rid'],
                        'message' => $res['message']
                    ];
                }
            }
            if ($r->post('s') == 'F') {
                $model = new FsspForm();

                if ( null != $r->post('sid') && null != $r->post('code') ) {
                    return $this->_sendJSONAnswer($model->Send_Grab($r->post('rid'),$r->post('did'),$r->post('sid'),$r->post('code')));
                } else {
                    $renderView = 'fssp';
                    $params = [
                        'session' => $model->GetCaptcha(),
                        'rid'     => $r->post('rid')
                    ];
                }
            }
            if ($r->post('s') == 'P') {
                $model = new PcheckForm();

                if ( null != $r->post('uid') && null != $r->post('jid') && null != $r->post('code') ) {
                    return $this->_sendJSONAnswer(
                        $model->PassportValidate(
                            $r->post('rid'),
                            $r->post('did'),
                            $r->post('code'),
                            $r->post('uid'),
                            $r->post('jid')
                        )
                    );
                } else {
                    $renderView = 'passport';
                    $params = [
                        'session' => $model->GetCaptcha(),
                        'rid'     => $r->post('rid')
                    ];
                }
            }
            if ( $r->post('s') == 'G') {
                $model = new GibddForm();

                $res = $model->Check($r->post('rid'), $r->post('did'));

                $renderView = 'gibdd';

                $params = [
                    'result' => $res,
                    'rid'    => $r->post('rid')
                ];
            }
            if ( $r->post('s') == 'finish') {
                $renderView = 'finish';

                $params = [
                    'rid' => $r->post('rid')
                ];
            }
            if ( $r->post('s') == 'prep') {
                $model = new ScoristaForm();

                $res = $model->Check($r->post('rid'), $r->post('did'), 'validate');

                $renderView = 'scorista';

                $params = [
                    'result' => $res,
                ];
            }
            if ( $r->post('s') == 'pay') {
                $renderView  = 'payment';
                $payModel    = new PaymentForm();
                $reportPrice = $payModel->getScoristaPrice();

                $params = [
                    'price' => $reportPrice,
                ];
            }
        }

        return $this->renderPartial($renderView, $params);
    }

    public function actionGetreport($rid) {
        $model = new RepGeneratorForm();
        $pdf   = null;
        $mpdf  = new \Mpdf\Mpdf(['tempDir' => '/tmp']);
        $attrs = $model->getDocAttrs($rid);

        if( $attrs['error'] == 200 ) {
            $html_template = $this->renderPartial('doc_template', [
                'rdate'     => $attrs['rdate'],
                'email'     => $attrs['demail'],
                'pvalidate' => $attrs['pvalidate'],
                'egrul'     => $attrs['egrul'],
                'gibdd'     => $attrs['gibdd'],
                'fssp'      => $attrs['fssp'],
                'scorista'  => $attrs['scorista'],
            ]);

            $mpdf->WriteHTML($html_template);

            if (null != $attrs['scorista']) {
                $packet = json_decode($attrs['scorista']);

                $mpdf->AddPage();
                $mpdf->WriteHTML($packet->data->cronos->html);
            }

            $pdf = $mpdf->Output();
        }

        return $pdf ? $this->_sendPDFDoc($pdf) : '';
    }

    public function actionSendreport($rid) {
        $model = new RepGeneratorForm();
        $pdf   = null;
        $mpdf  = new \Mpdf\Mpdf(['tempDir' => '/tmp']);
        $attrs = $model->getDocAttrs($rid);
        $filename = '/tmp/report'.$rid.'.pdf';

        $html_template = $this->renderPartial('doc_template',[
            'rdate'     => $attrs['rdate'],
            'email'     => $attrs['demail'],
            'pvalidate' => $attrs['pvalidate'],
            'egrul'     => $attrs['egrul'],
            'gibdd'     => $attrs['gibdd'],
            'fssp'      => $attrs['fssp'],
            'scorista'  => $attrs['scorista'],
        ]);

        $mpdf->WriteHTML($html_template);

        if (null != $attrs['scorista']) {
            $packet = json_decode($attrs['scorista']);

            $mpdf->AddPage();
            $mpdf->WriteHTML($packet->data->cronos->html);
        }

        $mpdf->Output($filename, 'F');

        Yii::$app->mailer->compose('email_report', $attrs)
            ->setTo($attrs['oemail'])
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setSubject('Отчет с сайта Фильтр СБ')
            ->attach($filename)
            ->send();

        return $this->_sendJSONAnswer(1);
    }

    public function actionMakepay ($did, $rid = null) {
        $model = new PaymentForm();
        $res   = $model->addPayment($did, $rid, $model->getScoristaPrice());

        return $this->_sendJSONAnswer($res);
    }
}
