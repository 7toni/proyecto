/* Inicio de variables de recepción */    
    //var count_check_equipo = 0;
    var count_numinforme=0;
    var planta_temp = "";  
    var detalles="";  
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

        //$('[type="submit"]').removeAttr('disabled');
        $("[name='informevalidacion']").remove();
            activarcargando(1);
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

                activarcargando(0);

            }).fail(function (data) {
            }).always(function (data) {
                //console.log(data);
            });
        } 
        else{
            alertas_tipo_valor('alerta_idequipo','requerido','id del equipo');
            activarcargando(0);              
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
                        comprobar_informeequipo(datos[0]['id']);
                    }else if(getidequipo != null){
                        $("input[type='radio'][name='r1'][value='"+getidequipo+"']").prop('checked', true);  
                        comprobar_informeequipo(getidequipo);
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
        // Agregar un validacion de equipo mas informe, ya que solo valida el etatus del equipo, pero no juntamente con el informe
            
            var numinforme= $("#numero_informe").val();
            var reqaut_infactual= reqautorizacion;
            var proceso_infactual= proceso;
            var equipo_infactual= getidequipo;
            var valuesubmit=["Actualizar","En espera de autorización","Actualizar","Estado [requiere autorización]", "Solicitar registro","Solicitar registro","Registrar","Actualizar","Actualizar"]; 
            var tiposubmit= ["actualizar","sinpermiso","actualizaraut","sinpermiso","solicitud","solicitud","registrar","actualizar","actualizar"];
            var disabledsubmit= [false,true,false,true,false,false,false,false,false];
            var disablebusqueda= [false,true,true,true,false,false,false,false,false];
            var btncolor=["btn-warning","btn-danger","btn-info","btn-danger","btn-warning","btn-warning","btn-primary","btn-warning","btn-warning"];
            var valuealerta=[
                "Este equipo corresponde a este informe, puedes hacer alguna modificación en los datos del Cliente, PO, datos de calibración, en la hoja de entrada o cambiar de equipo, siempre y cuando este disponible.",
                "Este informe está en espera que se autorice para ingresar el equipo duplicado. Si deseas ingresar otro id, solicita cancelarlo a tu supervisor.",
                "Este equipo corresponde a este informe, está autorizado para continuar con el proceso de registro.",
                "Este Equipo no se puede usar, ya que esta se encuentra en un estado que requiere autorización. Si deseas ingresar este equipo, solicita cancelar el informe que tiene asignado, a tu supervisor.",                
                "Este Equipo no se puede usar, ya que esta se encuentra vigente en su fecha de calibración. Pero, si deseas ingresar este equipo, solicita la autorización a tu supervisor.",
                "Este Equipo no se puede usar, ya que esta se encuentra en proceso. Pero, si deseas ingresar este equipo, solicita la autorización a tu supervisor.",
                "Este Equipo ha superado su fecha de vencimiento <span class='badge bg-red'> URGENTE! </span>. Puedes ingresar el equipo ya que este informe no tiene asignado ningun otro equipo.",
                "Este Equipo ha superado su fecha de vencimiento <span class='badge bg-red'> URGENTE! </span>. <h3> Ojo! </h3> Este informe ya tiene asigando otro equipo, pero puedes actualizarlo.",
                "<h3> Ojo! </h3> Este informe tiene asignado otro equipo y se encuentra en proceso, pero puedes actualizarlo."
            ];

            $.ajax({
                url: "?c=recepcion&a=ajax_load_ultimoid_equipo",
                dataType: "json",
                method: "POST",
                data: "idequipo=" + val
            }).done(function(data) {
                var datos = data;                                                               
                //Si el datos.length es igual a cero, quiere decir que no tiene ningun informe asociado.                
                    if (datos.length > 0) {
                        var num_infbuscado= datos[0]['id'];
                        var equipo_infbuscado= datos[0]['idequipo'];
                        var proceso_infbuscado= datos[0]['proceso'];
                        var reqauto_infbuscado= datos[0]['reqautorizacion'];
                        var vigencia_infbuscado= "";  
                        if(proceso_infbuscado == 4){
                            vigencia_infbuscado= validar_ultimacal(datos[0]['fecha_calibracion'], datos[0]['fecha_vencimiento']);
                        }                                              

                        // Revisar si el informe actual es igual al encontrado
                        if(numinforme == num_infbuscado && equipo_infactual == equipo_infbuscado){
                            //Este alerta es para los informes que pasaron a un estado de reqautizacion                            
                            if(reqaut_infactual > 0 && proceso_infactual < 4){
                                //alerta                                                            
                                $("[name='informevalidacion']").remove();
                                alertas_col12('alerta_equipoinforme', 'warning', valuealerta[reqaut_infactual] );                            
                            }else if(proceso_infactual < 4){
                                $("[name='informevalidacion']").remove();
                                alertas_col12('alerta_equipoinforme', 'info', valuealerta[reqaut_infactual] );                            
                            }else if(proceso_infactual == 4){
                                $("[name='informevalidacion']").remove();
                                alertas_col12('alerta_equipoinforme', 'info',  "Este equipo corresponde a este informe y finalizado el proceso, si deseas realizar alguna actualización esta permitido." );
                            }                           
                            
                            //Submit
                            $('[type="submit"]').prop('disabled', disabledsubmit[reqaut_infactual]);                             
                            $('[type="submit"]').prop('value', valuesubmit[reqaut_infactual]);
                            $('[name="tiposubmit"]').prop('value',tiposubmit[reqaut_infactual]);
                            $('[type="submit"]').removeClass('btn-primary').addClass(btncolor[reqaut_infactual]);
                            
                            //Opciones de busqueda
                            $('#buscar_idequipo').prop('disabled', disablebusqueda[reqaut_infactual]);
                            $('#idequipo').prop('disabled', disablebusqueda[reqaut_infactual]);                            
                            
                        }else if(numinforme != num_infbuscado){ //Analizar cuando un equipo o el informe no son iguales, 
                            var numtemp=0;                            
                            /**
                             * 1. Revisar si el equipo esta asignado a un informe que esta en proceso
                             * 2. Revisar si el equipo esta asignado a un informe que no ha finalizado su vigencia de calibracion.
                             * 3. Revisar si el equipo no se encuentra en proceso de autorizacion.
                             * 4. Revisar si el informe no tiene asignado un equipo ya. 
                             */
                            if(reqauto_infbuscado == 0){
                                if(proceso_infbuscado < 4 && proceso_infactual<4){
                                    numtemp=5;
                                    $("[name='informevalidacion']").remove();
                                    alertas_col12('alerta_equipoinforme', 'warning', valuealerta[numtemp] );                                     
                                    detalles= usuario + "_"+"Último número de informe ("+ num_infbuscado +") encontrado que pertenece al cliente "+  datos[0]['empresa'] +","+  datos[0]['planta']  +", el proceso actual es "+ datos[0]['proceso'];

                                } else if(proceso_infbuscado>3  && vigencia_infbuscado > 100  && equipo_infactual == ""){
                                    numtemp=6;
                                    $("[name='informevalidacion']").remove();
                                    alertas_col12('alerta_equipoinforme', 'warning', valuealerta[numtemp]);
                                }
                                else if( proceso_infbuscado>3  && vigencia_infbuscado > 100  && proceso_infactual < 4 && equipo_infactual != null ){
                                    numtemp=7;
                                    $("[name='informevalidacion']").remove();
                                    alertas_col12('alerta_equipoinforme', 'warning', valuealerta[numtemp]);
                                }                             
                                else if(vigencia_infbuscado < 80 ){
                                    numtemp=4;
                                    $("[name='informevalidacion']").remove();
                                    alertas_col12('alerta_equipoinforme', 'warning', valuealerta[numtemp] );                                    
                                    detalles= usuario + "_"+"Último número de informe ("+ num_infbuscado +") encontrado que pertenece al cliente "+  datos[0]['empresa'] +","+  datos[0]['planta']  +", con fecha de vencimiento :"+  datos[0]['fecha_vencimiento'];
                                } 
                                                          

                                $('[type="submit"]').prop('disabled',disabledsubmit[numtemp] );
                                $('[type="submit"]').prop('value', valuesubmit[numtemp]);
                                $('[name="tiposubmit"]').prop('value',tiposubmit[numtemp]);
                                $('[type="submit"]').removeClass('btn-primary').addClass(btncolor[numtemp]);

                            }
                            else{                           
                                //alerta 
                                if(reqauto_infbuscado > 0 && proceso_infbuscado < 4){
                                    numtemp=3;
                                    $("[name='informevalidacion']").remove();
                                    alertas_col12('alerta_equipoinforme', 'warning', valuealerta[numtemp] );                                    
                                }                              
                                else if( reqauto_infbuscado > 0 && vigencia_infbuscado < 80){
                                    numtemp=4;
                                    $("[name='informevalidacion']").remove();
                                    alertas_col12('alerta_equipoinforme', 'warning', valuealerta[numtemp] );
                                    detalles= usuario + "_"+"Último número de informe ("+ num_infbuscado +") encontrado que pertenece al cliente "+  datos[0]['empresa'] +","+  datos[0]['planta']  +", con fecha de vencimiento :"+  datos[0]['fecha_vencimiento'];
                                }                             

                                $('[type="submit"]').prop('disabled',disabledsubmit[numtemp] );
                                $('[type="submit"]').prop('value', valuesubmit[numtemp]);
                                $('[name="tiposubmit"]').prop('value',tiposubmit[numtemp]);
                                $('[type="submit"]').removeClass('btn-primary').addClass(btncolor[numtemp]);
                            }                            

                        }                 
                    }else{
                        // Comprobar si el informe actual tiene alguna restriccion, por ejemplo que este esperando alguna autorizacion y sea haya confirmado
                        if(reqautorizacion === null || reqautorizacion === "0"){
                            var valor= "<p>Puedes ingresar el equipo seleccionado sin problema. No se encontró ninguna coincidencia con algún informe.</p>";
                            alertas_col12('alerta_equipoinforme', 'success', valor );                    
                            //Cambio de boton de submit= Registrar
                            $('[type="submit"]').prop('value', 'Registrar');
                            $('[name="tiposubmit"]').prop('value','registrar');
                        }else{
                            var numtemp=0;    
                            
                            if(reqautorizacion == 2 ){
                                numtemp=3;
                                alertas_col12('alerta_equipoinforme', 'warning', valuealerta[numtemp] );                    
                                //Cambio de boton de submit= Registrar
                                $('[type="submit"]').prop('disabled', disabledsubmit[numtemp]);                             
                                $('[type="submit"]').prop('value', valuesubmit[numtemp]);
                                $('[name="tiposubmit"]').prop('value',tiposubmit[numtemp]);
                            }else{
                                numtemp=1;
                                alertas_col12('alerta_equipoinforme', 'warning', valuealerta[numtemp] );                    
                                //Cambio de boton de submit= Registrar
                                $('[type="submit"]').prop('disabled', disabledsubmit[numtemp]);                             
                                $('[type="submit"]').prop('value', valuesubmit[numtemp]);
                                $('[name="tiposubmit"]').prop('value',tiposubmit[numtemp]);
                            }
                           
                        }
                        
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
                    return _input;                    
                },                
                orderable: false,
                searchable: false
            },{
                targets: 14,
                render: function (data, type, row) {
                    var proceso=["Inicio","Calibración","Salida","Facturación","Finalizado"];
                    var bgcolor=["bg-red","bg-yellow","bg-aqua","bg-blue","bg-green"];
                    return '<span class="pull-right badge '+bgcolor[row['proceso']] +'">'+ proceso[row['proceso']]+'</span>';
                },                
                orderable: false,
                searchable: false  
            }           
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
            //console.log(val);           
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
                //console.log(datos[0]);
                $("input[type='number'][name='periodo_calibracion']").val(datos[0]['periodo_calibracion']);
                $("#periodo_id").val(datos[0]['periodo_id']);
                $("#acreditaciones_id").val(datos[0]['acreditaciones_id']).change();
                $("#usuarios_calibracion_id").val(datos[0]['usuarios_calibracion_id']).change();
                $("#calibraciones_id").val(datos[0]['calibraciones_id']).change();
                $("#empresa_ajax_r").val(datos[0]['empresas_id']).change();
                planta_temp= datos[0]['plantas_id'];
        }              
    }); 

    $("input[type='submit']").click ( function(){
        activarcargandosubmit(1);
        //Variable de validacion
          var validacion= true;    
        //Array de los campos capturados                      
          var parametro = {
             0:$("#numero_informe").val(),
             1:$("input[type='radio'][name='r1']:checked").val() ,
             2:$("#idplanta_ajax_r").val(),

             3:$("input[name='periodo_calibracion']").val(),
             4:$("#periodo_id").val(),

             5:$("#acreditaciones_id").val(),

             6:$("#usuarios_calibracion_id").val(),

             7:$("#calibraciones_id").val(),

             8:$("#po_id").val(),
             9:$("#cantidad").val(),

             10:$("input[type='radio'][name='prioridad']:checked").val(),

             11:$("input[name='num_hojaent']").val(),
             12:$("#usuarios_id").val(),
             13:$("input[name='fecha']").val(),                         
          };

          for(var i=0; i < 14; i++){  //Iteracion hasta 14
             if(validar(parametro[i]) == false){
              validacion= false;
             }
          }               

          if(validacion == true){                        
            parametro[14]=$("#tiposubmit").val(),
            parametro[15]=$("#proceso").val();

            var comentario= $('#comentario').val();            
            if(detalles == ""){
                parametro[16]=comentario;
            }else{
                if(comentario == "" || comentario== null){
                    comentario= "Sin comentarios";
                }
                parametro[16]= detalles + "_"+ comentario;
            }                             

            $.ajax({
              type: 'post',
              url: "?c=recepcion&a=ajax_store",                        
              data: parametro
            }).done(function(data) {
              var datos = data;              
              var obj= JSON.parse(datos);

              if(obj.title == "Exitoso"){
                var url=obj.data[0]['msg'];  
                //console.log(url);                             
                window.open(url,'_self'); 
              }else{
                var valor= obj.data[0]['msg'];
                alertas_col12('alertavalidacion', 'danger', valor );                    
              }             
              
              activarcargandosubmit(0);
            }).fail(function(data) {}).always( function(data) {
              //console.log(data);
              activarcargandosubmit(0);
            });

          }
          else{
            // Mostrar alerta de campos no ingresados o seleccionados
            var valor= "<p>Campo requerido, revisar que no existan campos vacios e intentelo una vez más.</p>";
            alertas_col12('alertavalidacion', 'danger', valor );
            activarcargandosubmit(0);
          }

      });  
   
    var validar= function(data) {
        var bool = true;
        if (data === "" || data === null || data=== 'undefined') {
            bool = false;
        }       
        return bool;
    }

    var activarcargando= function(activo){
        if(activo == 1){
          $('#overlay').addClass('overlay');
          $('#refresh').addClass('fa fa-refresh fa-spin');
        }else if(activo == 0){
          $('#overlay').removeClass('overlay');
          $('#refresh').removeClass('fa fa-refresh fa-spin');
        }         
    }

    var activarcargandosubmit= function(activo){
        if(activo == 1){
          $('#overlay_submit').addClass('overlay');
          $('#refresh_submit').addClass('fa fa-refresh fa-spin');
        }else if(activo == 0){
          $('#overlay_submit').removeClass('overlay');
          $('#refresh_submit').removeClass('fa fa-refresh fa-spin');
        }         
    }

}); 
  