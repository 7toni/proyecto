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
                                    <h3 class="box-title">Control de Bajas Dep. Calibración</h3>
                                    <!-- <a href="?c=<?php echo $this->name; ?>&a=add" class="btn btn-primary btn-md pull-right btn-flat">Agregar nuevo</a> -->
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">

                                    <table id="tablecc_bajas" class="table table-bordered table-striped" >
                                        <thead>
                                            <tr>
                                                <th>id</th>                                                
                                                <th>Clave</th>                                              
                                                <th>Magnitud</th>
                                                <th>Tipo de Cal.</th>
                                                <th>Requiere Cal.</th>                                                                                                
                                                                                                
                                                <th>Requiere Mant.</th>                                                
                                                <th>Ultimo Mant.</th>
                                                <th>Prox. Mant.</th>                                                                                                                                              
                                                <th>Estado Mant.</th>

                                                <th>Requiere Veri.</th>                                                
                                                <th>Ultima Veri.</th>
                                                <th>Prox. Veri.</th>                                                
                                                <th>Estado Veri.</th>
                                                <th>Comentario</th>                                                                                              

                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>id</th>                                                
                                                <th>Clave</th>                                              
                                                <th>Magnitud</th>
                                                <th>Tipo de Cal.</th> 
                                                <th>Requiere Cal.</th>                                                                                                
                                                                                                
                                                <th>Requiere Mant.</th>                                                
                                                <th>Ultimo Mant.</th>
                                                <th>Prox. Mant.</th>                                                                                                                                              
                                                <th>Estado Mant.</th>

                                                <th>Requiere Veri.</th>                                                
                                                <th>Ultima Veri.</th>
                                                <th>Prox. Veri.</th>                                                
                                                <th>Estado Veri.</th>                                                                                              
                                                <th>Comentario</th>

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
           var controller = "<?php echo $this->name .' '.$this->ext.' '.'bajas '; ?>";            
           var _controller= "<?php echo $this->name ?>";
        </script>
        <?php importView('_static.scripts'); ?>
        <script>
         /* Formatting function for row details  */
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
                    '<tr>'+
                        '<td>Activo:</td>'+
                        '<td>'+d[7]+'</td>'+
                    '</tr>'+
                '</table>';
            }
            
        $(document).ready(function () {
            var requiere= ["No requiere","Requiere"];
            var badge= ["bg-red","bg-green"];
            var label= ["label-danger","label-success"];
            var hoy= moment().format('YYYY-MM-DD');
            var nextmonth= moment(hoy).add(1,'months').format('YYYY-MM-DD');

            $('#tablecc_bajas thead tr').clone(true).appendTo( '#tablecc_bajas thead' );
                $('#tablecc_bajas thead tr:eq(1) th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" style="width:100%; font-size:11px;" placeholder="'+title+'" />' );                        
            } );
            
            var tablecc_bajas = $('#tablecc_bajas').DataTable({
                "ajax": "assets/php/server_processing.php?controller=" + controller,
                "processing": true,
                "serverSide": true,
                "dataType": "jsonp",
                "lengthMenu": [[15, 20, 50,100,200,500,1000,3000, -1], [15, 20, 50,100,200,500,1000,3000, "All"]],
                "autoWidth": true,           
                "scrollX": true,
                "columns": [
                    {   "data": 0 },   //"id"
                    {
                        "className":      'details-control',                        
                        "data":           2,
                        "defaultContent": ''
                    },                                                                                                                  
                    { "data":  8}, // "magnitud"
                    { "data":  9}, //"calibracion"
                    { "data":  10}, // "requierec"                    
                    { "data": 16 }, // "requierem"                   
                    { "data": 18 }, // "ultimo_mantenimiento"
                    { "data": 19 }, // "proxm"
                    { "data": 20 }, // "proxm"
                    { "data": 21 }, // "requierev"                    
                    { "data": 23 }, // "ultima_verificacion"
                    { "data": 24 }, // "proxv"
                    { "data": 25 }, // "proxv"                   
                    { "data": 26 }, // "comentario"
                    { "data": 29 } // "fechaingreso"
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
                    {
                        "targets": -1,
                        "data": null,                    
                        "render": function(data,type, row){                                                                   
                            menu = "<a href='?c=control_calidadc&a=enable&p=" + row[0]+"' data-type='enable' class='btn btn-social-icon badge bg-green' title='Activar Equipo'><i class='fa fa-toggle-on'></i></a>";
                            menu += "<a href='?c=control_calidadc&a=delete&p=" + row[0]+"' data-type='delete' class='btn btn-social-icon badge bg-red' title='Eliminar'><i class='fa fa-trash-o'></i></a>";
                            
                            return menu;                                             
                        }                
                    },{
                        "render": function(data,type,row){
                            var rowvalue=row[10];                        
                            return "<span class='label "+label[rowvalue] +"'>"+requiere[rowvalue] +"</span>";                         
                        },
                        "targets":4
                    },{
                        "render": function(data,type,row){
                            var rowvalue=row[16];                        
                            return "<span class='label "+label[rowvalue] +"'>"+requiere[rowvalue] +"</span>";
                        },
                        "targets":5
                    },{
                        "render": function(data,type,row){
                            var rowvalue=row[21];                        
                            return "<span class='label "+label[rowvalue] +"'>"+requiere[rowvalue] +"</span>";
                        },
                        "targets":10
                    }                                    
                ],
                "language": {
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
                                                       
            tablecc_bajas.columns().every( function () {
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
            $('#tablecc_bajas tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tablecc_bajas.row( tr );
                            
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