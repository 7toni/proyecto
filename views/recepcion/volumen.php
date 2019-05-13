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
                        <div class="col-md-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Actualización de informes por volumen</h3>
                                    <div class="pull-right box-tools">
                                        <button type="button" class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                                        <i class="fa fa-minus"></i></button> 
                                    </div>
                                </div>                             
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3">                                           
                                            <div class="form-group">
                                                <div class="btn btn-default btn-file btn-block">
                                                    <span class="mailbox-attachment-icon"><i class="fa fa-file-excel-o"></i></span>
                                                    <input type="file" id="file" accept=".csv">                                                    
                                                </div>                                                 
                                                <div class="mailbox-attachment-info" id="infofile">
                                                    <label class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> *.csv</label>
                                                        <span class="mailbox-attachment-size">
                                                        &nbsp; 0 KB                                                        
                                                        </span>
                                                </div>
                                            </div>                                                                                                                                
                                        </div>
                                        <div class="col-md-3">
                                            <div class="box box-widget">
                                                <div class="user-block">PASO 1.</div>
                                                <div class="box-body"> 
                                                    <div class="form-group">
                                                        <div class="info-box">
                                                            <a href="#" id="cargarfile">
                                                                <span class="info-box-icon bg-blue"><i class="fa fa-upload"></i></span>
                                                            </a>
                                                            <a href="#" id="cargarfiledisabled" >
                                                                <span class="info-box-icon bg-gray"><i class="fa fa-upload"></i></span>
                                                            </a>

                                                            <div class="info-box-content">
                                                                <span class="info-box-text">Cargar</span>
                                                                <span class="info-box-number">Información</span>
                                                            </div>
                                                            <!-- /.info-box-content -->
                                                        </div>                                            
                                                    </div>
                                                </div>
                                                <div id="overlay1">
                                                    <i id="refresh1" ></i> 
                                                </div> 
                                            </div>                                            
                                        </div>
                                        <div class="col-md-3">
                                            <div class="box box-widget">
                                                <div class="user-block">PASO 2.</div>
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="info-box">
                                                            <a href="#" id="comprobardatos">
                                                                <span class="info-box-icon bg-orange"><i class="fa fa-puzzle-piece"></i></span>
                                                            </a>
                                                            <a href="#" id="comprobardatosdisabled">
                                                                <span class="info-box-icon bg-gray"><i class="fa fa-puzzle-piece"></i></span>
                                                            </a>

                                                            <div class="info-box-content">
                                                            <span class="info-box-text">Validar</span>
                                                            <span class="info-box-number">Información</span>
                                                            </div>
                                                            <!-- /.info-box-content -->
                                                        </div>                                                 
                                                    </div>                                                
                                                </div>
                                                <div id="overlay2">
                                                    <i id="refresh2" ></i> 
                                                </div>                                                 
                                            </div>                                                                                        
                                        </div>
                                        <div class="col-md-3">
                                            <div class="box box-widget">
                                                <div class="user-block">PASO 3.</div>
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="info-box">
                                                            <a href="#" id="submit" >
                                                                <span class="info-box-icon bg-green"><i class="fa fa-cloud-upload"></i></span>
                                                            </a>
                                                            <a href="#" id="submitdisabled" >
                                                                <span class="info-box-icon bg-gray"><i class="fa fa-cloud-upload"></i></span>
                                                            </a>

                                                            <div class="info-box-content">
                                                            <span class="info-box-text">Actualizar</span>
                                                            <span class="info-box-number">Bitacora</span>
                                                            </div>
                                                            <!-- /.info-box-content -->
                                                        </div> 
                                                    </div>                                                 
                                                </div>
                                                <div id="overlay3">
                                                    <i id="refresh3" ></i> 
                                                </div> 
                                            </div>
                                        </div>                                        
                                    </div>
                                    
                                    <div class="row" id="alerta_volumen"></div>

                                    <div class="row" id="row_table1">
                                        <div class="col-md-12 ">
                                            <div class="box-body">
                                                 <!-- <div class="table-responsive no-padding"> -->
                                                <div class="table-responsive">
                                                    <table id="table_volumen" class="table table-bordered table-hover" rol="grid"> 
                                                        <thead>
                                                            <tr>
                                                                <td>Informe</td>
                                                                <td>Clave</td>
                                                                <td>Descripcion</td>
                                                                <td>Marca</td>
                                                                <td>Modelo</td>
                                                                <td>Serie</td>
                                                                <td>Empresa</td>
                                                                <td>Planta</td>
                                                                <td>PO</td>
                                                                <td>Cantidad</td>                                                                                                                   
                                                                <td>Acreditación</td>
                                                                <td>Tipo Calibración</td>
                                                                <td>Hoja Ent.</td>
                                                                <td>Usuario</td>
                                                                <td>Fecha de Entrada</td>

                                                                <td>Técnico</td>
                                                                <td>Vigencia</td>                                                                                                                
                                                                <td>Fecha de Calibracion</td>
                                                                <td>Proceso</td>
                                                            </tr>
                                                        </thead>                                            
                                                        <tfoot>
                                                            <tr>
                                                                <td>Informe</td>
                                                                <td>Clave</td>
                                                                <td>Descripcion</td>
                                                                <td>Marca</td>
                                                                <td>Modelo</td>
                                                                <td>Serie</td>
                                                                <td>Empresa</td>
                                                                <td>Planta</td>
                                                                <td>PO</td>
                                                                <td>Cantidad</td>                                                                                                                     
                                                                <td>Acreditación</td>
                                                                <td>Tipo Calibración</td>
                                                                <td>Hoja Ent.</td>
                                                                <td>Usuario</td>
                                                                <td>Fecha de Entrada</td>

                                                                <td>Técnico</td>
                                                                <td>Vigencia</td>                                                                                                                
                                                                <td>Fecha de Calibracion</td>
                                                                <td>Proceso</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div> 
                                            </div>
                                        </div>                                                                                                                  
                                    </div>

                                    <div class="row" id="row_table2">
                                        <div class="col-md-12 ">
                                            <div class="box-body">
                                                <!-- <div class="table-responsive no-padding"> -->
                                                <div class="table-responsive">
                                                    <table id="table_volumen2" class="table table-bordered table-hover" rol="grid"> 
                                                        <thead>
                                                            <tr>
                                                                <td>Informe</td>
                                                                <td>Clave</td>
                                                                <td>Descripcion</td>
                                                                <td>Marca</td>
                                                                <td>Modelo</td>
                                                                <td>Serie</td>
                                                                <td>Empresa</td>
                                                                <td>Planta</td>
                                                                <td>PO</td>
                                                                <td>Cantidad</td>
                                                                <!-- <td>id Planta</td> -->                                                        
                                                                <td>Acreditación</td>
                                                                <td>Tipo Calibración</td>
                                                                <td>Hoja Ent.</td>
                                                                <td>Usuario</td>
                                                                <td>Fecha de Entrada</td>

                                                                <td>Técnico</td>
                                                                <td>Vigencia</td>                                                                                                                
                                                                <td>Fecha de Calibracion</td>
                                                                <td>Proceso</td>
                                                                <td>Estado de Equipo</td>
                                                                <td>Estado de Planta</td>
                                                                <td>Estado de Técnico</td>
                                                            </tr>
                                                        </thead>                                            
                                                        <tfoot>
                                                            <tr>
                                                                <td>Informe</td>
                                                                <td>Clave</td>
                                                                <td>Descripcion</td>
                                                                <td>Marca</td>
                                                                <td>Modelo</td>
                                                                <td>Serie</td>
                                                                <td>Empresa</td>
                                                                <td>Planta</td>
                                                                <td>PO</td>
                                                                <td>Cantidad</td>
                                                                <!-- <td>id Planta</td> -->                                                        
                                                                <td>Acreditación</td>
                                                                <td>Tipo Calibración</td>
                                                                <td>Hoja Ent.</td>
                                                                <td>Usuario</td>
                                                                <td>Fecha de Entrada</td>

                                                                <td>Técnico</td>
                                                                <td>Vigencia</td>                                                                                                                
                                                                <td>Fecha de Calibracion</td>
                                                                <td>Proceso</td>
                                                                <td>Equipo id</td>
                                                                <td>Planta id</td>
                                                                <td>Tecnico id</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div> 
                                            </div>
                                        </div>                                                                                                                  
                                    </div>
                                    
                                </div>                                
                                <div class="box-footer">                                    
                                </div>
                            </div>
                        </div>
                </div>
                </section>
            </div>
            <?php importView('_static.footer'); ?>
        </div>
        <script>
            var controller = "<?php echo $this->name; ?>";
        </script>        
        <?php importView('_static.scripts'); ?>
        <script type="text/javascript"> 
            var dataBitacora="";
            $(document).ready(function() {
                $('#row_table1').hide();
                $('#row_table2').hide();
                /* ******************************** */
                $('#cargarfile').hide();
                $('#cargarfiledisabled').show();
                $('#comprobardatos').hide();
                $('#comprobardatosdisabled').show();
                $('#submit').hide();
                $('#submitdisabled').show();
                /* ******************************** */                                

                $("#file").on("change",function(){
                    $('#row_table1').hide();
                    $('#row_table2').hide();
                    /* ******************************** */
                    $('#cargarfile').hide();
                    $('#cargarfiledisabled').show();
                    $('#comprobardatos').hide();
                    $('#comprobardatosdisabled').show();
                    $('#submit').hide();
                    $('#submitdisabled').show();
                    /* ******************************** */                    
                    var file= $('#file').prop('files')[0];
                    //console.log(file);
                    var infofile = $('#infofile');
                    infofile.empty();                    
                    infofile.append(
                        '<a href="#" class="mailbox-attachment-name"><i class="fa fa-paperclip"></i> &nbsp;'+ file['name'] +'</a>'+
                            '<span class="mailbox-attachment-size">'+
                            '&nbsp; '+ (file['size']/1024).toFixed(2) +' KB'+                           
                            '</span>'
                        );
                        $('#cargarfile').show();
                        $('#cargarfiledisabled').hide();
                });

                $("#cargarfile").click( function(){
                    document.getElementById("file").disabled = true;
                    var file= $('#file').prop('files')[0];
                    //console.log(file);                  
                    var frmData= new FormData();
                    frmData.append("csvfile",file);
                    $('#overlay1').addClass('overlay');
                    $('#refresh1').addClass('fa fa-refresh fa-spin');                                                           
                    $.ajax({
                        url: '?c=recepcion&a=ajax_cargarcsv',                        
                        data:frmData,
                        processData:false,
                        contentType: false,
                        type:'POST',
                        success:function(data) {
                            var datos = data;
                            var obj= JSON.parse(datos);
                            //console.log(obj);
                            $('#row_table1').show();                            

                            $('#table_volumen').DataTable({
                                data : obj,
                                "paging"      : true,                    
                                "searching"   : true,
                                "ordering"    : false,
                                "info"        : true,
                                "autoWidth"   : false,
                                dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
                                "columnDefs" : [
                                    { "targets":[8,9,11,12,13], "visible":false }
                                    ],
                                buttons: [],
                                columns: [
                                    { data: '0' },
                                    { data: '1' },
                                    { data: '2' },
                                    { data: '3' },
                                    { data: '4' },
                                    { data: '5' },
                                    { data: '6' },
                                    { data: '7' },
                                    { data: '8' },
                                    { data: '9' },
                                    { data: '10' },
                                    { data: '11' },
                                    { data: '12' },
                                    { data: '13' },
                                    { data: '14' },                              
                                    { data: '15' },
                                    { data: '16' },
                                    { data: '17' }, 
                                    { data: '18' }
                                ], "language": {
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
                            
                            $('#comprobardatos').show();
                            $('#comprobardatosdisabled').hide();

                            $('#overlay1').removeClass('overlay');
                            $('#refresh1').removeClass('fa fa-refresh fa-spin');
                            
                        },
                        error: function (response) {
                            console.log(response);                            
                        }
                    });                                       
                });

                $("#comprobardatos").click(function(){
                    var table = $('#table_volumen').DataTable();
                        table
                            .clear();
                    var file= $('#file').prop('files')[0];                    
                    var frmData= new FormData();
                    var entro=false;                    
                    frmData.append("csvfile",file);
                    $('#overlay2').addClass('overlay');
                    $('#refresh2').addClass('fa fa-refresh fa-spin');                    
                    $.ajax({                   
                        url: '?c=recepcion&a=ajax_comprobardatos',                        
                        data:frmData,
                        processData:false,
                        contentType: false,
                        type:'POST',
                        success:function(data) {
                            var datos = data;
                            var obj= JSON.parse(datos);                            
                            $('#row_table1').hide();
                            $('#row_table2').show();                                                        

                            $('#table_volumen2').dataTable( {
                                data : obj,
                                "paging"      : true,                    
                                "searching"   : true,
                                "ordering"    : true,
                                "info"        : true,
                                "autoWidth"   : false,
                                dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
                                "columnDefs" : [
                                    { "targets":[8,9,11,12,13], "visible":false },
                                    {
                                        "targets":17,
                                        "render": function(data,type, row){
                                            var menu="";
                                            if(row[17] != ""){
                                                menu="<span class='label label-success'>"+ moment(row[17]).format("YYYY-MM-DD"); +"</span>";
                                            }else{
                                                if(!entro){ //
                                                    entro=true;
                                                }                                                
                                                menu="<span class='label label-danger'>* Requiere </span>";                                                
                                            }                                                                                        
                                            return  menu;
                                        }
                                    },
                                    {
                                        "targets":19,
                                        "render": function(data,type, row){
                                            var menu="";
                                            if(parseInt(row[19]) > 0){
                                                menu="<span class='label label-success'>Aprovado</span>";
                                            }else{
                                                if(!entro){ //
                                                    entro=true;
                                                }                                                
                                                menu="<span class='label label-danger'>No aprovado</span>";                                                
                                            }                                                                                        
                                            return  menu;
                                        }
                                    },{
                                        "targets":20,
                                        "render": function(data,type, row){
                                            var menu="";
                                            if(parseInt(row[20]) > 0){
                                                menu="<span class='label label-success'>Aprovado</span>";                                                
                                            }else{
                                                if(!entro){
                                                    entro=true;
                                                } 
                                                menu="<span class='label label-danger'>No aprovado</span>";
                                            }                                                                                        
                                            return  menu;
                                        }
                                    },{
                                        "targets":21,
                                        "render": function(data,type, row){
                                            var menu="";
                                            if(parseInt(row[21]) > 0){
                                                menu="<span class='label label-success'>Aprovado</span>";
                                            }else{
                                                if(!entro){
                                                    entro=true;
                                                } 
                                                menu="<span class='label label-danger'>No aprovado</span>";
                                            }                                                                                        
                                            return  menu;
                                        }
                                    }
                                ],                                
                                buttons: [],
                                columns: [
                                    {"data" : "0"},
                                    {"data" : "1"},
                                    {"data" : "2"},
                                    {"data" : "3"},
                                    {"data" : "4"},
                                    {"data" : "5"},
                                    {"data" : "6"},
                                    {"data" : "7"},
                                    {"data" : "8"},
                                    {"data" : "9"},
                                    {"data" : "10"},
                                    {"data" : "11"},
                                    {"data" : "12"},
                                    {"data" : "13"},
                                    {"data" : "14"},
                                    {"data" : "15"},
                                    {"data" : "16"},
                                    {"data" : "17"},
                                    {"data" : "18"},
                                    {"data" : "19"},
                                    {"data" : "20"},
                                    {"data" : "21"}

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
                            
                            if(entro==false){
                                dataBitacora = obj;
                                $('#submit').show();
                                $('#submitdisabled').hide();
                            }
                            $('#overlay2').removeClass('overlay');
                            $('#refresh2').removeClass('fa fa-refresh fa-spin');                           
                        },
                        error: function (response) {
                            console.log(response);                             
                        }
                    });                                         
                });

                $("#submit").click(function(){
                    var frmData= JSON.stringify(dataBitacora);
                    $('#overlay3').addClass('overlay');
                    $('#refresh3').addClass('fa fa-refresh fa-spin');                                                           
                    $.ajax({
                        url: '?c=recepcion&a=ajax_storevolCSV',                                                
                        type:'POST',                        
                        data: {data:frmData},
                        dataType: 'JSON',                        
                        success:function(data) {
                            var datos = data;
                            var obj= JSON.parse(datos);                            
                            if(obj==true){
                                alertas_tipo_valor_col12('alerta_volumen','correcto','Los datos fueron registrados correctamente.');                                
                                var table = $('#table_volumen2').DataTable();
                                    table
                                        .clear();
                                $('#row_table1').hide();
                                $('#row_table2').hide();
                                /* ******************************** */
                                $('#cargarfile').hide();
                                $('#cargarfiledisabled').show();
                                $('#comprobardatos').hide();
                                $('#comprobardatosdisabled').show();
                                $('#submit').hide();
                                $('#submitdisabled').show();
                                /* ******************************** */
                                document.getElementById("file").disabled = false;
                            }
                            else{
                                alertas_tipo_valor_col12('alerta_volumen','error','Error al actualizar la bitacora, revisar si alguna información esta incorrecta y favor de reportar el error con el administrador. Gracias!');
                            }
                            $('#overlay3').removeClass('overlay');
                            $('#refresh3').removeClass('fa fa-refresh fa-spin');
                        },
                        error: function (response) {
                            console.log(response);                            
                        }
                    });                    
                    
                });
                
              });

        </script>      
    </body>
</html>

