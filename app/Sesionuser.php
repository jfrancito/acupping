<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sesionuser extends Model {

	protected $table = 'sesionusers';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function sesioncatacion() {
		return $this->belongsTo('App\Sesioncatacion');
	}

	public function user() {
		return $this->belongsTo('App\User');
	}

}
