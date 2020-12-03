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
                     <!-- /.row --> 
                        <div class="row">
                            <div class="col-md-12">
                            <div class="box box-default">
                                <div class="box-header with-border">
                                <h3 class="box-title">Informes en espera de Autorización</h3>
                                <div class="box-body table-responsive">
                                <p id="alerta"></p>                                     

                                    <table id="table_aut" class="table table-bordered table-condensed table-responsive table-striped" cellspacing="0" width="100%" class="display" >
                                    <thead>
                                        <tr>
                                        <th> <div class="checkbox">                                                
                                                <input type="checkbox" class="dt-checkboxes" name="select_all" value="1" id="table_aut-select-all"><label></label>
                                            </div> 
                                        </th>
                                            <th>Num de informe</th>
                                            <th>Solicitante</th>
                                            <th>Equipo</th>                                           
                                            <th>Detalles</th>                                           
                                            <th>Comentarios</th>
                                            <th>Tiempo de solicitud</th>                                                                                 
                                        </tr>
                                    </thead>
                                    <tbody>                                                           
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th>Num de informe</th>
                                            <th>Solicitante</th>
                                            <th>Equipo</th>                                           
                                            <th>Detalles</th>                                            
                                            <th>Comentarios</th>
                                            <th>Tiempo de solicitud</th>
                                        </tr>
                                    </tfoot>
                                    </table>
                                </div>                
                                <!-- /.box-tools -->
                                </div>                      
                            </div>
                            </div>    
                        </div>   
                    <!-- /.row -->  
                </section>
            </div>
            <?php importView('_static.footer'); ?>
        </div>
        <script>
            var controller = "<?php echo $this->name.' '.$this->ext.'_v3 '; ?>";
        </script>
        <?php importView('_static.scripts'); ?>    
        <script type="text/javascript">

             $(document).ready( function(){

                var _table = $('#table_aut').DataTable({
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
                                className: 'btn btn-primary',                                
                                text: 'Autorizar',                              
                            }, 
                            {
                                className: 'btn btn-danger',                                
                                text: 'Cancelar',                                
                            }, 
                            {
                                className: 'btn btn-primary',                                
                                text: 'Actualizar',                               
                            }, 
                            {
                                className: 'btn btn-primary',
                                extend: 'excelHtml5',
                                autoFilter: true,
                                text: 'Exportar todo a Excel',
                                // exportOptions: {
                                //   columns: [':not(:last-child)' ]
                                // },
                                title: 'informesporautorizar',
                            },                                                          
                        ],
                        //fixedColumns: true,
                        //fixedHeader: true,
                        "columns": [
                            { "data": 0},   //"id"
                            { "data": 0}, //"id" 
                            { "data": 28}, //"comentarios"
                            { "data": 1}, //"equipoalias"
                            { "data": 28}, //"comentarios"
                            { "data": 28}, //"comentarios"
                            { "data": 19} // "fecha_inicio"                                                                                                        
                        ],                    
                        "columnDefs": [                             
                            {
                                'targets': 0,
                                'render': function(data, type, row, meta){
                                if(type === 'display'){
                                    data = '<div class="checkbox"><input type="checkbox" name="id[]" value="'+ $('<div/>').text(data).html() +'" class="dt-checkboxes"><label></label></div>';
                                }
                                return data;
                                },
                                'checkboxes': true,
                                //  {
                                // //'selectRow': true,
                                // //'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                                // }
                            },                                                                                                                         
                            {                  
                                "render": function(data,type,row){
                                    var detalles= new String(row[28]);
                                    if(detalles != 'null'){
                                        var array= detalles.split('_');
                                        return array[0];
                                    }else{
                                        return "";
                                    }                                                                                             
                                },
                                "targets":2
                            },
                            {                  
                                "render": function(data,type,row){
                                    var equipo= row[1]+", "+row[2]+", "+row[3]+", "+row[4]+", "+row[5];
                                    return equipo;
                                },                                                                
                                "targets":3
                            },
                            {                  
                                "render": function(data,type,row){
                                    var detalles= new String(row[28]);
                                    if(detalles != 'null'){
                                        var array= detalles.split('_');
                                        return array[1];
                                    }else{
                                        return "";
                                    }                                                                                             
                                },                               
                                "targets":4
                            },{                  
                                "render": function(data,type,row){
                                    var detalles= new String(row[28]);
                                    if(detalles != 'null'){
                                        var array= detalles.split('_');
                                        return array[2];
                                    }else{
                                        return "";
                                    }                                                                                             
                                },
                                "targets":5
                            },
                            {                                        
                                "render": function(data,type,row){                          
                                    var datehome= new Date(row[19]);
                                    var dayWrapper = moment(datehome);
                                    var horas = moment().diff(dayWrapper, 'hours'); // Diff in hours
                                    if( horas < 24){
                                        return "<i class='fa fa-clock-o'></i> Hace "+ horas +" horas";
                                    }else{
                                        var days = moment().diff(dayWrapper, 'days'); // Diff in hours                                    
                                        return "<i class='fa fa-clock-o'></i> Hace "+ days +" días";
                                    }                               
                                },
                                
                                "targets":6
                            }
                        ],
                        'order': [[1, 'asc']]  
                });

                // Handle click on "Select all" control
                $('#table_aut-select-all').on('click', function(){
                    // Check/uncheck all checkboxes in the table
                    var rows = _table.rows({ 'search': 'applied' }).nodes();
                    $('input[type="checkbox"]', rows).prop('checked', this.checked);
                });                     

                // Handle click on checkbox to set state of "Select all" control
                $('#table_aut tbody').on('change', 'input[type="checkbox"]', function(){
                    // If checkbox is not checked
                    if(!this.checked){
                        var el = $('#table_aut-select-all').get(0);
                        // If "Select all" control is checked and has 'indeterminate' property
                        if(el && el.checked && ('indeterminate' in el)){
                            // Set visual state of "Select all" control 
                            // as 'indeterminate'
                            el.indeterminate = true;
                        }
                    }
                });

                _table.buttons().action( function( e, dt, button, config ) {
                    //console.log( this.text());
                    if(this.text() == "Autorizar" ){                                                
                        //console.log(read_table());
                        var data= read_table();
                        var tipo= 1;
                        ajax_autorizacion(tipo,data);

                    } else if(this.text() == "Cancelar" ){                                                
                        var data= read_table();
                        var tipo= 0;
                        ajax_autorizacion(tipo,data);
                    } else if(this.text() == "Actualizar" ){                                                
                        _table.ajax.reload();
                    } 

                } );

                function read_table() {
                    var catch_ids = [];
                    var datos = [];
                    $.each($("input[type='checkbox']:checked"), function(){
                        if($(this).val() != 'on'){
                            catch_ids.push($(this).val());                            
                        }                               
                    });

                    for(var i in catch_ids){                        
                        //console.log(catch_ids[i]);
                        _table.rows().eq(0).each( function ( index ) {
                            var row = _table.row(index);                        
                            var data = row.data();
                            //console.log(data);  
                            if(catch_ids[i] == data[0]){
                                datos.push(data);                                
                            }                            
                        });
                    }                    
                    return datos;
                }

                function ajax_autorizacion(tipo,datos){
                    //Array de los campos capturados                      
                     var parametro = {
                            0: tipo,
                            1:datos                                         
                        };

                        $.ajax({
                            type: 'post',
                            url: "?c=informes&a=ajax_autorizacion",                        
                            data: parametro
                        }).done(function(data) {                        
                            var datos= data;
                            var obj= JSON.parse(datos);                            
                           var mensaje="";
                            for(var i in obj){                                
                                if(obj[i] != null){
                                    mensaje += obj[i] +", ";
                                }
                            }

                            if((mensaje.length) > 0){
                                $('#alertacontenido').remove();
                                mensaje = mensaje.substring(0,(mensaje.length)-2);
                                $("#alerta").before(
                                "<div class='form-group' id='alertacontenido'>"+
                                    "<div class='col-sm-12'>" +
                                        "<div class='alert alert-warning alert-dismissible'>" + 
                                            "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button>" +
                                            "<h4><i class='icon fa fa-ban'></i> Alerta!</h4>" +
                                            "Se presentó un problema con la actualización con los siguientes números de informes ["+ mensaje +"], Inténtelo una vez. Si el problema persiste, favor de reportarlo." + 
                                        "</div>" +
                                    "</div>"+
                                "</div>"
                                );
                            }
                             _table.ajax.reload();
                        }).fail(function(data) {}).always( function(data) {
                            //console.log(data);                      
                        });
                }
                    
             });     
        </script>    
    </body>
</html>
