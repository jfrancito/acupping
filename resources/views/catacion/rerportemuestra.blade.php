@extends('template')
@section('style')

    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/slider-barras/css/slider.css') }} "/>

@stop
@section('section')


<div class="be-content catacion">
  <div class="main-content container-fluid">
    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider" >Muestra #{{$muestra->alias}} - {{$muestra->codigo}}
          </div>

          <div class="panel-body">
            <div class="panel panel-default">

          @if(count($array_cataciondescriptores_tipo)>0)
		      <div class="col-md-12">

					  <div id="chart"></div>

		      </div>
          @endif
		      <div class="col-md-12">
					<table class="table tabla-reporte" style="font-size: 1em;">
						<tbody>
								<tr>
									<td class='center sin-border-top'><i class = "zmdi zmdi-accounts zmdi-hc-2x"> </i></td>
									<td class='center sin-border-top'><b>Número de catadores</b></td>
									<td class='center sin-border-top'><span class="label label-success">1</span></td>
								</tr>
								<tr>
									<td class='center'><i class = "zmdi zmdi-chart zmdi-hc-2x"> </i></td>
									<td class='center'><b>Calificación promedio</b></td>
									<td class='center'><span class="label label-success">{{$muestra->puntaje}}</span></td>
								</tr>
								<tr>
									<td class='center'><i class = "zmdi zmdi-group zmdi-hc-2x"> </i></td>
									<td class='center'><b>Rango de calificación</b></td>
									<td class='center'><span class="label label-success">{{$muestra->puntaje}} - {{$muestra->puntaje}}</span></td>
								</tr>

								@foreach($listatipocatacion as $itemtc)
								<tr>
								    @php
								        $data_catacion = $funcion->catacion->data_catacion($itemtc->codigo,$muestra->id);
								        $icono = $funcion->catacion->icono_por_codigo($itemtc->codigo);
								    @endphp

									<td class='center'><i class = "zmdi {{$icono}} zmdi-hc-2x"> </i></td>
									<td class='center'><b>{{$itemtc->nombre}}</b></td>
						   			<td class='center'>
						   				@if($itemtc->codigo == '00000001')
											<span class="icon mdi mdi-circle tueste-circle tueste-c-n{{(int)$data_catacion->value}}"></span>
										@else
						   					@if($itemtc->codigo == '00000012')
												<span class="label label-danger">{{$data_catacion->value}}</span>
											@else
												<span class="label label-success">{{$data_catacion->value}}</span>
											@endif
										@endif
						   			</td>
								</tr>
								@endforeach
						</tbody>
					</table>
		      </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" name="data" id = "data" value='{{$data}}'>

  </div>
</div>

@include('catacion.modal.dettallesessioncatacion')

@stop
@section('script')

  <script src="{{ asset('public/js/general/inputmask/inputmask.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/js/general/inputmask/inputmask.extensions.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/js/general/inputmask/inputmask.numeric.extensions.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/js/general/inputmask/inputmask.date.extensions.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/js/general/inputmask/jquery.inputmask.js') }}" type="text/javascript"></script>

  <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/slider-barras/js/slider.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/js/general/navAccordion.js?v='.$version) }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}" type="text/javascript"></script>
  <script src="{{ asset('public/lib/chart/js/chart.js') }}" type="text/javascript"></script>

  <script type="text/javascript">

    $.fn.niftyModal('setDefaults',{
      overlaySelector: '.modal-overlay',
      closeSelector: '.modal-close',
      classAddAfterOpen: 'modal-show',
    });

    $(document).ready(function(){
      //initialize the javascript
      App.init();
      App.formElements();
      $('form').parsley();

      $('.numeroentero').inputmask({
        'alias': 'numeric',
        'groupSeparator': ',',
        'autoGroup': true,
        'digits': 0,
        'digitsOptional': false,
        'prefix': '',
        'placeholder': '0'
      });

      var obj = $.parseJSON($('#data').val());
      const data = obj;

      Sunburst()
        .data(data)
        .size('size')
        .color('color')
        .radiusScaleExponent(0.7)
        (document.getElementById('chart'));


    });






  </script>

  <script src="{{ asset('public/js/catacion/catacion.js?v='.$version) }}" type="text/javascript"></script>
@stop