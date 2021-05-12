<?php

//date_default_timezone_set('America/Hermosillo');

Session::logged();

class CartastrazController
{
	
	public function __construct()
	{
		$this->name="cartastraz";
		$this->title="Cartas Trazabilidad";
		$this->subtitle="";		
		$this->model = [
			//'informe' => new Informes(),
			'equipo' => new Equipo(),
        	'sucursal' => new Sucursal(),
  		];
       $this->ext=$this->model['sucursal']->extension();
	   $this->sucursal= strtoupper(Session::get('sucursal'));
	   
	   $_SESSION['script'] = '';
	}

	public function index(){		
		$_SESSION['menu'] = 'cartastraz';
		  $_SESSION['submenu'] = 'cartas';
		  
		include view($this->name.'.read');
	}

	public function ayuda(){		
		$_SESSION['menu'] = 'cartastraz';
		$_SESSION['submenu'] = 'ayuda';
		  
		include view($this->name.'.ayuda');
	}

	public function ajax_load_historial(){		
		$sucursal= array('NOGALES'=>'_n','HERMOSILLO'=>'_h','GUAYMAS'=>'_g');
		$directorio = 'storage/trazabilidad'. $sucursal[$this->sucursal].'';				
		$array_file = array_diff(scandir($directorio,1), array('..', '.'));
				
		$datatemp= array();
		$data= array();				
		$mesrenplace= ["ene"=> "1","feb"=> "2","mar"=> "3","abr"=> "4","may"=> "5","jun"=> "6","jul"=> "7","ago"=> "8","sep"=> "9","oct"=> "10","nov"=> "11","dic"=> "12"];															
		$size= sizeof($array_file);				

		if($size > 0 ){
			for($i=0; $i<$size;$i++){
				$value= $array_file[$i];
				$obj= explode("_",$value);
				
				$id= $obj[0];
				$date= substr($obj[1],0,-4);
				$objdate= explode(" a ",$date);
	
				$fechahome= trim($objdate[0]);
				$fechadiv= explode("-",$fechahome);
				$replace = str_replace($fechadiv[1], $mesrenplace[strtolower($fechadiv[1])], $fechahome);
				$fechahome=date("Y/m/d", strtotime($replace));
	
				$fechaend= trim($objdate[1]);
				$fechadiv= explode("-",$fechaend);
				$replace = str_replace($fechadiv[1], $mesrenplace[strtolower($fechadiv[1])], $fechaend);
				$fechaend=date("Y/m/d", strtotime($replace));
				
				$datatemp [] =array("id"=> $id,"fechahome"=>$fechahome,"fechaend"=>$fechaend,"url"=>$value);
			}							
			$aux= array();	
			foreach($datatemp as $row){
				$aux[]=  $row["fechahome"];			
			}		
			array_multisort($aux, SORT_DESC, $datatemp);		

			$size= sizeof($datatemp);

			$hoy = date("Y/m/d");
			foreach($datatemp as $val){
				if(sizeof($data) == 0){
					$fechahome= trim($val["fechahome"]);
					$fechaend= trim($val["fechaend"]);				

					if($fechaend >= $hoy){
						$newarray= array($val["url"],$val["id"],$fechahome,$fechaend,'');
					}else{
						$newarray= array('error_412',$val["id"],$fechahome,$fechaend,$val["url"]);
					}								
					array_push($data, $newarray);							
				}else{
					$igual= false;				  
					
					foreach($data as $key => $row){
						//var_dump( '['. $row[1].'] == ['. $val["id"] .'] <br/>');									
						if( strtolower($val["id"]) === strtolower($row[1])){					
							$data[$key][4]= (strlen($row[4]) > 0 ? ($row[4].'/'):'').$val["url"];
							$igual= true;									
						}				
					}				
					if(!$igual){
						$fechahome= trim($val["fechahome"]);
						$fechaend= trim($val["fechaend"]);
						
						if($fechaend >= $hoy){
							$newarray= array($val["url"],$val["id"],$fechahome,$fechaend,'');
						}
						else{
							$newarray= array('error_412',$val["id"],$fechahome,$fechaend,$val["url"]);
						}								
						array_push($data, $newarray);									
					}				
				}
			}
			$ids_collection="";
			foreach($data as $key => $val){
				$ids_collection .= "'{$val[1]}',";
			}	
			$ids_collection = substr($ids_collection, 0, -1);
			$result= $this->get_queryequipo($ids_collection);
			
			foreach($data as $key => $val){
				$entro=false;
				foreach($result as $row => $col){
					if($val[1]===$col['alias']){
						$data[$key][]= $col['id'];
						$data[$key][]= $col['alias'];
						$data[$key][]= $col['descripcion'];
						$data[$key][]= $col['marca'];
						$data[$key][]= $col['modelo'];
						$data[$key][]= $col['serie'];
						$entro=true;
						break;
					}												
				}
				if($entro==false){
					$data[$key][]= "Sin registro";
					$data[$key][]= "Sin registro";
					$data[$key][]= "Sin registro";
					$data[$key][]= "Sin registro";
					$data[$key][]= "Sin registro";
					$data[$key][]= "Sin registro";	
				}												
			}			
		}
		echo json_encode($data);				
		// $usuario =Session::get('id');		
		// $rol =substr(Session::get('roles_id'),-2); // solo se abstrae el ultimo numero del rol todos empiesan con 100 00
		// if($rol == "00" || $rol == "02" || $rol == "06"){
		// 	$proceso="";
		// }
		// else{
		// 	$proceso="4";
		// }
	}

