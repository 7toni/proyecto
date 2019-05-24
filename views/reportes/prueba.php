<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
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
        <div class="col-md-12">         

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title"><i class="fa fa-filter" aria-hidden="true"></i>&nbsp;Filtros de busqueda</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Rango de fechas:</label>
                      <div class="input-group">
                        <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" id="daterange-text" name="daterange">
                      </div>
                  </div>                  
                  <div class="form-group">
                    <label>Empresa/Sucursal:</label>
                    <select id="tipo_busqueda" class="form-control select2" style="width: 100%;" name="tipo_busqueda">
                      <option value="">Seleccione una opción</option> 
                      <option value="0">Nogales</option>
                      <option value="1">Hermosillo</option>
                      <option value="2">Guaymas</option> 
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Proceso de calibración</label>
                    <select id="tipo_busqueda" class="form-control select2" style="width: 100%;" name="tipo_busqueda">
                      <option value="">Seleccione una opción</option>
                      <option value="5">Todos</option> 
                      <option value="4">Informes Terminados</option>
                      <option value="3">Informes en Proceso</option>                                        
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Campos de bitacora a buscar</label>
                    <select class="form-control select2" multiple="multiple" data-placeholder="Seleccionar campo de bitacora"
                            style="width: 100%;">
                      <option>Sin filtro</option>
                      <option>Todos</option>
                      <option># informe</option>
                      <option>Clave</option>
                      <option>Descripcion</option>
                      <option>Marca</option>
                      <option>Modelo</option>
                      <option>Serie</option>                    
                      <option>Serie</option>
                      <option>Técnico</option>
                      <option>Cliente</option>
                    </select>
                  </div>
                </div>
              </div>  
              <div class="row">
              <div class="col-md-12">                
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Informe(s)</label>
                      <input type="text" class="form-control" name="informes" placeholder="Ejemplo : 0123,1034,1456" />
                    </div>                    
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Clave (s)</label>
                      <input type="text" class="form-control" name="claves" placeholder="Ejemplo : clave1,clave2,calve...n" />
                    </div>                    
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Descripción(s)</label>
                      <select class="form-control select2" multiple="multiple" data-placeholder="Seleccionar descripción"
                            style="width: 100%;">
                      <option>Descripcion 1</option>
                      <option>Descripcion 2</option>
                      <option>Descripcion 3</option>
                      <option>Descripcion 4</option>
                      <option>Descripcion 5</option>
                      <option>Descripcion 6</option>                      
                    </select>
                    </div>
                  </div>                 
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Marca(s)</label>
                      <select class="form-control select2" multiple="multiple" data-placeholder="Seleccionar marca"
                            style="width: 100%;">
                      <option>Marca 1</option>
                      <option>Marca 2</option>
                      <option>Marca 3</option>
                      <option>Marca 4</option>
                      <option>Marca 5</option>
                      <option>Marca 6</option>                      
                    </select>
                    </div>                    
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Modelo(s)</label>
                      <select class="form-control select2" multiple="multiple" data-placeholder="Seleccionar modelo"
                            style="width: 100%;">
                      <option>Modelo 1</option>
                      <option>Modelo 2</option>
                      <option>Modelo 3</option>
                      <option>Modelo 4</option>
                      <option>Modelo 5</option>
                      <option>Modelo 6</option>                      
                    </select>
                    </div>                    
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Serie(s)</label>
                      <input type="text" class="form-control" name="claves" placeholder="Ejemplo : Serie1,Serie2,Serie...n" />
                    </div>
                    
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Técnico(s)</label>
                      <select class="form-control select2" multiple="multiple" data-placeholder="Seleccionar técnico"
                            style="width: 100%;">
                      <option>Técnico 1</option>
                      <option>Técnico 2</option>
                      <option>Técnico 3</option>
                      <option>Técnico 4</option>
                      <option>Técnico 5</option>
                      <option>Técnico 6</option>                      
                    </select>
                    </div>                    
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Cliente(s)</label>
                      <select class="form-control select2" multiple="multiple" data-placeholder="Seleccionar cliente"
                            style="width: 100%;">
                      <option>Cliente 1</option>
                      <option>Cliente 2</option>
                      <option>Cliente 3</option>
                      <option>Cliente 4</option>
                      <option>Cliente 5</option>
                      <option>Cliente 6</option>                      
                    </select>
                    </div>                    
                  </div>
              </div>
              </div>             
              <!-- /.form-group -->                
            </div>
            <div class="box-footer"><button type="button" name="buscar_rc" id="buscar_rc" class="btn btn-info margin-buttom pull-right"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;Buscar</button></div>
            <!-- /.box-body -->
          </div>
          
        </div>
        <!-- /.col -->
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-12">
              <div class="box box-success">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-bars" aria-hidden="true"></i>&nbsp; TOTAL DE EQUIPOS</h3>
                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>                                              
                  </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">                 
                  <!-- =========================================================== -->
                    <div class="row">
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-black">
                          <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

                          <div class="info-box-content">
                            <span class="info-box-text">T. Recepción</span>
                            <span class="info-box-number">41,410</span>

                            <div class="progress">
                              <div class="progress-bar" style="width: 70%"></div>
                            </div>
                                <span class="progress-description">
                                  70% Clientes
                                </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <table class="table table-condensed table-hover">
                          <tr>
                            <th style="width: 10px">#</th>
                            <th>Descripción</th>                            
                            <th style="width: 40px">Total</th>
                          </tr>
                          <tr>
                            <td>1.</td>
                            <td>Interna</td>                            
                            <td><span class="badge bg-red">55%</span></td>
                          </tr>
                          <tr>
                            <td>2.</td>
                            <td>Externa</td>                            
                            <td><span class="badge bg-yellow">70%</span></td>
                          </tr>
                          <tr>
                            <td>3.</td>
                            <td>Ventas</td>                            
                            <td><span class="badge bg-light-blue">30%</span></td>
                          </tr>
                          <tr>
                            <td>4.</td>
                            <td>Hermosillo</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                          <tr>
                            <td>5.</td>
                            <td>Nogales</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                          <tr>
                            <td>6.</td>
                            <td>Reparación</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                          <tr>
                            <td>7.</td>
                            <td>Servicios Especiales</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                          <tr>
                            <td>8.</td>
                            <td>Guaymas</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                        </table>
                        <!-- /.info-box -->
                      </div>
                      <!-- /.col -->
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-green">
                          <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

                          <div class="info-box-content">
                            <span class="info-box-text">T. Calibrados</span>
                            <span class="info-box-number">35,910</span>

                            <div class="progress">
                              <div class="progress-bar" style="width: 90%"></div>
                            </div>
                                <span class="progress-description">
                                  90% Clientes
                                </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <table class="table table-condensed table-hover">
                          <tr>
                            <th style="width: 10px">#</th>
                            <th>Descripción</th>                            
                            <th style="width: 40px">Total</th>
                          </tr>
                          <tr>
                            <td>1.</td>
                            <td>Interna</td>                            
                            <td><span class="badge bg-red">55%</span></td>
                          </tr>
                          <tr>
                            <td>2.</td>
                            <td>Externa</td>                            
                            <td><span class="badge bg-yellow">70%</span></td>
                          </tr>
                          <tr>
                            <td>3.</td>
                            <td>Ventas</td>                            
                            <td><span class="badge bg-light-blue">30%</span></td>
                          </tr>
                          <tr>
                            <td>4.</td>
                            <td>Hermosillo</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                          <tr>
                            <td>5.</td>
                            <td>Nogales</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                          <tr>
                            <td>6.</td>
                            <td>Reparación</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                          <tr>
                            <td>7.</td>
                            <td>Servicios Especiales</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                          <tr>
                            <td>8.</td>
                            <td>Guaymas</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                        </table>
                        <!-- /.info-box -->
                      </div>
                      <!-- /.col -->
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-yellow">
                          <span class="info-box-icon"><i class="fa fa-calendar"></i></span>

                          <div class="info-box-content">
                            <span class="info-box-text">T. Entregados</span>
                            <span class="info-box-number">33,410</span>

                            <div class="progress">
                              <div class="progress-bar" style="width: 85%"></div>
                            </div>
                                <span class="progress-description">
                                  85% Clientes
                                </span>                                
                          </div>
                         
                          <!-- /.info-box-content -->
                        </div>
                        <table class="table table-condensed">
                          <tr>
                            <th style="width: 10px">#</th>
                            <th>Descripción</th>                            
                            <th style="width: 40px">Total</th>
                          </tr>
                          <tr>
                            <td>1.</td>
                            <td>Interna</td>                            
                            <td><span class="badge bg-red">55%</span></td>
                          </tr>
                          <tr>
                            <td>2.</td>
                            <td>Externa</td>                            
                            <td><span class="badge bg-yellow">70%</span></td>
                          </tr>
                          <tr>
                            <td>3.</td>
                            <td>Ventas</td>                            
                            <td><span class="badge bg-light-blue">30%</span></td>
                          </tr>
                          <tr>
                            <td>4.</td>
                            <td>Hermosillo</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                          <tr>
                            <td>5.</td>
                            <td>Nogales</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                          <tr>
                            <td>6.</td>
                            <td>Reparación</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                          <tr>
                            <td>7.</td>
                            <td>Servicios Especiales</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                          <tr>
                            <td>8.</td>
                            <td>Guaymas</td>                            
                            <td><span class="badge bg-green">90%</span></td>
                          </tr>
                        </table>
                        <!-- /.info-box -->
                      </div>
                      <!-- /.col -->
                      <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box bg-red">
                          <span class="info-box-icon"><i class="fa fa-file-pdf-o"></i></span>

                          <div class="info-box-content">
                            <span class="info-box-text">T. Facturados</span>
                            <span class="info-box-number">41,410</span>

                            <div class="progress">
                              <div class="progress-bar" style="width: 70%"></div>
                            </div>
                                <span class="progress-description">
                                  70% Pagados
                                </span>
                          </div>
                          <!-- /.info-box-content -->
                        </div>
                        <table class="table table-condensed">
                          <tr>
                            <th style="width: 10px">#</th>
                            <th>Descripción</th>                            
                            <th style="width: 40px">Total</th>
                          </tr>
                          <tr>
                            <td>1.</td>
                            <td>Interna</td>                            
                            <td><span class="badge bg-red">55%</span></td>
                          </tr>
                          <tr>
                            <td>2.</td>
                            <td>Externa</td>                            
                            <td><span class="badge bg-yellow">70%</span></td>
                          </tr>                          
                        </table>
                        <!-- /.info-box -->
                      </div>
                      <!-- /.col -->
                    </div>
                    <!-- /.row -->
                  <!-- =========================================================== -->
                </div>
                  <!-- /.row -->
              </div>                          
                <!-- /.box-footer -->
            </div>
              <!-- /.box -->
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Inbox</h3>
                  <div class="box-body">
                    <table id="table_reporte" class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>Informe</th>
                          <th>Clave</th>
                          <th>Descripción</th>
                          <th>Marca</th>
                          <th>Modelo</th>
                          <th>Serie</th>
                          <th>Cliente (Sucursal/Departamento)</th>
                          <th>Fecha de calibración</th>
                          <th>Vigencia</th>
                          <th>Fecha de vencimiento</th>
                          <th>Precio</th>
                          <th>Precio extra</th>
                          <th>Moneda</th>
                          <th>Proceso</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Trident</td>
                          <td>Internet
                            Explorer 4.0
                          </td>
                          <td>Win 95+</td>
                          <td> 4</td>
                          <td>X</td>
                        </tr>
                        <tr>
                          <td>Trident</td>
                          <td>Internet
                            Explorer 5.0
                          </td>
                          <td>Win 95+</td>
                          <td>5</td>
                          <td>C</td>
                        </tr>
                        <tr>
                          <td>Trident</td>
                          <td>Internet
                            Explorer 5.5
                          </td>
                          <td>Win 95+</td>
                          <td>5.5</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Trident</td>
                          <td>Internet
                            Explorer 6
                          </td>
                          <td>Win 98+</td>
                          <td>6</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Trident</td>
                          <td>Internet Explorer 7</td>
                          <td>Win XP SP2+</td>
                          <td>7</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Trident</td>
                          <td>AOL browser (AOL desktop)</td>
                          <td>Win XP</td>
                          <td>6</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Firefox 1.0</td>
                          <td>Win 98+ / OSX.2+</td>
                          <td>1.7</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Firefox 1.5</td>
                          <td>Win 98+ / OSX.2+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Firefox 2.0</td>
                          <td>Win 98+ / OSX.2+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Firefox 3.0</td>
                          <td>Win 2k+ / OSX.3+</td>
                          <td>1.9</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Camino 1.0</td>
                          <td>OSX.2+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Camino 1.5</td>
                          <td>OSX.3+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Netscape 7.2</td>
                          <td>Win 95+ / Mac OS 8.6-9.2</td>
                          <td>1.7</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Netscape Browser 8</td>
                          <td>Win 98SE+</td>
                          <td>1.7</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Netscape Navigator 9</td>
                          <td>Win 98+ / OSX.2+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.0</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.1</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1.1</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.2</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1.2</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.3</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1.3</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.4</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1.4</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.5</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1.5</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.6</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>1.6</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.7</td>
                          <td>Win 98+ / OSX.1+</td>
                          <td>1.7</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Mozilla 1.8</td>
                          <td>Win 98+ / OSX.1+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Seamonkey 1.1</td>
                          <td>Win 98+ / OSX.2+</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Gecko</td>
                          <td>Epiphany 2.20</td>
                          <td>Gnome</td>
                          <td>1.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>Safari 1.2</td>
                          <td>OSX.3</td>
                          <td>125.5</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>Safari 1.3</td>
                          <td>OSX.3</td>
                          <td>312.8</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>Safari 2.0</td>
                          <td>OSX.4+</td>
                          <td>419.3</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>Safari 3.0</td>
                          <td>OSX.4+</td>
                          <td>522.1</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>OmniWeb 5.5</td>
                          <td>OSX.4+</td>
                          <td>420</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>iPod Touch / iPhone</td>
                          <td>iPod</td>
                          <td>420.1</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Webkit</td>
                          <td>S60</td>
                          <td>S60</td>
                          <td>413</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Opera 7.0</td>
                          <td>Win 95+ / OSX.1+</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Opera 7.5</td>
                          <td>Win 95+ / OSX.2+</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Opera 8.0</td>
                          <td>Win 95+ / OSX.2+</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>
                        <tr>
                          <td>Presto</td>
                          <td>Opera 8.5</td>
                          <td>Win 95+ / OSX.2+</td>
                          <td>-</td>
                          <td>A</td>
                        </tr>                                    
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
                          <th>Fecha de calibración</th>
                          <th>Vigencia</th>
                          <th>Fecha de vencimiento</th>
                          <th>Precio</th>
                          <th>Precio extra</th>
                          <th>Moneda</th>
                          <th>Proceso</th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>                
                  <!-- /.box-tools -->
                </div>                      
              </div>
            </div>
          </div>                
         
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
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

          $(document).ready(function(){

            $('#table_reporte tfoot th').each( function () {
              var title = $(this).text();
              $(this).html( '<input type="text" style="width:100%;font-weight: 400;font-size: 13px;padding: 3px 2px;" placeholder=" '+title+'" />' );
            } );

            var _table= $('#table_reporte').DataTable({
              "lengthMenu": [[15, 20, 50,100,200,500,1000,3000, -1], [15, 20, 50,100,200,500,1000,3000, "All"]],
              dom: '<"pull-left"l>fr<"dt-buttons"B>tip',
              buttons: [
                   {
                      extend: 'excel',
                      text: 'Excel',
                      exportOptions: {
                          columns: [':not(:last-child)' ]
                      }
                  }                
              ],                  
              columns: [
                          { data: 'informe' },
                          { data: 'clave' },
                          { data: 'descripcion'},
                          { data: 'marca' },
                          { data: 'modelo' },
                          { data: 'serie' },
                          { data: 'cliente' },
                          { data: 'fecha_calibracion' },
                          { data: 'periodo_calibracion' },
                          { data: 'fecha_vencimiento' },
                          { data: 'precio' },
                          { data: 'precio_extra' },
                          { data: 'moneda' },
                          { data: 'proceso' } 
                        ]             
                });

              _table.columns().every( function () {
              var that = this;
              $( 'input', this.footer() ).on( 'keyup change', function () {
                  if ( that.search() !== this.value ) {
                      that
                          .search( this.value )
                          .draw();
                      }
                  });
            }); 

          });
    
        </script>              
    </body>
          
</html>