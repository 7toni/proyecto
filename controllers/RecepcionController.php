<?php

  Session::logged();

  class RecepcionController {
  	
	public function __construct() {
  		$this->name= "recepcion";
  		$this->title ="Recepción";
  		$this->subtitle= "Bitácora";      
  		$this->model=[  
        'empresa'=> new Empresa(),
        'planta' => new Planta(),        
        'usuario'=> new Usuario(),
        'acreditacion'=> new Acreditacion(),
        'tipocalibracion'=> new Tipocalibracion(),
        'po'=> new PO(),
        'hojaentradaaux'=> new HojaEntradaAux(),
        'hojaentrada'=> new HojaEntrada(),
        'informes'=> new Informes(),
        'equipo'=> new Equipo(),
  		 'sucursal' => new Sucursal(),
       'periodo' => new Periodo(),
      ];
      $this->ext=$this->model['sucursal']->extension(); 
      $this->sucursal= strtoupper(Session::get('sucursal'));
      $_SESSION['script'] = 'recepcion';
            
	}

	public function index (){
    //var_dump(Session::get('id')); //id usuario
    //?c=recepcion&a=index&p=2  
    if (isset($_GET['p'])) {
      $id=$_GET['p'];
      $view_informes="view_informes". $this->ext;      
       $data['get']=$this->model['informes']->get_recepcion($id, $view_informes);       
      $data['planta']= $this->model['planta']->find_by(['empresas_id'=>$data['get'][0]['empresas_id']]);
      //var_dump($data['get']);  
      //exit;        
    }
    else{   
    $data ['get']=array(array(
      'id' => '', 'idequipo' => '', 'alias' => '', 'empresas_id' => '', 'plantas_id' => '', 'periodo_calibracion' => '', 'acreditaciones_id' => '',
      'usuarios_calibracion_id' => '', 'calibraciones_id' => '', 'prioridad' => '', 'comentarios' => '', 'po_id' => '', 'cantidad' => '',
      'hojas_entrada_id' => '', 'usuarios_id' => '', 'fecha' => '', 'proceso' => '',
      )); 
      //usuarios predefinidos para la hoja de entrada dependiendo la sucursal      
    }
    //var_dump(Session::get());  
    $sucursal=strtolower(Session::get('sucursal'));

      $data['empresa']=$this->model['empresa']->all();        
      //se hara la modificación para hermosillo y para guaymas que todos los tecnicos puedan estar en hoja de entrada
      $data['tecnico']= $this->model['usuario']->find_by(['activo'=>'1','plantas_id'=>Session::get('plantas_id')]);       
      //var_dump($data['tecnico']);
      if($sucursal != 'nogales'){        
        $data['registradopor']= $this->model['usuario']->find_by(['plantas_id'=>Session::get('plantas_id')]);
      }
      else{        
        $data['registradopor']= $this->model['usuario']->find_by(['roles_id'=>'10006','plantas_id'=>Session::get('plantas_id')]);
      }
         
      //asignar en la hoja de entrada un usuario regitrado por, cuando es para registro, pondra al usuario que usa la cuenta, o si no se encuentra en la lista habra que eliegir una opcion.
      if (!isset($_GET['p'])) {
       $data['get'][0]['usuarios_id']= Session::get('id');      
      }

      $data['acreditacion']=$this->model['acreditacion']->find_by(['activo'=>'1']);

      $data['tipocalibracion']=$this->model['tipocalibracion']->all();
      $data['periodo']=$this->model['periodo']->find_by();
      $_SESSION['menu'] = 'bitacora';
      $_SESSION['submenu'] = 'recepcion';      
      
  	include view($this->name.'.read');
  }
  
  public function registrovol (){
    $_SESSION['menu'] = 'bitacora';
    $_SESSION['submenu'] = 'recepcionvol';               
      $sucursal=strtolower(Session::get('sucursal'));

      $data['empresa']=$this->model['empresa']->all();        
      //se hara la modificación para hermosillo y para guaymas que todos los tecnicos puedan estar en hoja de entrada
      $data['tecnico']= $this->model['usuario']->find_by(['activo'=>'1','plantas_id'=>Session::get('plantas_id')]);       
      //var_dump($data['tecnico']);
      if($sucursal != 'nogales'){        
        $data['registradopor']= $this->model['usuario']->find_by(['plantas_id'=>Session::get('plantas_id')]);
      }
      else{        
        $data['registradopor']= $this->model['usuario']->find_by(['roles_id'=>'10006','plantas_id'=>Session::get('plantas_id')]);
      }               

      $data['acreditacion']=$this->model['acreditacion']->find_by(['activo'=>'1']);

      $data['tipocalibracion']=$this->model['tipocalibracion']->all();
      $data['periodo']=$this->model['periodo']->find_by();                           
      
  	include view($this->name.'.registrovol');
	}

	public function volumen() {
    $_SESSION['menu'] = 'bitacora';
    $_SESSION['submenu'] = 'actualizarvol';    
    include view($this->name.'.volumen');
	}

  public function ajax_cargarcsv(){
    if($_FILES['csvfile']['name'] != ''){    
    $ext = strtolower(end(explode('.', $_FILES['csvfile']['name'])));
    $type = $_FILES['csvfile']['type'];
    $ruta = $_FILES['csvfile']['tmp_name'];   
    // check the file is a csv
      if($ext === 'csv'){              
        $data= $this->readCSV($ruta);
      }                                
    }           
    echo json_encode($data);
  }

  public function ajax_comprobardatos(){
  
    if($_FILES['csvfile']['name'] != ''){    
      $ext = strtolower(end(explode('.', $_FILES['csvfile']['name'])));
      $type = $_FILES['csvfile']['type'];
      $ruta = $_FILES['csvfile']['tmp_name'];   
      // check the file is a csv
        if($ext === 'csv'){              
          $data= $this->readCSV($ruta);
        }                                
      }
        
      $cliente_temp=['empresa'=>"",'planta'=>""];
      $usuario_temp=['nombre'=>"",'apellido'=>""];    
      $planta_temp=0;
      $tecnico_temp= 0;
      
      foreach($data as $clave => $value){  
               
        if(!empty($data[$clave][1])){
          $equipo= ['alias'=>$data[$clave][1],'descripcion'=>$data[$clave][3],'marca'=>$data[$clave][4],'modelo'=>$data[$clave][5],'serie'=>$data[$clave][2]];
          $query1= "SELECT id FROM mypsa_bitacoramyp.view_equipos where alias='{$equipo['alias']}' and descripcion='{$equipo['descripcion']}' and marca='{$equipo['marca']}' and modelo='{$equipo['modelo']}' and serie='{$equipo['serie']}';";
          //echo $query1;
          $data1=$this->model['equipo']->get_query($query1);          
          if(sizeof($data1)>0){
            $data[$clave][19]=$data1[0]['id'];            
          }
          else{
            $data[$clave][19]=0;
          }   
        } else{
          $data[$clave][19]=0;
        }             

        if(!empty($data[$clave][6])){
          
            $cliente=['empresa'=>$data[$clave][6],'planta'=>$data[$clave][7]];
         
            if(($cliente_temp['empresa'] == $cliente['empresa']) && ($cliente_temp['planta'] == $cliente['planta']))
            {
              $data[$clave][20]=$planta_temp;
            }
            else{
              $cliente_temp['empresa']=$data[$clave][6];
              $cliente_temp['planta']=$data[$clave][7];
              $query2="SELECT id FROM mypsa_bitacoramyp.view_plantas where empresa='{$cliente['empresa']}' and nombre='{$cliente['planta']}';";        
              $data2=$this->model['planta']->get_query($query2);
              if(sizeof($data2)>0){            
                $planta_temp=$data2[0]['id'];            
              }
              else{
                $planta_temp=0;
              }
              $data[$clave][20]=$planta_temp;
            }                                        
        }
        else{
          $data[$clave][20]=0;
        } 

        if(!empty($data[$clave][15])){
          $tecnico= explode(' ',$data[$clave][15]);
          $usuario=['nombre'=>$tecnico[0],'apellido'=>$tecnico[1]];

          if(($usuario_temp['nombre'] == $usuario['nombre']) && ($usuario_temp['apellido'] == $usuario['apellido'])){
            $data[$clave][21]=$tecnico_temp;
          }
          else{
            $usuario_temp['nombre']=$tecnico[0];
            $usuario_temp['apellido']=$tecnico[1];
            $query3="SELECT id FROM mypsa_bitacoramyp.view_usuarios where nombre='{$usuario['nombre']}' and apellido='{$usuario['apellido']}';";
            $data3=$this->model['usuario']->get_query($query3);
            if(sizeof($data3)>0){
              $tecnico_temp=$data3[0]['id'];
            }else{
              $tecnico_temp=0;
            }
            $data[$clave][21]=$tecnico_temp;
          }
          
        }else{
          $data[$clave][21]=0;
        }
        
      }

      //$data= procesar_csv($data);

      echo json_encode($data);

  }

  public function ajax_storevolCSV(){
    $post = $_POST['data'];

    $decoded= json_decode($post, true);    
    
    foreach($decoded as $clave => $value){

      $data[$clave]=[
        'id'=> intval($decoded[$clave][0]),
        'equipos_id'=>intval($decoded[$clave][19]),
        'plantas_id'=>intval($decoded[$clave][20]),
        'usuarios_calibracion_id'=>intval($decoded[$clave][21]),
        'usuarios_informe_id'=>intval($decoded[$clave][21]),        
        'periodo_id'=>null,
        'periodo_calibracion'=>null,
        'calibrado'=>null,
        'fecha_calibracion'=>null,
        'fecha_vencimiento'=>null        
        ];

      if(strtolower($decoded[$clave][18])=="inicio" || strtolower($decoded[$clave][18])=="calibracion"){
        $data[$clave]['proceso']=2;
      }

      // Datos del proceso de calibracion
      $fechacal= $decoded[$clave][17];
      $vigencia= explode(' ',$decoded[$clave][16]);
      $periodocal=intval($vigencia[0]);
      $periodo_id=strtolower($vigencia[1]);
      $dia_mes="";
      if ($periodo_id=="mes(s)") {
        $data[$clave]['periodo_id']=1;
        $dia_mes="month";
      }
      else if ($periodo_id=="día(s)"){
        $data[$clave]['periodo_id']=2;
        $dia_mes="days";
      } 
      if($periodocal>0){
        $data[$clave]['calibrado']=1;
      }
      else{
        $data[$clave]['calibrado']=0;
      } 
      $data[$clave]['periodo_calibracion']=$periodocal;
      $data[$clave]['fecha_calibracion']= date('Y-m-d', strtotime($fechacal));
      $data[$clave]['fecha_vencimiento'] = date('Y-m-d', strtotime($fechacal . "+".$periodocal." ".$dia_mes));  
      // <-- Fin -->      
    }    
    //var_dump(sizeof($data));   
        
    for ($i=0; $i < sizeof($data); $i++) {
        $planta= $this->model['planta']->find_by(['id'=>$data[$i]['plantas_id']],'view_plantas');
        $nombreplanta= strtolower(str_replace(' ','',$planta[0]['nombre']));
        $cliente= ($nombreplanta=="planta1") ? $planta[0]['empresa']:$planta[0]['empresa'].', '.$planta[0]['nombre'];
        if ($this->model['informes']->update($data[$i])){
          Logs::this("Actualización de informes por CSV", " cliente : {". $cliente ."} y datos de calibración del informe: ".$data[$i]['id']); 
          $return=true;
        }else{
          $return=false;
          break;
        }    
    }    

    echo json_encode($return);    
  }

  public function readCSV($ruta){ 
        $lines = file($ruta, FILE_IGNORE_NEW_LINES); 
        $data = array();                     
         foreach ($lines as $key => $value)
        {                  
             $csv[$key] = str_getcsv(utf8_encode($value));             
             if($key>0)
             {              
             array_push($data,$csv[$key]);
             }                         
        }         
        return $data;
  }

 //Update la bitacora 

  public function store() {
    //existe esta variables auxiliar que es un radio y esta en la tabla de historial, pero tomo el valor del número de informe del campo informe, entonces cuando hay datos en la tabla y tambien en el campo informe, no me sirve el id_aux.
    $view="view_informes". $this->ext;
    if (isset($_POST['id_aux'])) {unset($_POST['id_aux']);}
        $data = validate($_POST, [
            'id' => 'required|toInt',
            'equipos_id' => 'required|toInt',
            'plantas_id' => 'required|toInt',          
            'periodo_calibracion' => 'required|toInt',
            'acreditaciones_id' => 'required|toInt',
            'usuarios_calibracion_id' => 'required|toInt',
            'calibraciones_id' => 'required|toInt',
            'po_id' =>'required|trimlower',
            'cantidad' =>'required|toInt',

            'hojas_entrada_id' =>'required',
            'usuarios_id' =>'required|toInt',
            'fecha' =>'fecha',

            'prioridad' => 'required|toInt',                          
            'comentarios' => 'trimlower',
            'proceso' => 'toInt',
            'periodo_id' => 'toInt',            
        ]);
        $proceso_temp = $data['proceso'];

        if ($data['proceso'] === 0) {
          $data['proceso'] = intval('1');
        }

      $retorno = $this->model['informes']->validar_fecha($data['id'],$data['fecha'],$proceso_temp,$this->name,$view);

        //var_dump($retorno);

        if ($retorno) {
          # code...
          $hoy = date("Y-m-d H:i:s");
          $data['fecha_inicio'] = $hoy;
                             
          /* Agregar PO , funcion store_po */
          $po_id = $data['po_id']; unset($data['po_id']);        
          $cantidad = $data['cantidad']; unset($data['cantidad']);        
          $data['po_id']= $this->store_po($po_id,$cantidad);
          /* renombrando las variables para insertar la hoja de entrada */                
          $hojaentrada_sucursal="view_hojas_entrada_aux".$this->ext;         
          $hojas_entrada_id = $data['hojas_entrada_id']; unset($data['hojas_entrada_id']);//
          $usuarios_id = $data['usuarios_id']; unset($data['usuarios_id']); // 
          $fecha = $data['fecha']; unset($data['fecha']);//  
          /* Agregar Hoja de entrada , funcion store_hoja_entrada */
          $data['hojas_entrada_aux_id']= $this->store_hoja_entrada($hojas_entrada_id,$usuarios_id,$fecha,$hojaentrada_sucursal);

            /* Comparar si si agrego bien el PO y la hoja de entrada */                                  
          if (strlen($data['hojas_entrada_aux_id'])> 0 && strlen($data['po_id'])>0) {
            //si se agrego correctamente hoja de entrada y PO entonces se hara update sobre la tabla informes de los datos pendientes.
            $planta= $this->model['planta']->find_by(['id'=>$data['plantas_id']],'view_plantas');
            $nombreplanta= strtolower(str_replace(' ','',$planta[0]['nombre']));
            $cliente= ($nombreplanta=="planta1") ? $planta[0]['empresa']:$planta[0]['empresa'].', '.$planta[0]['nombre'];
            if ($this->model['informes']->update($data))  {
              // direccionarlo al siguiente proceso 
              $roles_id= substr(Session::get('roles_id'),-1,1);                                      
              if ($proceso_temp == 0) {
                Logs::this("Captura datos de recepción", "Recepción del equipo, cliente : {". $cliente ."} y datos de calibración del informe: ".$data['id']); 
              $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);
              }
              else if($proceso_temp == 1) {
                Logs::this("Actualización en recepción", "Actualización en recepción, se encuentra en proceso de recepción. Informe: ".$data['id']);              
                $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);
              }              
              else if($proceso_temp == 2) {
                Logs::this("Actualización en recepción", "Actualización en recepción, se encuentra en proceso de salida. Informe: ".$data['id']);  
                $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);
              }
              else if ($proceso_temp == 3) {
                Logs::this("Actualización en recepción", "Actualización en recepción, se encuentra en proceso de facturación. Informe:".$data['id']);                
                $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);
              } 
              else if ($proceso_temp == 4) {                
                Logs::this("Actualización en recepción", "Actualización en recepción, ya se encontraba el informe terminado. Informe:".$data['id']); 
                $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);
              } 
              else{
                redirect('?c=informes&a=proceso');
              }
            }
            else {               
               Flash::error(setError('002'));
            }  
          }
          else{
            Flash::error(setError('002'));           
          }           
        }
        else{
            if ($proceso_temp = 2) {
              Flash::error(setError('011'));
            }
            else if($proceso_temp > 2){
              Flash::error(setError('010'));
            }
        }      
  }

  public function storevol() {
    $view="view_informes". $this->ext;    
    $data = validate($_POST, [
        'informeadd' => 'required|toInt',            
        'plantas_id' => 'required|toInt',                
    ]);
    
    $proceso_temp = $data['proceso'];                
    
    //   # code...
    $hoy = date("Y-m-d H:i:s");
    $data['fecha_inicio'] = $hoy;
    
    $iteraciones= $data['informeadd']; unset($data['informeadd']);     
    //   /* Agregar PO , funcion store_po */    
      $po_id = $data['po_id']; unset($data['po_id']);        
      $cantidad = $data['cantidad']; unset($data['cantidad']);        
      $data['po_id']= $this->store_po($po_id,$cantidad);
    //   /* renombrando las variables para insertar la hoja de entrada */
      $hojaentrada_sucursal="view_hojas_entrada_aux".$this->ext;         
      $hojas_entrada_id = $data['hojas_entrada_id']; unset($data['hojas_entrada_id']);//
      $usuarios_id = $data['usuarios_id']; unset($data['usuarios_id']); // 
      $fecha = $data['fecha']; unset($data['fecha']);//        
    //   /* Agregar Hoja de entrada , funcion store_hoja_entrada */
      $data['hojas_entrada_aux_id']= $this->store_hoja_entrada($hojas_entrada_id,$usuarios_id,$fecha,$hojaentrada_sucursal);

    //     /* Comparar si si agrego bien el PO y la hoja de entrada */
    if (strlen($data['hojas_entrada_aux_id'])> 0 && strlen($data['po_id'])>0) {
      //si se agrego correctamente hoja de entrada y PO entonces se hara update sobre la tabla informes de los datos pendientes.
      $planta= $this->model['planta']->find_by(['id'=>$data['plantas_id']],'view_plantas');
      $nombreplanta= strtolower(str_replace(' ','',$planta[0]['nombre']));
      $cliente= ($nombreplanta=="planta1") ? $planta[0]['empresa']:$planta[0]['empresa'].', '.$planta[0]['nombre'];
      for ($i=0; $i < $iteraciones; $i++) { 
        # code...
        if ($this->model['informes']->store($data))  {          
          // direccionarlo al siguiente proceso 
          if($iteraciones == ($i+1)){
            $roles_id= substr(Session::get('roles_id'),-1,1);                                      
            if ($proceso_temp == 0) {
              
              Logs::this("Captura datos de recepción por volumen", "Recepción del equipo, cliente : {". $cliente ."}. Total de informes : ". $iteraciones);          
              $this->download_excel($view,$data['plantas_id'],$iteraciones);
              include view($this->name.'.registrovol');
            }
            else {               
              Flash::error(setError('002'));
            } 
          }                
        }
      }          
    }
    else{
      Flash::error(setError('002'));           
    } 

  }

  public function download_excel($view,$plantaid,$limit){
    $query= "SELECT id as informe,alias as clave,descripcion,marca,modelo,serie,empresa,planta,po_id,cantidad,acreditacion,calibracion,numero_hoja_entrada as hoja_entrada,usuarios_hoja_entrada,fecha_hoja_entrada,calibrado_por,vigencia,fecha_calibracion,nombre_proceso as proceso FROM ". $view ." WHERE plantas_id=". $plantaid ." ORDER BY id DESC LIMIT ". $limit .";";
        
    $data = $this->model['informes']->get_query_informe($query); 

    $filename="formato.csv";
    header('Content-Encoding: UTF-8');              
    header('Content-Type: text/csv; charset=utf-8' );
    header('Content-Disposition: attachment; filename='.$filename);
    header("Pragma: public");
    header("Expires: 0");     
    $mostrarcol=false;
    $df = fopen( 'php://output', 'w' );
    //This line is important:
    fputs( $df, "\xEF\xBB\xBF" ); //UTF-8
    foreach ($data as $row ) {

      if(!$mostrarcol){
        fputcsv( $df,array_keys($row));
        $mostrarcol= true;
      }
        fputcsv( $df, array_values($row) );
    }
    fclose($df);
            
  }

  public function store_po($po_id,$cantidad){
    $_po="";
    //existe p.o
     if ($this->model['po']->find_by(['id' => $po_id])) {
       //si existe - update                 
        if($this->model['po']->update(['id'=> $po_id ,'cantidad'=>$cantidad])) {                
            $_po=$po_id;
            Logs::this("Editar", "Se edito el PO".$_po." , ".$cantidad);                          
        } else {              
          Flash::error(setError('002'));
        }
     }         
     //si no ; insert y asignar id de po
     else {
        if ($this->model['po']->store(['id'=> $po_id,'cantidad'=>$cantidad])) {                 
              $_po=$po_id; 
              Logs::this("Agregar", "Se agrego el PO".$_po." , ".$cantidad);
        } else {                  
              Flash::error(setError('002'));
          }
      } 
      return $_po;    
  }

  public function store_hoja_entrada($hojas_entrada_id,$usuarios_id,$fecha,$hojaentrada_sucursal){
      $_hojaent="";
      //existe hoja entrada auxiliar
      $id_hoja_entrada = $this->model['hojaentradaaux']->find_by(['numero_hoja' => $hojas_entrada_id,'usuarios_id'=> $usuarios_id,'fecha'=>$fecha],$hojaentrada_sucursal);
      if (sizeof($id_hoja_entrada)> 0) {              
            $id_hoja_aux= $id_hoja_entrada[0]['id'];
            $_hojaent=$id_hoja_aux;            
            //var_dump($id_hoja_aux);
      }
    // no  existe en la tabla auxiliar
      else { 
        // Pregunta si existe el numero de hoja de entrada, si existe se inserta a la tabla auxiliar, si no se agregara todo desde cero. 
        $id_hoja_entrada =$this->model['hojaentrada']->find_by(['numero' => $hojas_entrada_id]);                              
        if (sizeof($id_hoja_entrada)> 0) {
            //insertar hojaentradaaux y select id hoja entrada aux
            if($this->model['hojaentradaaux']->store(['hojas_entrada_id'=>$id_hoja_entrada[0]['id'], 'usuarios_id' =>$usuarios_id,'fecha'=>$fecha])){
                $id_hoja_entrada_aux = $this->model['hojaentradaaux']->find_by(['numero_hoja' => $hojas_entrada_id,'usuarios_id'=> $usuarios_id,'fecha'=>$fecha],$hojaentrada_sucursal);
                $id_hoja_aux= $id_hoja_entrada_aux[0]['id'];                       
                $_hojaent=$id_hoja_aux;
                Logs::this("Agregar", "Se agrego la hoja de entrada". $id_hoja_aux);                    
            } 
            else {
              Flash::error(setError('002'));
            }
        }
        //No se encontro en la tabla hoja de entrada, se insertara en hoja de entrada y se asignara en la tabla auxiliar.
        else{
          if ($this->model['hojaentrada']->store(['numero'=>$hojas_entrada_id])) {
              $id_hoja_entrada =$this->model['hojaentrada']->find_by(['numero' => $hojas_entrada_id]);

              //insertar hoja_auxiliar y select id hoja entrada aux
              if($this->model['hojaentradaaux']->store(['hojas_entrada_id'=>$id_hoja_entrada[0]['id'], 'usuarios_id' =>$usuarios_id,'fecha'=>$fecha])){
                
                $id_hoja_entrada_aux = $this->model['hojaentradaaux']->find_by(['numero_hoja' => $hojas_entrada_id,'usuarios_id'=> $usuarios_id,'fecha'=>$fecha],$hojaentrada_sucursal);
                $id_hoja_aux= $id_hoja_entrada_aux[0]['id'];                      
                $_hojaent=$id_hoja_aux;
                  Logs::this("Agregar", "Se agrego la hoja de entrada". $id_hoja_aux);
              }
              else {
                Flash::error(setError('002'));
              }
          }            
          else {
            Flash::error(setError('002'));
          }
        }            
      }  
      return intval($_hojaent);
  }

  public function ajax_load_generar_informe() {
      $hoy = date("Y-m-d H:i:s");
       $numero= "";      
      $data=[
        'fecha_inicio'=> $hoy,        
        'proceso'=> '0',
      ];   
      if ($this->model['informes']->store($data)) {        
           $numero =$this->model['informes']->numero_informe();  
          Logs::this("Generar", "Se generó el número de informe: ".json_encode($numero));          
        } else {
           $numero ='Erro BD';
        }
        echo json_encode($numero);
  }

  public function ajax_load_ultimo_informe() {
        echo json_encode($numero=$this->model['informes']->numero_informe());
  }


  public function cookies() {                                                
    echo json_encode(Session::get('planta'));
  }
  
  public function ajax_load_historial() {
      $idequipo = $_POST['idequipo']; 
      $view_informes="view_informes". $this->ext;
      $data = json_encode($data['informes'] = $this->model['informes']->find_by(['alias' => $idequipo],$view_informes));
      echo $data;
    }

  public function ajax_load_equipo() {
      $idequipo = $_POST['idequipo'];                    
       $data = json_encode($data['equipo'] = $this->model['equipo']->find_by(['alias' => $idequipo],'view_equipos'));
      echo $data;
  }

  public function ajax_load_plantas() {
      $idempresa = $_POST['idempresa'];
      $data = json_encode($data['planta'] = $this->model['planta']->find_by([ 'empresas_id' => $idempresa]));
      echo $data;
  }

  public function ajax_load_po() {
      $idpo = $_POST['po_id'];       
      $data = json_encode($data['po'] = $this->model['po']->find_by([ 'id' => $idpo]));
      echo $data;
  }

  public function ajax_load_hoja_entrada() {
      $numero_hoja = $_POST['hojas_entrada_id'];
      $view_hojas_entrada="view_hojas_entrada_aux". $this->ext;         
      $data = json_encode($data['hojaentradaaux'] = $this->model['hojaentradaaux']->find_by(['numero_hoja' => $numero_hoja],$view_hojas_entrada)); 
      echo $data;
  }  
 
 }
