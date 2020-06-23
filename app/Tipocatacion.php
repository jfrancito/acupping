<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipocatacion extends Model {

	protected $table = 'tipocataciones';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function cataciones() {
		return $this->hasMany('App\Catacion');
	}

}
