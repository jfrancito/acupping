<div  class="panel panel-border panel-contrast padre_seccion"
      data_muestra_id = '{{$muestra->id}}'
      data_codigo = '00000002'>
  <div class="panel-heading panel-heading-contrast"><b>Fragancia / Aroma</b>
  <div class="tools">
    <span class="badge puntaje">{{$funcion->catacion->value_catacion('00000002',$muestra->id)}}</span>
  </div>
  </div>

  <div class="panel-body panel-indicadores">

    <div class='col-xs-3'>
      <div class="slider00000002 slidercatacion"></div>
    </div>
    <div class='col-xs-9'>
      <ol class="breadcrumb">
        <li class="active selectdescriptores">
          Descriptores <i class="icon icon-right mdi mdi-eye"></i>
        </li>
      </ol>
      <div class='ajax_lista_descriptores_00000002'>
        @include('catacion.ajax.adescriptorcatacion', ['tipocatacion_codigo' => '00000002'])
      </div>
    </div>


  </div>

  <div class="panel-body panel-descriptores">
    <div class='col-xs-12'>
      <div class='ajax-descriptores'>


      </div>
    </div>
  </div>

</div>