<div  class="panel panel-border panel-contrast padre_seccion"
      data_muestra_id = '{{$muestra->id}}'
      data_codigo = '00000002'>
  <div class="panel-heading panel-heading-contrast panel-heading-prioridad"><b>Prioridad descriptores</b>
  <div class="tools">
  </div>
  </div>
  <div class="panel-body">
    <div class="form-group">
      <div class="col-sm-12 ajax_descriptores_muestra">
        @include('catacion.ajax.adescriptormuestras')
      </div>
    </div>
  </div>
</div>