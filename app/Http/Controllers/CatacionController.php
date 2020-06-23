<?php

namespace App\Http\Controllers;

use App\Catacion;
use App\Muestra;
use App\Sesioncatacion;
use App\Tipocatacion;
use Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;

class CatacionController extends Controller {

	public function actionListarSesionCatacion($idopcion) {

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion, 'Ver');
		if ($validarurl != 'true') {return $validarurl;}
		/******************************************************/

		$listasesiones = Sesioncatacion::where('activo', '=', 1)->get();
		$funcion = $this;

		return View::make('catacion/listasesioncatacion',
			[
				'idopcion' => $idopcion,
				'listasesiones' => $listasesiones,
				'funcion' => $funcion,
			]);
	}

	public function actionAgregarSesionCatacion($idopcion, Request $request) {
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion, 'Anadir');
		if ($validarurl != 'true') {return $validarurl;}
		/******************************************************/

		if ($_POST) {

			$fecha = $request['fecha'];
			$fecha = date_format(date_create(date($fecha)), 'Ymd h:i:s');
			$descripcion = $request['descripcion'];
			$lugar = $request['lugar'];
			$identificador_muestra = $request['identificador_muestra'];
			$numeros_muestra = $request['numeros_muestra'];

			$id = $this->funciones->getCreateIdMaestra('sesioncataciones');
			$codigo = $this->funciones->generar_codigo('sesioncataciones', 8);
			$cabecera = new Sesioncatacion;
			$cabecera->id = $id;
			$cabecera->fecha = date("Ymd h:i:s");
			$cabecera->fechasesion = date('Ymd');
			$cabecera->codigo = $codigo;
			$cabecera->descripcion = $descripcion;
			$cabecera->lugar = $lugar;
			$cabecera->identificador_muestra = $identificador_muestra;
			$cabecera->numeros_muestra = $numeros_muestra;
			$cabecera->fecha_crea = date("Ymd h:i:s");
			$cabecera->usuario_crea = Session::get('usuario')->usuario_solomon_id;
			$cabecera->save();

			//agregar muestra
			$array_letras = $this->catacion->array_letras();

			for ($i = 0; $i < $numeros_muestra; $i++) {

				//ver si es digito o letra
				$alias = '';
				if ($identificador_muestra == 'DI') {
					$alias = (string) ($i + 1);
				} else {
					$alias = $array_letras[$i]['letra'];
				}

				$muestra_id = $this->funciones->getCreateIdMaestra('muestras');
				$detalle = new Muestra;
				$detalle->id = $muestra_id;
				$detalle->alias = $alias;
				$detalle->aliasantes = $alias;
				$detalle->nombre = '';
				$detalle->descripcion = '';
				$detalle->numeroreferencia = '';
				$detalle->identificadorexterno = '';
				$detalle->humedad = 0;
				$detalle->densidad = 0;
				$detalle->puntaje = 0;
				$detalle->actividadagua = 0;
				$detalle->varietales = '';
				$detalle->aniocosecha = '';
				$detalle->proceso = '';
				$detalle->region = '';
				$detalle->productor = '';
				$detalle->proveedor = '';
				$detalle->pais_id = '1CIX00000001';
				$detalle->especie_id = '1CIX00000001';
				$detalle->tipomuestra_id = '1CIX00000001';
				$detalle->sesioncatacion_id = $id;
				$detalle->estado_id = '1CIX00000001';
				$detalle->aniocosecha_id = '1CIX00000011';
				$detalle->fecha_crea = $this->fechaactual;
				$detalle->usuario_crea = Session::get('usuario')->usuario_solomon_id;
				$detalle->save();
			}

			$listamuestas = Muestra::where('sesioncatacion_id', '=', $id)->orderBy('id', 'asc')->get();
			$listatipocataciones = Tipocatacion::orderBy('id', 'asc')->get();

			foreach ($listamuestas as $key => $item) {
				foreach ($listatipocataciones as $keytc => $itemtc) {

					$puntaje = $this->catacion->puntaje_catacion_tipo($itemtc->id, $itemtc->puntaje_defecto);
					$catacion_id = $this->funciones->getCreateIdMaestra('cataciones');
					$catacion = new Catacion;
					$catacion->id = $catacion_id;
					$catacion->muestra_id = $item->id;
					$catacion->tipocatacion_id = $itemtc->id;
					$catacion->puntaje = $puntaje;
					$catacion->notas = '';
					$catacion->value = $itemtc->puntaje_defecto;
					$catacion->fecha_crea = $this->fechaactual;
					$catacion->usuario_crea = Session::get('usuario')->usuario_solomon_id;
					$catacion->save();
				}
				$this->catacion->puntaje_muestra($item->id);
			}

			return Redirect::to('/gestion-de-sesiones-catacion/' . $idopcion)->with('bienhecho', 'Sesion de catacion ' . $codigo . ' registrado con exito');

		} else {

			$comboestructuramuestra = array('DI' => "Digitos", 'LE' => "Letras");
			$fecha = $this->hoy;
			$estructuramuestra_id = 'DI';

			return View::make('catacion/agregarsesioncatacion',
				[
					'comboestructuramuestra' => $comboestructuramuestra,
					'idopcion' => $idopcion,
					'fecha' => $fecha,
					'estructuramuestra_id' => $estructuramuestra_id,
				]);
		}
	}

	public function actionModificarSesionCatacion($idopcion, $idsesioncatacion, Request $request) {

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
		if ($validarurl != 'true') {return $validarurl;}
		/******************************************************/
		$idsesioncatacion = $this->funciones->decodificarmaestra($idsesioncatacion);

		if ($_POST) {

			$fecha = $request['fecha'];
			$fecha = date_format(date_create(date($fecha)), 'Ymd h:i:s');
			$descripcion = $request['descripcion'];
			$lugar = $request['lugar'];
			$identificador_muestra = $request['identificador_muestra'];

			$cabecera = Sesioncatacion::find($idsesioncatacion);
			$cabecera->fecha = $fecha;
			$cabecera->descripcion = $descripcion;
			$cabecera->lugar = $lugar;
			$cabecera->identificador_muestra = $identificador_muestra;
			$cabecera->fecha_mod = $this->fechaactual;
			$cabecera->usuario_mod = Session::get('usuario')->usuario_solomon_id;
			$cabecera->save();

			//agregar catacion
			$array_letras = $this->catacion->array_letras();
			$listamuestas = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->orderBy('id', 'asc')->get();

			foreach ($listamuestas as $key => $item) {
				//ver si es digito o letra
				$alias = '';
				if ($identificador_muestra == 'DI') {
					$alias = (string) ($key + 1);
				} else {
					$alias = $array_letras[$key]['letra'];
				}

				$item->aliasantes = $item->alias;
				$item->alias = $alias;
				$item->fecha_mod = $this->fechaactual;
				$item->usuario_mod = Session::get('usuario')->usuario_solomon_id;
				$item->save();

			}

			return Redirect::to('/gestion-de-sesiones-catacion/' . $idopcion)->with('bienhecho', 'Sesion de catacion ' . $cabecera->codigo . ' modificado con exito');

		} else {

			$comboestructuramuestra = array('DI' => "Digitos", 'LE' => "Letras");
			$sesioncatacion = Sesioncatacion::where('id', '=', $idsesioncatacion)->first();
			$funcion = $this;

			$estructuramuestra_id = $sesioncatacion->identificador_muestra;
			$fecha = $this->hoy;

			return View::make('catacion/modificarsesioncatacion',
				[
					'comboestructuramuestra' => $comboestructuramuestra,
					'idopcion' => $idopcion,
					'fecha' => $fecha,
					'estructuramuestra_id' => $estructuramuestra_id,
					'sesioncatacion' => $sesioncatacion,
				]);
		}
	}

	public function actionEliminarSesionCatacion($idopcion, $idsesioncatacion, Request $request) {

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion, 'Eliminar');
		if ($validarurl != 'true') {return $validarurl;}
		/******************************************************/
		$idsesioncatacion = $this->funciones->decodificarmaestra($idsesioncatacion);

		$cabecera = Sesioncatacion::find($idsesioncatacion);
		$cabecera->activo = 0;
		$cabecera->fecha_mod = $this->fechaactual;
		$cabecera->usuario_mod = Session::get('usuario')->usuario_solomon_id;
		$cabecera->save();

		return Redirect::to('/gestion-de-sesiones-catacion/' . $idopcion)->with('bienhecho', 'Sesion de catacion ' . $cabecera->codigo . ' eliminado con exito');

	}

	public function actionEditarMuestras($idopcion, $idsesioncatacion, Request $request) {

		$idsesioncatacion = $this->funciones->decodificarmaestra($idsesioncatacion);
		if (Session::get('muestra_id')) {
			$muestra = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->where('id', '=', Session::get('muestra_id'))->first();
			Session::flash('bienhecho', 'Muetra ' . $muestra->alias . ' modificado con exito');
		} else {
			$muestra = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->orderBy('id', 'asc')->first();
		}
		$sessioncatacion = Sesioncatacion::where('id', '=', $idsesioncatacion)->first();
		$listamuestas = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->orderBy('id', 'asc')->get();
		$combo_tipomuestras = $this->funciones->combo_tipomuestras();
		$combo_aniocosechas = $this->funciones->combo_aniocosechas();
		$combo_paises = $this->funciones->combo_paises();
		$combo_especies = $this->funciones->combo_especies();

		return View::make('catacion/editarmuestras',
			[
				'sessioncatacion' => $sessioncatacion,
				'idopcion' => $idopcion,
				'listamuestas' => $listamuestas,
				'muestra' => $muestra,
				'combo_tipomuestras' => $combo_tipomuestras,
				'combo_aniocosechas' => $combo_aniocosechas,
				'combo_paises' => $combo_paises,
				'combo_especies' => $combo_especies,
			]);

	}

	public function actionUpdateMuestras($idopcion, $idmuestra, Request $request) {

		$idmuestra = $this->funciones->decodificarmaestra($idmuestra);
		$muestra = Muestra::where('id', '=', $idmuestra)->first();

		$muestra->nombre = $request['nombre'];
		$muestra->descripcion = $request['descripcion'];
		$muestra->numeroreferencia = $request['numeroreferencia'];
		$muestra->identificadorexterno = $request['identificadorexterno'];
		$muestra->humedad = $request['humedad'];
		$muestra->densidad = $request['densidad'];
		$muestra->actividadagua = $request['actividadagua'];
		$muestra->varietales = $request['varietales'];
		$muestra->aniocosecha = $request['aniocosecha'];
		$muestra->proceso = $request['proceso'];
		$muestra->region = $request['region'];
		$muestra->productor = $request['productor'];
		$muestra->proveedor = $request['proveedor'];
		$muestra->pais_id = $request['pais_id'];
		$muestra->especie_id = $request['especie_id'];
		$muestra->tipomuestra_id = $request['tipomuestra_id'];
		$muestra->estado_id = '1CIX00000002';
		$muestra->aniocosecha_id = $request['aniocosecha_id'];
		$muestra->fecha_mod = $this->fechaactual;
		$muestra->usuario_mod = Session::get('usuario')->usuario_solomon_id;
		$muestra->save();

		return Redirect::to('/editar-muestras/' . $idopcion . '/' . Hashids::encode(substr($muestra->sesioncatacion_id, -8)))
			->with('muestra_id', $muestra->id);

	}

	public function actionAjaxMostrarFormMuestra(Request $request) {

		$idopcion = $request['idopcion'];
		$muestra = Muestra::where('id', '=', $request['muestra_id'])->first();

		$combo_tipomuestras = $this->funciones->combo_tipomuestras();
		$combo_aniocosechas = $this->funciones->combo_aniocosechas();
		$combo_paises = $this->funciones->combo_paises();
		$combo_especies = $this->funciones->combo_especies();

		return View::make('catacion/form/formmuestra',
			[
				'idopcion' => $idopcion,
				'muestra' => $muestra,
				'combo_tipomuestras' => $combo_tipomuestras,
				'combo_aniocosechas' => $combo_aniocosechas,
				'combo_paises' => $combo_paises,
				'combo_especies' => $combo_especies,
			]);

	}

	public function actionAjaxTueste(Request $request) {

		$muestra_id = $request['muestra_id'];
		$catacion_value = $request['catacion_value'];
		$tipocatacion_codigo = $request['tipocatacion_codigo'];

		$tipocatacion = Tipocatacion::where('codigo', '=', $tipocatacion_codigo)->first();
		$catacion = Catacion::where('muestra_id', '=', $muestra_id)
			->where('tipocatacion_id', '=', $tipocatacion->id)
			->first();

		$catacion->value = $catacion_value;
		$catacion->save();

		$muestra = Muestra::where('id', '=', $muestra_id)->first();
		$array_nivel_tueste = $this->catacion->array_nivel_tueste();
		$funcion = $this;

		return View::make('catacion/ajax/atueste',
			[
				'muestra' => $muestra,
				'array_nivel_tueste' => $array_nivel_tueste,
				'funcion' => $funcion,
			]);

	}

	public function actionAjaxMostrarFormCatacion(Request $request) {
		$idopcion = $request['idopcion'];
		$muestra = Muestra::where('id', '=', $request['muestra_id'])->first();
		$sessioncatacion = Sesioncatacion::where('id', '=', $muestra->sesioncatacion_id)->first();
		$listamuestas = Muestra::where('sesioncatacion_id', '=', $muestra->sesioncatacion_id)->orderBy('id', 'asc')->get();
		$funcion = $this;
		$array_nivel_tueste = $this->catacion->array_nivel_tueste();

		return View::make('catacion/form/formcatacion',
			[
				'muestra' => $muestra,
				'sessioncatacion' => $sessioncatacion,
				'listamuestas' => $listamuestas,
				'funcion' => $funcion,
				'array_nivel_tueste' => $array_nivel_tueste,
				'idopcion' => $idopcion,
				'ajax' => true,
			]);

	}

	public function actionRealizarCatacion($idopcion, $idsesioncatacion) {

		$idsesioncatacion = $this->funciones->decodificarmaestra($idsesioncatacion);

		if (Session::get('muestra_id')) {
			$muestra = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->where('id', '=', Session::get('muestra_id'))->first();
			Session::flash('bienhecho', 'Muetra ' . $muestra->alias . ' modificado con exito');
		} else {
			$muestra = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->orderBy('id', 'asc')->first();
		}
		$sessioncatacion = Sesioncatacion::where('id', '=', $idsesioncatacion)->first();
		$listamuestas = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->orderBy('id', 'asc')->get();
		$funcion = $this;
		$array_nivel_tueste = $this->catacion->array_nivel_tueste();

		return View::make('catacion/realizarcatacion',
			[
				'idopcion' => $idopcion,
				'sessioncatacion' => $sessioncatacion,
				'listamuestas' => $listamuestas,
				'muestra' => $muestra,
				'array_nivel_tueste' => $array_nivel_tueste,
				'funcion' => $funcion,
			]);
	}

	public function actionAjaxRecalcularPuntajeCatacionMuestra(Request $request) {

		$muestra_id = $request['muestra_id'];
		$catacion_value = $request['catacion_value'];
		$tipocatacion_codigo = $request['tipocatacion_codigo'];

		$tipocatacion = Tipocatacion::where('codigo', '=', $tipocatacion_codigo)->first();
		$catacion = Catacion::where('muestra_id', '=', $muestra_id)
			->where('tipocatacion_id', '=', $tipocatacion->id)
			->first();
		$catacion->puntaje = $catacion_value;
		$catacion->value = $catacion_value;
		$catacion->fecha_mod = $this->fechaactual;
		$catacion->usuario_mod = Session::get('usuario')->usuario_solomon_id;
		$catacion->save();
		$puntaje = $this->catacion->retornar_puntaje_muestra($muestra_id);
		print_r($puntaje);
	}
	public function actionAjaxNotasCatacionMuestra(Request $request) {

		$muestra_id = $request['muestra_id'];
		$catacion_value = $request['catacion_value'];
		$tipocatacion_codigo = $request['tipocatacion_codigo'];

		$tipocatacion = Tipocatacion::where('codigo', '=', $tipocatacion_codigo)->first();
		$catacion = Catacion::where('muestra_id', '=', $muestra_id)
			->where('tipocatacion_id', '=', $tipocatacion->id)
			->first();

		$catacion->notas = $catacion_value;
		$catacion->fecha_mod = $this->fechaactual;
		$catacion->usuario_mod = Session::get('usuario')->usuario_solomon_id;
		$catacion->save();

	}

}
