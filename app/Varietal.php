<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Varietal extends Model {

	protected $table = 'varietales';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function muestras() {
		return $this->hasMany('App\Muestra');
	}

	public function especie() {
		return $this->belongsTo('App\Especie');
	}

}
