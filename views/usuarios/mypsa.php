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
                                <div class="box-body">
                                    <table id="table_usermypsa" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Empresa</th>
                                                <th>Planta</th>
                                                <th>Dirección</th>
                                                <th>Puesto</th>
                                                <th>Telefono</th>
                                                <th>Email</th>
                                                <th>Rol</th>
                                                <th>Disponible</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>Empresa</th>
                                                <th>Planta</th>
                                                <th>Dirección</th>]
                                                <th>Puesto</th>
                                                <th>Telefono</th>
                                                <th>Email</th>
                                                <th>Rol</th>
                                                <th>Disponible</th>
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
            var controller = "<?php echo $this->name.' '.$rol; ?>";
        </script>
        <?php importView('_static.scripts'); ?>
        <script> 
         var _arrayCtrl=controller.split(" ");  

                $('#table_usermypsa thead tr').clone(true).appendTo( '#table_usermypsa thead' );
                $('#table_usermypsa thead tr:eq(1) th').each( function () {
                    var title = $(this).text();
                    $(this).html( '<input type="text" style="width:100%; font-size:11px;" placeholder="'+title+'" />' );                        
                } );

                // $('#table_users tfoot th').each( function () {
                //     var title = $(this).text();
                //     $(this).html( '<input type="text" style="width:100%;font-weight: 400;font-size: 13px;padding: 3px 2px;" placeholder=" '+title+'" />' );
                // } );

                var table = $('#table_usermypsa').DataTable({
                    "ajax": "assets/php/server_processing.php?controller=" + _arrayCtrl[0]+"_mypsa",
                    //"dom": 'Zlfrtip',
                    "deferRender": true,
                    "processing": true,
                    "serverSide": true,
                    "dataType": "jsonp",
                    //"colReorder": true,                
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "autoWidth": true,           
                    "scrollX": true,                                
                    "columnDefs": [{
                            "width": "50px",
                            "targets": -1,                       
                            "data": null,
                            "render": function(data,type, row){
                                var menu="";                               
                                menu += "<a href='#' data-type='edit' class='btn btn-social-icon badge bg-blue' title='Editar'><i class='fa fa-pencil'></i></a>";                                                           
                                if(_arrayCtrl[1] == '00' || _arrayCtrl[1] == '04'|| _arrayCtrl[1] == '02'){
                                menu += "<a href='#' data-type='delete' class='btn btn-social-icon badge bg-red' title='Eliminar'><i class='fa fa-trash'></i></a>"+
                                "<a href='#' data-type='password' class='btn btn-social-icon badge bg-orange' title='Restablecer contraseña'><i class='fa fa-key' aria-hidden='true'></i></a>"+
                                "<a href='#' data-type='turn_off' class='btn btn-social-icon badge bg-gray' title='Suspender usuario'><i class='fa fa-power-off' aria-hidden='true'></i></a>";
                                }
                                    return menu;
                                }
                        }],
                        "language": { "url": "assets/json/datatables.spanish.json",
                            "oAria": {
                            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            }            
                        }
                });

                table.columns().every( function () {
                    var that = this;
                    $( 'input', this.header() ).on( 'keyup change', function () {
                        if ( that.search() !== this.value ) {
                            that                        
                                .search(this.value)
                                .draw();
                        }
                    });
                });            
            
                $('#table_usermypsa tbody').on('click', 'a', function () {
                    var data = table.row($(this).parents('tr')).data();
                    if ($(this).data("type") == "edit") {
                        window.location.replace("?c=" + _arrayCtrl[0] + "&a=edit&p=" + data[0]);
                    } 
                    if(_arrayCtrl[1] == '00' || _arrayCtrl[1] == '04'|| _arrayCtrl[1] == '02'){
                        if($(this).data("type") == "delete") {
                            window.location.replace("?c=" + _arrayCtrl[0] + "&a=delete&p=" + data[0]);
                         }
                        else if($(this).data("type") == "password") {
                            window.location.replace("?c=" + _arrayCtrl[0] + "&a=password&p=" + data[0]);
                        } else if($(this).data("type") == "turn_off") {
                            window.location.replace("?c=" + _arrayCtrl[0] + "&a=turn_off&p=" + data[0]);
                        }
                    }
                });          

        </script>
    </body>
</html>