
<div class="tools cerrar-descriptor">
  <span class="badge badge-danger cerra-panel"><span class="icon mdi mdi-close"></span></span>
</div>
<nav class="mainNav">
  <ul>
    @foreach($listadescriptortipocatacion as $index=>$item)
      <li class='descriptor'
      data_descriptortipocatacion_id='{{$item->descriptortipocatacion_id}}'
      data_catacion_id="{{$catacion_id}}"
      data_tipocatacion_codigo="{{$tipocatacion_codigo}}"
      >
        <a href="#">{{$item->nombre}}</a>
        <span class="accordion-btn-wrap-agregar">
            <span class="accordion-btn-agregar">
              <i class="fa fa-plus"></i>
            </span>
        </span>

        @php
          $listadescritores1 = $funcion->catacion->lista_descriptores_niveles(0, $tipocatacion_id, $item->codigo);
        @endphp
        <ul>
          @foreach($listadescritores1 as $index1=>$item1)

              @php
                $listadescritores2 = $funcion->catacion->lista_descriptores_niveles(0, $tipocatacion_id, $item1->codigo);
              @endphp

              <li class="relative descriptor"
                data_descriptortipocatacion_id='{{$item1->descriptortipocatacion_id}}'
                data_catacion_id="{{$catacion_id}}"
                data_tipocatacion_codigo="{{$tipocatacion_codigo}}">
                <a href="#">{{$item1->nombre}}</a>
                <span class="accordion-btn-wrap-agregar @if(count($listadescritores2)<=0) btn-sin-detalle @endif">
                    <span class="accordion-btn-agregar">
                      <i class="fa fa-plus"></i>
                    </span>
                </span>


                @if(count($listadescritores2)>0)
                  <ul>
                    @foreach($listadescritores2 as $index2=>$item2)

                        @php
                          $listadescritores3 = $funcion->catacion->lista_descriptores_niveles(0, $tipocatacion_id, $item2->codigo);
                        @endphp

                        <li class="relative descriptor"
                          data_descriptortipocatacion_id='{{$item2->descriptortipocatacion_id}}'
                          data_catacion_id="{{$catacion_id}}"
                          data_tipocatacion_codigo="{{$tipocatacion_codigo}}">
                          <a href="#">{{$item2->nombre}}</a>
                          <span class="accordion-btn-wrap-agregar @if(count($listadescritores3)<=0) btn-sin-detalle @endif">
                              <span class="accordion-btn-agregar">
                                <i class="fa fa-plus"></i>
                              </span>
                          </span>

                          @if(count($listadescritores3)>0)
                            <ul>
                              @foreach($listadescritores3 as $index3=>$item3)

                                @php
                                  $listadescritores4 = $funcion->catacion->lista_descriptores_niveles(0, $tipocatacion_id, $item3->codigo);
                                @endphp


                                  <li class="relative descriptor"
                                    data_descriptortipocatacion_id='{{$item3->descriptortipocatacion_id}}'
                                    data_catacion_id="{{$catacion_id}}"
                                    data_tipocatacion_codigo="{{$tipocatacion_codigo}}">
                                    <a href="#">{{$item3->nombre}}</a>
                                    <span class="accordion-btn-wrap-agregar @if(count($listadescritores4)<=0) btn-sin-detalle @endif">
                                        <span class="accordion-btn-agregar">
                                          <i class="fa fa-plus"></i>
                                        </span>
                                    </span>

                                    @if(count($listadescritores4)>0)
                                      <ul>
                                        @foreach($listadescritores4 as $index4=>$item4)

                                            <li class="relative descriptor"
                                              data_descriptortipocatacion_id='{{$item4->descriptortipocatacion_id}}'
                                              data_catacion_id="{{$catacion_id}}"
                                              data_tipocatacion_codigo="{{$tipocatacion_codigo}}">
                                              <a href="#">{{$item4->nombre}}</a>
                                              <span class="accordion-btn-wrap-agregar btn-sin-detalle ">
                                                  <span class="accordion-btn-agregar">
                                                    <i class="fa fa-plus"></i>
                                                  </span>
                                              </span>

                                            </li>
                                        @endforeach
                                      </ul>
                                    @endif
                                  </li>
                              @endforeach
                            </ul>
                          @endif



                        </li>
                    @endforeach
                  </ul>
                @endif
              </li>
          @endforeach
        </ul>
      </li>
    @endforeach
  </ul>
</nav>



@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
      //Accordion Nav
      jQuery('.mainNav').navAccordion({
        expandButtonText: '<i class="fa fa-chevron-down"></i>',  //Text inside of buttons can be HTML
        collapseButtonText: '<i class="fa fa-chevron-up"></i>'
      },
      function(){
        console.log('Callback')
      });
    });
  </script>
@endif