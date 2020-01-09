<?php

class Inventarioc extends Model {

    function __construct() {        
        $this->primary_key='id';
        $this->model=[
            'sucursal'=> new Sucursal(),
        ];
        $this->table='inventarioc'.$this->model['sucursal']->extension();
    }

}