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
		$this->subtitle="Certificados";
		$this->model = [
		 'planta' => new Planta(),
		  'sucursal' => new Sucursal(),
		  'informes' => new Informes(),
        ];
		$this->ext=$this->model['sucursal']->extension();
		$_SESSION['script'] = '';
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

	public function ajax_historial(){
		$idequipo = $_POST['idequipo'];
		$idplanta = $_POST['idplanta'];
		if($_SESSION['submenu'] === "iconti"){
			$view_informes="view_clienteinformes". $this->ext.'conti';
		}
		else{
			$view_informes="view_clienteinformes". $this->ext;
		}
		//$view_informes="view_clienteinformes". $this->ext;
		$query="SELECT * FROM ".$view_informes." where id_equipo={$idequipo} and plantas_id={$idplanta} order by id desc;";                         
		$data=$this->model['informes']->get_query_informe($query);    

		if(sizeof($data) > 0){
			foreach($data as $row => $value){				
				$file='storage/informes'.$this->ext.'/'. $value['id'].'.pdf';
				if (is_file($file)) {
					$data[$row]['isfile']="1";
				}else{
					$data[$row]['isfile']="0";
				}
			}
		}
		echo json_encode($data);
	}


}