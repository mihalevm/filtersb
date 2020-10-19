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
    public $pdate;
    public $dserial;
    public $dnumber;
    public $bdate;
    public $ddate;
    public $rpostzip;
    public $rregion;
    public $rcity;
    public $rstreet;
    public $rhouse;
    public $rbuild;
    public $rflat;
    public $lpostzip;
    public $lregion;
    public $lcity;
    public $lstreet;
    public $lhouse;
    public $lbuild;
    public $lflat;
    public $dup_address;

    protected $db_conn;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
//            ['email', 'required', 'message' => 'Заполните поле "Email"' ],
            ['inn', 'required', 'message' => 'Заполните поле "ИНН"' ],
            ['firstname', 'required', 'message' => 'Заполните поле "Имя"' ],
            ['secondname', 'required', 'message' => 'Заполните поле "Фамилия"' ],
            ['middlename', 'required', 'message' => 'Заполните поле "Отчество"' ],
            ['bdate', 'required', 'message' => 'Укажите дату рождения' ],
            ['pserial', 'required', 'message' => 'Заполните поле "Серия паспорта"' ],
            ['pnumber', 'required', 'message' => 'Заполните поле "Номер паспорта"' ],
            ['dserial', 'required', 'message' => 'Заполните поле "Серия водительского"' ],
            ['dnumber', 'required', 'message' => 'Заполните поле "Номер водительского"' ],
            ['pdate', 'required', 'message' => 'Укажите дату выдачи паспорта' ],
            ['ddate', 'required', 'message' => 'Укажите дату выдачи водительского удостоверения' ],
            ['rregion', 'required', 'message' => 'Укажите регион регистрации' ],
            ['rcity', 'required', 'message' => 'Укажите город регистрации' ],
            ['rstreet', 'required', 'message' => 'Укажите улицу регистрации' ],
            ['email', 'email'],
            [['inn', 'pserial', 'pnumber', 'dserial', 'dnumber'], 'integer'],
            [['bdate', 'ddate','pdate'], 'date', 'format' => 'dd.MM.yyyy'],
            [['rpostzip', 'lpostzip'], 'default', 'value' => '000000'],
            [['rstreet', 'lstreet'],   'default', 'value' => 'НЕТ'],
        ];
    }

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    public function AddDriver() {
        $this->inn     = preg_replace('/\_/','', $this->inn);
        $this->pserial = preg_replace('/\_/','', $this->pserial);
        $this->pnumber = preg_replace('/\_/','', $this->pnumber);
        $this->dserial = preg_replace('/\_/','', $this->dserial);
        $this->dnumber = preg_replace('/\_/','', $this->dnumber);

        $this->db_conn->createCommand("insert into users (username) values (:email)",
            [
                ':email'    => null,
            ])
            ->bindValue(':email', $this->email )
            ->execute();

        $id = Yii::$app->db->getLastInsertID();

        $this->db_conn->createCommand("insert into userinfo (inn, firstname, secondname, middlename, birthday, pserial, pnumber, pdate, dserial, dnumber, ddate, id) values (:inn, :firstname, :secondname, :middlename, :bdate, :pserial, :pnumber, :pdate,:dserial, :dnumber, :ddate, :id)",
            [
                ':inn'        => null,
                ':firstname'  => null,
                ':secondname' => null,
                ':middlename' => null,
                ':bdate'      => null,
                ':pserial'    => null,
                ':pnumber'    => null,
                ':pdate'      => null,
                ':dserial'    => null,
                ':dnumber'    => null,
                ':ddate'      => null,
                ':id'         => null,
            ])
            ->bindValue(':inn',        $this->inn        )
            ->bindValue(':firstname',  $this->firstname  )
            ->bindValue(':secondname', $this->secondname )
            ->bindValue(':middlename', $this->middlename )
            ->bindValue(':bdate',      date_format(date_create_from_format('d.m.Y', $this->bdate), 'Y-m-d'))
            ->bindValue(':pserial',    $this->pserial    )
            ->bindValue(':pnumber',    $this->pnumber    )
            ->bindValue(':pdate',      $this->pdate      )
            ->bindValue(':dserial',    $this->pserial    )
            ->bindValue(':dnumber',    $this->pnumber    )
            ->bindValue(':ddate',      date_format(date_create_from_format('d.m.Y', $this->ddate), 'Y-m-d'))
            ->bindValue(':id',         $id )
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
        $arr = $this->db_conn->createCommand("SELECT t.id, t.did, u.username, i.inn, i.firstname, i.secondname, i.middlename, i.birthday, i.pserial, i.pnumber, i.dserial, i.dnumber, (SELECT COUNT(*) FROM tcdrivers tt WHERE tt.did=t.did AND  tt.tid<>t.tid) AS cnt FROM tcdrivers t, users u, userinfo i WHERE t.tid=:tid AND t.reqby=:reqby AND t.disabled='N' AND t.did = u.id AND t.did = i.id", [
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

    public function getDriverInfo($id) {
        $arr = ($this->db_conn->createCommand("SELECT u.username,u.active,t.reqby,i.* FROM tcdrivers t, userinfo i, users u WHERE t.tid=:tid AND t.id=:id and i.id=t.did AND u.id=t.did", [
            ':id' => null,
            ':tid'   => null,
        ])
            ->bindValue(':id',  $id )
            ->bindValue(':tid', Yii::$app->user->identity->id )
            ->queryAll())[0];

        return $arr;
    }

    public function getCompanyReports ($id) {
        $arr = $this->db_conn->createCommand("SELECT r.cdate, r.id, r.payed, r.completed FROM reports r, tcdrivers t WHERE r.oid=:tid and r.did=t.did and t.id=:id order by cdate desc", [
            ':tid' => null,
            ':id'  => null,
        ])
            ->bindValue(':tid', Yii::$app->user->identity->id )
            ->bindValue(':id',  intval($id) )
            ->queryAll();

        return $arr;
    }

    public function getDriverComents($id) {
        $arr = $this->db_conn->createCommand("SELECT cast(c.cdate as date) as cdate, cdate as coment_date, c.rait, c.coment, i.agreecomment FROM tcdrivers t, userinfo i, dcoments c WHERE t.tid=:tid AND t.id=:id and i.id=t.did AND c.did=t.did order by coment_date desc", [
            ':id' => null,
            ':tid'   => null,
        ])
            ->bindValue(':id',  $id )
            ->bindValue(':tid', Yii::$app->user->identity->id )
            ->queryAll();

        return $arr;
    }

    public function saveComment($did, $rait, $coment){
        $this->db_conn->createCommand("insert into dcoments (did, rait, coment) values (:did, :rait, :coment)",
            [
                ':did'    => null,
                ':rait'   => null,
                ':coment' => null,
            ])
            ->bindValue(':did',    $did    )
            ->bindValue(':rait',   $rait   )
            ->bindValue(':coment', $coment )
            ->execute();

        return Yii::$app->db->getLastInsertID();
    }

    public function driver_employment ($id) {
        $this->db_conn->createCommand("update tcdrivers set reqby='T' where id=:id and tid=:tid",
            [
                ':id'  => null,
                ':tid'   => null,
            ])
            ->bindValue(':id', $id                            )
            ->bindValue(':tid', Yii::$app->user->identity->id )
            ->execute();

        return 1;
    }

}