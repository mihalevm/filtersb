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
class SigninForm extends Model
{
    public $email;
    public $password;
    public $rememberMe = true;

    private $_user = false;

    protected $db_conn;

    function __construct () {
        $this->db_conn = Yii::$app->db;
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'required',    'message' => 'Введите имя пользователя' ],
            ['password', 'required', 'message' => 'Введите пароль' ],
            ['email', 'email'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError('*', 'Не верное имя пользователя или пароль');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->email);
        }

        return $this->_user;
    }

    public function sendRestore($email){
        $answer = array(
            'status'  => 'notfound',
            'message' => 'Пользователь с таким логином не найден'
        );

        $user = User::findByUsername($email);

        if ( null != $user ) {
            $confirm_hash = \Yii::$app->security->generateRandomString();

            $this->db_conn->createCommand("update users set confirm=:confirm where id=:id",
                [
                    ':id'      => null,
                    ':confirm'  => null,
                ])
                ->bindValue(':id',      $user->getAttribute('id') )
                ->bindValue(':confirm',  $confirm_hash)
                ->execute();

            Yii::$app->mailer->compose('email_restore', ['hash' => $confirm_hash])
                ->setTo($email)
                ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->params['senderName']])
                ->setSubject('Восстановление пароля на сайте Фильтр СБ')
                ->send();

            $answer['status'] = 'sended';
            $answer['message'] = 'На указанный адрес выслана ссылка для восстановления пароля';
        }

        return $answer;
    }

    public function confirmHashIsExist($h) {
        $res = $this->db_conn->createCommand("select count(*) as cnt from users where confirm=:confirm")
            ->bindValue(':confirm', $h)
            ->queryAll();

        return count($res) ? $res[0]['cnt'] : null;
    }

    public function acceptRestore($password, $hash){
        $answer = array(
            'status'  => 'notfound',
            'message' => 'Ваш запрос не действителен, выполните запрос восстановления пароля еще раз'
        );

        if ( $this->confirmHashIsExist($hash) ) {
            $this->db_conn->createCommand("update users set password=:password, confirm='' where confirm=:confirm",
                [
                    ':password' => null,
                    ':confirm'  => null,
                ])
                ->bindValue(':password', $password )
                ->bindValue(':confirm',  $hash)
                ->execute();

            $answer['status'] = 'accepted';
            $answer['message'] = 'Пароль успешно сменен';
        }

        return $answer;
    }
}
