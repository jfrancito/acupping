<?php
namespace App\Biblioteca;
use App\Catacion;
use App\Descriptortipocatacion;
use App\Muestra;
use App\Tipocatacion;

class Cataciones {

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
		$muestra->save();
		return $puntaje;
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

	public function array_nivel_tueste() {
		$array_nivel_tueste = [
			['color' => 'tueste-n5'], ['color' => 'tueste-n4'], ['color' => 'tueste-n3'], ['color' => 'tueste-n2'], ['color' => 'tueste-n1'],
		];
		return $array_nivel_tueste;
	}

}
