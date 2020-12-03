<?php

Session::logged();

class CalibracionController {

	public function __construct() {
  		$this->name= "calibracion";
  		$this->title ="Calibración";
  		$this->subtitle= "Bitácora";
  		$this->model=[
  			'usuario'=> new Usuario(),
        'acreditacion'=> new Acreditacion(),
        'informes'=> new Informes(),
        'sucursal' => new Sucursal(),
        'periodo' => new Periodo(),
  		];
      $this->ext=$this->model['sucursal']->extension();    
      $this->sucursal= strtoupper(Session::get('sucursal')); 

      $_SESSION['script'] = '';
  	}

  	public function index (){   
      if (isset($_GET['p'])) {
        $id=$_GET['p'];
        $view_informes="view_informes". $this->ext;       
        $data['get']=$this->model['informes']->get_calibracion($id, $view_informes);
        $data['equipo'] = $this->model['informes']->datos_equipo($id);                

        $data['cliente'] = $this->model['informes']->datos_cliente($id);
                
       if ($data['get'][0]['proceso']> 0) {
        $data['tecnico']= $this->model['usuario']->find_by(['activo'=>'1']);
        $data['acreditacion']=$this->model['acreditacion']->find_by(['activo'=>'1']); 
        $data['periodo']=$this->model['periodo']->find_by();                      
        include view($this->name.'.read');
        }
        else{ redirect('?c=informes&a=proceso');}
    }
    else{   
       redirect('?c=informes&a=proceso');
  	}
  }

  public function store (){

      $view="view_informes". $this->ext;
              
      $data = validate($_POST, [
        'id' => 'toInt',
        'proceso' => 'toInt',
        'usuarios_calibracion_id' => 'required|toInt',
        'usuarios_informe_id' => 'required|toInt',
        'fecha_calibracion' => 'required',
        'fecha_vencimiento' => 'required',
        'acreditaciones_id' => 'required|toInt',             
        'periodo_calibracion' => 'required|toInt',
        'periodo_id'=>'toInt',
        'comentarios' => 'ucname',              
      ]);

      $data['calibrado'] = isset($_POST['calibrado']) === true ? $_POST['calibrado'] : intval('1');
            
      $proceso_temp = $data['proceso']; 

      if ($data['proceso'] === 1) {
        $data['proceso'] = intval('2');
      }   

        $retorno = $this->model['informes']->validar_fecha($data['id'],$data['fecha_calibracion'],$proceso_temp,$this->name,$view);

        if ($retorno) {
          if ($this->model['informes']->find_by(['id' => $data['id']])){
              if ($this->model['informes']->update($data))  {
              // direccionarlo al siguiente proceso 
                $roles_id= substr(Session::get('roles_id'),-1,1);                     
               if ($proceso_temp === 1) {
                Logs::this("Captura en calibración", "Se capturo los datos de calibración el informe ".$data['id']);
                $this->model['informes']->_redirec($roles_id, $data['proceso'],$data['id']);
                }
                else if ($proceso_temp === 2) {
                  Logs::this("Actualización en calibración", "Actualización de información, se encuentra en proceso de Calibración. El informe ".$data['id']);
                  $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);               
                }
                else if ($proceso_temp === 3) {
                  Logs::this("Actualización en calibración", "Actualización de información, se encuentra en proceso de facturación. El informe ".$data['id']);
                  $this->model['informes']->_redirec($roles_id, $proceso_temp,$data['id']);              
                }
                else if ($proceso_temp === 4) {
                  Logs::this("Actualización en calibración", "Actualización en información, ya se encontraba el informe terminado. ".$data['id']);
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
        }
        else{
            if ($proceso_temp = 1) {
              Flash::error(setError('012'));
            }
            else{
              Flash::error(setError('014'));
            }
        }
         
  }
}