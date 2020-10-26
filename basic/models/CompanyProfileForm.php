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
class CompanyProfileForm extends Model {
    public $email;
    public $password;
    public $inn;
    public $companyname;
    public $firstname;
    public $secondname;
    public $middlename;
    public $phone;

    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            ['email', 'required', 'message' => 'Заполните поле "Email"' ],
            ['inn', 'required', 'message' => 'Заполните поле "ИНН"' ],
            ['companyname', 'required', 'message' => 'Заполните поле "Название компании"' ],
            ['firstname', 'required', 'message' => 'Заполните поле "Имя"' ],
            ['middlename', 'string'],
            ['secondname', 'required', 'message' => 'Заполните поле "Фамилия"' ],
            ['phone', 'required', 'message' => 'Заполните поле "Контактный телефон"' ],
            ['email', 'email'],
            ['email', 'unqEmailCheck'],
            ['inn',   'unqInnCheck']
        ];
    }

    public function unqInnCheck ($attribute) {
        $this->inn = preg_replace('/\_/','', $this->inn);

        $res = $this->db_conn->createCommand("SELECT u.id from users u, userinfo i WHERE i.id=u.id AND u.active='Y' AND i.inn=:inn and i.id<>:id")
            ->bindValue(':inn', $this->inn)
            ->bindValue(':id', Yii::$app->user->identity->id)
            ->queryAll();

        if (count($res)>0) {
            $this->addError('*', 'Компания с таким ИНН уже зарегестрирована');
        }
    }

    public function unqEmailCheck($attribute) {
        $res = $this->db_conn->createCommand("select id from users where active='Y' and username=:email and id<>:id")
            ->bindValue(':email', $this->email)
            ->bindValue(':id', Yii::$app->user->identity->id)
            ->queryAll();

        if (count($res)>0) {
            $this->addError('*', 'Указанный "Email" уже зарегестрирован');
        }
    }

    public function getCompanyProfile () {
        return ($this->db_conn->createCommand("select * from userinfo where id=:id")
            ->bindValue(':id', Yii::$app->user->identity->id)
            ->queryAll())[0];
    }

    public function saveCompanyProfile() {
        $this->inn   = preg_replace('/\_/','', $this->inn);
        $this->phone = preg_replace('/\-/','', $this->phone);

        $this->db_conn->createCommand("update userinfo set inn=:inn, companyname=:companyname, firstname=:firstname, secondname=:secondname, middlename=:middlename, personalphone=:phone  where id=:id",
            [
                ':inn'          => null,
                ':companyname'  => null,
                ':firstname'    => null,
                ':secondname'   => null,
                ':middlename'   => null,
                ':phone'        => null,
                ':id'           => null,
            ])
            ->bindValue(':inn',         $this->inn          )
            ->bindValue(':companyname', $this->companyname  )
            ->bindValue(':firstname',   $this->firstname    )
            ->bindValue(':secondname',  $this->secondname   )
            ->bindValue(':middlename',  $this->middlename   )
            ->bindValue(':phone',       $this->phone        )
            ->bindValue(':id',          Yii::$app->user->identity->id )
            ->execute();

        if (isset($this->email) && $this->email != Yii::$app->user->identity->username) {
            $this->db_conn->createCommand("update users set email=:email  where id=:id",
                [
                    ':email' => null,
                    ':id' => null,
                ])
                ->bindValue(':email', $this->email)
                ->bindValue(':id', Yii::$app->user->identity->id)
                ->execute();
        }

        if (isset($this->password) && $this->password != Yii::$app->user->identity->password) {
            $this->db_conn->createCommand("update users set password=:password  where id=:id",
                [
                    ':password' => null,
                    ':id' => null,
                ])
                ->bindValue(':password', $this->password)
                ->bindValue(':id', Yii::$app->user->identity->id)
                ->execute();
        }
    }
}
