<?php
Session::logged();

class ReportesController{		

	public function __construct()
	{
		$this->name="reportes";
		$this->title="Reportes";
		$this->subtitle="";		
		$this->model = [		 
		 'sucursal' => new Sucursal(),
		 'usuario'=> new Usuario(),
		 'tipocalibracion'=> new Tipocalibracion(),
		 'informe'=> new Informes(),
		 'planta' => new Planta(),
        ];
        $this->ext=$this->model['sucursal']->extension();        
	}

	public function index(){

		// if(isset($_POST['submit'])){
		// 	$data = validate($_POST, [
	    //         'daterange' => 'required',
	    //         'nombre_suc' => 'required|trimlower',
	    //         'usuarios_calibracion_id' => 'required|toInt',          
	    //         'calibraciones_id' => 'required|toInt',            
	    //     ]); 
	    //     $cadena= explode(' - ', $data['daterange']);				
		// 	unset($data['daterange']);
		// 	$data['fecha_home']=$cadena[0];
		// 	$data['fecha_end']=$cadena[1];
		// 	$ext="";
	    // 	if ($data['nombre_suc']== 'nogales') {$ext="_n"; }
	    //     else if($data['nombre_suc']== 'hermosillo') {$ext="_h"; }
	    //     else if($data['nombre_suc']== 'guaymas') {$ext="_g"; }	        
	    //     unset($data['nombre_suc']);
	    //     $data['ext']=$ext;
	 	// 	$table_t=$this->model['informe']->get_reporte_totales($data);	 		 	
	 	// 	$equipos_t = 0;
	 	// 	$pesos_t = 0;
	 	// 	$dolares_t = 0;  		
	 	// 	if(sizeof($table_t) > 0){ 			 	
	 	// 	for ($i=0; $i < sizeof($table_t); $i++) {
	 	// 		if(sizeof($table_t) > 1){ 				
	 	// 			$z=$i+1;
	 	// 			for ($y=$z; $y <= sizeof($table_t); $y++) { 			 	
	 	// 		 		if ((int)$table_t[$i]['id_tecnico'] == (int)$table_t[$y]['id_tecnico']) {  						 					
		//  					$table_t[$i]['total_equipos'] += (int) $table_t[$y]['total_equipos']; //concatena y suma  la fila actual y la siguiente
		//  					$table_t[$i]['total_pesos'] += (floatval ($table_t[$y]['total_pesos']));
		//  					$table_t[$i]['total_dolares'] += (floatval ($table_t[$y]['total_dolares']));
		//  					unset($table_t[$y]);
	 	// 				} 		  				
	 	// 			}	 				
	 	// 			$table_t=array_values($table_t);
	 	// 		}			  			 			
		// 		 }  	
				 				
	 	// 	} 	 		
	 	// 	//var_dump($table_t);  		 	
	 	// 	// for ($i=0; $i < sizeof($table_t) ; $i++) { 
	 	// 	// 	$equipos_t = $equipos_t + (int) $table_t[$i]['total_equipos']; // sumar el total de equipos de todos los tecnicos
	 	// 	// 	$pesos_t = $pesos_t + (floatval($table_t[$i]['total_pesos'])) ; 
	 	// 	// 	$dolares_t = $dolares_t + (floatval($table_t[$i]['total_dolares'])) ;
	 	// 	//  	$array_Ttec[$i]=$table_t[$i]['tecnico'];
	 	// 	//  	$array_Teq[$i]=$table_t[$i]['total_equipos'];
	 	// 	//  	$array_Tps[$i]=$table_t[$i]['total_pesos'];
	 	// 	//  	$array_Tdl[$i]=$table_t[$i]['total_dolares'];
	 	// 	// }  
	 	// 	if (sizeof($table_t)>1) {
	 	// 		array_push($table_t,['id_tecnico'=>'','tecnico'=>'Total','total_equipos'=>$equipos_t,'total_pesos'=>$pesos_t,'total_dolares'=>$dolares_t]);
	 	// 	}	 			 		
	 	// }
		 
		// $data['tecnico']= $this->model['usuario']->find_by(['roles_id'=>'10003', 'plantas_id'=>Session::get('plantas_id')]);

		$data['tipocalibracion']=$this->model['tipocalibracion']->all();	
		$data['sucursal']=$this->model['sucursal']->find_by();
		$_SESSION['menu'] = 'reportes';
      	$_SESSION['submenu'] = $this->name.'_index';			     	
 		include view($this->name.'.read');
	}

