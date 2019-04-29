<?php

class Magnitud extends Model {

    function __construct() {
        $this->table = 'magnitudes';
        $this->primary_key = 'id';
    }

}