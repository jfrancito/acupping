<table id="table1" class="table table-striped table-hover table-fw-widget dt-responsive nowrap listatabla" style='width: 100%;'>
  <thead>
    <tr>
      <th>Codigo</th>
      <th>Dueño</th>
      <th>Fecha y hora</th>
      <th>Descripción</th>
      <th>Lugar</th>

      <th>Información de muestras</th>
      <th>Editar</th>
      <th>Estatus</th>
      <th>Revisar</th>
      <th>Eliminar</th>

    </tr>
  </thead>
  <tbody>
    @foreach($listasesiones as $index=>$item)
      <tr>
        <td>{{$item->codigo}}</td>
        <td>{{$funcion->funciones->tabla_usuario($item->usuario_crea)->nombre}}</td>
        <td>{{date_format(date_create($item->fecha_crea), 'd-m-Y H:i')}}</td>
        <td>{{$item->descripcion}}</td>
        <td>{{$item->lugar}}</td>

        <td class='center'>
          <a  href="{{ url('/editar-muestras/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8))) }}"
              class="btn btn-rounded btn-space btn-primary">
            <i class="icon icon-left mdi mdi-edit"></i> {{$funcion->catacion->count_muetras_editadas($item->id)}} / {{$item->numeros_muestra}}
          </a>
        </td>
        <td class='center'>
          <a  href="{{ url('/modificar-sesion-catacion/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8))) }}"
              class="btn btn-rounded btn-space btn-primary">
            <i class="icon icon-left mdi mdi-edit"></i>
          </a>
        </td>
        <td class='center'>
          <a  href="{{ url('/realizar-catacion/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8))) }}"
              class="btn btn-rounded btn-space btn-success">
            <i class="icon icon-left mdi mdi-coffee"></i> catar ahora
          </a>
        </td>

        <td class='center'>
          <a  href="{{ url('/modificar-sesion-catacion/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8))) }}"
              class="btn btn-rounded btn-space btn-success">
            <i class="icon icon-left mdi mdi-assignment"></i>
          </a>
        </td>


        <td class='center'>
          <a  href="{{ url('/eliminar-sesion-catacion/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8))) }}"
              class="btn btn-rounded btn-space btn-danger">
            <i class="icon icon-left mdi mdi-delete"></i>
          </a>
        </td>
      </tr>
    @endforeach

  </tbody>
</table>

@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script>
@endif

