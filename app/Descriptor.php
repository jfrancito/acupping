<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descriptor extends Model {

	protected $table = 'descriptores';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function descriptortipocataciones() {
		return $this->hasMany('App\Descriptortipocatacion');
	}

	public function muestradescriptores() {
		return $this->hasMany('App\Muestradescriptor');
	}

}
