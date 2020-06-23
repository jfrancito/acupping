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

}
