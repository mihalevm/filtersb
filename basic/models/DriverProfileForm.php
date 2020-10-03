<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\CompanyProfileForm;
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
	public $mainNumber;
	public $relativesNumbers;

	public function rules() 
	{
		return [
			[
				['email', 'required', 'message' => 'Заполните поле "Адрес электронной почты"'],
				['secondName', 'required', 'message' => 'Заполните поле "Фамилия"'],
				['firstName', 'required', 'message' => 'Заполните поле "Имя"'],
				['thirdName', 'required', 'message' => 'Заполните поле "Отчество"'],
				['birthDate', 'required', 'message' => 'Выберите значение в поле "Дата рождения"'], // Нужна проверка пустой даты
				['passportSerial', 'required', 'message' => 'Заполните поле "Серия паспорта"'],
				['passportNumber', 'required', 'message' => 'Заполните поле "Номер паспорта"'],
				['inn', 'required', 'message' => 'Заполните поле "ИНН"' ],
				['licenseSerial', 'required', 'message' => 'Заполните поле "Серия водительского удостоверения"' ],
				['licenseNumber', 'required', 'message' => 'Заполните поле "Номер водительского удостоверения"' ],
				['licenseRealeaseDate', 'required', 'message' => 'Заполните поле "Дата выдачи водительского удостоверения"' ],
				// ['mainNumber', 'required', 'message' => 'Заполните поле "Контактный телефон"' ],
				// ['relativesNumbers', 'required', 'message' => 'Заполните поле "Телефоны родственников (2 человека)"' ],
			],
			['email', 'email'],
			['email', 'unqEmailCheck'],
			['inn',   'unqInnCheck']
		];
	}

	protected $db_conn;

	function __construct () {
		$this->db_conn = Yii::$app->db;
	}
	
	public function getDicTachograph() {
		$list = ($this->db_conn->createCommand("SELECT * FROM `filtersb`.`dic_tachograph` LIMIT 3"))
			->queryAll();   
		$list = ArrayHelper::map($list,'id', 'name');

		return $list;
	}

	public function getDicTrailerType() {
		$list = ($this->db_conn->createCommand("SELECT * FROM `filtersb`.`dic_trailertype` LIMIT 3"))
			->queryAll();   
		$list = ArrayHelper::map($list,'id', 'name');

		return $list;
	}

	public function getDriverProfile () {
        return ($this->db_conn->createCommand("select * from userinfo where id=:id")
            ->bindValue(':id', Yii::$app->user->identity->id)
            ->queryAll())[0];
    }

	public function saveDriverProfile() {
		$this->db_conn->createCommand("update userinfo set secondname=:secondName, firstname=:firstName, middlename=:thirdName,   
		pserial=:passportSerial, pnumber=:passportNumber, inn=:inn, dnumber=:licenseSerial, dnumber=:licenseNumber, ddate=:licenseRealeaseDate, where id=:id",
				[
					':secondName'   => null,
					':firstname'    => null,
					':thirdName'   => null,
					':passportSerial' => null,
					':passportNumber' => null,					
					':inn'          => null,
					':licenseSerial' => null,					
					':licenseRealeaseDate' => null,					
					// ':mainNumber'   => null,
					':id'           => null,
				])
				->bindValue(':secondName',  $this->secondName)
				->bindValue(':firstName',   $this->firstName)
				->bindValue(':thirdName',   $this->thirdName)
				->bindValue(':birthDate',   $this->birthDate)
				->bindValue(':passportSerial',   $this->passportSerial)
				->bindValue(':passportNumber',   $this->passportNumber)
				->bindValue(':inn',         $this->inn)
				->bindValue(':licenseSerial',   $this->licenseSerial)
				->bindValue(':licenseNumber',   $this->licenseNumber)
				->bindValue(':licenseRealeaseDate',   $this->licenseRealeaseDate)
				// ->bindValue(':mainNumber',  $this->mainNumber)
				->bindValue(':id',          Yii::$app->user->identity->id)
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
	}

}
