<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especie extends Model {

	protected $table = 'especies';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function muestras() {
		return $this->hasMany('App\Muestra');
	}

	public function verietales() {
		return $this->hasMany('App\Varietal');
	}

}