	private function get_queryequipo($ids){	
		$query="SELECT * FROM mypsa_bitacoramyp.view_equipos where alias in ({$ids});";
		$dato= $this->model['equipo']->get_query($query);
		return $dato;
	}

	public function vercartastraz(){
		$usuario =Session::get('id');		 
		$rol =Session::get('roles_id');		 
		if (isset($_GET['p']) && ($rol !='10001' || $rol !='10004')) {
		 	$url=$_GET['p'];	
		  	//$temp = json_encode($data['informe'] = $this->model['informe']->get_comparar_cliente($numinforme),true);		
		  	//$cliente= json_decode($temp, true);
		  	$plantaid=Session::get('plantas_id');		  	
		 	$file='storage/trazabilidad'.$this->ext.'/'.$url;	 		 		 	 			
			if (is_file($file)) {
					// if($plantaid == $cliente[0]["plantas_id"] && $rol =='10005') // Nos ayudara para saber si el cliente que quiere ver su informe le corresponde ese número
				 	// {
					// 	include view($this->name.'.vercartastraz');
				 	// }	
				 	// else if($rol !='10005'){ // A los demas usuarios que son del equipo interno si los dejara ver
					// 	include view($this->name.'.vercartastraz');
				 	// }
				 	// else{
				 	// 	redirect('?c=error&a=error_404');
					 // }					 
					 include view($this->name.'.vercartastraz');
			 } else {
		   		redirect('?c=error&a=error_412');
		  	}		 					
		}
		else{
			redirect('?c=error&a=error_412');
		}
	}

	public function ajax_enviaremail(){		  
		$data = [
			  'de' => $_POST['de'],
			  'asunto' => $_POST['asunto'],			 
			  'mensaje' => $_POST['mensaje'],			  
			];
		$empresa= Session::get('empresa');
		$planta= Session::get('planta');
		$direccion= Session::get('direccion');
		$data['cliente']= $empresa. ', '.$planta.', '. $direccion; 
		$sucursal=Session::get('sucursal');
		$data['sucursal']= $sucursal;		
			  
		$data['body']=EnvioCorreo::_bodysolicitudcarta($data);  
				          		 
		$email_suc = ["nogales"=>"cartas.nogales@mypsa.com.mx","hermosillo"=>"cartas.hermosillo@mypsa.com.mx","guaymas"=>"cartas.guaymas@mypsa.com.mx"];

		  $data['email']= $email_suc[strtolower($sucursal)];
		  //$data['email']= "otoniel.hernandez@mypsa.com.mx";
		  $data['nombre']= "";
		  $data['cc'] = array(
							'email' => array($data['de']), 
							'alias' => array($data['de']),
						);
		  
		  $data['cco'] = array(
							'email' => array('bitacora.soporte@mypsa.com.mx','calidad@mypsa.mx','mvega@mypsa.mx'), 
							'alias' => array('Bitacora S.','Calidad','Manuel V.'),                       
						);                   
			  			    	
		  $retorno=EnvioCorreo::_enviocorreo($data);		  		  
	
		  echo json_encode($retorno);                                          
	  }
	

}

?>
