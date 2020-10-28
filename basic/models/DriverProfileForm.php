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
	public $sex;
	public $passportSerial;
	public $passportNumber;
	public $passportRealeaseDate;
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
			['sex', 'required', 'message' => 'Выберите значение в поле "Пол"'],
			['passportSerial', 'required', 'message' => 'Заполните поле "Серия паспорта"'],
			['passportNumber', 'required', 'message' => 'Заполните поле "Номер паспорта"'],
			['passportRealeaseDate', 'required', 'message' => 'Заполните поле "Дата выдачи паспорта"'],
			['inn', 'required', 'message' => 'Заполните поле "ИНН"' ],
			['licenseSerial', 'required', 'message' => 'Заполните поле "Серия водительского удостоверения"' ],
			['licenseNumber', 'required', 'message' => 'Заполните поле "Номер водительского удостоверения"' ],
			['licenseRealeaseDate', 'required', 'message' => 'Заполните поле "Дата выдачи водительского удостоверения"' ],
			['agreementPersonalData', 'required', 'message' => 'Заполните поле "Cогласие на обработку персональных данных."' ],
			['agreementThirdParty', 'required', 'message' => 'Заполните поле "Cогласие на то, что достоверность указанных данных будет проверяться третьими лицами."' ],
			['agreementComments', 'required', 'message' => 'Заполните поле "Cогласие на комментирование со стороны транспортных компаний."' ],
			['email', 'email'],
			['sex', 'integer'],
		];
	}	

	protected $db_conn;

	function __construct () 
	{
		$this->db_conn = Yii::$app->db;
	}
	
	public function getDriverProfile ()
	{
		$list = ($this->db_conn->createCommand("select * from userinfo where id=:id"))
			->bindValue(':id', Yii::$app->user->identity->id)
			->queryAll();

        if (sizeof($list)) {
            $list[0]['ddate'] = date('d.m.Y', strtotime($list[0]['ddate']));
            $list[0]['birthday'] = date('d.m.Y', strtotime($list[0]['birthday']));
            $list[0]['pdate'] = date('d.m.Y', strtotime($list[0]['pdate']));
        }

		return sizeof($list) ? $list[0]:null;
	}

	public function saveDriverProfile() 
	{

        $this->inn   = preg_replace('/\_/','', $this->inn);

        $this->db_conn->createCommand("update userinfo set secondname=:secondName, firstname=:firstName, middlename=:thirdName, birthday=:birthDate,   
		pserial=:passportSerial, pnumber=:passportNumber, inn=:inn, dnumber=:licenseSerial, dnumber=:licenseNumber, ddate=:licenseRealeaseDate, agreepersdata=:agreementPersonalData ,agreecomment=:agreementComments ,agreecheck=:agreementThirdParty, pdate=:passportRealeaseDate, sex=:sex where id=:id",
			[
				':secondName'   => null,
				':firstName'    => null,
				':thirdName'   	=> null,
				':birthDate'   	=> null,
				':sex'       	=> null,
				':passportSerial' => null,
				':passportNumber' => null,					
				':passportRealeaseDate' => null,
				':inn'          => null,
				':licenseSerial' => null,
				':licenseNumber' => null,
				':licenseRealeaseDate' => null,		
				':agreementPersonalData' => null,
				':agreementThirdParty' => null,
				':agreementComments' => null,				
				':id'           => null,
			])
		->bindValue(':secondName',  $this->secondName)
		->bindValue(':firstName',   $this->firstName)
		->bindValue(':thirdName',   $this->thirdName)
		->bindValue(':birthDate',       date_format(date_create_from_format('d.m.Y', $this->birthDate), 'Y-m-d'))		
		->bindValue(':sex',       $this->sex)
		->bindValue(':passportSerial',   $this->passportSerial)
		->bindValue(':passportNumber',   $this->passportNumber)
		->bindValue(':passportRealeaseDate',   date_format(date_create_from_format('d.m.Y', $this->passportRealeaseDate), 'Y-m-d'))
		->bindValue(':inn',         $this->inn)
		->bindValue(':licenseSerial',   $this->licenseSerial)
		->bindValue(':licenseNumber',   $this->licenseNumber)
		->bindValue(':licenseRealeaseDate',  date_format(date_create_from_format('d.m.Y', $this->licenseRealeaseDate), 'Y-m-d') )
		->bindValue(':agreementPersonalData',   $this->agreementPersonalData)
		->bindValue(':agreementThirdParty',   $this->agreementThirdParty)
		->bindValue(':agreementComments',         $this->agreementComments)
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
