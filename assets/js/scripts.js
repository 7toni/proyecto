//Variables

//Functions
    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('#img_avatar').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
    }
    }

    var checkPasswords = function(input) {
    if (input.value != document.getElementById('password').value) {
        input.setCustomValidity('Las contraseñas deben de coincidir');
    } else {
        input.setCustomValidity('');
    }
    }   
    
    /* Lista de errores nombre de la alerta, tipo de alerta, y texto */
    function alertas_tipo_valor(alerta, tipo, valor) {
        $("[name='alertas']").remove();
        if (tipo == 'correcto') {
            $("#" + alerta + "").before(
                "<div class='form-group' name='alertas'>" + "<div class='col-sm-3'> </div>" + "<div class='col-sm-9'> " + "<div class='alert alert-success alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-check'></i> Alerta!</h4>" + "Resultados correctos." + "</div>" + "</div>" + "</div>");
        }
        if (tipo == 'vacio') {
            $("#" + alerta + "").before(
                "<div class='form-group' name='alertas'>" + "<div class='col-sm-3'> </div>" + "<div class='col-sm-9'> " + "<div class='alert alert-info alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-info'></i> Alerta!</h4>" + "No se ha encontrado resultados, verifique su información." + valor + "</div>" + "</div>" + "</div>");
        }
        if (tipo == 'requerido') {
            $("#" + alerta + "").before(
                "<div class='form-group' name='alertas'>" + "<div class='col-sm-3'> </div>" + "<div class='col-sm-9'> " + "<div class='alert alert-danger alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-ban'></i> Alerta!</h4>" + "Campo requerido, favor de ingresar " + valor + " correctamente. Intente una vez más." + "</div>" + "</div>" + "</div>");
        }
    }

    function alertas_tipo_valor_col12(alerta, tipo, valor) {
        $("[name='alertas']").remove();
        if (tipo == 'correcto') {
            $("#" + alerta + "").before(
                "<div class='form-group' name='alertas'>" + "<div class='col'> " + "<div class='alert alert-success alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-check'></i> Alerta!</h4>" + "Resultados correctos." + "</div>" + "</div>" + "</div>");
        }
        if (tipo == 'vacio') {
            $("#" + alerta + "").before(
                "<div class='form-group' name='alertas'>" + "<div class='col'> " + "<div class='alert alert-info alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-info'></i> Alerta!</h4>" + "No se ha encontrado resultados, verifique su información." + valor + "</div>" + "</div>" + "</div>");
        }
        if (tipo == 'requerido') {
            $("#" + alerta + "").before(
                "<div class='form-group' name='alertas'>" + "<div class='col'> " + "<div class='alert alert-danger alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-ban'></i> Alerta!</h4>" + "Campo requerido, favor de ingresar " + valor + " correctamente. Intente una vez más." + "</div>" + "</div>" + "</div>");
        }
        if (tipo == 'error') {
            $("#" + alerta + "").before(
                "<div class='form-group' name='alertas'>" + "<div class='col'> " + "<div class='alert alert-danger alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-ban'></i> Alerta!</h4>" + valor + " </div>" + "</div>" + "</div>");
        }
    }
    
    function ultimo_numero_salida() {
    $.ajax({
        url: "?c=salida&a=ajax_load_ultimo_hojasalida",
        dataType: "json",
        data: ""
    }).done(function(data) {
        var datos = data;    
        $("#ultimo_hojasalida").text(datos[0].numero);
    }).fail(function(data) {}).always(function(data) {
        //console.log(data);
    });
    }

    /* Buscar los técnicos de acuerdo a la sucursal  */
    var sucursalxtec_ajax = function() {
        //console.log($(".select2").val());   
        $.ajax({
            url: "?c=reportes&a=ajax_load_tecnicos",
            dataType: "json",
            method: "POST",
            data: "sucursal=" + $(".select2").val()
        }).done(function(data) {
            var datos = data;         
            var select = $('#usuarios_calibracion_id');
            select.empty();
            select.append($("<option />").val('').text('Seleccione una opción'));
            select.append($("<option />").val('0').text('Todos'));
            $.each(datos, function() {                        
                select.append($("<option />").val(this.id).text(this.nombre + ' '+ this.apellido));
            });  
            $('#usuarios_calibracion_id').val('').change();       
        }).fail(function(data) {}).always(function(data) {
            //console.log(data);
        });
    }     

