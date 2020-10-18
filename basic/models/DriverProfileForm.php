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
	public $tachograph;
	public $trailertype;
	public $marks;
	public $familyStatus;
	public $childs;
	public $categoryC;
	public $categoryE;
	public $interPassportExpireDate;
	public $medCard;
	public $startDate;
	public $flyInAccept;
	public $workplaceList;
	public $agreementPersonalData;
	public $agreementThirdParty;
	public $agreementComments;
	public $workStartDate;
	public $workEndDate;
	public $company;
	public $post;
	public $action;
	public $dismissal;
	public $guarantor;	

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
			// ['mainNumber', 'required', 'message' => 'Заполните поле "Контактный телефон"' ],
			// ['relativesNumbers', 'required', 'message' => 'Заполните поле "Телефоны родственников (2 человека)"' ],
			// ['familyStatus', 'required', 'message' => 'Заполните поле "Семейное положение*:"' ],
			// ['childs', 'required', 'message' => 'Заполните поле "Дети, пол и возраст*:"' ],
			// ['categoryC', 'required', 'message' => 'Заполните поле "Стаж вождения именно по категории “С” (лет)*:"' ],
			// ['categoryE', 'required', 'message' => 'Заполните поле "Стаж вождения именно по категории “Е” (лет)*:"' ],
			// ['tachograph', 'required', 'message' => 'Заполните поле "Имеется ли карта тахографа, выбрать из списка (можно выбрать несколько)*:"' ],
			// ['trailertype', 'required', 'message' => 'Заполните поле "Какими прицепами управляли, выбрать из списка (можно выбрать несколько):*"' ],
			// ['marks', 'required', 'message' => 'Заполните поле "Марки транспортных средств, которыми управляли на последних местах работы*:' ],
			// ['interPassportExpireDate', 'required', 'message' => 'Заполните поле "Дата окончания загран.паспорта*:"' ],
			// ['medCard', 'required', 'message' => 'Заполните поле "Наличие медицинской книжки*:"' ],
			// ['startDate', 'required', 'message' => 'Заполните поле "Когда вы готовы приступить к работе*:"' ],
			// ['flyInAccept', 'required', 'message' => 'Заполните поле "Согласна ли ваша семья/близкие родственники работе вахтовым методом*:"' ],
			// ['agreementPersonalData', 'required', 'message' => 'Заполните поле "Cогласие на обработку персональных данных."' ],
			// ['agreementThirdParty', 'required', 'message' => 'Заполните поле "Cогласие на то, что достоверность указанных данных будет проверяться третьими лицами."' ],
			// ['agreementComments', 'required', 'message' => 'Заполните поле "Cогласие на комментирование со стороны транспортных компаний."' ],
			// ['workStartDate', 'required', 'message' => 'Заполните поле "Дата приема на работу*:"' ],
			// ['workEndDate', 'required', 'message' => 'Заполните поле "Дата увольнения с работы*:"' ],
			// ['company', 'required', 'message' => 'Заполните поле "Семейное положение*:"' ],
			// ['post', 'required', 'message' => 'Заполните поле "Семейное положение*:"' ],
			// ['action', 'required', 'message' => 'Заполните поле "Семейное положение*:"' ],
			// ['dismissal', 'required', 'message' => 'Заполните поле "Семейное положение*:"' ],
			// ['guarantor', 'required', 'message' => 'Заполните поле "Семейное положение*:"' ],
			['email', 'email'],
			// ['email', 'unqEmailCheck'], // Не работает
			// ['inn',   'unqInnCheck'] // Не работает
		];
	}	

	protected $db_conn;

	function __construct () 
	{
		$this->db_conn = Yii::$app->db;
	}
	
	public function getDicTachograph() 
	{
		$list = ($this->db_conn->createCommand("SELECT * FROM `filtersb`.`dic_tachograph` LIMIT 3"))
			->queryAll();

		$list = ArrayHelper::map($list, 'id', 'name');	

		return $list;
	}

	public function getDicTrailerType() 
	{
		$list = ($this->db_conn->createCommand("SELECT * FROM `filtersb`.`dic_trailertype` LIMIT 3"))
			->queryAll();
		$list = ArrayHelper::map($list, 'id', 'name');

		return $list;
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
