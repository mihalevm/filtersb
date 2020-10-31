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

class RepGeneratorForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    public function getDocAttrs($rid) {
        $attrs = [
            'error' => 500
        ];

        $reports = $this->db_conn->createCommand("select oid, cdate, egrul, fssp, passport, gibdd, scorista, (select username from users where id=did) as demail, (select username from users where id=oid) as oemail from reports where id=:rid and oid=:oid",[
                ':rid' => null,
                ':oid' => null,
            ])
                ->bindValue(':rid', $rid)
                ->bindValue(':oid', Yii::$app->user->identity->id)
                ->queryAll();

        if ( sizeof($reports) ) {
            $attrs['rdate']  = $reports[0]['cdate'];
            $attrs['demail'] = $reports[0]['demail'];
            $attrs['oemail'] = $reports[0]['oemail'];
            $attrs['pvalidate'] = strlen(strstr($reports[0]['passport'], "Среди недействительных не значится")) > 0 ? 1 : 0;
            $attrs['egrul'] = $reports[0]['egrul'];
            $attrs['gibdd'] = $reports[0]['gibdd'];
            $attrs['fssp']  = $reports[0]['fssp'];
            $attrs['scorista'] = $reports[0]['scorista'];
            $attrs['error'] = 200;
        }

        return $attrs;
    }
}