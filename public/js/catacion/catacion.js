$(document).ready(function(){

	var carpeta = $("#carpeta").val();



    $(".catacion").on('click','.selectdescriptores', function() {
        var padre                       = $(this).parents('.panel-indicadores');
        var hermano                     = $(padre).siblings('.panel-descriptores');
        $(padre).toggle();
        $(hermano).toggle();
    });


    $(".catacion").on('click','#asignarnota', function() {

        var padre                       = $(this).parents('.padre_seccion');
        var puntaje                     = $(padre).find('.puntaje');
        var data_muestra_id             = $(padre).attr('data_muestra_id');
        var data_codigo                 = $(padre).attr('data_codigo');
        var value                       = $(padre).find('#notas').val();
        var data_value                  = value;
        actualizar_notas_catacion_muestra(data_muestra_id,data_codigo,data_value);
    });



    $(".catacion").on('click','#asignardefectos', function() {

        var padre                       = $(this).parents('.padre_seccion');
        var puntaje                     = $(padre).find('.puntaje');
        var data_muestra_id             = $(padre).attr('data_muestra_id');
        var data_codigo                 = $(padre).attr('data_codigo');
        var value                       = $(padre).find('#defecto').val();
        var data_value                  = -parseFloat(value);
        $(puntaje).text(data_value.toFixed(2));
        actualizar_puntaje_catacion_muestra(data_muestra_id,data_codigo,data_value);
    });

    $(".catacion").on('click','.checkuniformidad', function() {

        var padre                       = $(this).parents('.padre_seccion');
        var puntaje                     = $(padre).find('.puntaje');
        var data_muestra_id             = $(this).attr('data_muestra_id');
        var data_codigo                 = $(this).attr('data_codigo');
        var data_value                  = parseFloat($(puntaje).html());
        var input                       = $(this).siblings('.input_uniformidad');
        if($(input).is(':checked')){
            data_value   = data_value - 2;
        }else{
            data_value   = data_value + 2;
        }
        $(puntaje).text(data_value.toFixed(2));
        actualizar_puntaje_catacion_muestra(data_muestra_id,data_codigo,data_value);
    });

    $(".catacion").on('click','.checktazitas', function() {

        var padre                       = $(this).parents('.padre_seccion');
        var puntaje                     = $(padre).find('.puntaje');
        var data_muestra_id             = $(this).attr('data_muestra_id');
        var data_codigo                 = $(this).attr('data_codigo');
        var data_value                  = parseFloat($(puntaje).html());
        var input                       = $(this).siblings('.input_tazalimpia');
        if($(input).is(':checked')){
            data_value   = data_value - 2;
        }else{
            data_value   = data_value + 2;
        }
        $(puntaje).text(data_value.toFixed(2));
        actualizar_puntaje_catacion_muestra(data_muestra_id,data_codigo,data_value);
    });

    $(".catacion").on('click','.checkdulzor', function() {

        var padre                       = $(this).parents('.padre_seccion');
        var puntaje                     = $(padre).find('.puntaje');
        var data_muestra_id             = $(this).attr('data_muestra_id');
        var data_codigo                 = $(this).attr('data_codigo');
        var data_value                  = parseFloat($(puntaje).html());
        var input                       = $(this).siblings('.input_dulzor');
        if($(input).is(':checked')){
            data_value   = data_value - 2;
        }else{
            data_value   = data_value + 2;
        }
        $(puntaje).text(data_value.toFixed(2));
        actualizar_puntaje_catacion_muestra(data_muestra_id,data_codigo,data_value);
    });



    $(".catacion").on('click','.tabcatacion', function() {
        var _token                      = $('#token').val();
        var data_alias                  = $(this).attr('data_alias');
        var contenedor                  = 'cont'+data_alias;
        var idopcion                    = $(this).attr('data_opcion');
        var muestra_id                  = $(this).attr('data_muestra');
        $('.tab-pane').html('');
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-mostrar-form-muestra",
            data    :   {
                            _token                  : _token,
                            muestra_id              : muestra_id,
                            idopcion                : idopcion
                        },
            success: function (data) {
                $('.'+contenedor).html(data);
                cerrarcargando();
            },
            error: function (data) {
                error500(data);
            }
        });
    });




    $(".catacion").on('click','.tabmuestra', function() {
        var _token                      = $('#token').val();
        var data_alias           		= $(this).attr('data_alias');
        var contenedor 					= 'cont'+data_alias;
        var idopcion           			= $(this).attr('data_opcion');
        var muestra_id           		= $(this).attr('data_muestra');
        $('.tab-pane').html('');
        abrircargando();
        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-mostrar-form-muestra",
            data    :   {
                            _token                  : _token,
                            muestra_id       		: muestra_id,
                            idopcion        		: idopcion
                        },
            success: function (data) {
                $('.'+contenedor).html(data);
                cerrarcargando();
            },
            error: function (data) {
                error500(data);
            }
        });
    });


    $(".catacion").on('click','.btntueste', function() {

        var _token                      = $('#token').val();
        var data_muestra_id             = $(this).attr('data_muestra_id');
        var data_value                  = $(this).attr('data_value');
        var data_codigo                 = $(this).attr('data_codigo');

        //$('.container-tueste').html('');

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-tueste",
            data    :   {
                            _token                  : _token,
                            muestra_id              : data_muestra_id,
                            catacion_value          : data_value,
                            tipocatacion_codigo     : data_codigo,
                        },
            success: function (data) {
                $('.container-tueste').html(data);
                alertajax("Modificación exitosa");
            },
            error: function (data) {
                error500(data);
            }
        });
    });


    actualizar_indicadores_muestra();
    

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
    function actualizar_notas_catacion_muestra(muestra_id,tipocatacion_codigo,catacion_value){

        var _token = $('#token').val();

        $.ajax({
            type    :   "POST",
            url     :   carpeta+"/ajax-notas-catacion-muestra",
            data    :   {
                            _token                  : _token,
                            muestra_id              : muestra_id,
                            catacion_value          : catacion_value,
                            tipocatacion_codigo     : tipocatacion_codigo,
                        },
            success: function (data) {
                alertajax("Modificación exitosa");
            },
            error: function (data) {
                error500(data);
            }
        });

    }
	

    function actualizar_indicadores_muestra(){

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

    }

	$('.numeroentero').inputmask({
	    'alias': 'numeric',
	    'groupSeparator': ',',
	    'autoGroup': true,
	    'digits': 0,
	    'digitsOptional': false,
	    'prefix': '',
	    'placeholder': '0'
	  });
});