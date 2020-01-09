<?php

class Historialcv extends Model {

    function __construct() {
        $this->primary_key  = 'id';
        $this->model=[           
        'sucursal' => new Sucursal(),
        ];      
        $this->table = 'historialcv'.$this->model['sucursal']->extension();     
    }    

}