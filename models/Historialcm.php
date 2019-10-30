<?php

class Historialcm extends Model {

    function __construct() {
        $this->primary_key  = 'id';
        $this->model=[           
        'sucursal' => new Sucursal(),
        ];      
        $this->table = 'historialcm'.$this->model['sucursal']->extension();     
    }    

}