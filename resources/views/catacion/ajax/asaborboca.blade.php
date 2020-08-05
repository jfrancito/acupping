<div  class="panel panel-border panel-contrast padre_seccion"
      data_muestra_id = '{{$muestra->id}}'
      data_codigo = '00000004'>
  <div class="panel-heading panel-heading-contrast"><b>Sabor de boca</b>
  <div class="tools">
    <span class="badge puntaje">{{$funcion->catacion->value_catacion('00000004',$muestra->id)}}</span>
  </div>
  </div>


  <div class="panel-body panel-indicadores">

    <div class='col-xs-3'>
      <div class="slider00000004 slidercatacion"></div>
    </div>
    <div class='col-xs-9'>
      @if(!isset($revisar))
      <ol class="breadcrumb">
        <li class="active selectdescriptores">
          Descriptores <i class="icon icon-right mdi mdi-eye"></i>
        </li>
      </ol>
      <div class='ajax_lista_descriptores_00000004'>
        @include('catacion.ajax.adescriptorcatacion', ['tipocatacion_codigo' => '00000004'])
      </div>
      @endif
    </div>
  </div>


  <div class="panel-body panel-descriptores">
    <div class='col-xs-12'>
      <div class='ajax-descriptores'>


      </div>
    </div>
  </div>



</div>