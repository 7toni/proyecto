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
              color: #367fa9;                
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
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
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
                <label><h4>Rango de fechas:</h4></label>
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control input-lg" id="daterange-text" name="daterange">
                  </div>
              </div>
              <div class="form-group">
                <label><h4>Tipo de calibración</h4></label>
                <select id="tipo_calibracion" class="form-control select2" style="width: 100%;" name="tipo_calibracion">                     
                <option value="todos" selected="selected">Todos</option>
                  <?php
                    foreach ($data['tipocalibraciones'] as $tipocal) {                                                     
                      echo '<option value="'.$tipocal['nombre'].'">'.$tipocal['nombre'].'</option>';                                                                  
                    }
                  ?>                          
                </select>
              </div>                
              <div class="form-group">
                <label><h4>Seleccionar cliente</h4></label>
                <select id="tecnico" class="form-control select2" data-placeholder="Seleccionar cliente"
                        style="width: 100%;" name="tecnico">                      
                  <option value="todos" selected="selected">Todos</option>
                  <?php
                    foreach ($data['planta'] as $clientes) {
                      if(trim(strtolower($clientes['nombre'])) == 'planta1')
                      {
                        $_cliente= $clientes['empresa'];
                      }
                      else{
                        $_cliente= $clientes['empresa'].' ('. $clientes['nombre'].')';
                      } 
                      echo '<option value="'.$clientes['id'].'">'. $_cliente
                      .'</option>'; 
                    }
                  ?>     
                </select>
              </div>                 
              <!-- <div class="form-group">
                <label>Matriz/Sucursal:</label>
                <select id="tipo_busqueda" class="form-control select2" style="width: 100%;" name="tipo_busqueda">
                  <option value="">Seleccione una opción</option> 
                  <option value="0">Nogales</option>
                  <option value="1">Hermosillo</option>
                  <option value="2">Guaymas</option> 
                </select>
              </div>                   -->                                      
            </div>
            <div class="box-footer">
              <button type="button" name="submit" id="submit" class="btn btn-info btn-lg pull-right"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Buscar</button>
            </div> 
            <!-- /box box-widget -->           
          </div>
          <!-- /.col -->          
        </div>       
         <!-- /.col -->                   
      </div>
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
              return '<table class="table table-hover" >'+
                  '<tr>'+
                      '<td>Precio:</td>'+
                      '<td> $ '+d['precio']+'</td>'+
                  '</tr>'+
                  '<tr>'+
                      '<td>Precio extra:</td>'+
                      '<td> $ '+d['precio_extra']+'</td>'+
                  '</tr>'+
                  '<tr>'+
                      '<td>Moneda:</td>'+
                      '<td>'+d['moneda']+'</td>'+
                  '</tr>'+                                   
              '</table>';
          }          

          // var randomScalingFactor = function() {
          //   return Math.round(Math.random() * 100);
          // };

          // var config = {
          //   type: 'doughnut',
          //   data: {
          //     datasets: [{
          //       data: [
          //         1                  
          //       ],
          //       backgroundColor: [
          //         'rgba(255, 64, 130, 1)'                
          //       ],
          //       label: 'Dataset 1'
          //     }],
          //     labels: [
          //       'Técnico Myp'                
          //     ]
          //   },
          //   options: { 
          //     onClick: handleClick,             
          //     responsive: true,
          //     legend: {
          //       position: 'right',
          //     },
          //     title: {
          //       position: 'left',
          //       display: true,
          //       text: 'Equipos calibrados por técnico'
          //     },
          //     animation: {
          //       animateScale: true,
          //       animateRotate: true
          //     }
          //   }
          // };
    
          // function handleClick(e, slice) {
          //     if (slice && slice[0]) {
          //       var label = config.data.labels[slice[0]._index];

          //       if(label != "Técnico Myp"){
          //         var value = config.data.datasets[slice[0]._datasetIndex].data[slice[0]._index];
          //         var url="?c=reportes&a=resultados_calibracion&var0="+ parametro['daterange'] +"&var1=" + parametro['tipo_calibracion'] + "&var2="+label +"";
          //         window.open(url,'_blank');
          //         //window.open('index.php?c=reportes&a=pulso');
          //         console.log(parametro['daterange'] +" | "+ parametro['tipo_calibracion'] +" | "+ label +" | "+ value);
          //       }                
          //     }              
          // }

          $(document).ready(function(){            
            // var ctx = document.getElementById('myChart').getContext('2d');
            // var myDoughnut = new Chart(ctx, config);                                                     

            var _table= $('#table_reporte').DataTable({
              "deferRender": true,
              "lengthMenu": [[15, 20, 50,100,200,500,1000,3000, -1], [15, 20, 50,100,200,500,1000,3000, "All"]],
              "autoWidth": true,           
              "scrollX": true,
              dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
              buttons: [
                   {
                      className: 'btn btn-default btn-lg',
                      extend: 'excel',
                      text: '<span class="fa fa-download"></span> Exportar a Excel',
                      exportOptions: {
                          columns: ':visible'
                      },
                      title: 'Reporte_equiposcalibrados_técnico',
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
                    { "data": 'cliente'}, // "cliente"
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
                    { "data": 'fecha_salida' }, // "fecha_salida"
                    { "data": 'fecha_salida' } // "fecha_salida"                                   
                ],
                fixedColumns: true,
                "columnDefs": [ 
                  { "targets": [7, 17] , "width": "70px" },                   
                  {
                      "render": function(data,type,row){
                          var rowvalue=row['proceso'];                                                     
                          var proceso=["Recepcion","Calibracion","Salida","Facturacion","Terminado"];                              
                          return "<span class='badge "+ bg_color[rowvalue] +"'>"+ proceso[rowvalue]+"</span>";                         
                      },
                      "targets":18
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
                      "targets":19
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
                      "targets":20
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
                      "targets":21
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
          
            // var addData = function(labels,data){
            //   if (config.data.datasets.length > 0) {
            //     for(var i in labels){
            //       //config.data.labels.push('técnico ' + config.data.labels.length ); //insertar labels
            //       config.data.labels.push(labels[i]); //insertar labels
            //       // generamos color al random
            //       var color = "rgba(" + Math.floor(Math.random() * 255) + "," + Math.floor(Math.random() * 195) + "," + Math.floor(Math.random() * 245) + ",";               
            //       config.data.datasets.forEach(function(dataset) {
            //         dataset.data.push(data[i]);
            //         dataset.backgroundColor.push(color + "1)");
            //       });
            //     }                
            //     myDoughnut.update();                
            //   }
            // }

            // var deleteData = function(){              
            //   if (config.data.labels.length > 0) {                
            //     var n=config.data.labels.length;         
            //     for(var j=n; j>0; j--){                  
            //          config.data.labels.splice(-1, 1);                  
            //         config.data.datasets.forEach((dataset) => {                      
            //           dataset.data.pop();
            //           dataset.backgroundColor.pop();
            //         });                   
            //     }      
            //     myDoughnut.update();                                                                        
            //   }                                                                                   
            // }

            $("#submit").click ( function(){
                parametro= {
                  'daterange': $('#daterange-text').val(),
                  'tipo_calibracion': $("#tipo_calibracion").val(),
                  'email': $("#tecnico").val()                                
                };                                  
                $.ajax({
                  type: 'post',
                  url: "?c=reportes&a=ajax_cliente_cal",                        
                  data: parametro
                }).done(function(data) {
                  var datos = data;
                 //console.log(datos); 
                  var obj= JSON.parse(datos); 
                  _table.clear();
                  _table.rows.add(obj).draw();                 
                  
                  // var tecnicosData = [];
                  // var labels = [];
                  // var dataset = [];                 

                  // for (var i in obj) {
                  //   tecnicosData.push(obj[i].tecnico_email);                                                               
                  // }

                  // tecnicosData.sort();
                  // var count= 0;
                  // var z=-1;
                  // for(var i in tecnicosData){                   
                  //     i=0; 
                  //     z++;                     
                  //     labels.push(tecnicosData[i]);
                  //     for(var j in tecnicosData){                       
                  //       if(labels[z] == tecnicosData[j]){                         
                  //         count++;
                  //       }
                  //     }  
                  //     tecnicosData.splice(0, count);
                  //     dataset.push(count);
                  //     count=0;                                                                               
                  // }
                  // deleteData();                                           
                  // addData(labels,dataset);                 

                }).fail(function(data) {}).always( function(data) {
                  //console.log(data);
                }); 
                
            });                                                                            

          });
                
        </script>              
    </body>         
</html>