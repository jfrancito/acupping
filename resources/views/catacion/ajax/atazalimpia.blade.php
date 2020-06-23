<div  class="panel panel-border panel-contrast padre_seccion">
  <div class="panel-heading panel-heading-contrast"><b>Taza limpia</b>
  <div class="tools">
    <span class="badge puntaje">{{$funcion->catacion->value_catacion('00000010',$muestra->id)}}</span>
  </div>
  </div>
  <div class="panel-body">
    <div class="form-group checkcoffee">
      <div class="col-sm-12">
        @for ($i = 0; $i < 5; $i++)
          @php
            $puntaje = $funcion->catacion->value_catacion('00000010',$muestra->id);
            $checked = '';
            $calculo = $puntaje/($i+1);
          @endphp
          @if($calculo>=2)
            @php $checked = 'checked'; @endphp
          @endif
          <div class="be-checkbox be-checkbox-color inline">
            <input id="tazalimpia{{$i}}" type="checkbox" name="tazalimpia" class='input_tazalimpia' {{$checked}}>
            <label  for="tazalimpia{{$i}}"
                    class='checktazitas'
                    data_muestra_id = '{{$muestra->id}}'
                    data_codigo = '00000010'
                    data_value = '{{$puntaje}}'
                    ></label>
            <i class="icon icon-left mdi mdi-coffee"></i>
          </div>
        @endfor
      </div>
    </div>
  </div>
</div>