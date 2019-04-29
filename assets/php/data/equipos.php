<?php

$primary_key = 'id';

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'alias', 'dt' => 1),
    array('db' => 'serie', 'dt' => 2),
    array('db' => 'descripcion', 'dt' => 3),
    array('db' => 'marca', 'dt' => 4),
    array('db' => 'modelo', 'dt' => 5),
    //array('db' => 'activo', 'dt' => 6),
    array(
        'db' => 'activo',
        'dt' => 6,
        'formatter' => function($d, $row){
            if($d==0){
                return '<spam class="badge bg-red">inactivo</spam>';
            }
                else{
                    return '<spam class="badge bg-green">activo</spam>';
                }
            }
        ),
    array('db' => 'comentarios', 'dt' => 7),
);
