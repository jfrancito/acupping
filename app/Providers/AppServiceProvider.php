<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Validator;
use View;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {

		Schema::defaultStringLength(191);
		View::share('capeta', '/acupping');
		View::share('nombre_sistema', 'Acupping');
		View::share('version', '1.58');

		Validator::extend('unico', function ($attribute, $value, $parameters, $validator) {
			$tabla = $parameters[0] . '.' . $parameters[1];
			$count = DB::table($tabla)->where($attribute, '=', $value)->count();
			if ($count > 0) {
				return false;
			} else {
				return true;
			}
		});

		Validator::extend('unico_menos', function ($attribute, $value, $parameters, $validator) {

			$tabla = $parameters[0] . '.' . $parameters[1];
			$attr = $parameters[2];
			$valor = $parameters[3];

			$count = DB::table($tabla)->where($attribute, '=', $value)->where($attr, '<>', $valor)->count();

			if ($count > 0) {
				return false;
			} else {
				return true;
			}

		});

	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		//
	}
}
