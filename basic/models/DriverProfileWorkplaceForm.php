<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DriverProfileWorkplaceForm extends Model
{
	public $workplaceList;
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
			['workStartDate', 'required', 'message' => 'Заполните поле "Дата приема на работу*:"' ],
			['workEndDate', 'required', 'message' => 'Заполните поле "Дата увольнения с работы*:"' ],
			['company', 'required', 'message' => 'Заполните поле "Название организации*:"' ],
			['post', 'required', 'message' => 'Заполните поле "Должность*:"' ],
			['action', 'required', 'message' => 'Заполните поле "Содержание деятельности*:"' ],
			['dismissal', 'required', 'message' => 'Заполните поле "Причина увольнения*:"' ],
			['guarantor', 'required', 'message' => 'Заполните поле "Кто может дать рекомендации с даннного места
			работы (ФИО, контакт для связи)*:"' ],			
		];
	}	

	protected $db_conn;

	function __construct () 
	{
		$this->db_conn = Yii::$app->db;
	}	

	public function getDriverProfileWorkplace () 
	{
		$list = ($this->db_conn->createCommand("select * from workplace where did=:id"))
			->bindValue(':id', Yii::$app->user->identity->id)
			->queryAll();

		$list[0]['sdate'] = date('d.m.Y', strtotime($list[0]['sdate']));
		$list[0]['edate'] = date('d.m.Y', strtotime($list[0]['edate']));

		return sizeof($list) ? $list[0]:null;
	}

	public function saveDriverProfileWorkplace() 
	{
		$this->db_conn->createCommand("update workplace set sdate=:workStartDate, edate=:workEndDate, company=:company, post=:post,   
		action=:action, dismissal=:dismissal, guarantor=:guarantor where did=:id",
			[
				':workStartDate'   => null,
				':workEndDate'     => null,
				':company'   	   => null,
				':post'   		   => null,
				':action'          => null,
				':dismissal'       => null,					
				':guarantor'       => null,
				':id'              => null,
			])
		->bindValue(':workStartDate', date_format(date_create_from_format('d.m.Y', $this->workStartDate), 'Y-m-d'))		
		->bindValue(':workEndDate',   date_format(date_create_from_format('d.m.Y', $this->workEndDate), 'Y-m-d') )
		->bindValue(':company',  $this->company)
		->bindValue(':post',   $this->post)
		->bindValue(':action',   $this->action)
		->bindValue(':dismissal',   $this->dismissal)
		->bindValue(':guarantor',   $this->guarantor)
		->bindValue(':id',          Yii::$app->user->identity->id)
		->execute();		
	}

}
