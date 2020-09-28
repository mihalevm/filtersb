<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DriverProfile extends Model
{

  public $email;

  public function rules() 
  {
    return [
      [['email'], 'required'],
      ['email', 'email']
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

}
