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
                                    <h3 class="box-title">Editar </h3>
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
                                    <form method="POST" autocomplete="off"  action="?c=<?php echo $this->name; ?>&a=update" role="form">
                                        <input type="hidden" id="id" name="id" value="<?php echo $data['get'][0]['id']; ?>">
                                        <div class="box-body">                                            
                                            <div class="form-group" id="alerta_equipocc">                                           
                                                <h4>Clave del equipo</h4>                                            
                                                <div class="input-group">                                  
                                                <input autofocus type="text" id="idequipocc" class="form-control" placeholder="clave" >
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
                                                <?php                                                
                                                    if(strlen($data['get'][0]['equipos_id'])> 0){
                                                        $estadoeq="";
                                                        $labeleq="";
                                                        if ($data['equipo'][0]['activo']==1){
                                                            $estadoeq="Activo";
                                                            $labeleq="label-success";
                                                        }
                                                        else{
                                                            $estadoeq="Inactivo";
                                                            $labeleq="label-danger";
                                                        }                                                        
                                                        echo '<tr>';  
                                                        echo '<td ><label> <input type="radio" name="equipos_id" value="'.$data['equipo'][0]['id'] .'" checked></label></td>'; 
                                                        echo '<td >'.$data['equipo'][0]['alias'] .'</td>';
                                                        echo '<td >'.$data['equipo'][0]['descripcion'] .'</td>';
                                                        echo '<td >'.$data['equipo'][0]['marca'] .'</td>';
                                                        echo '<td >'.$data['equipo'][0]['modelo'] .'</td>';
                                                        echo '<td >'. $data['equipo'][0]['serie'] .'</td>';
                                                        echo '<td > <span class="label '. $labeleq .'">' . $estadoeq . '</spam> </td>';                                              
                                                        echo '<td > <a class="btn btn-block btn-warning btn-sm" target="_blank" href="?c=equipos&a=edit&p='.$data['equipo'][0]['id'].'"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>';
                                                        echo '</tr>';
                                                    }
                                                ?>
                                                </tbody>                                                                                            
                                            </table>
                                            </div>
                                            <div class="form-group">
                                                <label>Fecha de ingreso</label>
                                                <?php
                                                    if(strlen($data['get'][0]['fechaingreso']) > 0){
                                                        echo "<input type='text' class='form-control pull-right datepicker_aux' id='fechaingreso' name='fechaingreso' value='". $data['get'][0]['fechaingreso'] ."'>";
                                                    }
                                                    else{
                                                        echo "<input type='text' class='form-control pull-right datepicker' id='fechaingreso' name='fechaingreso' require=''>";
                                                    }
                                                ?>                                                                                                                                           
                                                
                                            </div>                                            
                                            <div class="form-group">
                                                <!-- <h4>Magnitudes</h4> -->
                                                <label for="magnitudes">Magnitudes</label>
                                                <select class="form-control select2" style="width: 100%;"  id="magnitudes_id" name="magnitudes_id" require="">                                                    
                                                    <option value="">Seleccione una opción</option> 
                                                    <?php
                                                        foreach($data['magnitud']as $magnitud){
                                                            if(intval($data['get'][0]['magnitudes_id'])== intval($magnitud['id'])){
                                                                echo '<option value="'.$magnitud['id'].'" selected="selected">'. $magnitud['nombre'].'</option>';
                                                            }
                                                            else{
                                                                echo '<option value="'.$magnitud['id'].'">'. $magnitud['nombre'].'</option>';
                                                            }
                                                            
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
                                                    if(intval($data['get'][0]['calibraciones_id']) == $tipocalibracion['id']){
                                                        echo '<option value="'.$tipocalibracion['id'].'" selected="selected">'.$tipocalibracion['nombre'].'</option>';
                                                    }
                                                    else{
                                                        echo '<option value="'.$tipocalibracion['id'].'">'.$tipocalibracion['nombre'].'</option>';
                                                    }
                                                    
                                                }
                                                ?> 
                                                </select>                                                                                           
                                            </div>                                           
                                                <!-- checkbox -->
                                            <div class="form-group">
                                                <label>
                                                    <?php
                                                    if($data['get'][0]['requierec'] == 1){
                                                        echo "<input type='checkbox' class='flat-red' id='requierec' name='requierec'  checked>";
                                                    }
                                                    else if(data['get'][0]['requierec'] == 0){
                                                        echo "<input type='checkbox' class='flat-red' id='requierec' name='requierec'>";
                                                    }
                                                    ?>                                                
                                                &nbsp; Requiere Calibración
                                                </label>                                                                                                
                                            </div> 
                                            <div class="form-group">
                                                <label>
                                                <?php
                                                    if($data['get'][0]['requierem'] == 1){
                                                        echo "<input type='checkbox' class='flat-red' id='requierem' name='requierem'  checked>";
                                                    }
                                                    else if($data['get'][0]['requierem'] == 0){
                                                        echo "<input type='checkbox' class='flat-red' id='requierem' name='requierem'>";
                                                    } 
                                                ?>                                              
                                                &nbsp; Requiere Mantenimiento
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                <?php
                                                    if($data['get'][0]['requierev'] == 1){
                                                        echo "<input type='checkbox' class='flat-red' id='requierev' name='requierev'  checked>";
                                                    }
                                                    else if($data['get'][0]['requierev'] == 0){
                                                        echo "<input type='checkbox' class='flat-red' id='requierev' name='requierev'>";
                                                    } 
                                                ?>                                                
                                                &nbsp; Requiere Verificación
                                                </label>                                                                              
                                            </div>
                                            <!-- Buscar informe  -->                                            
                                            <!-- Ocultar cuando la opcion "no requiere calibracion" se desactiva  -->                                            
                                            <div id="grupo_informes">
                                                <div class="form-group" id="alerta_informec">                                           
                                                    <h4>Informe</h4>                                                                                      
                                                    <div class="input-group">
                                                        <?php
                                                        echo (strlen($data['get'][0]['informe']) > 0 ) ?  "<input type='text'  class='form-control' id='informe' name='informe' placeholder='Num Informe' value='". $data['get'][0]['informe'] ."'>": "<input type='text'  class='form-control' id='informe' name='informe' placeholder='Num Informe'>" ;
                                                        ?>                                                                                                                                         
                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-block btn-default" id="buscar_idinformecc"> <i class="fa fa-search"></i> &nbsp; Buscar Informe</button>                                                                                                                  
                                                        </div>             
                                                    </div>
                                                </div>
                                                <div class="form-group"></div>
                                                <!-- Date -->                                            
                                                <div class="form-group">                                                
                                                    <label >Fecha de calibración</label>
                                                    <?php
                                                        echo (strlen($data['get'][0]['fecha_calibracion']) > 0 ) ? "<input type='text' class='form-control pull-right datepicker_aux' id='fecha_calibracion' name='fecha_calibracion' value='". $data['get'][0]['fecha_calibracion'] ."'>" : "<input type='text' class='form-control pull-right datepicker' id='fecha_calibracion' name='fecha_calibracion'>" ;
                                                    ?>                                                                                              
                                                    <!-- <input type="text" class="form-control pull-right datepicker" id="fecha_calibracion" name="fecha_calibracion">-->
                                                </div>
                                                <div class="form-group">
                                                    <label >Vigencia</label> 
                                                    <?php
                                                        echo (strlen($data['get'][0]['vigencia']) > 0) ? "<input type='number' class='form-control' id='vigencia' name='vigencia' placeholder='12' value='". $data['get'][0]['vigencia'] ."'>" : "<input type='number'  class='form-control' id='vigencia' name='vigencia' placeholder='12' value='12'>";
                                                    ?>                                 
                                                    <!-- <input type="number"  class="form-control" id="vigencia" name="vigencia" placeholder="12" value="12"> -->
                                                </div>                                           
                                                <!-- Date -->                                            
                                                <div class="form-group">                                                
                                                    <label >Fecha de vencimiento</label> 
                                                    <?php
                                                        echo (strlen($data['get'][0]['fecha_vencimiento']) > 0) ? "<input type='text' class='form-control pull-right datepicker_aux' id='fecha_vencimiento' name='fecha_vencimiento' value='". $data['get'][0]['fecha_vencimiento'] ."'>" : "<input type='text' class='form-control pull-right datepicker' id='fecha_vencimiento' name='fecha_vencimiento'>";
                                                    ?>                                                                                               
                                                    <!-- <input type="text" class="form-control pull-right datepicker" id="fecha_vencimiento" name="fecha_vencimiento"> -->
                                                </div>                                               
                                                <div class="form-group">
                                                    <label >Estado de Calibración</label>                                  
                                                    <select class="form-control select2" style="width: 100%;" id="estadoc" name="estadoc">                                                        
                                                        <option value="1" <?php echo ($data['get'][0]['estadoc'] == 1) ? "selected='selected'" :""; ?>>Calibrado</option>                                                           
                                                        <option value="0" <?php echo ($data['get'][0]['estadoc'] == 0) ? "selected='selected'" :""; ?>>No Calibrado</option>
                                                    </select>
                                                </div>
                                            </div>                                                                                                                                  
                                        </div>
                                        <div class="box-footer"><button type="submit" class="btn btn-info btn-flat">Editar</button> <button type="button" class="btn btn-danger btn-flat pull-right" onClick="history.back()">Cancelar</button></div>
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
                        url: "?c=control_pruebaelect&a=ajax_load_equipo",
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

            function calcular_fecha(){                      
                var datecal= $('#fecha_calibracion').val();
                var periodo= $('#vigencia').val();
                //var vigencia= $('#vigencia').val();
                // var setdate= ["","M","days"];                
                
                var datetemp=moment(datecal);
                var fechavenc= datetemp.add(periodo, "M").format('YYYY-MM-DD');  
                
                $('#fecha_vencimiento').datepicker({                
                    autoclose: true,
                    format: 'yyyy-mm-dd'
                }).datepicker('setDate', fechavenc);
            }


            $(document).ready(function(){
                <?php  echo ($data['get'][0]['calibraciones_id']==3) ? "$('#grupo_informes').hide()" : ""; ?>
                <?php  echo ($data['get'][0]['calibraciones_id']==2) ? "document.getElementById('buscar_idinformecc').disabled = true;" : "document.getElementById('buscar_idinformecc').disabled = false;"; ?>
                <?php  echo ($data['get'][0]['requierec']==1) ? "$('#grupo_informes').show(); $('#requierec').iCheck('check'); " : "$('#grupo_informes').hide(); $('#requierec').iCheck('uncheck');"; ?>

                
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

                $( "#fecha_calibracion" ).change(function() {
                    calcular_fecha();
                });
                
                $( "#vigencia" ).change(function() {
                    calcular_fecha();
                });


            });
        </script>
    </body>
</html>