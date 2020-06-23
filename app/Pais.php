<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model {

	protected $table = 'paises';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function muestras() {
		return $this->hasMany('App\Muestra');
	}

}
