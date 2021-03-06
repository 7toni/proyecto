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
                    <h1><?php echo $this->title; ?><small><?php echo $this->subtitle; ?></small></h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header  with-border">
                                    <h3 class="box-title">Eliminación de <?php echo $this->name; ?></h3>
                                </div>
                                <div class="box-body">
                                    <?php if ($error = Flash::hasError()) { ?>
                                        <div class="alert alert-warning alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                            <h4><i class="icon fa fa-warning"></i> <?php echo $error['title']; ?> #<?php echo $error['id']; ?> </h4>
                                            <ul><?php
                                                foreach ($error['data'] as $err) {
                                                    echo '<li>' . $err['msg'] . '</li>';
                                                }
                                                ?></ul>
                                        </div>
                                    <?php } ?>
                                    <form method="POST" autocomplete="off" action="?c=<?php echo $this->name; ?>&a=destroy" role="form">
                                        <input type="hidden" name="id" value="<?php echo $data['ciudad'][0]['id']; ?>">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="id">Número de identificación</label>
                                                <input type="text" class="form-control" id="id" name="id" placeholder="Número de identificación" disabled="" value="<?php echo $data['ciudad'][0]['id']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="nombre">Nombre</label>
                                                <input type="text" name="nombre" class="form-control" id="nombre"  disabled="" placeholder="nombre" value="<?php echo $data['ciudad'][0]['nombre']; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="estados_id">Estado</label>
                                                <select disabled="" autofocus="" id="estados_id" class="form-control select2" style="width: 100%;" name="estados_id" required="">
                                                    <option value="">Seleccione una opcion</option>
                                                    <?php
                                                    foreach ($data['estado'] as $estado) {
                                                        if ($estado['id'] == $data['ciudad'][0]['estados_id']) {
                                                            echo '<option value="' . $estado['id'] . '" selected>' . $estado['nombre'] . '</option>';
                                                        } else {
                                                            echo '<option value="' . $estado['id'] . '">' . $estado['nombre'] . '</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="box-footer"><button type="submit" class="btn btn-danger btn-flat">Elminar registro</button></div>
                                    </form>
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