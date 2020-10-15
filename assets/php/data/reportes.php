<?php

$primary_key = 'id';

// $columns = array(
//     array('db' => 'id', 'dt' => 0),
//     array('db' => 'alias', 'dt' => 1),
//     array('db' => 'descripcion', 'dt' => 2),
//     array('db' => 'marca', 'dt' => 3),
//     array('db' => 'modelo', 'dt' => 4),
//     array('db' => 'serie', 'dt' => 5),    
//     array(
//         'db' => 'activo',
//         'dt' => 6,
//         'formatter' => function($d, $row){
//             if($d==0){
//                 return '<spam class="badge bg-red">inactivo</spam>';
//             }
//                 else{
//                     return '<spam class="badge bg-green">activo</spam>';
//                 }
//             }
//         ),    
//     array('db' => 'cliente', 'dt' => 7),
//     array('db' => 'calibracion', 'dt' => 8),
//     array('db' => 'precio', 'dt' => 9),        
//     array('db' => 'precio_extra', 'dt' => 10),
//     array('db' => 'moneda', 'dt' => 11),
//     array(
//         'db' => 'fecha_calibracion',
//         'dt' => 12
//          ),    
//     array(
//             'db' => 'fecha_inicio',
//             'dt' => 13,
//             'formatter'=> function( $d, $row ) { 
//             $start= strtotime($d);              
//             $end= strtotime($row[12]);
//             $count =0;
//             while(date('Y-m-d',$start)< date('Y-m-d',$end))
//             {
//                 $count += date('N',$start) < 6 ? 1:0;
//                 $start = strtotime("+1 day",$start);
//             }
//             return  $count;                            
//             }
//         ),        
//      array(
//             'db' => 'fecha_salida',
//             'dt' => 14,
//             'formatter'=> function( $d, $row ) { 
//                 if($d != null || $d!='')
//                 {
//                     $start= strtotime($row[12]);              
//                     $end= strtotime($d);
//                     $count =0;
//                     while(date('Y-m-d',$start)< date('Y-m-d',$end))
//                     {
//                         $count += date('N',$start) < 6 ? 1:0;
//                         $start = strtotime("+1 day",$start);
//                     }                    
//                 } else{
//                     $count =0; 
//                 }                             
//                 return $count;
//             }
//         ),
//     array('db' => 'fecha_salida', 'dt' => 15),       
//     array('db' => 'proceso', 'dt' => 16),
//     array('db' => 'tecnico', 'dt' => 17)  
// );

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'id_equipo', 'dt' => 1),
    array('db' => 'alias', 'dt' => 2),
    array('db' => 'descripcion', 'dt' => 3),
    array('db' => 'marca', 'dt' => 4),
    array('db' => 'modelo', 'dt' => 5),
    array('db' => 'serie', 'dt' => 6),
    array('db' => 'activo', 'dt' => 7),
    array('db' => 'cliente_id', 'dt' => 8),
    array('db' => 'cliente', 'dt' => 9),
    array('db' => 'estado_calibracion', 'dt' => 10),
    array('db' => 'proceso', 'dt' => 11),
    array('db' => 'calibraciones_id', 'dt' => 12),
    array('db' => 'calibracion', 'dt' => 13),
    array('db' => 'factura', 'dt' => 14),
    array('db' => 'precio', 'dt' => 15),
    array('db' => 'precio_extra', 'dt' => 16),
    array('db' => 'moneda', 'dt' => 17),

    array('db' => 'fecha_captura', 'dt' => 18),
    //Revisar los javascrip si el campo 18 no altera alguna opcion, que correspondia a la fecha_inicio
    array('db' => 'fecha_inicio', 'dt' => 19),
    array('db' => 'fecha_calibracion', 'dt' => 20),
    array('db' => 'periodo_calibracion', 'dt' => 21),
    array('db' => 'fecha_vencimiento', 'dt' => 22),
    array('db' => 'tecnico_id', 'dt' => 23),
    array('db' => 'tecnico', 'dt' => 24),
    array('db' => 'tecnico_email', 'dt' => 25),  
    array('db' => 'fecha_salida', 'dt' => 26),
    array('db' => 'direccion', 'dt' => 27),
    array('db' => 'referencia', 'dt' => 28)
);

?>