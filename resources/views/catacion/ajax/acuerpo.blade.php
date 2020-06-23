<div  class="panel panel-border panel-contrast padre_seccion"
      data_muestra_id = '{{$muestra->id}}'
      data_codigo = '00000006'>
  <div class="panel-heading panel-heading-contrast"><b>Cuerpo</b>
  <div class="tools">
    <span class="badge puntaje">{{$funcion->catacion->value_catacion('00000006',$muestra->id)}}</span>
  </div>
  </div>
  <div class="panel-body panel-indicadores">

    <div class='col-xs-3'>
      <div class="slider00000006 slidercatacion"></div>
    </div>
    <div class='col-xs-9'>
      <ol class="breadcrumb">
        <li class="active selectdescriptores">
          Descriptores <i class="icon icon-right mdi mdi-eye"></i>
        </li>
      </ol>
    </div>


  </div>

  <div class="panel-body panel-descriptores">
    <div class='col-xs-12'>
      descriptores
    </div>
  </div>
</div>