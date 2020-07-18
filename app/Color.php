<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model {

	protected $table = 'colores';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function muestras() {
		return $this->hasMany('App\Muestra');
	}

}
