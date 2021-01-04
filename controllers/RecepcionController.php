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
      $this->roles_id= substr(Session::get('roles_id'),-1,1);     
	}

	public function index (){
   // var_dump(Session::get("roles_id")); //Sucursal
    // Rol de ventas : 10001
    //?c=recepcion&a=index&p=2  
    if (isset($_GET['p'])) {
      $id=$_GET['p'];
      $view_informes="view_informes". $this->ext;      
       $data['get']=$this->model['informes']->get_recepcion($id, $view_informes);       
      $data['planta']= $this->model['planta']->find_by(['empresas_id'=>$data['get'][0]['empresas_id']]);      

      $data['plataselect']= $this->model['planta']->find_by(['id' => $data['get'][0]['plantas_id']], "view_plantas");
      //var_dump($data['get']);  
      //exit;               
    }
    else{ 
      
    $data ['get']=array(array(
      'id' => '', 'idequipo' => '', 'alias' => '', 'empresas_id' => '', 'plantas_id' => '', 'periodo_calibracion' => '', 'acreditaciones_id' => '',
      'usuarios_calibracion_id' => '', 'calibraciones_id' => '', 'prioridad' => '', 'comentarios' => '', 'po_id' => '', 'cantidad' => '',
      'hojas_entrada_id' => '', 'usuarios_id' => '', 'fecha' => '', 'proceso' => '0', 'periodo_id' => '1', 'reqautorizacion' => '0',
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
    //$this->download_excel();
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
    
    $post = $_POST['data'];
    $data= json_decode($post, true);     
  
      // if($_FILES['csvfile']['name'] != ''){    
      //   $ext = strtolower(end(explode('.', $_FILES['csvfile']['name'])));
      //   $type = $_FILES['csvfile']['type'];
      //   $ruta = $_FILES['csvfile']['tmp_name']; 
      //   // check the file is a csv
      //     if($ext === 'csv'){          
      //       $data= $this->readCSV($ruta);
      //     }                                
      // }
          
        $cliente_temp=['empresa'=>"",'planta'=>""];
        $usuario_temp=['email'=>""];      
        $planta_temp=0;
        $tecnico_temp= 0;
        $fechaent_temp="";
        $fechaentrada="";
        $fechacal_temp="";        
        $fechacal="";
        
          foreach($data as $clave => $value){
          
            if(!empty($data[$clave][14])){              
              if($fechaent_temp === trim($data[$clave][14])){
                  $data[$clave][14] = $fechaentrada;
              }else{
                $fechaentrada = date('Y-m-d', strtotime(trim($data[$clave][14])));
                $data[$clave][14]= $fechaentrada;
              }            
            }
            if(!empty($data[$clave][17])){              
              if($fechacal_temp === trim($data[$clave][17])){
                  $data[$clave][17] = $fechacal;
              }else{
                $fechacal = date('Y-m-d', strtotime(trim($data[$clave][17])));
                $data[$clave][17]= $fechacal;
              }            
            }
                                           
            if(!empty($data[$clave][1])){
              $equipo= ['alias'=>trim($data[$clave][1]),'descripcion'=>trim($data[$clave][2]),'marca'=>trim($data[$clave][3]),'modelo'=>trim($data[$clave][4]),'serie'=>trim($data[$clave][5])];
              $query1= "SELECT id FROM mypsa_bitacoramyp.view_equipos where alias LIKE '{$equipo['alias']}' and descripcion LIKE '{$equipo['descripcion']}' and marca LIKE '{$equipo['marca']}' and modelo LIKE '{$equipo['modelo']}' and serie LIKE '{$equipo['serie']}';";              
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
                $cliente=['empresa'=>trim($data[$clave][6]),'planta'=>trim($data[$clave][7])];             
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
              $tecnico= trim($data[$clave][15]);
              $usuario=['email'=>$tecnico];
    
              if(($usuario_temp['email'] == $usuario['email'])){
                $data[$clave][21]=$tecnico_temp;
              }
              else{            
                $query3="SELECT id FROM mypsa_bitacoramyp.view_usuarios where email='{$usuario['email']}';";                
                $data3=$this->model['usuario']->get_query($query3);
                if(sizeof($data3)>0){
                  $usuario_temp['email']=$usuario['email'];
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

      echo json_encode($data);      
  }

  public function ajax_storevolcsv(){
    $post = $_POST['data'];
    $decoded= json_decode($post, true);         
    $hojaaux_temp=['id'=>"",'numero_hoja'=>"",'nombre'=>"",'fecha'=>""];

    $acreditacion_temp=null;     
    $calibracion_temp=null;

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
        'fecha_vencimiento'=>null,
        'po_id'=>null,
        'acreditaciones_id'=>null,
        'calibraciones_id'=>null,
        'hojas_entrada_aux_id'=>null,
      ];                   
    
      /* ------------------Acreditacion-------------------- */
      if(!empty($decoded[$clave][10])){
        $acreditacion=trim($decoded[$clave][10]);
        if(($acreditacion_temp == $acreditacion)){
          $data[$clave]['acreditaciones_id']=$acreditacion_temp;
        }
        else{                                          
          $data1=$this->model['acreditacion']->find_by(['nombre'=> $acreditacion]);          
          if(sizeof($data1)>0){            
            $acreditacion_temp= intval($data1[0]['id']);
            $data[$clave]['acreditaciones_id']=$acreditacion_temp;
          }else{
            $data[$clave]['acreditaciones_id']==null;
          }          
        }          
      }else{
        $data[$clave]['acreditaciones_id']=null;
      }      
    /* ---------------Tipo Calibraciones---------------------- */
      if(!empty($decoded[$clave][11])){
        $tipocalibracion=trim($decoded[$clave][11]);
        if(($calibracion_temp == $tipocalibracion)){
          $data[$clave]['calibraciones_id']=$calibracion_temp;
        }
        else{                       
          $data1=$this->model['tipocalibracion']->find_by(['nombre'=> $tipocalibracion]);          
          if(sizeof($data1)>0){       
            $calibracion_temp=intval($data1[0]['id']);
            $data[$clave]['calibraciones_id']=$calibracion_temp;
          }else{
            $data[$clave]['calibraciones_id']=null;
          }          
        }          
      }else{
        $data[$clave]['calibraciones_id']=null;
      }      
    /* ------------------------------------------------ */
      /* Agregar PO , funcion store_po */    
        $po_id = $decoded[$clave][8];        
        $cantidad = $decoded[$clave][9]; 
        $data[$clave]['po_id']= $this->store_po($po_id,$cantidad);
      /* ------------------------------------------------ */
        /* Agregar/Actualizar -- Hoja de entrada */        
        $hoja_ent=['numero_hoja'=>trim($decoded[$clave][12]),'nombre'=>trim($decoded[$clave][13]),'fecha'=>trim($decoded[$clave][14])];               
        /* Agregar Hoja de entrada , funcion store_hoja_entrada */
        $hojaentrada_sucursal="view_hojas_entrada_aux".$this->ext;      
        if($hojaaux_temp['numero_hoja']==$hoja_ent['numero_hoja'] && $hojaaux_temp['nombre']==$hoja_ent['nombre'] && $hojaaux_temp['fecha']==$hoja_ent['fecha']){
          $data[$clave]['hojas_entrada_aux_id']=$hojaaux_temp['id'];
        }
        else{
          $tecnicodata=$this->model['usuario']->find_by(['email'=> $decoded[$clave][13]]);        
          if(sizeof($tecnicodata)>0){          
            $tecnicoid=intval($tecnicodata[0]['id']);
            $id_hoja= $this->store_hoja_entrada($hoja_ent['numero_hoja'],$tecnicoid,$hoja_ent['fecha'],$hojaentrada_sucursal);                  
            if(sizeof($id_hoja)>0){            
              $hojaaux_temp=[
                'id'=>$id_hoja,
                'numero_hoja'=>$hoja_ent['numero_hoja'],
                'nombre'=>$hoja_ent['nombre'],
                'fecha'=>$hoja_ent['fecha']
              ];
              $data[$clave]['hojas_entrada_aux_id']=$id_hoja;
            }
            else{
              $data[$clave]['hojas_entrada_aux_id']=null;
            }
          }else{
            $data[$clave]['hojas_entrada_aux_id']=null;
          }
        }
      /* --------------------------------------------- */
        if(strtolower($decoded[$clave][18])=="inicio" || strtolower($decoded[$clave][18])=="calibracion"){
          $data[$clave]['proceso']=2;
        }
      /* --------------------------------------------- */
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
          $return="Error al actualizar Informe ".$data[$i];
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
            //$csv[$key] = str_getcsv($value);             
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
            $data['calibrado']=0;
           $data['proceso'] = intval('1');
        }


      //$retorno = $this->model['informes']->validar_fecha($data['id'],$data['fecha'],$proceso_temp,$this->name,$view);

        ////var_dump($retorno);

        // if ($retorno) {
        //   # code...
        //   $hoy = date("Y-m-d H:i:s");
        //   $data['fecha_inicio'] = $hoy;
                             
        //   /* Agregar PO , funcion store_po */
        //   $po_id = $data['po_id']; unset($data['po_id']);        
        //   $cantidad = $data['cantidad']; unset($data['cantidad']);        
        //   $data['po_id']= $this->store_po($po_id,$cantidad);
        //   /* renombrando las variables para insertar la hoja de entrada */                
        //   $hojaentrada_sucursal="view_hojas_entrada_aux".$this->ext;         
        //   $hojas_entrada_id = $data['hojas_entrada_id']; unset($data['hojas_entrada_id']);//
        //   $usuarios_id = $data['usuarios_id']; unset($data['usuarios_id']); // 
        //   $fecha = $data['fecha']; unset($data['fecha']);//  
        //   /* Agregar Hoja de entrada , funcion store_hoja_entrada */
        //   $data['hojas_entrada_aux_id']= $this->store_hoja_entrada($hojas_entrada_id,$usuarios_id,$fecha,$hojaentrada_sucursal);

        //     /* Comparar si si agrego bien el PO y la hoja de entrada */                                  
        //   if (strlen($data['hojas_entrada_aux_id'])> 0 && strlen($data['po_id'])>0) {
        //     //si se agrego correctamente hoja de entrada y PO entonces se hara update sobre la tabla informes de los datos pendientes.
        //     $planta= $this->model['planta']->find_by(['id'=>$data['plantas_id']],'view_plantas');
        //     $nombreplanta= strtolower(str_replace(' ','',$planta[0]['nombre']));
        //     $cliente= ($nombreplanta=="planta1") ? $planta[0]['empresa']:$planta[0]['empresa'].', '.$planta[0]['nombre'];
        //     if ($this->model['informes']->update($data))  {
        //       // direccionarlo al siguiente proceso 
        //       $roles_id= substr(Session::get('roles_id'),-1,1);                                      
        //       if ($proceso_temp == 0) {
        //         Logs::this("Captura datos de recepción", "Recepción del equipo, cliente : {". $cliente ."} y datos de calibración del informe: ".$data['id']); 
        //       $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);
        //       }
        //       else if($proceso_temp == 1) {
        //         Logs::this("Actualización en recepción", "Actualización en recepción, se encuentra en proceso de recepción. Informe: ".$data['id']);              
        //         $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);
        //       }              
        //       else if($proceso_temp == 2) {
        //         Logs::this("Actualización en recepción", "Actualización en recepción, se encuentra en proceso de salida. Informe: ".$data['id']);  
        //         $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);
        //       }
        //       else if ($proceso_temp == 3) {
        //         Logs::this("Actualización en recepción", "Actualización en recepción, se encuentra en proceso de facturación. Informe:".$data['id']);                
        //         $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);
        //       } 
        //       else if ($proceso_temp == 4) {                
        //         Logs::this("Actualización en recepción", "Actualización en recepción, ya se encontraba el informe terminado. Informe:".$data['id']); 
        //         $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);
        //       } 
        //       else{
        //         redirect('?c=informes&a=proceso');
        //       }
        //     }
        //     else {               
        //        Flash::error(setError('002'));
        //     }  
        //   }
        //   else{
        //     Flash::error(setError('002'));           
        //   }           
        // }
        // else{
        //     if ($proceso_temp = 2) {
        //       Flash::error(setError('011'));
        //     }
        //     else if($proceso_temp > 2){
        //       Flash::error(setError('010'));
        //     }
        // }      
  }

  public function ajax_store() { 
    $validado= true;
    $dictionary = array(      
      'id' => '000',
      'title' => 'Exitoso',    
    );        

    $view="view_informes". $this->ext;        
    $return="";

    $tiposubmit= $_POST[14];  
    /** registrar | actualizar |  solicitud | actualizaraut | sinpermiso |  */
    $data = array(
      'id' => (int)$_POST[0],
      'equipos_id' => (int) $_POST[1],
      'plantas_id' => (int) $_POST[2],          
      'periodo_calibracion' => (int) $_POST[3],
      'periodo_id' => (int) $_POST[4],

      'acreditaciones_id' => (int) $_POST[5],
      'usuarios_calibracion_id' => (int)$_POST[6],
      'calibraciones_id' => (int) $_POST[7],
      'po_id' =>$_POST[8],
      'cantidad' =>(int) $_POST[9],
      
      'prioridad' => (int) $_POST[10],

      'hojas_entrada_id' => $_POST[11],
      'usuarios_id' =>(int) $_POST[12],
      'fecha' =>$_POST[13],
      'comentarios' =>$_POST[16],
    );       
       
    $proceso_temp = (int) $_POST[15];

    if($tiposubmit == "registrar" ){
      $validado= true;
    }else if ($tiposubmit == "actualizar" ){
      /** Valida la fecha de la hoja de entrada que no se mayor a la de calibracion o salida  */
      $validar = $this->model['informes']->validar_fecha($data['id'],$data['fecha'],$proceso_temp,$this->name,$view);       
      if(!$validar){
        $validado= false;
        if ($proceso_temp = 2) {
          $return= setError('011');              
        }
        else if($proceso_temp > 2){
          $return=  setError('010');              
        }
      }
    }else if ($tiposubmit == "solicitud" ){
      if($proceso_temp == 0){
        //Cambiar el estado de la autorizacion
        $data['reqautorizacion']=1;      
        $validado= true;
      }else{ // proceso > 0
        /** Validar informe que se esta solcitando que el id del equipo concide con el que se esta actualizando */
        $informeigual = $this->model['informes']->validar_informe_equipo($data['id'],$data['equipos_id'],$view);
        if(!$informeigual){
          $dictionary ['data'] = array(['msg' => 'Este Informe no se puede actualizar, El equipo no coincide con el informe que se autorizo. Si se desea usar una vez más este informe, debe cancelarlo e iniciar su uso.']);
          $return= $dictionary;
          $validado= false;
        } 
      }      
    }else if ($tiposubmit == "actualizaraut"){
      /** Validar informe autorizado que el id del equipo concide con el que se esta actualizando */
      $informeigual = $this->model['informes']->validar_informe_equipo($data['id'],$data['equipos_id'],$view);
      if(!$informeigual){
        $dictionary ['data'] = array(['msg' => 'Este Informe no se puede actualizar, el equipo no coincide con el informe autorizado. Si se desea usar una vez más este informe, debe cancelarlo e iniciar su uso.' ]);
        $return= $dictionary;
        $validado= false;
      }else{        
        /** Valida la fecha de la hoja de entrada que no se mayor a la de calibracion o salida  */
        $validar = $this->model['informes']->validar_fecha($data['id'],$data['fecha'],$proceso_temp,$this->name,$view);
        if(!$validar){
          $validado= false;
          if ($proceso_temp = 2) {
            $return= setError('011');              
          }
          else if($proceso_temp > 2){
            $return=  setError('010');           
          }
        }
      }                
    }else if ($tiposubmit == "sinpermiso"){

      if($this->roles_id == 0 || $this->roles_id== 2 || $this->roles_id==4 || $this->roles_id==7){        
        /** Validar informe autorizado que el id del equipo concide con el que se esta actualizando */
        $informeigual = $this->model['informes']->validar_informe_equipo($data['id'],$data['equipos_id'],$view);
        if(!$informeigual){
          $dictionary ['data'] = array(['msg' => 'Este Informe no se puede actualizar, El equipo no coincide con el informe a autorizar. Cancelar o confirmar autorización desde el listado.' ]);
          $return= $dictionary;
          $validado= false;
        }else{
          //Cambiar el estado de la autorizacion 
          $data['reqautorizacion']=2;
        }
      }else{
        $dictionary ['data'] = array(['msg' => 'Este Informe no se puede actualizar, esta en espera de autorización. Solicite cancelar o confirmar autorización.' ]);
        $return= $dictionary;
        $validado= false;
      }        
    }             

    if ($validado) {
      # code...
      //$hoy = date("Y-m-d H:i:s");
      //$data['fecha_inicio'] = $hoy;

      if ($proceso_temp === 0) {
        $data['calibrado']=0;
        $data['proceso'] = intval('1');
      }
                          
      /* Agregar PO , funcion store_po */
      $po_id = $data['po_id']; unset($data['po_id']);        
      $cantidad = $data['cantidad']; unset($data['cantidad']);        
      $data['po_id'] = $this->store_po($po_id,$cantidad);

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

          $arrayequipo=  $this->model['equipo']->find_by(['id'=>$data['equipos_id']],'view_equipos');

          $logtitle= array(
            'registrar' => "Registro de datos en recepción",
            'actualizar'=> "Actualización de datos en recepción",
            'solicitud'=> "Solicitud de registro con equipo duplicado",
            'actualizaraut'=> "Actualización de registro con equipo duplicado",
            'sinpermiso'=> "Actualización  de Equipo sin permiso"
          );

          $logdetails= array(
            'registrar' => "Captura de información en el Informe: {$data['id']}. Se asignó el cliente: {$cliente}, con la fecha de entrada: {$fecha}",
            'actualizar'=> "Actualización del Informe: {$data['id']}. Cliente: {$cliente} asignado, con la fecha de entrada {$fecha} estando en el proceso: {$proceso_temp} ",
            'solicitud'=> "Solicitud de registro de un equipo duplicado para el informe: {$data['id']}. Datos del equipo [{$arrayequipo[0]['alias']},{$arrayequipo[0]['descripcion']},{$arrayequipo[0]['marca']},{$arrayequipo[0]['modelo']},{$arrayequipo[0]['serie']}]. Cliente : {$cliente}",
            'actualizaraut'=> "Aprobación de registro de un equipo duplicado para el informe: {$data['id']}. Datos del equipo [{$arrayequipo[0]['alias']},{$arrayequipo[0]['descripcion']},{$arrayequipo[0]['marca']},{$arrayequipo[0]['modelo']},{$arrayequipo[0]['serie']}]. Cliente : {$cliente}",
            'sinpermiso'=> "Actualización de registro sin previa autorización de un equipo duplicado para el informe: {$data['id']}. Datos del equipo [{$arrayequipo[0]['alias']},{$arrayequipo[0]['descripcion']},{$arrayequipo[0]['marca']},{$arrayequipo[0]['modelo']},{$arrayequipo[0]['serie']}]. Cliente : {$cliente}"
          );
          
          Logs::this($logtitle[$tiposubmit], $logdetails[$tiposubmit]);                 

          if ($proceso_temp == 0) {            
            $dictionary ['data'] = array(['msg' => $this->model['informes']->_redirecajax($roles_id, $proceso_temp,$data['id']) ]);
            $return= $dictionary;
          }
          else if($proceso_temp == 1) {
            //Logs::this("Actualización en recepción", "Actualización en recepción, se encuentra en proceso de recepción. Informe: ".$data['id']);                
            $dictionary ['data'] = array(['msg' => $this->model['informes']->_redirecajax($roles_id, $proceso_temp,$data['id']) ]);
            $return= $dictionary;
          }              
          else if($proceso_temp == 2) {
            //Logs::this("Actualización en recepción", "Actualización en recepción, se encuentra en proceso de salida. Informe: ".$data['id']);  
            $dictionary ['data'] = array(['msg' => $this->model['informes']->_redirecajax($roles_id, $proceso_temp,$data['id']) ]);
            $return= $dictionary;
          }
          else if ($proceso_temp == 3) {
            //Logs::this("Actualización en recepción", "Actualización en recepción, se encuentra en proceso de facturación. Informe:".$data['id']);                
            $dictionary ['data'] = array(['msg' => $this->model['informes']->_redirecajax($roles_id, $proceso_temp,$data['id']) ]);
            $return= $dictionary;
          } 
          else if ($proceso_temp == 4) {                
            //Logs::this("Actualización en recepción", "Actualización en recepción, ya se encontraba el informe terminado. Informe:".$data['id']); 
            $dictionary ['data'] = array(['msg' => $this->model['informes']->_redirecajax($roles_id, $proceso_temp,$data['id']) ]);
            $return= $dictionary;
          } 
          else{ 
            $dictionary['data'] = array(['msg' => '?c=informes&a=proceso']); 
            $return= $dictionary;              
          }
        }
        else {               
          $return= setError('002');              
        }  
      }
      else{
        $return= setError('002');           
      }           
    }           

    echo json_encode($return);
        
  }

  public function storevol() {
    $view="view_informes". $this->ext;    
    $data = validate($_POST, [
        'informeadd' => 'required|toInt',            
        'plantas_id' => 'required|toInt',                
    ]);
    
    $proceso_temp = $data['proceso'];                
    
    //   # code...
    //Pendiente-- Julio-03-2020 --- Corregir el parametro fecha, desde la base de datos que se generare la fecha con la funcion CURRENT_TIMESTAMP
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
          $ultimo= $i +1;
          if($iteraciones == $ultimo){
            $roles_id= substr(Session::get('roles_id'),-1,1);                                      
            if ($proceso_temp == 0) {              
              Logs::this("Captura datos de recepción por volumen", "Recepción del equipo, cliente : {". $cliente ."}. Total de informes : ". $iteraciones);          
              $this->download_excel($view,$data['plantas_id'],$iteraciones);
              //include view($this->name.'.registrovol');
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
    $query= "SELECT id as informe,alias as clave,descripcion,marca,modelo,serie,empresa,planta,po_id,cantidad,acreditacion,calibracion,numero_hoja_entrada as hoja_entrada,registradopor_email,fecha_hoja_entrada,tecnico_cal_email,vigencia,fecha_calibracion,nombre_proceso as proceso FROM ". $view ." WHERE plantas_id=". $plantaid ." ORDER BY id DESC LIMIT ". $limit .";";        
    $data = $this->model['informes']->get_query_informe($query); 

    $filename="formato.csv";
    header('Content-Encoding: UTF-8');   
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename='.$filename);
    header("Pragma: public");
    header("Expires: 0"); 
    $mostrarcol=false;
    $titulos = array("Informe","Clave","Descripcion","Marca","Modelo","Serie","Empresa","Planta","PO","Cantidad","Acreditacion","Tipo Calibracion","Hoja Entrada","Realizado por","Fecha Hoja.Ent.","Calibrado por","Vigencia","F. Calibracion (m/dd/yyyy)","Proceso actual");
    $df = fopen( 'php://output', 'w' );
    //This line is important:
    fputs( $df, "\xEF\xBB\xBF" ); //UTF-8

    foreach ($data as $row ) {
      if(!$mostrarcol){
        fputcsv( $df, $titulos);
        //fputcsv($df, array_keys($row));
        $mostrarcol= true;
      }
        fputcsv( $df, array_values($row));
    }
    fclose($df);    
    exit;        
  }

  public function store_po($po_id,$cantidad){
    $_po="";
    //existe p.o
     if ($this->model['po']->find_by(['id' => $po_id])) {
       //si existe - update                 
        if($this->model['po']->update(['id'=> $po_id ,'cantidad'=>$cantidad])) {                
            $_po=$po_id;
            Logs::this("Editar", "Se actualizo el PO ".$_po." , ".$cantidad);                          
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
                Logs::this("Agregar", "Se agrego la hoja de entrada en tabla hojaentradaauxiliar. Num de hoja: {$id_hoja_aux} con la fecha: {$fecha} y el usuario id: {$usuarios_id}");                    
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
                Logs::this("Agregar", "Se agrego la hoja de entrada en tabla hojaentradaauxiliar. Num de hoja: {$id_hoja_aux} con la fecha: {$fecha} y el usuario id: {$usuarios_id}");
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
      $data = json_encode($data['planta'] = $this->model['planta']->find_by(['empresas_id' => $idempresa]));
      echo $data;
  } 

  public function ajax_load_cliente() {
    $id = $_POST['idplanta'];
    $view="view_plantas";
    $data = json_encode($data['planta'] = $this->model['planta']->find_by(['id' => $id], $view));
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
  
  public function ajax_load_ultimoid_equipo(){
    $idequipo = $_POST['idequipo'];
    $view_informes="view_informes". $this->ext;
    $query="SELECT * FROM ".$view_informes." where idequipo=".$idequipo." order by id desc limit 1;";                         
    $data=json_encode($this->model['informes']->get_query_informe($query));    
    echo $data;
  }

  public function ajax_load_usuario_confirmar(){   
    $usuario=Session::get('id');
    $query="SELECT accesoconfirmar FROM usuarios where id=". $usuario .";";                             
    $data=json_encode($this->model['usuario']->get_query($query));    
    echo $data;    
  }

  // Funcion en reparacion
  public function storevol_enreparacion() {
    $view="view_informes". $this->ext;    
    $data = validate($_POST, [
        'informeadd' => 'required|toInt',            
        'plantas_id' => 'required|toInt',                
    ]);
    
    $proceso_temp = $data['proceso'];                
    
    //   # code...
    //Pendiente-- Julio-03-2020 --- Corregir el parametro fecha, desde la base de datos que se generare la fecha con la funcion CURRENT_TIMESTAMP
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
          $ultimo= $i +1;
          if($iteraciones == $ultimo){
            $roles_id= substr(Session::get('roles_id'),-1,1);                                      
            if ($proceso_temp == 0) {              
              Logs::this("Captura datos de recepción por volumen", "Recepción del equipo, cliente : {". $cliente ."}. Total de informes : ". $iteraciones);          
              $this->download_excel($view,$data['plantas_id'],$iteraciones);
              //include view($this->name.'.registrovol');
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


 
 }
