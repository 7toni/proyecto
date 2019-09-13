<aside class="main-sidebar">
    <section class="sidebar">
        <div class="user-panel">
            <div class="pull-left image">
                <a href="storage/avatares/<?php echo session::get('imagen');  ?>" data-lightbox="perfil">
                    <img  id="avatar" src="storage/avatares/<?php echo session::get('imagen'); ?>" class="img-circle" alt="User Image">
                </a>
            </div>
            <div class="pull-left info">
                <p><?php echo ucfirst(session::get('nombre')) . ' ' .ucfirst(session::get('apellido')) ; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> En línea</a>
            </div>
        </div>
        <!-- <div class="sidebar-form">-->
            <!-- <div class="input-group"> -->
                <!-- <input type="text" id="search" class="form-control" placeholder="Buscar..." required="" min="3"> -->                
                <!-- <span class="input-group-btn">
                    <a href="#" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></a>
                </span> -->
            <!-- </div> -->
        <!-- </div> -->
        <ul class="sidebar-menu">
            <li class="header">MENÚ DE NAVEGACIÓN</li>
            <?php             
                if(Session::has('rol',['Administrador','Ingenieros','Calidad'])){ 
                    $pulsom = ($_SESSION['menu']=='pulso') ? 'active' : '' ;                   
                    echo "<li class='". $pulsom ." treeview'>
                            <a href='?c=reportes&a=pulso'>
                               <i class='fa fa-dashboard'></i> <span>Pulso MyPSA</span>                    
                            </a>                
                        </li>";                                                
                }    
            ?>
            <?php 
                $bitacoram = ($_SESSION['menu']=='bitacora') ? 'active' : '';
                echo "<li class='". $bitacoram ." treeview'>";                
            ?>            
                <?php
                    if(Session::has('rol',['Administrador','Ingenieros','Almacén','Técnicos','Calidad'])){ 
                echo "
                <a href='#'>
                    <i class='fa fa-table'></i> <span>Bitacora</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                </a>";
                }?>
                <ul class='treeview-menu'>
                 <?php 
                    $completasm = ($_SESSION['submenu']=='completa') ? 'active' : '';
                    $recepcionsm = ($_SESSION['submenu']=='recepcion') ? 'active' : '';
                    $recepcionvolsm = ($_SESSION['submenu']=='recepcionvol') ? 'active' : '';
                    $recepcionactvolsm = ($_SESSION['submenu']=='actualizarvol') ? 'active' : '';
                    $procesosm = ($_SESSION['submenu']=='proceso') ? 'active' : '';               
                    $acalibrarsm = ($_SESSION['submenu']=='acalibrar') ? 'active' : '';               
                        if(Session::has('rol',['Administrador','Técnicos','Ingenieros','Almacén'])){
                            echo "
                                <li class='". $recepcionsm ."'><a href='?c=recepcion'><i class='fa fa-circle-o'></i>Recepción de equipo</a></li>                                
                                <li class='". $completasm ."'><a href='?c=informes'><i class='fa fa-circle-o'></i>Bitacora completa</a></li>                                
                                <li class='". $procesosm ."'><a href='?c=informes&a=proceso'><i class='fa fa-circle-o'></i>Equipos en proceso</a></li>                                
                           ";
                        }
                        if(Session::has('rol',['Administrador','Almacén'])){
                            echo "<li class='". $recepcionvolsm ."'><a href='?c=recepcion&a=registrovol'><i class='fa fa-circle-o'></i>Recepción por volumen</a></li>
                            <li class='". $recepcionactvolsm ."'><a href='?c=recepcion&a=volumen'><i class='fa fa-circle-o'></i>Actualizar informes (*.csv)</a></li>";
                        }
                        if(Session::has('rol',['Administrador','Técnicos'])){
                            echo "                                
                                <li class='". $acalibrarsm ."'><a href='?c=informes&a=calibrar'><i class='fa fa-circle-o'></i>Equipos a calibrar</a></li>
                           ";
                        }                        
                        // if(Session::has('rol',['Administrador'])){
                        //     echo " <li><a href='?c=login&a=sucursal'><i class='fa fa-circle-o'></i>Sucursal</a></li> ";
                        // } 
                        if(Session::has('rol',['Calidad'])){
                            echo "         
                                <li class='". $completasm ."'><a href='?c=informes'><i class='fa fa-circle-o'></i>Bitacora Terminada</a></li>                                                 
                                <li class='". $procesosm ."'><a href='?c=informes&a=proceso'><i class='fa fa-circle-o'></i>Equipos en proceso</a></li>
                                <li class='". $acalibrarsm ."'><a href='?c=informes&a=calibrar'><i class='fa fa-circle-o'></i>Equipos a calibrar</a></li>
                           ";
                        }                                                            
                ?>             
                </ul>
            </li>
            <?php
                $informesm = ($_SESSION['menu']=='informes') ? 'active' : '';

                $ihistorialsm = ($_SESSION['submenu']=='ihistorial') ? 'active' : '';
                $icontim = ($_SESSION['submenu']=='iconti') ? 'active' : '';
                $iavencersm = ($_SESSION['submenu']=='iavencer') ? 'active' : '';
                $ivencidossm = ($_SESSION['submenu']=='ivencidos') ? 'active' : '';

                if(Session::has('rol',['Administrador','Ingenieros','Almacén','Servicios','Calidad'])){
                        echo "<li class='". $informesm ." treeview'>
                        <a href='#''>
                            <i class='fa fa-files-o'></i> <span>Informes</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                        </a>";
                        echo "<ul class='treeview-menu'>";
                        if(Session::get('plantas_id')=='126'){
                            echo "<li class='". $ihistorialsm ."' ><a href='?c=clienteinformes&a=continental'><i class='fa fa-circle-o'></i>Historial informes</a></li>";
                        }   
                        else{echo "<li class='". $ihistorialsm ."' ><a href='?c=clienteinformes'><i class='fa fa-circle-o'></i>Historial informes</a></li>";} 
                        if(Session::get('plantas_id')=='758' && Session::has('rol',['Administrador'])){
                        echo "<li class='". $icontim ."' ><a href='?c=clienteinformes&a=continental'><i class='fa fa-circle-o'></i>Historial informes conti</a></li>"; 
                        }
                         echo "<li class='". $iavencersm ."' ><a href='?c=clienteinformes&a=recalibrar'><i class='fa fa-circle-o'></i>Equipos a vencer</a></li>";
                          echo "<li class='". $ivencidossm ."' ><a href='?c=clienteinformes&a=vencidos'><i class='fa fa-circle-o'></i>Equipos vencidos</a></li>";
                           //echo '<li><a href="#"><i class="fa fa-circle-o"></i>Cartas de trazabilidad</a></li>';
                           echo "</ul> </li>";
                    }
                ?>              
             <!-- Módulos de reportes  --> 
             <?php
                $reportesm = ($_SESSION['menu']=='reportes') ? 'active' : '';
                $rindexsm = ($_SESSION['submenu']=='reportes_tecnico') ? 'active' : '';
                $rtecnicossm = ($_SESSION['submenu']=='reportes_tecnico') ? 'active' : '';
                $rclientessm = ($_SESSION['submenu']=='reportes_cliente') ? 'active' : '';
                $rproductsm = ($_SESSION['submenu']=='reportes_productividad') ? 'active' : '';

                //<li class='". $rtecnicossm ."' ><a href='?c=reportes'><i class='fa fa-circle-o'></i>Técnicos</a></li>     
                if(Session::has('rol',['Administrador','Ingenieros','Calidad']) || Session::has('email',['drodriguez@mypsa.com.mx'])){             
                    echo "<li class='". $reportesm ." treeview'>
                        <a href='#'>
                            <i class='fa fa-pie-chart'></i> <span>Reportes</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                        </a>
                        <ul class='treeview-menu'>
                            <li class='". $rindexsm ."' ><a href='?c=reportes'><i class='fa fa-circle-o'></i>
                            Técnico</a></li>                                                   
                            <li class='". $rclientessm ."' ><a href='?c=reportes&a=cliente'><i class='fa fa-circle-o'></i>
                            Clientes</a></li>
                            <li class='". $rproductsm ."' ><a href='?c=reportes&a=productividad'><i class='fa fa-circle-o'></i>
                            Productividad</a></li>                  
                        </ul>
                        </li>";
                }            
            ?>
            <!-- Menu para las opciones de Calidad -->

            <!-- End Menu Calidad -->
            <?php
            if(Session::has('rol',['Administrador','Ingenieros','Calidad'])){
                    echo "<li class='header'>CALIDAD</li>";

                    //adminsitración de equipos
                    $calidadm = ($_SESSION['menu']=='control_calidad') ? 'active' : '';
                    $calidadsm = ($_SESSION['submenu']=='control_calidad') ? 'active' : '';                    
                    //$calidadspc = ($_SESSION['submenu']=='pulsocalidad') ? 'active' : '';
                    $calidadsb=($_SESSION['submenu']=='bajas') ? 'active' : '';                    
                    $calidadsi=($_SESSION['submenu']=='inventario') ? 'active' : '';
                    $historialcsm = ($_SESSION['submenu']=='historialm') ? 'active' : '';
                    $historialcsv = ($_SESSION['submenu']=='historialv') ? 'active' : '';

                    echo "<li class='". $calidadm ." treeview'>
                    <a href='#'>
                        <i class='fa fa-calendar-check-o'></i> <span>Control de Calidad</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                    </a>
                    <ul class='treeview-menu'>                                                                        
                        <li class='". $calidadsm ."'><a href='?c=control_calidad'><i class='fa fa-calendar-o'></i> Control de Equipos</a></li>
                        <li class='". $calidadsi ."'><a href='?c=inventario'><i class='fa fa-cubes'></i> Inventario</a></li>
                        <li class='". $calidadsb ."'><a href='?c=control_calidad&a=bajas'><i class='fa fa-toggle-off'></i> Baja MPC</a></li>
                        <li class='". $historialcsm ."'><a href='?c=historialm'><i class='fa fa-archive'></i> Historial Mantenimiento</a></li>
                        <li class='". $historialcsv ."'><a href='?c=historialv'><i class='fa fa-archive'></i> Historial Verificación</a></li>
                    </ul>
                </li>";

                //<li class='".$calidadspc ."'><a href='?c=control_calidad&a=pulsocalidad'><i class='fa fa-heartbeat'></i> Pulso Calidad</a></li>


            }
            ?>
            <!-- Módulos de administración  -->
            <?php                

                if(Session::has('rol',['Administrador','Ingenieros','Almacén','Técnicos','Calidad'])){
                    echo "<li class='header'>ADMINISTRACIÓN</li>";
                    //adminsitración de equipos
                    $equiposm = ($_SESSION['menu']=='equipos') ? 'active' : '';

                    $equipossm = ($_SESSION['submenu']=='equipos') ? 'active' : '';
                    $descripcionsm = ($_SESSION['submenu']=='equipos_descripciones') ? 'active' : '';
                    $marcasm = ($_SESSION['submenu']=='equipos_marcas') ? 'active' : '';
                    $modelosm = ($_SESSION['submenu']=='equipos_modelos') ? 'active' : '';
                        echo "<li class='". $equiposm ." treeview'>
                            <a href='#'>
                                <i class='fa fa-wrench'></i> <span>Administración de equipos</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                            </a>
                            <ul class='treeview-menu'>
                                <li class='". $equipossm ."'><a href='?c=equipos'><i class='fa fa-database'></i> Equipos</a></li>
                                <li class='". $descripcionsm ."'><a href='?c=equipos_descripciones'><i class='fa fa-font'></i> Descripción de equipos</a></li>
                                <li class='". $marcasm ."'><a href='?c=equipos_marcas'><i class='fa fa-tags'></i>Marcas de equipos</a></li>
                                <li class='". $modelosm ."'><a href='?c=equipos_modelos'><i class='fa fa-list'></i>Modelos de equipos</a></li>
                            </ul>
                        </li>";
    
                    //adminsitración de clientes
                    $clientesm = ($_SESSION['menu']=='clientes') ? 'active' : '';

                    $empresassm = ($_SESSION['submenu']=='empresas') ? 'active' : '';
                    $plantassm = ($_SESSION['submenu']=='plantas') ? 'active' : '';    
                        echo "<li class='". $clientesm ." treeview'>
                            <a href='#'>
                                <i class='fa fa-address-card' aria-hidden='true'></i> <span>Administración de clientes</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                            </a>
                            <ul class='treeview-menu'>
                                <li class='". $empresassm ."'><a href='?c=empresas'><i class='fa fa-building'></i>Empresas</a></li>
                                <li class='". $plantassm ."'><a href='?c=plantas'><i class='fa fa-industry'></i>Planta/Sucursal</a></li>
                            </ul>
                        </li>";
                        //adminsitración de modulos
                    $modulosm = ($_SESSION['menu']=='modulos') ? 'active' : '';

                    $paissm = ($_SESSION['submenu']=='paises') ? 'active' : '';
                    $estadosm = ($_SESSION['submenu']=='estados') ? 'active' : '';
                    $ciudadsm = ($_SESSION['submenu']=='ciudades') ? 'active' : '';
                    $tipocalsm = ($_SESSION['submenu']=='calibraciones') ? 'active' : '';
                    $sucursalsm = ($_SESSION['submenu']=='sucursales') ? 'active' : '';
                    $acreditacionsm = ($_SESSION['submenu']=='acreditacion') ? 'active' : '';
                    echo "<li class='". $modulosm ." treeview'>
                        <a href='#'>
                            <i class='fa fa-th'></i> <span>Módulos</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                        </a>
                        <ul class='treeview-menu'>
                            <li class='". $paissm ."'><a href='?c=paises'><i class='fa fa-globe'></i>Paises</a></li>
                            <li class='". $estadosm ."'><a href='?c=estados'><i class='fa fa-globe'></i>Estados</a></li>
                            <li class='". $ciudadsm ."'><a href='?c=ciudades'><i class='fa fa-globe'></i>Ciudades</a></li>
                            <li class='". $tipocalsm ."'><a href='?c=calibraciones'><i class='fa fa-cog'></i>Tipo de calibración</a></li>
                            <li class='". $sucursalsm ."'><a href='?c=sucursales'><i class='fa fa-suitcase'></i>Sucursales</a></li>
                            <li class='". $acreditacionsm ."'><a href='?c=acreditaciones'><i class='fa fa-certificate'></i>Acreditaciones</a></li>
                        </ul>
                    </li>";                            
                    //adminsitración de usuarios
                    $usuariosm = ($_SESSION['menu']=='usuarios') ? 'active' : '';

                    $usuariossm = ($_SESSION['submenu']=='usuarios') ? 'active' : '';
                    $usuariosrolsm = ($_SESSION['submenu']=='roles') ? 'active' : '';
                    $usuariosaltasm = ($_SESSION['submenu']=='usuariosalta') ? 'active' : '';            
                    if(Session::has('rol',['Administrador','Ingenieros','Calidad'])){
                        echo "<li class='".$usuariosm." treeview'>
                            <a href='#'>
                                <i class='fa fa-user'></i> <span>Cuentas de usuarios</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                            </a>
                            <ul class='treeview-menu'>
                                <li class='".$usuariossm. "'><a href='?c=usuarios'><i class='fa fa-users'></i>Usuarios</a></li>
                                <li class='".$usuariosrolsm. "'><a href='?c=roles'><i class='fa fa-cogs'></i>Roles de usuarios</a></li>
                                <li class='".$usuariosaltasm. "'><a href='?c=usuarios&a=alta'><i class='fa fa-users'></i>Alta de Usuarios</a></li>
                            </ul>
                        </li>";
                    }           
                    //adminsitración del LOG
                    $logm = ($_SESSION['menu']=='logs') ? 'active' : '';
                    $logsm = ($_SESSION['submenu']=='logs') ? 'active' : '';                            
                    if(Session::has('rol',['Administrador'])){
                        echo  "<li class='". $logm ." treeview'>
                            <a href='#'>
                                <i class='fa fa-cog'></i> <span>Administración</span><span class='pull-right-container'><i class='fa fa-angle-left pull-right'></i></span>
                            </a>
                            <ul class='treeview-menu'>
                                <li class='". $logsm ."'><a href='?c=logs'><i class='fa fa-cog'></i>Logs</a></li>
                            </ul>
                        </li>";
                    }
                }
            ?>
        </ul>
    </section>
</aside>