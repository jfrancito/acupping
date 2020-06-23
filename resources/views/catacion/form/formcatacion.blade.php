  <input type="hidden" name="puntaje_fragancia" id="puntaje_fragancia" value="{{$funcion->catacion->value_catacion('00000002',$muestra->id)}}">
  <input type="hidden" name="puntaje_sabor" id="puntaje_sabor" value="{{$funcion->catacion->value_catacion('00000003',$muestra->id)}}">
  <input type="hidden" name="puntaje_saborboca" id="puntaje_saborboca" value="{{$funcion->catacion->value_catacion('00000004',$muestra->id)}}">
  <input type="hidden" name="puntaje_acidez" id="puntaje_acidez" value="{{$funcion->catacion->value_catacion('00000005',$muestra->id)}}">
  <input type="hidden" name="puntaje_cuerpo" id="puntaje_cuerpo" value="{{$funcion->catacion->value_catacion('00000006',$muestra->id)}}">
  <input type="hidden" name="puntaje_balance" id="puntaje_balance" value="{{$funcion->catacion->value_catacion('00000007',$muestra->id)}}">
  <input type="hidden" name="puntaje_general" id="puntaje_general" value="{{$funcion->catacion->value_catacion('00000008',$muestra->id)}}">

  <div class="col-md-12">
          <div class="panel-heading" >
            <b>Calificación total de la muestra #{{$muestra->alias}} :
            <span id='puntaje_total'>{{$muestra->puntaje}}</span>
            </b>
          </div>
  </div>
  <div class="col-md-4">
    <div class='container-tueste'>
      @include('catacion.ajax.atueste')
    </div>
  </div>

  <div class="col-md-4">
    <div class='container-fragancia'>
      @include('catacion.ajax.afragancia')
    </div>
  </div>

  <div class="col-md-4">
    <div class='container-sabor'>
      @include('catacion.ajax.asabor')
    </div>
  </div>

  <div class="col-md-4">
    <div class='container-saborboca'>
      @include('catacion.ajax.asaborboca')
    </div>
  </div>
  <div class="col-md-4">
    <div class='container-acidez'>
      @include('catacion.ajax.aacidez')
    </div>
  </div>
  <div class="col-md-4">
    <div class='container-cuerpo'>
      @include('catacion.ajax.acuerpo')
    </div>
  </div>
  <div class="col-md-4">
    <div class='container-balance'>
      @include('catacion.ajax.abalance')
    </div>
  </div>
  <div class="col-md-4">
    <div class='container-general'>
      @include('catacion.ajax.ageneral')
    </div>
  </div>
  <div class="col-md-4 sector-tazas">
    <div class="col-md-12">
      <div class='container-uniformidad container-check'>
        @include('catacion.ajax.auniformidad')
      </div>
    </div>
    <div class="col-md-12">
      <div class='container-tazalimpia container-check'>
        @include('catacion.ajax.atazalimpia')
      </div>
    </div>
    <div class="col-md-12">
      <div class='container-dulzor container-check'>
        @include('catacion.ajax.adulzor')
      </div>
    </div>

  </div>

  <div class="col-md-6">
    <div class='container-defecto'>
      @include('catacion.ajax.adefectos')
    </div>
  </div>
  <div class="col-md-6">
    <div class='container-notas'>
      @include('catacion.ajax.anotas')
    </div>
  </div>
