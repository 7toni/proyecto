<?php

Session::logged();

class InformesController
{
	
	public function __construct()
	{
		$this->name="informes";
		$this->title="Historial";
		$this->subtitle="Bitácora";		
		$this->model = [
            'informe' => new Informes(),
        	'sucursal' => new Sucursal(),
  		];
       $this->ext=$this->model['sucursal']->extension();
	   $this->sucursal= strtoupper(Session::get('sucursal'));
	   
	   $_SESSION['script'] = '';
	}

	public function index(){
		$usuario =Session::get('id');		
		$rol =substr(Session::get('roles_id'),-2); // solo se abstrae el ultimo numero del rol todos empiesan con 100 00
		if($rol == "00" || $rol == "02" || $rol == "06"){
			$proceso="";
		}
		else{
			$proceso="4";
		}
		$_SESSION['menu'] = 'bitacora';
      	$_SESSION['submenu'] = 'completa';
		include view($this->name.'.read');
	}

	public function proceso(){
		$usuario =Session::get('id');		
		$rol =substr(Session::get('roles_id'),-2); // solo se abstrae el ultimo numero del rol todos empiesan con 100 00
		$_SESSION['menu'] = 'bitacora';
        $_SESSION['submenu'] = 'proceso';
		include view($this->name.'.proceso');
	}

	public function cancelar(){
		$usuario =Session::get('id');		
		$rol =substr(Session::get('roles_id'),-2); // solo se abstrae el ultimo numero del rol todos empiesan con 100 00
		$_SESSION['menu'] = 'bitacora';
        $_SESSION['submenu'] = 'cancelar';
		include view($this->name.'.cancelar');
	}

	public function calibrar(){		
		Session::logged([
			//'roles_id' => '10003|10000',
		]);
		$usuario =Session::get('id');		 
		$rol =Session::get('roles_id');
		$_SESSION['menu'] = 'bitacora';
	    $_SESSION['submenu'] = 'acalibrar';
		include view($this->name.'.calibrar');
	}

	public function verinforme(){
		$usuario =Session::get('id');		 
		$rol =Session::get('roles_id');		 
		if (isset($_GET['p']) && ($rol !='10001' || $rol !='10004')) {
		 	$numinforme=$_GET['p'];	
		  	$temp = json_encode($data['informe'] = $this->model['informe']->get_comparar_cliente($numinforme),true);		
		  	$cliente= json_decode($temp, true);
		  	$plantaid=Session::get('plantas_id');		  	
		 	$file='storage/informes'.$this->ext.'/'.$numinforme.'.pdf';		 		 		 	 			
			if (file_exists($file)) {		 		
					if($plantaid == $cliente[0]["plantas_id"] && $rol =='10005') // Nos ayudara para saber si el cliente que quiere ver su informe le corresponde ese número
				 	{
						include view($this->name.'.verinforme');
				 	}	
				 	else if($rol !='10005'){ // A los demas usuarios que son del equipo interno si los dejara ver
						include view($this->name.'.verinforme');
				 	}
				 	else{
				 		redirect('?c=error&a=error_404');
				 	}
			 } else {
		   		redirect('?c=error&a=error_412');
		  	}		 					
		}
		else{
			redirect('?c=error&a=error_412');
		}
	}

	public function autorizacion(){
		$usuario =Session::get('id');		
		$rol =substr(Session::get('roles_id'),-2); // solo se abstrae el ultimo numero del rol todos empiesan con 100 00
				
		$_SESSION['menu'] = 'bitacora';
      	$_SESSION['submenu'] = 'autorizacion';
		include view($this->name.'.autorizacion');
	}
		
	public function get_a_calibrar(){
        echo $data = json_encode($data['informe'] = $this->model['informe']->equipos_calibrar_notification());
	}

	public function get_a_autorizar(){
        echo $data = json_encode($data['informe'] = $this->model['informe']->equipos_autorizar_notification());
	}

