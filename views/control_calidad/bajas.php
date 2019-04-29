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

                                    <table id="table_controlcalidad_bajas" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="width:10px;">#</th>
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
           var controller = "<?php echo $this->name .' '.$this->ext.' '.'bajas '; ?>";            
           var _controller= "<?php echo $this->name ?>";
        </script>
        <?php importView('_static.scripts'); ?>
        <script>
        $(document).ready(function () {
            var requiere= ["No requiere","Requiere"];
            var badge= ["bg-red","bg-green"];
            var label= ["label-danger","label-success"];
            var hoy= moment().format('YYYY-MM-DD');
            var nextmonth= moment(hoy).add(1,'months').format('YYYY-MM-DD');

            $('#table_controlcalidad_bajas tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" style="width:100%;font-weight: 400;font-size: 13px;padding: 3px 2px;" placeholder=" '+title+'" />' );
            } );
            
            var table = $('#table_controlcalidad_bajas').DataTable({
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
                            menu = "<a href='#' data-type='enable' class='btn btn-social-icon badge bg-black' title='Activar Equipo'><i class='fa fa-power-off'></i></a>";
                            menu += "<a href='#' data-type='delete' class='btn btn-social-icon badge bg-red' title='Eliminar'><i class='fa fa-trash-o'></i></a>";
                            
                            return menu;
                            // "<a href='?c=control_calidad&a=edit&p=" + data[0]+"' data-type='edit' class='btn btn-xs btn-primary btn-flat'>Editar</a>"
                            // +" <a href='?c=control_calidad&a=delete&p=" + data[0]+"' data-type='delete' class='btn btn-xs btn-danger btn-flat'>Eliminar</a>"                         
                        }                
                    },               
                    {"targets":[1,11,12,13,14,15,17,18,19,20,22,23,24,25], "visible":false
                    },{
                        "render": function(data,type,row){
                            var rowvalue=row[10];                        
                            return "<span class='label "+label[rowvalue] +"'>"+requiere[rowvalue] +"</span>";                         
                        },
                        "targets":10
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
                    }               
                ],
                "language": { "url": "assets/json/datatables.spanish.json" }
            });
                                
            table.columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                        }
                    });
            });

            $('#table_controlcalidad_bajas tbody').on('click', 'a', function () {
               var data = table.row($(this).parents('tr')).data();
               if ($(this).data("type") == "enable") {
                   window.location.replace("?c="+ _controller + "&a=enable&p=" + data[0]);
               } else if($(this).data("type") == "delete") {
                   window.location.replace("?c=" + _controller + "&a=delete&p=" + data[0]);
               }
            });
        });

        </script>              
    </body>
</html>