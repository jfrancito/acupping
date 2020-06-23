<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aniocosecha extends Model {

	protected $table = 'aniocosechas';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function muestras() {
		return $this->hasMany('App\Muestra');
	}

}
