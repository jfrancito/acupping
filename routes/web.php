<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/********************** USUARIOS *************************/
// header('Access-Control-Allow-Origin:  *');
// header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers: *');

Route::group(['middleware' => ['guestaw']], function () {

	Route::any('/', 'UserController@actionLogin');
	Route::any('/login', 'UserController@actionLogin');
	Route::any('/acceso', 'UserController@actionAcceso');

});

Route::get('/cerrarsession', 'UserController@actionCerrarSesion');

Route::group(['middleware' => ['authaw']], function () {

	Route::get('/bienvenido', 'UserController@actionBienvenido');

	Route::any('/gestion-de-usuarios/{idopcion}', 'UserController@actionListarUsuarios');
	Route::any('/agregar-usuario/{idopcion}', 'UserController@actionAgregarUsuario');
	Route::any('/modificar-usuario/{idopcion}/{idusuario}', 'UserController@actionModificarUsuario');
	Route::any('/ajax-activar-perfiles', 'UserController@actionAjaxActivarPerfiles');

	Route::any('/gestion-de-roles/{idopcion}', 'UserController@actionListarRoles');
	Route::any('/agregar-rol/{idopcion}', 'UserController@actionAgregarRol');
	Route::any('/modificar-rol/{idopcion}/{idrol}', 'UserController@actionModificarRol');

	Route::any('/gestion-de-permisos/{idopcion}', 'UserController@actionListarPermisos');
	Route::any('/ajax-listado-de-opciones', 'UserController@actionAjaxListarOpciones');
	Route::any('/ajax-activar-permisos', 'UserController@actionAjaxActivarPermisos');

	Route::any('/gestion-de-sesiones-catacion/{idopcion}', 'CatacionController@actionListarSesionCatacion');
	Route::any('/agregar-sesion-catacion/{idopcion}', 'CatacionController@actionAgregarSesionCatacion');
	Route::any('/modificar-sesion-catacion/{idopcion}/{idsesioncatacion}', 'CatacionController@actionModificarSesionCatacion');
	Route::any('/eliminar-sesion-catacion/{idopcion}/{idsesioncatacion}', 'CatacionController@actionEliminarSesionCatacion');
	Route::any('/editar-muestras/{idopcion}/{idsesioncatacion}', 'CatacionController@actionEditarMuestras');
	Route::any('/update-muestras/{idopcion}/{idmuestra}', 'CatacionController@actionUpdateMuestras');
	Route::any('/ajax-mostrar-form-muestra', 'CatacionController@actionAjaxMostrarFormMuestra');
	Route::any('/realizar-catacion/{idopcion}/{idsesioncatacion}', 'CatacionController@actionRealizarCatacion');

	Route::any('/ajax-recalcular-puntaje-catacion-muestra', 'CatacionController@actionAjaxRecalcularPuntajeCatacionMuestra');
	Route::any('/ajax-notas-catacion-muestra', 'CatacionController@actionAjaxNotasCatacionMuestra');
	Route::any('/ajax-mostrar-form-catacion', 'CatacionController@actionAjaxMostrarFormCatacion');
	Route::any('/ajax-tueste', 'CatacionController@actionAjaxTueste');

	Route::any('/ajax-lista-descriptores', 'CatacionController@actionAjaxListaDescriptores');
	Route::any('/ajax-lista-descriptores-catacion', 'CatacionController@actionAjaxListaDescriptoresCatacion');
	Route::any('/ajax-eliminar-descriptores-catacion', 'CatacionController@actionAjaxEliminarDescriptoresCatacion');
	Route::any('/ajax-combo-varietales-especie', 'CatacionController@actionAjaxComboVarietalesEspecie');

});
