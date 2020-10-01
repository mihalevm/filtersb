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
        ['email', 'required', 'message' => 'Заполните поле "Адрес электронной почты"'],
        ['secondName', 'required', 'message' => 'Заполните поле "Фамилия"'],
        ['firstName', 'required', 'message' => 'Заполните поле "Имя"'],
        ['thirdName', 'required', 'message' => 'Заполните поле "Отчество"'],
        ['birthDate', 'required', 'message' => 'Выберите значение в поле "Дата рождения"'], // Нужна проверка пустой даты
        ['passportSeries', 'required', 'message' => 'Заполните поле "Серия паспорта"'],
        ['passportNumber', 'required', 'message' => 'Заполните поле "Номер паспорта"'],
        ['inn', 'required', 'message' => 'Заполните поле "ИНН"' ],
        ['licenseSeriesNumber', 'required', 'message' => 'Заполните поле "Серия и номер водительского удостоверения"' ],
        ['licenseRealeaseDate', 'required', 'message' => 'Заполните поле "Дата выдачи водительского удостоверения"' ],
        ['mainNumber', 'required', 'message' => 'Заполните поле "Контактный телефон"' ],
        ['relativesNumber1', 'required', 'message' => 'Заполните поле "Телефоны родственников (2 человека) - тел №1"' ],
        ['relativesNumber2', 'required', 'message' => 'Заполните поле "Телефоны родственников (2 человека) - тел №1"' ],        
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

}
