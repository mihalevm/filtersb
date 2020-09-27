<?php

namespace app\models;

use Yii;
use yii\base\Model;

class DriverProfile extends Model
{

  protected $db_conn;

  function __construct () {
    $this->db_conn = Yii::$app->db;
  }
  
  public function getDicTachograph() {
    $list = ($this->db_conn->createCommand("SELECT name FROM `filtersb`.`dic_tachograph` LIMIT 3"))
        ->queryAll();   

    return $list;
  }

}
