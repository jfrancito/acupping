<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sesioncatacion extends Model {

	protected $table = 'sesioncataciones';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function muestras() {
		return $this->hasMany('App\Muestra');
	}

	public function lugar() {
		return $this->belongsTo('App\Lugar');
	}

	public function sesionusers() {
		return $this->hasMany('App\Sesionuser');
	}

	public function estado() {
		return $this->belongsTo('App\Estado');
	}

}
