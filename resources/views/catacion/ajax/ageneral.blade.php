<div  class="panel panel-border panel-contrast padre_seccion"
      data_muestra_id = '{{$muestra->id}}'
      data_codigo = '00000008'>
  <div class="panel-heading panel-heading-contrast"><b>General</b>
  <div class="tools">
    <span class="badge puntaje">{{$funcion->catacion->value_catacion('00000008',$muestra->id)}}</span>
  </div>
  </div>
  <div class="panel-body panel-indicadores">

    <div class='col-md-3'>
      <div class="slider00000008 slidercatacion"></div>
    </div>

  </div>


</div>