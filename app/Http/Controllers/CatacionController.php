<?php

namespace App\Http\Controllers;

use App\Catacion;
use App\Cataciondescriptor;
use App\Lugar;
use App\Muestra;
use App\Muestradescriptor;
use App\Sesioncatacion;
use App\Sesionuser;
use App\Tipocatacion;
use App\User;
use Hashids;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;

class CatacionController extends Controller {

	public function actionVerReporteMuestra($idmuestra, $idopcion) {

		$listatipocatacion = Tipocatacion::where('codigo', '<>', '00000001')
			->where('codigo', '<>', '00000013')->orderBy('id', 'asc')->get();
		$muestra = Muestra::where('id', '=', $idmuestra)->orderBy('id', 'asc')->first();
		$funcion = $this;
		$data_rueda_sabores = $this->catacion->data_rueda_sabores($idmuestra);
		$data_rueda_sabores = $this->catacion->quitar_numeros_json($data_rueda_sabores);
		$array_listacatacion = Catacion::where('muestra_id', '=', $idmuestra)->pluck('id')->toArray();
		$array_cataciondescriptores_tipo = Cataciondescriptor::join('descriptortipocataciones', 'cataciondescriptores.descriptortipocatacion_id', '=', 'descriptortipocataciones.id')
			->wherein('catacion_id', $array_listacatacion)->where('cataciondescriptores.activo', '=', '1')
			->select('descriptortipocataciones.descriptor_id')
			->groupBy('descriptortipocataciones.descriptor_id')
			->pluck('descriptortipocataciones.descriptor_id')->toArray();

		return View::make('catacion/rerportemuestra',
			[
				'idopcion' => $idopcion,
				'listatipocatacion' => $listatipocatacion,
				'muestra' => $muestra,
				'funcion' => $funcion,
				'data' => $data_rueda_sabores,
				'array_cataciondescriptores_tipo' => $array_cataciondescriptores_tipo,
			]);

	}

	public function actionRevisarCatacion($idopcion, $idsesioncatacion) {

		$idsesioncatacion = $this->funciones->decodificarmaestra($idsesioncatacion);

		if (Session::get('muestra_id')) {
			$muestra = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->where('id', '=', Session::get('muestra_id'))->first();
			Session::flash('bienhecho', 'Muetra ' . $muestra->alias . ' modificado con exito');
		} else {
			$muestra = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->orderBy('id', 'asc')->first();
		}
		$sessioncatacion = Sesioncatacion::where('id', '=', $idsesioncatacion)->first();
		$listamuestas = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->orderBy('id', 'asc')->get();

		$array_listamuestras = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->pluck('id')->toArray();
		$array_listacatacion = Catacion::wherein('muestra_id', $array_listamuestras)->pluck('id')->toArray();
		$listacataciondescriptores = Cataciondescriptor::wherein('catacion_id', $array_listacatacion)->where('activo', '=', '1')->get();

		$listamuestradescriptores = Muestradescriptor::where('muestra_id', '=', $muestra->id)->where('activo', '=', '1')
			->orderBy('prioridad', 'asc')->get();
		$funcion = $this;
		$array_nivel_tueste = $this->catacion->array_nivel_tueste();
		$combo_numerotazas = $this->funciones->combo_numerotazas();
		$combo_intensidad = $this->funciones->combo_intensidad();

		$listatipocatacion = Tipocatacion::orderBy('id', 'asc')->get();

		return View::make('catacion/revisarcatacion',
			[
				'idopcion' => $idopcion,
				'sessioncatacion' => $sessioncatacion,
				'listamuestas' => $listamuestas,
				'muestra' => $muestra,
				'muestra_id' => $muestra->id,
				'array_nivel_tueste' => $array_nivel_tueste,
				'listacataciondescriptores' => $listacataciondescriptores,
				'listamuestradescriptores' => $listamuestradescriptores,
				'listatipocatacion' => $listatipocatacion,
				'combo_numerotazas' => $combo_numerotazas,
				'combo_intensidad' => $combo_intensidad,
				'funcion' => $funcion,
				'revisar' => true,
			]);
	}

