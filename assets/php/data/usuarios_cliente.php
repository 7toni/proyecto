<?php

$primary_key = 'id';

$columns = array(
    array('db' => 'id', 'dt' => 0),
    array('db' => 'nombre', 'dt' => 1),
    array('db' => 'apellido', 'dt' => 2),
    array('db' => 'empresa', 'dt' => 3),
    array('db' => 'planta', 'dt' => 4),
    array('db' => 'direccion', 'dt' => 5),
    array('db' => 'puesto', 'dt' => 6),
    array('db' => 'telefono', 'dt' => 7),
    array('db' => 'email', 'dt' => 8),
    array('db' => 'rol', 'dt' => 9),
    //array('db' => 'activo', 'dt' => 9),
    array(
        'db' => 'activo',
        'dt' => 10,
        'formatter' => function($d, $row){
            if($d=='no'){
                return '<spam class="badge bg-red">NO</spam>';
            }
                else{
                    return '<spam class="badge bg-green">SI</spam>';
                }
            }
        ),
);
