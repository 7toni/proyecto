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
                                    <h3 class="box-title">Editar listados de <?php echo $this->name; ?></h3>
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
                                    <form method="POST" autocomplete="off" action="?c=<?php echo $this->name; ?>&a=update" role="form">
                                        <input type="hidden" name="id" value="<?php echo $data['equipo'][0]['id']; ?>">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="alias">Id de equipo</label>                                                    
                                                <input autofocus type="text" class="form-control" name="alias" id="alias" placeholder="Id de equipo" value="<?php echo $data['equipo'][0]['alias'] ?>" required="">
                                            </div>
                                            <div class="form-group" id="alerta_numeroserie">
                                                <label for="serie">Número de serie</label>                                                    
                                                <input  type="text" class="form-control" name="serie" id="serie" onchange="BuscarSerie(this.value)" placeholder="Número de serie" value="<?php echo $data['equipo'][0]['serie'] ?>" required="">
                                            </div>                                            
                                            <div class="form-group">
                                                <label for="descripciones_id">Descripción</label> 
                                                <select class="form-control select2Descripcion" name="descripciones_id" id="descripciones_id"  required="" style="width: 100%;">                                                    
                                                <!-- <option value="">Seleccione una opción</option> -->
                                                <!-- <select class="form-control select2" name="descripciones_id" id="descripciones_id"  required="">
                                                    <option value="">Seleccione una opción</option> -->
                                                <?php
                                                    $entro=false;
                                                    foreach ($data['equipos_descripciones'] as $descripcion) {
                                                        if($data['equipo'][0]['descripciones_id'] == $descripcion['id']){
                                                            $entro=true;
                                                            echo '<option value="'.$descripcion['id'].'" selected>'.$descripcion['nombre'].'</option>';
                                                            break;
                                                        } 
                                                    }

                                                    if($entro==false){
                                                        echo '<option value="">Seleccione una opción</option>';
                                                    }

                                                    // foreach ($data['equipos_descripciones'] as $descripcion) {
                                                    //     if($data['equipo'][0]['descripciones_id'] == $descripcion['id']){
                                                    //         echo '<option selected value="'.$descripcion['id'].'">'.$descripcion['nombre'].'</option>';
                                                    //         break;
                                                    //     } else{
                                                    //         echo '<option value="'.$descripcion['id'].'">'.$descripcion['nombre'].'</option>';
                                                    //     }
                                                    // }
                                                ?> 
                                                 </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="marcas_id">Marca</label>
                                                <select class="form-control select2Marca" name="marcas_id" id="marcas_id" required="" style="width: 100%;">                                                   
                                                <?php
                                                    $entro=false;
                                                    foreach ($data['equipos_marcas'] as $marca) {
                                                        if($data['equipo'][0]['marcas_id'] == $marca['id']){
                                                            $entro=true;
                                                            echo '<option selected value="'.$marca['id'].'">'.$marca['nombre'].'</option>';
                                                            break;
                                                        } 
                                                    }

                                                    if($entro==false){
                                                        echo '<option value="">Seleccione una opción</option>';
                                                    }

                                                    // foreach ($data['equipos_marcas'] as $marca) {
                                                    //     if($data['equipo'][0]['marcas_id'] == $marca['id']){
                                                    //         echo '<option selected value="'.$marca['id'].'">'.$marca['nombre'].'</option>';
                                                    //         break;
                                                    //     } else {
                                                    //         echo  '<option value="">Seleccione una opción</option>';
                                                    //     }
                                                    // }
                                                ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="modelos_id">Modelo</label>
                                                <select class="form-control select2Modelo" name="modelos_id" id="modelos_id" required="" style="width: 100%;">
                                                <?php
                                                    $entro=false;
                                                    foreach ($data['equipos_modelos'] as $modelo) {
                                                        if($data['equipo'][0]['modelos_id'] == $modelo['id']){
                                                            $entro=true;
                                                            echo '<option selected value="'.$modelo['id'].'">'.$modelo['nombre'].'</option>';
                                                            break;
                                                        }
                                                    }
                                                    if($entro==false){
                                                        echo '<option value="">Seleccione una opción</option>';
                                                    }
                                                    // foreach ($data['equipos_modelos'] as $modelo) {
                                                    //     if($data['equipo'][0]['modelos_id'] == $modelo['id']){
                                                    //         echo '<option selected value="'.$modelo['id'].'">'.$modelo['nombre'].'</option>';
                                                    //         break;
                                                    //     } else{
                                                    //         echo '<option value="'.$modelo['id'].'">'.$modelo['nombre'].'</option>';
                                                    //     }
                                                    // }
                                                ?>
                                                </select>
                                            </div>
                                                <!-- checkbox -->
                                                <div class="form-group">
                                                <label>
                                                    <?php
                                                    if($data['equipo'][0]['activo'] == 1){
                                                        echo "<input type='checkbox' class='flat-red' id='activo' name='activo'  checked>";
                                                    }
                                                    else {
                                                        echo "<input type='checkbox' class='flat-red' id='activo' name='activo'>";
                                                    }
                                                    ?>                                                
                                                &nbsp; Activo
                                                </label>                                                                                                
                                            </div> 
                                            <div class="form-group">
                                                <label for="comentarios">Comentarios</label>
                                                <input type="text" class="form-control" name="comentarios" id="comentarios" value="<?php echo $data['equipo'][0]['comentarios'] ?>"  placeholder="Comentarios">
                                            </div>
                                        </div>
                                        <div class="box-footer"><button type="submit" class="btn btn-primary btn-flat">Guardar cambios</button></div>
                                    </form>
                                    <!-- /.modal -->
                                        <div class="modal fade" id="modal-default">
                                            <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Confirmar permiso</h4>
                                                </div>
                                                <div class="modal-body box box-info"> 
                                                    <form id="form_acceso" name="form_acceso" action="#" >
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                            <label for="email">* Correo</label>
                                                            <input type="email" class="form-control" id="email" name="email" placeholder="Ingresar Correo">
                                                            </div>
                                                            <div class="form-group">
                                                            <label for="password">* Contraseña</label>
                                                            <input type="password" class="form-control" id="password" name="password" placeholder="Ingresar Contraseña">
                                                            </div>
                                                            <p id="validacion"></p>                                                    
                                                        </div>
                                                        
                                                        <!-- /.box-body -->
                                                        <div class="box-footer">
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>  
                                                        <button type="button" id="submit" class="btn btn-primary pull-right" onclick="submit_acceso()"> Enviar </button>                         
                                                        </div>                                                    
                                                    </form> 
                                                    
                                                </div>
                                            
                                            </div>
                                            <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>
                                     <!-- /.modal -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php importView('_static/footer'); ?>
        </div>
        <?php importView('_static/scripts'); ?>
        <script type="text/javascript">           
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
                                $("[name='numeroserie']").remove();
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
        </script>       
    </body>
</html>