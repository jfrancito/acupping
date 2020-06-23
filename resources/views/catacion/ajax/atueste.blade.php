<div class="panel panel-border panel-contrast">
  <div class="panel-heading panel-heading-contrast"><b>Nivel de tueste</b></div>
  <div class="panel-body">
    <div class="xs-mt-20 xs-mb-10">
      <div class="btn-toolbar">
        <div role="group" class="btn-group-vertical btn-space">
            @foreach($array_nivel_tueste as $index=>$item)
              <div  class="tueste {{$item['color']}} btntueste"
                    data_muestra_id = '{{$muestra->id}}'
                    data_value = '{{$index+1}}'
                    data_codigo = '00000001'>
                <div class="tools">
                  <span class="badge">@if($index+1 == $funcion->catacion->value_catacion('00000001',$muestra->id))
                  <i class="icon icon-left mdi mdi-check"></i>
                  @endif</span>
                </div>
              </div>
            @endforeach
          </div>
      </div>
    </div>
  </div>
</div>