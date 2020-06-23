<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grupoopcion extends Model {
	protected $table = 'grupoopciones';
	public $timestamps = false;

	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function opciones() {
		return $this->hasMany('App\Opcion');
	}

}
