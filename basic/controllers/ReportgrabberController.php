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
                $renderView = 'index';
            }
            if ( $r->post('s') == 'E') {
                $model = new EgrulForm();

                $res = $model->EgrulRequest($r->post('did'), $r->post('rid'));

                if (intval($res['code']) > 0 || null !=$res['message'] ) {
                    $renderView = 'egrul';

                    $params = [
                        'result'  => $res['code'],
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
                $renderView = 'payment';
                $params = [];
            }
        }

        return $this->renderPartial($renderView, $params);
    }

    public function actionGetreport($rid) {
        $model = new RepGeneratorForm();
        $pdf   = null;
        $mpdf  = new \Mpdf\Mpdf(['tempDir' => '/tmp']);
        $attrs = $model->getDocAttrs($rid);

        $html_template = $this->renderPartial('doc_template',[
                'rdate'     => $attrs['rdate'],
                'email'     => $attrs['email'],
                'pvalidate' => $attrs['pvalidate'],
                'egrul'     => $attrs['egrul'],
                'gibdd'     => $attrs['gibdd'],
                'fssp'      => $attrs['fssp'],
                'scorista'  => $attrs['scorista'],
            ]);

        $mpdf->WriteHTML($html_template);
        $pdf = $mpdf->Output();

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
            'email'     => $attrs['email'],
            'pvalidate' => $attrs['pvalidate'],
            'egrul'     => $attrs['egrul'],
            'gibdd'     => $attrs['gibdd'],
            'fssp'      => $attrs['fssp'],
            'scorista'  => $attrs['scorista'],
        ]);

        $mpdf->WriteHTML($html_template);
        $mpdf->Output($filename, 'F');

        Yii::$app->mailer->compose('email_report', $attrs)
            ->setTo(Yii::$app->user->identity->username)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setSubject('Отчет с сайта Фильтр СБ')
            ->attach($filename)
            ->send();

        return $this->_sendJSONAnswer(1);
    }

    public function actionMakepay ($did, $rid) {
        $model = new PaymentForm();
        $res   = $model->addPayment($did, $rid);

        return $this->_sendJSONAnswer($res);
    }
}
