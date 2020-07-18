<div  class="panel panel-border panel-contrast padre_seccion"
      data_muestra_id = '{{$muestra->id}}'
      data_codigo = '00000012'>
      @php
        $value = $funcion->catacion->value_catacion('00000012',$muestra->id)
      @endphp
  <div class="panel-heading panel-heading-contrast"><b>Defectos</b>
    <div class="tools">
      <span class="badge puntaje">{{number_format($value, 2, '.', ',')}}</span>
    </div>
  </div>

  <div class="panel-body panel-indicadores">

    <div class='col-xs-12'>
      <div class="form-group">
        <label class="col-sm-3 control-label">Defecto :</label>
        <div class="col-sm-6 input-group xs-mb-15">
            <input  type="number"
                    id="defecto"
                    name='defecto'
                    value="{{number_format($value, 0, '.', ',')*-1}}"
                    required = ""
                    autocomplete="off"
                    maxlength="300"
                    class="form-control input-sm"/>

            <span class="input-group-btn">
                  <button id="asignardefectos" type="button" class="btn btn-primary ">
                    <font><i class="mdi mdi-refresh"></i></font>
                  </button>
            </span>
        </div>
      </div>
    </div>

    <div class='col-xs-12'>
      <ol class="breadcrumb">
        <li class="active selectdescriptores">
          Descriptores <i class="icon icon-right mdi mdi-eye"></i>
        </li>
      </ol>
      <div class='ajax_lista_descriptores_00000012'>
        @include('catacion.ajax.adescriptorcatacion', ['tipocatacion_codigo' => '00000012'])
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