@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
        var carpeta = $("#carpeta").val();
        var puntaje_fragancia = $("#puntaje_fragancia").val();
        var puntaje_sabor = $("#puntaje_sabor").val();
        var puntaje_saborboca = $("#puntaje_saborboca").val();
        var puntaje_acidez = $("#puntaje_acidez").val();
        var puntaje_cuerpo = $("#puntaje_cuerpo").val();
        var puntaje_balance = $("#puntaje_balance").val();
        var puntaje_general = $("#puntaje_general").val();


        $(".slider00000002")
        .slider({
            min: 5,
            max: 10,
            value: puntaje_fragancia,
            step: 0.25,
            orientation: "vertical"
        })
        .slider("pips", {
            rest: "label"
        }).on("slidechange", function(e,ui) {

            var padre = $(this).parents('.padre_seccion');
            var data_muestra_id = $(padre).attr('data_muestra_id');
            var data_codigo = $(padre).attr('data_codigo');
            var puntaje = $(padre).find('.puntaje');
            $(puntaje).text(ui.value);
            actualizar_puntaje_catacion_muestra(data_muestra_id,data_codigo,ui.value);

        }).slider("float");


        $(".slider00000003")
        .slider({
            min: 5,
            max: 10,
            value: puntaje_sabor,
            step: 0.25,
            orientation: "vertical"
        })
        .slider("pips", {
            rest: "label"
        }).on("slidechange", function(e,ui) {

            var padre = $(this).parents('.padre_seccion');
            var data_muestra_id = $(padre).attr('data_muestra_id');
            var data_codigo = $(padre).attr('data_codigo');
            var puntaje = $(padre).find('.puntaje');
            $(puntaje).text(ui.value);
            actualizar_puntaje_catacion_muestra(data_muestra_id,data_codigo,ui.value);

        }).slider("float");


        $(".slider00000004")
        .slider({
            min: 5,
            max: 10,
            value: puntaje_saborboca,
            step: 0.25,
            orientation: "vertical"
        })
        .slider("pips", {
            rest: "label"
        }).on("slidechange", function(e,ui) {

            var padre = $(this).parents('.padre_seccion');
            var data_muestra_id = $(padre).attr('data_muestra_id');
            var data_codigo = $(padre).attr('data_codigo');
            var puntaje = $(padre).find('.puntaje');
            $(puntaje).text(ui.value);
            actualizar_puntaje_catacion_muestra(data_muestra_id,data_codigo,ui.value);

        }).slider("float");

        $(".slider00000005")
        .slider({
            min: 5,
            max: 10,
            value: puntaje_acidez,
            step: 0.25,
            orientation: "vertical"
        })
        .slider("pips", {
            rest: "label"
        }).on("slidechange", function(e,ui) {

            var padre = $(this).parents('.padre_seccion');
            var data_muestra_id = $(padre).attr('data_muestra_id');
            var data_codigo = $(padre).attr('data_codigo');
            var puntaje = $(padre).find('.puntaje');
            $(puntaje).text(ui.value);
            actualizar_puntaje_catacion_muestra(data_muestra_id,data_codigo,ui.value);

        }).slider("float");

        $(".slider00000006")
        .slider({
            min: 5,
            max: 10,
            value: puntaje_cuerpo,
            step: 0.25,
            orientation: "vertical"
        })
        .slider("pips", {
            rest: "label"
        }).on("slidechange", function(e,ui) {

            var padre = $(this).parents('.padre_seccion');
            var data_muestra_id = $(padre).attr('data_muestra_id');
            var data_codigo = $(padre).attr('data_codigo');
            var puntaje = $(padre).find('.puntaje');
            $(puntaje).text(ui.value);
            actualizar_puntaje_catacion_muestra(data_muestra_id,data_codigo,ui.value);

        }).slider("float");


        $(".slider00000007")
        .slider({
            min: 5,
            max: 10,
            value: puntaje_balance,
            step: 0.25,
            orientation: "vertical"
        })
        .slider("pips", {
            rest: "label"
        }).on("slidechange", function(e,ui) {

            var padre = $(this).parents('.padre_seccion');
            var data_muestra_id = $(padre).attr('data_muestra_id');
            var data_codigo = $(padre).attr('data_codigo');
            var puntaje = $(padre).find('.puntaje');
            $(puntaje).text(ui.value);
            actualizar_puntaje_catacion_muestra(data_muestra_id,data_codigo,ui.value);

        }).slider("float");


        $(".slider00000008")
        .slider({
            min: 5,
            max: 10,
            value: puntaje_general,
            step: 0.25,
            orientation: "vertical"
        })
        .slider("pips", {
            rest: "label"
        }).on("slidechange", function(e,ui) {

            var padre = $(this).parents('.padre_seccion');
            var data_muestra_id = $(padre).attr('data_muestra_id');
            var data_codigo = $(padre).attr('data_codigo');
            var puntaje = $(padre).find('.puntaje');
            $(puntaje).text(ui.value);
            actualizar_puntaje_catacion_muestra(data_muestra_id,data_codigo,ui.value);

        }).slider("float");


        function actualizar_puntaje_catacion_muestra(muestra_id,tipocatacion_codigo,catacion_value){

            var _token = $('#token').val();

            $.ajax({
                type    :   "POST",
                url     :   carpeta+"/ajax-recalcular-puntaje-catacion-muestra",
                data    :   {
                                _token                  : _token,
                                muestra_id              : muestra_id,
                                catacion_value          : catacion_value,
                                tipocatacion_codigo     : tipocatacion_codigo,
                            },
                success: function (data) {
                    $("#puntaje_total").html(data);
                    alertajax("Modificación exitosa");
                },
                error: function (data) {
                    error500(data);
                }
            });

        }

    });
  </script>
@endif