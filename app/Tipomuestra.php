<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipomuestra extends Model {

	protected $table = 'tipomuestras';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function muestras() {
		return $this->hasMany('App\Muestra');
	}

	public function codigotipomuestras() {
		return $this->hasMany('App\Codigotipomuetra');
	}

}
