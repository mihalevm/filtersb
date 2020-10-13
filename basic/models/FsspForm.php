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

class FsspForm extends Model {
    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    private function addFsspItem ( $rid, $content ) {
        $this->db_conn->createCommand("update reports set fssp=:content where id=:rid",
        [
            ':rid'     => null,
            ':content' => null
        ])
            ->bindValue(':rid',     intval($rid))
            ->bindValue(':content', $content )
            ->execute();

        return 0;
    }

    private function getHttpClient ( $sid ) {
        $host = 'is.fssprus.ru';
        $http = 'https://'.$host;
        $url  = $http.'/ajax_search';

        $client = new Client();

        $response = $client->createRequest()
            ->setOptions([
                'timeout' => 2
            ])
            ->setMethod('get')
            ->setUrl($url)
            ->setHeaders([
                'Accept'           => 'application/json, text/javascript, */*; q=0.01',
                'Accept-Encoding'  => 'gzip, deflate, br',
                'Accept-Language'  => 'ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
                'Cache-Control'    => 'no-cache',
                'Connection'       => 'keep-alive',
                'Content-Type'     => 'application/x-www-form-urlencoded; charset=UTF-8',
                'Host'             => $host,
                'Pragma'           => 'no-cache',
                'Referer'          => $http,
                'User-Agent'       => 'runscope/0.1,Mozilla/5.0 (X11; Ubuntu; Linux i686; rv:39.0) Gecko/20100101 Firefox/39.0',
                'X-Requested-With' => 'XMLHttpRequest',
                'Cookie'           => 'connect.sid='.$sid.';',
            ]);

        return $response;
    }

    private function parseContent ($html, $did, $rid) {
        $dom = new \DOMDocument();
        $dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'), LIBXML_NOERROR);
        $result = [];

        $all_tr = $dom->getElementsByTagName('tr');

        foreach ($all_tr as $tr) {
            $node = $tr->childNodes;

            if ($node->length > 1 && $node->item(5)->nodeName == 'td'){
                $matches = null;
                preg_match('/^(.+):\s(\d+\.\d\d)/U', $node->item(5)->nodeValue, $matches);
                if (strcasecmp('Исполнительский сбор', $matches[1]) !== 0){
                    array_push($result, [
                        'docnum'   => $node->item(1)->nodeValue,
                        'docid'    => $node->item(2)->nodeValue,
                        'docedate' => $node->item(3)->nodeValue,
                        'summ'     => $node->item(5)->nodeValue,
                        'psumm'    => floatval($matches[2]),
                        'fssp_div' => $node->item(6)->nodeValue,
                        'fssp_ex'  => $node->item(7)->nodeValue
                    ]);
                }
            }
        }

        if ( count($result)>0 ) {
            $this->addFsspItem($rid, json_encode($result));
        } else {
            $result = [
                'empty' => 'По вашему запросу ни чего не найдено.'
            ];

            $this->addFsspItem($rid, json_encode($result));
        }

        return $rid;
    }

    public function getDriverInfo($did) {
        $arr = $this->db_conn->createCommand("select firstname, secondname, middlename, birthday from userinfo where id=:did",[
            ':did' => null,
        ])
            ->bindValue(':did', $did)
            ->queryAll();

        return sizeof($arr) ? $arr[0]:null;
    }

    public function Send_Grab($rid, $did, $sid, $code) {
        $driverInfo = $this->getDriverInfo($did);

        $ts       = time();
        $response = $this->getHttpClient($sid);
        $answer   = null;

        $response->setData([
            'is' =>[
                'ip_preg'    => '',
                'variant'    => '1',
                'last_name'  => $driverInfo['secondname'],
                'first_name' => $driverInfo['firstname'],
                'patronymic' => $driverInfo['middlename'],
                'date'       => $driverInfo['birthday'],
                'drtr_name'  => '',
                'address'    => '',
                'ip_number'  => '',
                'id_number'  => '',
                'id_type'    => [],
                'id_issuer'  => '',
                'region_id'  => [-1],
                'extended'   => 1,
            ],
            'code'     => $code,
            'nocache'  => 1,
            'system'   => 'ip',
            'callback' => 'jQuery340016456929004994936_'.$ts,
            '_'        => $ts,
        ]);

        try {
            $answer = $response->send();
        } catch (\Exception $e) {
            $answer = null;
        }

        if (null != $answer  && $answer->getIsOk() ){
            if (!strstr($answer->content, "Неверно введен код") ) {
                $matches = null;
                preg_match('/\(\{\"data\":\"(.+)\",\"/', $answer->content, $matches);
                $answer = null;
                $content = $matches[1];
                $content = str_replace('\r\n', '', $content );
                $content = str_replace('  ', '', $content   );
                $content = str_replace('\"', '"', $content  );

                $this->parseContent($content, $did, $rid);
                $answer['data']  = 'Данные из базы ФССП получены.';
                $answer['error'] = 200;
            } else {
                $answer = null;
                $answer['data'] = 'Код с картинки введен не верно.';
                $answer['error'] = 400;
            }
        } else {
            $answer['data'] = 'Сервис временно не доступен';
            $answer['error'] = 500;
        }

        return $answer;
    }

    public function GetCaptcha() {
        $captcha = [];

        $response = $this->getHttpClient('');

        $response->setData([
            'is' =>[
                'ip_preg'    => '',
                'variant'    => '1',
                'drtr_name'  => '',
                'address'    => '',
                'ip_number'  => '',
                'id_number'  => '',
                'id_type'    => [],
                'id_issuer'  => '',
                'region_id'  => [-1],
                'extended'   => 1,
            ],
            'nocache' => 1,
            'system'  => 'ip',
        ]);

        try {
            $answer = $response->send();
        } catch (\Exception $e) {
            $answer = null;
        }

        if (null != $answer  && $answer->getIsOk() ){
            $matches = null;
            preg_match('/\"(data:image.+)\\\"\sid=\\\"capchaVisual/', $answer->content, $matches);
            $captcha['captcha'] = $matches[1];
            $captcha['cookies'] = $answer->getCookies();
            $captcha['error']   = 200;

            if ($captcha['cookies']->get('connect.sid')) {
                $captcha['cookies'] = $captcha['cookies']->get('connect.sid')->value;
            }
        } else {
            $captcha['captcha'] = '';
            $captcha['cookies'] = '';
            $captcha['error']   = 500;
        }

        return $captcha;
    }
}