	public function ajax_index(){
		$sucursal= array('nogales'=>'_n','hermosillo'=>'_h','guaymas'=>'_g');

		$data = array(
			"daterange" =>$_POST[0],
			"ext" =>  $sucursal[strtolower($_POST[1])],
			"tipo_calibracion" =>$_POST[2],
			"proceso" => $_POST[3]			
			);				
		
		$cadena= explode(' - ', $data['daterange']);				
		unset($data['daterange']);
		$data['fecha_home']=$cadena[0];
		$data['fecha_end']=$cadena[1];									
						
		echo json_encode($this->model['informe']->get_reporte_bitacora($data));
	}

	public function tecnico(){
		$_SESSION['menu'] = 'reportes';
      	$_SESSION['submenu'] = $this->name.'_tecnico';
		$arreglo = (isset($_GET['p'])) ? json_encode($this->url_get($_GET['p'])) : "";		

		include view($this->name.'.tecnico');
	}

	public function productividad(){
		/* Lectura de los datos del formulario */
		// $sucursal= array('nogales'=>'_n','hermosillo'=>'_h','guaymas'=>'_g');

		if(isset($_POST['submit'])){
			if ($_POST['tipo_busqueda']== 1) {
				$_POST['cliente_id']=0;
			}			
			$data = array(
				"daterange" =>$_POST['daterange'],
				"nombre_suc" =>$_POST['nombre_suc'],
				"cliente_id" => (int) $_POST['cliente_id'],
				"tipo_busqueda" =>(int) $_POST['tipo_busqueda']
			);

			$cadena= explode(' - ', $data['daterange']);
			$fecha=$data['daterange'];

			unset($data['daterange']);
			$data['fecha_home']=$cadena[0];
			$data['fecha_end']=$cadena[1];	
			
			
			$table_data=$this->model['informe']->get_productividad($data);
						
			$table_totales=$this->model['informe']->get_totalprocesos($data);									

			if ($data['tipo_busqueda']== 0) {
				$empresa= $this->model['planta']->find_by(['id'=>$data['cliente_id']],'view_plantas');                 
            	$cliente = (trim(strtolower($empresa[0]['nombre']))=='planta1') ?  $empresa[0]['empresa']: $empresa[0]['empresa'].' ('.$empresa[0]['nombre'].')';
			}
			
			//$table_totales=$this->model['informe']->get_productividad_total($data);
			// var_dump($table_totales);
			// exit;	
		}

 		/* Arreglos default para el formulario */
		$_data['planta']= $this->model['planta']->find_by([],'view_plantas');
		 if (strtolower(Session::get('sucursal'))=="nogales") {
			$_data['sucursal']=$this->model['sucursal']->find_by();
		}
		else{
			$_data['sucursal']=$this->model['sucursal']->find_by(['nombre'=>Session::get('sucursal')]);	 
		}	
		$_SESSION['menu'] = 'reportes';
		$_SESSION['submenu'] = $this->name.'_productividad';
		  
	
		include view($this->name.'.productividad');
	}

	public function ajax_load_tecnicos() {
        $sucursal = $_POST['sucursal'];
		$data = json_encode($data['tecnico']= $this->model['usuario']->find_by(['roles_id'=>'10003', 'sucursal'=> strtolower($sucursal)],'view_usuarios')); 
        echo $data;
    }

