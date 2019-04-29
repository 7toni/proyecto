<?php

class ControlCalidad extends Model {

    function __construct() {
        $this->primary_key  = 'id';
        $this->model=[           
        'sucursal' => new Sucursal(),
        ];      
        $this->table = 'control_calidad'.$this->model['sucursal']->extension();     
    }    

}