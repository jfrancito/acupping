<?php
namespace App\Biblioteca;
use App\Catacion;
use App\Descriptor;
use App\Descriptortipocatacion;
use App\Muestra;
use App\Muestradescriptor;
use App\Sesioncatacion;
use App\Tipocatacion;
use DB;
use Session;

class Cataciones {

	public function desactivar_poner_prioridad($muestra_id, $descriptor_id, $listacataciondescriptores) {

		$descriptor = Descriptor::where('id', '=', $descriptor_id)->first();
		$codigo_padre = substr($descriptor->codigo, 0, 2);
		$sw = 0;

		foreach ($listacataciondescriptores as $key => $item) {
			$codigo_padre_catacion = substr($item->descriptortipocatacion->descriptor->codigo, 0, 2);
			if ($codigo_padre == $codigo_padre_catacion) {
				$sw = 1;
			}
		}

		if ($sw == 0) {

			$padredescriptor = Descriptor::where('codigo', '=', substr($descriptor->codigo, 0, 2))->first();
			$listadescriptorprioridad = Muestradescriptor::where('muestra_id', '=', $muestra_id)
				->where('descriptor_id', '=', $padredescriptor->id)
				->first();

			$listadescriptorprioridad->activo = 0;
			$listadescriptorprioridad->prioridad = 0;
			$listadescriptorprioridad->fecha_mod = date("Ymd h:i:s");
			$listadescriptorprioridad->usuario_mod = Session::get('usuario')->usuario_solomon_id;
			$listadescriptorprioridad->save();

		}

		$listamuestradescriptores = Muestradescriptor::where('muestra_id', '=', $muestra_id)->where('activo', '=', '1')
			->orderBy('prioridad', 'asc')->get();

		foreach ($listamuestradescriptores as $key => $item) {
			$item->activo = 1;
			$item->prioridad = $key + 1;
			$item->fecha_mod = date("Ymd h:i:s");
			$item->usuario_mod = Session::get('usuario')->usuario_solomon_id;
			$item->save();
		}

	}

	public function activar_poner_prioridad($muestra_id, $descriptor_id) {

		$descriptor = Descriptor::where('id', '=', $descriptor_id)->first();

		$padredescriptor = Descriptor::where('codigo', '=', substr($descriptor->codigo, 0, 2))->first();

		$listadescriptorprioridad = Muestradescriptor::where('muestra_id', '=', $muestra_id)
			->where('descriptor_id', '=', $padredescriptor->id)
			->where('activo', '=', '0')
			->first();

		if (count($listadescriptorprioridad) > 0) {

			$countdescriptorprioridad = Muestradescriptor::where('muestra_id', '=', $muestra_id)
				->where('activo', '=', '1')
				->select(DB::raw('(count(prioridad)+1) as count_prioridad'))
				->first();

			$listadescriptorprioridad->activo = 1;
			$listadescriptorprioridad->prioridad = $countdescriptorprioridad->count_prioridad;
			$listadescriptorprioridad->fecha_mod = date("Ymd h:i:s");
			$listadescriptorprioridad->usuario_mod = Session::get('usuario')->usuario_solomon_id;
			$listadescriptorprioridad->save();

		}

	}

	public function lista_descriptores_prioridad() {

		$listadescriptorprioridad = Descriptortipocatacion::join('descriptores as de', 'de.id', '=', 'descriptortipocataciones.descriptor_id')
			->where('de.padre', '=', '00')
			->where('descriptortipocataciones.tipocatacion_id', '=', '1CIX00000002')
			->select('de.*')
			->get();

		return $listadescriptorprioridad;

	}

	public function lista_descriptores_niveles($nivel, $tipocatacion_id, $padre) {

		$listadescriptortipocatacion = Descriptortipocatacion::join('descriptores as de', 'de.id', '=', 'descriptortipocataciones.descriptor_id')
		//->where('de.nivel', '=', $nivel)
			->where('de.padre', '=', $padre)
			->where('descriptortipocataciones.tipocatacion_id', '=', $tipocatacion_id)
			->select('de.*', 'descriptortipocataciones.id as descriptortipocatacion_id')
			->get();

		return $listadescriptortipocatacion;

	}

	public function nota_catacion($codigo, $muestra_id) {

		$notas = Catacion::where('muestra_id', '=', $muestra_id)
			->join('tipocataciones', 'tipocataciones.id', '=', 'cataciones.tipocatacion_id')
			->where('tipocataciones.codigo', '=', $codigo)
			->first()->notas;

		return $notas;

	}

	public function value_catacion($codigo, $muestra_id) {

		$value = Catacion::where('muestra_id', '=', $muestra_id)
			->join('tipocataciones', 'tipocataciones.id', '=', 'cataciones.tipocatacion_id')
			->where('tipocataciones.codigo', '=', $codigo)
			->first()->value;

		return $value;

	}

	public function data_catacion($codigo, $muestra_id) {

		$catacion = Catacion::where('muestra_id', '=', $muestra_id)
			->join('tipocataciones', 'tipocataciones.id', '=', 'cataciones.tipocatacion_id')
			->where('tipocataciones.codigo', '=', $codigo)
			->first();

		return $catacion;

	}

