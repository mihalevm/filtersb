<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DriverProfileForm extends Model
{
	public $email;
	public $secondName;
	public $firstName;
	public $thirdName;
	public $birthDate;
	public $passportSerial;
	public $passportNumber;
	public $inn;
	public $licenseSerial;
	public $licenseNumber;
	public $licenseRealeaseDate;
	public $agreementPersonalData;
	public $agreementThirdParty;
	public $agreementComments;	

	public function rules() 
	{
		return [
			['email', 'required', 'message' => 'Заполните поле "Адрес электронной почты"'],
			['secondName', 'required', 'message' => 'Заполните поле "Фамилия"'],
			['firstName', 'required', 'message' => 'Заполните поле "Имя"'],
			['thirdName', 'required', 'message' => 'Заполните поле "Отчество"'],
			['birthDate', 'required', 'message' => 'Выберите значение в поле "Дата рождения"'],
			['passportSerial', 'required', 'message' => 'Заполните поле "Серия паспорта"'],
			['passportNumber', 'required', 'message' => 'Заполните поле "Номер паспорта"'],
			['inn', 'required', 'message' => 'Заполните поле "ИНН"' ],
			['licenseSerial', 'required', 'message' => 'Заполните поле "Серия водительского удостоверения"' ],
			['licenseNumber', 'required', 'message' => 'Заполните поле "Номер водительского удостоверения"' ],
			['licenseRealeaseDate', 'required', 'message' => 'Заполните поле "Дата выдачи водительского удостоверения"' ],
			['agreementPersonalData', 'required', 'message' => 'Заполните поле "Cогласие на обработку персональных данных."' ],
			['agreementThirdParty', 'required', 'message' => 'Заполните поле "Cогласие на то, что достоверность указанных данных будет проверяться третьими лицами."' ],
			['agreementComments', 'required', 'message' => 'Заполните поле "Cогласие на комментирование со стороны транспортных компаний."' ],
			['email', 'email'],
			['email', 'unqEmailCheck'], 
			['inn',   'unqInnCheck']
		];
	}	

	protected $db_conn;

	function __construct () 
	{
		$this->db_conn = Yii::$app->db;
	}
	
    public function unqInnCheck ($attribute) {
        $res = ($this->db_conn->createCommand("SELECT u.id from users u, userinfo i WHERE u.id=u.id AND u.active='Y' AND i.inn=:inn")
            ->bindValue(':inn', $this->inn)
            ->queryAll())[0];

        if ($res['id'] != Yii::$app->user->identity->id) {
            $this->addError('*', 'Компания с таким ИНН уже зарегестрирована');
        }
    }

    public function unqEmailCheck($attribute) {
        $res = ($this->db_conn->createCommand("select id from users where active='Y' and username=:email")
            ->bindValue(':email', $this->email)
            ->queryAll())[0];

        if ($res['id'] != Yii::$app->user->identity->id) {
            $this->addError('*', 'Указанный "Email" уже зарегестрирован');
        }
    }

	public function getDriverProfile () 
	{
		$list = ($this->db_conn->createCommand("select * from userinfo where id=:id"))
			->bindValue(':id', Yii::$app->user->identity->id)
			->queryAll();

		$list[0]['ddate'] = date('d.m.Y', strtotime($list[0]['ddate']));
		$list[0]['birthday'] = date('d.m.Y', strtotime($list[0]['birthday']));

		return $list[0];
	}

	public function getDriverProfileWorkplace () 
	{
		$list = ($this->db_conn->createCommand("select * from workplace where did=:id"))
			->bindValue(':id', Yii::$app->user->identity->id)
			->queryAll();

		$list[0]['sdate'] = date('d.m.Y', strtotime($list[0]['sdate']));
		$list[0]['edate'] = date('d.m.Y', strtotime($list[0]['edate']));

		return $list[0];
	}

	public function saveDriverProfile() 
	{
		$this->db_conn->createCommand("update userinfo set secondname=:secondName, firstname=:firstName, middlename=:thirdName, birthday=:birthDate,   
		pserial=:passportSerial, pnumber=:passportNumber, inn=:inn, dnumber=:licenseSerial, dnumber=:licenseNumber, ddate=:licenseRealeaseDate where id=:id",
			[
				':secondName'   => null,
				':firstName'    => null,
				':thirdName'   	=> null,
				':birthDate'   	=> null,
				':passportSerial' => null,
				':passportNumber' => null,					
				':inn'          => null,
				':licenseSerial' => null,
				':licenseNumber' => null,
				':licenseRealeaseDate' => null,					
				':id'           => null,
			])
		->bindValue(':secondName',  $this->secondName)
		->bindValue(':firstName',   $this->firstName)
		->bindValue(':thirdName',   $this->thirdName)
		->bindValue(':birthDate',       date_format(date_create_from_format('d.m.Y', $this->birthDate), 'Y-m-d'))		
		->bindValue(':passportSerial',   $this->passportSerial)
		->bindValue(':passportNumber',   $this->passportNumber)
		->bindValue(':inn',         $this->inn)
		->bindValue(':licenseSerial',   $this->licenseSerial)
		->bindValue(':licenseNumber',   $this->licenseNumber)
		->bindValue(':licenseRealeaseDate',  date_format(date_create_from_format('d.m.Y', $this->licenseRealeaseDate), 'Y-m-d') )
		->bindValue(':id',          Yii::$app->user->identity->id)
		->execute();

		if (isset($this->email) && $this->email != Yii::$app->user->identity->username) {
			$this->db_conn->createCommand("update users set username=:email  where id=:id",
				[
					':email' => null,
					':id' => null,
				])
				->bindValue(':email', $this->email)
				->bindValue(':id', Yii::$app->user->identity->id)
				->execute();
		}
	}

}
