<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Catacion extends Model {

	protected $table = 'cataciones';
	public $timestamps = false;
	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';

	public function tipocatacion() {
		return $this->belongsTo('App\Tipocatacion');
	}

	public function muestra() {
		return $this->belongsTo('App\Muestra');
	}

}