	public function puntaje_muestra($muestra_id) {

		$puntaje = Catacion::where('muestra_id', '=', $muestra_id)->sum('puntaje');
		$muestra = Muestra::where('id', '=', $muestra_id)->first();
		$muestra->puntaje = $puntaje;
		$muestra->save();

	}

	public function retornar_puntaje_muestra($muestra_id) {

		$puntaje = Catacion::where('muestra_id', '=', $muestra_id)->sum('puntaje');
		$muestra = Muestra::where('id', '=', $muestra_id)->first();
		$muestra->puntaje = $puntaje;
		$muestra->fecha_mod = date("Ymd h:i:s");
		$muestra->usuario_mod = Session::get('usuario')->usuario_solomon_id;
		$muestra->save();

		$this->puntaje_session_catacion($muestra->sesioncatacion_id);
		return $puntaje;
	}

	public function puntaje_session_catacion($sesioncatacion_id) {

		$listacatacion = Muestra::where('sesioncatacion_id', '=', $sesioncatacion_id)->get();
		$puntaje = 0.00;
		foreach ($listacatacion as $key => $item) {
			$puntaje = $puntaje + $item->puntaje;
		}
		$puntaje = $puntaje / (count($listacatacion));

		$sesioncatacion = Sesioncatacion::where('id', '=', $sesioncatacion_id)->first();
		$sesioncatacion->puntaje = $puntaje;
		$sesioncatacion->fecha_mod = date("Ymd h:i:s");
		$sesioncatacion->usuario_mod = Session::get('usuario')->usuario_solomon_id;
		$sesioncatacion->save();

	}

	public function puntaje_catacion_tipo($tipocatacion_id, $puntaje) {

		$ptj = 0;
		$tipocatacion = Tipocatacion::where('id', '=', $tipocatacion_id)->first();
		if ($tipocatacion->ind_sumar == 1) {
			if ($tipocatacion->operador == 0) {
				$ptj = -$puntaje;
			} else {
				$ptj = $puntaje;
			}
		}
		return $ptj;

	}

	public function count_muetras_editadas($sesioncatacion_id) {

		$count = 0;
		$listamuestras = Muestra::where('sesioncatacion_id', '=', $sesioncatacion_id)
			->where('estado_id', '<>', '1CIX00000001')->get();
		$count = count($listamuestras);
		return $count;
	}

	public function array_letras() {
		$array_letras = [
			['letra' => 'A'], ['letra' => 'B'], ['letra' => 'C'], ['letra' => 'D'], ['letra' => 'E'],
			['letra' => 'F'], ['letra' => 'G'], ['letra' => 'H'], ['letra' => 'I'], ['letra' => 'J'],
			['letra' => 'K'], ['letra' => 'L'], ['letra' => 'M'], ['letra' => 'N'], ['letra' => 'Ñ'],
			['letra' => 'O'], ['letra' => 'P'], ['letra' => 'Q'], ['letra' => 'R'], ['letra' => 'S'],
			['letra' => 'T'], ['letra' => 'U'], ['letra' => 'V'], ['letra' => 'W'], ['letra' => 'X'],
			['letra' => 'X'], ['letra' => 'Z'],
		];
		return $array_letras;
	}

	public function icono_por_codigo($codigo) {

		$array_tipo_catacion_iconos = $this->array_tipo_catacion_iconos();
		$array_key = array_search($codigo, array_column($array_tipo_catacion_iconos, 'codigo'));
		$valor = $array_tipo_catacion_iconos[$array_key]['icono'];
		return $valor;

	}

	public function array_nivel_tueste() {
		$array_nivel_tueste = [
			['color' => 'tueste-n5'], ['color' => 'tueste-n4'], ['color' => 'tueste-n3'], ['color' => 'tueste-n2'], ['color' => 'tueste-n1'],
		];
		return $array_nivel_tueste;
	}

	public function array_tipo_catacion_iconos() {
		$array_tipo_catacion_iconos = [
			['codigo' => '00000001', 'icono' => 'zmdi-grain'],
			['codigo' => '00000002', 'icono' => 'zmdi-grain'],
			['codigo' => '00000003', 'icono' => 'zmdi-coffee'],
			['codigo' => '00000004', 'icono' => 'zmdi-leak'],
			['codigo' => '00000005', 'icono' => 'zmdi-iridescent'],
			['codigo' => '00000006', 'icono' => 'zmdi-filter-center-focus'],
			['codigo' => '00000007', 'icono' => 'zmdi-power-input'],
			['codigo' => '00000008', 'icono' => 'zmdi-input-composite'],
			['codigo' => '00000009', 'icono' => 'zmdi-input-antenna'],
			['codigo' => '00000010', 'icono' => 'zmdi-star-circle'],
			['codigo' => '00000011', 'icono' => 'zmdi-view-array'],
			['codigo' => '00000012', 'icono' => 'zmdi-broken-image'],
			['codigo' => '00000013', 'icono' => 'zmdi-grain'],
		];
		return $array_tipo_catacion_iconos;
	}

}
