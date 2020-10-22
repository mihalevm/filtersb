<?php
/**
 * Created by PhpStorm.
 * User: mmv
 * Date: 05.08.2019
 * Time: 11:15
 */

namespace app\models;

use Yii;
use yii\httpclient\Client;
use yii\base\Model;


class PaymentForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn  = Yii::$app->db;
    }

    public function addPayment ($did) {
        $this->db_conn->createCommand("insert into reports (oid, did) values (:oid, :did)",
            [
                ':oid'     => null,
                ':did'     => null,
            ])
            ->bindValue(':oid', intval(Yii::$app->user->identity->id))
            ->bindValue(':did', $did)
            ->execute();

        $rid = Yii::$app->db->getLastInsertID();

        $this->db_conn->createCommand("insert into scorista (oid, rid) values (:oid, :rid)",
            [
                ':oid'     => null,
                ':rid'     => null,
            ])
            ->bindValue(':oid', intval(Yii::$app->user->identity->id))
            ->bindValue(':rid', $rid)
            ->execute();

        return $rid;
    }
}