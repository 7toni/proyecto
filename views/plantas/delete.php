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
                                        <input type="hidden" name="id" value="<?php echo $data['planta'][0]['id']; ?>">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label for="id">Número de identificación</label>
                                                <input type="text" class="form-control" id="id" name="id" placeholder="Número de identificación" disabled="" value="<?php echo (isset($data['planta'][0]['id'])) ? $data['planta'][0]['id']: ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="nombre">Nombre</label>                                                    
                                                <input disabled="" autofocus type="text" class="form-control" name="nombre" id="nombre" placeholder="Nombre" value="<?php echo (isset($data['planta'][0]['nombre'])) ? $data['planta'][0]['nombre']:''; ?>" required="">
                                            </div>
                                            <div class="form-group">
                                                <label for="empresas_id">Nombre de la empresa perteneciente</label>
                                                <select disabled="" id="empresas_id" class="form-control select2" style="width: 100%;" name="empresas_id" required="">
                                                    <option value="">Seleccione una opción</option>
                                                    <?php
                                                    foreach ($data['empresa'] as $empresa) {
                                                        if($data['planta'][0]['empresas_id'] == $empresa['id'])
                                                        {
                                                            echo '<option value="' . $empresa['id'] . '" selected>' . $empresa['nombre'] . '</option>';
                                                        } else{
                                                            echo '<option value="' . $empresa['id'] . '">' . $empresa['nombre'] . '</option>';
                                                        }
                                                        
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="alias">Alias (Nombre alternativo) </label>                                                    
                                                <input  disabled="" type="text" class="form-control" name="alias" id="alias" placeholder="Nombre alternativo de empresa y planta" value="<?php echo (isset($data['planta'][0]['alias'])) ? $data['planta'][0]['alias']: ''; ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="rfc">RFC</label>                                                    
                                                <input disabled=""  type="text" class="form-control" name="rfc" id="rfc" placeholder="RFC" value="<?php echo (isset($data['planta'][0]['rfc'])) ? $data['planta'][0]['rfc']:''; ?>" >
                                            </div>
                                            <div class="form-group">
                                                <label for="razon_social">Razoón Social</label>                                                    
                                                <input disabled="" type="text"  class="form-control" name="razon_social" id="razon_social" placeholder="Razon Social" value="<?php echo (isset($data['planta'][0]['razon_social'])) ? $data['planta'][0]['razon_social']:''; ?>" >
                                            </div>
                                                                                        
                                            <div class="form-group">
                                                <label for="cp">Codigo postal </label>                                                    
                                                <input  disabled="" min="0" type="text"   class="form-control" name="cp" id="cp" placeholder="Codigo postal" value="<?php echo (isset($data['planta'][0]['cp'])) ? $data['planta'][0]['cp']:''; ?>">
                                            </div>
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <label for="calle">Calle </label>  
                                                        <input disabled="" type="text" class="form-control" name="calle" id="calle" placeholder="Calle + Numero interior/exterior" value="<?php echo (isset($data['planta'][0]['calle'])) ? $data['planta'][0]['calle']:''; ?>" >
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <label for="colonia">Colonia </label>  
                                                        <input disabled="" type="text" class="form-control" name="colonia" id="colonia" placeholder="Col. Nombre" value="<?php echo (isset($data['planta'][0]['colonia'])) ? $data['planta'][0]['colonia']:''; ?>" >
                                                    </div>
                                                </div>                                               
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <label for="ciudades_id">Delegación/ Municipio/ Ciudad</label>
                                                        <select disabled="" id="ciudades_id" class="form-control select2" style="width: 100%;" name="ciudades_id" >                                                            
                                                            <?php
                                                            foreach ($data['ciudad'] as $ciudad) {
                                                                if($data['planta'][0]['ciudades_id'] == $ciudad['id'])
                                                                {
                                                                    echo '<option value="' . $ciudad['id'] . '" selected>' . $ciudad['nombre'] . '</option>';
                                                                } else{
                                                                    echo '<option value="' . $ciudad['id'] . '">' . $ciudad['nombre'] . '</option>';
                                                                }
                                                                
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6">
                                                    <div class="form-group">
                                                        <label for="estado">Estado </label>  
                                                        <select disabled="" id="estados_id" class="form-control select2" style="width: 100%;" name="estados_id" >                                                            
                                                            <?php
                                                            foreach ($data['estado'] as $estado) {
                                                                if($data['planta'][0]['estados_id'] == $estado['id'])
                                                                {
                                                                    echo '<option value="' . $estado['id'] . '" selected>' . $estado['nombre'] . '</option>';
                                                                } else{
                                                                    echo '<option value="' . $estado['id'] . '">' . $estado['nombre'] . '</option>';
                                                                }
                                                                
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>                                               
                                            </div>

                                            <div class="form-group">
                                                <label for="referencia">Referencia</label>                                                    
                                                <input  disabled="" type="text" class="form-control" name="referencia" id="referencia" placeholder="Entre cale y calle"  value="<?php echo (isset($data['planta'][0]['refereencia'])) ? $data['planta'][0]['refereencia']:''; ?>">
                                            </div>                                            
                                           
                                            <div class="form-group">
                                                <label for="sucursales_id">Sucursal</label>
                                                <select disabled="" id="sucursales_id" class="form-control select2" style="width: 100%;" name="sucursales_id" required="">
                                                    <option value="">Seleccione una opción</option>
                                                    <?php
                                                    foreach ($data['sucursal'] as $sucursal) {
                                                        if($data['planta'][0]['sucursales_id'] == $sucursal['id'])
                                                        {
                                                            echo '<option value="' . $sucursal['id'] . '" selected>' . $sucursal['nombre'] . '</option>';
                                                        } else{
                                                            echo '<option value="' . $sucursal['id'] . '">' . $sucursal['nombre'] . '</option>';
                                                        }
                                                        
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="comentarios">Comentarios</label>
                                                <input disabled=""  type="text" class="form-control" name="comentarios" id="comentarios" placeholder="Comentarios" value="<?php echo (isset($data['planta'][0]['comentarios'])) ? $data['planta'][0]['comentarios']:''; ?>">
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