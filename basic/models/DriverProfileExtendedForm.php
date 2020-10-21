<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DriverProfileExtendedForm extends Model
{
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

	public function rules() 
	{
		return [
			['mainNumber', 'required', 'message' => 'Заполните поле "Контактный телефон"' ],
			['relativesNumbers', 'required', 'message' => 'Заполните поле "Телефоны родственников (2 человека)"' ],
			['familyStatus', 'required', 'message' => 'Заполните поле "Семейное положение*:"' ],
			['childs', 'required', 'message' => 'Заполните поле "Дети, пол и возраст*:"' ],
			['categoryC', 'required', 'message' => 'Заполните поле "Стаж вождения именно по категории “С” (лет)*:"' ],
			['categoryE', 'required', 'message' => 'Заполните поле "Стаж вождения именно по категории “Е” (лет)*:"' ],
			['tachograph', 'required', 'message' => 'Заполните поле "Имеется ли карта тахографа, выбрать из списка (можно выбрать несколько)*:"' ],
			['trailertype', 'required', 'message' => 'Заполните поле "Какими прицепами управляли, выбрать из списка (можно выбрать несколько):*"' ],
			['marks', 'required', 'message' => 'Заполните поле "Марки транспортных средств, которыми управляли на последних местах работы*:' ],
			['interPassportExpireDate', 'required', 'message' => 'Заполните поле "Дата окончания загран.паспорта*:"' ],
			['medCard', 'required', 'message' => 'Заполните поле "Наличие медицинской книжки*:"' ],
			['startDate', 'required', 'message' => 'Заполните поле "Когда вы готовы приступить к работе*:"' ],
			['flyInAccept', 'required', 'message' => 'Заполните поле "Согласна ли ваша семья/близкие родственники работе вахтовым методом*:"' ],
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

		$list[0]['fpassdate'] = date('d.m.Y', strtotime($list[0]['fpassdate']));
		$list[0]['startdate'] = date('d.m.Y', strtotime($list[0]['startdate']));

		return sizeof($list) ? $list[0]:null;
	}

	public function saveDriverProfileExtended() 
	{
		$this->db_conn->createCommand("update userinfo set personalphone=:mainNumber, relphones=:relativesNumbers, tachograph=:tachograph, trailertype=:trailertype,   
		transporttype=:marks, familystatus=:familyStatus, childs=:childs, c_experience=:categoryC, e_experience=:categoryE, fpassdate=:interPassportExpireDate, medbook=:medCard,
		startdate=:startDate, agreefamily=:flyInAccept  where id=:id",
			[
				':mainNumber'   => null,
				':relativesNumbers'    => null,
				':tachograph'   	=> null,
				':trailertype'   	=> null,
				':familyStatus' => null,
				':childs' => null,					
				':categoryC'          => null,
				':categoryE' => null,
				':interPassportExpireDate' => null,
				':medCard' => null,					
				':startDate' => null,					
				':flyInAccept' => null,					
				':id'           => null,
			])
		->bindValue(':mainNumber',  $this->mainNumber)
		->bindValue(':relativesNumbers',   $this->relativesNumbers)
		->bindValue(':tachograph',   $this->tachograph)
		->bindValue(':trailertype',   $this->trailertype)
		->bindValue(':familyStatus',   $this->familyStatus)
		->bindValue(':childs',   $this->childs)
		->bindValue(':marks',   $this->marks)
		->bindValue(':categoryC',   $this->categoryC)
		->bindValue(':categoryE',   $this->categoryE)
		->bindValue(':interPassportExpireDate', date_format(date_create_from_format('d.m.Y', $this->interPassportExpireDate), 'Y-m-d'))		
		->bindValue(':medCard',   $this->medCard)
		->bindValue(':startDate',  date_format(date_create_from_format('d.m.Y', $this->startDate), 'Y-m-d'))
		->bindValue(':flyInAccept',   $this->flyInAccept)
		->bindValue(':id',          Yii::$app->user->identity->id)
		->execute();
	}

}
