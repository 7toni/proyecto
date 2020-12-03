/* Inicio de variables de recepción */
    var historial = {};
    //var count_check_equipo = 0;
    var count_numinforme=0;
    var planta_temp = "";      
/* End variables de inicio */
 
/* Generar número de informe  */
    function generar_informe() {
        count_numinforme++;        
        if(count_numinforme<2)
        {
            $.ajax({
                url: "?c=recepcion&a=ajax_load_generar_informe",
                dataType: "json",
                data: ""
            }).done(function(data) {
                var datos = data;
                //console.log(datos);
                $("#numero_informe").val(datos[0].id);
                count_numinforme++;
                document.getElementById("btn_generar_informe").disabled = true;
            }).fail(function(data) {}).always(function(data) {
                //console.log(data);s
            });
        }
    }
/* End  generar_informe() */

/* Consultar el último número de informe registrado */
    var ultimo_numero_informe = function() {   
        $.ajax({
            url: "?c=recepcion&a=ajax_load_ultimo_informe",
            dataType: "json",
            data: ""
        }).done(function(data) {
            var datos = data;
            $("#ultimo_informe").text(datos[0].id);         
            //console.log(datos[0].id);                                       
        }).fail(function(data) {}).always(function(data) {
            //console.log(data);
        });   
    }
/* End  ultimo_numero_informe */

/* asignar_equipo_cliente */
    // var asignar_equipo_cliente = function(index) {
    //     //count_check_equipo++;
    //     //if (count_check_equipo < 2) {
    //         $('#table_equipo').removeClass( "table-scroll" );
    //         $('#table_equipo tbody').remove();                        
    //         //console.log( historial);                
    //         var bitacora = historial[index];            
    //         planta_temp = bitacora.plantas_id;
        
    //         if (bitacora.equipo_activo=="1"){
    //         estadoeq="Activo";
    //         labeleq="label-success";                        
    //         }
    //         else{
    //             estadoeq="Inactivo";
    //             labeleq="label-danger";
    //             disabled="disabled";
    //         }        

    //         var nuevafila = "<tr>" +
    //             "<td><label> <input type='radio' class='minimal' name='equipos_id' value='" + bitacora.equipos_id + "' checked></label></td>" +
    //             "<td>" + bitacora.alias + "</td>" +
    //             "<td>" + bitacora.descripcion + "</td>" +
    //             "<td>" + bitacora.marca + "</td>" +
    //             "<td>" + bitacora.modelo + "</td>" +
    //             "<td>" + bitacora.serie + "</td>" +
    //             "<td > <span class='label "+ labeleq +"'>" + estadoeq + "</spam> </td>" +
    //             "<td> <a class='btn btn-block btn-warning btn-sm' target='_blank'  href='?c=equipos&a=edit&p=" + bitacora.equipos_id + "'><i class='fa fa-pencil' aria-hidden='true'></i></a></td>" +
    //             +"</tr>"
    //         $("#table_equipo").append(nuevafila);

    //         $('#empresa_ajax_r').val(bitacora.empresas_id).change();
    //         $('#periodo_calibracion').val(bitacora.vigencia)
    //         $('#acreditaciones_id').val(bitacora.acreditacion).change();
    //         $('#calibraciones_id').val(bitacora.tipo_cal).change();
    //         $('#usuarios_calibracion_id').val(bitacora.tecnico_cal).change();            
                      
    //         var porciento = validar_equipo_vigenciacal(bitacora.equipos_id);
    //         var usuario_permiso=validar_usuario_confirmar();
           
    //         if(porciento == 0 ){ 
    //             if(usuario_permiso==1){
    //                 $("[name='informevalidacion']").remove();
    //                 var valor= "<p> <h4>El equipo aún no se ha calibrado. Este usuario permite ingresar el equipo una vez más.</h4> </p>";
    //                 $("#alerta_informevalidacion").before(
    //                     "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-info alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-warning'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
    //             }
    //             else{                           
    //                 $("[type='submit']").attr('disabled','disabled');              
    //                 $("[name='informevalidacion']").remove();
    //                 var valor= "<p> <h4>El equipo aún no se ha calibrado. ¿Estas seguro de ingresar el equipo una vez más?</h4> <button type='button' class='btn btn-default' data-toggle='modal' data-target='#modal-default'>Confirmar <i class='fa fa-check fa-lg'></i> </button> </p>";
    //                 $("#alerta_informevalidacion").before(
    //                     "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-info alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-warning'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
    //             }
    //         }else if( porciento < 80 ){
    //             if(usuario_permiso==1){
    //                 $("[name='informevalidacion']").remove();
    //                 var valor= "<p> <h4>La fecha de vencimiento aún no culminá. Este usuario permite ingresar el equipo una vez más.</p>";
    //                 $("#alerta_informevalidacion").before(
    //                     "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-danger alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-warning'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");   
    //             }
    //             else{
    //             $("[type='submit']").attr('disabled','disabled');              
    //             $("[name='informevalidacion']").remove();
    //             var valor= "<p> <h4>La fecha de vencimiento aún no culminá. ¿Estas seguro de ingresar el equipo una vez más?</h4> <button type='button' class='btn btn-default' data-toggle='modal' data-target='#modal-default'>Confirmar <i class='fa fa-check fa-lg'></i> </button> </p>";
    //             $("#alerta_informevalidacion").before(
    //                 "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-danger alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-warning'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
    //             }
    //         }
    //         else{
    //             $("[name='informevalidacion']").remove();           
    //         }                                          
    // }       

    function validar_ultimacal(datehome,dateend){
        var value=0;
        if(datehome == null){
            value=0;
        } else{
            var dateA= moment(datehome);
            var dateB= moment(dateend);
            var datehoy= moment();
    
            var diastotal= dateB.diff(dateA, 'days');
            var diastranscurridos= datehoy.diff(dateA, 'days');
            value= ((diastranscurridos*100)/diastotal);                             
        }              
        return value;
    }

    function validar_usuario_confirmar(){
        var result=0;
        $.ajax({            
            url: "?c=recepcion&a=ajax_load_usuario_confirmar",
            dataType: "json",
            method: "POST",
            data: "",
            async: false,
            success: function(data) {
                var datos = data[0].accesoconfirmar;             
               result = datos;
            },
            error: function(data) {
                result = 0;
            },
        });             
        return result;
    }   

