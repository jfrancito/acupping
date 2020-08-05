<div  class="panel panel-border panel-contrast padre_seccion"
      data_muestra_id = '{{$muestra->id}}'
      data_codigo = '00000012'>
      @php
        $value = $funcion->catacion->value_catacion('00000012',$muestra->id);
        $data_catacion = $funcion->catacion->data_catacion('00000012',$muestra->id);
      @endphp
  <div class="panel-heading panel-heading-contrast"><b>Defectos</b>
    <div class="tools">
      <span class="badge puntaje">{{number_format($value, 2, '.', ',')}}</span>
    </div>
  </div>

  <div class="panel-body panel-indicadores">

    <div class='col-xs-12'>

      <div class='col-xs-6'>
        <div class="form-group">
          <label class="col-sm-12 control-label">Numero de tazas :</label>
          <div class="col-sm-12">
            {!! Form::select( 'numero_tazas', $combo_numerotazas, array($data_catacion->numerotasas),
                              [
                                'class'       => 'form-control control input-sm' ,
                                'id'          => 'numero_tazas',
                                'required'    => ''
                              ]) !!}
          </div>
        </div>
      </div>

      <div class='col-xs-6'>
        <div class="form-group">
          <label class="col-sm-12 control-label">Intensidad :</label>
          <div class="col-sm-12">
            {!! Form::select( 'intensidad', $combo_intensidad, array($data_catacion->intensidad),
                              [
                                'class'       => 'form-control control input-sm' ,
                                'id'          => 'intensidad',
                                'required'    => ''
                              ]) !!}
          </div>
        </div>
      </div>

      <div class="dropdown-tools">
          <div class="btn-group xs-mt-5 xs-mb-10">
            <label data-toggle="modal" data-target="#mod-warning" type="button" class="btn btn-default txtnumerotasas">
              {{$data_catacion->numerotasas}}
            </label>
            <label data-toggle="modal" data-target="#mod-warning" type="button" class="btn btn-default active">
              X
            </label>
            <label data-toggle="modal" data-target="#mod-warning" type="button" class="btn btn-default txtintensidad">
              {{$data_catacion->intensidad}}
            </label>
            <label data-toggle="modal" data-target="#mod-warning" type="button" class="btn btn-default active">
              =
            </label>
            <label data-toggle="modal" data-target="#mod-warning" type="button" class="btn btn-default txtdefectos">
              {{number_format($value, 2, '.', ',')}}
            </label>

          </div>
      </div>
    </div>

    <div class='col-xs-12'>

      @if(!isset($revisar))
       <ol class="breadcrumb">
          <li class="active selectdescriptores">
            Descriptores <i class="icon icon-right mdi mdi-eye"></i>
          </li>
        </ol>
        <div class='ajax_lista_descriptores_00000012'>
          @include('catacion.ajax.adescriptorcatacion', ['tipocatacion_codigo' => '00000012'])
        </div>
      @endif
    </div>



  </div>

  <div class="panel-body panel-descriptores">
    <div class='col-xs-12'>
      <div class='ajax-descriptores'>


      </div>
    </div>
  </div>

</div>