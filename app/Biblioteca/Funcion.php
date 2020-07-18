<?php
namespace App\Biblioteca;

use App\Aniocosecha;
use App\Codigotipomuestra;
use App\Color;
use App\Especie;
use App\Lugar;
use App\Nombrecomercial;
use App\Pais;
use App\Producto;
use App\Rolopcion;
use App\Tipomuestra;
use App\Tipoproceso;
use App\User;
use App\Varietal;
use Hashids;
use Illuminate\Support\Facades\DB;
use Redirect;
use Session;
use table;

class Funcion {

	public function codigo_muestra_agregando_historial($muestra_id, $tipomuestra_id) {
		$codigo = Codigotipomuestra::where('tipomuestra_id', '=', $tipomuestra_id)->max('correlativo');
		$tipomuestra = Tipomuestra::where('id', '=', $tipomuestra_id)->first();
		if (is_null($codigo)) {
			$codigo = 1;
		} else {
			$codigo = $codigo + 1;
		}
		//concatenar con ceros
		$codigo_completo = str_pad($codigo, 8, "0", STR_PAD_LEFT);
		$codigo_completo = $tipomuestra->abreviatura . $codigo_completo;

		//desactivar los otros codigos
		$listacodigotipomuestra = Codigotipomuestra::where('muestra_id', '=', $muestra_id)->get();

		foreach ($listacodigotipomuestra as $key => $item) {
			$item->activo = 0;
			$item->fecha_mod = date('Ymd h:i:s');
			$item->usuario_mod = Session::get('usuario')->usuario_solomon_id;
			$item->save();
		}
		// crear nuevo codigo

		$id = $this->getCreateIdMaestra('codigotipomuestras');
		$codigomuestra = new Codigotipomuestra;
		$codigomuestra->id = $id;
		$codigomuestra->codigo = $codigo_completo;
		$codigomuestra->correlativo = $codigo;
		$codigomuestra->muestra_id = $muestra_id;
		$codigomuestra->tipomuestra_id = $tipomuestra_id;
		$codigomuestra->fecha_crea = date('Ymd h:i:s');
		$codigomuestra->usuario_crea = Session::get('usuario')->usuario_solomon_id;
		$codigomuestra->save();

		return $codigo_completo;
	}

	public function combo_colores() {
		$combo_colores = Color::where('activo', '=', 1)
			->pluck('nombre', 'id')
			->toArray();
		return $combo_colores;
	}

	public function combo_productos() {
		$combo_productos = Producto::where('activo', '=', 1)
			->pluck('nombre', 'id')
			->toArray();
		return $combo_productos;
	}

	public function combo_tipoprocesos() {
		$combo_tipoprocesos = Tipoproceso::where('activo', '=', 1)
			->pluck('nombre', 'id')
			->toArray();
		return $combo_tipoprocesos;
	}

	public function combo_varietales_especies($especie_id) {
		$combo_varietales = Varietal::where('activo', '=', 1)
			->where('especie_id', '=', $especie_id)
			->pluck('nombre', 'id')
			->toArray();
		return $combo_varietales;
	}

	public function combo_nombrecomerciales() {
		$combo_nombrecomerciales = Nombrecomercial::where('activo', '=', 1)
			->pluck('nombre', 'id')
			->toArray();
		return $combo_nombrecomerciales;
	}

	public function combo_usuarios_menos_yo($usuario_id) {
		$combo_usuarios_menos_yo = User::where('activo', '=', 1)
			->where('id', '<>', '1CIX00000001')
			->where('id', '<>', $usuario_id)
			->pluck('nombre', 'id')
			->toArray();

		return $combo_usuarios_menos_yo;
	}

	public function combo_usuarios() {
		$combo_usuarios = User::where('activo', '=', 1)
			->pluck('nombre', 'id')
			->toArray();
		return $combo_usuarios;
	}

	public function combo_lugares() {
		$combo_lugares = Lugar::where('activo', '=', 1)
			->pluck('nombre', 'id')
			->toArray();
		return $combo_lugares;
	}
	public function combo_especies() {
		$combo_especies = Especie::where('activo', '=', 1)
			->pluck('nombre', 'id')
			->toArray();
		return $combo_especies;
	}

