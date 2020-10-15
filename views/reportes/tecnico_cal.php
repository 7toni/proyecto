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
              <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">   

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xl-6 col-lg-5 col-md-12 col-sm-12 col-xs-12">
          <div class="box box-widget">
            <div class="box-header with-border">
              <div class="user-block">
                <span class="username"><h3><i class="fa fa-filter" aria-hidden="true"></i> &nbsp;<strong style="color:dark">Filtros de busqueda</strong></h3></span>
                <span class="description">&nbsp; Reporte de equipos calibrados por técnico</span>
              </div>
              <!-- <h3 class="box-title"><i class="fa fa-filter" aria-hidden="true"></i>&nbsp;Filtros de busqueda</h3> -->

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">              
              <div class="form-group">
                <label><h4>Rango de fechas *</h4></label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" id="daterange-text" name="daterange" class="form-control input-lg" >
                  </div>
              </div>
              <div class="form-group">
                <label><h4>Sucursal *</h4></label>
                <select id="sucursal" name="sucursal" class="form-control select2" data-placeholder="Seleccionar sucursal" style="width: 100%;">                    
                  <option value="">Seleccionar sucursal</option>  
                  <option value="nogales">Nogales</option>
                  <option value="hermosillo">Hermosillo</option>
                  <option value="guaymas">Guaymas</option> 
                </select>
              </div> 
              <div class="form-group">
                <label><h4>Seleccionar tipo de calibración *</h4></label>
                <select id="tipo_calibracion" name="tipo_calibracion" class="form-control select2" multiple="multiple" data-placeholder="Seleccionar tipo de calibración" style="width: 100%;">                                     
                  <?php
                    foreach ($data['tipocalibraciones'] as $tipocal) {                                                     
                      echo '<option value="'.$tipocal['id'].'">'.$tipocal['nombre'].'</option>';                                                                  
                    }
                  ?>                                            
                </select>
                <button type="button" id="allselect_tc" class="btn btn-default pull-left"><i class="fa fa-ellipsis-v" aria-hidden="true"></i> &nbsp; Seleccionar todos</button>
                <button type="button" id="cleanselect_tc" class="btn btn-default pull-left"><i class="fa fa-refresh" aria-hidden="true"></i> &nbsp;Limpiar</button>            
              </div>
                </br>                                             
              <div class="form-group">
                <label><h4>Seleccionar técnico *</h4></label>
                <select id="tecnico" name="tecnico" class="form-control select2" multiple="multiple" data-placeholder="Seleccionar técnico" style="width: 100%;">                                                    
                </select>
                <button type="button" id="allselect_t" class="btn btn-default pull-left"><i class="fa fa-ellipsis-v" aria-hidden="true"></i> &nbsp; Seleccionar todos</button>
                <button type="button" id="cleanselect_t" class="btn btn-default pull-left"><i class="fa fa-refresh" aria-hidden="true"></i> &nbsp;Limpiar</button>                
              </div>              
            </div>
            <div class="box-footer">
              <label>* Campos requeridos/obligatorios </label>
              <button type="button" id="submit" name="submit" class="btn btn-info btn-lg pull-right"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Buscar</button>
            </div>
             <!-- /.box-body -->
            <!-- Loading (remove the following to stop the loading)-->
            <div id="overlay" class="">
              <i id="refresh" class=""></i>
            </div>

          </div>
          <!-- /.col -->          
        </div>
        <div class="col-xl-6 col-lg-7 col-md-12 col-sm-12 col-x2-12">
          <!-- Box Comment -->
            <div class="box box-widget">
              <div class="box-header with-border">
                <div class="user-block">                           
                  <span class="username"><h3><strong style="color:dark">Total</strong></h3></span>
                  <span class="description">Equipos calibrados</span>
                </div>
                <!-- /.user-block -->
                <div class="box-tools" >
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>                
                </div>
                <!-- /.box-tools -->
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <canvas id="myChart" style="display: block; width: 100%; height: 52%;" width="100%" height="52%"  class="chartjs-render-monitor"></canvas>
              </div>
              <!-- /.box-body -->            
            </div>
          <!-- /.box -->
        </div> 
         <!-- /.col -->  
         
         
      <!-- /.row --> 
      <div class="row">
        <div class="col-md-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">Resultados</h3>
              <div class="box-body table-responsive">
                <table id="table_reporte" class="table table-condensed">
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
                  <tbody>                                                           
                  </tbody>
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
              </div>                
              <!-- /.box-tools -->
            </div>                      
          </div>
        </div>
      <!-- /.row --> 
      </div>                
            
      
    </section>
    <!-- /.content -->
  </div>                      
          <?php importView('_static.footer'); ?>
        </div>        
        <script>
            var controller = "<?php echo $this->name; ?>";              
        </script> 
                   
        <?php importView('_static.scripts'); ?>
        <script type="text/javascript">
          var parametro ={};
          var bg_color=["bg-red","bg-yellow","bg-aqua","bg-blue","bg-green"];
          var defaultbool=0;
          /* Formatting function for row details  */
          function data_equipo ( d ) {
              // 'd' is the original data object for the row
              return '<table class="table table-hover" >'+
                  '<tr>'+
                      '<td>Descripción:</td>'+
                      '<td> '+d['descripcion']+'</td>'+
                  '</tr>'+
                  '<tr>'+
                      '<td>Marca:</td>'+
                      '<td>'+d['marca']+'</td>'+
                  '</tr>'+
                  '<tr>'+
                      '<td>Modelo:</td>'+
                      '<td>'+d['modelo']+'</td>'+
                  '</tr>'+
                  '<tr>'+
                      '<td>Serie:</td>'+
                      '<td>'+d['serie']+'</td>'+
                  '</tr>'+                    
              '</table>';
          }

          function data_factura ( d ) {
            // 'd' is the original data object for the row
            var precio= (d['precio'] == null)  ? "" : '$ '+d['precio'];
            var precioex= (d['precio_extra'] == null)  ? "" : '$ '+d['precio_extra'];
            var moneda= (d['moneda'] == null)  ? "" : d['moneda'];
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
            var referencia= (d['referencia'] == null)  ? "" : d[referencia];
          
            return '<table class="table table-hover" >'+
                '<tr>'+
                    '<td>Dirección:</td>'+
                    '<td> '+d['direccion']+'</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>Referencia:</td>'+
                    '<td> '+referencia+'</td>'+
                '</tr>'+                                                      
            '</table>';
          }          

          var sucursal_ajax = function() {
            $.ajax({
                url: "?c=usuarios&a=ajax_load_usermypsa",
                dataType: "json",
                method: "POST",
                data: "sucursal=" + $("#sucursal").val()
            }).done(function(data) {
                var datos = data;
                var select = $('#tecnico');
                select.empty();
               // select.append($("<option />").val('').text('Seleccione una opción'));
                $.each(datos, function() {
                    select.append($("<option />").val(this.id).text(this.email));
                });
            }).fail(function(data) {

            }).always(function(data) {

            });
          }

          // var randomScalingFactor = function() {
          //   return Math.round(Math.random() * 100);
          // };

          var config = {
            type: 'doughnut',
            data: {
              datasets: [{
                data: [
                  1                  
                ],
                backgroundColor: [
                  'rgba(34, 167, 240, 1)'                
                ],
                label: 'Dataset 1'
              }],
              labels: [
                'Técnico Myp'                
              ]
            },
            options: { 
              onClick: handleClick,
              maintainAspectRatio: true,             
              responsive: true,
              legend: {
                display:true,
                position: 'right',
              },
              title: {
                position: 'left',
                display: true,
                text: 'Equipos calibrados por técnico'
              },
              animation: {
                animateScale: true,
                animateRotate: true
              }
            }           
          };
    
          function handleClick(e, slice) {
              if (slice && slice[0]) {
                var label = config.data.labels[slice[0]._index];

                if(label != "Técnico Myp"){
                  var value = config.data.datasets[slice[0]._datasetIndex].data[slice[0]._index];                  
                  var url="?c=reportes&a=resultados_calibracion&var0="+ parametro[0] +"&var1=" + parametro[1] +"&var2=" + parametro[2] + "&var3="+label +"";
                  window.open(url,'_blank');                 
                }                
              }              
          }                      

          var allselect_t= function(){
            $("#tecnico  option").prop("selected","selected");
            $("#tecnico").trigger("change");
          }

          var cleanselect_t= function(){
            $("#tecnico").val(null).trigger('change');
          }

          var allselect_tc= function(){
            $("#tipo_calibracion  option").prop("selected","selected");
            $("#tipo_calibracion").trigger("change");
          }

          var cleanselect_tc= function(){
            $("#tipo_calibracion").val(null).trigger('change');
          }

          var validar= function(data) {        
            var bool = true;
            if (data === "" || data === null) {
                bool = false;
            }       
            return bool;
          }

          var activarcargando= function(activo){                  
            if(activo == 1){
              $('#overlay').addClass('overlay');
              $('#refresh').addClass('fa fa-refresh fa-spin');
            }else if(activo == 0){
              $('#overlay').removeClass('overlay');
              $('#refresh').removeClass('fa fa-refresh fa-spin');
            }         
          }

          $(document).ready(function(){           
            $("#allselect_t").on('click', allselect_t);
            $("#cleanselect_t").on('click', cleanselect_t);

            $("#allselect_tc").on('click', allselect_tc);
            $("#cleanselect_tc").on('click', cleanselect_tc);

            $("#sucursal").on('change', sucursal_ajax);

            var ctx = document.getElementById('myChart').getContext('2d');
            var myChart = new Chart(ctx, config);                        

            var _table= $('#table_reporte').DataTable({
              "deferRender": true,
              "lengthMenu": [[15, 20, 50,100,200,500,1000,3000, -1], [15, 20, 50,100,200,500,1000,3000, "All"]],
              "autoWidth": true,           
              "scrollX": true,
              dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
              buttons: [
                   {
                      className: 'btn btn-default btn-lg',
                      extend: 'excelHtml5',
                      autoFilter: true,
                      text: '<span class="fa fa-download"></span> Exportar todo a Excel',
                      // exportOptions: {
                      //   columns: [':not(:last-child)' ]
                      // },
                      title: 'ReporteCalportecnico',
                  },                                
              ], 
              "columns": [
                    {   "data": 'informe' },   //"id"
                    {
                        "className":      'details-equipo',                        
                        "data":           'clave',
                        "defaultContent": ''                   
                    },                                                                                                                  
                    { "data":  'descripcion',
                        "visible" : false}, // "descripcion"
                    { "data":  'marca',
                        "visible" : false}, // "marca"
                    { "data":  'modelo',
                        "visible" : false}, // "modelo"
                    { "data":  'serie',
                        "visible" : false}, // "serie"             
                    { 
                      "className":      'details-direccion',  
                      "data": 'cliente',          // "cliente"
                      "defaultContent": ''                        
                    },
                    { "data": 'direccion',   // "direccion"                                              
                      "visible" : false},                                  
                    { "data": 'referencia',                                   
                      "visible" : false }, // "referencia"  
                    { "data": 'fecha_captura'}, //"fecha_inicio"                  
                    { "data": 'fecha_inicio'}, //"fecha_inicio"
                    { "data": 'tipo_calibracion'}, // "tipo_calibracion"
                    { "data": 'fecha_calibracion' }, // "fecha_calibracion"
                    { "data": 'periodo_calibracion' }, // "periodo_calibracion"
                    { "data": 'fecha_vencimiento' }, // "fecha_vencimiento"
                    { "data": 'tecnico_email' }, // "tecnico"
                    { 
                        "className":      'details-factura',  
                        "data":           'factura', // "factura"
                        "defaultContent": ''                    
                    }, 
                    { "data": 'precio',   // "precio"    
                      "visible" : false},                                    
                    { "data": 'precio_extra',  
                      "visible" : false }, // "precio_extra"
                    { "data": 'moneda',
                      "visible" : false }, // "moneda"
                    { "data": 'fecha_salida' }, // "fecha_salida"
                    { "data": 'proceso' }, //proceso 
                    { "data": 'fecha_inicio'}, //"fecha_inicio"
                    { "data": 'fecha_calibracion' }, // "fecha_salida"
                    { "data": 'fecha_salida' } // "fecha_salida"                                   
                ],
                fixedColumns: true,
                "columnDefs": [ 
                  { "targets": [7, 17] , "width": "70px" },
                  { "targets": [19] , "width": "100px" },                  
                  {
                      "render": function(data,type,row){
                          var rowvalue=row['proceso'];                                                     
                          var proceso=["Recepcion","Calibracion","Salida","Facturacion","Terminado"];                              
                          return "<span class='badge "+ bg_color[rowvalue] +"'>"+ proceso[rowvalue]+"</span>";                         
                      },
                      "targets":20
                  },{                  
                      "render": function(data,type,row){                          
                          var datehome=row['fecha_inicio'];
                          var dateend=row['fecha_calibracion'];                          
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
                      "targets":21
                  },{                  
                      "render": function(data,type,row){
                          var datehome=row['fecha_calibracion'];
                          var dateend=row['fecha_salida'];
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
                          var proceso= row['proceso'];
                          var count=0;
                          if(proceso == 4){
                            var dateinicio=row['fecha_inicio'];
                            var datecal=row['fecha_calibracion'];
                            var datesal=row['fecha_salida'];                          
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
                      "targets":23
                  },
                ],     

                });

                _table.columns().every( function () {
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
            $('#table_reporte tbody').on('click', 'td.details-equipo', function () {
                var tr = $(this).closest('tr');
                var row =  _table.row( tr );
                            
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
            
            $('#table_reporte tbody').on('click', 'td.details-factura', function () {
                var tr = $(this).closest('tr');
                var row =  _table.row( tr );
                            
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
            
            $('#table_reporte tbody').on('click', 'td.details-direccion', function () {
                    var tr = $(this).closest('tr');
                    var row = _table.row( tr );
                                
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
          
            
              var addData = function(labels,data){
                if (config.data.datasets.length > 0) {
                  for(var i in labels){
                    //config.data.labels.push('técnico ' + config.data.labels.length ); //insertar labels
                    config.data.labels.push(labels[i]); //insertar labels
                    // generamos color al random
                    var color = "rgba(" + Math.floor(Math.random() * 255) + "," + Math.floor(Math.random() * 195) + "," + Math.floor(Math.random() * 245) + ",";               
                    config.data.datasets.forEach(function(dataset) {
                      dataset.data.push(data[i]);
                      dataset.backgroundColor.push(color + "1)");
                    });
                  }                
                  myChart.update();                
                }
              }

              var deleteData = function(){
                if (config.data.labels.length > 0) {                
                  var n=config.data.labels.length;         
                  for(var j=n; j>0; j--){                  
                      config.data.labels.splice(-1, 1);                  
                      config.data.datasets.forEach((dataset) => {                      
                        dataset.data.pop();
                        dataset.backgroundColor.pop();
                      });                   
                  }      
                  myChart.update();                                                                        
                }                                                                                   
              }

            $("#submit").click ( function(){
              //Eliminar alertas si existen
              $("[name='alertas']").remove();
              //Variable de validacion
                var validacion= true;    
              //Array de los campos capturados                      
                parametro = {
                   0:$("#daterange-text").val(),
                   1:$("#sucursal").val() ,
                   2:$("#tipo_calibracion").val(),
                   3:$("#tecnico").val()                                               
                };

                for(var i=0; i < 4; i++){
                   if(validar(parametro[i]) == false){
                    validacion= false;
                   }
                }

                if(validacion == true){
                  activarcargando(1);                     
                  $.ajax({
                    type: 'post',
                    url: "?c=reportes&a=ajax_tecnico_cal",                        
                    data: parametro
                  }).done(function(data) {
                    var datos = data;
                    //console.log(datos); 
                    var obj= JSON.parse(datos); 

                    _table.clear();
                    _table.rows.add(obj).draw();                 
                    
                    var tecnicosData = [];
                    var labels = [];
                    var dataset = []; 
                    var total= 0;                

                    for (var i in obj) {
                      tecnicosData.push(obj[i].tecnico_email); 
                      total++;                                                              
                    }

                    tecnicosData.sort();
                    var count= 0;
                    var z=-1;
                    for(var i in tecnicosData){
                        i=0; 
                        z++;                     
                        labels.push(tecnicosData[i]);
                        for(var j in tecnicosData){                       
                          if(labels[z] == tecnicosData[j]){                         
                            count++;
                          }
                        }  
                        tecnicosData.splice(0, count);
                        dataset.push(count);
                        count=0;                                                                               
                    }
                    deleteData();                                           
                    addData(labels,dataset);                           
                      activarcargando(0);
                  }).fail(function(data) {}).always( function(data) {
                    //console.log(data);
                      activarcargando(0);
                  });

                }
                else{
                  // Mostrar alerta de campos no ingresados o seleccionados                              
                  alertas_tipo_valor_col12('submit', 'requerido', 'campos no seleccionado');
                  activarcargando(0);
                }

               
                
             
                
            });                                                                            

          });
                
        </script>              
    </body>         
</html>