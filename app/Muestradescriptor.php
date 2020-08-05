<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Muestradescriptor extends Model {

	protected $table = 'muestradescriptores';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function muestra() {
		return $this->belongsTo('App\Muestra');
	}

	public function descriptor() {
		return $this->belongsTo('App\Descriptor');
	}

}
