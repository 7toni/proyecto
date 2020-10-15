<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
        <style>
            td.details-equipo {
              display: block;
              font-weight: bold;
              font-size: 15px;            
              cursor: pointer;
              color: #0073b7;                
          }
          tr.shown td.details-equipo {
            color: #00c0ef;           
          }

          td.details-factura {
              display: block;
              font-weight: bold;
              font-size: 15px;            
              cursor: pointer;
              color: #00a65a;                
          }
          tr.shown td.details-factura {
            color: #07de7b;           
          }

          td.details-direccion {
                /* display: block; */
                font-weight: bold;
                font-size: 15px;
                cursor: pointer;
                color: #00c0ef;     
                          
            } 
            tr.shown td.details-direccion {
                color: #0073b7;           
            }

        </style>           
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php importView('_static.header'); ?>
            <?php importView('_static.sidebar'); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?>  </small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-info">
                                <div class="box-header">
                                    <h3 class="box-title">Equipos calibrados</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body table-responsive">
                                    <table id="table_resultados" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>                                                
                                                <th>Informe</th>                                                
                                                <th>Clave</th>
                                                <th>Descripción</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Cliente (Sucursal/Departamento)</th>
                                                <th>Dirección</th>
                                                <th>Referencia</th>
                                                <th>Fecha de captura</th>
                                                <th>Fecha de inicio</th>
                                                <th>Tipo de calibración</th>
                                                <th>Fecha de calibración</th>
                                                <th>Vigencia</th>
                                                <th>Fecha de vencimiento</th>
                                                <th>Técnico</th>
                                                <th>Factura</th>
                                                <th>Precio</th>
                                                <th>Precio extra</th>
                                                <th>Moneda</th>
                                                <th>Fecha de salida</th>
                                                <th>Proceso</th>
                                                <th>Días antes de calibración</th>
                                                <th>Días despues de calibración</th>
                                                <th>Total de días en laboratorio</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr> 
                                                <th>Informe</th>                                                
                                                <th>Clave</th>
                                                <th>Descripción</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Cliente (Sucursal/Departamento)</th>
                                                <th>Dirección</th>
                                                <th>Referencia</th>
                                                <th>Fecha de captura</th>
                                                <th>Fecha de inicio</th>
                                                <th>Tipo de calibración</th>
                                                <th>Fecha de calibración</th>
                                                <th>Vigencia</th>
                                                <th>Fecha de vencimiento</th>
                                                <th>Técnico</th>
                                                <th>Factura</th>
                                                <th>Precio</th>
                                                <th>Precio extra</th>
                                                <th>Moneda</th>
                                                <th>Fecha de salida</th>
                                                <th>Proceso</th>
                                                <th>Días antes de calibración</th>
                                                <th>Días despues de calibración</th>
                                                <th>Total de días en laboratorio</th>                                               
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <!-- /* Termina contenido*/-->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <?php importView('_static.footer'); ?>                        
        </div>        
        <script>
            var controller = '<?php echo 'reportes'.' '.$arreglo.''; ?>'; 

        </script> 
        <?php importView('_static.scripts'); ?>

        <script type="text/javascript">
            var bg_color=["bg-red","bg-yellow","bg-aqua","bg-blue","bg-green"];
            /* Formatting function for row details  */
            function data_equipo ( d ) {
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

            function data_factura ( d ) {
                // 'd' is the original data object for the row
                var precio= (d[15] == null)  ? "" : '$ '+d[15];
                var precioex= (d[16] == null)  ? "" : '$ '+d[16];
                var moneda= (d[17] == null)  ? "" : d[17];
                return '<table class="table table-hover" >'+
                    '<tr>'+
                        '<td>Precio:</td>'+
                        '<td>'+precio+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Precio extra:</td>'+
                        '<td>'+precioex+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Moneda:</td>'+
                        '<td>'+moneda+'</td>'+
                    '</tr>'+                                   
                '</table>';
            }

            function data_direccion ( d ) {
                // 'd' is the original data object for the row              
               var referencia= (d[27] == null)  ? "" : d[27];
              
                return '<table class="table table-hover" >'+
                    '<tr>'+
                        '<td>Dirección:</td>'+
                        '<td> '+d[26]+'</td>'+
                    '</tr>'+
                    '<tr>'+
                        '<td>Referencia:</td>'+
                        '<td> '+referencia+'</td>'+
                    '</tr>'+                                                      
                '</table>';
            }
              
            $(document).ready(function(){

                var table_resultados = $('#table_resultados').DataTable({
                    "ajax": "assets/php/server_processing.php?controller=" + controller,
                    "deferRender": true,
                    "processing": true,
                    "serverSide": true,
                    "dataType": "jsonp",
                    "lengthMenu": [[15, 20, 50,100,200,500,1000,3000, -1], [15, 20, 50,100,200,500,1000,3000, "All"]],
                    "autoWidth": true,
                    "scrollX": true,                
                    dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
                    buttons: [
                        {
                            className: 'btn btn-default btn-lg',
                            extend: 'excelHtml5',
                            text: '<span class="fa fa-download"></span> Exportar todo a Excel',
                            exportOptions: {                         
                                modifier: {
                                    search: 'applied',
                                    order: 'applied'
                                }
                            },
                            title: 'Reporte_EquiposCalibrados',
                        },                                  
                    ],               
                    fixedColumns: true,
                    fixedHeader: true,
                    "columns": [
                        {   "data": 0},   //"id"                       
                        {
                            "className":      'details-equipo',                        
                            "data":           2,
                            "defaultContent": ''                   
                        },                                                                                                                  
                        { "data":  3,
                            "visible" : false}, // "descripcion"
                        { "data":  4,
                            "visible" : false}, // "marca"
                        { "data":  5,
                            "visible" : false}, // "modelo"
                        { "data":  6,
                            "visible" : false}, // "serie"                 
                        { 
                            "className":      'details-direccion',  
                            "data": 9,          // "cliente"
                            "defaultContent": ''                        
                        }, 
                        { "data": 26,   // "direccion"                                              
                        "visible" : false},                                    
                        { "data": 27,                                   
                        "visible" : false }, // "referencia"
                        { "data": 18}, //"fecha_captura"
                        { "data": 19}, //"fecha_inicio"
                        { "data": 13}, // "tipo_calibracion"
                        { "data": 20 }, // "fecha_calibracion"
                        { "data": 21 }, // "periodo_calibracion"
                        { "data": 22 }, // "fecha_vencimiento"
                        { "data": 25 }, // "tecnico"
                        { 
                            "className":      'details-factura',  
                            "data":           14, // "factura"
                            "defaultContent": ''                    
                        }, 
                        { "data": 15,   // "precio"    
                        "visible" : false},                                    
                        { "data": 16,  
                        "visible" : false }, // "precio_extra"
                        { "data": 17,
                        "visible" : false }, // "moneda"
                        { "data": 26 }, // "fecha_salida"
                        { "data": 11 }, //proceso 
                        { "data": 19}, //"fecha_inicio"
                        { "data": 25 }, // "fecha_salida"
                        { "data": 26 } // "fecha_salida"   
                    ],
                    "columnDefs": [                       
                        { "targets": [7, 17] , "width": "70px" },                   
                        {
                            "render": function(data,type,row){
                                var rowvalue=row[11];                                                     
                                var proceso=["Recepcion","Calibracion","Salida","Facturacion","Terminado"];                              
                                return "<span class='badge "+ bg_color[rowvalue] +"'>"+ proceso[rowvalue]+"</span>";                         
                            },
                            "targets":21
                        },{
                            "render": function(data,type,row){                          
                                var datehome=row[19];
                                var dateend=row[20];                          
                                var count=0;
                                if(datehome == null || dateend== null){
                                    count=0;
                                } else{
                                    var dateA= moment(datehome);
                                    var dateB= moment(dateend);                      
                                    count= dateB.diff(dateA, 'days');                              
                                }                                                                  
                                return "<span class='badge bg-black'>"+ count +"</span>";
                            },
                            "targets":22
                        },{
                            "render": function(data,type,row){
                                var datehome=row[20];
                                var dateend=row[26];
                                var count=0;
                                if(datehome == null || dateend== null){
                                    count=0;
                                } else{
                                    var dateA= moment(datehome);
                                    var dateB= moment(dateend);                      
                                    count= dateB.diff(dateA, 'days');                              
                                }                                                                  
                                return "<span class='badge bg-black'>"+ count +"</span>";
                            },
                            "targets":23
                        },{
                            "render": function(data,type,row){
                                var proceso= row[11];
                                var count=0;
                                if(proceso == 4){
                                    var dateinicio=row[19];
                                    var datecal=row[20];
                                    var datesal=row[26];                          
                                    if(dateinicio == null || datecal== null || datesal== null){
                                    count=0;
                                    } else{
                                        var dateA= moment(dateinicio);
                                        var dateB= moment(datecal);                      
                                        var dateC= moment(datesal);

                                        var count1= dateB.diff(dateA, 'days');                              
                                        var count2= dateC.diff(dateB, 'days');
                                        count = count1 + count2 ;
                                    }
                                }
                                else{
                                    count="En curso";
                                }                                                                                       
                                return "<span class='badge bg-black'>"+ count +"</span>";                     
                            },
                            "targets":24
                        }
                    ]
                });

                table_resultados.columns().every( function () {
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
                $('#table_resultados tbody').on('click', 'td.details-equipo', function () {
                    var tr = $(this).closest('tr');
                    var row = table_resultados.row( tr );
                                
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( data_equipo(row.data()) ).show();
                        tr.addClass('shown');
                    }
                } );
            
                $('#table_resultados tbody').on('click', 'td.details-factura', function () {
                    var tr = $(this).closest('tr');
                    var row = table_resultados.row( tr );
                                
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( data_factura(row.data()) ).show();
                        tr.addClass('shown');
                    }
                } ); 

                $('#table_resultados tbody').on('click', 'td.details-direccion', function () {
                    var tr = $(this).closest('tr');
                    var row = table_resultados.row( tr );
                                
                    if ( row.child.isShown() ) {
                        // This row is already open - close it
                        row.child.hide();
                        tr.removeClass('shown');
                    }
                    else {
                        // Open this row
                        row.child( data_direccion(row.data()) ).show();
                        tr.addClass('shown');
                    }
                } );

            });

        </script>
    </body>
</html>