/* Buscar Hoja de salida */
    var buscar_hoja_salida = function() {
        if (validar_text($("#hojas_salida_id").val()) == true) {
            if ($("#hojas_salida_id").val().substr(0,4)!="0000") { //evitar la busqueda de los números de hoja con '0000'
                $.ajax({
                    url: "?c=salida&a=ajax_load_hoja_salida",
                    dataType: "json",
                    method: "POST",
                    data: "hojas_salida_id=" + $("#hojas_salida_id").val()
                }).done(function(data) {
                    var datos = data;
                    if (datos.length > 0) {
                        $('#hojas_salida_id').val(datos[0].numero);
                        $('#usuario_hoja_salida').val(datos[0].usuarios_id).change(); // librerias de query -> select2                 
                        $('#fecha').datepicker({ autoclose: true, format: 'yyyy-mm-dd' }).datepicker("setDate", datos[0].fecha);
                        var entregado = datos[0].fecha_entrega;
                        //se hace uso de icheck para hacer el checked sobre el input de el equipo fue entregado
                        if (entregado.length > 0) { $('.minimal').iCheck('check'); }

                        alertas_tipo_valor('alerta_hojasalida', 'correcto', '');
                    } else {
                        $('.minimal').iCheck('uncheck');
                        alertas_tipo_valor('alerta_hojasalida', 'vacio', '');
                    }
                }).fail(function(data) {}).always(function(data) {
                    //console.log(data);
                });
            }
        } else {
            $('input').iCheck('check');
            alertas_tipo_valor('alerta_hojasalida', 'requerido', 'número de hoja salida');
        }
    }
    /* End Hoja de salida */
/* validar campos  */
    function validar_text(id) {        
    var bool = true;
    if (id == "" || id === null) {
        bool = false;
    }       
    return bool;
    }
   

