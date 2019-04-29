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
                                    <h3 class="box-title">Listado de <?php echo $this->title; ?></h3>
                                    <a href="?c=<?php echo $this->name; ?>&a=add" class="btn btn-primary btn-md pull-right btn-flat">Agregar nuevo</a>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body table-responsive">

                                    <table id="table_historialv" class="table table-bordered table-striped table-hover" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Id Equipo</th>
                                                <th>Clave</th>                                                
                                                <th>Descripcion</th>
                                                <th>Marca</th>
                                                <th>Modelo</th>
                                                <th>Serie</th>

                                                <th style="width:95px">Fecha de Veri.</th>

                                                <th>Id Usuario</th>                                                
                                                <th>Responsable</th>
                                                
                                                <th style="width:200px; align=justify">Comentarios</th>                                                

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

                                                <th style="width:95px">Fecha de Veri.</th>

                                                <th>Id Usuario</th>                                                
                                                <th>Responsable</th>
                                                
                                                <th style="width:200px; align=justify">Comentarios</th>                                                

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
           var controller = "<?php echo $this->name .' '.$this->ext; ?>";            
        </script>
        <?php importView('_static.scripts'); ?>              
    </body>
</html>