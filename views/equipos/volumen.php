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
                                    <h3 class="box-title"> Registro de equipos por volumen</h3>
                                    <div class="pull-right box-tools">
                                    <button type="button" class="btn btn-info " id="downloadcsv"><i class="fa fa-download"></i> Descargar formato.csv</button>
                                        <button type="button" class="btn btn-primary btn-sm" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">                                        
                                        <i class="fa fa-minus"></i></button>                                         
                                    </div>
                                </div>                             
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <!-- small box -->
                                            <div class="small-box bg-red">
                                                <div class="inner">
                                                    <h3>Paso 1 <i class="fa fa-arrow-circle-right pull-right"></i></h3>                                                    
                                                </div>                                                                                                       
                                            </div>                                         
                                            <!-- -->
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
                                            <!-- -->                                                                                                                               
                                        </div>
                                        <!-- -->
                                        <div class="col-md-3">
                                            <div class="box box-widget">                                                
                                                <!-- small box -->
                                                <div class="small-box bg-orange">
                                                    <div class="inner">
                                                        <h3>Paso 2 <i class="fa fa-arrow-circle-right pull-right"></i></h3>                                                    
                                                    </div>                                                                                                       
                                                </div>    
                                                <div class="box-body"> 
                                                    <div class="form-group">
                                                        <div class="info-box">
                                                            <a href="#" id="cargarfile">
                                                                <span class="info-box-icon bg-orange"><i class="fa fa-upload"></i></span>
                                                            </a>
                                                            <a href="#" id="cargarfiledisabled" >
                                                                <span class="info-box-icon bg-gray"><i class="fa fa-upload"></i></span>
                                                            </a>

                                                            <div class="info-box-content">
                                                                <span class="info-box-text">Cargar</span>
                                                                <span class="info-box-number">Archivo *.CSV</span>
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
                                                <!-- small box -->
                                                <div class="small-box bg-blue">
                                                    <div class="inner">
                                                        <h3>Paso 3 <i class="fa fa-arrow-circle-right pull-right"></i></h3>                                                    
                                                    </div>                                                                                                       
                                                </div>                                                 
                                                <div class="box-body">
                                                    <div class="form-group">
                                                        <div class="info-box">
                                                            <a href="#" id="comprobardatos">
                                                                <span class="info-box-icon bg-blue"><i class="fa fa-puzzle-piece"></i></span>
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
                                                <!-- small box -->
                                                <div class="small-box bg-green">
                                                    <div class="inner">
                                                        <h3>Paso 4 <i class="fa fa-paper-plane pull-right"></i></h3>                                                    
                                                    </div>                                                                                                       
                                                </div>                                                
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
                                                            <span class="info-box-text">Registrar</span>
                                                            <span class="info-box-number">Equipos</span>
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
                                                                <td>Clave</td>
                                                                <td>Descripcion</td>
                                                                <td>Marca</td>
                                                                <td>Modelo</td>
                                                                <td>Serie</td>                                                                
                                                            </tr>
                                                        </thead>                                            
                                                        <tfoot>
                                                            <tr>                                                                
                                                                <td>Clave</td>
                                                                <td>Descripcion</td>
                                                                <td>Marca</td>
                                                                <td>Modelo</td>
                                                                <td>Serie</td>                                                               
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
                                                                <td>Clave</td>
                                                                <td>Descripcion</td>
                                                                <td>Marca</td>
                                                                <td>Modelo</td>
                                                                <td>Serie</td>
                                                                <td>existeequipo</td>
                                                                <td>Estado</td> <!-- serieduplicada -->
                                                                <td>existedesc</td>
                                                                <td>existemarca</td>
                                                                <td>existemodelo</td>                                                                
                                                            </tr>
                                                        </thead>                                            
                                                        <tfoot>
                                                            <tr>                                                               
                                                                <td>Clave</td>
                                                                <td>Descripcion</td>
                                                                <td>Marca</td>
                                                                <td>Modelo</td>
                                                                <td>Serie</td>
                                                                <td>existeequipo</td>
                                                                <td>Estado</td> <!-- serieduplicada -->
                                                                <td>existedesc</td>
                                                                <td>existemarca</td>
                                                                <td>existemodelo</td>
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
            var dataEquipo="";
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
                        url:"?c=equipos&a=ajax_cargarcsv",
                        method:"POST",
                        data:frmData,
                        dataType:'json',
                        contentType:false,
                        cache:false,
                        processData:false,
                        success:function(data) {
                            //console.log(data);

                            var obj=data;
                            dataEquipo= obj;

                            $('#row_table1').show();                           

                            $('#table_volumen').DataTable({
                                data : obj,
                                "deferRender" : true,
                                "paging"      : true,                    
                                "searching"   : true,
                                "ordering"    : false,
                                "info"        : true,
                                "autoWidth"   : false,
                                dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
                                "columnDefs" : [
                                   /*  { "targets":[11,12,13], "visible":false } */
                                ],
                                buttons: [],                            
                                columns: [
                                    { data: '0' },
                                    { data: '1' },
                                    { data: '2' },
                                    { data: '3' },
                                    { data: '4' }                                    
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
                    var frmData= JSON.stringify(dataEquipo);
                    //console.log(frmData);
                    var entro=false;                    
                    $('#overlay2').addClass('overlay');
                    $('#refresh2').addClass('fa fa-refresh fa-spin');    

                    $.ajax({
                        url: '?c=equipos&a=ajax_comprobardatos',                       
                        method:"POST",                        
                        data: {data:frmData},                                              
                        success:function(data) {
                            var datos = data;
                            var obj= JSON.parse(datos);
                            //var obj=datos;
                            //console.log(obj);                            

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
                                // "rowCallback": function( row, data, index ) {                                  
                                //     var existeequipo= parseInt(data[5]),               
                                //     $node = this.api().row(row).nodes().to$();
                                //     if (existeequipo == 1 ) {
                                //         $node.addClass('bg-aqua')
                                //     }                                                          
                                // },
                                "columnDefs" : [
                                    { "targets":[5,7,8,9], "visible":false },
                                    {
                                        "targets":6,
                                        "render": function(data,type, row){ 
                                            var retorno="<span data-toggle='tooltip' title='' class='badge bg-green'>Aprobado</span>";
                                            if(row[5] == "1"){                                                
                                                retorno="<span data-toggle='tooltip' title='' class='badge bg-blue' data-original-title='El equipo ya se encuentra resgistrado, lo ignoraremos en el proceso de registro.'>Registrado</span>";
                                            }
                                            if(row[6] == "1"){ 
                                                entro=true;
                                                retorno="<span data-toggle='tooltip' title='' class='badge bg-yellow' data-original-title='Serie duplicada'>Alerta!</span>";
                                            }
                                            if(row[7] == "0"){ 
                                                entro=true;
                                                retorno="<span data-toggle='tooltip' title='' class='badge bg-red' data-original-title='La descripción no se encuentra registrada.Verificar información antes de registrar.'>Alerta!</span>";
                                            }  
                                            if(row[8] == "0"){ 
                                                entro=true;
                                                retorno="<span data-toggle='tooltip' title='' class='badge bg-red' data-original-title='La marca no se encuentra registrada.Verificar información antes de registrar.'>Alerta!</span>";
                                            }  
                                            if(row[9] == "0"){ 
                                                entro=true;
                                                retorno="<span data-toggle='tooltip' title='' class='badge bg-red' data-original-title='El modelo no se encuentra registrado.Verificar información antes de registrar.'>Alerta!</span>";
                                            }                                                                                      
                                            return retorno;
                                        }
                                    },
                                ],                                
                                buttons: [],
                                columns: [
                                    {data : '0'},
                                    {data : '1'},
                                    {data : '2'},
                                    {data : '3'},
                                    {data : '4'},
                                    {data : '5'},
                                    {data : '6'},
                                    {data : '7'},
                                    {data : '8'},
                                    {data : '9'}                                    
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
                            
                            if(entro==false){
                                dataEquipo = obj;
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
                    var frmData= JSON.stringify(dataEquipo);                    
                    $('#overlay3').addClass('overlay');
                    $('#refresh3').addClass('fa fa-refresh fa-spin');

                    $.ajax({
                        url: '?c=equipos&a=ajax_storevolcsv',                                                
                        type:'POST',                        
                        data: {data:frmData},                                              
                        success:function(data) {
                            var datos = data;                            
                            var obj= JSON.parse(datos);
                            console.log(obj);                                                      
                            
                            // if(obj==true){
                            //     alertas_tipo_valor_col12('alerta_volumen','correcto','Los datos fueron registrados correctamente.');                                
                            //     var table = $('#table_volumen2').DataTable();
                            //         table
                            //             .clear();
                            //     $('#row_table1').hide();
                            //     $('#row_table2').hide();
                            //     /* ******************************** */
                            //     $('#cargarfile').hide();
                            //     $('#cargarfiledisabled').show();
                            //     $('#comprobardatos').hide();
                            //     $('#comprobardatosdisabled').show();
                            //     $('#submit').hide();
                            //     $('#submitdisabled').show();
                            //     /* ******************************** */
                            //     document.getElementById("file").disabled = false;
                            // }
                            // else{
                            //     alertas_tipo_valor_col12('alerta_volumen','error','Error al actualizar el catalogo de equipos, revisar si alguna información esta incorrecta. Gracias!');
                            // }
                            $('#overlay3').removeClass('overlay');
                            $('#refresh3').removeClass('fa fa-refresh fa-spin');
                        },
                        error: function (response) {
                            console.log(response);                            
                        }
                    });                    
                    
                });

                $("#downloadcsv").click(function(){ 
                    $.ajax({
                        url : "?c=equipos&a=download_excel", 
                        type: 'POST',                        
                        success: function(data){                                                      
                            var downloadLink = document.createElement("a");                            
                            var fileData = ['\ufeff'+JSON.parse(data)];
                            var blobObject = new Blob(fileData,{
                                type: "text/csv;charset=utf-8;"
                            });
                            var url = URL.createObjectURL(blobObject);
                            downloadLink.href = url;
                            downloadLink.download = "equiposxvolumen.csv";
                            /*
                            * Actually download CSV
                            */
                            document.body.appendChild(downloadLink);
                            downloadLink.click();
                            document.body.removeChild(downloadLink);
                        }
                    });
                                   

                });
            });
        </script>      
    </body>
</html>