	public function actionAjaxMostrarFormCatacionRevisar(Request $request) {
		$idopcion = $request['idopcion'];
		$muestra = Muestra::where('id', '=', $request['muestra_id'])->first();
		$sessioncatacion = Sesioncatacion::where('id', '=', $muestra->sesioncatacion_id)->first();
		$listamuestas = Muestra::where('sesioncatacion_id', '=', $muestra->sesioncatacion_id)->orderBy('id', 'asc')->get();
		$funcion = $this;
		$array_nivel_tueste = $this->catacion->array_nivel_tueste();

		$array_listamuestras = Muestra::where('sesioncatacion_id', '=', $muestra->sesioncatacion_id)->pluck('id')->toArray();
		$array_listacatacion = Catacion::wherein('muestra_id', $array_listamuestras)->pluck('id')->toArray();
		$listacataciondescriptores = Cataciondescriptor::wherein('catacion_id', $array_listacatacion)->where('activo', '=', '1')->get();

		$listamuestradescriptores = Muestradescriptor::where('muestra_id', '=', $muestra->id)->where('activo', '=', '1')
			->orderBy('prioridad', 'asc')->get();

		$combo_numerotazas = $this->funciones->combo_numerotazas();
		$combo_intensidad = $this->funciones->combo_intensidad();
		$listatipocatacion = Tipocatacion::orderBy('id', 'asc')->get();

		return View::make('catacion/form/formcatacionrevisar',
			[
				'muestra' => $muestra,
				'sessioncatacion' => $sessioncatacion,
				'listamuestas' => $listamuestas,
				'listacataciondescriptores' => $listacataciondescriptores,
				'listamuestradescriptores' => $listamuestradescriptores,
				'funcion' => $funcion,
				'muestra_id' => $muestra->id,
				'array_nivel_tueste' => $array_nivel_tueste,
				'idopcion' => $idopcion,
				'combo_numerotazas' => $combo_numerotazas,
				'combo_intensidad' => $combo_intensidad,
				'listatipocatacion' => $listatipocatacion,
				'ajax' => true,
				'revisar' => true,
			]);

	}

	public function actionCerrarSesionCatacion(Request $request) {

		$sessioncatacion_id = $request['sesioncatacion'];
		$idopcion = $request['idopcion'];

		$sesioncatacion = Sesioncatacion::where('id', '=', $sessioncatacion_id)->first();
		$sesioncatacion->estado_id = '1CIX00000003';
		$sesioncatacion->fecha_mod = date("Ymd h:i:s");
		$sesioncatacion->usuario_mod = Session::get('usuario')->usuario_solomon_id;
		$sesioncatacion->save();

		return Redirect::to('/revisar-catacion/' . $idopcion . '/' . Hashids::encode(substr($sessioncatacion_id, -8)))->with('bienhecho', 'Sesion de catacion ' . $sesioncatacion->codigo . ' cerrado con exito');

	}

	public function actionAjaxModalDetalleMuestras(Request $request) {

		$sessioncatacion_id = $request['sessioncatacion_id'];
		$data_opcion = $request['data_opcion'];

		$sessioncatacion = Sesioncatacion::where('id', '=', $sessioncatacion_id)->first();
		$listatipocatacion = Tipocatacion::where('id', '<>', '1CIX00000013')
			->orderBy('id', 'asc')->get();
		$funcion = $this;

		return View::make('catacion/ajax/amodaldetallesesion',
			[
				'sessioncatacion' => $sessioncatacion,
				'listatipocatacion' => $listatipocatacion,
				'funcion' => $funcion,
				'idopcion' => $data_opcion,
			]);

	}

	public function actionAjaxActualizarDescriptoresMuestra(Request $request) {

		$muestra_id = $request['muestra_id'];
		$listamuestradescriptores = Muestradescriptor::where('muestra_id', '=', $muestra_id)->where('activo', '=', '1')
			->orderBy('prioridad', 'asc')->get();

		return View::make('catacion/ajax/adescriptormuestras',
			[
				'listamuestradescriptores' => $listamuestradescriptores,
			]);

	}

