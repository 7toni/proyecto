<!DOCTYPE html>
<html>
    <head>
        <?php importView('_static.head'); ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php importView('_static/header'); ?>
            <?php importView('_static/sidebar'); ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>Pulso <small>Control Calidad</small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-sm-12">
                            <div class="box box-primary box-solid">
                                <div class="box-header">
                                    <h3 class="box-title">Proximos Mantenimientos</h3>                                    
                                </div>
                                 <!-- /.box-header -->
                                <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
                                    <tr>
                                        <th>Clave</th>
                                        <th>Descripción</th>
                                        <th>Fecha de calibración</th>
                                        <th>Tipo de calibración</th>
                                        <th>Acción</th>
                                    </tr>
                                    <tr>
                                        <td>183</td>
                                        <td>John Doe</td>
                                        <td>11-7-2014</td>
                                        <td><span class="label label-success">Approved</span></td>
                                        <td><a class='btn btn-block btn-warning btn-sm' target='_blank'  href=""><i class='fa fa-pencil' aria-hidden='true'></i></a></td>                                    
                                    </tr>
                                    <tr>
                                        <td>219</td>
                                        <td>Alexander Pierce</td>
                                        <td>11-7-2014</td>
                                        <td><span class="label label-warning">Pending</span></td>
                                        <td><a class='btn btn-block btn-warning btn-sm' target='_blank'  href=""><i class='fa fa-pencil' aria-hidden='true'></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>657</td>
                                        <td>Bob Doe</td>
                                        <td>11-7-2014</td>
                                        <td><span class="label label-primary">Approved</span></td>
                                        <td><a class='btn btn-block btn-warning btn-sm' target='_blank'  href=""><i class='fa fa-pencil' aria-hidden='true'></i></a></td>
                                    </tr>
                                    <tr>
                                        <td>175</td>
                                        <td>Mike Doe</td>
                                        <td>11-7-2014</td>
                                        <td><span class="label label-danger">Denied</span></td>
                                        <td><a class='btn btn-block btn-warning btn-sm' target='_blank'  href=""><i class='fa fa-pencil' aria-hidden='true'></i></a></td>
                                    </tr>
                                </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-sm-12">
                            <div class="box box-warning box-solid">
                                <div class="box-header">
                                    <h3 class="box-title">Proximas Verificación</h3>                                    
                                </div>
                                <div class="box-body">

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-sm-12">
                            <div class="box box-danger box-solid">
                                <div class="box-header">
                                    <h3 class="box-title">Calibraciones a vencer</h3>                                    
                                </div>
                                <div class="box-body">

                                </div>

                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-sm-6 col-md-6 col-sm-12">
                            <div class="box box-success box-solid">
                                <div class="box-header">
                                    <h3 class="box-title">Estado Actual</h3>                                    
                                </div>
                                <div class="box-body">

                                </div>

                            </div>
                        </div>
                    </div>
                </section>
            </div>                   
            <?php importView('_static/footer'); ?>
        </div>
        <?php importView('_static/scripts'); ?>        
        </body>
</html>