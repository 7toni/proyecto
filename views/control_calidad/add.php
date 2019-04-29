<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php importView('_static/header'); ?>
            <?php importView('_static/sidebar'); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?></small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header  with-border">
                                    <h3 class="box-title">Agregar listados de <?php echo $this->name; ?></h3>
                                </div>
                                <div class="box-body">
                                    <?php if ($error = Flash::hasError()) { ?>
                                        <div class="alert alert-warning alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h4><i class="icon fa fa-warning"></i> <?php echo $error['title']; ?> #<?php echo $error['id']; ?> </h4>
                                            <ul><?php
                                                foreach ($error['data'] as $err) {
                                                    echo '<li>' . $err['msg'] . '</li>';
                                                }
                                                ?></ul>
                                        </div>
                                    <?php } ?>
                                    <form method="POST" autocomplete="off"  action="?c=<?php echo $this->name; ?>&a=store" role="form">
                                        <div class="box-body">
                                            <div class="form-group" id="alerta_equipocc">                                           
                                                <h4>Clave del equipo</h4>                                            
                                                <div class="input-group">                                  
                                                <input autofocus type="text" id="idequipocc" class="form-control" placeholder="clave" required="">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-block btn-default" id="buscar_idequipocc" > <i class="fa fa-search"></i> &nbsp; Buscar Equipo</button>                                                                                                                  
                                                </div>             
                                            </div>

                                            <h4>Datos del equipo</h4>
                                            <div class="form-group table-responsive">
                                            <table class="table table-condensed" id="table_equipocc">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">#</th>
                                                        <th >Clave</th>
                                                        <th >Descripción</th>
                                                        <th >Marca</th>
                                                        <th>Modelo</th>
                                                        <th>Serie</th>                                                    
                                                        <th>Estado</th>
                                                        <th>Editar</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <!-- Esperando que se busque la clave del equipo-->
                                                </tbody>                                                                                            
                                            </table>
                                            </div>
                                            <div class="form-group">
                                                <label>Fecha de ingreso</label>                                                                                                                                             
                                                <input type="text" class="form-control pull-right datepicker" id="fechaingreso" name="fechaingreso" require="">                                            
                                            </div>                                            
                                            <div class="form-group">
                                                <!-- <h4>Magnitudes</h4> -->
                                                <label for="magnitudes">Magnitudes</label>
                                                <select class="form-control select2" style="width: 100%;"  id="magnitudes_id" name="magnitudes_id" require="">                                                    
                                                    <option value="">Seleccione una opción</option> 
                                                    <?php
                                                        foreach($data['magnitud']as $magnitud){
                                                            echo '<option value="'.$magnitud['id'].'">'. $magnitud['nombre'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>                                                                                        
                                            <div class="form-group">
                                                <label for="tipocalibracion">Tipo de Calibración</label>                                                                                                                        
                                                <select class="form-control select2" style="width: 100%;" id="calibraciones_id" name="calibraciones_id" required="">
                                                <option value="">Seleccione una opción</option> 
                                                <?php
                                                foreach ($data['tipocalibracionc'] as $tipocalibracion) {
                                                    echo '<option value="'.$tipocalibracion['id'].'">'.$tipocalibracion['nombre'].'</option>';
                                                }
                                                ?> 
                                                </select>                                                                                           
                                            </div>                                           
                                                <!-- checkbox -->
                                            <div class="form-group">
                                                <label>
                                                <input type="checkbox" class="flat-red" id="requierec" name="requierec"  checked>
                                                &nbsp; Requiere Calibración
                                                </label>                                                                                                
                                            </div> 
                                            <div class="form-group">
                                                <label>
                                                <input type="checkbox" class="flat-red" id="requierem" name="requierem"  checked>
                                                &nbsp; Requiere Mantenimiento
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                <input type="checkbox" class="flat-red" id="requierev" name="requierev"  checked>
                                                &nbsp; Requiere Verificación
                                                </label>                                                                              
                                            </div>
                                            <!-- Buscar informe  -->                                            
                                            <!-- Ocultar cuando la opcion "no requiere calibracion" se desactiva  -->
                                            <div id="grupo_informes">
                                                <div class="form-group" id="alerta_informec">                                           
                                                    <h4>Informe</h4>                                                                                      
                                                    <div class="input-group">                                                                                 
                                                        <input type="text"  class="form-control" id="informe" name='informe' placeholder="Num Informe">
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-block btn-default" id="buscar_idinformecc"> <i class="fa fa-search"></i> &nbsp; Buscar Informe</button>                                                                                                                  
                                                        </div>             
                                                    </div>
                                                </div>
                                                <div class="form-group"></div>
                                                <!-- Date -->                                            
                                                <div class="form-group">                                                
                                                    <label >Fecha de calibración</label>                                                                                               
                                                    <input type="text" class="form-control pull-right datepicker" id="fecha_calibracion" name="fecha_calibracion">                                            
                                                </div>                                            
                                                <!-- Date -->                                            
                                                <div class="form-group">                                                
                                                    <label >Fecha de vencimiento</label>                                                                                                
                                                    <input type="text" class="form-control pull-right datepicker" id="fecha_vencimiento" name="fecha_vencimiento">                                            
                                                </div>                                                                                                                                                                            
                                                <div class="form-group">
                                                    <label >Vigencia</label>                                  
                                                    <input type="number"  class="form-control" id="vigencia" name="vigencia" placeholder="12" value="12">                                                           
                                                </div>
                                                <div class="form-group">
                                                    <label >Estado de Calibración</label>                                  
                                                    <select class="form-control select2" style="width: 100%;" id="estadoc" name="estadoc">
                                                        <option value="1">Calibrado</option>                                                           
                                                        <option value="0">No Calibrado</option>
                                                    </select>
                                                </div>
                                            </div>                                                                                                                                  
                                        </div>
                                        <div class="box-footer"><button type="submit" class="btn btn-primary btn-flat">Guardar</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php importView('_static/footer'); ?>
        </div>
        <?php importView('_static/scripts'); ?>
        <script>
            var buscar_idequipo = function() {
                if (validar_text($("#idequipocc").val().trim()) == true) {
                    $.ajax({
                        url: "?c=control_calidad&a=ajax_load_equipo",
                        dataType: "json",
                        method: "POST",
                        data: "idequipo=" + $("#idequipocc").val().trim()
                    }).done(function(data) {
                        var bitacora = data;
                        //console.log(bitacora);                          
                        if (bitacora.length > 0) {                            
                            $('#table_equipocc').removeClass( "table-scroll" );
                            $('#table_equipocc tbody').remove();                    
                            $('#table_equipocc').last().addClass( "table-scroll" );
                            if(bitacora.length==1){$('#table_equipocc').removeClass( "table-scroll" );}  //Se elimina la clase cuando hay un fila en la tabla.                                                        
                            alertas_tipo_valor_col12('alerta_equipocc', 'correcto', '');                            
                            var radiocheck = '';                   
                            var filas= bitacora.length;
                            var estadoeq="";    
                            var labeleq="";
                            for (var i =  0; i < filas; i++) {
                                if (bitacora[i].activo=="1"){
                                    estadoeq="Activo";
                                    labeleq="label-success";
                                }
                                else{
                                    estadoeq="Inactivo";
                                    labeleq="label-danger";
                                }

                                if (filas == 1) { radiocheck = 'checked'; }
                                    var nuevafila = "<tr>" +
                                        "<td> <label> <input type='radio' name='equipos_id' value='" + bitacora[i].id + "' " + radiocheck + "></label></td>" +
                                        "<td>" + bitacora[i].alias + "</td>" +
                                        "<td>" + bitacora[i].descripcion + "</td>" +
                                        "<td>" + bitacora[i].marca + "</td>" +
                                        "<td>" + bitacora[i].modelo + "</td>" +
                                        "<td>" + bitacora[i].serie + "</td>" +
                                        "<td > <span class='label "+ labeleq +"'>" + estadoeq + "</spam> </td>" +
                                        "<td> <a class='btn btn-block btn-warning btn-sm' target='_blank'  href='?c=equipos&a=edit&p=" + bitacora[i].id + "'><i class='fa fa-pencil' aria-hidden='true'></i></a></td>" +
                                        +"</tr>"
                                    $("#table_equipocc").append(nuevafila);
                            }
                        } else {
                            $('#table_equipocc tbody').remove();
                            alertas_tipo_valor_col12('alerta_equipocc', 'vacio', "<p><a href='?c=equipos&a=add' target='_blank' class='btn btn-primary' style='text-decoration:none;'><i class='fa fa-plus-circle'></i> &nbsp; Agregar equipo</a></li></p>");
                        }
                    }).fail(function(data) {}).always(function(data) {
                       //console.log(data);
                    });
                } else {
                    alertas_tipo_valor_col12('alerta_equipocc', 'requerido', 'id del equipo');
                }
            } 
            
            var buscar_informe = function() {
                if (validar_text($("#informe").val().trim()) == true) {
                    $.ajax({
                        url: "?c=control_calidad&a=ajax_load_informe",
                        dataType: "json",
                        method: "POST",
                        data: "idinforme=" + $("#informe").val().trim()
                    }).done(function(data) {
                        var bitacora = data;
                        //console.log(bitacora);                                         
                        if (bitacora.length > 0) {
                                alertas_tipo_valor_col12('alerta_informec', 'correcto', '');
                                $('#fecha_calibracion').datepicker({ autoclose: true, format: 'yyyy-mm-dd' }).datepicker("setDate", bitacora[0].fecha_calibracion);
                                $('#fecha_vencimiento').datepicker({ autoclose: true, format: 'yyyy-mm-dd' }).datepicker("setDate", bitacora[0].fecha_vencimiento);
                                $('#vigencia').val(bitacora[0].periodo_calibracion);
                                if(bitacora[0].estado_calibracion=="1")
                                {
                                    $('#estadoc').select2("val","1");
                                }
                                else{
                                    $('#estadoc').select2("val","0");
                                }
                        }
                        else{
                            alertas_tipo_valor_col12('alerta_informec', 'vacio', ''); 
                        }                        
                    }).fail(function(data) {}).always(function(data) {
                       //console.log(data);
                    });
                } else {
                    alertas_tipo_valor_col12('alerta_informec', 'requerido', 'Este campo es requerido');
                }
            }

            function hide_showxtipocal(){
                var x = document.getElementById("calibraciones_id").value;
                //console.log(x);
                if(x==3){
                    hide_show_informes(false);                                 
                    $("#requierec").iCheck('uncheck');
                    $("#requierev").iCheck('uncheck');
                }
                else{                                    
                    hide_show_informes(true);
                    $("#requierec").iCheck('check');
                    $("#requierev").iCheck('check');
                } 
                if(x==2){
                    document.getElementById("buscar_idinformecc").disabled = true;
                }
                else{
                    document.getElementById("buscar_idinformecc").disabled = false;
                }               
            }

            function hide_show_informes(value){  
                if(value==true){
                    $("#grupo_informes").show();
                }
                else{
                    $("#grupo_informes").hide();
                }                
            }

            $(document).ready(function(){
                $("#buscar_idequipocc").on('click', buscar_idequipo);

                $("#idequipocc").keypress(function(e) {
                    if (e.which == 13) {   
                        $(this).val(espacio_blanco($(this).val()));      
                        buscar_idequipo();
                        e.preventDefault();
                    }
                });               

                $("#calibraciones_id").on('change', hide_showxtipocal);

                $("#requierec").on('ifChanged',function(e){
                    var isChecked= e.currentTarget.checked;
                    hide_show_informes(isChecked);                    
                });                               

                $("#buscar_idinformecc").on('click', buscar_informe);

                $("#informe").keypress(function(e) {
                    if (e.which == 13) {   
                        $(this).val(espacio_blanco($(this).val()));      
                        buscar_informe();
                        e.preventDefault();
                    }
                });                
            });
        </script>
    </body>
</html>