	public function actionAjaxSubirBajarPrioridades(Request $request) {

		$muestra_descriptor_id = $request['muestra_descriptor_id'];
		$accion = $request['accion'];
		$muestra_id = $request['muestra_id'];

		if ($accion == 'btn_bottom') {

			$muestra_descritor_bajar = Muestradescriptor::where('id', '=', $muestra_descriptor_id)->first();
			$muestra_descritor_subir = Muestradescriptor::where('muestra_id', '=', $muestra_descritor_bajar->muestra_id)
				->where('prioridad', '=', $muestra_descritor_bajar->prioridad + 1)->first();

		} else {

			$muestra_descritor_subir = Muestradescriptor::where('id', '=', $muestra_descriptor_id)->first();
			$muestra_descritor_bajar = Muestradescriptor::where('muestra_id', '=', $muestra_descritor_subir->muestra_id)
				->where('prioridad', '=', $muestra_descritor_subir->prioridad - 1)->first();

		}

		$muestra_descritor_bajar->prioridad = $muestra_descritor_bajar->prioridad + 1;
		$muestra_descritor_bajar->fecha_mod = date("Ymd h:i:s");
		$muestra_descritor_bajar->usuario_mod = Session::get('usuario')->usuario_solomon_id;
		$muestra_descritor_bajar->save();

		$muestra_descritor_subir->prioridad = $muestra_descritor_subir->prioridad - 1;
		$muestra_descritor_subir->fecha_mod = date("Ymd h:i:s");
		$muestra_descritor_subir->usuario_mod = Session::get('usuario')->usuario_solomon_id;
		$muestra_descritor_subir->save();

		$listamuestradescriptores = Muestradescriptor::where('muestra_id', '=', $muestra_id)->where('activo', '=', '1')
			->orderBy('prioridad', 'asc')->get();

		return View::make('catacion/ajax/adescriptormuestras',
			[
				'listamuestradescriptores' => $listamuestradescriptores,
			]);

	}

	public function actionAjaxEliminarDescriptoresCatacion(Request $request) {

		$data_catacion_descriptor_id = $request['data_catacion_descriptor_id'];
		$tipocatacion_codigo = $request['tipocatacion_codigo'];
		$muestra_id = $request['muestra_id'];

		$catacion_descriptor = Cataciondescriptor::where('id', '=', $data_catacion_descriptor_id)->first();
		$catacion_descriptor->activo = 0;
		$catacion_descriptor->fecha_mod = date("Ymd h:i:s");
		$catacion_descriptor->usuario_mod = Session::get('usuario')->usuario_solomon_id;
		$catacion_descriptor->save();

		$muestra = Muestra::where('id', '=', $muestra_id)->first();

		$array_listamuestras = Muestra::where('sesioncatacion_id', '=', $muestra->sesioncatacion->id)->pluck('id')->toArray();
		$array_listacatacion = Catacion::wherein('muestra_id', $array_listamuestras)->pluck('id')->toArray();
		$listacataciondescriptores = Cataciondescriptor::wherein('catacion_id', $array_listacatacion)->where('activo', '=', '1')->get();

		$array_listamuestras_p = Muestra::where('sesioncatacion_id', '=', $muestra->sesioncatacion->id)
			->where('id', '=', $muestra_id)->pluck('id')->toArray();
		$array_listacatacion_p = Catacion::wherein('muestra_id', $array_listamuestras_p)->pluck('id')->toArray();
		$listacataciondescriptores_p = Cataciondescriptor::wherein('catacion_id', $array_listacatacion_p)->where('activo', '=', '1')->get();

		$descriptor_id = $catacion_descriptor->descriptortipocatacion->descriptor_id;
		$this->catacion->desactivar_poner_prioridad($muestra_id, $descriptor_id, $listacataciondescriptores_p);

		return View::make('catacion/ajax/adescriptorcatacion',
			[
				'listacataciondescriptores' => $listacataciondescriptores,
				'tipocatacion_codigo' => $tipocatacion_codigo,
				'muestra_id' => $muestra->id,
			]);

	}

