<?php

$primary_key = 'id';

$array1 = array(
    array('db' => 'id', 'dt' => 0),

    array('db' => 'equipos_id', 'dt' => 1),//ocultar
    array('db' => 'clave', 'dt' => 2),
    array('db' => 'descripcion', 'dt' => 3),
    array('db' => 'marca', 'dt' => 4),
    array('db' => 'modelo', 'dt' => 5),
    array('db' => 'serie', 'dt' => 6),    
    //array('db' => 'activo', 'dt' => 7),
    array(
        'db' => 'activo',
        'dt' => 7,
        'formatter' => function($d, $row){
            if($d==0){
                return '<spam class="badge bg-red">inactivo</spam>';
            }
                else{
                    return '<spam class="badge bg-green">activo</spam>';
                }
            }
        ),    
    //array('db' => 'calibraciones_id', 'dt' => 8),        
    array('db' => 'magnitud', 'dt' => 8),
    //array('db' => 'magnitudes_id', 'dt' => 10),
    array('db' => 'calibracion', 'dt' => 9),

    array('db' => 'requierec', 'dt' => 10), 
    array('db' => 'informe', 'dt' => 11),    
    array('db' => 'fecha_calibracion', 'dt' => 12),
    array('db' => 'fecha_vencimiento', 'dt' => 13),
    array('db' => 'vigencia', 'dt' => 14),    
       
    array('db' => 'fecha_vencimiento', 'dt' => 15), // Funcion calcular fecha
   
    array('db' => 'requierem', 'dt' => 16),
    array('db' => 'mantenimiento_id', 'dt' => 17),//ocultar
    array('db' => 'ultimo_mantenimiento', 'dt' => 18),
    array('db' => 'proxm', 'dt' => 19),
    //array('db' => 'contadorm', 'dt' => 20),
    array('db' => 'proxm','dt' => 20), //Funcion calcular fecha

    array('db' => 'requierev', 'dt' => 21),       
    array('db' => 'verificaciones_id', 'dt' => 22),
    array('db' => 'ultima_verificacion', 'dt' => 23),
    array('db' => 'proxv', 'dt' => 24),    
    //array('db' => 'contadorv', 'dt' => 26),
    array('db' => 'proxv', 'dt' => 25), //Funcion calcular fecha

    array('db' => 'comentario', 'dt' => 26),
    array('db' => 'fecha', 'dt' => 27),
    array('db' => 'responsable', 'dt' => 28),

    array('db' => 'fechaingreso', 'dt' => 29)
);

$columns = $array1;