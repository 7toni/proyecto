/* Inicio de variables de recepción */    
    //var count_check_equipo = 0;
    var count_numinforme=0;
    var idplanta_temp = ""; 
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
            value= Math.round(((diastranscurridos*100)/diastotal));                             
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
        select.trigger("change");

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
            select.trigger("change");

            if (idplanta_temp.length > 0) {
                $('#idplanta_ajax_r').val(idplanta_temp).trigger("change");
                idplanta_temp = "";
            } 

            if(datos.length == 1){
            var optplanta= datos[0]['id'];
            $('#idplanta_ajax_r').val(optplanta).trigger("change");
            }
            else{
                $('#direccion_planta').text('...'); 
            } 
                     

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
            if(planta_temp.length >0){
                var campo= planta_temp;                                
                var value=  $("#idplanta_ajax_r").find("option:contains('"+planta_temp+"')").val();               
                $("#idplanta_ajax_r").val(value).change();
                planta_temp="";
            }          
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
                //$("[name='informevalidacion']").remove();
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
    var arrayidequipo = function(){        
        var qr= $("#idequipo").val().trim();
        //console.log(qr);          
        var obj= qr.split(';');           
        return obj;
    }

    var comparatext = function(var1,var2){
        if(var1.toLowerCase() == var2.toLowerCase()){
            return true;
        }
        else{
            return false;
        }
    }

    var buscar_historialequipo = function () {
        //count_check_equipo=0;
            $('[type="submit"]').removeAttr('disabled');
            //$("[name='informevalidacion']").remove();
            $("[name='alertas']").remove();
            activarcargando(1);
        if (validar_text($("#idequipo").val().trim())== true) {
            var obj = arrayidequipo();  
            try{
                $.ajax({
                    url: "?c=recepcion&a=ajax_load_historial",
                    dataType: "json",
                    method: "POST",
                    data: "idequipo=" + obj[0]  //obj[clave]              
                }).done(function (data) {
                    var datos = data;
                    //console.log(datos);
                    var sizedatos= datos.length;                                
                    if (sizedatos > 0) {                                                                  
                        _table2.clear();
                        _table2.rows.add(datos).draw();
                    }                                 
                    buscar_tablaequipo(obj);
                    activarcargando(0);
    
                }).fail(function (data) {
                }).always(function (data) {
                    //console.log(data);
                }); 
            }   
            catch(err){
                console.log("Tenemos un problema con los datos de entrada");
            }                                       
        } 
        else{
            alertas_tipo_valor('alerta_idequipo','requerido','id del equipo');
            activarcargando(0);              
        }
    };

    var buscar_tablaequipo = function(obj) {
        var sizeobj= obj.length;
        //$("[name='informevalidacion']").remove();
        if (obj[0] != null || obj[0] != '') {        
            $.ajax({
                url: "?c=recepcion&a=ajax_load_equipo",
                dataType: "json",
                method: "POST",
                data: "idequipo=" + obj[0]
            }).done(function(data) {
                var datos = data; 
                //console.log(datos);
                var sizedata= datos.length;              
                if (sizedata > 0) { // Quiere decir que hay equipos en data                                        
                    _table.clear();
                    _table.rows.add(datos).draw();
                    var sizegetideq= getidequipo.length;
                     
                    if(sizegetideq>0 && obj[0]===getalias){//Verifica que el informe en curso, ya tiene asiganado un equipo, lo que hace es
                        //buscarlo en el array de datos y seleccionarlo.
                        var data=[];                      
                        for (var i in datos) {                          
                            if(getidequipo == datos[i]['id']){                                                          
                                data[0]= datos[i];
                                break;
                            }                             
                        }
                        _table.clear();
                        _table.rows.add(data).draw();
                        //La variable getequipo se obtiene desde php
                        $("input[type='radio'][name='r1'][value='"+getidequipo+"']").prop('checked', true);  
                        evaluar_informeequipo(getidequipo);
                    } else if(sizeobj > 1){ // quiere decir que el array obj esta lleno con los datos de equipo y cliente, escaneado desde QR
                        //Comparar si la tabla tiene un columna o varias, y se comparara las datos del obj con el el data                                             
                        for(var i=0; i<sizedata; i++){                                                   
                            if(comparatext(datos[i]['alias'],obj[0]) == true && comparatext(datos[i]['descripcion'],obj[1]) && comparatext(datos[i]['marca'],obj[2]) && comparatext(datos[i]['modelo'],obj[3]) && comparatext(datos[i]['serie'],obj[4])){                                
                                $("input[type='radio'][name='r1'][value='"+datos[i]['id']+"']").prop('checked', true);
                                evaluar_informeequipo(datos[i]['id']);
                                var campo= obj[5];                                
                                var value=  $("#empresa_ajax_r").find("option:contains('"+ campo +"')").val();                                
                                $("#empresa_ajax_r").val(value).trigger("change");
                                planta_temp= obj[6];                                                              
                                break;
                            }
                            else{
                                alertas_tipo_valor('alerta_idequipo', 'vacio', "<p>No se encontró coincidencia, favor de verificar.</p>");
                            }                                                        
                        }
                    } else if(sizedata == 1){//quiere decir que los datos del data, que se llenaron en la tabla equipos, tiene una columna , por lo tanto se hace check
                        $("input[type='radio'][name='r1'][value='"+datos[0]['id']+"']").prop('checked', true);                        
                        evaluar_informeequipo(datos[0]['id']);
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

    //Validar los valores del informe actual mas las diferentes notifcaciones del caso.
    var evaluar_informeequipo = function(val) {            
        // Agregar un validacion de equipo mas informe, ya que solo valida el estado del equipo
            //$("[name='informevalidacion']").remove();                 
            var numinforme= $("#numero_informe").val();
            var reqaut_infactual= parseInt(reqautorizacion);
            var proceso_infactual= parseInt($("#proceso").val());            
            var equipo_infactual= getidequipo;

            var obj={"id":numinforme,"idequipo":equipo_infactual,"proceso":proceso_infactual,"reqautorizacion":reqaut_infactual};
            var data= historial_ultimoidequipo(val);
            var sizedata=data.length;

            var valuesubmit=["Registrar","Actualizar","Solicitar registro","Estado [autorización]", "Bajo autorización","Estado [autorización]"]; 
            var tiposubmit= ["registrar","actualizar","solicitud","sinpermiso","actualizar","sinpermiso"];
            var disabledsubmit= [false,false,false,true,false,true];
            var disablebusqueda= [false,false,false,true,true,false];
            var btncolor=["btn-primary","btn-info","btn-warning","btn-danger","btn-warning","btn-danger"];
            //success info warning danger
            var alertcolor="";
            var alerta="";
            var  numtemp=0;
            if(sizedata==0){
                if(obj['reqautorizacion']==0){
                    if(obj['proceso']==0){
                        if(obj['idequipo']!=val || obj['idequipo']==""){
                            alerta="#1 Este informe está disponible para ingresar el equipo seleccionado, para continuar con el proceso de registro.";
                            alertcolor="success";
                            numtemp=0; 
                        }else if(obj['idequipo']==val){
                            alerta="#2 Este informe tiene asigando el equipo seleccionado, el cual esta disponible para continuar con el proceso de registro.";
                            alertcolor="info";
                            numtemp=1;
                        }
                    }else if(obj['proceso']>0){
                        if(obj['proceso']==4){
                            if(obj['idequipo']!=val || obj['idequipo']==""){
                                alerta="#3 Este informe se encuentra en proceso finalizado, el equipo asignado no es el seleccionado por lo cual si se desea actualizar se enviara una solicitud de registro.";
                                alertcolor="warning";
                                numtemp=2;
                                detalles = usuario + "_"+"El Informe:"+ obj['id']+ "se encuentra en proceso finalizado, y se desea ingresar otro equipo con el id:"+ val +". Ojo! Revise informe (Excel) y certificado que se haga el cambio completo.";
                            }
                            else if(obj['idequipo']==val){
                                alerta="#4 Este informe se encuentra en proceso finalizado y el equipo asignado es el seleccionado.";
                                alertcolor="info";
                                numtemp=1; 
                            }                                
                        }else{
                            if(obj['idequipo']!=val || obj['idequipo']==""){
                                alerta="#5 Este informe se encuentra en proceso, el equipo asignado no es el seleccionado por lo cual si se desea actualizar se enviara una solicitud de registro.";
                                alertcolor="warning";
                                numtemp=2;
                                detalles = usuario + "_"+"El Informe:"+ obj['id']+ "se encuentra en proceso, y se desea ingresar otro equipo con el id:"+ val;
                            }else if(obj['idequipo']==val){
                                alerta="#6 Este informe se encuentra en proceso y el equipo asignado es el seleccionado.";
                                alertcolor="info";
                                numtemp=1;  
                            }                         
                        }                       
                    }                   
                }else if(obj['reqautorizacion']>0){
                    if(obj['proceso']<4){
                        if(obj['idequipo']!=val || obj['idequipo']==""){
                            alerta="#7 Este informe tiene asignado otro equipo";
                            alertcolor="danger";
                            var opcionnum=[0,3,3];
                            var alertatemp=[""," No se puede realizar ninguna modificación hasta que autorice o se cancele."," No se puede realizar cambios o actualizaciones, a menos que se cancele el informe actual."];
                            numtemp= opcionnum[obj['reqautorizacion']];
                            alerta+=alertatemp[obj['reqautorizacion']];
                        }else{
                            alerta="#8 Este informe tiene asignado el equipo seleccionado.";
                            alertcolor="danger";
                            var opcionnum=[0,3,4];
                            var alertatemp=[""," Pero no se puede realizar ninguna modificación hasta que autorice o se cancele."," Se puede realizar cambios o actualizaciones excepto cambiar el equipo asignado, a menos que se cancele el informe actual."];
                            numtemp= opcionnum[obj['reqautorizacion']];
                            alerta+=alertatemp[obj['reqautorizacion']];
                        }
                    }else if(obj['proceso']==4){
                        if(obj['reqautorizacion']==2){
                            if(obj['idequipo']!=val || obj['idequipo']==""){
                                alerta="#9 Este informe tiene asignado otro equipo y se encuentra es un estado de autorización aprobado. Si se desea ingresar otro equipo cancele este informe e ingresa la información que desea. ";
                                alertcolor="danger";
                                numtemp=3;
                            }else{
                                alerta="#10 Este informe tiene asigando el equipo seleccionado y se encuentra en estado de aprobación.";
                                alertcolor="warning";
                                numtemp=4; 
                            }                            
                        }
                    }
                }
            }
            else if(sizedata>0){
                var alertatemp="";
                for(var i in data){
                    var vigencia=0;                    
                    if(obj['reqautorizacion']==0){
                        if(obj['proceso']==0){
                            if(obj['idequipo']!=val || obj['idequipo']==""){                                
                                if(data[i]['reqautorizacion']==0){
                                    if(parseInt(data[i]['proceso'])<4){
                                        //Solicitar
                                        alertatemp+="#11 El equipo seleccionado según su historial se encuentra en el proceso de <span class='badge bg-red'>"+data[i]['nombre_proceso']+"</span>. Si se desea continuar con el proceso de registro, al final del registro se enviara una solicitud para autorizar.";
                                        alertcolor="warning";
                                        detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +" y se encuentra en el proceso de "+  data[i]['nombre_proceso']+". Se desea registrar en el informe :"+obj['id'];
                                        numtemp=2;
                                    }else if(parseInt(data[i]['proceso'])==4){
                                        //vigencia, Solicitar registro
                                        vigencia= validar_ultimacal(data[i]['fecha_calibracion'], data[i]['fecha_vencimiento']);
                                        if(vigencia>100){
                                            alertatemp +="#12 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia ha superado el límite. Prioridad de registro: <span class='badge bg-red'> URGENTE! </span>.";
                                            alertcolor="success";
                                            numtemp=0;
                                        }
                                        else if(vigencia>80){
                                            alertatemp +="#13 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia es del <span class='badge bg-red'> "+ vigencia +"% </span>. Puede continuar con el proceso de registro.";
                                            alertcolor="success";
                                            numtemp=0;
                                        }else if(vigencia<80){
                                            alertatemp +="#14 El equipo seleccionado según su historial el estado de vigencia es del <span class='badge bg-red'>"+vigencia+"% </span>. Si se desea continuar con el proceso de registro, al final del registro se enviara una solicitud para autorizar.";
                                            alertcolor="warning";
                                            detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +" y su fecha de vencimiento es hasta "+  data[i]['fecha_vencimiento']+". Se desea registrar en el informe :"+obj['id'];
                                            numtemp=2;
                                        }                            
                                    }
                                }else if(data[i]['reqautorizacion']>0){
                                    if(data[i]['reqautorizacion']==1){
                                        alertatemp +="#15 El equipo seleccionado según su historial se encuentra en un estado de autorización <span class='badge bg-yellow'>pendiente</span>,por lo tanto no se puede continuar con el proceso de registro. ";
                                        alertcolor="danger";
                                        numtemp=5;
                                    }else if(data[i]['reqautorizacion']==2){
                                        if(parseInt(data[i]['proceso'])<4){
                                            //Solicitar
                                            alertatemp+="#16 El equipo seleccionado según su historial se encuentra en el proceso de <span class='badge bg-red'>"+data[i]['nombre_proceso']+"</span> y en el estado de <span class='badge bg-red'>bajo autorización</span>. Si se desea registrar, se enviara una solicitud para autorizar. ";
                                            alertcolor="warning";
                                            detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +", se encuentra en el proceso de "+  data[i]['nombre_proceso']+" y en un estado: bajo autorización. Se desea registrar en el informe :"+obj['id'];
                                            numtemp=2;
                                        }else if(parseInt(data[i]['proceso'])==4){
                                            //vigencia, Solicitar registro
                                            vigencia= validar_ultimacal(data[i]['fecha_calibracion'], data[i]['fecha_vencimiento']);
                                            if(vigencia>100){
                                                alertatemp +="#17 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia ha superado el límite. Prioridad de registro: <span class='badge bg-red'> URGENTE! </span>.";
                                                alertcolor="success";
                                                numtemp=0;
                                            }
                                            else if(vigencia>80){
                                                alertatemp +="#18 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia es del <span class='badge bg-red'> "+ vigencia +"% </span>. Puede continuar con el proceso de registro.";
                                                alertcolor="success";
                                                numtemp=0;
                                            }else if(vigencia<80){
                                                alertatemp +="#19 El equipo seleccionado según su historial el estado de vigencia es del <span class='badge bg-red'>"+vigencia+"% </span>, además este informe se encuentra <span class='badge bg-red'>bajo autorización</span>. Si se desea continuar con el proceso de registro, al final del registro se enviara una solicitud para autorizar.";
                                                alertcolor="warning";
                                                detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +" y su fecha de vencimiento es hasta "+  data[i]['fecha_vencimiento']+". Se desea registrar en el informe :"+obj['id'];
                                                numtemp=2;
                                            }                            
                                        }  
                                    }
                                }
                            }else if(obj['idequipo']== val && obj['id']==parseInt(data[i]['id'])){
                                alertatemp +="#20 El equipo seleccionado corresponde al informe <span class='badge bg-red'>"+data[i]['id']+"</span>.";
                                alertcolor="info";
                                numtemp=1;
                            }
                        }else{
                            if(obj['idequipo']!= val){
                                if(data[i]['reqautorizacion']==0){
                                    if(parseInt(data[i]['proceso'])<4){
                                        //Solicitar
                                        alertatemp+="#21 El equipo seleccionado según su historial se encuentra en el proceso de <span class='badge bg-red'>"+data[i]['nombre_proceso']+"</span>. Si se desea continuar con el proceso de registro, al final del registro se enviara una solicitud para autorizar.";
                                        alertcolor="warning";
                                        detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +" y se encuentra en el proceso de "+  data[i]['nombre_proceso']+". Se desea registrar en el informe :"+obj['id'];
                                        numtemp=2;
                                    }else if(parseInt(data[i]['proceso'])==4){
                                        //vigencia, Solicitar registro
                                        vigencia= validar_ultimacal(data[i]['fecha_calibracion'], data[i]['fecha_vencimiento']);
                                        if(vigencia>100){
                                            alertatemp +="#22 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia ha superado el límite. Prioridad de registro: <span class='badge bg-red'> URGENTE! </span>.";
                                            alertcolor="success";
                                            numtemp=0;
                                        }
                                        else if(vigencia>80){
                                            alertatemp +="#23 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia es del <span class='badge bg-red'> "+ vigencia +"% </span>. Puede continuar con el proceso de registro.";
                                            alertcolor="success";
                                            numtemp=0;
                                        }else if(vigencia<80){
                                            alertatemp +="#24 El equipo seleccionado según su historial el estado de vigencia es del <span class='badge bg-red'>"+vigencia+"% </span>. Si se desea continuar con el proceso de registro, al final del registro se enviara una solicitud para autorizar.";
                                            alertcolor="warning";
                                            detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +" y su fecha de vencimiento es hasta "+  data[i]['fecha_vencimiento']+". Se desea registrar en el informe :"+obj['id'];
                                            numtemp=2;
                                        }                            
                                    }
                                }else if(data[i]['reqautorizacion']>0){
                                    if(data[i]['reqautorizacion']==1){
                                        alertatemp +="#25 El equipo seleccionado según su historial se encuentra en un estado de autorización <span class='badge bg-yellow'>pendiente</span>,por lo tanto no se puede continuar con el proceso de registro. ";
                                        alertcolor="danger";
                                        numtemp=5;
                                    }else if(data[i]['reqautorizacion']==2){
                                        if(parseInt(data[i]['proceso'])<4){
                                            //Solicitar
                                            alertatemp+="#26 El equipo seleccionado según su historial se encuentra en el proceso de <span class='badge bg-red'>"+data[i]['nombre_proceso']+"</span> y en el estado de <span class='badge bg-red'>bajo autorización</span>. Si se desea registrar, se enviara una solicitud para autorizar. ";
                                            alertcolor="warning";
                                            detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +", se encuentra en el proceso de "+  data[i]['nombre_proceso']+" y en un estado: bajo autorización. Se desea registrar en el informe :"+obj['id'];
                                            numtemp=2;
                                        }else if(parseInt(data[i]['proceso'])==4){
                                            //vigencia, Solicitar registro
                                            vigencia= validar_ultimacal(data[i]['fecha_calibracion'], data[i]['fecha_vencimiento']);
                                            if(vigencia>100){
                                                alertatemp +="#27 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia ha superado el límite. Prioridad de registro: <span class='badge bg-red'> URGENTE! </span>.";
                                                alertcolor="success";
                                                numtemp==0;
                                            }
                                            else if(vigencia>80){
                                                alertatemp +="#28 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia es del <span class='badge bg-red'> "+ vigencia +"% </span>. Puede continuar con el proceso de registro.";
                                                alertcolor="success";
                                                numtemp==0;
                                            }else if(vigencia<80){
                                                alertatemp +="#29 El equipo seleccionado según su historial el estado de vigencia es del <span class='badge bg-red'>"+vigencia+"% </span>, además este informe se encuentra <span class='badge bg-red'>bajo autorización</span>. Si se desea continuar con el proceso de registro, al final del registro se enviara una solicitud para autorizar.";
                                                alertcolor="warning";
                                                detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +" y su fecha de vencimiento es hasta "+  data[i]['fecha_vencimiento']+". Se desea registrar en el informe :"+obj['id'];
                                                numtemp=2;
                                            }                            
                                        }  
                                    }
                                }
                            }
                            else if(obj['idequipo']== val && obj['id']==parseInt(data[i]['id'])){
                                alertatemp +="#30 El equipo seleccionado corresponde al informe <span class='badge bg-red'>"+data[i]['id']+"</span>.";
                                alertcolor="info";
                                numtemp=1;
                            }
                        }
                    }else if(obj['reqautorizacion']>0){
                        if(obj['reqautorizacion']==1){
                            alertatemp +="#31 Este informe se encuentra en un estado de autorización <span class='badge bg-yellow'>pendiente</span>,por lo tanto no se puede continuar con el proceso de registro. ";
                            alertcolor="danger";
                            numtemp=3;
                        }else if(obj['reqautorizacion']==2){
                            if(obj['proceso']==0){
                                if(obj['idequipo']!=val || obj['idequipo']==""){                                
                                    if(data[i]['reqautorizacion']==0){
                                        if(parseInt(data[i]['proceso'])<4){
                                            //Solicitar
                                            alertatemp+="#32 El equipo seleccionado según su historial se encuentra en el proceso de <span class='badge bg-red'>"+data[i]['nombre_proceso']+"</span>. Si se desea continuar con el proceso de registro, al final del registro se enviara una solicitud para autorizar.";
                                            alertcolor="warning";
                                            detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +" y se encuentra en el proceso de "+  data[i]['nombre_proceso']+". Se desea registrar en el informe :"+obj['id'];
                                            numtemp=2;
                                        }else if(parseInt(data[i]['proceso'])==4){
                                            //vigencia, Solicitar registro
                                            vigencia= validar_ultimacal(data[i]['fecha_calibracion'], data[i]['fecha_vencimiento']);
                                            if(vigencia>100){
                                                alertatemp +="#33 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia ha superado el límite. Prioridad de registro: <span class='badge bg-red'> URGENTE! </span>.";
                                                alertcolor="success";
                                                numtemp=0;
                                            }
                                            else if(vigencia>80){
                                                alertatemp +="#34 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia es del <span class='badge bg-red'> "+ vigencia +"% </span>. Puede continuar con el proceso de registro.";
                                                alertcolor="success";
                                                numtemp=0;
                                            }else if(vigencia<80){
                                                alertatemp +="#35 El equipo seleccionado según su historial el estado de vigencia es del <span class='badge bg-red'>"+vigencia+"% </span>. Si se desea continuar con el proceso de registro, al final del registro se enviara una solicitud para autorizar.";
                                                alertcolor="warning";
                                                detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +" y su fecha de vencimiento es hasta "+  data[i]['fecha_vencimiento']+". Se desea registrar en el informe :"+obj['id'];
                                                numtemp=2;
                                            }                            
                                        }
                                    }else if(data[i]['reqautorizacion']>0){
                                        if(data[i]['reqautorizacion']==1){
                                            alertatemp +="#36 El equipo seleccionado según su historial se encuentra en un estado de autorización <span class='badge bg-yellow'>pendiente</span>,por lo tanto no se puede continuar con el proceso de registro. ";
                                            alertcolor="danger";
                                            numtemp=3;
                                        }else if(data[i]['reqautorizacion']==2){
                                            if(parseInt(data[i]['proceso'])<4){
                                                //Solicitar
                                                alertatemp+="#37 El equipo seleccionado según su historial se encuentra en el proceso de <span class='badge bg-red'>"+data[i]['nombre_proceso']+"</span> y en el estado de <span class='badge bg-red'>bajo autorización</span>. Si se desea registrar, se enviara una solicitud para autorizar. ";
                                                alertcolor="warning";
                                                detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +", se encuentra en el proceso de "+  data[i]['nombre_proceso']+" y en un estado: bajo autorización. Se desea registrar en el informe :"+obj['id'];
                                                numtemp=2;
                                            }else if(parseInt(data[i]['proceso'])==4){
                                                //vigencia, Solicitar registro
                                                vigencia= validar_ultimacal(data[i]['fecha_calibracion'], data[i]['fecha_vencimiento']);
                                                if(vigencia>100){
                                                    alertatemp +="#38 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia ha superado el límite. Prioridad de registro: <span class='badge bg-red'> URGENTE! </span>.";
                                                    alertcolor="success";
                                                    numtemp=0;
                                                }
                                                else if(vigencia>80){
                                                    alertatemp +="#39 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia es del <span class='badge bg-red'> "+ vigencia +"% </span>. Puede continuar con el proceso de registro.";
                                                    alertcolor="success";
                                                    numtemp=0;
                                                }else if(vigencia<80){
                                                    alertatemp +="#40 El equipo seleccionado según su historial el estado de vigencia es del <span class='badge bg-red'>"+vigencia+"% </span>. Si se desea continuar con el proceso de registro, al final del registro se enviara una solicitud para autorizar.";
                                                    alertcolor="warning";
                                                    detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +" y su fecha de vencimiento es hasta "+  data[i]['fecha_vencimiento']+". Se desea registrar en el informe :"+obj['id'];
                                                    numtemp=2;
                                                }                            
                                            }  
                                        }
                                    }
                                }else if(obj['idequipo']== val && obj['id']==parseInt(data[i]['id'])){
                                    alertatemp +="#41 El equipo seleccionado corresponde al informe <span class='badge bg-red'>"+data[i]['id']+"</span>.";
                                    alertcolor="info";
                                    numtemp=1;
                                }
                            }else{
                                if(obj['idequipo']!= val){
                                    if(data[i]['reqautorizacion']==0){
                                        if(parseInt(data[i]['proceso'])<4){
                                            //Solicitar
                                            alertatemp+="#42 El equipo seleccionado según su historial se encuentra en el proceso de <span class='badge bg-red'>"+data[i]['nombre_proceso']+"</span>. Si se desea continuar con el proceso de registro, al final del registro se enviara una solicitud para autorizar.";
                                            alertcolor="warning";
                                            detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +" y se encuentra en el proceso de "+  data[i]['nombre_proceso']+". Se desea registrar en el informe :"+obj['id'];
                                            numtemp=2;
                                        }else if(parseInt(data[i]['proceso'])==4){
                                            //vigencia, Solicitar registro
                                            vigencia= validar_ultimacal(data[i]['fecha_calibracion'], data[i]['fecha_vencimiento']);
                                            if(vigencia>100){
                                                alertatemp +="#43 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia ha superado el límite. Prioridad de registro: <span class='badge bg-red'> URGENTE! </span>.";
                                                alertcolor="success";
                                                numtemp=0;
                                            }
                                            else if(vigencia>80){
                                                alertatemp +="#44 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia es del <span class='badge bg-red'> "+ vigencia +"% </span>. Puede continuar con el proceso de registro.";
                                                alertcolor="success";
                                                numtemp=0;
                                            }else if(vigencia<80){
                                                alertatemp +="#45 El equipo seleccionado según su historial el estado de vigencia es del <span class='badge bg-red'>"+vigencia+"% </span>. Si se desea continuar con el proceso de registro, al final del registro se enviara una solicitud para autorizar.";
                                                alertcolor="warning";
                                                detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +" y su fecha de vencimiento es hasta "+  data[i]['fecha_vencimiento']+". Se desea registrar en el informe :"+obj['id'];
                                                numtemp=2;
                                            }                            
                                        }
                                    }else if(data[i]['reqautorizacion']>0){
                                        if(data[i]['reqautorizacion']==1){
                                            alertatemp +="#46 El equipo seleccionado según su historial se encuentra en un estado de autorización <span class='badge bg-yellow'>pendiente</span>,por lo tanto no se puede continuar con el proceso de registro. ";
                                            alertcolor="danger";
                                            numtemp=3;
                                        }else if(data[i]['reqautorizacion']==2){
                                            if(parseInt(data[i]['proceso'])<4){
                                                //Solicitar
                                                alertatemp+="#47 El equipo seleccionado según su historial se encuentra en el proceso de <span class='badge bg-red'>"+data[i]['nombre_proceso']+"</span> y en el estado de <span class='badge bg-red'>bajo autorización</span>. Si se desea registrar, se enviara una solicitud para autorizar. ";
                                                alertcolor="warning";
                                                detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +", se encuentra en el proceso de "+  data[i]['nombre_proceso']+" y en un estado: bajo autorización. Se desea registrar en el informe :"+obj['id'];
                                                numtemp=2;
                                            }else if(parseInt(data[i]['proceso'])==4){
                                                //vigencia, Solicitar registro
                                                vigencia= validar_ultimacal(data[i]['fecha_calibracion'], data[i]['fecha_vencimiento']);
                                                if(vigencia>100){
                                                    alertatemp +="#48 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia ha superado el límite. Prioridad de registro: <span class='badge bg-red'> URGENTE! </span>.";
                                                    alertcolor="success";
                                                    numtemp=0;
                                                }
                                                else if(vigencia>80){
                                                    alertatemp +="#49 El equipo seleccionado puede registrarse, ya que según su historial se encuentra en proceso terminado y su estado de vigencia es del <span class='badge bg-red'> "+ vigencia +"% </span>. Puede continuar con el proceso de registro.";
                                                    alertcolor="success";
                                                    numtemp=0;
                                                }else if(vigencia<80){
                                                    alertatemp +="#50 El equipo seleccionado según su historial el estado de vigencia es del <span class='badge bg-red'>"+vigencia+"% </span>. Si se desea continuar con el proceso de registro, al final del registro se enviara una solicitud para autorizar.";
                                                    alertcolor="warning";
                                                    detalles = usuario + "_"+"El equipo tiene asigando el informe: ("+ data[i]['id'] +") que pertenece al cliente: "+  data[i]['empresa'] +","+  data[i]['planta']  +" y su fecha de vencimiento es hasta "+  data[i]['fecha_vencimiento']+". Se desea registrar en el informe :"+obj['id'];
                                                    numtemp=2;
                                                }                            
                                            }  
                                        }
                                    }
                                }
                                else if(obj['idequipo']== val && obj['id']==parseInt(data[i]['id'])){
                                    alertatemp +="#51 El equipo seleccionado corresponde al informe <span class='badge bg-red'>"+data[i]['id']+"</span>.";
                                    alertcolor="info";
                                    numtemp=1;
                                }
                            } 
                        }
                    }                                                                                            
                }
                alerta= alertatemp;
            }            

            //Submit
                $('[type="submit"]').prop('disabled', disabledsubmit[numtemp]);                             
                $('[type="submit"]').prop('value', valuesubmit[numtemp]);
                $('[name="tiposubmit"]').prop('value',tiposubmit[numtemp]);
                $('[type="submit"]').removeClass('btn-primary').addClass(btncolor[numtemp]);
            //Opciones de busqueda           
                $('#buscar_idequipo').prop('disabled', disablebusqueda[numtemp]);
                $('#idequipo').prop('disabled', disablebusqueda[numtemp]); 
            //Notificacion 
                //$("[name='informevalidacion']").remove();                               
                alertas_col12('alerta_equipoinforme', alertcolor, alerta);              
    };
    
    var historial_ultimoidequipo = function(val){
        var datos=[];
        $.ajax({
            url: "?c=recepcion&a=ajax_load_ultimoid_equipo",
            dataType: "json",
            method: "POST",
            async: false,
            data: "idequipo=" + val,
        }).done(function(data) {
            datos = data;                                                                                         
        }).fail(function(data) {           
        }).always(function(data) {
            //console.log(data);
        }); 
        return datos;
    }
    

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

    $("#clear_idequipo").click(function(e){       
        $("#idequipo").val('');
        $("#idequipo").focus();        
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
                    if(row['activo']==1){
                        _input='<input type="radio" name="r1" value="'+ row['id'] +'">';
                    }else{
                        _input='<input type="radio" name="r1" value="'+ row['id'] +'" disabled>';
                    }
                    
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
                { "data": 'vigencia'},
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
            'order': [[1, 'desc']]                                                                  
    });
      
    if(getalias != ""){
        var obj= getalias.split(';');                
        buscar_tablaequipo(obj);
    }
    
    $("#table_equipo tbody").on("change", "input[type='radio'][name='r1']", function(){
        if(this.checked){            
            var val = $("input[type='radio'][name='r1']:checked").val(); 
           evaluar_informeequipo(val); 
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
                idplanta_temp= datos[0]['plantas_id'];
        }              
    }); 

    $("input[type='submit']").click ( function(){
        activarcargandosubmit(1);
        //Variable de validacion
          var validacion= true;    
        //Array de los campos capturados                      
          var parametro = {
             0:$("#numero_informe").val(),
             1:$("input[type='radio'][name='r1']:checked").val(),
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
        if (data === "" || data === null || data === undefined) {
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

    // var campo= 'Grupo Chamberlain S. De R.L. De C.V.';
    // var value=  $("#empresa_ajax_r").find("option:contains('"+ campo +"')").val();

    // console.log(value);
     
});