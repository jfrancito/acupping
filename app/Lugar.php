<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lugar extends Model {

	protected $table = 'lugares';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function sessioncataciones() {
		return $this->hasMany('App\Sesioncatacion');
	}

}