/* Información de cokies */
    function retorna_session_planta() {
        $.ajax({
            url: "?c=recepcion&a=cookies",
            dataType: "json",
            data: ""
        }).done(function(data) {
            var datos = data;
            opciones_calibraciones(datos.toLowerCase().trim());
        }).fail(function(data) {}).always(function(data) {
            //console.log(data);
        });
    }
    /* ## Fin de funciones de recepción ## */

    /* Buscar plantas de la empresa  */
    var empresa_ajax = function() {
        $.ajax({
            url: "?c=usuarios&a=ajax_load_plantas",
            dataType: "json",
            method: "POST",
            data: "empresas_id=" + $(".select2").val()
        }).done(function(data) {
            var datos = data;
            var select = $('#idplanta_ajax');
            select.empty();
            select.append($("<option />").val('').text('Seleccione una opción'));
            $.each(datos, function() {
                select.append($("<option />").val(this.id).text(this.nombre));
            });

        }).fail(function(data) {

        }).always(function(data) {

        });
    } 

    var idplanta_ajax = function() {
        var dato= $('#idplanta_ajax').val();
        if(dato != ""){            
            $.ajax({
                url: "?c=recepcion&a=ajax_load_cliente",
                dataType: "json",
                method: "POST",
                data: "idplanta=" + dato
            }).done(function(data) {
                var datos = data;

                var label = $('#direccion_planta');
                label.empty();
                if (datos[0]['address'] != null){                    
                    label.append($('#direccion_planta').text(datos[0]['address']));
                    label.addClass('control-label pull-left');
                }else{                    
                    label.append($('#direccion_planta').text('Sin dirección'));
                    label.addClass('control-label pull-left');
                }                                
            }).fail(function(data) {}).always(function(data) {
                // console.log(data);
            });
        }
        else{
            //console.log("vacio");
        }

       
      }
   
    function _accesovalidacion(parametro){
        
    }

    //Events
    $(window).load(function() {
        // Mostrar equipos a calibrar en area de notificaciones
        $.ajax({
            url: "?c=informes&a=get_a_calibrar",
            dataType: "json",
            method: "GET",
            }).done(function(data) {
            var count = data.length;
            if(count >0){$('#notification_number').text(count);}
            $.each(data, function(i, item) {
                var color;            
                if(item.prioridad == '0' || item.prioridad == null){
                    color = 'blue'
                } else{
                    color = 'red';
                }
                $('#notification_header').text('Tienes '+count+' equipos a calibrar');
                $('#notification_menu').append('<li><a href="?c=calibracion&a=index&p='+item.id+'" title="'+item.descripcion+'"><i class="fa fa-file-text text-'+color+'"></i> #' + item.id + ' - ' + item.descripcion + '</a></li>');
            });
        }).fail(function(data) {
        }).always(function(data) {
        });

        $.ajax({
            url: "?c=usuarios&a=get_usuario_alta",
            dataType: "json",
            method: "GET",
            }).done(function(data) {
            var count = data.length;
            if(count >0){$('#notification_number_2').text(count);}
            $.each(data, function(i, item) {                
                var date_home= new Date(item.fecha);          
                var dayWrapper = moment(date_home);
                var horas = moment().diff(dayWrapper, 'hours'); // Diff in hours
                //var dias = moment().diff(dayWrapper, 'days'); // Diff in days                
                var nombre= item.nombre +' '+ item.apellido;
                $('#notification_header_2').text('Tienes '+count+' Usuarios para dar de alta');                
                $('#notification_menu_2').append('<li><a href="?c=usuarios&a=edit&p='+item.id+'&alta=true" title="'+nombre+'"><div class="pull-left"><img src="storage/avatares/default.png" class="img-circle" alt="User Image" width="20" height="20"></div><h4>'+ nombre +'<small><i class="fa fa-clock-o"></i> hace '+ horas +' horas </small></h4><p>'+ item.email +'</p></a></li>');
            });

            }).fail(function(data) {

            }).always(function(data) {
        });       
    });

    $(document).ready(function() {
        //$('#historial_informes').last().addClass( "table-fixed" );             
        //Busqueda
        $('#search').on('keyup', function(e) {
            if (e.which == 13) {
                var str = (($('#search').val()).trim()).toLowerCase();
                if (str.length >= 2) {
                    window.location.replace('?c=buscar&p=' + str);
                }
            }
        });

        $('#search-btn').on('click', function(e) {
            var str = $('#search').val();
            if (str.length >= 2) {
                window.location.replace('?c=buscar&p=' + str);
            }
        });
        // # Empresa / Usuario           
        $("#empresa_ajax").on('change', empresa_ajax);
        $("#idplanta_ajax").on('change', idplanta_ajax);  

        //Fin busqueda
        $('.sidebar-toggle').on('click', function() {
            //
        });

        // Selects 2
        $(".select2").select2();

        $('.select2Modelo').select2({
            language: "es",
            placeholder: 'Seleccione una opción',
            ajax: {
                url: 'api/EquiposModelos.php',
                dataType: 'json',
                delay: 450,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    console.log(params);
                    params.page = params.page || 1;
                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) <= data[0].total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup; },
            minimumInputLength: 1
        });

        $('.select2Marca').select2({
            language: "es",

            placeholder: 'Seleccione una opción',
            ajax: {
                url: 'api/EquiposMarca.php',
                dataType: 'json',
                delay: 450,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) <= data[0].total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup; },
            minimumInputLength: 1
        });

        $('.select2Descripcion').select2({
            language: "es",

            placeholder: 'Seleccione una opción',
            ajax: {
                url: 'api/EquiposDescripciones.php',
                dataType: 'json',
                delay: 450,
                data: function(params) {                    
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) <= data[0].total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup; },
            minimumInputLength: 1,

        });

        $('.select2Empresa').select2({
            language: "es",
            placeholder: 'Seleccione una opción',
            ajax: {
                url: 'api/Empresas.php',
                dataType: 'json',
                delay: 450,
                data: function(params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function(data, params) {
                    console.log(params);
                    params.page = params.page || 1;
                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) <= data[0].total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function(markup) {
                return markup; },
            minimumInputLength: 1
        });
       
        // $('#idequipo').keyup(function(){ 
        //     var value=  $('#idequipo').val().trim();               
        //      $('#idequipo').val(value);
        // });
                             
        // ultimo_numero_salida();        
        //# End Recepción

        /* start Salida */
        $("#buscar_hoja_salida").on('click', buscar_hoja_salida);
        $("#hojas_salida_id").keypress(function(e) {
            if($(this).val().length==4)
            {
                var anio = (new Date).getFullYear();            
                var numero=$(this).val();
                numero.replace(numero);            
                $(this).val(numero+'-'+anio.toString().substr(-2));
            }
            if (e.which == 13) {
                $(this).val(espacio_blanco($(this).val()));      
                buscar_hoja_salida();
                e.preventDefault();
            }
        });
        /* End Salida */

        $("#cp").inputmask("99999", {
            clearIncomplete: true,
            showMaskOnHover: false,
            nullable: false,
        });
        $("#phone").inputmask("(999) 999-9999", {
            clearIncomplete: true,
            showMaskOnHover: false,
            nullable: false,
        });

        $('.datepicker').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        }).datepicker('setDate', 'today');

        /* Esta opcion es para cuando en un campo se pone la fecha desde php */
        $('.datepicker_aux').datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd'
        }); 

        /* Datarange libreria*/
        $('#daterange-text').daterangepicker(
            {
          ranges: {
            'Hoy': [moment(), moment()],
            'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'últimos 7 días': [moment().subtract(6, 'days'), moment()],
            'últimos 30 días': [moment().subtract(29, 'days'), moment()],
            'Este mes': [moment().startOf('month'), moment().endOf('month')],
            'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            '1 año': [moment().subtract(1, 'years').add(1, 'day'), moment()]            
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
            },
            function (start, end) {
          $('#daterange-text span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));
            }
        );                
       
        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
        
         /* Home Reportes Productividad  */  
        $("#nombre_suc").on('change', sucursalxtec_ajax);            
        /* End Reportes productividad */        

    });

    $("#avatar").change(function() {
        readURL(this);
    });

    function espacio_blanco(value){                      
         return value.trim();
    }   
    
