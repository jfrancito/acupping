
<div class="panel panel-default panel-table informacion_muestra">
	<div class="panel-heading">

	  <div class="title">
		<p><b>Productor : </b>{{$muestra->productor}}</p>
		<p><b>Tipo de muestra : </b> {{$muestra->tipomuestra->nombre}}</p>
		<p><b>Descripción del producto  : </b>{{$muestra->producto->nombre}}</p>
		<p><b>Calificación promedio : </b>{{$muestra->puntaje}}</p>
	  </div>

      <div class="tools tooltiptop">


        <a href="#" class="tooltipcss opciones editar-catacion">
          <span class="tooltiptext">Editar Resultado</span>
          <span class="icon mdi mdi-comment-edit"></span>
        </a>

        <a href="{{ url('/ver-reporte-muestra/'.$muestra->id.'/'.$idopcion) }}" class="tooltipcss opciones">
          <span class="tooltiptext">Ver reporte</span>
          <span class="icon mdi mdi-chart"></span>
        </a>

      </div>
    </div>
</div>


<table class="table" style="font-size: 1em;">
<thead>
  <tr>
    <th>Muestra</th>
	<th>Puntaje</th>
  </tr>
</thead>
<tbody>
		@foreach($listatipocatacion as $itemtc)
		<tr>
			<td>{{$itemtc->nombre}}</td>
		    @php
		        $data_catacion = $funcion->catacion->data_catacion($itemtc->codigo,$muestra->id);
		    @endphp
   			<td>
   				@if($itemtc->codigo == '00000001')
					<span class="icon mdi mdi-circle tueste-circle tueste-c-n{{(int)$data_catacion->value}}"></span>
				@else
   					@if($itemtc->codigo == '00000013')
						{{$data_catacion->notas}}
					@else
						{{$data_catacion->value}}
					@endif
				@endif
   			</td>
		</tr>
		@endforeach
</tbody>
</table>