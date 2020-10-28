<?php

namespace app\models;

use Yii;
use yii\base\Model;

class DriverProfileAddressForm extends Model {
    public $rpostzip;
    public $rregion;
    public $rcity;
    public $rstreet;
    public $rhouse;
    public $rbuild;
    public $rflat;
    public $lpostzip;
    public $lregion;
    public $lcity;
    public $lstreet;
    public $lhouse;
    public $lbuild;
    public $lflat;
    public $dup_address;
    public $sex;

	public function rules() {
		return [
            ['rregion', 'required', 'message' => 'Укажите регион регистрации' ],
            ['rcity', 'required', 'message' => 'Укажите город регистрации' ],
            ['rstreet', 'required', 'message' => 'Укажите улицу регистрации' ],
            [['rpostzip', 'lpostzip'], 'default', 'value' => '000000'],
            [['rstreet', 'lstreet'],   'default', 'value' => 'НЕТ'],
            [['rhouse','rbuild', 'rflat', 'lhouse', 'lbuild', 'lflat'], 'string', 'max' => 4 ],
            ['dup_address', 'boolean'],
		];
	}	

	protected $db_conn;

	function __construct () {
		$this->db_conn = Yii::$app->db;
	}

    public function saveDriverProfile() {
        $raddress = [
            'postzip' => $this->rpostzip,
            'region'  => $this->rregion,
            'city'    => $this->rcity,
            'street'  => $this->rstreet,
            'house'   => $this->rhouse,
            'build'   => $this->rbuild,
            'flat'    => $this->rflat
        ];

        $laddress = $raddress;

        if (! $this->dup_address) {
            $laddress = [
                'postzip' => $this->lpostzip,
                'region'  => $this->lregion,
                'city'    => $this->lcity,
                'street'  => $this->lstreet,
                'house'   => $this->lhouse,
                'build'   => $this->lbuild,
                'flat'    => $this->lflat
            ];
        }

        $this->db_conn->createCommand("update userinfo set raddress=:raddress, laddress=:laddress where id=:id",
            [
                ':raddress' => null,
                ':laddress' => null,
                ':id'       => null,
            ])
            ->bindValue(':raddress',  json_encode($raddress))
            ->bindValue(':laddress',  json_encode($laddress))
            ->bindValue(':id',        Yii::$app->user->identity->id)
            ->execute();

        return;
    }
}
