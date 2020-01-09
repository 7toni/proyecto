<?php

class ControlCalidadC extends Model {

    function __construct() {
        $this->primary_key  = 'id';
        $this->model=[           
        'sucursal' => new Sucursal(),
        ];      
        $this->table = 'control_calidadc'.$this->model['sucursal']->extension();     
    }    

}