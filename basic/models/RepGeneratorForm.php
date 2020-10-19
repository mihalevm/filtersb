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

    private function parseContent ($html) {
        $data = [];

        if (null !=$html && strlen(strstr($html, "empty")) == 0) {
            $dom = new \DOMDocument();
            $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_NOERROR);
            $all_tr = $dom->getElementsByTagName('tr');

            foreach ($all_tr as $tr) {
                $node = $tr->childNodes;

                if ($node->length > 1 && $node->item(5)->nodeName == 'td') {
                    $matches = null;
                    preg_match('/^(.+):\s(\d+\.\d\d)/U', $node->item(5)->nodeValue, $matches);
                    if (strcasecmp('Исполнительский сбор', $matches[1]) !== 0) {
                        $data = [
                            'owner' => $node->item(0)->nodeValue,
                            'doc_num' => $node->item(1)->nodeValue,
                            'doc_id' => $node->item(2)->nodeValue,
                            'doc_edate' => $node->item(3)->nodeValue,
                            'summ' => $node->item(2)->nodeValue,
                            'psumm' => floatval($matches[2]),
                            'fssp_div' => $node->item(6)->nodeValue,
                            'fssp_ex' => $node->item(7)->nodeValue
                        ];
                    }
                }
            }
        }

        return $data;
    }

    public function getDocAttrs($rid) {
        $attrs = [
            'error' => 500
        ];

        $reports = $this->db_conn->createCommand("select oid, cdate, egrul, fssp, passport, gibdd from reports where id=:rid and oid=:oid",[
            ':rid' => null,
            ':oid' => null,
        ])
            ->bindValue(':rid', $rid)
            ->bindValue(':oid', Yii::$app->user->identity->id)
            ->queryAll();

        if ( sizeof($reports) ) {
            $attrs['rdate'] = $reports[0]['cdate'];
            $attrs['email'] = Yii::$app->user->identity->username;
            $attrs['pvalidate'] = strlen(strstr($reports[0]['passport'], "Cреди недействительных не значится")) > 0 ? 1 : 0;
            $attrs['egrul'] = $reports[0]['egrul'];
            $attrs['gibdd'] = $reports[0]['gibdd'];
            $attrs['fssp']  = $this->parseContent($reports[0]['fssp']);
            $attrs['error'] = 200;
        }

        return $attrs;
    }
}