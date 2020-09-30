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
class RegisterForm extends Model
{
    public $email;
    public $password;
    public $utype;
    public $inn;

    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['email', 'password','utype'],        'required', 'on' => 'driver' ],
            [['email', 'password','utype', 'inn'], 'required', 'on' => 'company'],
            ['email', 'email'],
            ['email', 'unqEmailCheck'],
            ['utype', 'string', 'length' => 1],
            ['inn',   'unqInnCheck']
        ];
    }

    public function unqInnCheck ($attribute) {
        if ($this->utype === 'C') {
            if (!isset($this->inn)) {
                $this->addError('*', 'ИНН обязательное поле');
            } else {
                $res = ($this->db_conn->createCommand("select count(*) as cnt from users where active='Y' and inn=:inn")
                    ->bindValue(':inn', $this->inn)
                    ->queryAll())[0];

                if ($res['cnt'] > 0) {
                    $this->addError('*', 'Компания с таким ИНН уже зарегестрирована');
                }
            }
        }
    }

    public function unqEmailCheck($attribute) {
        $res = ($this->db_conn->createCommand("select count(*) as cnt from users where active='Y' and username=:email")
            ->bindValue(':email', $this->email)
            ->queryAll())[0];

        if ($res['cnt'] > 0) {
            $this->addError('*', 'Указанный логин уже зарегестрирован');
        }

    }

    public function sendConfirmation() {

        $confirm_hash = \Yii::$app->security->generateRandomString();

        $this->db_conn->createCommand("insert into users (username, password, utype, inn, confirm) values (:username, :password, :utype, :inn, :confirm)",
            [
                ':username' => null,
                ':password' => null,
                ':utype'    => null,
                ':inn'      => null,
                ':confirm'  => null,
            ])
            ->bindValue(':username', $this->email    )
            ->bindValue(':password', $this->password )
            ->bindValue(':utype',    $this->utype    )
            ->bindValue(':inn',      $this->inn      )
            ->bindValue(':confirm',  $confirm_hash   )
            ->execute();

        Yii::$app->mailer->compose('email_confirm', ['hash' => $confirm_hash])
            ->setTo($this->email)
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
            ->setSubject('Подтверждение регистрации с сайта Фильтр СБ')
            ->send();

        return true;
    }

    public function activateAccount ($h) {
        $this->db_conn->createCommand("update users set active='Y' where confirm=:confirm",
            [
                ':confirm'  => null,
            ])
            ->bindValue(':confirm', $h )
            ->execute();


        $this->db_conn->createCommand("insert into userinfo (id, inn) select id, inn from users where confirm=:confirm",
            [
                ':confirm' => null,
            ])
            ->bindValue(':confirm',  $h )
            ->execute();


        return true;
    }
}
