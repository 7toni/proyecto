<?php

$primary_key='id';

$array1 =array(
    array('db'=>'id','dt'=>0),
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

    array('db' => 'procedimiento', 'dt' => 8),
    array('db' => 'campo_aplicacion', 'dt' => 9),
    array('db' => 'localizacion', 'dt' => 10),

    array('db' => 'responsable', 'dt' => 11),
    array('db' => 'comentario', 'dt' => 12),

    array('db' => 'fecha_registro', 'dt' => 13)
);

$columns= $array1;