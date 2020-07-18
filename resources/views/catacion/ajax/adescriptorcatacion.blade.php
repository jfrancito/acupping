@foreach($listacataciondescriptores as $index=>$item)
	@if($tipocatacion_codigo == $item->catacion->tipocatacion->codigo and $item->catacion->muestra_id == $muestra_id)
		<div class='etiqueta-descriptores' data_catacion_descriptor_id="{{$item->id}}">
			<span class="label label-success nombre">{{trim($item->descriptortipocatacion->descriptor->nombre)}}</span>
			<span class="label label-danger eliminar btn_eliminar_descriptor">X</span>
		</div>
	@endif
@endforeach

