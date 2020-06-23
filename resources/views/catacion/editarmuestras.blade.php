@extends('template')
@section('style')

    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>


@stop
@section('section')


<div class="be-content catacion">
  <div class="main-content container-fluid">
    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider" >SESION DE CATACION #{{$sessioncatacion->codigo}}
              <span class="panel-subtitle">Incio : {{date_format(date_create(date($sessioncatacion->fecha)), 'd-m-Y H:i:s')}}</span>
          </div>
          <div class="panel-body">

            <div class="panel panel-default">
              <div class="tab-container">
                <ul class="nav nav-tabs">
                  @foreach($listamuestas as $index=>$item)
                    <li class="@if($item->id == $muestra->id) active @endif tabmuestra"
                        data_alias='{{$item->alias}}'
                        data_opcion='{{$idopcion}}'
                        data_muestra='{{$item->id}}'>
                      <a href="#{{$item->alias}}" data-toggle="tab">{{$item->alias}}</a>
                    </li>
                  @endforeach
                </ul>
                <div class="tab-content">

                  @foreach($listamuestas as $index=>$item)
                  <div id="{{$item->alias}}" class="tab-pane @if($item->id == $muestra->id) active @endif cont cont{{$item->alias}}">
                    @if($item->id == $muestra->id)
                        @include('catacion.form.formmuestra')
                    @endif
                  </div>
                  @endforeach
                </div>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>


  </div>
</div>



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

  <script type="text/javascript">
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

    });
  </script>

  <script src="{{ asset('public/js/catacion/catacion.js?v='.$version) }}" type="text/javascript"></script>
@stop