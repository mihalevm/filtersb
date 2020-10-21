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


class ScoristaForm extends Model {
    protected $db_conn;
    protected $username;
    protected $token;
    protected $nonce;
    protected $password;

    function __construct () {
        $this->db_conn  = Yii::$app->db;
        $this->username = 'mihalevmv@e-arbitrage.biz';
        $this->token    = '0d58f99f9d3cab6d4999edff748c8c21919d2749';
        $this->nonce    = sha1(uniqid(true));
        $this->password = sha1($this->nonce.$this->token);
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

    private function getHttpClient ( $params ) {
        $rest_url = 'https://api.scorista.ru/dossier/json';
        $client   = new Client();

        $response = $client->createRequest()
            ->setOptions([
                'timeout' => 10
            ])
            ->setMethod('post')
            ->setUrl($rest_url)
            ->setFormat(Client::FORMAT_JSON)
            ->setData($params)
            ->setHeaders([
//                'Accept'           => 'text/html,application/xhtml+xm…plication/xml;q=0.9,*/*;q=0.8',
//                'Accept-Encoding'  => 'gzip, deflate, br',
//                'Accept-Language'  => 'ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
//                'Cache-Control'    => 'max-age=0',
//                'Connection'       => 'keep-alive',
//                'Content-Type'     => 'application/x-www-form-urlencoded; charset=UTF-8',
//                'Host'             => $host,
//                'Referer'          => $http,
//                'User-Agent'       => 'Mozilla/5.0 (Windows NT 6.3; Win64; x64; rv:68.0) Gecko/20100101 Firefox/68.0',
                'username'         => $this->username,
                'nonce'            => $this->nonce,
                'password'         => $this->password
            ]);

        return $response->send();
    }
/*
    public function getDriverInfo($rid) {
        $arr = $this->db_conn->createCommand("SELECT i.*, r.payed FROM reports r, userinfo i WHERE r.id = :rid and r.oid = :oid AND r.did = i.id",[
            ':rid' => null,
            ':oid' => null,
        ])
            ->bindValue(':rid', $rid)
            ->bindValue(':oid', Yii::$app->user->identity->id)
            ->queryAll();

        return sizeof($arr) ? $arr[0]:null;
    }
*/
    public function getDriverInfo($did) {
        $arr = $this->db_conn->createCommand("SELECT i.*, 'Y' as payed FROM userinfo i WHERE i.id = :did",[
            ':did' => null,
        ])
            ->bindValue(':did', $did)
            ->queryAll();

        return sizeof($arr) ? $arr[0]:null;
    }


    public function Check($rid) {
        $answer = [];

        $userInfo = $this->getDriverInfo($rid);

        if ( null != $userInfo ) {
            if ( $userInfo['payed'] == 'Y' ) {
                if(
                    null != $userInfo['firstname'] &&
                    null != $userInfo['secondname'] &&
                    null != $userInfo['middlename'] &&
//Надо добавить пол
//                    null != $userInfo['sex'] &&
                    null != $userInfo['birthday'] &&
                    null != $userInfo['pserial'] &&
                    null != $userInfo['pnumber'] &&
                    null != $userInfo['pdate'] &&
                    null != $userInfo['raddress'] &&
                    null != $userInfo['laddress'] &&
                    null != $userInfo['personalphone']
                ) {
                    $raddress = json_decode($userInfo['raddress']);
                    $laddress = json_decode($userInfo['laddress']);

                    $req_packet = [
                        'form' => [
                            'persona' => [
                                'personalInfo'        => [
                                    'lastName'       => $userInfo['secondname'] ,
                                    'firstName'      => $userInfo['firstname'],
                                    'patronimic'     => $userInfo['middlename'],
                                    'gender'         => 1,
                                    'birthDate'      => date_format(date_create_from_format('Y-m-d', $userInfo['birthday']), 'd.m.Y'),
                                    'placeOfBirth'   => 'НЕТ',
                                    'passportSN'     => $userInfo['pserial'].' '.$userInfo['pnumber'],
                                    'issueDate'      => date_format(date_create_from_format('Y-m-d', $userInfo['pdate']), 'd.m.Y'),
                                    'issueAuthority' => 'НЕТ'
                                ],
                                'addressRegistration' => [
                                    'postIndex' => $raddress->postzip,
                                    'region'    => $raddress->region,
                                    'city'      => $raddress->city,
                                    'street'    => $raddress->street,
                                    'house'     => $raddress->house,
                                    'building'  => $raddress->build,
                                    'flat'      => $raddress->flat,
                                ],
                                'addressResidential'  => [
                                    'postIndex' => $laddress->postzip,
                                    'region'    => $laddress->region,
                                    'city'      => $laddress->city,
                                    'street'    => $laddress->street,
                                    'house'     => $laddress->house,
                                    'building'  => $laddress->build,
                                    'flat'      => $laddress->flat,
                                ],
                                'contactInfo'         => [
                                    'cellular' => $userInfo['personalphone']
                                ],
                                'cronos'              => 1
                            ]
                        ]
                    ];

                    $response = $this->getHttpClient($req_packet);

                    if ($response->getIsOk()) {
//                        {"status":"OK","requestid":"agrid5f8fb2224a75a"}
                        $jres = json_decode($response->content);

                        if (property_exists($jres, 'status') && $jres->status == 'OK') {
                            $answer = [
                                'code'    => 200,
                                'message' => $response->content
                            ];
                        } else {
                            $answer = [
                                'code'    => 500,
                                'message' => 'Ошибка запроса данных'
                            ];
                        }
                    } else {
                        $answer = [
                            'code'    => 500,
                            'message' => 'Ошибка запроса к серверу'
                        ];
                    }
                } else {
                    $answer = [
                        'code'    => 500,
                        'message' => 'Данные анкеты сотрудника не полные'
                    ];
                }
            } else {
                $answer = [
                    'code'    => 500,
                    'message' => 'Отчет не оплачен'
                ];
            }
        } else {
            $answer = [
                'code'    => 404,
                'message' => 'Данные отчета не найдены'
                ];
        }

        return $answer;
    }
}