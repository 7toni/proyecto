<?php

Session::logged();

class LogsController {

    public function __construct() {
        $this->name = "logs";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'log' => new Log(),
        ];
    }

    public function index() {
        $_SESSION['menu'] = 'logs';
        $_SESSION['submenu'] = $this->name;
        include view($this->name . '.read');
    }
}
