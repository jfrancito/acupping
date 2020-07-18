<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cataciondescriptor extends Model {

	protected $table = 'cataciondescriptores';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function descriptortipocatacion() {
		return $this->belongsTo('App\Descriptortipocatacion');
	}
	public function catacion() {
		return $this->belongsTo('App\Catacion');
	}

}