	public function combo_paises() {
		$combo_paises = Pais::where('activo', '=', 1)
			->pluck('nombre', 'id')
			->toArray();
		return $combo_paises;
	}

	public function combo_aniocosechas() {
		$combo_aniocosechas = Aniocosecha::where('activo', '=', 1)
			->pluck('nombre', 'id')
			->toArray();
		return $combo_aniocosechas;
	}

	public function combo_tipomuestras() {
		$combo_tipomuestras = Tipomuestra::where('activo', '=', 1)
			->pluck('nombre', 'id')
			->toArray();
		return $combo_tipomuestras;
	}

	public function tabla_usuario($usuario_id) {
		$usuario = User::where('id', '=', $usuario_id)->first();
		return $usuario;
	}

	public function generar_codigo($basedatos, $cantidad) {

		// maximo valor de la tabla referente
		$tabla = DB::table($basedatos)
			->select(DB::raw('max(codigo) as codigo'))
			->get();

		//conversion a string y suma uno para el siguiente id
		$idsuma = (int) $tabla[0]->codigo + 1;

		//concatenar con ceros
		$correlativocompleta = str_pad($idsuma, $cantidad, "0", STR_PAD_LEFT);

		return $correlativocompleta;

	}

	public function decodificarmaestra($id) {

		//decodificar variable
		$iddeco = Hashids::decode($id);
		//ver si viene con letras la cadena codificada
		if (count($iddeco) == 0) {
			return '';
		}
		//concatenar con ceros
		$idopcioncompleta = str_pad($iddeco[0], 8, "0", STR_PAD_LEFT);
		//concatenar prefijo

		//$prefijo = Local::where('activo', '=', 1)->first();

		// apunta ahi en tu cuaderno porque esto solo va a permitir decodifcar  cuando sea el contrato del locl en donde estas del resto no
		//¿cuando sea el contrato del local?
		$prefijo = $this->prefijomaestra();
		$idopcioncompleta = $prefijo . $idopcioncompleta;
		return $idopcioncompleta;

	}

	public function getUrl($idopcion, $accion) {

		//decodificar variable
		$decidopcion = Hashids::decode($idopcion);
		//ver si viene con letras la cadena codificada
		if (count($decidopcion) == 0) {
			return Redirect::back()->withInput()->with('errorurl', 'Indices de la url con errores');
		}

		//concatenar con ceros
		$idopcioncompleta = str_pad($decidopcion[0], 8, "0", STR_PAD_LEFT);
		//concatenar prefijo

		// hemos hecho eso porque ahora el prefijo va hacer fijo en todas las empresas que 1CIX
		//$prefijo = Local::where('activo', '=', 1)->first();
		//$idopcioncompleta = $prefijo->prefijoLocal.$idopcioncompleta;
		$idopcioncompleta = '1CIX' . $idopcioncompleta;

		// ver si la opcion existe
		$opcion = Rolopcion::where('opcion_id', '=', $idopcioncompleta)
			->where('rol_id', '=', Session::get('usuario')->rol_id)
			->where($accion, '=', 1)
			->first();

		if (count($opcion) <= 0) {
			return Redirect::back()->withInput()->with('errorurl', 'No tiene autorización para ' . $accion . ' aquí');
		}
		return 'true';

	}

	public function getCreateIdMaestra($tabla) {

		$id = "";
		// maximo valor de la tabla referente
		$id = DB::table($tabla)
			->select(DB::raw('max(SUBSTRING(id,5,8)) as id'))
			->first();
		//conversion a string y suma uno para el siguiente id
		$idsuma = (int) $id->id + 1;
		//concatenar con ceros
		$idopcioncompleta = str_pad($idsuma, 8, "0", STR_PAD_LEFT);
		//concatenar prefijo
		$prefijo = $this->prefijomaestra();
		$idopcioncompleta = $prefijo . $idopcioncompleta;
		return $idopcioncompleta;

	}

	public function prefijomaestra() {

		$prefijo = '1CIX';
		return $prefijo;
	}

}
