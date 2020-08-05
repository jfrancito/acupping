<?php
namespace App\Biblioteca;
use App\Catacion;
use App\Cataciondescriptor;
use App\Descriptor;
use App\Descriptortipocatacion;
use App\Muestra;
use App\Muestradescriptor;
use App\Sesioncatacion;
use App\Tipocatacion;
use DB;
use Session;

class Cataciones {

	public function array_padres($array_listacatacion) {

		$array_cataciondescriptores = Cataciondescriptor::join('descriptortipocataciones', 'cataciondescriptores.descriptortipocatacion_id', '=', 'descriptortipocataciones.id')
			->wherein('catacion_id', $array_listacatacion)->where('cataciondescriptores.activo', '=', '1')
			->select('descriptortipocataciones.descriptor_id')
			->groupBy('descriptortipocataciones.descriptor_id')
			->get();

		$listaid = array();
		$i = 0;

		foreach ($array_cataciondescriptores as $key => $item) {

			$descriptor = Descriptor::where('id', '=', $item->descriptor_id)->first();
			//nivel 1
			$nivel1 = Descriptor::where('codigo', '=', $descriptor->padre)->first();
			if (count($nivel1) > 0) {
				$listaid[$i] = $nivel1->id;
				$i = $i + 1;

				$nivel2 = Descriptor::where('codigo', '=', $nivel1->padre)->first();
				if (count($nivel2) > 0) {
					$listaid[$i] = $nivel2->id;
					$i = $i + 1;
					$nivel3 = Descriptor::where('codigo', '=', $nivel2->padre)->first();

					if (count($nivel3) > 0) {
						$listaid[$i] = $nivel3->id;
						$i = $i + 1;
					}
				}
			}
		}

		return $listaid;

	}
	public function data_rueda_sabores($muestra_id) {
		$muestra = Muestra::where('id', '=', $muestra_id)->first();

		$array_listacatacion = Catacion::where('muestra_id', '=', $muestra_id)->pluck('id')->toArray();

		$array_padres = $this->array_padres($array_listacatacion);

		$array_cataciondescriptores_tipo = Cataciondescriptor::join('descriptortipocataciones', 'cataciondescriptores.descriptortipocatacion_id', '=', 'descriptortipocataciones.id')
			->wherein('catacion_id', $array_listacatacion)->where('cataciondescriptores.activo', '=', '1')
			->select('descriptortipocataciones.descriptor_id')
			->groupBy('descriptortipocataciones.descriptor_id')
			->pluck('descriptortipocataciones.descriptor_id')->toArray();

		$array_cataciondescriptores = Descriptor::wherein('id', $array_cataciondescriptores_tipo)
			->orwherein('id', $array_padres)
			->select('id')
			->groupBy('id')
			->pluck('id')->toArray();

		//dd($array_cataciondescriptores);

		$lista_descriptores_nivel_1 = Descriptor::wherein('id', $array_cataciondescriptores)->where('nivel', '=', '1')->get();
		$array_padre = array("name" => "Acupping", "color" => "#ffffff");

		$array_padre1 = array();

		foreach ($lista_descriptores_nivel_1 as $key => $item) {

			$valor_torta = $this->valor_torta($item, $array_cataciondescriptores, count($lista_descriptores_nivel_1));

			if ($valor_torta <= 0) {
				$array_1 = array("name" => $item->nombre, "color" => "#bdbdbd");
			} else {
				$array_1 = array("name" => $item->nombre, "size" => $valor_torta, "color" => "#bdbdbd");
			}

			//nivel 2
			$lista_descriptores_nivel_2 = Descriptor::wherein('id', $array_cataciondescriptores)
				->where('padre', '=', $item->codigo)->where('nivel', '=', '2')->get();
			$array_padre2 = array();
			if (count($lista_descriptores_nivel_2)) {
				foreach ($lista_descriptores_nivel_2 as $key2 => $item2) {

					$valor_torta = $this->valor_torta($item2, $array_cataciondescriptores, count($lista_descriptores_nivel_1));

					if ($valor_torta <= 0) {
						$array_2 = array("name" => $item2->nombre, "color" => "#bdbdbd");
					} else {
						$array_2 = array("name" => $item2->nombre, "size" => $valor_torta, "color" => "#bdbdbd");
					}

					//nivel 3
					$lista_descriptores_nivel_3 = Descriptor::wherein('id', $array_cataciondescriptores)
						->where('padre', '=', $item2->codigo)->where('nivel', '=', '3')->get();
					$array_padre3 = array();

					if (count($lista_descriptores_nivel_3)) {
						foreach ($lista_descriptores_nivel_3 as $key3 => $item3) {

							$valor_torta = $this->valor_torta($item3, $array_cataciondescriptores, count($lista_descriptores_nivel_1));

							if ($valor_torta <= 0) {
								$array_3 = array("name" => $item3->nombre, "color" => "#bdbdbd");
							} else {
								$array_3 = array("name" => $item3->nombre, "size" => $valor_torta, "color" => "#bdbdbd");
							}

							//nivel 4
							$lista_descriptores_nivel_4 = Descriptor::wherein('id', $array_cataciondescriptores)
								->where('padre', '=', $item3->codigo)->where('nivel', '=', '4')->get();
							$array_padre4 = array();

							if (count($lista_descriptores_nivel_4)) {

								foreach ($lista_descriptores_nivel_4 as $key4 => $item4) {

									$valor_torta = $this->valor_torta($item4, $array_cataciondescriptores, count($lista_descriptores_nivel_1));

									if ($valor_torta <= 0) {
										$array_4 = array("name" => $item4->nombre, "color" => "#bdbdbd");
									} else {
										$array_4 = array("name" => $item4->nombre, "size" => $valor_torta, "color" => "#bdbdbd");
									}

									array_push($array_padre4, $array_4);
								}
								$array_3 = $array_3 + array("children" => $array_padre4);

							}
							//nivel 4

							array_push($array_padre3, $array_3);
						}
						$array_2 = $array_2 + array("children" => $array_padre3);
					}
					//nivel 3

					array_push($array_padre2, $array_2);
				}
				$array_1 = $array_1 + array("children" => $array_padre2);
			}
			//nivel 2

			array_push($array_padre1, $array_1);

		}

		$array_padre = $array_padre + array("children" => $array_padre1);

		return json_encode($array_padre, false);

	}
	public function quitar_numeros_json($data_rueda_sabores) {

		for ($i = 0; $i < 10; $i++) {
			$data_rueda_sabores = str_replace("children" . $i, "children", $data_rueda_sabores);
		}
		return $data_rueda_sabores;
	}

	public function valor_torta($descriptor, $array_cataciondescriptores, $counttorta) {

		$lista_descriptores = Descriptor::wherein('id', $array_cataciondescriptores)->where('padre', '=', $descriptor->codigo)->get();
		if (count($lista_descriptores) > 0) {
			$valor = 0;
		} else {
			$lista_descriptores_acabo = Descriptor::wherein('id', $array_cataciondescriptores)->where('padre', '=', $descriptor->padre)->get();
			$valor = 100 / $counttorta / count($lista_descriptores_acabo);
		}

		return $valor;
	}

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
