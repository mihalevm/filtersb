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


class PcheckForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    private function addPassportValidate ($rid, $content) {
        $this->db_conn->createCommand("update reports set passport=:content where id=:rid",
            [
                ':rid'     => null,
                ':content' => null
            ])
            ->bindValue(':rid',     intval($rid))
            ->bindValue(':content', $content )
            ->execute();

        return 0;
    }

    private function getHttpClient ( $service, $method = 'post' ) {
        $host = 'xn--b1afk4ade4e.xn--b1ab2a0a.xn--b1aew.xn--p1ai';
        $http = 'http://'.$host;
        $url  = $http.'/'.$service;

        $client = new Client();

        $response = $client->createRequest()
            ->setOptions([
                'timeout' => 2
            ])
            ->setMethod($method)
            ->setUrl($url)
            ->setHeaders([
                'Accept'           => 'text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8',
                'Accept-Encoding'  => 'gzip, deflate, br',
                'Accept-Language'  => 'ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
                'Cache-Control'    => 'max-age=0',
                'Connection'       => 'keep-alive',
                'Content-Type'     => 'application/x-www-form-urlencoded; charset=UTF-8',
                'Host'             => $host,
                'Referer'          => $http,
                'User-Agent'       => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0',
            ]);

        return $response;
    }

    public function getCaptcha() {
        $captcha  = [];
        $answer   = null;
        $request = $this->getHttpClient( 'services/captcha.jpg', 'get');

        try {
            $answer = $request->send();
        } catch (\Exception $e) {
            $answer = null;
        }

        if (null != $answer  && $answer->getIsOk() ){
            $session_cookies    = $answer->getCookies();
            $captcha['captcha'] = "data:image/jpeg;base64,".base64_encode($answer->content);
            $captcha['uid']     = $session_cookies->get('uid')->value;
            $captcha['jid']     = $session_cookies->get('JSESSIONID')->value;
            $captcha['error']   = 200;
        } else {
            $captcha['error'] = 500;
        }

        return $captcha;
    }

    private function parseContent ($html) {
        $dom = new \DOMDocument();
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_NOERROR);
        $data = "";

        $all_h4 = $dom->getElementsByTagName('h4');

        if ( $all_h4->length ) {
            $data = $all_h4->item(0)->nodeValue;
        }

        return $data;
    }

    public function getDriverInfo($did) {
        $arr = $this->db_conn->createCommand("select pserial, pnumber from userinfo where id=:did",[
            ':did' => null,
        ])
            ->bindValue(':did', $did)
            ->queryAll();

        return sizeof($arr) ? $arr[0]:null;
    }

    public function PassportValidate ($rid, $did, $captcha, $uid, $jid) {
        $answer = null;
        $check_result = [];
        $check_result['validate'] = 0;

        $driverInfo = $this->getDriverInfo($did);

        $request = $this->getHttpClient('info-service.htm');

        $request->setData([
            'sid'           => '2000',
            'form_name'     => 'form',
            'DOC_SERIE'	    => $driverInfo['pserial'],
            'DOC_NUMBER'    => $driverInfo['pnumber'],
            'captcha-input' => $captcha
        ]);

        $request->setCookies([
            ['name' => 'uid',        'value' => $uid],
            ['name' => 'JSESSIONID', 'value' => $jid]
        ]);

        try {
            $answer = $request->send();
        } catch (\Exception $e) {
            $answer = null;
        }

        if (null != $answer  && $answer->getIsOk() ){
            $check_result['data'] = $answer->content;
            $check_result['data'] = str_replace('\r\n', '', $check_result['data']);
            $check_result['data'] = str_replace('  ', '', $check_result['data']);
            $check_result['data'] = str_replace('\"', '"', $check_result['data']);

            $check_result['data'] = $this->parseContent($check_result['data']);

            if (strlen($check_result['data']) > 0) {
                $check_result['error']  = 200;

                if (strlen(strstr($check_result['data'], "Cреди недействительных не значится")) > 0) {
                    $check_result['validate'] = 1;
                }

                $this->addPassportValidate($rid, $check_result['data']);
                $check_result['data'] = 'Данные из базы МВД получены.<br/>Для продолжения формирования отчета нажмите кнопку "Далее"';

            } elseif (strlen($check_result['data']) == 0) {
                $check_result['data'] = 'Ошибка получения данных из базы МВД.<br/>Вы можете пропустить этот шаг нажав кнопку "Пропустиь"<br/>либо повторить попытку нажав кнопку "Повторить"';
                $check_result['error']  = 400;
            } else {
                $check_result['data'] = 'Данные из базы МВД получены.<br/>Для продолжения формирования отчета нажмите кнопку "Далее".';
                $check_result['error']  = 200;
            }
        } else {
            $check_result['data'] = 'Ошибка получения данных из базы МВД.<br/>Вы можете пропустить этот шаг нажав кнопку "Пропустиь"<br/>либо повторить попытку нажав кнопку "Повторить"';
            $check_result['error']  = 500;
        }

        return $check_result;
    }
}