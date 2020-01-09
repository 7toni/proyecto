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
        }
        tr.shown td.details-control {
            color: Green;            
        }
        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php importView('_static.header'); ?>
            <?php importView('_static.sidebar'); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?></small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title"><?php echo $this->title; ?> Dep. Calibración</h3>
                                    <a href="?c=<?php echo $this->name; ?>&a=add" class="btn btn-primary btn-md pull-right btn-flat">Agregar nuevo</a>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">

                                    <table id="table_historialcv" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>id</th>                                                
                                                <th>Clave</th>

                                                <th>Fecha de Veri.</th>                                                                                          
                                                <th>Responsable</th>
                                                
                                                <th>Comentarios</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>                                                
                                                <th>id</th>                                                
                                                <th>Clave</th>                                                
                                                <th>Fecha de Veri.</th>                                                                                          
                                                <th>Responsable</th>
                                                
                                                <th>Comentarios</th>
                                                <th>Acción</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php importView('_static.footer'); ?>
        </div>
        <script>
           var controller = "<?php echo $this->name .' '.$this->ext; ?>";            
        </script>
        <?php importView('_static.scripts'); ?> 
        <script>
            /* Formatting function for row details - modify as you need */
            function format ( d ) {                
                // 'd' is the original data object for the row
                return '<table class="table table-hover" >'+
                    '<tr>'+
                        '<td>Descripción:</td>'+
                        '<td> '+d[3]+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Marca:</td>'+
                        '<td>'+d[4]+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Modelo:</td>'+
                        '<td>'+d[5]+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Serie:</td>'+
                        '<td>'+d[6]+'</td>'+
                    '</tr>'+
                '</table>';
            }

            $(document).ready(function(){

                $('#table_historialcv thead tr').clone(true).appendTo( '#table_historialcv thead' );
                $('#table_historialcv thead tr:eq(1) th').each( function () {
                    var title = $(this).text();
                    $(this).html( '<input type="text" style="width:100%; font-size:11px;" placeholder="'+title+'" />' );                        
                } );
                
                var table_historialcv = $('#table_historialcv').DataTable({
                    "ajax": "assets/php/server_processing.php?controller=" + controller,            
                    "processing": true,
                    "serverSide": true,
                    "dataType": "jsonp",
                    "lengthMenu": [[15, 20, 50,100,200,500,1000,3000, -1], [15, 20, 50,100,200,500,1000,3000, "All"]],
                    "autoWidth": true,           
                    "scrollX": true,
                    "columns": [
                        { "data": 0 },   //"id"
                        {
                            "className":      'details-control',
                            "orderable":      false,
                            "data":           2,
                            "defaultContent": ''
                        },                                                                                                                  
                        { "data":  7}, // "ultima_verificacion"
                        { "data":  9}, //"email"
                        { "data":  10}, // "comentario"                      
                        { "data": 11 } // "fecha_registro"
                    ],
                    dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
                    buttons: [
                        {
                            extend: 'excel',
                            text: 'Excel',
                            exportOptions: {
                                columns: [':not(:last-child)' ]
                            },
                        }                
                    ],
                    fixedColumns: true,            
                    "columnDefs": [
                        { "width": "90px", "targets": -1 },
                        {
                            "targets": -1,
                            "data": null,                    
                            "render": function(data,type, row){
                                return "<a href='?c=historialcv&a=edit&p="+ row[0]+"' data-type='edit' class='btn btn-social-icon badge bg-yellow' title='Editar'><i class='fa fa-edit'></i></a> <a href='?c=historialcv&a=delete&p="+ row[0]+"' data-type='delete' class='btn btn-social-icon badge bg-red' title='Eliminar'><i class='fa fa-trash-o'></i></a>"
                            }                        
                        },                                                                            
                    ],"language": {
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

                table_historialcv.columns().every( function () {
                    var that = this;
                    $( 'input', this.header() ).on( 'keyup change', function () {
                        if ( that.search() !== this.value ) {
                            that                        
                                .search(this.value)
                                .draw();
                        }
                    });
                });

                // Add event listener for opening and closing details
                $('#table_historialcv tbody').on('click', 'td.details-control', function () {
                    var tr = $(this).closest('tr');
                    var row = table_historialcv.row( tr );
                                
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

            });
        </script>             
    </body>
</html>