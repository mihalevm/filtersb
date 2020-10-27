<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class DriverDashboardForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    public function getDriverReports () {
        $arr = $this->db_conn->createCommand("SELECT cast(r.cdate as date) as cdate, r.id, r.payed, (if(r.egrul IS NULL, FALSE, TRUE) and if(r.fssp IS NULL, FALSE, TRUE) AND  if(r.passport IS NULL, FALSE, TRUE) and if(r.passport IS NULL, FALSE, TRUE) and if((r.scorista IS NULL and r.payed='Y') or r.payed='N' , FALSE, TRUE) ) as completed FROM reports r WHERE r.oid=r.did and r.did=:did order by cdate desc", [
            ':did'  => null,
        ])
            ->bindValue(':did',  intval((Yii::$app->user->identity->id)) )
            ->queryAll();

        return $arr;
    }

    public function getDriverRequests () {
        $arr = $this->db_conn->createCommand("SELECT distinct t.id, cast(t.rdate as date) as rdate, t.reqby, i.companyname FROM tcdrivers t, userinfo i WHERE t.did=:did AND t.tid=i.id order by rdate desc", [
            ':did'  => null,
        ])
            ->bindValue(':did',  intval((Yii::$app->user->identity->id)) )
            ->queryAll();

        return $arr;
    }

    public function getAllCompany() {
        $arr = $this->db_conn->createCommand("SELECT distinct i.id, i.companyname FROM users u, userinfo i WHERE u.id=i.id AND u.utype='C' and i.companyname is not null AND u.id NOT IN (SELECT tid FROM  tcdrivers WHERE did=:did)", [
            ':did'  => null,
        ])
            ->bindValue(':did',  intval((Yii::$app->user->identity->id)) )
            ->queryAll();

        return ArrayHelper::map($arr, 'id', 'companyname');
    }

    public function selectCompany($sc) {
        $cid = explode(',', $sc);

        foreach ($cid as &$tid) {
            $this->db_conn->createCommand("insert into tcdrivers (did, tid, reqby) values (:did, :tid, 'R')",
                [
                    ':did' => null,
                    ':tid' => null,
                ])
                ->bindValue(':did', Yii::$app->user->identity->id)
                ->bindValue(':tid', $tid)
                ->execute();
        }

        return Yii::$app->db->getLastInsertID();
    }

    public function DeleteRequest($rid) {
        $this->db_conn->createCommand("delete from tcdrivers where id=:id and did=:did",
            [
                ':id' => null,
                ':did' => null,
            ])
            ->bindValue(':did', Yii::$app->user->identity->id)
            ->bindValue(':id', $rid)
            ->execute();

        return 1;
    }
}
