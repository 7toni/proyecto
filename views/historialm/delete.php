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
                                    <form method="POST" autocomplete="off"  action="?c=<?php echo $this->name;?>&a=destroy" role="form">
                                        <input type="hidden" id="id" name="id" value="<?php echo $data['get'][0]['id']; ?>">
                                        <div class="box-body">                                            
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
                                                        echo '<td ><label> <input type="radio" name="equipos_id" value="'.$data['equipo'][0]['id'] .'" checked disabled></label></td>'; 
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
                                                <input type="text" class="form-control" name="tipo" value="<?php echo $data['get'][0]['tipo']; ?>" disabled>                                                                                                                                    
                                            </div>
                                             <!-- Observaciones -->
                                            <div class="form-group">
                                                <h4>Observaciones</h4>
                                                <textarea class="form-control" rows="4" id="comentario" name="comentario" placeholder="Observaciones ..." disabled><?php echo (strlen($data['get'][0]['comentario'])> 0) ? "". $data['get'][0]['comentario'] ."": ""; ?></textarea>
                                            </div>
                                             <!-- Responsable -->
                                            <div class="form-group">
                                                <h4 for="Responsable">Responsable</h4>
                                                    <?php
                                                        foreach($data['usuarios'] as $usuario){
                                                            if(($usuario["rol"] != "Administrador")){
                                                                if($data['get'][0]['responsable']== $usuario['id']){
                                                                    echo '<input class="form-control" name="" value="'.$usuario['email'] .'" disabled>';
                                                                }                                                                                                                                
                                                            }                                                            
                                                        }
                                                    ?>

                                            </div>
                                             <!-- Estado de Mantenimiento -->
                                            <div class="form-group">
                                                <h4 >Estado de mantenimiento</h4>
                                                <input type="text" class="form-control" name="estado" value="<?php echo $data['get'][0]['estado']; ?>" disabled>                                                
                                            </div>
                                            <!-- Fecha de Mantenimiento -->
                                            <div class="form-group">
                                                <h4 for="fecha_mantenimiento">Fecha de mantenimiento</h4>                                                
                                                <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right" name="fecha" value="<?php echo $data['get'][0]['fecha']; ?>" disabled>                                                                                                
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                        </div>
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-danger btn-flat">Eliminar</button>
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
    </body>
</html>