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
		return $this->belongsTo('App\Catacion');
	}

}
