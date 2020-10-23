<?php
/**
 * Created by PhpStorm.
 * User: mmv
 * Date: 05.08.2019
 * Time: 11:15
 */

namespace app\models;

use Yii;
use yii\base\Model;
use YandexCheckout\Client;


class PaymentForm extends Model {
    protected $db_conn;
    protected $secretKey;
    protected $shopID;

    function __construct () {
        $this->db_conn   = Yii::$app->db;
        $this->secretKey = Yii::$app->params['yandexk_secretKey'];
        $this->shopID    = Yii::$app->params['yandexk_shopID'];
    }

    public function checkPaymentsStatus () {
        $payments = $this->db_conn->createCommand("select id, payid from reports where payed='N' and payid is not null",[])->queryAll();

        if ( count($payments) > 0 ) {
            $yclient = new Client();
            $yclient->setAuth($this->shopID, $this->secretKey);

            foreach ($payments as $payItem) {
                $paymentStatus = $yclient->getPaymentInfo($payItem['payid']);

                if ('succeeded' == $paymentStatus->getStatus()) {
                    $this->db_conn->createCommand("update reports set payed='Y' where id=:rid",
                        [
                            ':rid' => null,
                        ])
                        ->bindValue(':rid', $payItem['id'])
                        ->execute();
                }

                if ('canceled' == $paymentStatus->getStatus()) {
                    $this->db_conn->createCommand("update reports set payid=NULL where id=:rid",
                        [
                            ':rid' => null,
                        ])
                        ->bindValue(':rid', $payItem['id'])
                        ->execute();
                }
            }
        }
    }

    public function addPayment ($did, $rid) {
        $answer = [
            'code' => 500,
            'rid'  => $rid,
            'rurl' => null
        ];

        if (null == $rid) {
            $this->db_conn->createCommand("insert into reports (oid, did) values (:oid, :did)",
                [
                    ':oid' => null,
                    ':did' => null,
                ])
                ->bindValue(':oid', intval(Yii::$app->user->identity->id))
                ->bindValue(':did', $did)
                ->execute();

            $rid = Yii::$app->db->getLastInsertID();

            $this->db_conn->createCommand("insert into scorista (oid, rid) values (:oid, :rid)",
                [
                    ':oid' => null,
                    ':rid' => null,
                ])
                ->bindValue(':oid', intval(Yii::$app->user->identity->id))
                ->bindValue(':rid', $rid)
                ->execute();
        }

        if ($rid) {
            $yclient = new Client();
            $yclient->setAuth($this->shopID, $this->secretKey);

            try {
                $payment = $yclient->createPayment(
                    array(
                        'amount' => array(
                            'value' => 400,
                            'currency' => 'RUB',
                        ),
                        'confirmation' => array(
                            'type' => 'redirect',
                            'return_url' => Yii::$app->request->hostInfo,
                        ),
                        'capture' => true,
                        'description' => 'Покупка на сайте ' . Yii::$app->request->hostInfo . ' платного отчета №' . $rid,
                    ),
                    uniqid('', true)
                );
            } catch (\Exception $e) {
                \Yii::warning('[Yandex kassa] '.$e->getMessage());
                $rid = null;
            }

            if ($rid) {
                $redirect_url = $payment->getConfirmation()->getConfirmationUrl();

                if ($redirect_url) {
                    $this->db_conn->createCommand("update reports set payid=:payid where id=:rid",
                        [
                            ':payid' => null,
                            ':rid' => null,
                        ])
                        ->bindValue(':payid', $payment->getId())
                        ->bindValue(':rid', $rid)
                        ->execute();

                    $answer = [
                        'code' => 200,
                        'rid' => $rid,
                        'rurl' => $redirect_url
                    ];
                }
            }
        }

        return $answer;
    }
}