<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>              
    </head>
    <body class="hold-transition skin-black layout-top-nav">
        <div class="wrapper">
            <!-- Encabezado -->
            <header class="main-header">
              <nav class="navbar navbar-static-top">
                <div class="container">
                  <div class="navbar-header">
                    <a href="index.php" class="navbar-brand"><?php echo(APP_NAME); ?></a>
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                      <i class="fa fa-bars"></i>
                    </button>
                  </div>

                  <!-- Collect the nav links, forms, and other content for toggling -->
                  <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                    <ul class="nav navbar-nav">
                      <li class="active"><a href="?c=informes&a=scaninforme"> Buscar cert. calibración firmados<span class="sr-only"></span></a></li>
                      <li><a data-toggle="modal" data-target="#modal-default">Tutorial de uso <span class="sr-only"></span></a></li>                                          
                    </ul>
                    <!-- <form class="navbar-form navbar-left" role="search">
                      <div class="form-group">
                        <input type="text" class="form-control" id="navbar-search-input" placeholder="Busqueda rapida">
                      </div>
                    </form> -->
                  </div>
                  <!-- /.navbar-collapse -->
                  <!-- Navbar Right Menu -->
                  <div class="navbar-custom-menu">
                      <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                              <img src="storage/avatares/<?php echo session::get('imagen'); ?>" class="user-image" alt="User Image">
                              <span class="hidden-xs"><?php echo ucfirst(session::get('nombre')) . ' ' . ucfirst(session::get('apellido')); ?></span>
                          </a>
                          <ul class="dropdown-menu">
                              <li class="user-header">

                                  <img src="storage/avatares/<?php echo session::get('imagen'); ?>" class="img-circle" alt="User Image">
                                  <p><?php echo ucfirst(session::get('nombre')) . ' ' . ucfirst(session::get('apellido')); ?><small><?php echo ucwords(session::get('empresa')); ?></small></p>
                              </li>
                              <li class="user-body">
                                  <div class="row">
                                      <div class="col-xs-12 text-center">
                                          <?php echo ucwords(session::get('puesto')); ?>
                                      </div>
                                  </div>
                              </li>
                              <li class="user-footer">
                                  <div class="pull-left">
                                      <a href="?c=perfil" title="Acceder al perfil de usuario" class="btn btn-default btn-flat">Perfil</a>
                                  </div>
                                  <div class="pull-left">
                                      <a href="?c=usuarios&a=refresh" title="Actualizar" class="btn btn-default btn-flat"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                                  </div>

                                  <div class="pull-right">
                                      <a href="?c=login&a=logout" title="Salir del sistema" class="btn btn-default btn-flat">Cerrar Sesión</a>
                                  </div>
                                  <div class="pull-right">
                                      <a href="?c=login&a=lock" title="Bloquear sistema" class="btn btn-default btn-flat"><i class="fa fa-lock" aria-hidden="true"></i></a>
                                  </div>
                              </li>
                          </ul>
                        </li>
                      </ul>                                                            
                  </div>
                  <!-- /.navbar-custom-menu -->
                </div>
                <!-- /.container-fluid -->
              </nav>
            </header>               

            <!-- Body -->
              <!-- Full Width Column -->
            <div class="content-wrapper">
              <div class="container">
                  <!-- Content Header (Page header) -->
                  <section class="content-header">
                    <h1>
                    Buscar certificados de calibración
                      <small>Suc. <?php echo  $this->sucursal; ?></small>
                    </h1>
                    <!-- <ol class="breadcrumb">
                      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                      <li><a href="#">Layout</a></li>
                      <li class="active">Top Navigation</li>
                    </ol> -->
                  </section>

                  <!-- Main content -->
                  <section class="content">
                    <div class=row>                      
                      <div class="col-lg-12 col-md-12">
                        <form> 
                            <div class="box box-default">
                            <div class="box-header with-border">
                                <h3 class="box-title">Buscar Cert. de calibración firmados en la nube</h3>
                                <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>                              
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">                                                            
                                    <!-- textarea -->
                                    <div class="form-group">
                                        <label>Lista de cert. de calibración a buscar</label>
                                        <textarea class="form-control" rows="12" placeholder="#informe1&#10;#informe2&#10;#informe3&#10;...&#10;#informen" name="listainformes"></textarea>
                                    </div>
                                    <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-lg"><i class="fa fa-search"></i> Buscar</button>                                
                                    </div>
                                    <div id="alertavalidacion">                        
                                    </div> 
                                    <div class="form-group">
                                        <label>Cert. calibración no encontrados</label>
                                        <textarea class="form-control" rows="12" placeholder="#informe1&#10;#informe2&#10;#informe3&#10;...&#10;#informen" name="informesbuscados"></textarea>
                                    </div>  
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer clearfix">
                                                      
                            </div>
                            <div id="overlay">
                                <i id="refresh"></i>
                            </div>
                            <!-- /.box-footer -->
                            </div>
                        </form>  
                      </div>
                      
                    </div>                    
                                         
                  </section>                  
                  <!-- /.content -->
                    <div class="modal modal-default fade" id="modal-default">
                      <div class="modal-dialog ">
                        <div class="modal-content">
                          <div class="modal-header bg-blue" >                         
                            <h2 class="modal-title"><i class="fa fa-bars" aria-hidden="true"></i> Tutorial de uso</h2>
                          </div>
                          <div class="modal-body"> 
                                <div class="row margin-bottom">                                   
                                    <div class="col-sm-4">
                                    <p class="text-muted text-center"  style="font-size:20px; margin: 10% 0 0 1%;" > Una forma fácil  de revisar informes firmados en la nube, es ingresando los <strong> números </strong> que deseas comprobar, separalo con un </trong>Enter</strong> </p>
                                    </div>
                                    <div class="col-sm-8">
                                        <a href="storage/ayuda/informesnube1.png" data-lightbox="perfil">
                                            <img src="storage/ayuda/informesnube1.png" class="img-responsive pad" alt="...">
                                        </a>                                   
                                    </div>
                                </div>
                                <div class="row margin-bottom">              
                                    <div class="col-sm-8">
                                        <a href="storage/ayuda/informesnube2.png" data-lightbox="perfil">                
                                        <img src="storage/ayuda/informesnube2.png" alt="..." class="img-responsive pad" >                                
                                        </a>
                                    </div>
                                    <div class="col-sm-4">
                                        <p class="text-muted text-center"  style="font-size:20px; margin: 10% 0 0 1%;" > Ya ingresaste los números  de informe?  <strong> Da clic </strong> en nuestra opción  <strong> "Buscar informes firmados"</strong> </p>
                                    </div>                                
                                </div>
                                <div class="row margin-bottom">                                   
                                    <div class="col-sm-4">
                                    <p class="text-muted text-center"  style="font-size:20px; margin: 10% 0 0 1%;" > Espera un poco, ya que haya terminado de revisar, <strong> podrás ver una alerta</strong>, si fue el caso los números no encontrados.</p>
                                    </div>
                                    <div class="col-sm-8">
                                        <a href="storage/ayuda/informesnube3.png" data-lightbox="perfil">
                                            <img src="storage/ayuda/informesnube3.png" class="img-responsive pad" alt="...">
                                        </a>                                   
                                    </div>
                                </div>
                                <div class="row margin-bottom">            
                                    <div class="col-sm-2">                
                                    </div>
                                    <div class="col-sm-8">
                                        <p class="text-muted text-center"  style="font-size:25px; margin: 10% 0 0 1%;" > Esto ha sido todo. </br> <strong> ¡Fue fácil! </strong> ¿No crees? </p>              
                                    </div>
                                    <div class="col-sm-2">                
                                    </div>
                                </div>
                          </div>
                          <div class="modal-footer ">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>                            
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  <!-- /.modal -->

              </div>
              <!-- /.container -->
            </div>
            <!-- /.content-wrapper -->
            <?php importView('_static.footer'); ?>
        </div>
        <?php importView('_static.scripts'); ?>       
        <script type="text/javascript">
        var activarcargando= function(activo){
                    if(activo == 1){
                      $('#overlay').addClass('overlay');
                      $('#refresh').addClass('fa fa-refresh fa-spin');
                    }else if(activo == 0){
                      $('#overlay').removeClass('overlay');
                      $('#refresh').removeClass('fa fa-refresh fa-spin');
                    }         
                }

        /* Submit de acceso */
        $("form").submit (function(event){               
                activarcargando(1);
                var str= $("[name='listainformes']").val();
                var array= str.split(/\n/);                
                var parametro = {
                    'data': array           
                };               
                if(array.length >1){
                    $("[name='informesbuscados']").val('');                    
                    $.ajax({
                        type: 'post',
                        url: "?c=informes&a=ajax_scaninforme",                       
                        data: parametro
                        }).done(function(data) {
                        var datos = data;
                        var array= JSON.parse(datos); 
                        //console.log(array);
                        var text= "";
                        if(array.length > 0){
                            var valor= "<p>No hemos encontrado registros en la nube, te invito a que puedas revisar los números de informes que se muestran a continuación y vuelve a intentarlo mas tarde.</p>";
                            alertas_col12('alertavalidacion', 'danger', valor );
                            for (var i in array) {                                   
                                text += array[i] +"\n";
                            }
                        $("[name='informesbuscados']").val(text);
                        }
                        else{                       
                            var valor= "<p>Felicidades! todos los informes buscados, se encuentran exitosamente en la nube.</p>";
                            alertas_col12('alertavalidacion', 'success', valor );
                        }                                      
                    }).fail(function(data) {}).always( function(data) {
                        //console.log(data);                                   
                    });
                    $("[name='listainformes']").val('');
                }else{
                    var valor= "<p>Alerta! no se puede proceder ya que el campo de informes está vacío, favor de ingresar los datos.</p>";
                        alertas_col12('alertavalidacion', 'warning', valor ); 
                }               
                activarcargando(0);              
                event.preventDefault();
            });

        </script>
    </body>
</html>