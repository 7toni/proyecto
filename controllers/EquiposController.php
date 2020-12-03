<?php

Session::logged();

class EquiposController {

    public function __construct() {
        $this->name = "equipos";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'equipo' => new Equipo(),
            'equipos_descripciones' => new EquipoDescripcion(),
            'equipos_marcas' => new EquipoMarca(),
            'equipos_modelos' => new EquipoModelo(),
            'sucursal' => new Sucursal(),
        ];
        $_SESSION['script'] = $this->name;
    }

    public function index() {
        $_SESSION['menu'] = 'equipos';
        $_SESSION['submenu'] = $this->name;
        include view($this->name . '.read');
    }

    public function add() {        
        $data['sucursal'] = $this->model['sucursal']->all();
        include view($this->name . '.add');
    }

    public function volumen() {        
        $data['sucursal'] = $this->model['sucursal']->all();
        include view($this->name . '.volumen');
    }

    public function edit($id) {
        $data['equipo'] = $this->model['equipo']->find($id);
        //var_dump($data['equipo']);
        if (exists($data['equipo'])) {
            $data['equipos_descripciones'] = $this->model['equipos_descripciones']->all();
            $data['equipos_marcas'] = $this->model['equipos_marcas']->all();
            $data['equipos_modelos'] = $this->model['equipos_modelos']->all();
            $data['sucursal'] = $this->model['sucursal']->all();
            include view($this->name . '.edit');
        }
    }

    public function delete($id) {
        $data['equipo'] = $this->model['equipo']->find($id);
        if (exists($data['equipo'])) {
            $data['equipos_descripciones'] = $this->model['equipos_descripciones']->all();
            $data['equipos_marcas'] = $this->model['equipos_marcas']->all();
            $data['equipos_modelos'] = $this->model['equipos_modelos']->all();
            $data['sucursal'] = $this->model['sucursal']->all();
            include view($this->name . '.delete');
        }
    }

    public function store() {
        $data = validate($_POST, [
            'alias' => 'required|trim|strtoupper',
            'serie' => 'required|trim',
            'descripciones_id' => 'required|number',
            'marcas_id' => 'required|number',
            'modelos_id' => 'required|number',
        ]);
        
        $data['continental_id'] = 1;
        $data['activo'] = 1;
        if ($this->model['equipo']->store($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function update() {
        $data = validate($_POST, [
            'id' => 'required',
            'alias' => 'required|trim|strtoupper',
            'serie' => 'required|trim',
            'descripciones_id' => 'required|number',
            'marcas_id' => 'required|number',
            'modelos_id' => 'required|number',
        ]);
        $data['activo']= intval(isset($_POST['activo']) ? "1":"0");       
        if ($this->model['equipo']->update($data)) {
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|number|exists:equipos',
        ]);
        if ($this->model['equipo']->destroy($data)) {
            Logs::this('Elimino','Se elimino el equipo '. $data['id']);
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    } 

    public function autorizacion(){
		$usuario =Session::get('id');		
		$rol =substr(Session::get('roles_id'),-2); // solo se abstrae el ultimo numero del rol todos empiesan con 100 00		
		$_SESSION['menu'] = 'equipos';
      	$_SESSION['submenu'] = 'autorizacion';
		include view($this->name.'.autorizacion');
    }
    
    
    public function ajax_load_validacionserie() {
        $serie=$_POST['serie'];
        $dato= $this->model['equipo']->find_by(['serie' => $serie],"view_equipos");                
        echo json_encode($dato);
    }

    public function download_excel(){                 
        $titulos = array("Id","Descripción","Marca","Modelo","Serie");
        echo json_encode($titulos);
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

    public function ajax_comprobardatos(){
        $post = $_POST['data'];
        $data= json_decode($post, true);
        $desc_temp="";
        $marca_temp="";
        $modelo_temp="";
        $iddesc_temp="";
        $idmarca_temp="";
        $idmodelo_temp="";
        
        foreach($data as $clave => $value){
            $query= "SELECT id FROM mypsa_bitacoramyp.view_equipos where alias LIKE '{$value[0]}' and descripcion LIKE '{$value[1]}' and marca LIKE '{$value[2]}' and modelo LIKE '{$value[3]}' and serie LIKE '{$value[4]}';";            
            //array_push($query1,$query);              
            $data1=$this->model['equipo']->get_query($query);
            if(sizeof($data1)>0){
                $data[$clave][5]='1';  // indica que este equipo esta registrado
                $data[$clave][6]='-1'; // ignoramos serie
                $data[$clave][7]='-1'; // ignoramos descripcion
                $data[$clave][8]='-1'; // ignoramos marca
                $data[$clave][9]='-1'; // ignoramos modelo               
            }else{
                $data[$clave][5]='0'; // Equipo No registrado

                if(trim(strtolower($value[4])) != "n/a" || trim(strtolower($value[4])) != "sin serie"){
                    $serie= "SELECT serie FROM mypsa_bitacoramyp.view_equipos where alias LIKE '{$value[0]}' and serie LIKE '{$value[4]}';";
                    if(sizeof($this->model['equipo']->get_query($serie))>0){
                        $data[$clave][6]='1';   //indica que la serie esta registrada con el mismo id de equipo
                    }
                    else{
                        $data[$clave][6]='0'; //indica que la serie no esta registra
                    }
                }else{
                    $data[$clave][6]='-1'; //indica que la serie no tiene problemas
                }

                if($desc_temp=="" || $desc_temp != trim(strtolower($value[1]))){                   
                    $iddesc= "SELECT id FROM mypsa_bitacoramyp.view_equipos_descripciones where nombre LIKE '{$value[1]}';";
                    $resultdesc= $this->model['equipos_descripciones']->get_query($iddesc);
                    if(sizeof($resultdesc)>0){
                        $data[$clave][7]=$resultdesc[0]['id'];
                        $desc_temp=trim(strtolower($value[1]));
                        $iddesc_temp=$resultdesc[0]['id'];                        
                    }else{
                        $data[$clave][7]='0'; // No existe la descripcion
                    }
                }else{
                   $data[$clave][7]=$iddesc_temp;
                }
                                            
                if($marca_temp=="" || $marca_temp != trim(strtolower($value[2]))){                    
                    $idmarca= "SELECT id FROM mypsa_bitacoramyp.view_equipos_marcas where nombre LIKE '{$value[2]}';";
                    $resultmarca= $this->model['equipos_marcas']->get_query($idmarca);
                    if(sizeof($resultmarca)>0){
                        $data[$clave][8]=$resultmarca[0]['id'];
                        $marca_temp=trim(strtolower($value[2]));
                        $idmarca_temp=$resultmarca[0]['id'];
                    }else{
                        $data[$clave][8]='0'; // No existe la marca
                    }
                }else{
                    $data[$clave][8]=$idmarca_temp;
                }
                
                if($modelo_temp=="" || $modelo_temp != trim(strtolower($value[3]))){
                    $idmodelo= "SELECT id FROM mypsa_bitacoramyp.view_equipos_modelos where nombre LIKE '{$value[3]}';";
                    $resultmodelo= $this->model['equipos_modelos']->get_query($idmodelo);
                    if(sizeof($resultmodelo)>0){
                        $data[$clave][9]=$resultmodelo[0]['id'];
                        $modelo_temp=trim(strtolower($value[3]));
                        $idmodelo_temp=$resultmodelo[0]['id'];
                    }else{
                        $data[$clave][9]='0'; // No existe el modelo
                    }
                }else{
                    $data[$clave][9]=$idmodelo_temp;
                }

            }
        }                  
        echo json_encode($data);      
    }

    public function ajax_storevolcsv(){
        $post = $_POST['data'];
        $decoded= json_decode($post, true);                 
            
        foreach($decoded as $clave => $value){
    
          $data[$clave]=[
            'id'=> intval($decoded[$clave][0]),
            'descripcion'=>intval($decoded[$clave][19]),
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

}
