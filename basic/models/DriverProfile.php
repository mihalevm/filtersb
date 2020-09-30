<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class DriverProfile extends Model
{
  public $email;
  public $secondName;
  public $firstName;
  public $thirdName;
  public $birthDate;
  public $passportSeries;
  public $passportNumber;
  public $inn;
  public $licenseSeriesNumber;
  public $licenseRealeaseDate;
  public $mainNumber;
  public $relativesNumber1;
  public $relativesNumber2;

  public function rules() 
  {
    return [
      [
        ['email', 'secondName', 'firstName', 'thirdName', 'birthDate', 'passportSeries',
          'passportNumber', 'inn', 'licenseSeriesNumber', 'licenseRealeaseDate', 'mainNumber', 'relativesNumber1', 'relativesNumber2'], 
        'required'],
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