/* End asignar_equipo_cliente */

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

  var empresa_ajax_r = function() {

      $.ajax({
          url: "?c=recepcion&a=ajax_load_plantas",
          dataType: "json",
          method: "POST",
          data: "idempresa=" + $(".select2").val()
      }).done(function(data) {
          var datos = data;        
          var select = $('#idplanta_ajax_r');
          select.empty();
            select.append($("<option >").val('').text('Seleccione una opción'));
          $.each(datos, function() {
              select.append($("<option >").val(this.id).text(this.nombre));
          });                  
          
          if (planta_temp.length > 0) {
            $('#idplanta_ajax_r').val(planta_temp).change();
            planta_temp = "";
          } 

            if(datos.length == 1){
            var optplanta= datos[0]['id'];
            $('#idplanta_ajax_r').val(optplanta).change();            
            }
            else{
                $('#direccion_planta').text('...'); 
            }          
        //   else  {
        //       $('#idplanta_ajax_r').val('').change();
        //   }     

      }).fail(function(data) {}).always(function(data) {
          // console.log(data);
      });
    }

    var idplanta_ajax_r = function() {
        var dato= $('#idplanta_ajax_r').val();
        if(dato != ""){
            $.ajax({
                url: "?c=recepcion&a=ajax_load_cliente",
                dataType: "json",
                method: "POST",
                data: "idplanta=" + dato
            }).done(function(data) {
                var datos = data;
                //console.log(datos);
                var label = $('#direccion_planta');
                label.empty();
                if (datos[0]['address'] != null){                    
                    label.append($('#direccion_planta').text(datos[0]['address']));
                    label.addClass('control-label pull-left');
                }else{                    
                    label.append($('#direccion_planta').text('Sin dirección'));
                    label.addClass('control-label pull-left');
                }  
                var label = $('#alias_planta');
                label.empty();
                if (datos[0]['alias'] != null){                    
                    label.append($('#alias_planta').text(datos[0]['alias']));
                    label.addClass('control-label pull-left');
                }else{                    
                    label.append($('#alias_planta').text('...'));
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
    
        

/*  End empresa_ajax_r  */

/* Para capturar factura previa */
  var factura_previa = function() {    
    var informe= $("#numero_informe").val(); 
    if(informe=="" || informe== undefined || informe== null)
    {
        alert("No hay número de informe, generar número informe porfavor.");          
    }  
    else {
          var url = "?c=factura&a=index&p="+informe;
        //console.log(url);
        window.open(url, '_blank');
    }                 
  }
/* End Factura previa */

/* Buscar P.O */
  var buscar_po = function() {
    if (validar_text($("#po_id").val()) == true) {           
        $.ajax({
            url: "?c=recepcion&a=ajax_load_po",
            dataType: "json",
            method: "POST",
            data: "po_id=" + $("#po_id").val()
        }).done(function(data) {
            var datos = data;               
            if (datos.length > 0) {
                $('#cantidad').val(datos[0].cantidad);
                alertas_tipo_valor('alerta_po', 'correcto', '');
            } else {
                alertas_tipo_valor('alerta_po', 'vacio', '');
            }
        }).fail(function(data) {}).always(function(data) {
            // console.log(data);
        });
    } else {
        alertas_tipo_valor('alerta_po', 'requerido', 'P.O');
    }
  }    
/* END Buscar P.O */

/* Buscar Hoja de entrada */
  var buscar_hoja_entrada = function() {
    if (validar_text($("#num_hojaent").val()) == true) {
        if ($("#num_hojaent").val().substr(0,4)!="0000") { //evitar la busqueda de los números de hoja con '0000'
            $.ajax({
            url: "?c=recepcion&a=ajax_load_hoja_entrada",
            dataType: "json",
            method: "POST",
            data: "hojas_entrada_id=" + $("#num_hojaent").val()
            }).done(function(data) {
            var datos = data;
            //console.log(datos);
            if (datos.length > 0) {
                $('#num_hojaent').val(datos[0].numero_hoja);
                $('#usuarios_id').val(datos[0].usuarios_id).change(); // librerias de query -> select2                 
                $('#fecha').datepicker({ autoclose: true, format: 'yyyy-mm-dd' }).datepicker("setDate", datos[0].fecha);
                alertas_tipo_valor('alerta_hojaentrada', 'correcto', '');
            } else {
                alertas_tipo_valor('alerta_hojaentrada', 'vacio', '');
            }
            }).fail(function(data) {}).always(function(data) {
                //console.log(data);
            }); 
        }        
    } else {
        alertas_tipo_valor('alerta_hojaentrada', 'requerido', 'número de hoja entrada');
    }
    }
/* End Buscar Hoja de entrada */

/* Segun las opciones de calibracion asigna de las demas opciones de datos de P.O, Hoja de entrada */
  function opciones_calibraciones(sucursal_temp) {
    var activo_local = [0, 0, 0];
    var sucursales = "";
    $('#calibraciones_id option:selected').each(function() {
        var $this = $(this);
        if ($this.length) {
            sucursales = $this.text().toLowerCase().trim();
        }
    });
    
    if (sucursal_temp == sucursales) {
        opciones_po('no_registrar');
        opciones_hoja_entrada('registrar');
        if (sucursales == "nogales") { activo_local[0] = 1 }
        if (sucursales == "hermosillo") { activo_local[1] = 1 }
        if (sucursales == "guaymas") { activo_local[2] = 1 }
    } else if (activo_local[0] == 0 && sucursales == "nogales") {
        opciones_po('no_registrar');
        opciones_hoja_entrada('no_registrar');
    } else if (activo_local[1] == 0 && sucursales == "hermosillo") {
        opciones_po('no_registrar');
        opciones_hoja_entrada('no_registrar');
    } else if (activo_local[2] == 0 && sucursales == "guaymas") {
        opciones_po('no_registrar');
        opciones_hoja_entrada('no_registrar');
    } else if (sucursales == "externa") {
        opciones_po('registrar');
        opciones_hoja_entrada('no_registrar');
    } else if (sucursales == "ventas") {
        opciones_po('no_registrar');
        opciones_hoja_entrada('registrar');
    } else {
        opciones_po('registrar');
        opciones_hoja_entrada('registrar');
    }
  }
/*  End Opciones de calibraciones */

/*  Opciones para registrar PO*/
  function opciones_po(opciones){

    var op=['no_registrar','pendiente','registrar'];
    $( "#btn_registrar_po" ).prop( "disabled", false );
    $( "#btn_pendiente_po" ).prop( "disabled", false );
    $( "#btn_noregistrar_po" ).prop( "disabled", false );

    //$( "#id_po" ).prop( "disabled", false ).val('');
    $( "#buscar_po" ).removeClass( "disabled");
    //$( "#cantidad" ).prop( "disabled", false ).val('');       
    // no registrar
    if (op[0]==opciones) {            
        $( "#btn_noregistrar_po" ).prop( "disabled", true );          

        $( "#po_id" ).val('N/A');
        $( "#buscar_po" ).addClass( "disabled");
        $( "#cantidad" ).val('0');
    }
    //pendiente
    else if(op[1]==opciones) {                     
        $( "#btn_pendiente_po" ).prop( "disabled", true );            

        $( "#po_id" ).val('pendiente');
        $( "#buscar_po" ).addClass( "disabled");
        $( "#cantidad" ).val('0');
    }
        //registrar
    else if (op[2]==opciones) {            
        $( "#btn_registrar_po" ).prop( "disabled", true );            
    }    
  }
/* End Opciones de PO */

/*  Opción de la hoja de entrada*/
  function opciones_hoja_entrada(opciones) {

    var op = ['no_registrar', 'registrar'];
    $("#btn_registrar_hojae").prop("disabled", false);
    $("#btn_noregistrar_hojae").prop("disabled", false);
    $("#buscar_hoja_entrada").removeClass("disabled");
    // no registrar
    if (op[0] == opciones) {
        $("#btn_noregistrar_hojae").prop("disabled", true);
        var anio = (new Date).getFullYear();
        $("#num_hojaent").val('0000-'+anio.toString().substr(-2));
        $("#buscar_hoja_entrada").addClass("disabled");
       
        $("#fecha").datepicker({ autoclose: true, format: 'yyyy-mm-dd' }).datepicker('setDate', 'today');
    }
    //registrar
    else if (op[1] == opciones) {
        $("#btn_registrar_hojae").prop("disabled", true);
    }
  }
/* End Opciones de Hoja de entrada */

/* Opciones para datos de factura */
  function opciones_factura(opciones) {
    var op = ['no_registrar', 'registrar'];
    $("#btn_registrar_factura").prop("disabled", false);
    $("#btn_noregistrar_factura").prop("disabled", false);        
    // no registrar
    if (op[0] == opciones) {
        $("#btn_noregistrar_factura").prop("disabled", true);
        $("#precio").val('0');
        $("#precio_extra").val('0');           
        $("#factura").val('Sin factura');
        $("#monedas_id").val('1').change();            
    }
    //registrar
    else if (op[1] == opciones) {
        $("#btn_registrar_factura").prop("disabled", true);        
    }
  }
/* End Opciones de datos de factura */

/* Submit de acceso */
function submit_acceso() {
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value; 
    var validado= true;                 
    
    if(email =="" || email === null ){validado=false;}
    if(password== "" || password === null ){validado=false;}
    
    if(validado == true){
        var $logModal = $('#modal-default');
        var parametro= {                  
            'email': email.trim(),
            'password': password.trim()
        };
        $.ajax({
            url: "?c=login&a=ajax_load_acceso",
            dataType: "json",
            method: "POST",
            data: parametro
        }).done(function(data) {
            var datos = data;
            if(datos=="exitoso"){
                $('[type="submit"]').removeAttr('disabled');
                $logModal.modal('hide');
                $("[name='informevalidacion']").remove();
            }
            else{
                $("[name='alerta_validacion']").remove();
                $("#validacion").before(
                "<div class='form-group' name='alerta_validacion'> <div class='col-sm-12'> " + "<div class='alert alert-danger alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-ban'></i> Alerta!</h4>" + datos + "</div>" + "</div>" + "</div>");                    
            }                                           
        }).fail(function(data) {}).always(function(data) {
            //console.log(data);             
        });                                           
    }else{
        $("[name='alerta_validacion']").remove();
        $("#validacion").before(
        "<div class='form-group' name='alerta_validacion'> <div class='col-sm-12'> " + "<div class='alert alert-danger alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-ban'></i> Alerta!</h4>" + "Campo requerido,favor de ingresar información. Intente una vez más." + "</div>" + "</div>" + "</div>");                    
    }              
}
/* Submit de acceso */
  
  $(document).ready(function() {
        
    /**
 *  Modulo de busqueda de historial y equipo
*/
    var buscar_historialequipo = function () {
        //count_check_equipo=0;

        // $('[type="submit"]').removeAttr('disabled');
        // $("[name='informevalidacion']").remove();

        $('#overlay').addClass('overlay');
        $('#refresh').addClass('fa fa-refresh fa-spin');

        if (validar_text($("#idequipo").val().trim())== true) {          

            $.ajax({
                url: "?c=recepcion&a=ajax_load_historial",
                dataType: "json",
                method: "POST",
                data: "idequipo=" + $("#idequipo").val().trim()                
            }).done(function (data) {
                var datos = data;   
                //console.log(datos);              
                if (datos.length > 0) {                                                                  
                    _table2.clear();
                    _table2.rows.add(datos).draw();              
                }                 
                buscar_tablaequipo($("#idequipo").val().trim());

                $('#overlay').removeClass('overlay');
                $('#refresh').removeClass('fa fa-refresh fa-spin');

            }).fail(function (data) {
            }).always(function (data) {
                //console.log(data);
            });
        } 
        else{
            alertas_tipo_valor('alerta_idequipo','requerido','id del equipo');
            $('#overlay').removeClass('overlay');
            $('#refresh').removeClass('fa fa-refresh fa-spin');               
        }        
    };

    var buscar_tablaequipo = function(val) {
        if (val != null || val != '') {
            $.ajax({
                url: "?c=recepcion&a=ajax_load_equipo",
                dataType: "json",
                method: "POST",
                data: "idequipo=" + val
            }).done(function(data) {
                var datos = data;  
               // console.log(datos);              
                if (datos.length > 0) {
                    _table.clear();
                    _table.rows.add(datos).draw();
                    if(datos.length ==1){
                        $("input[type='radio'][name='r1'][value='"+datos[0]['id']+"']").prop('checked', true); 
                        //$("#historial_informes tbody, input[type='radio'][value='"+datos[0]['id']+"']").prop('checked', true); 
                        comprobar_informeequipo(datos[0]['id']);
                    }                  
                } else{
                    alertas_tipo_valor('alerta_idequipo', 'vacio', "<p><a href='?c=equipos&a=add' target='_blank' class='btn btn-primary' style='text-decoration:none;'><i class='fa fa-plus-circle'></i> &nbsp; Agregar equipo</a></li></p>");
                }          

            }).fail(function(data) {}).always(function(data) {
                // console.log(data);
            });
        } else {
            alertas_tipo_valor('alerta_idequipo', 'requerido', 'id del equipo');
        }
    };

    var comprobar_informeequipo = function(val) {
        $("[name='informevalidacion']").remove();
            $.ajax({
                url: "?c=recepcion&a=ajax_load_ultimoid_equipo",
                dataType: "json",
                method: "POST",
                data: "idequipo=" + val
            }).done(function(data) {
                var datos = data;  
                //console.log(datos);             
                if (datos.length > 0) { 
                    if(datos[0]['reqautorizacion'] == 0){
                        //Evalua si el equipo se encuentra repetido
                        if(datos[0]['id'] != informe){
                            if(datos[0]['proceso'] < 4){
                                var proceso=["Inicio","Calibración","Salida","Facturación","Finalizado"];
                                $("[name='informevalidacion']").remove();
                                var valor= "<p>Este equipo está en proceso de  <span class='badge bg-red'>"+ proceso[datos[0]['proceso']]+"</span> .";                                
                                 valor += "</br> Si deseas registrarlo nuevamente en este informe, el sistema enviara la solicitud a tu supervisor. </br> ";
                                 valor += "Puedes continuar llenado la información, y esperar la autorización.</p>";
                                $("#alerta_informevalidacion").before(
                                    "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-warning alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-warning'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
                                //Cambio de boton de submit

                                //console.log("No se puede registrar ya que este equipa esta en proceso : "+ datos[0]['proceso']);                            
                            }else{
                                var statusequipo= validar_ultimacal(datos[0]['fecha_calibracion'], datos[0]['fecha_vencimiento']);                                                                
                                if(statusequipo< 80){
                                    $("[name='informevalidacion']").remove();
                                var valor= "<p>Este equipo se encuentra calibrado y su periodo aún no está vencido. El porcentaje esta en <span class='badge bg-red'>"+ Math.round(statusequipo) +"%</span>.";                                
                                 valor += "</br> Si deseas registrarlo nuevamente en este informe, el sistema enviara la solicitud a tu supervisor. </br> ";
                                 valor += "Puedes continuar llenado la información, y esperar la autorización.</p>";
                                $("#alerta_informevalidacion").before(
                                    "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-warning alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-warning'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
                                //Cambio de boton de submit
                                }else{
                                    var valor="";
                                    if(statusequipo > 100){
                                        valor= "<p>Puedes ingresar el equipo seleccionado sin problema. Pero este equipo ha superado su fecha de vencimiento. <span class='badge bg-red'> Ingrésalo urgentemente</span></p>";
                                    }
                                    else{
                                        valor= "<p>Puedes ingresar el equipo seleccionado sin problema. Ya que esta próximamente a vencer.</p>";
                                    }                                                                        
                                    $("#alerta_informevalidacion").before(
                                        "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-success alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-check'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
                                        //Cambio de boton de submit= Registrar
                                    //console.log("Sin problema, puede ingresar el equipo");
                                }                               
                            }
                        } else{
                            var valor= "<p>Puedes ingresar el equipo seleccionado sin problema.</p>";                                
                            $("#alerta_informevalidacion").before(
                                "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-success alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-check'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
                                //Cambio de boton de submit= Registrar
                            //console.log("Este equipo corresponde al informe, se ignora las validaciones.");
                        }
                    }else if(datos[0]['reqautorizacion'] == 1){
                        var valor= "<p>Este informe está en espera que se autorice para ingresar el equipo duplicado. <br> Si deseas ingresar otro id, solicita cancelar la solicitud a tu supervisor.</p>";
                        $("#alerta_informevalidacion").before(
                        "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-danger alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-ban'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
                            //Cambio de boton de submit= desabilitar

                        //No se permitira registrar, ya que se encuentra en espera de autorizacion
                        //console.log("Equipo en espera de autorizacion");
                    }
                    else if(datos[0]['reqautorizacion'] == 2){
                        var valor= "<p>Equipo repetido, pero está autorizado para registrarlo.</p>";                                
                        $("#alerta_informevalidacion").before(
                            "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-info alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-info'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
                        //Enviar una alerta de que este equipo esta repetido, pero ya esta autorizado
                        console.log("Equipo repetido, pero autorizado");
                    }                       
                }else{
                    var valor= "<p>Puedes ingresar el equipo seleccionado sin problema. No se encontró ninguna coincidencia con algún informe.</p>";
                    $("#alerta_informevalidacion").before(
                        "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-success alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-check'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
                        //Cambio de boton de submit= Registrar
                }
                
            }).fail(function(data) {}).always(function(data) {
                // console.log(data);
            });       
    };

    // $('[type="submit"]').prop('disabled', true);
    // $('[type="submit"]').prop('disabled', false);
/**
* Final Modulo de busqueda de historial y equipo
*/

    $("#refresh_informe").click(function(e){
      ultimo_numero_informe();
      e.preventDefault();
    });
   
    $("#buscar_idequipo").on('click', buscar_historialequipo);

    $("#idequipo").keypress(function(e) {
      if (e.which == 13) {   
        $(this).val(espacio_blanco($(this).val()));      
          //buscar_idequipo_historial();
          buscar_historialequipo();
          e.preventDefault();
      }
    });

    ultimo_numero_informe();

    // # Home Recepción   
    $("#empresa_ajax_r").on('change', empresa_ajax_r);        

    $("#factura_previa").click(function(e){
      factura_previa();
      e.preventDefault();
    });    

    $("#calibraciones_id").on('change', retorna_session_planta);
   
    $("#empresa_ajax").on('change', empresa_ajax);
    $("#idplanta_ajax_r").on('change', idplanta_ajax_r);

    /**  # Datos de P.O **/
    $("#btn_noregistrar_po").click(function(e){           
        opciones_po('no_registrar');
        e.preventDefault();
      });

      $("#btn_pendiente_po").click(function(e){           
        opciones_po('pendiente');
        e.preventDefault();
      });

      $("#btn_registrar_po").click(function(e){           
        opciones_po('registrar');
        e.preventDefault();
      });

    $("#buscar_po").on('click', buscar_po);

    $("#po_id").keypress(function(e) {
        if (e.which == 13) {
            $(this).val(espacio_blanco($(this).val()));      
            buscar_po();
            e.preventDefault();
        }
    });
    /**  # Hoja de entrada  **/
    $("#btn_noregistrar_hojae").click(function(e){           
        opciones_hoja_entrada('no_registrar');
        e.preventDefault();
      });

      $("#btn_registrar_hojae").click(function(e){           
        opciones_hoja_entrada('registrar');
        e.preventDefault();
      });     

    $("#buscar_hoja_entrada").on('click', buscar_hoja_entrada);
    
    $("#num_hojaent").keypress(function(e) {
        if($(this).val().length==4)
        {
            var anio = (new Date).getFullYear();            
            var numero=$(this).val();
            numero.replace(numero);            
            $(this).val(numero+'-'+anio.toString().substr(-2));
            e.preventDefault();                      
        }
        if (e.which == 13) {
            $(this).val(espacio_blanco($(this).val()));      
            buscar_hoja_entrada();
            e.preventDefault();
        }                      
    });

    /**  # Datos de P.O **/    

    /**  # Datos iniciales **/
    opciones_po("registrar");
    opciones_hoja_entrada("registrar");
    opciones_factura("registrar");

    $("#btn_registrar_factura").click(function(e){
        opciones_factura('registrar');
        e.preventDefault();
      });

    $("#btn_noregistrar_factura").click(function(e){
    opciones_factura('no_registrar');
    e.preventDefault();
    });        
        
    var currDate = new Date();
    $('.datepickerhome').datepicker({
        format: 'yyyy-mm-dd',                       
        autoclose: true,
        startDate : currDate, //endD,
        // endDate : endD
    }).datepicker('setDate', 'today');  
    
    var _table = $("#table_equipo").DataTable({
        "deferRender": true,                                                
        "lengthMenu": [[5, 10], [5, 10]],
        "autoWidth": true,
        "scrollX": true,                                              
        "scrollY": "200px",
        "scrollCollapse": true,
        fixedColumns: true,
        fixedHeader: true,
        "columns": [
            { "data": 'id'},
            { "data": 'alias'},
            { "data": 'descripcion'},
            { "data": 'marca'},
            { "data": 'modelo'},
            { "data": 'serie'},
            { "data": 'activo'},
            { "data": 'id'}
        ],"columnDefs": [            
            {
                targets: 0,
                render: function (data, type, row) {
                    var _input="";
                    _input='<input type="radio" name="r1" value="'+ row['id'] +'">';
                    return _input;
                },                
                orderable: false,
                searchable: false
            },
            {
                targets: 6,
                render: function (data, type, row) {
                    var _input="";
                    var activo=["Inactivo","Activo"];
                    var bgcolor=["bg-red","bg-green"];
                    _input='<span class="pull-right badge '+bgcolor[row['activo']] +'">'+ activo[row['activo']]+'</span>'
                    if (type === 'display') {
                        _input=_input; 
                    }
                    return _input;                   
                },                
                orderable: false,
                searchable: false
            },           
            {                
            "targets": 7,
            'render': function(data, type, row, meta){                    
                    var menu="<a href='?c=equipos&a=edit&p="+row['id']+"' target='_black' class='btn btn-social-icon badge bg-yellow pull-right' data-original-title='Editar Equipo'><i class='fa fa-pencil'></i></a>";
                    return menu;
                    },
                "orderable": false
            } ], 
        'order': [[1, 'asc']]                                                                   
});

    var _table2 = $("#table_historial").DataTable({
            "deferRender": true,                                                
            "lengthMenu": [[5, 10], [5, 10]],
            "autoWidth": true,
            "scrollX": true,                                              
            "scrollY": "300px",
            "scrollCollapse": true,
            fixedColumns: true,
            fixedHeader: true,
            "columns": [
                { "data": 'id'},
                { "data": 'id'},  
                { "data": 'alias'}, 
                { "data": 'descripcion'}, 
                { "data": 'marca'}, 
                { "data": 'modelo'}, 
                { "data": 'serie'}, 
                { "data": 'empresa'},                
                { "data": 'planta'},
                { "data": 'fecha_calibracion'},
                { "data": 'periodo_calibracion'},
                { "data": 'fecha_vencimiento'},
                { "data": 'tecnico_cal_email'},
                { "data": 'acreditacion'},
                { "data": 'proceso'}
            ],"columnDefs": [                
                {
                targets: 0,
                render: function (data, type, row) {
                    var _input="";
                    _input='<input type="radio" name="r2" value="'+ row['id'] +'">';
                    // if(row['proceso'] < 4 ){
                    //     _input= '<input type="checkbox" class="editor-historial" value="'+ row['id'] +'" disabled>';
                    // }else{
                    //     _input='<input type="checkbox" class="editor-historial" value="'+ row['id'] +'">';
                    // }                 
                    return _input;                    
                },                
                orderable: false,
                searchable: false
            },{
                targets: 13,
                render: function (data, type, row) {
                    var proceso=["Inicio","Calibración","Salida","Facturación","Finalizado"];
                    var bgcolor=["bg-red","bg-yellow","bg-aqua","bg-blue","bg-green"];
                    return '<span class="pull-right badge '+bgcolor[row['proceso']] +'">'+ proceso[row['proceso']]+'</span>';
                },                
                orderable: false,
                searchable: false  
            }
            // {
            //   "targets": 0,
            //   "orderable": false
            //   } 
            ], 
            'order': [[1, 'asc']]                                                                  
    });
      
    if(getalias != ""){                
        buscar_tablaequipo(getalias);
    }
    
    $("#table_equipo tbody").on("change", "input[type='radio'][name='r1']", function(){
        if(this.checked){            
            var val = $("input[type='radio'][name='r1']:checked").val(); 
           comprobar_informeequipo(val); 
        }              
    });    

    $("#table_historial tbody").on("change", "input[type='radio'][name='r2']", function(){
        if(this.checked){
            var val = $("input[type='radio'][name='r2']:checked").val(); 
            console.log(val);
            //comprobar_informeequipo(val); 
               var datos= [];                    
                //console.log(catch_ids[i]);
                _table2.rows().eq(0).each( function ( index ) {
                    var row = _table2.row(index);                        
                    var data = row.data();
                   // console.log(data);  
                    if(val == data['id']){
                        datos.push(data);                         
                    }                            
                });                      

                console.log(datos[0]);
                $("input[type='number'][name='periodo_calibracion']").val(datos[0]['periodo_calibracion']);
                $("#periodo_id").val(datos[0]['periodo_id']);

                $("#acreditaciones_id").val(datos[0]['acreditaciones_id']).change();
                $("#usuarios_calibracion_id").val(datos[0]['usuarios_calibracion_id']).change();
                $("#calibraciones_id").val(datos[0]['calibraciones_id']).change();
                $("#empresa_ajax_r").val(datos[0]['empresas_id']).change();
                planta_temp= datos[0]['plantas_id'];

                //$("#idplanta_ajax_r").val(datos[0]['plantas_id']).change();
                

                // 
                // datos[0]['calibraciones_id']
                // datos[0]['calibrado_por']
                // datos[0]['periodo_calibracion']
                // datos[0]['periodo_id'] // Meses o dias
                // datos[0]['empresas_id']
                // datos[0]['plantas_id']
                



        }              
    }); 

   
   

}); 
  