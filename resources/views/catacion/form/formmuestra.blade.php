
<form method="POST" action="{{ url('/update-muestras/'.$idopcion.'/'.Hashids::encode(substr($muestra->id, -8))) }}"
      style="border-radius: 0px;"
      class="form-horizontal group-border-dashed">
  {{ csrf_field() }}


  <div class="col-md-12">
          <div class="panel-heading" ><b>Muestra #{{$muestra->alias}} ({{$muestra->codigo}})</b>
          </div>
  </div>
  <div class="col-md-6">

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
      <label class="col-sm-3 control-label">Descripción del producto :</label>
      <div class="col-sm-6">
        {!! Form::select( 'producto_id', $combo_productos, array($muestra->producto_id),
                          [
                            'class'       => 'form-control control input-sm' ,
                            'id'          => 'producto_id',
                            'required'    => ''
                          ]) !!}
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Marca del producto :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="marcaproducto"
                  name='marcaproducto'
                  value="@if(isset($muestra)){{old('marcaproducto',$muestra->marcaproducto)}}@else{{old('marcaproducto','')}}@endif"
                  placeholder="Marca del producto"
                  autocomplete="off"
                  maxlength="1000"
                  class="form-control input-sm"/>

      </div>
    </div>


    <div class="form-group">
      <label class="col-sm-3 control-label">Nombre Comercial :</label>
      <div class="col-sm-6">
        {!! Form::select( 'nombrecomercial_id', $combo_nombrecomerciales, array($muestra->nombrecomercial_id),
                          [
                            'class'       => 'form-control control input-sm' ,
                            'id'          => 'nombrecomercial_id',
                            'required'    => ''
                          ]) !!}
      </div>
    </div>




    <div class="form-group">
      <label class="col-sm-3 control-label">Nota :</label>
      <div class="col-sm-6">

          <input  type="text"
                  id="nota"
                  name='nota'
                  value="@if(isset($muestra)){{old('nombre',$muestra->nota)}}@else{{old('nota','')}}@endif"
                  placeholder="Nota"
                  autocomplete="off"
                  maxlength="1000"
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



    <div class='ajax_varietales'>

      <div class="form-group">
        <label class="col-sm-3 control-label">Varietales :</label>
        <div class="col-sm-6">
          {!! Form::select( 'varietal_id', $combo_varietales_especies, array($muestra->varietal_id),
                            [
                              'class'       => 'form-control control input-sm' ,
                              'id'          => 'varietal_id',
                              'required'    => ''
                            ]) !!}
        </div>
      </div>

    </div>






  </div>

  <div class="col-md-6">


    <div class="form-group">
      <label class="col-sm-3 control-label">Colores :</label>
      <div class="col-sm-6">
        {!! Form::select( 'color_id', $combo_colores, array($muestra->color_id),
                          [
                            'class'       => 'form-control control input-sm' ,
                            'id'          => 'color_id',
                            'required'    => ''
                          ]) !!}
      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Humedad :</label>
      <div class="col-sm-6">

          <input  type="number"
                  id="humedad"
                  name='humedad'
                  value="@if(isset($muestra)){{old('humedad',$muestra->humedad)}}@else{{old('humedad',0)}}@endif"
                  required = ""
                  step="0.1" min="9.0" max="12.0"
                  autocomplete="off"
                  class="form-control input-sm"/>

      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Densidad :</label>
      <div class="col-sm-6">

          <input  type="number"
                  id="densidad"
                  name='densidad'
                  value="@if(isset($muestra)){{old('densidad',$muestra->densidad)}}@else{{old('densidad',0)}}@endif"
                  required = ""
                  autocomplete="off"
                  step="1" min="300" max="999"
                  class="form-control input-sm"/>

      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Actividad de agua :</label>
      <div class="col-sm-6">

          <input  type="number"
                  id="actividadagua"
                  name='actividadagua'
                  value="@if(isset($muestra)){{old('actividadagua',$muestra->actividadagua)}}@else{{old('actividadagua',0)}}@endif"
                  required = ""
                  step="0.01" min="0.45" max="0.65"
                  autocomplete="off"
                  maxlength="300"
                  class="form-control input-sm"/>

      </div>
    </div>

    <div class="form-group">
      <label class="col-sm-3 control-label">Tipo proceso :</label>
      <div class="col-sm-6">
        {!! Form::select( 'tipoproceso_id', $combo_tipoprocesos, array($muestra->tipoproceso_id),
                          [
                            'class'       => 'form-control control input-sm' ,
                            'id'          => 'tipoproceso_id',
                            'required'    => ''
                          ]) !!}
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