	public function ajax_turn_off(){
		$id = $_POST['id'];

		$data['informe'] = $this->model['informe']->find($id);
		
        if (exists($data['informe'])) {
			$rol =substr(Session::get('roles_id'),-2); // solo se abstrae el ultimo numero del rol todos empiesan con 100 00
			if($rol == "00" || $rol == "02" || $rol == "04"|| $rol == "06"){				                          				
				$data = [
				    'id' => $id,
					'equipos_id' => null,
					'plantas_id' => null,
					'po_id' => null,
					'acreditaciones_id' => null,
					'calibraciones_id' => null,
					'hojas_entrada_aux_id' => null,
					'usuarios_calibracion_id' => null,
					'periodo_calibracion' => null,
					'usuarios_informe_id' => null,
					'fecha_vencimiento' => null,
					'fecha_calibracion' => null,
					'hojas_salida_id' => null,
					'precio' => null,
					'precio_extra' => null,
					'factura' => null,
					'monedas_id' => null,
					'fecha_finalizacion' => null,
					'comentarios' => null,
					'prioridad' => null,
					'periodo_id' => null
				];
				$disponible = $data['informe'][0]['calibrado'];
                if($disponible < 2){
					$data['calibrado'] = 2;
					$data['proceso'] = 0;
                } else{
					$data['calibrado'] = 0;
					$data['proceso'] = 0;
                }
				unset($data['informe']);								
				
                if ($this->model['informe']->update($data)) {
					Logs::this("Suspención de informe", "Número de informe: ".$data['id']." supendido."); 
                    echo json_encode("exitoso");
                } else {
                   echo json_encode("error");
                }
            }else{
				redirect('?c=error&a=error_403');
			}
        }
	}

	public function ajax_autorizacion(){
		$tipoaut = $_POST[0];
		$datos = $_POST[1];								
		
		$usuario=Session::get('email');
		$mensaje="";		
		$retorno= array();				

		for($i=0; $i< sizeof($datos);$i++){
			//El data['id'] se actualizara su valor cada iteracion 
			$data['id']= $datos[$i][0];			
			$data['comentarios' ]= null;
			$equipo=$datos[$i][1].', '. $datos[$i][2].', '. $datos[$i][3].', '.$datos[$i][4].', '.$datos[$i][5];
			$informe=$datos[$i][0];

			if($tipoaut==1){
				$data['reqautorizacion']= 2;
				//Cuando el proceso este en el inicio, cambiar el estado del proceso a calibracion				
				if($datos[$i][31] == 0){
					$data['proceso']=1;
				}
				$mensaje = "Aprobado, registro de equipo repetido: {$equipo}. del informe: {$informe}, autorizado por el usuario {$usuario}";
				// Si el equipo es aprobado en repetir el equipo, se modificara el campo comentarios

			}else{
				$data['reqautorizacion']= 0;
				$data['equipos_id']= null;
				$mensaje ="Cancelado, no se registro el equipo {$equipo}, en el informe {$informe}, cancelado por el usuario {$usuario}";
				// Si el registro es cancelado en repetir id del equipo, se eliminara todo contenido que se asocie con el informe
			}		

			/* Update  */
			if ($this->model['informe']->update($data))  {
				Logs::this("Solicitud de autorización", $mensaje);				
				array_push($retorno, null);			
			}
			else{					
				array_push($retorno,$data['id']);
			}			
		}					
		echo json_encode($retorno);

	}

	public function scaninforme(){								
		include view($this->name.'.scaninforme');
	}

	public function ajax_scaninforme(){			
		$sucursal= array('NOGALES'=>'_n','HERMOSILLO'=>'_h','GUAYMAS'=>'_g');		
		$array = $_POST['data'];									
		$data= array();
		foreach($array as $row => $value ){											
			if($value != ""){
				$nombre_fichero = 'storage/informes'.$sucursal[$this->sucursal].'/'. $value.'.pdf';	
				if (!file_exists($nombre_fichero)){
					$data[]= $value;
				}
			}																			
		}
		echo json_encode($data);
	}

	public function existsinforme(){
		if (isset($_POST['id'])){
			$id=$_POST['id'];
			$file='storage/informes'.$this->ext.'/'.$id.'.pdf';	
			if (is_file($file)) {
				$return=true;
			}else{
				$return=false;
			}
		}else{
			$return=false;
		}
		echo json_encode($return);
	}

	public function ajax_historial(){
		$id = $_POST['informe'];			
		$view_informes="view_informes". $this->ext."_v1";				
		$query="SELECT * FROM {$view_informes} where idequipo = (select idequipo from {$view_informes} where id={$id}) order by id desc;";
		
		$data=$this->model['informe']->get_query_informe($query);		
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
