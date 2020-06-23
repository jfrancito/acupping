<div  class="panel panel-border panel-contrast padre_seccion"
      data_muestra_id = '{{$muestra->id}}'
      data_codigo = '00000013'>
  <div class="panel-heading panel-heading-contrast"><b>Notas</b>

  </div>

  <div class="panel-body panel-indicadores">

    <div class='col-xs-12'>
      <div class="form-group">
          <div class="col-xs-12 input-group xs-mb-15">

           <textarea id="notas" class="form-control input-sm" rows="4">{{$funcion->catacion->nota_catacion('00000013',$muestra->id)}}</textarea>

            <span class="input-group-btn">
                  <button id="asignarnota" type="button" class="btn btn-primary ">
                    <font><i class="mdi mdi-refresh"></i></font>
                  </button>
            </span>

          </div>
      </div>



    </div>
  </div>
</div>