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
    protected $rest_url;

    function __construct () {
        $this->db_conn  = Yii::$app->db;
        $this->username = Yii::$app->params['scorista_username'];
        $this->token    = Yii::$app->params['scorista_token'];
        $this->nonce    = sha1(uniqid(true));
        $this->password = sha1($this->nonce.$this->token);
        $this->rest_url = Yii::$app->params['scorista_rest_url'];
    }

    private function addScoristaRequest ($rid, $scrid) {
        $this->db_conn->createCommand("insert into scorista (oid, rid, scrid) values (:oid, :rid, :scrid)",
            [
                ':oid'     => null,
                ':rid'     => null,
                ':scrid'   => null,
            ])
            ->bindValue(':oid',   intval(Yii::$app->user->identity->id))
            ->bindValue(':rid',   $rid)
            ->bindValue(':scrid', $scrid)
            ->execute();

        return Yii::$app->db->getLastInsertID();
    }

    private function getHttpClient ( $params ) {
        $client   = new Client();

        $response = $client->createRequest()
            ->setOptions([
                'timeout' => 10
            ])
            ->setMethod('post')
            ->setUrl($this->rest_url)
            ->setFormat(Client::FORMAT_JSON)
            ->setData($params)
            ->setHeaders([
                'username'         => $this->username,
                'nonce'            => $this->nonce,
                'password'         => $this->password
            ]);

        return $response->send();
    }

    public function getDriverInfoReq($rid) {
        $arr = $this->db_conn->createCommand("SELECT i.*, r.payed FROM reports r, userinfo i WHERE r.id = :rid and r.oid = :oid AND r.did = i.id",[
            ':rid' => null,
            ':oid' => null,
        ])
            ->bindValue(':rid', $rid)
            ->bindValue(':oid', Yii::$app->user->identity->id)
            ->queryAll();

        return sizeof($arr) ? $arr[0]:null;
    }

    public function getDriverInfoVal($did) {
        $arr = $this->db_conn->createCommand("SELECT *, 'Y' as payed FROM userinfo WHERE id=:did",[
            ':did' => null,
        ])
            ->bindValue(':did', $did)
            ->queryAll();

        return sizeof($arr) ? $arr[0]:null;
    }

    public function Check($rid, $did, $type) {
        $answer = [];

        $userInfo = ($type == 'validate' ? $this->getDriverInfoVal($did) : $this->getDriverInfoReq($rid));

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

                    if (
                        null != $raddress->region &&
                        null != $raddress->city &&
                        null != $raddress->street &&
                        (null != $raddress->house || null != $raddress->build || null != $raddress->flat) &&
                        null != $laddress->region &&
                        null != $laddress->city &&
                        null != $laddress->street &&
                        (null != $laddress->house || null != $laddress->build || null != $laddress->flat)
                    ) {
                        if ($type !== 'validate') {
                            $req_packet = [
                                'form' => [
                                    'persona' => [
                                        'personalInfo' => [
                                            'lastName' => $userInfo['secondname'],
                                            'firstName' => $userInfo['firstname'],
                                            'patronimic' => $userInfo['middlename'],
                                            'gender' => 1,
                                            'birthDate' => date_format(date_create_from_format('Y-m-d', $userInfo['birthday']), 'd.m.Y'),
                                            'placeOfBirth' => 'НЕТ',
                                            'passportSN' => $userInfo['pserial'] . ' ' . $userInfo['pnumber'],
                                            'issueDate' => date_format(date_create_from_format('Y-m-d', $userInfo['pdate']), 'd.m.Y'),
                                            'issueAuthority' => 'НЕТ'
                                        ],
                                        'addressRegistration' => [
                                            'postIndex' => $raddress->postzip,
                                            'region' => $raddress->region,
                                            'city' => $raddress->city,
                                            'street' => $raddress->street,
                                            'house' => $raddress->house,
                                            'building' => $raddress->build,
                                            'flat' => $raddress->flat,
                                        ],
                                        'addressResidential' => [
                                            'postIndex' => $laddress->postzip,
                                            'region' => $laddress->region,
                                            'city' => $laddress->city,
                                            'street' => $laddress->street,
                                            'house' => $laddress->house,
                                            'building' => $laddress->build,
                                            'flat' => $laddress->flat,
                                        ],
                                        'contactInfo' => [
                                            'cellular' => $userInfo['personalphone']
                                        ],
                                        'cronos' => 1
                                    ]
                                ]
                            ];

                            $response = $this->getHttpClient($req_packet);

                            if ($response->getIsOk()) {
                                $jres = json_decode($response->content);
//                            $jres = json_decode('{"status":"OK","requestid":"agrid5f8fb2224a75a"}');

                                if (property_exists($jres, 'status') && $jres->status == 'OK') {
                                    if ($this->addScoristaRequest($rid, $jres->requestid) > 0) {
                                        $answer = [
                                            'code' => 200,
                                            'message' => 'Ваш запрос поставлен в очередь.'
                                        ];
                                    } else {
                                        $answer = [
                                            'code' => 500,
                                            'message' => 'Ошибка добаления запроса в очередь'
                                        ];
                                    }
                                } else {
                                    $answer = [
                                        'code' => 500,
                                        'message' => 'Ошибка запроса данных'
                                    ];
                                }
                            } else {
                                $answer = [
                                    'code' => 500,
                                    'message' => 'Ошибка запроса к серверу'
                                ];
                            }
                        } else {
                            $answer = [
                                'code' => 200,
                                'message' => 'Данные сотрудника валидны'
                            ];
                        }
                    } else {
                        $answer = [
                            'code'    => 500,
                            'message' => 'Адрес проживания либо регистрации задан не верно'
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

/*
 * Console part
 *
 * */

    private function updateScoristaOrders ($id, $status, $msg) {
        $this->db_conn->createCommand("update scorista set status=:status, message=:msg where id=:id",
                [
                    ':status' => null,
                    ':msg'    => null,
                    ':id'     => null
                ])
                ->bindValue(':id',     intval($id) )
                ->bindValue(':status', $status )
                ->bindValue(':msg',    $msg )
                ->execute();
    }

    private function updateReports ($rid, $content) {
        $this->db_conn->createCommand("update reports set scorista=:content where id=:rid",
            [
                ':content' => null,
                ':rid'     => null
            ])
            ->bindValue(':rid',     intval($rid) )
            ->bindValue(':content', $content )
            ->execute();
    }


    public function addOrder () {
        $tasks = $this->db_conn->createCommand("select rid from scorista where scrid is null and status is null", [])->queryAll();

        if (count($tasks) > 0 ) {
            foreach ($tasks as $taskItem){
                $this->Check($taskItem['rid'], null, 'request');
            }
        }

        return 0;
    }

    public function getRequestedContent () {
        $tasks = $this->db_conn->createCommand("select id, oid, rid, scrid from scorista where scrid is not null and status is NULL AND CURRENT_TIMESTAMP()-rdate > 60", [])->queryAll();

        if (count($tasks) > 0 ) {
            foreach ($tasks as $taskItem){
                $request_packet = [
                    'requestID' => $taskItem['scrid']
                ];

                $response = $this->getHttpClient($request_packet);

                if ($response->getIsOk()) {

                    $jres = json_decode($response->content);

                    if (property_exists($jres, 'status')) {
                        if ($jres->status == 'DONE') {
                            $this->updateReports($taskItem['rid'], $response->content);
                            $this->updateScoristaOrders($taskItem['id'], $jres->status, null);
                        }
                    }
                } else {
                    $jres = json_decode($response->content);

                    if (property_exists($jres, 'status')) {
                        $this->updateScoristaOrders($taskItem['id'], $jres->status, $response->content);
                    }
                }
            }
        }

        return;
    }
}
