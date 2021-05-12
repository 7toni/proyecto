<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?> 
        <style>
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
                    <h1><?php echo $this->title; ?><small>Equipos a vencer</small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-default">
                                <div class="box-header">
                                    <h3 class="box-title">Certificados </h3>                                                                    
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                <!-- /* Agregar contenido */-->
                                     <table id="table_clientes" class="table table-bordered table-striped table-condensed" >
                                        <thead>
                                            <tr>                                                
                                                <th>No. certificado</th>
                                                <th>Id equipo</th>
                                                <th>Descripción</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>activo</th>                                                
                                                <th>Cliente</th>                                                
                                                <th>Dirección</th>
                                                <th>Acreditación</th> 
                                                <th>Calibración actual</th>
                                                <th>Vigencia</th>
                                                <th>Calibración siguiente</th>                                                
                                                <th>Comentarios</th>
                                                <th>Estado de Cal.</th>
                                                <th>proceso</th>                                                
                                                <th>Ver más</th>                                               
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
                                                <th>activo</th>                                                
                                                <th>Cliente</th>                                                
                                                <th>Dirección</th>
                                                <th>Acreditación</th> 
                                                <th>Calibración actual</th>
                                                <th>Vigencia</th>
                                                <th>Calibración siguiente</th>                                                
                                                <th>Comentarios</th>
                                                <th>Estado de Cal.</th>
                                                <th>proceso</th>                                                
                                                <th>Ver más</th> 
                                            </tr>
                                        </tfoot>
                                    </table>

                                <!-- /* Termina contenido*/-->
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal modal-default fade" id="modal-default">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header bg-blue" >                         
                            <h2 class="modal-title"><i class="fa fa-eye"></i> Certificados</h2>
                          </div>
                          <div class="modal-body">                          
                            <div class="col-sm-12 col-lg-12">                        
                                <table id="table_historialinforme" class="table table-condenced table-striped table-responsive">
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
            var controller = "<?php echo $this->name.' '.$this->ext.' recalibrar '.$usuario.' '; ?>"; 
            var planta= "<?php echo  $usuario; ?>";       
        </script>
        <?php importView('_static.scripts'); ?>
        <script type="text/javascript">
            $(window).load(function() {
                    new $.fn.dataTable.FixedColumns( table_clientes ,{
                        leftColumns:1,
                        rightColumns:1
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
                                        menu += "<a href='?c=informes&a=verinforme&p="+row['id'] +"' target='_blank' data-type='ver' class='btn btn-social-icon badge bg-green' title='Ver informe'><i class='fa fa-file-pdf-o'></i></a>";
                                    }else{
                                        menu += "<a href='#' data-type='ver' class='btn btn-social-icon badge bg-yellow disabled' title='Informe pendiente de subir'><i class='fa fa-file-pdf-o'></i></a>";
                                    }                                                                
                                    return menu;                            
                                }
                                else{  
                                    menu += "<a href='#' data-type='ver' class='btn btn-social-icon badge bg-red disabled' title='No se calibro'><i class='fa fa-file-pdf-o'></i></a>";
                                    return menu;                                  
                                }
                            },
                            "orderable" : false,
                            "searchable": false,                       
                        },
                    ],
                    'order': [[1, 'asc']]
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
               
                function verhistorial(value) {                     
                    var parametro= {                  
                        'idequipo': value,
                        'idplanta': planta
                    };

                    $.ajax({
                        type: 'post',
                        url: "?c=clienteinformes&a=ajax_historial",                        
                        data: parametro,
                    }).done(function(data) {
                        var datos = data;
                        var obj= JSON.parse(datos);
                        _tableh.clear();
                        _tableh.rows.add(obj).draw();                   
                    }).fail(function(data) {}).always( function(data) {
                        //console.log(data);                
                    });              
                    $('#modal-default').modal('show');                                                                                    
                }

        </script> 
    </body>
</html>