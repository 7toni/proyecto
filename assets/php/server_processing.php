<?php 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// Model of database
$cadena = explode(' ',$_GET['controller']); 
$controller =$cadena[0];
$ext = isset($cadena[1]) ? $cadena[1] : "";
$tipo = isset($cadena[2]) ? $cadena[2] : "";
$usuario = isset($cadena[3]) ? $cadena[3] : "";
$rol = isset($cadena[4]) ? $cadena[4] : "";
$condicion="";
// DB table to use

/* #Home vista de bitacora- porcesos #Home */ 
    if ($controller== "informes") {
        $table = 'view_'.$controller;
        $table.=$ext; 
        $version= substr($ext,2);
        $bool=false;          

        if($version=="_v1"){
            $condicion="id in (SELECT max(id) as id FROM {$table} group by alias order by id desc)";
            $bool=true;         
        }        
       
        if ($tipo == 4) {
            if($bool== true){
                $tipo=$tipo-2;
                $condicion.=" and proceso>={$tipo}"; 
            }
            else{
                $condicion.="proceso=4 ";
            }                       
        }
        if ($tipo == 1) {
            if($bool== true){
                $condicion.=" and proceso=1";
            }
            else{
                $condicion.="proceso=1";
            }            
        }
        if($tipo == 3){
            if($bool== true){
                $condicion.=" and proceso <=". $tipo;
            }
            else{
                $condicion.="proceso <=". $tipo;
            }          
        }   //reqautorizacion<>1 and   
        if($rol == '03'){ 
            if($ext== "_n" && $tipo==1){
                $condicion.=" and usuarios_calibracion_id=".$usuario;
            }                   
        }    
    }
    else{$table = 'view_'.$controller.$ext;}

    
/* #End vista de bitacora- porcesos #End */ 

/* #Home vista de informes cliente #Home */ 
    if ($controller== "clienteinformes") {$table = 'view_'.$controller.$ext;} 
    if($tipo== "clienteinformes"){
        //$condicion= "plantas_id=". $usuario.'';
        $condicion="id IN (SELECT max(id) as id FROM view_clienteinformes{$ext} where plantas_id= '{$usuario}' group by alias order by id desc)";
    }
    if($tipo== "clienteconti"){
        $table = 'view_clienteinformes_nconti';
        //$condicion= "plantas_id=". $usuario.'';
        $condicion="id IN (SELECT max(id) as id FROM mypsa_bitacoramyp.view_clienteinformes_nconti group by alias order by id desc)";
    }

    $query='';
    if($tipo=="recalibrar"){
        $query="periodo_calibracion> 0 and plantas_id=". $usuario." and  fecha_vencimiento between (curdate()) and (date_add(curdate(), interval 1 month))";
        $condicion=$query;        
    }
    if($tipo=="vencidos"){
        $query="plantas_id=". $usuario." and fecha_vencimiento > date_sub(curdate(),interval 3 month) and fecha_vencimiento < curdate()  and alias not in ( select temp2.alias from (SELECT * FROM view_informes".$ext." where plantas_id=". $usuario." and fecha_calibracion >= date_sub(curdate(),interval 3 month)) as temp2) and alias not in ( select temp3.alias from (SELECT * FROM view_informes".$ext." where alias is not null and proceso < 4 and plantas_id=". $usuario." ) as temp3)";
        $condicion=$query;           
    }
/* #End vista de informes cliente #End */ 

/* #Home Reportes */
    if ($controller== "reportes") {   
        $data=json_decode($ext); 
        $table = 'view_'.$controller.$data[0]; // Tabla a consultar view_reporte_(sucursal)        
        $query_condicion = "fecha_calibracion between '". $data[1] ."' and '". $data[2] ."'";                               
        //Filtrar tipos de calibracion        
        $query_condicion .="and calibraciones_id in (". $data[3][0] .")";

        $query_condicion .= " and tecnico_email='". $data[4] ."'";
              
        $condicion= $query_condicion;                   
    }
    if ($controller== "total_product") {  
        $data=json_decode($ext);  //Año,mes,sucursal
        $table = 'view_informes'.$data[3]; // contiene la extension de la tabla a consultar 

        if ($data[0]=="compara" ) {
            $query_condicion =" year(fecha_calibracion)='".$data[1]."' and month(fecha_calibracion) ='".$data[2]."'";
            $query_condicion .= " and estado_calibracion=1";
            //and (calibraciones_id = 1  or calibraciones_id= 2 or  calibraciones_id= 6)
        }
        else{
            $query_condicion =" fecha_hoja_entrada between '".$data[1]."' and '".$data[2]."' ";
        }
       
        if ($data[4] != 0) { // Pregunta se existe cliente
            $query_condicion .= " and plantas_id=".$data[4];
        }                    
        $condicion= $query_condicion;
    }
/* #End Reportes */

/* #Home control calidad */
    if ($controller == "control_calidadc") {
        if($tipo=="bajas"){
            $condicion="activo=0";
        }
        else if($tipo=="activos"){
            $condicion="activo=1";
            }
    }
/* #end  control calidad */

/* #Home control Prueba Electrica */
if ($controller == "control_pruebaelect") {
    if($tipo=="bajas"){
        $condicion="activo=0";
    }
    else if($tipo=="activos"){
        $condicion="activo=1";
        }
}
/* #end  control Prueba Electrica */

// Table's primary key    
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
require ('data/'.$controller.'.php');

 
//SQL server connection information
$sql_details = array(
	'host' => '192.232.243.186',
    'user' => 'mypsa_app2',
    'pass' => 'TL5ZU9J4H2WV',
    'db'   => 'mypsa_bitacoramyp',
    'charset' => 'utf8' 
);

// $sql_details = array(
//     'host' => 'localhost',
//     'user' => 'root',
//     'pass' => '',
//     'db'   => 'mypsa_bitacoramyp',
//     'charset' => 'utf8' 
// );
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */   
 
require( "ssp.class.php" );
echo json_encode(
    SSP::simple($_GET, $sql_details, $table, $primary_key, $columns,$condicion)    
);
