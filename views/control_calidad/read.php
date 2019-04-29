<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
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
                                    <h3 class="box-title">Listado de <?php echo $this->name; ?></h3>
                                    <a href="?c=<?php echo $this->name; ?>&a=add" class="btn btn-primary btn-md pull-right btn-flat">Agregar nuevo</a>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body table-responsive">

                                    <table id="table_controlcalidad" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Id Equipo</th>
                                                <th>Clave</th>                                                
                                                <th>Descripcion</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Estado</th>
                                                <th>Magnitud</th>
                                                <th>Tipo de Cal.</th>                                                                                                 
                                                
                                                <th>Requiere Calibración</th>
                                                <th>Informe</th>
                                                <th>Fecha de Cal.</th>
                                                <th>Fecha de Venc.</th>                                                
                                                <th>Vigencia</th>                                                
                                                <th>Estado de Cal.</th>

                                                <th>Requiere Mant.</th>
                                                <th>Mantenimiento Id</th>
                                                <th>Ultimo Mant.</th>
                                                <th>Prox. Mant.</th>                                                                                                                                              
                                                <th>Estado Mant.</th>

                                                <th>Requiere Veri.</th>
                                                <th>Verificacion Id</th>
                                                <th>Ultima Veri.</th>
                                                <th>Prox. Veri.</th>                                                
                                                <th>Estado Veri.</th>

                                                <th>Comentario</th>
                                                <th>Fecha</th>
                                                <th>Responsable</th>

                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Id Equipo</th>
                                                <th>Clave</th>                                                
                                                <th>Descripcion</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>
                                                <th>Activo</th>
                                                <th>Magnitud</th>
                                                <th>Tipo de Cal.</th>                                                                                                 
                                                
                                                <th>Requiere Calibración</th>
                                                <th>Informe</th>
                                                <th>Fecha de Cal.</th>
                                                <th>Fecha de Venc.</th>                                                
                                                <th>Vigencia</th>                                                
                                                <th>Estado de Cal.</th>

                                                <th>Requiere Mant.</th>
                                                <th>Mantenimiento Id</th>
                                                <th>Ultimo Mant.</th>
                                                <th>Prox. Mant.</th>                                                                                                                                              
                                                <th>Estado Mant.</th>

                                                <th>Requiere Veri.</th>
                                                <th>Verificacion Id</th>
                                                <th>Ultima Veri.</th>
                                                <th>Prox. Veri.</th>                                                
                                                <th>Estado Veri.</th>

                                                <th>Comentario</th>
                                                <th>Fecha</th>
                                                <th>Responsable</th>

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
           var controller = "<?php echo $this->name .' '.$this->ext.' '.'activos '; ?>";            
           var _controller= "<?php echo $this->name ?>";
        </script>
        <?php importView('_static.scripts'); ?> 
        <script>
        $(document).ready(function(){
        var requiere= ["No requiere","Requiere"];
        var badge= ["bg-red","bg-green"];
        var label= ["label-danger","label-success"];
        var hoy= moment().format('YYYY-MM-DD');
        var nextmonth= moment(hoy).add(1,'months').format('YYYY-MM-DD');

        $('#table_controlcalidad tfoot th').each( function () {
            var title = $(this).text();
            $(this).html( '<input type="text" style="width:100%;font-weight: 400;font-size: 13px;padding: 3px 2px;" placeholder=" '+title+'" />' );
        } );

        var table_controlcalidad = $('#table_controlcalidad').DataTable({
            "ajax": "assets/php/server_processing.php?controller=" + controller,
            "deferRender": true,
            "processing": true,
            "serverSide": true,
            "dataType": "jsonp",
            "lengthMenu": [[15, 20, 50,100,200,500,1000, -1], [15, 20, 50,100,200,500,1000, "All"]],
            "autoWidth": true,
            "scrollX": true,
            "responsive": true,            
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
            //fixedColumns: true,                                   
            "columnDefs": [
                { "width": "60px", "targets": -1 
                },{
                    "targets": -1,
                    "data": null,                    
                    "render": function(data,type, row){
                        var menu="<a href='#' data-type='edit' class='btn btn-social-icon badge bg-yellow' title='Editar'><i class='fa fa-edit'></i></a>";
                        if(row[16]==1){
                            //menu += "<a href='?c=historialm&a=add&p="+ row[1] +"' data-type='addm' target='_blank' class='btn btn-social-icon badge bg-blue' title='Actualizar Mantenimiento'><i class='fa fa-cogs'></i></a>";
                            menu += "<a href='#' data-type='addm' class='btn btn-social-icon badge bg-blue' title='Actualizar Mantenimiento'><i class='fa fa-cogs'></i></a>";
                        }                        
                        if(row[21]==1){
                            //menu +="<a href='?c=historialv&a=add&p="+ row[1] +"' data-type='addv' target='_blank' class='btn btn-social-icon badge bg-gray' title=' Actualizar Verificación'><i class='fa fa-eye'></i></a>";
                            menu +="<a href='#' data-type='addv' class='btn btn-social-icon badge bg-gray' title=' Actualizar Verificación'><i class='fa fa-eye'></i></a>";
                        }                                             
                        menu += "<a href='#' data-type='cancel' class='btn btn-social-icon badge bg-black' title='Baja de equipo'><i class='fa fa-power-off'></i></a>";
                        menu += "<a href='#' data-type='addi' class='btn btn-social-icon badge bg-teal' title='Agregar a inventario'><i class='fa fa-database'></i></a>";
                        menu += "<a href='#' data-type='delete' class='btn btn-social-icon badge bg-red' title='Eliminar'><i class='fa fa-trash-o'></i></a>";
                        
                        return menu;
                        // "<a href='?c=control_calidad&a=edit&p=" + data[0]+"' data-type='edit' class='btn btn-xs btn-primary btn-flat'>Editar</a>"
                        // +" <a href='?c=control_calidad&a=delete&p=" + data[0]+"' data-type='delete' class='btn btn-xs btn-danger btn-flat'>Eliminar</a>"                         
                    }                
                },               
                {"targets":[1,17,22,26,27,28], "visible":false
                },{
                    "render": function(data,type,row){
                        var rowvalue=row[10];                        
                        return "<span class='label "+label[rowvalue] +"'>"+requiere[rowvalue] +"</span>";                         
                    },
                    "targets":10
                },{                                                   
                    "render": function(data,type,row){
                        if(row[16]==1){
                        var rowvalue = row[19];
                        return (moment(rowvalue).format("MMM-YYYY"));
                        }else{
                            return "<span class='label "+label[row[16]] +"'>"+requiere[row[16]] +"</span>";
                        }
                    },                        
                        "targets": 19                                    
                },{                                                   
                    "render": function(data,type,row){
                        if(row[21]==1){
                        var rowvalue = row[24];
                        return (moment(rowvalue).format("MMM-YYYY"));
                        }else{
                            return "<span class='label "+label[row[21]] +"'>"+requiere[row[21]] +"</span>";
                        }
                    },                        
                        "targets": 24                                   
                },{
                    "render": function(data,type,row){
                        var rowvalue=row[16];                        
                        return "<span class='label "+label[rowvalue] +"'>"+requiere[rowvalue] +"</span>";
                    },
                    "targets":16
                },{
                    "render": function(data,type,row){
                        var rowvalue=row[21];                        
                        return "<span class='label "+label[rowvalue] +"'>"+requiere[rowvalue] +"</span>";
                    },
                    "targets":21
                },{
                    "render": function(data,type,row){
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
                        return estado;                        
                    },
                    "targets":15
                },{
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
                    "targets":20
                },{
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
                    "targets":25
                }                
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
                             
        table_controlcalidad.columns().every( function () {
            var that = this;
            $( 'input', this.footer() ).on( 'keyup change', function () {
                if ( that.search() !== this.value ) {
                    that
                        .search( this.value )
                        .draw();
                    }
                });
        });

        $('#table_controlcalidad tbody').on('click', 'a', function () {
               var data = table.row($(this).parents('tr')).data();
               if ($(this).data("type") == "edit") {
                   window.location.replace("?c=" + _controller + "&a=edit&p=" + data[0]);
               } else if($(this).data("type") == "delete") {
                   window.location.replace("?c=" + _controller + "&a=delete&p=" + data[0]);
               } else if($(this).data("type") == "cancel") {
                    window.location.replace("?c=" + _controller + "&a=cancel&p=" + data[0]);
               } else if($(this).data("type") == "addm") {
                    window.location.replace("?c=historialm&a=add&p=" + data[1]);
               }else if($(this).data("type") == "addv") {
                    window.location.replace("?c=historialv&a=add&p=" + data[1]);
               }
               else if($(this).data("type") == "addi") {
                    window.location.replace("?c=inventario&a=add&p=" + data[1]);
               }
           });

        });
        </script>            
    </body>
</html>