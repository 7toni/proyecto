<?php

class Historialv extends Model {

    function __construct() {
        $this->primary_key  = 'id';
        $this->model=[           
        'sucursal' => new Sucursal(),
        ];      
        $this->table = 'historialv'.$this->model['sucursal']->extension();     
    }    

}