	public function cliente(){
 		$data['planta']= $this->model['planta']->find_by([],'view_plantas');

		 if (strtolower(Session::get('sucursal'))=="nogales") {
			$data['sucursal']=$this->model['sucursal']->find_by();
		}
		else{
			$data['sucursal']=$this->model['sucursal']->find_by(['nombre'=>Session::get('sucursal')]);	 
		}				
		$_SESSION['menu'] = 'reportes';
      	$_SESSION['submenu'] = $this->name.'_cliente';
		include view($this->name.'.cliente');
	}

	public function ajax_load_clientes() {
		$data = array(
				"daterange" =>$_POST['daterange'],
				"nombre_suc" =>$_POST['nombre_suc'],
				"cliente_id" => (int) $_POST['cliente_id'],
				"tipo_busqueda" =>(int) $_POST['tipo_busqueda']
				);	

        $cadena= explode(' - ', $data['daterange']);				
		unset($data['daterange']);
		$data['fecha_home']=$cadena[0];
		$data['fecha_end']=$cadena[1];
		$ext="";				
		$sucursal= strtolower($data['nombre_suc']);

    	if ($sucursal== 'nogales') {$ext="_n"; }
        else if($sucursal== 'hermosillo') {$ext="_h"; }
        else if($sucursal== 'guaymas') {$ext="_g"; }	        
        unset($data['nombre_suc']);
		$data['ext']=$ext;
					
		if ($data['tipo_busqueda']==1) {
			$hoy= date('Y-m-d');
			$_fhome= date('Y-m-d',strtotime($data['fecha_home']));
			$_fend= date('Y-m-d',strtotime($data['fecha_end']));
				if ($_fhome >= $hoy and $_fend > $hoy) {				
					$table_rc=$this->model['informe']->get_reporte_clientes($data);		
				}
				else{
					$table_rc=false;
				}
			}
		else{
			$table_rc=$this->model['informe']->get_reporte_clientes($data);	
		}
		
		echo json_encode($table_rc);								

    }  

	public function get_url($data){
		$array = array(
			$data['ext'],			
			$data['calibraciones_id'],
			$data['fecha_home'],
			$data['fecha_end']			
			);
 		$tmp = serialize($array);
        $tmp = urlencode($tmp);
        return $tmp;
	}

	public function url_get($url_array){
		$tmp = stripslashes($url_array);
		$tmp = urldecode($tmp);
		$tmp = unserialize($tmp);
		return $tmp;
	}

	public function ajax_puente(){
		$id= $_POST['var1'];
		$url_array= $_POST['var2'];
		$array = $this->url_get($url_array);
		$array[4]= (int)$id;
		$tmp = serialize($array);
        $tmp = urlencode($tmp);		
		echo  $tmp;
	}

	public function total_product(){
		$meses=array('enero' => '01','febrero' =>'02','marzo'=>'03','abril'=>'04','mayo'=>'05','junio'=>'06','julio'=>'07','agosto'=>'08','septiembre'=>'09','octubre'=>'10','noviembre'=>'11','diciembre'=>'12');
		$sucursal=array('nogales' =>'_n','hermosillo' =>'_h','guaymas' =>'_g' );	

	  	if ($_GET['var0']=="compara") {
	  		$arreglo = json_encode(array(
	  		$_GET['var0'],			
			$_GET['var1'],
			$meses[$_GET['var2']],
			$sucursal[$_GET['var3']],
			$_GET['var4']			
			));	
	  	}
	  	else{
	  		$arreglo = json_encode(array(
	  		$_GET['var0'],			
			$_GET['var1'], //fecha home
			$_GET['var2'], //fecha end
			$sucursal[$_GET['var3']],
			$_GET['var4']			
			));	

	  	}			
		include view($this->name.'.total_product');
	}

	public function pulso(){	
		Session::logged(['roles_id'=>'10000']);
        $suc = array("n","h","g");    
        for($i=0; $i<3; $i++)
        {
            $query="SELECT count(id) as count FROM informes_".$suc[$i]." where proceso=1 union all select count(id) FROM informes_".$suc[$i]." where proceso=2 union all select count(id) FROM informes_".$suc[$i]." where proceso=3;";           
            $data['result'][$i] = $this->model['informe']->get_query_informe($query);
       }
       $_SESSION['menu'] = 'pulso';
       $_SESSION['submenu'] = 'pulso';
	   include view($this->name.'.pulso');
	}

