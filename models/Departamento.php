<?php

class Departamento extends Model {

    function __construct() {
        $this->table = 'departamentos';
        $this->primary_key = 'id';
    }

}