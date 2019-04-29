<?php

class Inventario extends Model {

    function __construct() {        
        $this->primary_key='id';
        $this->model=[
            'sucursal'=> new Sucursal(),
        ];
        $this->table='inventario'.$this->model['sucursal']->extension();
    }

}