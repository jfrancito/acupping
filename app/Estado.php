<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model {

	protected $table = 'estados';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function muestras() {
		return $this->hasMany('App\Muestra');
	}

}
