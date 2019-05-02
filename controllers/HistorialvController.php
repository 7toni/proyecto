<?php
Session::logged();
$_SESSION['script']= NULL;

class HistorialvController{

    public function __construct(){        
        $this->name ="historialv";
        $this->title = "Historial Verificación";
        $this->subtitle = "Panel Control de verificaciones";
        $this->model=[
            'historialv'=> new Historialv(),
            'control_calidad' => new ControlCalidad(),
            'equipo'=> new Equipo(),
            'usuario'=> new Usuario(),
            'sucursal'=> new Sucursal(),
        ];
        $this->ext=$this->model['sucursal']->extension();

        $_SESSION['menu'] = 'control_calidad';
        $_SESSION['submenu'] = $this->name;                
    }

    public function index(){        
        include view($this->name.'.read');
    }
    
    public function add(){
        if(isset($_GET['p'])){
            $id=$_GET['p'];
            $data['equipo'] = $this->model['equipo']->find_by(['id' => $id],'view_equipos');   
        }         
        $data['usuarios']=$this->model['usuario']->find_by(['plantas_id'=>Session::get('plantas_id'),'activo'=>'si'],'view_usuarios');        
        include view($this->name.'.add');
    }

    public function edit($id){
        $data['get']= $this->model['historialv']->find($id);        
        if(exists($data['get'])){
            $data['usuarios']=$this->model['usuario']->find_by(['plantas_id'=>Session::get('plantas_id'),'activo'=>'si'],'view_usuarios');
            $data['equipo'] = $this->model['equipo']->find_by(['id' => $data['get'][0]['equipos_id']],'view_equipos');
            include view($this->name.'.edit');
        }        
    }

    public function delete($id){
        $data['get']= $this->model['historialv']->find($id);
        if(exists($data['get'])){
            $data['equipo'] = $this->model['equipo']->find_by(['id' => $data['get'][0]['equipos_id']],'view_equipos');
            $data['usuarios']=$this->model['usuario']->find_by(['id'=> $data['get'][0]['responsable']],'view_usuarios');
            include view($this->name.'.delete');
        }
      
    }

    public function store(){
        $data= validate($_POST,[
            'equipos_id'=> 'required|toInt',
            'fecha'=> 'fecha',            
            'comentario'=> 'comentario',
            'responsable'=> 'required|toInt',                     
        ]);
      
        if($this->model['control_calidad']->find_by(['equipos_id' => $data['equipos_id']])){
            /* Preguntamos si existe ese registro con el mismo equipo, fecha y responsable, si existe muestra una alerta  */
            if($this->model['historialv']->find_by(['equipos_id' => $data['equipos_id'],'fecha'=> $data['fecha'],'responsable'=>$data['responsable']])){
                Flash::error(setError('015'));
            }
            else{
                if($this->model['historialv']->store($data)){
                    $historial=$this->model['historialv']->find_by(['equipos_id' => $data['equipos_id'],'fecha'=> $data['fecha'],'responsable'=>$data['responsable']]);
                    $control_calidad=$this->model['control_calidad']->find_by(['equipos_id' => $data['equipos_id']]);
    
                    $data_controlc['id']= $control_calidad[0]['id'];
                    $data_controlc['historialv_id']= $historial[0]['id'];
                    $data_controlc['proxv']= $this->prox_verificacion($data);
                                                      
                    if($this->model['control_calidad']->update($data_controlc)){
                        redirect('?c=' . $this->name);
                    }
                    else{
                        Flash::error(setError('002'));
                    }               
                }
                else{
                    Flash::error(setError('002'));
                } 
            }                          
        }
        else{                      
            $_SESSION["error"] = ["data" => $errors, "id" => "001", "title" => "Alerta!", "data"=> array(["msg" => "Ha ocurrido un problema con la validación de los datos. El equipo no se encuentra en el Control de Calidad. "])];
            header('Location: ' . $_SERVER['HTTP_REFERER']);            
        }                        
    }

    public function update(){
        $tabla= $this->name.$this->ext;
        $data= validate($_POST,[
            'id' => 'required|toInt|exists:'. $tabla .'',
            'equipos_id'=> 'required|toInt',
            'fecha'=> 'fecha',            
            'comentario'=> 'comentario',
            'responsable'=> 'required|toInt',                     
        ]);

        if(isset($_POST['actualizarv'])){           
            unset($data['actualizarv']);
        }       
                      
        if($this->model['control_calidad']->find_by(['equipos_id' => $data['equipos_id']])){
            /* Preguntamos si existe ese registro con el mismo equipo, fecha y responsable, si existe muestra una alerta  */
            if($this->model['historialv']->find_by(['equipos_id' => $data['equipos_id'],'fecha'=> $data['fecha'],'responsable'=>$data['responsable'],'comentario'=>$data['comentario']])){
                Flash::error(setError('015'));
            }
            else{
                if($this->model['historialv']->update($data)){
                    if(isset($_POST['actualizarv'])){
                        $historial=$this->model['historialv']->find_by(['equipos_id' => $data['equipos_id'],'fecha'=> $data['fecha'],'responsable'=>$data['responsable'],'comentario'=>$data['comentario']]);
                        $control_calidad=$this->model['control_calidad']->find_by(['equipos_id' => $data['equipos_id']]);
        
                        $data_controlc['id']= $control_calidad[0]['id'];
                        $data_controlc['historialv_id']= $historial[0]['id'];
                        $data_controlc['proxv']= $this->prox_verificacion($data);
                                        
                        if($this->model['control_calidad']->update($data_controlc)){
                            redirect('?c=' . $this->name);
                        }
                        else{
                            Flash::error(setError('002'));
                        }  

                    }else{
                        redirect('?c=' . $this->name);
                    }
                                 
                }
                else{
                    Flash::error(setError('002'));
                } 
            }                          
        }
        else{                      
            $_SESSION["error"] = ["data" => $errors, "id" => "001", "title" => "Alerta!", "data"=> array(["msg" => "Ha ocurrido un problema con la validación de los datos. El equipo no se encuentra en el Control de Calidad. "])];
            header('Location: ' . $_SERVER['HTTP_REFERER']);            
        }          
    }

    public function destroy(){
        $tabla= $this->name.$this->ext;
        $data = validate($_POST, [
            'id' => 'required|toInt|exists:'. $tabla .'', 
        ]);        
        if($this->model['historialv']->destroy($data)){
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        } 
    }  
       
    private function prox_verificacion($data){

        $fecha= $data['fecha'];
        $view_controlc=$this->model['control_calidad']->find_by(['equipos_id' => $data['equipos_id']],'view_control_calidad'.$this->ext);
        $vigencia=intval($view_controlc[0]['vigencia']);

        if($vigencia <= 12){
            $data = date('Y-m-d', strtotime($fecha . "+6 month"));
            //$data['contadorv']= ($periodocal/6)-1;
        }
        else{
            $data = date('Y-m-d', strtotime($fecha . "+12 month"));
            //$data['contadorv']= ($periodocal/6);
        }        
        return $data;
    }


}