    public function edit_sucursal() {
        $sucursal= $_POST['var1'];
        $plantas_id="";
        if ( $sucursal== 'nogales') {$plantas_id="758"; }
        else if($sucursal== 'hermosillo') {$plantas_id="757"; }
        else if($sucursal== 'guaymas') {$plantas_id="2341"; }

        if(!isset($_COOKIE['session'])) {           
            $_COOKIE['session']['sucursal'] = $sucursal;
            $_COOKIE['session']['plantas_id'] = $plantas_id;
        }
        $_SESSION['session']['sucursal'] = $sucursal;
        $_SESSION['session']['plantas_id'] = $plantas_id;
        
        //echo json_encode($_SESSION['session']);         
    }

    public function prueba(){		
       $_SESSION['menu'] = 'pulso';
       $_SESSION['submenu'] = 'pulso';
	   include view($this->name.'.prueba');
	}

	public function tecnico_cal(){
		$_SESSION['menu'] = 'reportes';
      	$_SESSION['submenu'] = $this->name.'_tecnico_cal';		
		$data['tipocalibraciones']= $this->model['tipocalibracion']->all();
		include view($this->name.'.tecnico_cal');
	}
	 
	// Nuevos Reportes , proceso de actualizacion
	public function ajax_tecnico_cal(){
		$sucursal= array('nogales'=>'_n','hermosillo'=>'_h','guaymas'=>'_g');

		$data = array(
			"daterange" =>$_POST[0],
			"ext" =>  $sucursal[strtolower($_POST[1])],
			"tipo_calibracion" =>$_POST[2],
			"tecnico" => $_POST[3]			
			);				
		
		$cadena= explode(' - ', $data['daterange']);				
		unset($data['daterange']);
		$data['fecha_home']=$cadena[0];
		$data['fecha_end']=$cadena[1];									
						
		echo json_encode($this->model['informe']->get_reporte_tecnico_cal($data));
	}

	public function resultados_calibracion(){
		$_SESSION['menu'] = 'reportes';
		$_SESSION['submenu'] = $this->name.'_tecnico_cal';		
		
		$sucursal= array('nogales'=>'_n','hermosillo'=>'_h','guaymas'=>'_g');		

		$date= explode(' - ', $_GET['var0']);		
		
		// 2019-12-16 - 2020-01-14 | todos | tecnico@mypsa.com.mx

		$arreglo = json_encode(array(
			$sucursal[strtolower($_GET['var1'])], // Sucursal
			$date[0], // dateHome
			$date[1],	// dateEnd		
			array($_GET['var2']), //TipoCalibracion
			$_GET['var3'] //tecnicoEmail
		));

		include view($this->name.'.resultados_calibracion');
	}

	public function cliente_cal(){
		$_SESSION['menu'] = 'reportes';
      	$_SESSION['submenu'] = $this->name.'_cliente_cal';
		$sucursal = Session::get('sucursal'); //Sucursal			
		$data['planta']= $this->model['planta']->find_by(['sucursal'=> strtolower($sucursal)],'view_plantas');
		$data['tipocalibraciones']= $this->model['tipocalibracion']->all();

		include view($this->name.'.cliente_cal');
	}
	
	public function ajax_cliente_cal(){
		$sucursal= array('nogales'=>'_n','hermosillo'=>'_h','guaymas'=>'_g');

		$data = array(
			"daterange" =>$_POST[0],
			"ext" =>  $sucursal[strtolower($_POST[1])],
			"tipo_calibracion" =>$_POST[2],
			"proceso" =>$_POST[3],
			"planta" => $_POST[4]			
		);				
		
		$cadena= explode(' - ', $data['daterange']);				
		unset($data['daterange']);
		$data['fecha_home']=$cadena[0];
		$data['fecha_end']=$cadena[1];				

		echo json_encode($this->model['informe']->get_reporte_cliente_cal($data));
	}

 
		
}