	public function actionAjaxListaDescriptoresCatacion(Request $request) {

		$descriptortipocatacion_id = $request['descriptortipocatacion_id'];
		$data_catacion_id = $request['data_catacion_id'];
		$tipocatacion_codigo = $request['tipocatacion_codigo'];
		$data_muestra_id = $request['muestra_id'];

		$cataciondescriptor = Cataciondescriptor::where('descriptortipocatacion_id', '=', $descriptortipocatacion_id)
			->where('catacion_id', '=', $data_catacion_id)->first();

		//dd($cataciondescriptor);

		if (count($cataciondescriptor) <= 0) {
			$id = $this->funciones->getCreateIdMaestra('cataciondescriptores');
			$cabecera = new Cataciondescriptor;
			$cabecera->id = $id;
			$cabecera->fecha_crea = date("Ymd h:i:s");
			$cabecera->usuario_crea = Session::get('usuario')->usuario_solomon_id;
			$cabecera->descriptortipocatacion_id = $descriptortipocatacion_id;
			$cabecera->catacion_id = $data_catacion_id;
			$cabecera->save();

			$descriptor_id = $cabecera->descriptortipocatacion->descriptor_id;
		} else {
			$cataciondescriptor->activo = 1;
			$cataciondescriptor->fecha_mod = date("Ymd h:i:s");
			$cataciondescriptor->usuario_mod = Session::get('usuario')->usuario_solomon_id;
			$cataciondescriptor->save();

			$descriptor_id = $cataciondescriptor->descriptortipocatacion->descriptor_id;
		}

		$catacion = Catacion::where('id', '=', $data_catacion_id)->first();
		$array_listamuestras = Muestra::where('sesioncatacion_id', '=', $catacion->muestra->sesioncatacion->id)->pluck('id')->toArray();
		$array_listacatacion = Catacion::wherein('muestra_id', $array_listamuestras)->pluck('id')->toArray();
		$listacataciondescriptores = Cataciondescriptor::wherein('catacion_id', $array_listacatacion)->where('activo', '=', '1')->get();

		$this->catacion->activar_poner_prioridad($data_muestra_id, $descriptor_id);

		return View::make('catacion/ajax/adescriptorcatacion',
			[
				'listacataciondescriptores' => $listacataciondescriptores,
				'tipocatacion_codigo' => $tipocatacion_codigo,
				'muestra_id' => $catacion->muestra->id,
			]);

	}

	public function actionAjaxListaDescriptores(Request $request) {

		$tipocatacion_codigo = $request['tipocatacion_codigo'];
		$muestra_id = $request['muestra_id'];
		$tipocatacion = Tipocatacion::where('codigo', '=', $tipocatacion_codigo)->first();
		$listadescriptortipocatacion = $this->catacion->lista_descriptores_niveles(1, $tipocatacion->id, '00');

		$catacion_id = Catacion::where('muestra_id', '=', $muestra_id)
			->join('tipocataciones', 'tipocataciones.id', '=', 'cataciones.tipocatacion_id')
			->where('tipocataciones.codigo', '=', $tipocatacion_codigo)
			->select('cataciones.*')
			->first()->id;

		$funcion = $this;

		return View::make('catacion/ajax/alistadescriptores',
			[
				'listadescriptortipocatacion' => $listadescriptortipocatacion,
				'funcion' => $funcion,
				'tipocatacion_id' => $tipocatacion->id,
				'catacion_id' => $catacion_id,
				'tipocatacion_codigo' => $tipocatacion_codigo,
				'ajax' => true,
			]);

	}

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
			$lugar_id = $request['lugar_id'];
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
			$cabecera->lugar_id = $lugar_id;
			$cabecera->identificador_muestra = 'DI';
			$cabecera->numeros_muestra = $numeros_muestra;
			$cabecera->puntaje = 0.00;
			$cabecera->estado_id = '1CIX00000001';
			$cabecera->fecha_crea = date("Ymd h:i:s");
			$cabecera->usuario_crea = Session::get('usuario')->usuario_solomon_id;
			$cabecera->save();

			$idsesioncatacion = $id;
			//agregar usuarios a sesion catacion

			$invitarusuarios = $request['invitarusuarios'];
			$listausuarios = User::whereIn('id', $invitarusuarios)
				->orwhere('id', '=', Session::get('usuario')->id)->get();

			foreach ($listausuarios as $item) {

				$idsu = $this->funciones->getCreateIdMaestra('sesionusers');
				$sesion = new Sesionuser;
				$sesion->id = $idsu;
				$sesion->sesioncatacion_id = $id;
				$sesion->user_id = $item->id;
				$sesion->fecha_crea = date("Ymd h:i:s");
				$sesion->usuario_crea = Session::get('usuario')->usuario_solomon_id;
				$sesion->save();

			}

