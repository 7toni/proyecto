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
                      <li class="active"><a href="?c=cartastraz">Cartas de Trazabilidad <span class="sr-only"></span></a></li>
                      <li><a href="?c=cartastraz&a=ayuda">Tutorial de uso <span class="sr-only"></span></a></li>
                      
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
                      Cartas de Trazabilidad
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

                    <div class=row>                      
                      <div class="col-lg-12 col-md-12">
                        <div class="box box-default">
                          <div class="box-header with-border">
                            <h3 class="box-title">Cartas de trazabilidad vigentes</h3>

                            <div class="box-tools pull-right">
                              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                              </button>                              
                            </div>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body">
                            <table id="table_cartas" class="table table-striped table-hover table-condensed table-re"> 
                                        <thead>
                                            <tr>
                                              <th></th>
                                              <th>Descripción</th>
                                              <th>Fecha de incio</th>
                                              <th><i class="fa fa-calendar" ></i> Fecha de vigencia</th>
                                              <th>Otras opciones</th>
                                              <th>id</th>
                                              <th>alias</th>
                                              <th>descripcion</th>
                                              <th>marca</th>
                                              <th>modelo</th>
                                              <th>serie</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                              <th></th>
                                              <th>Descripción</th>
                                              <th>Fecha de incio</th>
                                              <th><i class="fa fa-calendar" ></i> Fecha de vigencia</th>                                
                                              <th>Otras opciones</th>
                                              <th>id</th>
                                              <th>alias</th>
                                              <th>descripcion</th>
                                              <th>marca</th>
                                              <th>modelo</th>
                                              <th>serie</th>
                                            </tr>
                                        </tfoot>
                                    </table>                                                       
                          </div>
                          <!-- /.box-body -->
                          <div class="box-footer clearfix">
                            <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a> -->
                            <a  data-toggle="modal" data-target="#modal-mensaje" class="btn btn-sm btn-info btn-flat pull-right">Solicitar carta</a>
                          </div>
                          <div id="overlay">
                              <i id="refresh"></i>
                          </div>

                          <!-- /.box-footer -->
                        </div>
                      </div>
                      
                    </div>

                    <div class="modal modal-default fade" id="modal-default">
                      <div class="modal-dialog ">
                        <div class="modal-content">
                          <div class="modal-header bg-yellow" >                         
                            <h2 class="modal-title"><i class="fa fa-eye"></i> Ver cartas anteriores </h2>
                          </div>
                          <div class="modal-body"> 
                              <p id="modal_body_historial"><p>                                                      
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

                  <div class="modal modal-default fade" id="modal-mensaje">
                      <div class="modal-dialog ">
                        <div class="modal-content">
                          <div class="modal-header bg-blue" >                         
                            <h2 class="modal-title"><i class="fa fa-email"></i> Enviar solicitud </h2>
                          </div>
                          <form>
                            <div class="modal-body">
                                <div class="form-group">
                                  <input type="email" class="form-control" placeholder="De:"  id="email" name="email" required autofocus>
                                </div>
                                <div class="form-group">
                                  <input type="text" class="form-control" placeholder="Asunto:" id="asunto" name="asunto" required >
                                </div>
                                <div class="form-group">
                                  <textarea class="form-control" rows="10" placeholder="Mensaje ..." id="mensaje" name="mensaje" required></textarea>
                                </div>
                                <div id="alertavalidacion">                        
                                  </div> 
                            </div>                          
                            <div class="modal-footer ">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>                            
                              <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Enviar</button>
                            </div>
                          </form>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                  <!-- /.modal -->

                                         
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

            $(".modal").on("hidden.bs.modal", function(){
                $("#email").val('');
                $("#asunto").val('');
                $("#mensaje").val('');
            });

            function verhistorial(value) {                             
                var array= value.split('/');
                var div="";
                $("[name='modal_body_link']").remove();
                $.each(array, function(index, value) { 
                  div += "<a href=\"?c=cartastraz&a=vercartastraz&p="+ value +"\" target='_blank' name=\"modal_body_link\"><span class=\"badge bg-red\">"+ value +"</span></a> </br>";
                    //console.log(index + ': ' + value);
                  });                
              $("#modal_body_historial").after(div);
              $('#modal-default').modal('show');                                                                                    
            }  

            /* Submit de acceso */

            $("form").submit (function(event){
              var parametro = {
                'de':$("#email").val(),
                'asunto':$("#asunto").val(),
                'mensaje':$("#mensaje").val()
              };

              var logModal = $('#modal-mensaje');

              $.ajax({
                type: 'post',
                url: "?c=cartastraz&a=ajax_enviaremail",                        
                data: parametro
              }).done(function(data) {
                var datos = data;
                if(datos== "true"){
                  //var valor= "<p>La solicitud se envio de forma correcta. Mantente en espera de la respuesta.</br> Gracias!</p>";
                 // alertas_col12('alertavalidacion', 'success', valor );
                  logModal.modal('hide');                 
                }else{
                  var valor= "<p>Por el momento tenemos un problema en enviar tu solicitud. Intentalo una vez más, si el problema persiste, ponte en contacto con nosotros <a href=\"https://mypsa.mx/\"> Click aquí</a> </br> Gracias!</p>";
                  alertas_col12('alertavalidacion', 'danger', valor );
                }                                                                                         
              }).fail(function(data) {}).always( function(data) {
                //console.log(data);                
              });              
              event.preventDefault();
            });
             
            /* Submit de acceso */
           

          $(document).ready(function() {                             

                var activarcargando= function(activo){
                    if(activo == 1){
                      $('#overlay').addClass('overlay');
                      $('#refresh').addClass('fa fa-refresh fa-spin');
                    }else if(activo == 0){
                      $('#overlay').removeClass('overlay');
                      $('#refresh').removeClass('fa fa-refresh fa-spin');
                    }         
                }

                var buscar_cartastraz = function () {
                    activarcargando(1);          
                    $.ajax({
                        url: "?c=cartastraz&a=ajax_load_historial",
                        dataType: "json",
                        method: "POST",
                        data: ''                
                    }).done(function (data) {
                        var datos = data;   
                        //console.log(datos);              
                        if (datos.length > 0) {                                                                  
                            _table.clear();
                            _table.rows.add(datos).draw();              
                        } 
                        activarcargando(0); 
                    }).fail(function (data) {
                    }).always(function (data) {
                        //console.log(data);
                    });                        
                };

               buscar_cartastraz();

                var _table = $('#table_cartas').DataTable({
                  "deferRender": true,
                  "lengthMenu": [[5, 10, 15], [5, 10, 15]],
                  "autoWidth": true,           
                  "scrollX": true,                                                    
                  "scrollY": "500px",
                  "scrollCollapse": true,
                  "columns":[
                    {"data":0},
                    {"data":1},
                    {"data":2},
                    {"data":3},
                    {"data":4},
                    {"data":5},
                    {"data":6},
                    {"data":7},
                    {"data":8},
                    {"data":9},                       
                    {"data":10} 
                  ],"columnDefs": [                                  
                    {
                        "targets": [2,5,6,7,8,9,10], "visible": false
                    },
                    {
                        "targets": [0],
                        'render': function(data, type, row, meta){                    
                          return "<a href='?c=cartastraz&a=vercartastraz&p="+row[0]+"' target='_blank'  class='btn btn-social-icon badge bg-green' data-original-title='ver carta'><i class='fa fa-file-pdf-o'></i></a>";                              
                        },
                        orderable: false,
                        searchable: false
                    }, 
                    {
                        "targets": [1],
                        'render': function(data, type, row, meta){                    
                          return  "["+row[1] +"] "+ row[7] +" "+ row[8] +" "+ row[9];
                        },                           
                    },                                                
                    {
                        "targets": [3],
                        'render': function(data, type, row, meta){                            
                          moment.locale('es');                              
                          var datehome= moment(row[2]).format("DD-MMM-YYYY");
                          var dateend= moment(row[3]).format("DD-MMM-YYYY");
                          return datehome +' a ' + dateend;                             
                        },
                    },
                    {
                        "targets": [4],
                        'render': function(data, type, row, meta){

                          var value= row[4];

                          if(value != ''){  
                            var html="<button onclick=\"verhistorial('"+ value +"')\" class=\"btn btn-warning\">Ver historial</button>";;                                                 
                            return html;                            
                          }
                          else{
                            return "";
                          }                                                     

                        },
                    },
                  ],
                  'order': [[1, 'asc']] 
                });

                

          })
        </script>

    </body>
</html>