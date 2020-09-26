<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class CompanyDashboardForm extends Model {
    public $email;
    public $firstname;
    public $secondname;
    public $middlename;
    public $inn;
    public $pserial;
    public $pnumber;
    public $dserial;
    public $dnumber;
    public $bdate;

    protected $db_conn;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            ['email', 'required', 'message' => 'Заполните поле "Email"' ],
            ['inn', 'required', 'message' => 'Заполните поле "ИНН"' ],
            ['firstname', 'required', 'message' => 'Заполните поле "Имя"' ],
            ['secondname', 'required', 'message' => 'Заполните поле "Фамилия"' ],
            ['middlename', 'required', 'message' => 'Заполните поле "Отчество"' ],
            ['bdate', 'required', 'message' => 'Укажите дату рождения' ],
            ['pserial', 'required', 'message' => 'Заполните поле "Серия паспорта"' ],
            ['pnumber', 'required', 'message' => 'Заполните поле "Номер паспорта"' ],
            ['dserial', 'required', 'message' => 'Заполните поле "Серия водительского"' ],
            ['dnumber', 'required', 'message' => 'Заполните поле "Номер водительского"' ],
            ['email', 'email'],
            [['inn', 'pserial', 'pnumber', 'dserial', 'dnumber'], 'integer'],
            ['bdate', 'date', 'format' => 'dd.MM.yyyy']
        ];
    }

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }


    public function AddDriver() {
        $this->db_conn->createCommand("insert into users (username) values (:email)",
            [
                ':email'    => null,
            ])
            ->bindValue(':email', $this->email )
            ->execute();

        $id = Yii::$app->db->getLastInsertID();

        $this->db_conn->createCommand("insert into userinfo (inn, firstname, secondname, middlename, birthday, pserial, pnumber, dserial, dnumber, id) values (:inn, :firstname, :secondname, :middlename, :bdate, :pserial, :pnumber, :dserial, :dnumber, :id)",
            [
                ':inn'          => null,
                ':firstname'    => null,
                ':secondname'   => null,
                ':middlename'   => null,
                ':bdate'        => null,
                ':pserial'      => null,
                ':pnumber'      => null,
                ':dserial'      => null,
                ':dnumber'      => null,
                ':id'           => null,
            ])
            ->bindValue(':inn',         $this->inn          )
            ->bindValue(':firstname',   $this->firstname    )
            ->bindValue(':secondname',  $this->secondname   )
            ->bindValue(':middlename',  $this->middlename   )
            ->bindValue(':bdate',       date_format(date_create_from_format('d.m.Y', $this->bdate), 'Y-m-d'))
            ->bindValue(':pserial',     $this->pserial        )
            ->bindValue(':pnumber',     $this->pnumber        )
            ->bindValue(':dserial',     $this->pserial        )
            ->bindValue(':dnumber',     $this->pnumber        )
            ->bindValue(':id',          $id )
            ->execute();

        $this->db_conn->createCommand("insert into tcdrivers (did, tid) values (:did, :tid)",
            [
                ':did'  => null,
                ':tid'   => null,
            ])
            ->bindValue(':did', $id                           )
            ->bindValue(':tid', Yii::$app->user->identity->id )
            ->execute();

        return Yii::$app->db->getLastInsertID();
    }

    public function selectCompanyDrivers($reqFlag) {
        $arr = $this->db_conn->createCommand("SELECT t.id, u.username, i.inn, i.firstname, i.secondname, i.middlename, i.birthday, i.pserial, i.pnumber, i.dserial, i.dnumber, (SELECT COUNT(*) FROM tcdrivers tt WHERE tt.did=t.did AND  tt.tid<>t.tid) AS cnt FROM tcdrivers t, users u, userinfo i WHERE t.tid=:tid AND t.reqby=:reqby AND t.disabled='N' AND t.did = u.id AND t.did = i.id", [
            ':reqby' => null,
            ':tid'   => null,
        ])
        ->bindValue(':reqby', $reqFlag )
        ->bindValue(':tid',   Yii::$app->user->identity->id )
        ->queryAll();

        return $arr;
    }

    public function deleteDriver ($id) {
        $this->db_conn->createCommand("delete from tcdrivers where id=:id",
            [
                ':id'   => null,
            ])
            ->bindValue(':id', $id )
            ->execute();

        return 1;
    }
}