			$identificador_muestra = 'DI';
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
				$detalle->marcaproducto = '';
				$detalle->nota = '';
				$detalle->humedad = 9;
				$detalle->densidad = 300;
				$detalle->puntaje = 0;
				$detalle->actividadagua = 0.45;
				$detalle->productor = '';
				$detalle->nombrecomercial_id = '1CIX00000001';
				$detalle->producto_id = '1CIX00000001';
				$detalle->tipoproceso_id = '1CIX00000001';
				$detalle->color_id = '1CIX00000001';
				$detalle->pais_id = '1CIX00000001';
				$detalle->especie_id = '1CIX00000001';
				$detalle->varietal_id = '1CIX00000001';
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

			$this->catacion->puntaje_session_catacion($idsesioncatacion);
			$listadescriptorprioridad = $this->catacion->lista_descriptores_prioridad();
			//muestra con descriptores prioridad
			foreach ($listamuestas as $key => $item) {
				foreach ($listadescriptorprioridad as $keytc => $itemtc) {

					$muestradescriptor_id = $this->funciones->getCreateIdMaestra('muestradescriptores');

					$muestradescriptor = new Muestradescriptor;
					$muestradescriptor->id = $muestradescriptor_id;
					$muestradescriptor->fecha_crea = $this->fechaactual;
					$muestradescriptor->usuario_crea = Session::get('usuario')->usuario_solomon_id;
					$muestradescriptor->muestra_id = $item->id;
					$muestradescriptor->descriptor_id = $itemtc->id;
					$muestradescriptor->save();
				}
			}

