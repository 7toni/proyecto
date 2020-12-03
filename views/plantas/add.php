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
                                    <h3 class="box-title">Agregar <?php echo $this->name; ?></h3>
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
                                    <form method="POST"  autocomplete="off"  action="?c=<?php echo $this->name; ?>&a=store" role="form">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="nombre">Nombre *</label>                                                    
                                                <input autofocus type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="" required="">
                                            </div>

                                            <div class="form-group">
                                                <label for="descripciones_id">Nombre de la empresa *</label>
                                                <select class="form-control select2Empresa" name="empresas_id" id="empresas_id"  required="" style="width: 100%;">
                                                    <option value="">Seleccione una opción</option>
                                                </select>
                                            </div>

                                            <!-- <div class="form-group">
                                                <label for="empresas_id">Nombre de la empresa perteneciente</label>
                                                <select  id="empresas_id" class="form-control select2" style="width: 100%;" name="empresas_id" required="">
                                                    <option value="">Seleccione una opción</option>
                                                    <?php
                                                    foreach ($data['empresa'] as $empresa) {
                                                        echo '<option value="' . $empresa['id'] . '">' . $empresa['nombre'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div> -->
                                            <div class="form-group">
                                                <label for="alias">Alias (Nombre alternativo) </label>                                                    
                                                <input  type="text" class="form-control" name="alias" id="alias" placeholder="Nombre alternativo de empresa y planta" value="">
                                            </div>
                                            <div class="form-group">
                                                <label for="rfc">RFC</label>                                                    
                                                <input  type="text"  class="form-control" name="rfc" id="rfc" placeholder="RFC" value="" >
                                            </div>
                                            <div class="form-group">
                                                <label for="razon_social">Razón Social</label>                                                    
                                                <input  type="text"  class="form-control" name="razon_social" id="razon_social" placeholder="Razon Social" value="" >
                                            </div> 
                                            <div class="form-group">
                                                <label for="cp">Codigo postal *</label>                                                    
                                                <input  type="text"   class="form-control" name="cp" id="cp" placeholder="Codigo postal" value="" required="" min="0" >
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <label for="calle">Calle *</label>  
                                                        <input type="text" class="form-control" name="calle" id="calle" placeholder="Calle + Numero interior/exterior" value="" required="">
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <label for="colonia">Colonia *</label>  
                                                        <input type="text" class="form-control" name="colonia" id="colonia" placeholder="Col. Nombre" value="" required="">
                                                    </div>
                                                </div>                                               
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <label for="ciudades_id">Delegación/ Municipio/ Ciudad *</label>
                                                        <select class="form-control select2" style="width: 100%;" name="ciudades_id" id="ciudades_id"  required="">
                                                            <option value="">Seleccione una opción</option>
                                                            <?php
                                                            foreach ($data['ciudad'] as $ciudad) {
                                                                echo '<option value="' . $ciudad['id'] . '">' . $ciudad['nombre'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <label for="estado">Estado *</label>  
                                                        <select  class="form-control select2" style="width: 100%;" name="estados_id" id="estados_id" required="">
                                                            <option value="">Seleccione una opción</option>
                                                            <?php
                                                            foreach ($data['estado'] as $estado) {
                                                                echo '<option value="' . $estado['id'] . '">' . $estado['nombre'] . '</option>';
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>                                               
                                            </div>

                                            <div class="form-group">
                                                <label for="referencia">Referencia</label>                                                    
                                                <input  type="text" class="form-control" name="referencia" id="referencia" placeholder="Entre cale y calle"  value="">
                                            </div>

                                            <div class="form-group">
                                                <label for="sucursales_id">Sucursal responsable *</label>
                                                <select id="sucursales_id" class="form-control select2" style="width: 100%;" name="sucursales_id" required="">
                                                    <option value="">Seleccione una opción</option>
                                                    <?php
                                                    foreach ($data['sucursal'] as $sucursal) {
                                                        echo '<option value="' . $sucursal['id'] . '">' . $sucursal['nombre'] . '</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="comentarios">Comentarios</label>
                                                <input  type="text" class="form-control" name="comentarios" id="comentarios" placeholder="Comentarios" value="">
                                            </div>
                                            <div class="form-group">
                                                <label for="requiere">* Campos requeridos/obligatorios</label>
                                                
                                            </div>
                                        </div>
                                        <div class="box-footer"><button type="submit" class="btn btn-primary btn-flat">Guardar cambios</button></div>
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