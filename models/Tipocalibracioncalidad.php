<?php

class TipoCalibracionCalidad extends Model {

    function __construct() {
        $this->table = 'calibraciones_calidad';
        $this->primary_key = 'id';
    }

}