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

class GibddForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    private function gibdd_fetch ( $dcard, $rdate ) {
        $script = '/usr/bin/node /opt/gibdd/gibdd_dev.js';
        $ans = [];

        if ($dcard && $rdate) {
            exec($script.' '.$dcard.' '.$rdate, $ans);
        }

        return count($ans)>0 ? array_pop($ans): null;
    }

    public function getDriverInfo($did) {
        $arr = $this->db_conn->createCommand("select dserial, dnumber, ddate from userinfo where id=:did",[
            ':did' => null,
        ])
            ->bindValue(':did', $did)
            ->queryAll();

        return sizeof($arr) ? $arr[0]:null;
    }

    private function addGibddValidate ($rid, $content) {
        $this->db_conn->createCommand("update reports set gibdd=:content where id=:rid",
            [
                ':rid'     => null,
                ':content' => null
            ])
            ->bindValue(':rid',     intval($rid))
            ->bindValue(':content', $content )
            ->execute();

        return 0;
    }

    public function Check($rid, $did) {
        $answer = null;
        $result = 'Ошибка получения данных из базы ГИБДД.';
        $driverInfo = $this->getDriverInfo($did);

        $answer = $this->gibdd_fetch($driverInfo['dserial'].$driverInfo['dnumber'], $driverInfo['ddate']);

        $janswer = json_decode($answer);

        if(null !== $janswer && property_exists($janswer, 'code') && intval($janswer->code) == 100) {
            $this->addGibddValidate($rid, $answer);
            $result = 1;
        }

        return $result;
    }
}