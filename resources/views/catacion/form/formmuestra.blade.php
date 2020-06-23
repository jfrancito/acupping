
<form method="POST" action="{{ url('/update-muestras/'.$idopcion.'/'.Hashids::encode(substr($muestra->id, -8))) }}"
      style="border-radius: 0px;"
      class="form-horizontal group-border-dashed">
  {{ csrf_field() }}

  <div class="col-md-12">
          <div class="panel-heading" ><b>Muestra #{{$muestra->alias}}</b>
          </div>
  </div>
  <div class="col-md-6">

    <div class="form-group">
      <label class="col-sm-3 control-label">Nombre :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="nombre"
                  name='nombre'
                  value="@if(isset($muestra)){{old('nombre',$muestra->nombre)}}@else{{old('nombre','')}}@endif"
                  placeholder="Nombre"
                  autocomplete="off"
                  maxlength="500"
                  class="form-control input-sm"/>

      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Tipo de muestra :</label>
      <div class="col-sm-6">
        {!! Form::select( 'tipomuestra_id', $combo_tipomuestras, array($muestra->tipomuestra_id),
                          [
                            'class'       => 'form-control control input-sm' ,
                            'id'          => 'tipomuestra_id',
                            'required'    => ''
                          ]) !!}
      </div>
    </div>


    <div class="form-group">
      <label class="col-sm-3 control-label">Descripcion :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="descripcion"
                  name='descripcion'
                  value="@if(isset($muestra)){{old('descripcion',$muestra->descripcion)}}@else{{old('descripcion','')}}@endif"
                  placeholder="Descripcion"
                  autocomplete="off"
                  maxlength="500"
                  class="form-control input-sm"/>

      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Numero de referencia :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="numeroreferencia"
                  name='numeroreferencia'
                  value="@if(isset($muestra)){{old('numeroreferencia',$muestra->numeroreferencia)}}@else{{old('numeroreferencia','')}}@endif"
                  placeholder="Numero de referencia"
                  autocomplete="off"
                  maxlength="500"
                  class="form-control input-sm"/>

      </div>
    </div>


    <div class="form-group">
      <label class="col-sm-3 control-label">Identificar externo :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="identificadorexterno"
                  name='identificadorexterno'
                  value="@if(isset($muestra)){{old('identificadorexterno',$muestra->identificadorexterno)}}@else{{old('identificadorexterno','')}}@endif"
                  placeholder="Identificar externo"
                  autocomplete="off"
                  maxlength="500"
                  class="form-control input-sm"/>

      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Especie :</label>
      <div class="col-sm-6">
        {!! Form::select( 'especie_id', $combo_especies, array($muestra->especie_id),
                          [
                            'class'       => 'form-control control input-sm' ,
                            'id'          => 'especie_id',
                            'required'    => ''
                          ]) !!}
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Humedad :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="humedad"
                  name='humedad'
                  value="@if(isset($muestra)){{old('humedad',$muestra->humedad)}}@else{{old('humedad',0)}}@endif"
                  required = ""
                  autocomplete="off"
                  maxlength="300"
                  class="form-control input-sm numeroentero"/>

      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Densidad :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="densidad"
                  name='densidad'
                  value="@if(isset($muestra)){{old('densidad',$muestra->densidad)}}@else{{old('densidad',0)}}@endif"
                  required = ""
                  autocomplete="off"
                  maxlength="300"
                  class="form-control input-sm numeroentero"/>

      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Actividad de agua :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="actividadagua"
                  name='actividadagua'
                  value="@if(isset($muestra)){{old('actividadagua',$muestra->actividadagua)}}@else{{old('actividadagua',0)}}@endif"
                  required = ""
                  autocomplete="off"
                  maxlength="300"
                  class="form-control input-sm numeroentero"/>

      </div>
    </div>
  </div>

  <div class="col-md-6">
    <div class="form-group">
      <label class="col-sm-3 control-label">Varietales :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="varietales"
                  name='varietales'
                  value="@if(isset($varietales)){{old('varietales',$varietales->varietales)}}@else{{old('varietales','')}}@endif"
                  placeholder="Varietales"
                  autocomplete="off"
                  maxlength="500"
                  class="form-control input-sm"/>

      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Año cosecha :</label>
      <div class="col-sm-6">
        {!! Form::select( 'aniocosecha_id', $combo_aniocosechas, array($muestra->aniocosecha_id),
                          [
                            'class'       => 'form-control control input-sm' ,
                            'id'          => 'aniocosecha_id',
                            'required'    => ''
                          ]) !!}
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Proceso :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="proceso"
                  name='proceso'
                  value="@if(isset($muestra)){{old('proceso',$muestra->proceso)}}@else{{old('proceso','')}}@endif"
                  placeholder="Proceso"
                  autocomplete="off"
                  maxlength="500"
                  class="form-control input-sm"/>

      </div>
    </div>


    <div class="form-group">
      <label class="col-sm-3 control-label">País :</label>
      <div class="col-sm-6">
        {!! Form::select( 'pais_id', $combo_paises, array($muestra->pais_id),
                          [
                            'class'       => 'form-control control input-sm' ,
                            'id'          => 'pais_id',
                            'required'    => ''
                          ]) !!}
      </div>
    </div>


    <div class="form-group">
      <label class="col-sm-3 control-label">Region :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="region"
                  name='region'
                  value="@if(isset($muestra)){{old('region',$muestra->region)}}@else{{old('region','')}}@endif"
                  placeholder="Region"
                  autocomplete="off"
                  maxlength="500"
                  class="form-control input-sm"/>

      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Productor :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="productor"
                  name='productor'
                  value="@if(isset($muestra)){{old('productor',$muestra->productor)}}@else{{old('productor','')}}@endif"
                  placeholder="Productor"
                  autocomplete="off"
                  maxlength="500"
                  class="form-control input-sm"/>

      </div>
    </div>


    <div class="form-group">
      <label class="col-sm-3 control-label">Proveedor :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="proveedor"
                  name='proveedor'
                  value="@if(isset($muestra)){{old('proveedor',$muestra->proveedor)}}@else{{old('proveedor','')}}@endif"
                  placeholder="Proveedor"
                  autocomplete="off"
                  maxlength="500"
                  class="form-control input-sm"/>

      </div>
    </div>
  </div>

  <div class="col-md-12">

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
  </div>

</form>



