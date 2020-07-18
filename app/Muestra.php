<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Muestra extends Model {

	protected $table = 'muestras';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function sesioncatacion() {
		return $this->belongsTo('App\Sesioncatacion');
	}

	public function tipomuestra() {
		return $this->belongsTo('App\Tipomuestra');
	}

	public function especie() {
		return $this->belongsTo('App\Especie');
	}

	public function pais() {
		return $this->belongsTo('App\Pais');
	}

	public function estado() {
		return $this->belongsTo('App\Estado');
	}

	public function aniocosecha() {
		return $this->belongsTo('App\Aniocosecha');
	}

	public function cataciones() {
		return $this->hasMany('App\Catacion');
	}

	public function nombrecomercial() {
		return $this->belongsTo('App\Nombrecomercial');
	}

	public function varietal() {
		return $this->belongsTo('App\Varietal');
	}

	public function tipoproceso() {
		return $this->belongsTo('App\Tipoproceso');
	}

	public function producto() {
		return $this->belongsTo('App\Producto');
	}

	public function color() {
		return $this->belongsTo('App\Color');
	}
	public function codigotipomuestras() {
		return $this->hasMany('App\Codigotipomuetra');
	}

}
