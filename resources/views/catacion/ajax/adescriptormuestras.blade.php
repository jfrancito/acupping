<nav class="mainNav">
    <ul>
      @foreach($listamuestradescriptores as $index=>$item)
          @php
            $btn_up = 'btn_up';
            $btn_bottom = 'btn_bottom';
          @endphp

          @if($index == "0")
            @php
              $btn_up = 'griss';
            @endphp
          @endif

          @if(count($listamuestradescriptores) == 1)
            @php
              $btn_bottom = 'griss';
            @endphp
          @endif

          @if(count($listamuestradescriptores) == ($index+1))
            @php
              $btn_bottom = 'griss';
            @endphp
          @endif

        <li class='descriptor relative has-subnav'>

          <a href="#">{{$item->descriptor->nombre}}</a>
          <span class="accordion-btn-wrap-orden">
              <span class="accordion-btn-orden">
                {{$item->prioridad}}
              </span>
          </span>
          <span class="accordion-btn-wrap-bottom {{$btn_bottom}}"
                data_muestra_descriptor = '{{$item->id}}'
                accion = '{{$btn_bottom}}'>
              <span class="accordion-btn-bottom">
                <i class="fa fa-chevron-down"></i>
              </span>
          </span>
          <span class="accordion-btn-wrap-up {{$btn_up}}"
                data_muestra_descriptor = '{{$item->id}}'
                accion = '{{$btn_up}}'>
              <span class="accordion-btn-up">
                <i class="fa fa-chevron-up"></i>
              </span>
          </span>

        </li>
      @endforeach
    </ul>
</nav>