<?php

class Planta extends Model {

    function __construct() {
        $this->table  = 'plantas';
        $this->primary_key = 'id';
    }

    public function get_query($query){
        $this->query= $query;
        $this->get_results_from_query();       
        return $this->rows;
    }

}