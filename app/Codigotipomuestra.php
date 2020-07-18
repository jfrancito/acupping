<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codigotipomuestra extends Model {

	protected $table = 'codigotipomuestras';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function muestra() {
		return $this->belongsTo('App\Muestra');
	}

	public function tipomuestra() {
		return $this->belongsTo('App\Tipomuestra');
	}

}
