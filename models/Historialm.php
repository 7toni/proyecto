<?php

class Historialm extends Model {

    function __construct() {
        $this->primary_key  = 'id';
        $this->model=[           
        'sucursal' => new Sucursal(),
        ];      
        $this->table = 'historialm'.$this->model['sucursal']->extension();     
    }    

}