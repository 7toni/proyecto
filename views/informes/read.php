<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?> 
        <style>
            thead input {
            width: 70px;                
            }

            td.details-cliente {
            display: block;
            font-weight: bold;
            font-size: 17px;            
            cursor: pointer;
            color: #00A65A;                
            }
            tr.shown td.details-cliente {
            color: #006336;           
            }

            td.details-hojaentrada {
            display: block;
            font-weight: bold;
            font-size: 17px;            
            cursor: pointer;
            color: #00C0EF;                
            }
            tr.shown td.details-hojaentrada {
            color: #00738f;           
            }

            td.details-hojasalida {
            display: block;
            font-weight: bold;
            font-size: 17px;            
            cursor: pointer;
            color: #0073B7;                
            }
            tr.shown td.details-hojasalida {
            color: #00456d;           
            }

            td.details-factura {
            display: block;
            font-weight: bold;
            font-size: 17px;            
            cursor: pointer;
            color: #00A65A;                
            }
            tr.shown td.details-factura {
            color: #006336;           
            }
            
            td.details-control {
                display: block;
                font-weight: bold;
                font-size: 15px;            
                cursor: pointer;
                color: #0073b7;                
            }
            tr.shown td.details-control {
                color: #00c0ef;           
            }        
          
        </style>    
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php importView('_static.header'); ?>
            <?php importView('_static.sidebar'); ?>            
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle.' '. $this->sucursal; ?> </small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-default">
                                <div class="box-header">
                                    <h3 class="box-title">Bitácora completa</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <!-- /* Agregar contenido */-->                                    
                                    <table id="table_informes" class="table table-bordered table-striped"> 
                                        <thead>
                                            <tr>
                                                <th>Certificado</th>
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
                                                <th>Proceso %</th>    
                                                <th class="text-center">&nbsp;Ver&nbsp;</th>
                                                <th>+ opciones</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                            <th>Certificado</th>
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
                                            <th>Proceso %</th> 
                                            <th class="text-center">&nbsp;Ver&nbsp;</th>
                                            <th > + opciones</th> 
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

                  <div class="modal modal-default fade" id="modal-historial">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-blue" >                         
                                <h2 class="modal-title"><i class="fa fa-eye"></i> Certificados</h2>
                            </div>
                            <div class="modal-body">                                
                                <table id="table_historialinforme" class="table">
                                    <thead>
                                        <tr>                                                
                                            <th>No. certificado</th>
                                            <th>Id equipo</th>
                                            <th>Descripción</th>
                                            <th>Marca</th>
                                            <th>Modelo</th>
                                            <th>Serie</th>
                                            <!-- <th>activo</th> -->
                                            <th>Acreditación</th> 
                                            <th>Calibración actual</th>
                                            <th>Vigencia</th>
                                            <th>Calibración siguiente</th>
                                            <th>Ver certificado</th>                                               
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>                                               
                                            <th>No. certificado</th>
                                            <th>Id equipo</th>
                                            <th>Descripción</th>
                                            <th>Marca</th>
                                            <th>Modelo</th>
                                            <th>Serie</th>
                                            <!-- <th>activo</th> -->
                                            <th>Acreditación</th> 
                                            <th>Calibración actual</th>
                                            <th>Vigencia</th>
                                            <th>Calibración siguiente</th>
                                            <th>Ver certificado</th> 
                                        </tr>
                                    </tfoot>
                                </table>                                                                                                                                                     
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

                </section>
            </div>
            <?php importView('_static.footer'); ?>
        </div>
        <script>
        var controller = "<?php echo $this->name.' '.$this->ext.'_v1 '.$proceso.' '.$usuario.' '.$rol.''; ?>";        
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
                        $('#table_informes').DataTable().draw();
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
                new $.fn.dataTable.FixedColumns( table_informes ,{                       
                    leftColumns:0,
                    rightColumns:3
                });
            });

            /* Formatting function for row details  */
            function format ( d ) {
                    // 'd' is the original data object for the row
                    return '<table class="table table-condensed" >'+
                        '<tr>'+
                            '<td>Descripción:</td>'+
                            '<td> '+d['descripcion']+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td>Marca:</td>'+
                            '<td>'+d['marca']+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td>Modelo:</td>'+
                            '<td>'+d['modelo']+'</td>'+
                        '</tr>'+
                        '<tr>'+
                            '<td>Serie:</td>'+
                            '<td>'+d['serie']+'</td>'+
                        '</tr>'+
                    
                    '</table>';
                }

            var _tableh = $('#table_historialinforme').DataTable({
                "deferRender": true,
                "lengthMenu": [[5, 10], [5, 10]],
                "autoWidth": true,
                "responsive": true,           
                "scrollX": true,                                                    
                "scrollY": "500px",
                "scrollCollapse": true,
                "columns":[
                    {"data":"id"},
                    {
                        "className":      'details-control',                        
                        "data":           "alias",
                        "defaultContent": ''
                    },
                    { "data":  "descripcion",
                        "visible" : false}, // "descripcion"
                    { "data":  "marca",
                        "visible" : false}, // "marca"
                    { "data":  "modelo",
                        "visible" : false}, // "modelo"
                    { "data":  "serie",
                        "visible" : false}, // "serie"
                    {"data":"acreditacion"},
                    {"data":"fecha_calibracion"},
                    {"data":"periodo_calibracion"},
                    {"data":"fecha_vencimiento"},                     
                    {"data":"isfile"},
                ],"columnDefs": [                  
                    //estado_calibracion                        
                    {
                        "targets": 10,                                 
                        "render": function(data,type, row){                                                 
                            var menu="";
                            if(row['estado_calibracion'] == "1"){
                                if(row['isfile']== "1"){
                                    menu += "<a href='?c=informes&a=verinforme&p="+row['id'] +"' target='_blank' data-type='ver' class='btn btn-social-icon badge bg-green' title='Ver certificado'><i class='fa fa-file-pdf-o'></i></a>";
                                }else{
                                    menu += "<a href='#' data-type='ver' class='btn btn-social-icon badge bg-yellow' title='Certificado pendiente de subir'><i class='fa fa-file-pdf-o'></i></a>";
                                }                                                                
                                return menu;                            
                            }
                            else{  
                                menu += "<a href='#' data-type='ver' class='btn btn-social-icon badge bg-red' title='No se calibro'><i class='fa fa-file-pdf-o'></i></a>";
                                return menu;                                  
                            }
                        },
                        "orderable" : false,
                        "searchable": false,                       
                    },
                ],
                'order': [[0, 'desc']]
                ,"language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros de _START_ a _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                } 
            });

            // Add event listener for opening and closing details
            $('#table_historialinforme tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = _tableh.row( tr );
                            
                if ( row.child.isShown() ) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    // Open this row
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );

             verhistorial = function(value) {
                var parametro= {                  
                    'informe': value
                };            

                $.ajax({
                    type: 'post',
                    url: "?c=informes&a=ajax_historial",                        
                    data: parametro,
                }).done(function(data) {
                    var datos = data;
                    var obj= JSON.parse(datos);                   
                    _tableh.clear();
                    _tableh.rows.add(obj).draw();                   
                }).fail(function(data) {}).always( function(data) {
                    //console.log(data);                
                });              
                $('#modal-historial').modal('show');                                                                                    
            }

        
       

        </script> 
    </body>
</html>