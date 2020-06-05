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
                                    <form method="POST" autocomplete="off"  action="?c=<?php echo $this->name;?>&a=update" role="form">
                                        <input type="hidden" id="id" name="id" value="<?php echo $data['get'][0]['id']; ?>">
                                        <div class="box-body">
                                            <div class="form-group" id="alerta_equipom">
                                                <h4>Clave del equipo</h4>                                            
                                                <div class="input-group">                                  
                                                <input autofocus type="text" id="idequipom" class="form-control" placeholder="clave">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-block btn-default" id="buscar_idequipom" > <i class="fa fa-search"></i> &nbsp; Buscar Equipo</button>                                                                                                                  
                                                </div>             
                                            </div>
                                             <!-- Table Equipo -->                                            
                                            <div class="form-group table-responsive">
                                                <h4>Datos del equipo</h4>
                                                <table class="table table-condensed" id="table_equipom">
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
                                                    if(sizeof($data['equipo'][0])> 0){
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
                                             <!-- Tipo de Mantenimiento -->                                            
                                            <div class="form-group">
                                                <h4 for="tipo">Tipo de mantenimiento</h4>
                                                <select class="form-control select2" style="width: 100%;" id="tipo" name="tipo" required="">                                
                                                        <option value="0" <?php  echo ($data['get'][0]['tipo']=='Preventivo') ? "selected='selected'": ""; ?>>Preventivo</option>                                                           
                                                        <option value="1" <?php  echo ($data['get'][0]['tipo']=='Correctivo') ? "selected='selected'": ""; ?>>Correctivo</option>                                                        
                                                </select>                                                                                           
                                            </div>
                                             <!-- Observaciones -->
                                            <div class="form-group">
                                                <h4>Observaciones</h4>
                                                <textarea class="form-control" rows="4" id="comentario" name="comentario" placeholder="Observaciones ..." ><?php echo (strlen($data['get'][0]['comentario'])> 0) ? "". $data['get'][0]['comentario'] ."": ""; ?></textarea>
                                            </div>
                                             <!-- Responsable -->
                                            <div class="form-group">
                                                <h4 for="Responsable">Responsable</h4>                                                                                               
                                                <select class="form-control select2" style="width: 100%;"  id="responsable" name="responsable" require="">                                                    
                                                    <option value="">Seleccione una opción</option> 
                                                    <?php
                                                        foreach($data['usuarios'] as $usuario){
                                                            if(($usuario['rol'] != "Administrador")){
                                                                if($data['get'][0]['responsable'] == $usuario['id']){
                                                                    echo '<option value="'.$usuario['id'].'" selected="selected">'. $usuario['email'].'</option>';
                                                                }
                                                                else{
                                                                    echo '<option value="'.$usuario['id'].'">'. $usuario['email'].'</option>';
                                                                }                                                                
                                                            }                                                            
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                             <!-- Estado de Mantenimiento -->
                                            <div class="form-group">
                                                <h4 >Estado de mantenimiento</h4>
                                                <select class="form-control select2" style="width: 100%;" id="estado" name="estado">
                                                    <option value="0" <?php  echo ($data['get'][0]['estado']=='Completo') ? "selected='selected'": ""; ?>>Completo</option>
                                                    <option value="1" <?php  echo ($data['get'][0]['estado']=='Pendiente') ? "selected='selected'": ""; ?>>Pendiente</option>
                                                </select>
                                            </div>
                                            <!-- Fecha de Mantenimiento -->
                                            <div class="form-group">
                                                <h4 for="fecha_mantenimiento">Fecha de mantenimiento</h4>

                                                <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <?php
                                                        echo (strlen($data['get'][0]['fecha']) > 0 ) ? "<input type='text' class='form-control pull-right datepicker_aux' id='fecha' name='fecha' value='". $data['get'][0]['fecha'] ."'>" : "<input type='text' class='form-control pull-right datepicker' id='fecha' name='fecha' require=''>" ;
                                                ?>                                                 
                                                </div>
                                                <!-- /.input group -->
                                            </div>

                                            <!-- Pendiente, a evaluar con Melissa  -->
                                            <!-- <div class="form-group">      
                                                <h4 >Vigencia</h4>                                                                                    
                                                <input type="number" class="form-control" id="vigencia" name="vigencia" require="">                                                
                                            </div>

                                            <div class="form-group">                                      
                                                <h4 for="fecha_vencimiento">Fecha de vencimiento</h4>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right datepicker" id="fecha" name="fecha" require="">
                                                </div>
                                            </div> -->
                                            
                                            <!-- /.form group -->
                                            <div class="form-group">
                                                <h4><input type="checkbox" class="flat-red"  name="actualizarm">&nbsp; Actualizar el control de calidad</h4>                                                
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-info btn-flat">Editar</button>
                                            <button type="button" class="btn btn-danger btn-flat pull-right" onClick="history.back()">Cancelar</button>
                                        </div>
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
                if (validar_text($("#idequipom").val().trim()) == true) {
                    $.ajax({
                        url: "?c=control_calidadc&a=ajax_load_equipo",
                        dataType: "json",
                        method: "POST",
                        data: "idequipo=" + $("#idequipom").val().trim()
                    }).done(function(data) {
                        var bitacora = data;
                        //console.log(bitacora);                          
                        if (bitacora.length > 0) {                            
                            $('#table_equipom').removeClass( "table-scroll" );
                            $('#table_equipom tbody').remove();                    
                            $('#table_equipom').last().addClass( "table-scroll" );
                            if(bitacora.length==1){$('#table_equipom').removeClass( "table-scroll" );}  //Se elimina la clase cuando hay un fila en la tabla.                                                        
                            alertas_tipo_valor_col12('alerta_equipom', 'correcto', '');                            
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
                                    $("#table_equipom").append(nuevafila);
                            }
                        } else {
                            $('#table_equipom tbody').remove();
                            alertas_tipo_valor_col12('alerta_equipom', 'vacio', "<p><a href='?c=equipos&a=add' target='_blank' class='btn btn-primary' style='text-decoration:none;'><i class='fa fa-plus-circle'></i> &nbsp; Agregar equipo</a></li></p>");
                        }
                    }).fail(function(data) {}).always(function(data) {
                       //console.log(data);
                    });
                } else {
                    alertas_tipo_valor_col12('alerta_equipom', 'requerido', 'id del equipo');
                }
            } 

            $(document).ready(function(){
                $("#buscar_idequipom").on('click', buscar_idequipo);

                $("#idequipom").keypress(function(e) {
                    if (e.which == 13) {   
                        $(this).val(espacio_blanco($(this).val()));      
                        buscar_idequipo();
                        e.preventDefault();
                    }
                }); 
            });
        </script>     
    </body>
</html>