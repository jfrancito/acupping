<div class="form-group">
  <label class="col-sm-3 control-label">Fecha y hora :</label>
  <div class="col-sm-6">

    <div  data-start-view="2"
          data-date="1979-09-16T05:25:07Z"
          data-date-format="dd-mm-yyyy HH:ii:ss"
          data-link-field="dtp_input1"
          class="input-group date datetimepicker">
          <input  size="16"
                  type="text"
                  required = ""
                  id = "fecha"
                  name = "fecha"
                  value="@if(isset($sesioncatacion)){{old('fecha',date_format(date_create(date($sesioncatacion->fecha)), 'd-m-Y H:i:s'))}}@else{{old('fecha',$fecha)}}@endif"
                  class="form-control input-sm">
          <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
    </div>

  </div>
</div>




<div class="form-group">

  <label class="col-sm-3 control-label">Lugar :</label>
  <div class="col-sm-6">
    {!! Form::select( 'lugar_id', $combo_lugares, array($sesioncatacion_lugar_id),
                      [
                        'class'       => 'form-control control input-sm' ,
                        'id'          => 'lugar_id',
                        'required'    => ''
                      ]) !!}
  </div>
</div>





@if(!isset($sesioncatacion))

  <div class="form-group">
    <label class="col-sm-3 control-label">Número de muestras :</label>
    <div class="col-sm-6">

        <input  type="number"
                id="numeros_muestra"
                name='numeros_muestra'
                value="@if(isset($sesioncatacion)){{old('numeros_muestra',$sesioncatacion->numeros_muestra)}}@else{{old('numeros_muestra',1)}}@endif"
                required = ""
                autocomplete="off"
                maxlength="300"
                class="form-control input-sm"/>

    </div>
  </div>

@endif

<div class="form-group">
  <label class="col-sm-3 control-label">Invitar a:</label>
  <div class="col-sm-6">


    {!! Form::select( 'invitarusuarios[]', $combo_usuarios, $array_usuarios,
                      [
                        'class'       => 'select2 form-control control input-sm' ,
                        'id'          => 'invitarusuarios',
                        'required'    => '',
                        'multiple'    => 'multiple',
                        'data-aw'     => '1',
                      ]) !!}

  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Descripción :</label>
  <div class="col-sm-6">

      <input  type="text"
              id="descripcion"
              name='descripcion'
              value="@if(isset($sesioncatacion)){{old('descripcion',$sesioncatacion->descripcion)}}@else{{old('descripcion','')}}@endif"
              placeholder="Descripcion"
              autocomplete="off"
              maxlength="500"
              class="form-control input-sm"/>

  </div>
</div>



<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">

      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
      <button type="submit" class="btn btn-space btn-primary">Guardar</button>
    </p>
  </div>
</div>