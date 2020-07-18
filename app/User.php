<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
	use Notifiable;
	public $timestamps = false;

	protected $primaryKey = 'id';
	public $incrementing = false;
	public $keyType = 'string';
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'email', 'password',
	];

	/**
	 * The attributes that should be hidden for arrays.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password', 'remember_token',
	];

	public function roles() {
		return $this->belongsTo('App\Rol', 'rol_id', 'id');
	}

	public function sesionusers() {
		return $this->hasMany('App\Sesionuser');
	}

}
