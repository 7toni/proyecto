<?php

Session::logged();

/**
* 
*/
class ClienteinformesController
{
	
	public function __construct()
	{
		$this->name="clienteinformes";
		$this->title="Historial";
		$this->subtitle="Informes";
		$this->model = [
		 'planta' => new Planta(),
		  'sucursal' => new Sucursal(),
        ];
        $this->ext=$this->model['sucursal']->extension();
	}

	public function index(){
		$usuario=Session::get('plantas_id');
		$_SESSION['menu'] = 'informes';
      	$_SESSION['submenu'] = 'ihistorial';			
		include view($this->name.'.read');
	}	

	public function continental(){
		$conti=$this->ext.'conti';		
		$usuario=Session::get('plantas_id');
		$_SESSION['menu'] = 'informes';
      	$_SESSION['submenu'] = 'iconti';
		include view($this->name.'.continental');
	}

	public function recalibrar(){
		$usuario=Session::get('plantas_id');
		$_SESSION['menu'] = 'informes';
      	$_SESSION['submenu'] = 'iavencer';
		include view($this->name.'.recalibrar');
	}

	public function vencidos(){			
		$usuario=Session::get('plantas_id');
		$_SESSION['menu'] = 'informes';
      	$_SESSION['submenu'] = 'ivencidos';	
		include view($this->name.'.vencidos');
	}

}