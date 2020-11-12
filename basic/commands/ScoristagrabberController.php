<?php
/**
 * Created by PhpStorm.
 * User: max
 * Date: 21.10.20
 * Time: 20:53
 * Use from comand line: php yii scoristagrabber
 */

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use app\models\ScoristaForm;

class ScoristagrabberController extends Controller {

    public function actionIndex(){
        $model = new ScoristaForm();

        $model->addOrder();
        $rids = $model->getRequestedContent();

        foreach ($rids as $rid) {
            $pdf   = null;
            $mpdf  = new \Mpdf\Mpdf(['tempDir' => '/tmp']);
            $attrs = $model->getDocAttrs($rid);
            $filename = '/tmp/report'.$rid.'.pdf';

            $html_template = $this->renderPartial('/reportgrabber/doc_template',[
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

                if ( intval($packet->data->cronos->result) > 0 ) {
                    $mpdf->AddPage();
                    $mpdf->WriteHTML($packet->data->cronos->html);
                }
            }

            $mpdf->Output($filename, 'F');

            Yii::$app->mailer->compose('email_report', $attrs)
                ->setTo($attrs['oemail'])
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setSubject('Отчет с сайта Фильтр СБ')
                ->attach($filename)
                ->send();

            unlink($filename);
        }

        return ExitCode::OK;
    }

}