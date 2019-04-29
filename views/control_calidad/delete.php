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
                                    <h3 class="box-title">Eliminar </h3>
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
                                    <form method="POST" autocomplete="off"  action="?c=<?php echo $this->name; ?>&a=destroy" role="form">
                                        <input type="hidden" id="id" name="id" value="<?php echo $data['get'][0]['id']; ?>">
                                        <div class="box-body">                                                                                        
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
                                                        echo '<td ><label> <input type="radio" name="equipos_id" value="'.$data['equipo'][0]['id'] .'" checked disabled></label></td>'; 
                                                        echo '<td >'.$data['equipo'][0]['alias'] .'</td>';
                                                        echo '<td >'.$data['equipo'][0]['descripcion'] .'</td>';
                                                        echo '<td >'.$data['equipo'][0]['marca'] .'</td>';
                                                        echo '<td >'.$data['equipo'][0]['modelo'] .'</td>';
                                                        echo '<td >'. $data['equipo'][0]['serie'] .'</td>';
                                                        echo '<td > <span class="label '. $labeleq .'">' . $estadoeq . '</spam> </td>';                                                                                                      
                                                        echo '</tr>';
                                                    }
                                                ?>
                                                </tbody>                                                                                            
                                            </table>
                                            </div>
                                            <div class="form-group">
                                                <label>Fecha de ingreso</label>
                                                <?php
                                                    if(strlen($data['get'][0]['fechaingreso'])){
                                                        echo "<input type='text' class='form-control pull-right datepicker' id='fechaingreso' name='fechaingreso' value='". $data['get'][0]['fechaingreso'] ."' disabled>";
                                                    }                                                    
                                                ?>                                                                                                                                           
                                                
                                            </div>                                            
                                            <div class="form-group">
                                                <!-- <h4>Magnitudes</h4> -->
                                                <label for="magnitudes">Magnitudes</label>                                                
                                                    <?php
                                                        foreach($data['magnitud'] as $magnitud){
                                                            if(intval($data['get'][0]['magnitudes_id'])== intval($magnitud['id'])){
                                                                echo '<input type="text" class="form-control" name="magnitud" value="'.$magnitud['nombre'].'" disabled>';
                                                            }                                                                                                                       
                                                        }
                                                    ?>
                                                </select>
                                            </div>                                                                                        
                                            <div class="form-group">
                                                <label for="tipocalibracion">Tipo de Calibración</label>                                                
                                                <?php
                                                    foreach ($data['tipocalibracionc'] as $tipocalibracion) {
                                                        if($data['get'][0]['calibraciones_id'] == $tipocalibracion['id']){
                                                            echo '<input type="text" class="form-control" id="calibraciones_id" name="calibraciones_id" value="'.$tipocalibracion['nombre'].'" disabled>';
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
                                                        echo "<input type='checkbox' class='flat-red' id='requierec' name='requierec'  checked disabled>";
                                                    }
                                                    else if(data['get'][0]['requierec'] == 0){
                                                        echo "<input type='checkbox' class='flat-red' id='requierec' name='requierec' disabled>";
                                                    }
                                                    ?>                                                
                                                &nbsp; Requiere Calibración
                                                </label>                                                                                                
                                            </div> 
                                            <div class="form-group">
                                                <label>
                                                <?php
                                                    if($data['get'][0]['requierem'] == 1){
                                                        echo "<input type='checkbox' class='flat-red' id='requierem' name='requierem'  checked disabled>";
                                                    }
                                                    else if($data['get'][0]['requierem'] == 0){
                                                        echo "<input type='checkbox' class='flat-red' id='requierem' name='requierem' disabled>";
                                                    } 
                                                ?>                                              
                                                &nbsp; Requiere Mantenimiento
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label>
                                                <?php
                                                    if($data['get'][0]['requierev'] == 1){
                                                        echo "<input type='checkbox' class='flat-red' id='requierev' name='requierev'  checked disabled>";
                                                    }
                                                    else if($data['get'][0]['requierev'] == 0){
                                                        echo "<input type='checkbox' class='flat-red' id='requierev' name='requierev' disabled>";
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
                                                    <input type="text"  class="form-control" id="informe" name="informe" placeholder="Num Informe" value="<?php echo $data['get'][0]['informe']; ?>" disabled>

                                                </div>
                                                <div class="form-group"></div>
                                                <!-- Date -->                                            
                                                <div class="form-group">                                                
                                                    <label >Fecha de calibración</label>
                                                    <input type="text" class="form-control pull-right datepicker" id="fecha_calibracion" name="fecha_calibracion" value="<?php echo $data['get'][0]['fecha_calibracion'] ?>" disabled>                                                                                                                                               
                                                </div>                                            
                                                <!-- Date -->                                            
                                                <div class="form-group">                                                
                                                    <label >Fecha de vencimiento</label>
                                                    <input type="text" class="form-control pull-right datepicker" id="fecha_vencimiento" name="fecha_vencimiento" value="<?php echo $data['get'][0]['fecha_calibracion'] ?>" disabled>
                                                    
                                                </div>                                                                                                                                                                            
                                                <div class="form-group">
                                                    <label >Vigencia</label>
                                                    <input type='number'  class='form-control' id='vigencia' name='vigencia' value="<?php echo $data['get'][0]['vigencia']; ?>" disabled>                                                                                                                                                                                          
                                                </div>
                                                <div class="form-group">
                                                    <label >Estado de Calibración</label>                                  
                                                    <select class="form-control select2" style="width: 100%;" id="estadoc" name="estadoc" disabled>                                                        
                                                        <option value="1" <?php echo ($data['get'][0]['estadoc'] == 1) ? "selected='selected'" :""; ?>>Calibrado</option>                                                           
                                                        <option value="0" <?php echo ($data['get'][0]['estadoc'] == 0) ? "selected='selected'" :""; ?>>No Calibrado</option>
                                                    </select>
                                                </div>
                                            </div>                                                                                                                                  
                                        </div>
                                        <div class="box-footer"><button type="submit" class="btn btn-danger btn-flat">Eliminar</button></div>
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

            function hide_show_informes(value){  
                if(value==true){
                    $("#grupo_informes").show();
                }
                else{
                    $("#grupo_informes").hide();
                }                
            }

            $(document).ready(function(){
                <?php  echo ($data['get'][0]['calibraciones_id']==3) ? "$('#grupo_informes').hide()" : ""; ?>                
                <?php  echo ($data['get'][0]['requierec']==1) ? "$('#grupo_informes').show(); $('#requierec').iCheck('check'); " : "$('#grupo_informes').hide(); $('#requierec').iCheck('uncheck');"; ?>
                                               

                $("#requierec").on('ifChanged',function(e){
                    var isChecked= e.currentTarget.checked;
                    hide_show_informes(isChecked);                    
                });                                              

            });
        </script>
    </body>
</html>