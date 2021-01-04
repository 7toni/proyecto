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
                      <li><a href="?c=cartastraz">Cartas de Trazabilidad <span class="sr-only"></span></a></li>
                      <li class="active"><a href="?c=cartastraz&a=ayuda">Tutorial de uso <span class="sr-only"></span></a></li>
                      
                      <!-- <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Sucursal <span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Nogales</a></li>
                          <li class="divider"></li>
                          <li><a href="#">Hermosillo</a></li>
                          <li class="divider"></li>
                          <li><a href="#">Guaymas</a></li>                                              
                        </ul>
                      </li> -->
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
                      Tutorial de uso
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

                    <div class="row">
                      <!-- <div class="col-lg-3 col-xs-6">
                        <a href="#" class="small-box-footer">
                          <div class="small-box bg-aqua">
                            <div class="inner">
                            <span class="pull-right"><i class="fa fa-flag-o"></i></span>
                              <h3></h3> 
                              <p>Multimetros</p>                             
                            </div>                                                    
                          </div>
                        </a>
                      </div> -->
                      <!-- ./col -->
                      <!-- <div class="col-lg-3 col-xs-6">
                        <a href="#" class="small-box-footer">
                          <div class="small-box bg-green">
                            <div class="inner">
                            <span class="pull-right"><i class="fa fa-flag-o"></i></span>
                              <h3></h3> 
                              <p>Calibrador multifunción</p>                             
                            </div>                                                    
                          </div>
                        </a>
                      </div> -->
                      <!-- ./col -->
                      <!-- <div class="col-lg-3 col-xs-6">                        
                        <a href="#" class="small-box-footer">
                          <div class="small-box bg-yellow">
                            <div class="inner">
                            <span class="pull-right"><i class="fa fa-flag-o"></i></span>
                              <h3></h3> 
                              <p>Juego de pesas</p>                             
                            </div>                                                    
                          </div>
                        </a>
                      </div> -->
                      <!-- ./col -->
                      <!-- <div class="col-lg-3 col-xs-6">                       
                        <a href="#" class="small-box-footer">
                          <div class="small-box bg-red">
                            <div class="inner">
                              <span class="pull-right"><i class="fa fa-flag-o"></i></span>
                              <h3></h3> 
                              <p>Juego de bloques patrón</p>                             
                            </div>                                                    
                          </div>
                        </a>
                      </div> -->
                      <!-- ./col -->
                    </div>

                     <!-- row -->
      <div class="row">
        <div class="col-md-12">
          <div class="row margin-bottom">
              <div class="col-sm-1">                
              </div>
              <div class="col-sm-4">
              <p class="text-muted text-center"  style="font-size:35px; margin: 10% 0 0 1%;" >Cada certificado corresponde a un equipo calibrado, por tanto debes ir a la sección:  <strong> Patrones utilizados en la calibración</strong> </p>
              </div>
              <div class="col-sm-7">
                <a href="storage/ayuda/cartatraz1.png" data-lightbox="perfil">
                    <img src="storage/ayuda/cartatraz1.png" class="img-responsive pad" alt="...">
                </a>
              <!-- <img src="storage/ayuda/cartatraz1.png" alt="..." class="img-responsive pad" > -->
              </div>
          </div>
          <div class="row margin-bottom">              
              <div class="col-sm-7">
                <a href="storage/ayuda/cartatraz2.png" data-lightbox="perfil">                
                  <img src="storage/ayuda/cartatraz2.png" alt="..." class="img-responsive pad" >                                
                </a>
              </div>
              <div class="col-sm-4">
                <p class="text-muted text-center"  style="font-size:35px; margin: 10% 0 0 1%;" > Ahora podrás ver la <strong> carta de trazabilidad</strong> con solo seleccionar la opción <strong> "ver cartas"</strong> </p>              
              </div>
              <div class="col-sm-1">                
              </div>
          </div>
          <div class="row margin-bottom">
              <div class="col-sm-1">                
              </div>
              <div class="col-sm-4">
              <p class="text-muted text-center"  style="font-size:35px; margin: 10% 0 0 1%;"> Podrás encontrar toda una lista de cartas, y con la <strong>Identificación</strong> que viene en tu informe, sabrás cual seleccionar o buscar</p>
              </div>
              <div class="col-sm-7">
                <a href="storage/ayuda/cartatraz3.png" data-lightbox="perfil">                
                  <img src="storage/ayuda/cartatraz3.png" alt="..." class="img-responsive pad" >                                
                </a>
              </div>
          </div>
          <div class="row margin-bottom">              
              <div class="col-sm-7"> 
                  <a href="storage/ayuda/cartatraz4.png" data-lightbox="perfil">                
                    <img src="storage/ayuda/cartatraz4.png" alt="..." class="img-responsive pad" >                                
                  </a>                
              </div>
              <div class="col-sm-4">
                <p class="text-muted text-center"  style="font-size:35px; margin: 10% 0 0 1%;" > Una manera más  sencilla de ver cartas vigentes, cartas anteriores y filtrar, podras hacerlo con unos cuantos <strong> click </strong> ¡Intentalo! </p>              
              </div>
              <div class="col-sm-1">                
              </div>
          </div>
          <div class="row margin-bottom">
              <div class="col-sm-1">                
              </div>
              <div class="col-sm-4">
              <p class="text-muted text-center"  style="font-size:45px; margin: 10% 0 0 1%;"> ¿Ya elegiste la carta que quieres ver? <strong>Mira lo que pasa</strong> </p>
              </div>
              <div class="col-sm-7">
                <a href="storage/ayuda/cartatraz5.png" data-lightbox="perfil">                
                  <img src="storage/ayuda/cartatraz5.png" alt="..." class="img-responsive pad" >                                
                </a>              
              </div>
          </div>
        </div>
        <div class="row margin-bottom">
              <div class="col-sm-7"> 
                  <a href="storage/ayuda/cartatraz6.png" data-lightbox="perfil">                
                    <img src="storage/ayuda/cartatraz6.png" alt="..." class="img-responsive pad" >                                
                  </a>                
              </div>
              <div class="col-sm-4">
                <p class="text-muted text-center"  style="font-size:35px; margin: 10% 0 0 1%;" > Si no encontraste la carta <i class="fa fa-frown-o" aria-hidden="true"></i>, no te preocupes <strong> ¡Hay otra opción! </strong> da click en la opción <strong> "Solicitar carta" </strong></p>              
              </div>
              <div class="col-sm-1">                
              </div>
        </div>
        <div class="row margin-bottom">            
              <div class="col-sm-2">                
              </div>
              <div class="col-sm-8">
                <p class="text-muted text-center"  style="font-size:35px; margin: 10% 0 0 1%;" > Esto ha sido todo. <strong> ¡Fue fácil! </strong> ¿No crees ? </p>              
              </div>
              <div class="col-sm-2">                
              </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

                   
                                         
                  </section>
                  <!-- /.content -->
              </div>
              <!-- /.container -->
            </div>
            <!-- /.content-wrapper -->
            <?php importView('_static.footer'); ?>
        </div>
        <?php importView('_static.scripts'); ?>

        <script type="text/javascript">
            
        </script>

    </body>
</html>