<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
        <style>
            .prioridad {
                background-color: red !important;
            }
            thead input {
                width: 70px;                
            }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php importView('_static.header'); ?>
            <?php importView('_static.sidebar'); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle.' '. $this->sucursal; ?></small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-default">
                                <div class="box-header">
                                    <h3 class="box-title">Bitácora de informes en proceso</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <!-- /* Agregar contenido  cellspacing="0" width="100%" */-->
                                    <table id="table_proceso" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>                                                
                                                <th>Informe</th>
                                                <th>Id equipo</th>
                                                <th>Descripción</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Cliente</th>
                                                <th>Planta</th>
                                                <th>Dirección</th>
                                                <th>Tipo/calibración</th>
                                                <th># Hoja de Entrada</th>
                                                <th>Recibido por</th>
                                                <th>Fecha de entrada</th>
                                                <th>Calibración actual</th>
                                                <th>Vigencia</th>
                                                <th>Calibración siguiente</th>
                                                <th>Calibrado por</th>
                                                <th>Informe hecho por</th>
                                                <th>Acreditación</th>
                                                <th># Hoja de salida</th>
                                                <th>Entregado por</th>
                                                <th>Fecha de salida</th>
                                                <th># P.O</th>
                                                <th>Aparatos en P.O</th>
                                                <th># Factura</th>
                                                <th>Precio</th>
                                                <th>Extra</th>
                                                <th>Moneda</th>
                                                <th>Comentarios</th>
                                                <th>Estado</th>
                                                <th>Proceso</th>                                                
                                                <th>Proceso </th>
                                                <th>+ opciones</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>                                               
                                                <th>Informe</th>
                                                <th>Id equipo</th>
                                                <th>Descripción</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Cliente</th>
                                                <th>planta</th>
                                                <th>Dirección</th>
                                                <th>Tipo/calibración</th>
                                                <th># Hoja de Entrada</th>
                                                <th>Recibido por</th>
                                                <th>Fecha de entrada</th>
                                                <th>Calibración actual</th>
                                                <th>Vigencia</th>
                                                <th>Calibración siguiente</th>
                                                <th>Calibrado por</th>
                                                <th>Informe hecho por</th>
                                                <th>Acreditación</th>
                                                <th># Hoja de salida</th>
                                                <th>Entregado por</th>
                                                <th>Fecha de salida</th>
                                                <th># P.O</th>
                                                <th>Aparatos en P.O</th>
                                                <th># Factura</th>
                                                <th>Precio</th>
                                                <th>Extra</th>
                                                <th>Moneda</th>
                                                <th>Comentarios</th>
                                                <th>Estado</th>
                                                <th>Proceso</th>                                                
                                                <th>Proceso</th>
                                                <th>+ opciones</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <!-- /* Termina contenido*/-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal modal-default fade" id="modal-default">
                      <div class="modal-dialog ">
                        <div class="modal-content">
                          <div class="modal-header bg-red" >                         
                            <h2 class="modal-title"><i class="fa fa-bullhorn"></i> Confirmar </h2>
                          </div>
                          <div class="modal-body"> 
                              <p id="modal_body_cancel"><p>
                              <p id="modalvalidacion"></p>                         
                          </div>
                          <div class="modal-footer ">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-default pull-right bg-red" onclick="ajax_off();">Aceptar</button>
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>
                    <!-- /.modal -->                   

                </section>
            </div>
            <?php importView('_static.footer'); ?>
        </div>
        <script>
            var controller = "<?php echo $this->name.' '.$this->ext.' '.'3 '.$usuario.' '.$rol.''; ?>";
        </script>
        <?php importView('_static.scripts'); ?>    
        <script type="text/javascript">

            var id=0;
            informes_off = function(value) {                
                id=value;
                $("[name='body_cancel']").remove();
                var div="<h3 class='box-title' name='body_cancel'>Deseas cancelar el informe # <span class='badge bg-red'>"+ id +"</span> </h3>";
                $("#modal_body_cancel").after(div);
                $('#modal-default').modal('show');                                                                                    
            }

            function ajax_off(){
                var parametro= {                  
                    'id': id                        
                };

                $.ajax({
                    url: "?c=informes&a=ajax_turn_off",
                    dataType: "json",
                    method: "POST",
                    data: parametro
                }).done(function(data) {
                    var datos = data;
                    if(datos=="exitoso"){                                                
                        $('#table_proceso').DataTable().draw();
                        $('#modal-default').modal('hide');                      
                    }
                    else{
                        $("[name='alerta_validacion']").remove();
                            $("#modal_body_cancel").before(
                            "<div class='form-group' name='alerta_validacion'> <div class='col-sm-12'> " + "<div class='alert alert-danger alert-dismissible'>" + "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" + "<h4><i class='icon fa fa-ban'></i> Alerta!</h4> Ocurrio un problema, favor de comunicarcarlo con el administrador.</div>" + "</div>" + "</div>");
                    }                                           
                }).fail(function(data) {}).always(function(data) {
                    //console.log(data);             
                }); 
            }
            
       $(window).load(function() {
            new $.fn.dataTable.FixedColumns( table_proceso ,{
                leftColumns:1,
                rightColumns:2
            });
        } );         
        </script>    
    </body>
</html>