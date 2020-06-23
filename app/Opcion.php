<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model {
	protected $table = 'opciones';
	public $timestamps = false;

	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function grupoopcion() {
		return $this->belongsTo('App\Grupoopcion', 'grupoopcion_id', 'id');
	}

	public function rolopciones() {
		return $this->hasMany('App\Rolopcion', 'opcion_id', 'id');
	}

}
