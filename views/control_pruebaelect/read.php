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
            color: #367fa9;
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
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?></small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header">
                                    <h3 class="box-title">Control de <?php echo $this->title; ?>  Dep. Prueba Eléctrica</h3>
                                    <a href="?c=<?php echo $this->name; ?>&a=add" class="btn btn-primary btn-md pull-right btn-flat">Agregar nuevo</a>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <table id="tablecpe" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>id</th>                                                
                                                <th>Clave</th>  

                                                <th>Descripción</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Activo</th>
                                                
                                                <th>Magnitud</th>
                                                <th>Tipo de Cal.</th>                                                                                                 
                                                
                                                <th>Requiere Cal/Comp</th>
                                                <th>Informe</th>
                                                <th>Fecha de Cal/Comp</th>                                                                                                
                                                <th>Vigencia</th>
                                                <th>Fecha de Venc.</th>                                                
                                                <th>Estado de Cal/Comp</th>

                                                <th>Requiere Mant.</th>                                                
                                                <th>Ultimo Mant.</th>
                                                <th>Prox. Mant.</th>                                                                                                                                              
                                                <th>Estado Mant.</th>

                                                <th>Requiere Veri.</th>                                                
                                                <th>Ultima Veri.</th>
                                                <th>Prox. Veri.</th>                                                
                                                <th>Estado Veri.</th>                                                                                              

                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>id</th>                                                
                                                <th>Clave</th> 

                                                <th>Descripción</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Activo</th>

                                                <th>Magnitud</th>
                                                <th>Tipo de Cal.</th>                                                                                                 
                                                
                                                <th>Requiere Calibración</th>
                                                <th>Informe</th>
                                                <th>Fecha de Cal.</th>                                                                                                
                                                <th>Vigencia</th>
                                                <th>Fecha de Venc.</th>                                               
                                                <th>Estado de Cal.</th>

                                                <th>Requiere Mant.</th>                                                
                                                <th>Ultimo Mant.</th>
                                                <th>Prox. Mant.</th>                                                                                                                                              
                                                <th>Estado Mant.</th>

                                                <th>Requiere Veri.</th>                                                
                                                <th>Ultima Veri.</th>
                                                <th>Prox. Veri.</th>                                                
                                                <th>Estado Veri.</th>                                                                                      

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
           var controller = "<?php echo $this->name .'  '.'activos '; ?>";            
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

        $(document).ready(function(){

            var requiere= ["No requiere","Requiere"];
            var badge= ["bg-red","bg-green"];
            var label= ["label-info","label-success"];           

            var hoy= moment().format('YYYY-MM-DD');
            var nextmonth= moment(hoy).add(1,'months').format('YYYY-MM-DD');
            
            $('#tablecpe thead tr').clone(true).appendTo( '#tablecpe thead' );
                $('#tablecpe thead tr:eq(1) th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" style="width:100%; font-size:11px;" placeholder="'+title+'" />' );                        
            } );

            var tablecpe = $('#tablecpe').DataTable({
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
                    { "data":  3,
                        "visible" : false}, // "descripcion"
                    { "data":  4,
                        "visible" : false}, // "marca"
                    { "data":  5,
                        "visible" : false}, // "modelo"
                    { "data":  6,
                        "visible" : false}, // "serie"
                    { "data":  7,
                        "visible" : false}, // "activo"
                    { "data":  8}, // "magnitud"
                    { "data":  9}, //"calibracion"
                    { "data":  10}, // "requierec"
                    { "data":  11 }, // "informe"
                    { "data": 12 }, // "fecha_calibracion"
                    { "data": 13 }, // "fecha_vencimiento"
                    { "data": 14 }, // "vigencia"
                    { "data": 15 }, // "fecha_vencimiento"
                    { "data": 16 }, // "requierem"                   
                    { "data": 18 }, // "ultimo_mantenimiento"
                    { "data": 19 }, // "proxm"
                    { "data": 20 }, // "proxm"
                    { "data": 21 }, // "requierev"                    
                    { "data": 23 }, // "ultima_verificacion"
                    { "data": 24 }, // "proxv"
                    { "data": 25 }, // "proxv"                   
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
                    { "targets": -1 , "width": "70px", "searchable": false, "orderable" : false  },
                    {//  Requiere Calibracion; Posision: 9
                        "render": function(data,type,row){
                            var rowvalue=row[10];                        
                            return "<span class='label "+label[rowvalue] +"'>"+requiere[rowvalue] +"</span>";                         
                        },
                        "targets":9
                    },                    
                    {  //  Fecha cal; Posision: 11                                              
                        "render": function(data,type,row){
                            if(row[10]==1){
                            var rowvalue = row[12];
                                if(rowvalue != null){
                                    return rowvalue;
                                }else{
                                    return "En espera...";
                                }                            
                            }else{
                                return "No requiere";
                            }
                        },                        
                            "targets": 11                               
                    },
                    {  //  vigencia; Posision: 12                                             
                        "render": function(data,type,row){
                            if(row[10]==1){
                            var rowvalue = row[14];
                                if(rowvalue != null){
                                    return rowvalue;
                                }else{
                                    return "En espera...";
                                }                            
                            }else{
                                return "No requiere";
                            }
                        },                        
                            "targets": 12                               
                    },
                    {  //  Fecha de vencimiento; Posision: 13                                               
                        "render": function(data,type,row){
                            if(row[10]==1){
                            var rowvalue = row[15];
                                if(rowvalue != null){
                                    return rowvalue;
                                }else{
                                    return "En espera...";
                                }                            
                            }else{
                                return "No requiere";
                            }
                        },                        
                            "targets": 13                                
                    },
                    { // estado de calibracion; Posision:14
                        "render": function(data,type,row){
                            if(row[10]==1){                            
                                var rowvalue=moment(row[15]).format('YYYY-MM-DD');                                                
                                var estado="";
                                var programar= moment(nextmonth).isSame(rowvalue,'month') && moment(nextmonth).isSame(rowvalue,'year');
                                var vencido= ((moment(hoy).isSame(rowvalue,'month') && moment(hoy).isSame(rowvalue,'year')) || moment(rowvalue).isBefore(hoy));
                                var ok=  moment(rowvalue).isAfter(nextmonth);
                                if(programar == true){
                                    estado = "<span class='badge bg-yellow'> Programar </span>";
                                }
                                else if(vencido == true){
                                    estado = "<span class='badge bg-red'> Vencido </span>";
                                }
                                else if(ok== true){
                                    estado = "<span class='badge bg-green'> OK </span>";
                                }
                            }
                            else{
                                estado="<span class='label "+label[row[10]] +"'>"+requiere[row[10]] +"</span>"
                            }

                            return estado;                        
                        },
                        "targets":14
                    },                                                   
                    {//  Requiere mantenimiento; Posision: 15
                        "render": function(data,type,row){
                            var rowvalue=row[16];                        
                            return "<span class='label "+label[rowvalue] +"'>"+requiere[rowvalue] +"</span>";                         
                        },
                        "targets":15
                    },
                    { //  Ultimo mantenimiento; Posision: 16                                               
                        "render": function(data,type,row){
                            if(row[16]==1){
                            var rowvalue = row[18];                            
                                if(rowvalue != null){
                                    return (moment(rowvalue).format("MMM-YYYY"));
                                }else{
                                    return "En espera...";
                                }                            
                            }else{
                                return "<span class='label "+label[row[16]] +"'>"+requiere[row[16]] +"</span>";
                            }
                        },                        
                            "targets": 16                            
                    },
                    {  //  Proximo mantenimiento; Posision: 17                                               
                        "render": function(data,type,row){
                            if(row[16]==1){
                            var rowvalue = row[19];
                                if(rowvalue != null){
                                    return (moment(rowvalue).format("MMM-YYYY"));
                                }else{
                                    return "En espera...";
                                }                            
                            }else{
                                return "<span class='label "+label[row[16]] +"'>"+requiere[row[16]] +"</span>";
                            }
                        },                        
                            "targets": 17                                
                    },
                     {  //  Estado de mantenimiento; Posision: 18
                        "render": function(data,type,row){
                            if(row[16]==1){
                                var rowvalue=moment(row[20]).format('YYYY-MM-DD');                                                
                            var estado="";
                            var programar= moment(nextmonth).isSame(rowvalue,'month') && moment(nextmonth).isSame(rowvalue,'year');
                            var vencido= ((moment(hoy).isSame(rowvalue,'month') && moment(hoy).isSame(rowvalue,'year')) || moment(rowvalue).isBefore(hoy));
                            var ok=  moment(rowvalue).isAfter(nextmonth);
                            if(programar == true){
                                estado = "<span class='badge bg-yellow'> Programar </span>";
                            }
                            else if(vencido == true){
                                estado = "<span class='badge bg-red'> Vencido </span>";
                            }
                            else if(ok== true){
                                estado = "<span class='badge bg-green'> OK </span>";
                            }
                            }
                            else{
                                estado="<span class='label "+label[row[16]] +"'>"+requiere[row[16]] +"</span>"
                            }
                            
                            return estado;                        
                        },
                        "targets":18
                     },
                    { //  Requiere Veri.; Posision: 19
                        "render": function(data,type,row){
                            //var rowvalue=row[21];                                                   
                           return "<span class='label "+label[row[21]] +"'>"+requiere[row[21]] +"</span>";
                        },
                        "targets":19
                    },
                    { //  Ultima Veri.; Posision: 20                                               
                        "render": function(data,type,row){
                            if(row[21]==1){
                            var rowvalue = row[23];
                                if(rowvalue != null){
                                    return (moment(rowvalue).format("MMM-YYYY"));
                                }else{
                                    return "En espera...";
                                }                           
                            }else{
                                return "<span class='label "+label[row[21]] +"'>"+requiere[row[21]] +"</span>";
                            }
                        },                        
                            "targets": 20                                
                    },
                    { //  Prox. Veri.; Posision: 21                                                   
                        "render": function(data,type,row){
                            if(row[21]==1){
                            var rowvalue = row[24];
                                if(rowvalue != null){
                                    return (moment(rowvalue).format("MMM-YYYY"));
                                }else{
                                    return "En espera...";
                                }                            
                            }else{
                                return "<span class='label "+label[row[21]] +"'>"+requiere[row[21]] +"</span>";
                            }
                        },                        
                            "targets": 21                                  
                    },                   
                    { //  Prox. Veri.; Posision: 22 
                        "render": function(data,type,row){
                            if(row[21]==1){
                            var rowvalue=moment(row[25]).format('YYYY-MM-DD');                                                
                            var estado="";
                            var programar= moment(nextmonth).isSame(rowvalue,'month') && moment(nextmonth).isSame(rowvalue,'year');
                            var vencido= ((moment(hoy).isSame(rowvalue,'month') && moment(hoy).isSame(rowvalue,'year')) || moment(rowvalue).isBefore(hoy));
                            var ok=  moment(rowvalue).isAfter(nextmonth);
                            if(programar == true){
                                estado = "<span class='badge bg-yellow'> Programar </span>";
                            }
                            else if(vencido == true){
                                estado = "<span class='badge bg-red'> Vencido </span>";
                            }
                            else if(ok== true){
                                estado = "<span class='badge bg-green'> OK </span>";
                            }
                        }else{
                            estado="<span class='label "+label[row[21]] +"'>"+requiere[row[21]] +"</span>"
                        }
                            return estado;                        
                        },
                        "targets":22
                    },
                    {
                        "targets": -1,
                        "data": null,                    
                        "render": function(data,type, row){
                            var menu="<a href='?c=control_pruebaelect&a=edit&p=" + row[0]+"' data-type='edit' class='btn btn-social-icon badge bg-yellow' title='Editar'><i class='fa fa-edit'></i></a>";                    
                            if(row[16]==1){
                                menu += "<a href='?c=historialpem&a=add&p="+ row[1] +"' data-type='addm' target='_blank' class='btn btn-social-icon badge bg-blue' title='Actualizar Mantenimiento'><i class='fa fa-cogs'></i></a>";                            
                            }                        
                            if(row[21]==1){
                                menu +="<a href='?c=historialpev&a=add&p="+ row[1] +"' data-type='addv' target='_blank' class='btn btn-social-icon badge bg-gray' title=' Actualizar Verificación'><i class='fa fa-eye'></i></a>";                            
                            }                                             
                            menu += "<a href='?c=control_pruebaelect&a=cancel&p=" + row[0]+"' data-type='cancel' class='btn btn-social-icon badge bg-black' title='Baja de equipo'><i class='fa fa-power-off'></i></a>";
                            menu += "<a href='?c=inventariope&a=add&p="+ row[1] +"' data-type='addi' class='btn btn-social-icon badge bg-teal' title='Agregar a inventario'><i class='fa fa-database'></i></a>";
                            menu += "<a href='?c=control_pruebaelect&a=delete&p=" + row[0]+"' data-type='delete' class='btn btn-social-icon badge bg-red' title='Eliminar'><i class='fa fa-trash-o'></i></a>";
                            
                            return menu;                        
                        }                
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
            
            tablecpe.columns().every( function () {
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
            $('#tablecpe tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tablecpe.row( tr );
                            
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