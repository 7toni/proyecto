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
                                </div>
                                <div class="box-body">
                                    <table id="table" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th># de id</th>
                                                <th>Usuario</th>
                                                <th>Hora</th>
                                                <th>Fecha</th>
                                                <th>Acción</th>
                                                <th>Detalles</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th># de id</th>
                                                <th>Usuario</th>
                                                <th>Hora</th>
                                                <th>Fecha</th>
                                                <th>Acción</th>
                                                <th>Detalles</th>
                                                <th>Acciones</th>
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
            var controller = "<?php echo $this->name; ?>";
        </script>
        <?php importView('_static.scripts'); ?>
        <script>
            console.log(table);
        </script>
    </body>
</html>