			return Redirect::to('/gestion-de-sesiones-catacion/' . $idopcion)->with('bienhecho', 'Sesion de catacion ' . $codigo . ' registrado con exito');

		} else {

			$comboestructuramuestra = array('DI' => "Digitos", 'LE' => "Letras");
			$fecha = $this->hoy;
			$estructuramuestra_id = 'DI';
			$combo_lugares = $this->funciones->combo_lugares();
			$combo_usuarios = $this->funciones->combo_usuarios_menos_yo(Session::get('usuario')->id);
			$sesioncatacion_lugar_id = Lugar::where('activo', '=', 1)->first();
			$array_usuarios = array();

			return View::make('catacion/agregarsesioncatacion',
				[
					'comboestructuramuestra' => $comboestructuramuestra,
					'idopcion' => $idopcion,
					'fecha' => $fecha,
					'estructuramuestra_id' => $estructuramuestra_id,
					'combo_lugares' => $combo_lugares,
					'combo_usuarios' => $combo_usuarios,
					'sesioncatacion_lugar_id' => $sesioncatacion_lugar_id,
					'array_usuarios' => $array_usuarios,
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
			$lugar_id = $request['lugar_id'];

			$cabecera = Sesioncatacion::find($idsesioncatacion);
			$cabecera->fecha = $fecha;
			$cabecera->descripcion = $descripcion;
			$cabecera->lugar_id = $lugar_id;
			$cabecera->fecha_mod = $this->fechaactual;
			$cabecera->usuario_mod = Session::get('usuario')->usuario_solomon_id;
			$cabecera->save();

			//modificamos usuarios a sesion catacion
			$sesionmod = Sesionuser::where('sesioncatacion_id', '=', $idsesioncatacion)
				->where('id', '<>', '1CIX00000001')
				->where('id', '<>', Session::get('usuario')->id)
				->get();

			foreach ($sesionmod as $item) {
				$item->fecha_mod = $this->fechaactual;
				$item->usuario_mod = Session::get('usuario')->usuario_solomon_id;
				$item->activo = 0;
				$item->save();
			}

			$invitarusuarios = $request['invitarusuarios'];
			$listausuarios = User::whereIn('id', $invitarusuarios)
				->orwhere('id', '=', Session::get('usuario')->id)->get();

			foreach ($listausuarios as $itemu) {

				$sesionuno = Sesionuser::where('sesioncatacion_id', '=', $idsesioncatacion)
					->where('user_id', '=', $itemu->id)->first();

				if (count($sesionuno) > 0) {
					$sesionuno->fecha_mod = $this->fechaactual;
					$sesionuno->usuario_mod = Session::get('usuario')->usuario_solomon_id;
					$sesionuno->activo = 1;
					$sesionuno->save();
				} else {
					$idsu = $this->funciones->getCreateIdMaestra('sesionusers');
					$sesion = new Sesionuser;
					$sesion->id = $idsu;
					$sesion->sesioncatacion_id = $idsesioncatacion;
					$sesion->user_id = $itemu->id;
					$sesion->fecha_crea = date("Ymd h:i:s");
					$sesion->usuario_crea = Session::get('usuario')->usuario_solomon_id;
					$sesion->save();
				}

			}

			//agregar catacion
			$array_letras = $this->catacion->array_letras();
			$listamuestas = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->orderBy('id', 'asc')->get();
			$identificador_muestra = 'DI';
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
			$fecha = $this->hoy;
			$combo_lugares = $this->funciones->combo_lugares();
			$combo_usuarios = $this->funciones->combo_usuarios_menos_yo(Session::get('usuario')->id);
			$sesioncatacion_lugar_id = $sesioncatacion->lugar_id;
			$array_usuarios = Sesionuser::where('sesioncatacion_id', '=', $sesioncatacion->id)
				->where('activo', '=', 1)->pluck('user_id')->toArray();

			return View::make('catacion/modificarsesioncatacion',
				[
					'comboestructuramuestra' => $comboestructuramuestra,
					'idopcion' => $idopcion,
					'fecha' => $fecha,
					'sesioncatacion' => $sesioncatacion,
					'combo_lugares' => $combo_lugares,
					'combo_usuarios' => $combo_usuarios,
					'sesioncatacion_lugar_id' => $sesioncatacion_lugar_id,
					'array_usuarios' => $array_usuarios,
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
		$combo_nombrecomerciales = $this->funciones->combo_nombrecomerciales();
		$combo_varietales_especies = $this->funciones->combo_varietales_especies($muestra->especie->id);
		$combo_tipoprocesos = $this->funciones->combo_tipoprocesos();
		$combo_productos = $this->funciones->combo_productos();
		$combo_colores = $this->funciones->combo_colores();

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
				'combo_nombrecomerciales' => $combo_nombrecomerciales,
				'combo_varietales_especies' => $combo_varietales_especies,
				'combo_tipoprocesos' => $combo_tipoprocesos,
				'combo_productos' => $combo_productos,
				'combo_colores' => $combo_colores,
			]);

	}

	public function actionUpdateMuestras($idopcion, $idmuestra, Request $request) {

		$idmuestra = $this->funciones->decodificarmaestra($idmuestra);
		$muestra = Muestra::where('id', '=', $idmuestra)->first();
		$codigo = $muestra->codigo;

		if ($muestra->tipomuestra_id != $request['tipomuestra_id'] or $muestra->estado_id == '1CIX00000001') {
			$codigo = $this->funciones->codigo_muestra_agregando_historial($idmuestra, $request['tipomuestra_id']);
		}

		$muestra->productor = $request['productor'];
		$muestra->codigo = $codigo;
		$muestra->tipomuestra_id = $request['tipomuestra_id'];
		$muestra->producto_id = $request['producto_id'];
		$muestra->marcaproducto = $request['marcaproducto'];
		$muestra->nombrecomercial_id = $request['nombrecomercial_id'];
		$muestra->nota = $request['nota'];
		$muestra->especie_id = $request['especie_id'];
		$muestra->varietal_id = $request['varietal_id'];
		$muestra->color_id = $request['color_id'];
		$muestra->humedad = $request['humedad'];
		$muestra->densidad = $request['densidad'];
		$muestra->actividadagua = $request['actividadagua'];
		$muestra->tipoproceso_id = $request['tipoproceso_id'];
		$muestra->aniocosecha_id = $request['aniocosecha_id'];
		$muestra->pais_id = $request['pais_id'];
		$muestra->estado_id = '1CIX00000002';
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
		$combo_nombrecomerciales = $this->funciones->combo_nombrecomerciales();

		$combo_varietales_especies = $this->funciones->combo_varietales_especies($muestra->especie->id);
		$combo_tipoprocesos = $this->funciones->combo_tipoprocesos();

		$combo_productos = $this->funciones->combo_productos();
		$combo_colores = $this->funciones->combo_colores();

		return View::make('catacion/form/formmuestra',
			[
				'idopcion' => $idopcion,
				'muestra' => $muestra,
				'combo_tipomuestras' => $combo_tipomuestras,
				'combo_aniocosechas' => $combo_aniocosechas,
				'combo_paises' => $combo_paises,
				'combo_especies' => $combo_especies,
				'combo_nombrecomerciales' => $combo_nombrecomerciales,
				'combo_varietales_especies' => $combo_varietales_especies,
				'combo_tipoprocesos' => $combo_tipoprocesos,
				'combo_productos' => $combo_productos,
				'combo_colores' => $combo_colores,
			]);

	}

	public function actionAjaxComboVarietalesEspecie(Request $request) {

		$especie_id = $request['especie_id'];
		$combo_varietales_especies = $this->funciones->combo_varietales_especies($especie_id);

		return View::make('catacion/ajax/acombovarietales',
			[
				'combo_varietales_especies' => $combo_varietales_especies,
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

		$array_listamuestras = Muestra::where('sesioncatacion_id', '=', $muestra->sesioncatacion_id)->pluck('id')->toArray();
		$array_listacatacion = Catacion::wherein('muestra_id', $array_listamuestras)->pluck('id')->toArray();
		$listacataciondescriptores = Cataciondescriptor::wherein('catacion_id', $array_listacatacion)->where('activo', '=', '1')->get();

		$listamuestradescriptores = Muestradescriptor::where('muestra_id', '=', $muestra->id)->where('activo', '=', '1')
			->orderBy('prioridad', 'asc')->get();

		$combo_numerotazas = $this->funciones->combo_numerotazas();
		$combo_intensidad = $this->funciones->combo_intensidad();

		return View::make('catacion/form/formcatacion',
			[
				'muestra' => $muestra,
				'sessioncatacion' => $sessioncatacion,
				'listamuestas' => $listamuestas,
				'listacataciondescriptores' => $listacataciondescriptores,
				'listamuestradescriptores' => $listamuestradescriptores,
				'funcion' => $funcion,
				'muestra_id' => $muestra->id,
				'array_nivel_tueste' => $array_nivel_tueste,
				'idopcion' => $idopcion,
				'combo_numerotazas' => $combo_numerotazas,
				'combo_intensidad' => $combo_intensidad,
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

		$array_listamuestras = Muestra::where('sesioncatacion_id', '=', $idsesioncatacion)->pluck('id')->toArray();
		$array_listacatacion = Catacion::wherein('muestra_id', $array_listamuestras)->pluck('id')->toArray();
		$listacataciondescriptores = Cataciondescriptor::wherein('catacion_id', $array_listacatacion)->where('activo', '=', '1')->get();

		$listamuestradescriptores = Muestradescriptor::where('muestra_id', '=', $muestra->id)->where('activo', '=', '1')
			->orderBy('prioridad', 'asc')->get();

		$funcion = $this;
		$array_nivel_tueste = $this->catacion->array_nivel_tueste();

		$combo_numerotazas = $this->funciones->combo_numerotazas();
		$combo_intensidad = $this->funciones->combo_intensidad();

		return View::make('catacion/realizarcatacion',
			[
				'idopcion' => $idopcion,
				'sessioncatacion' => $sessioncatacion,
				'listamuestas' => $listamuestas,
				'muestra' => $muestra,
				'muestra_id' => $muestra->id,
				'array_nivel_tueste' => $array_nivel_tueste,
				'listacataciondescriptores' => $listacataciondescriptores,
				'listamuestradescriptores' => $listamuestradescriptores,
				'combo_numerotazas' => $combo_numerotazas,
				'combo_intensidad' => $combo_intensidad,
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

	public function actionAjaxRecalcularPuntajeCatacionMuestraDefecto(Request $request) {

		$muestra_id = $request['muestra_id'];
		$catacion_value = $request['catacion_value'];
		$tipocatacion_codigo = $request['tipocatacion_codigo'];
		$intensidad = $request['intensidad'];
		$numero_tazas = $request['numero_tazas'];

		$tipocatacion = Tipocatacion::where('codigo', '=', $tipocatacion_codigo)->first();
		$catacion = Catacion::where('muestra_id', '=', $muestra_id)
			->where('tipocatacion_id', '=', $tipocatacion->id)
			->first();
		$catacion->puntaje = $catacion_value;
		$catacion->value = $catacion_value;
		$catacion->intensidad = $intensidad;
		$catacion->numerotasas = $numero_tazas;
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
