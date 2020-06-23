<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rolopcion extends Model {
	protected $table = 'rolopciones';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function opcion() {
		return $this->belongsTo('App\Opcion', 'opcion_id', 'id');
	}

	public function rol() {
		return $this->belongsTo('App\Rol', 'rolopcion_id', 'id');
	}

}
