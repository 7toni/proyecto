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

/* Buscar equipo */
    var buscar_idequipo_historial = function () {
        //count_check_equipo=0;
        
        $('[type="submit"]').removeAttr('disabled');
        $("[name='informevalidacion']").remove();

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
                $('#historial_informes tbody').remove();                
                $('#historial_informes').last().addClass( "table-scroll" );                  
                //$('#table_equipo tbody').remove();                                                 
                alertas_tipo_valor('alerta_idequipo','correcto','');                   
                var filas= datos.length;
                var color=['','red','yellow','blue','green'];
                var color_row=['','danger','warning','info','success'];
                for (var i =  0; i < filas; i++) {                                    
                historial[i] = {equipos_id:datos[i].idequipo, alias: datos[i].alias, descripcion: datos[i].descripcion,
                    marca: datos[i].marca, modelo: datos[i].modelo, serie: datos[i].serie,equipo_activo:datos[i].equipo_activo, empresas_id:datos[i].empresas_id, 
                    plantas_id:datos[i].plantas_id, vigencia: datos[i].periodo_calibracion, acreditacion: datos[i].acreditaciones_id,
                    tipo_cal: datos[i].calibraciones_id, tecnico_cal: datos[i].usuarios_calibracion_id, fecha_calibracion:datos[i].fecha_calibracion,fecha_vencimiento:datos[i].fecha_vencimiento };
                        var radiocheck= '';
                        if(datos.length == 1) {radiocheck='checked'; asignar_equipo_cliente(i);  $('#historial_informes').removeClass( "table-scroll" );} //Esta condición se ejecuta cuando se halla un solo registro en historial.
                        var planta=datos[i].planta;
                        var cliente="";
                        if(planta.toLowerCase() == "planta1" || planta.toLowerCase() == "planta 1"){
                            cliente=datos[i].empresa;
                        }
                        else{
                            cliente=datos[i].empresa +" "+ datos[i].planta;
                        }
                        var nuevafila= "<tr class='bg-"+color_row[parseInt(datos[i].proceso)]+"'>"+
                        "<td> <label> <input type='radio' name='id_aux' class='minimal' onclick='asignar_equipo_cliente("+i+")' "+radiocheck +"></label></td>"+
                        "<td>"+datos[i].id +"</td>"+
                        "<td>"+datos[i].alias +"</td>"+
                        "<td>"+datos[i].descripcion +"</td>"+
                        "<td>"+datos[i].marca +"</td>"+
                        "<td>"+datos[i].modelo +"</td>"+
                        "<td>"+datos[i].serie +"</td>"+                                            
                        "<td>"+cliente +"</td>"+
                        "<td>"+datos[i].fecha_calibracion +"</td>"+
                        "<td>"+datos[i].periodo_calibracion +"</td>"+
                        "<td>"+datos[i].fecha_vencimiento +"</td>"+
                        "<td>"+datos[i].calibrado_por +"</td>"+
                        "<td>"+datos[i].acreditacion +"</td>"+                         
                        "<td> <span class='badge bg-"+ color[parseInt(datos[i].proceso)]+"'>"+ (parseInt(datos[i].proceso)*100)/4+"%</span></td>"+                                                     
                        +"</tr>"
                        $("#historial_informes") .append(nuevafila);                        
                }                   
                //Historial lleno, pero buscar equipos, esto es cuando hay muchos id similares 
                    buscar_idequipo(1);                                                   
                }
                else{
                    //Cuando historial esta vacio
                    $('#historial_informes tbody').remove();  
                    buscar_idequipo(0);
                } 
                //reload_radiobutton();
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
    }

    var buscar_idequipo = function(estado_hist) {
        if (validar_text($("#idequipo").val().trim()) == true) {
            $.ajax({
                url: "?c=recepcion&a=ajax_load_equipo",
                dataType: "json",
                method: "POST",
                data: "idequipo=" + $("#idequipo").val().trim()
            }).done(function(data) {
                var datos = data;
                //console.log(datos);                          
                if (datos.length > 0) {
                    if(estado_hist=0){$('#historial_informes tbody').remove(); $('#table_equipo').removeClass( "table-scroll" );}
                    $('#table_equipo tbody').remove();                    
                    $('#table_equipo').last().addClass( "table-scroll" );
                    if(datos.length==1){$('#table_equipo').removeClass( "table-scroll" );}  //Se elimina la clase cuando hay un fila en la tabla.                                                        
                    alertas_tipo_valor('alerta_idequipo', 'correcto', '');
                    var bitacora = datos;
                    var radiocheck = '';                   
                    var filas= datos.length;    
                    var disabled="";
                    for (var i =  0; i < filas; i++) {
                        if (bitacora[i].activo=="1"){
                            estadoeq="Activo";
                            labeleq="label-success";                        
                        }
                        else{
                            estadoeq="Inactivo";
                            labeleq="label-danger";
                            disabled="disabled";
                        }

                        var nuevafila = "<tr>";
                        if (datos.length == 1) {
                        radiocheck = 'checked';                         
                        nuevafila += "<td> <label> <input type='radio' class='minimal' name='equipos_id' value='" + bitacora[i].id + "' " + radiocheck + " "+ disabled +"></label></td>";
                        }else{
                        nuevafila += "<td> <label> <input type='radio' class='minimal' name='equipos_id' value='" + bitacora[i].id + "' " + radiocheck + " "+ disabled +"></label></td>";                        
                        } 
                        nuevafila += "<td>" + bitacora[i].alias + "</td>"+
                            "<td>" + bitacora[i].descripcion + "</td>" +
                            "<td>" + bitacora[i].marca + "</td>" +
                            "<td>" + bitacora[i].modelo + "</td>" +
                            "<td>" + bitacora[i].serie + "</td>" +
                            "<td > <span class='label "+ labeleq +"'>" + estadoeq + "</spam> </td>" +
                            "<td> <a class='btn btn-block btn-warning btn-sm' target='_blank'  href='?c=equipos&a=edit&p=" + bitacora[i].id + "'><i class='fa fa-pencil' aria-hidden='true'></i></a></td>" +
                            +"</tr>";                                                          
                        $("#table_equipo").append(nuevafila);
                    }

                } else {
                    $('#table_equipo tbody').remove();
                    alertas_tipo_valor('alerta_idequipo', 'vacio', "<p><a href='?c=equipos&a=add' target='_blank' class='btn btn-primary' style='text-decoration:none;'><i class='fa fa-plus-circle'></i> &nbsp; Agregar equipo</a></li></p>");
                }
            }).fail(function(data) {}).always(function(data) {
                // console.log(data);
            });
        } else {
            alertas_tipo_valor('alerta_idequipo', 'requerido', 'id del equipo');
        }
    }

