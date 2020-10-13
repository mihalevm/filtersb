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

class EgrulForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    private function _sendFirstRequest($key) {
        $client = new Client();

        $response = $client->createRequest()
            ->setMethod('post')
            ->setUrl('https://egrul.nalog.ru/')
            ->setHeaders([
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Accept-Language' => 'ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive',
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'Host' => 'egrul.nalog.ru',
                'Pragma' => 'no-cache',
                'Referer' => 'https://egrul.nalog.ru/',
                'User-Agent' => 'runscope/0.1,Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:39.0) Gecko/20100101 Firefox/39.0',
                'X-Requested-With' => 'XMLHttpRequest'
            ]);

        $response->setData([
            'vyp3CaptchaToken' => '',
            'query' =>	$key,
            'region' => '',
            'PreventChromeAutocomplete' => '',
        ]);

        return $response->send();
    }

    private function _sendSecondRequest($key, $t1, $t2) {
        $client = new Client();

        $response = $client->createRequest()
            ->setMethod('get')
            ->setUrl('https://egrul.nalog.ru/search-result/'.$key)
            ->setHeaders([
                'Accept' => 'application/json, text/javascript, */*; q=0.01',
                'Accept-Encoding' => 'gzip, deflate, br',
                'Accept-Language' => 'ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
                'Cache-Control' => 'no-cache',
                'Connection' => 'keep-alive',
                'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
                'Host' => 'egrul.nalog.ru',
                'Pragma' => 'no-cache',
                'Referer' => 'https://egrul.nalog.ru/',
                'User-Agent' => 'runscope/0.1,Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:39.0) Gecko/20100101 Firefox/39.0',
                'X-Requested-With' => 'XMLHttpRequest'
            ]);

        $response->setData([
            'r' => $t1,
            '_' => $t2,
        ]);

        return $response->send();
    }

    private function addDriverData ($did, $rid, $json) {
        $res = null;

        if ( intval($rid) > 0 ) {
            $this->db_conn->createCommand("update reports set egrul=:egrul where did=:did and oid=:oid and id=:rid",
                [
                    ':did' => null,
                    ':oid' => null,
                    ':rid' => null,
                    ':egrul' => null
                ])
                ->bindValue(':did', intval($did))
                ->bindValue(':rid', intval($rid))
                ->bindValue(':oid', Yii::$app->user->identity->id)
                ->bindValue(':egrul', $json)
                ->execute();

            $res = $rid;
        } else {
            $this->db_conn->createCommand("insert into reports (did, oid, egrul) values (:did, :oid, :egrul)",
                [
                    ':did' => null,
                    ':oid' => null,
                    ':egrul' => null
                ])
                ->bindValue(':did', $did)
                ->bindValue(':oid', Yii::$app->user->identity->id)
                ->bindValue(':egrul', $json)
                ->execute();

            $res = Yii::$app->db->getLastInsertID();
        }

        return $res;
    }

    public function getDriverINN ($did) {
        $arr = $this->db_conn->createCommand("select inn from userinfo where id=:did",[
            ':did' => null,
        ])
            ->bindValue(':did', $did)
            ->queryAll();

        return sizeof($arr) ? $arr[0]['inn']:null;
    }

    public function EgrulRequest($did, $rid){
        $inn  = intval($this->getDriverINN($did));

        $res = 0;
        $first_time_mark = round(microtime(true) * 1000);

        if ($inn > 0) {
            $res = $this->_sendFirstRequest($inn);

            if ($res->getIsOk()) {
                $res = json_decode($res->content);
                if (property_exists($res, 't')) {
                    $second_time_mark = round(microtime(true) * 1000);
                    $res = $this->_sendSecondRequest($res->t, $first_time_mark, $second_time_mark);
                    if ($res->getIsOk()) {
                        $content = $res->content;
                        $res = json_decode($content);
                        if (property_exists($res, 'rows')) {
                            if (sizeof($res->rows) > 0) {
                                $res = $this->addDriverData($did, $rid, $content);
                            } else {
                                $res = 'Указанный ИНН водителя не найден в базе ЕГРЮЛ';
                            }
                        } else {
                            $res = 'Указанный ИНН водителя не найден в базе ЕГРЮЛ';
                        }
                    } else {
                        $res = 'Ошибка запроса в базу ЕГРЮЛ';
                    }
                } else {
                    $res = 'Ошибка запроса в базу ЕГРЮЛ';
                }
            } else {
                $res = 'Ошибка запроса в базу ЕГРЮЛ';
            }
        } else {
            $res = 'ИНН водителя неверно задан в профиле';
        }

        return $res;
    }
}