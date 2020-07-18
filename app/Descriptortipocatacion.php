<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Descriptortipocatacion extends Model {

	protected $table = 'descriptortipocataciones';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function descriptor() {
		return $this->belongsTo('App\Descriptor');
	}

	public function cataciondescriptores() {
		return $this->hasMany('App\Cataciondescriptor');
	}

}