/* End Buscar equipo */

/* asignar_equipo_cliente */
    var asignar_equipo_cliente = function(index) {
        //count_check_equipo++;
        //if (count_check_equipo < 2) {
            $('#table_equipo').removeClass( "table-scroll" );
            $('#table_equipo tbody').remove();                        
            //console.log( historial);                
            var bitacora = historial[index];            
            planta_temp = bitacora.plantas_id;
        
            if (bitacora.equipo_activo=="1"){
            estadoeq="Activo";
            labeleq="label-success";                        
            }
            else{
                estadoeq="Inactivo";
                labeleq="label-danger";
                disabled="disabled";
            }        

            var nuevafila = "<tr>" +
                "<td><label> <input type='radio' class='minimal' name='equipos_id' value='" + bitacora.equipos_id + "' checked></label></td>" +
                "<td>" + bitacora.alias + "</td>" +
                "<td>" + bitacora.descripcion + "</td>" +
                "<td>" + bitacora.marca + "</td>" +
                "<td>" + bitacora.modelo + "</td>" +
                "<td>" + bitacora.serie + "</td>" +
                "<td > <span class='label "+ labeleq +"'>" + estadoeq + "</spam> </td>" +
                "<td> <a class='btn btn-block btn-warning btn-sm' target='_blank'  href='?c=equipos&a=edit&p=" + bitacora.equipos_id + "'><i class='fa fa-pencil' aria-hidden='true'></i></a></td>" +
                +"</tr>"
            $("#table_equipo").append(nuevafila);

            $('#empresa_ajax_r').val(bitacora.empresas_id).change();
            $('#periodo_calibracion').val(bitacora.vigencia)
            $('#acreditaciones_id').val(bitacora.acreditacion).change();
            $('#calibraciones_id').val(bitacora.tipo_cal).change();
            $('#usuarios_calibracion_id').val(bitacora.tecnico_cal).change();
                      
            var porciento = validar_equipo_vigenciacal(bitacora.equipos_id);
            var usuario_permiso=validar_usuario_confirmar();
           
            if(porciento == 0 ){ 
                if(usuario_permiso==1){
                    $("[name='informevalidacion']").remove();
                    var valor= "<p> <h4>El equipo aún no se ha calibrado. Este usuario permite ingresar el equipo una vez más.</h4> </p>";
                    $("#alerta_informevalidacion").before(
                        "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-info alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-warning'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
                }
                else{                           
                    $("[type='submit']").attr('disabled','disabled');              
                    $("[name='informevalidacion']").remove();
                    var valor= "<p> <h4>El equipo aún no se ha calibrado. ¿Estas seguro de ingresar el equipo una vez más?</h4> <button type='button' class='btn btn-default' data-toggle='modal' data-target='#modal-default'>Confirmar <i class='fa fa-check fa-lg'></i> </button> </p>";
                    $("#alerta_informevalidacion").before(
                        "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-info alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-warning'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
                }
            }else if( porciento < 80 ){
                if(usuario_permiso==1){
                    $("[name='informevalidacion']").remove();
                    var valor= "<p> <h4>La fecha de vencimiento aún no culminá. Este usuario permite ingresar el equipo una vez más.</p>";
                    $("#alerta_informevalidacion").before(
                        "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-danger alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-warning'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");   
                }
                else{
                $("[type='submit']").attr('disabled','disabled');              
                $("[name='informevalidacion']").remove();
                var valor= "<p> <h4>La fecha de vencimiento aún no culminá. ¿Estas seguro de ingresar el equipo una vez más?</h4> <button type='button' class='btn btn-default' data-toggle='modal' data-target='#modal-default'>Confirmar <i class='fa fa-check fa-lg'></i> </button> </p>";
                $("#alerta_informevalidacion").before(
                    "<div class='form-group' name='informevalidacion' id='informevalidacion'><div class='col-sm-12'> " + "<div class='alert alert-danger alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-warning'></i> Alerta!</h4>" + valor + "</div>" + "</div>" + "</div>");
                }
            }
            else{
                $("[name='informevalidacion']").remove();           
            }                                          
    }    
   

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

    function validar_equipo_vigenciacal(value){
        var result=0;
        $.ajax({            
            url: "?c=recepcion&a=ajax_load_ultimoid_equipo",
            dataType: "json",
            method: "POST",
            data: "idequipo=" + value,
            async: false,
            success: function(data) {
                var datos = data;               
                if(datos.length > 0){
                    fechacal=datos[0].fecha_calibracion;
                    //console.log(fechacal);                 
                    if(fechacal != ""){
                        result = Math.round(validar_ultimacal(datos[0].fecha_calibracion,datos[0].fecha_vencimiento));                                    
                    }                  
                }
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
          select.append($("<option />").val('').text('Seleccione una opción'));
          $.each(datos, function() {
              select.append($("<option />").val(this.id).text(this.nombre));
          });
          if (planta_temp.length > 0) {
              $('#idplanta_ajax_r').val(planta_temp).change();
              planta_temp = "";
          } else {
              $('#idplanta_ajax_r').val('').change();
          }
      }).fail(function(data) {}).always(function(data) {
          // console.log(data);
      });
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
        $("#factura").val('No existe');
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


/* END Lista de errores nombre de la alerta, tipo de alerta, y texto */

  $(document).ready(function() {

    $("#refresh_informe").click(function(e){           
      ultimo_numero_informe();
      e.preventDefault();
    });
   
    $("#buscar_idequipo").on('click', buscar_idequipo_historial);

    $("#idequipo").keypress(function(e) {
      if (e.which == 13) {   
        $(this).val(espacio_blanco($(this).val()));      
          buscar_idequipo_historial();
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
         
    

  }); 
  