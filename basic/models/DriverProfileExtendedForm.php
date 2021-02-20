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
    public $companyset;

	public function rules() 
	{
		return [
			['mainNumber', 'required', 'message' => 'Заполните поле "Контактный телефон"' ],
			['relativesNumbers', 'required', 'message' => 'Заполните поле "Телефоны родственников (2 человека)"' ],
			['familyStatus', 'required', 'message' => 'Заполните поле "Семейное положение"' ],
			['childs', 'required', 'message' => 'Заполните поле "Дети, пол и возраст"' ],
			['categoryC', 'required', 'message' => 'Заполните поле "Стаж вождения именно по категории “С” (лет)"' ],
			['categoryE', 'required', 'message' => 'Заполните поле "Стаж вождения именно по категории “Е” (лет)"' ],
			['tachograph', 'required', 'message' => 'Заполните поле "Имеется ли карта тахографа, выбрать из списка (можно выбрать несколько)"' ],
			['trailertype', 'required', 'message' => 'Заполните поле "Какими прицепами управляли, выбрать из списка (можно выбрать несколько)"' ],
			['marks', 'required', 'message' => 'Заполните поле "Марки транспортных средств, которыми управляли на последних местах работы' ],
			['interPassportExpireDate', 'default', 'value' => null],
			['medCard', 'required', 'message' => 'Заполните поле "Наличие медицинской книжки"' ],
			['startDate', 'required', 'message' => 'Заполните поле "Когда вы готовы приступить к работе"' ],
			['flyInAccept', 'required', 'message' => 'Заполните поле "Согласна ли ваша семья/близкие родственники работе вахтовым методом"' ],
            ['tachograph',  'each', 'rule' => ['string']],
            ['trailertype', 'each', 'rule' => ['string']],
            ['companyset',  'each', 'rule' => ['integer']],
        ];
	}	

	protected $db_conn;

	function __construct () 
	{
		$this->db_conn = Yii::$app->db;
	}
	
	public function getDicTachograph() 
	{
		$list = ($this->db_conn->createCommand("SELECT * FROM `filtersb`.`dic_tachograph`"))
			->queryAll();

		$list = ArrayHelper::map($list, 'name', 'name');

		return $list;
	}

	public function getDicTrailerType() 
	{
		$list = ($this->db_conn->createCommand("SELECT * FROM `filtersb`.`dic_trailertype`"))
			->queryAll();
		$list = ArrayHelper:: map($list, 'name', 'name');

		return $list;
	}

	public function getDriverProfile () 
	{
		$list = ($this->db_conn->createCommand("select * from userinfo where id=:id"))
			->bindValue(':id', Yii::$app->user->identity->id)
			->queryAll();

		if (sizeof($list)) {
            $list[0]['fpassdate']  = null != $list[0]['fpassdate'] ? date('d.m.Y', strtotime($list[0]['fpassdate'])) : '';
            $list[0]['startdate']  = date('d.m.Y', strtotime($list[0]['startdate']));
            $list[0]['tachograph'] = explode(',', $list[0]['tachograph']);
            $list[0]['tachograph'] = array_combine($list[0]['tachograph'], $list[0]['tachograph']);
            $list[0]['trailertype'] = explode(',', $list[0]['trailertype']);
            $list[0]['trailertype'] = array_combine($list[0]['trailertype'], $list[0]['trailertype']);
        }

		return sizeof($list) ? $list[0]:null;
	}

    public function getAllCompany() {
        $arr = $this->db_conn->createCommand("SELECT distinct i.id, i.companyname FROM users u, userinfo i WHERE u.id=i.id AND u.utype='C' and i.companyname is not null", [])
            ->queryAll();

        return ArrayHelper::map($arr, 'id', 'companyname');
    }

    public function saveDriverProfileExtended()
	{

        $this->mainNumber = preg_replace('/\-/','', $this->mainNumber);
        $this->mainNumber = preg_replace('/\_/','', $this->mainNumber);
        $this->relativesNumbers = preg_replace('/\-/','', $this->relativesNumbers);
        $this->relativesNumbers = preg_replace('/\_/','', $this->relativesNumbers);
        $this->categoryC = preg_replace('/\_/','', $this->categoryC);
        $this->categoryE = preg_replace('/\_/','', $this->categoryE);
        $this->companyset = implode(',', $this->companyset);

        $this->db_conn->createCommand("update userinfo set personalphone=:mainNumber, relphones=:relativesNumbers, tachograph=:tachograph, trailertype=:trailertype,   
		transporttype=:marks, familystatus=:familyStatus, childs=:childs, c_experience=:categoryC, e_experience=:categoryE, fpassdate=:interPassportExpireDate, medbook=:medCard,
		startdate=:startDate, agreefamily=:flyInAccept, companyset=:companyset  where id=:id",
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
				':companyset'    => null,
			])
		->bindValue(':mainNumber',  $this->mainNumber)
		->bindValue(':relativesNumbers',   $this->relativesNumbers)
		->bindValue(':tachograph',  implode(',', $this->tachograph))
		->bindValue(':trailertype', implode(',', $this->trailertype))
		->bindValue(':familyStatus',   $this->familyStatus)
		->bindValue(':childs',   $this->childs)
		->bindValue(':marks',   $this->marks)
		->bindValue(':categoryC',   $this->categoryC)
		->bindValue(':categoryE',   $this->categoryE)
		->bindValue(':interPassportExpireDate', null != $this->interPassportExpireDate ? date_format(date_create_from_format('d.m.Y', $this->interPassportExpireDate), 'Y-m-d') : null )
		->bindValue(':medCard',   $this->medCard)
		->bindValue(':startDate',  date_format(date_create_from_format('d.m.Y', $this->startDate), 'Y-m-d'))
		->bindValue(':flyInAccept',   $this->flyInAccept)
		->bindValue(':companyset',   $this->companyset)
		->bindValue(':id',          Yii::$app->user->identity->id)
		->execute();
	}

}
