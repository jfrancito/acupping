<div class="modal-header modal-header-session">
  <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
  <h3 class="modal-title"><strong>SESION DE CATACION #{{$sessioncatacion->codigo}}</strong></h3>
  <h5 class="modal-title">Incio : {{date_format(date_create(date($sessioncatacion->fecha)), 'd-m-Y H:i:s')}}</h5>
</div>
<div class="modal-body">


  <div class="scroll_text">
  	<table class="table" style="font-size: 0.9em;">
	    <thead>
	      <tr>
	        <th>Muestra</th>
	   		@foreach($sessioncatacion->muestras as $item)
	   			<th>{{$item->alias}}</th>
	   		@endforeach
	      </tr>
	    </thead>
	    <tbody>
	   		@foreach($listatipocatacion as $itemtc)
				<tr>
					<td>{{$itemtc->nombre}}</td>
			   		@foreach($sessioncatacion->muestras as $item)
					    @php
					        $data_catacion = $funcion->catacion->data_catacion($itemtc->codigo,$item->id);
					    @endphp

			   			<td>
			   				@if($itemtc->codigo == '00000001')
								<span class="icon mdi mdi-circle tueste-circle tueste-c-n{{(int)$data_catacion->value}}"></span>
							@else
								{{$data_catacion->value}}
							@endif
			   			</td>
			   		@endforeach
				</tr>
	   		@endforeach
				<tr>
					<td>Total</td>
			   		@foreach($sessioncatacion->muestras as $item)
			   			<td><b>{{$item->puntaje}}</b></td>
			   		@endforeach
				</tr>

	    </tbody>
  	</table>
  </div>


</div>
<div class="modal-footer">

	<form method="POST"
	      action="{{ url('/cerrar-sesion-catacion') }}"
	      style="border-radius: 0px;"
	      class="form-horizontal group-border-dashed">
	  	{{ csrf_field() }}
		<input type="hidden" name="sesioncatacion" value='{{$sessioncatacion->id}}'>
		<button type="submit" data-dismiss="modal" class="btn btn-success modal-close">Guardar</button>
	</form>

</div>

