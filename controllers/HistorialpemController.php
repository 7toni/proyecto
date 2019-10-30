<?php
Session::logged();
$_SESSION['script']= NULL;

class HistorialpemController{

    public function __construct(){        
        $this->name ="historialpem";
        $this->title = "Historial Mantenimiento";
        $this->subtitle = "Panel Control de mantenimiento";
        $this->model=[
            'historialpem'=> new Historialpem(),
            'control_pruebaelect' => new ControlPruebaelect(),
            'equipo'=> new Equipo(),
            'usuario'=> new Usuario(),
            'sucursal'=> new Sucursal(),
        ];
        $this->ext=$this->model['sucursal']->extension();

        $_SESSION['menu'] = 'control_pruebaelect';
        $_SESSION['submenu'] = $this->name; 
        
        $this->estadom= array("Completo","Pendiente");
        $this->tipomant= array("Preventivo","Correctivo");
    }

    public function index(){        
        include view($this->name.'.read');
    }
    
    public function add(){
        if(isset($_GET['p'])){
            $id=$_GET['p'];
            $data['equipo'] = $this->model['equipo']->find_by(['id' => $id],'view_equipos');   
        }
        $data['responsable']= Session::get('id');       
        $data['usuarios']=$this->model['usuario']->find_by(['plantas_id'=>Session::get('plantas_id'),'activo'=>'si'],'view_usuarios');        
        include view($this->name.'.add');
    }

    public function edit($id){
        $data['get']= $this->model['historialpem']->find($id);        
        if(exists($data['get'])){
            $data['usuarios']=$this->model['usuario']->find_by(['plantas_id'=>Session::get('plantas_id'),'activo'=>'si'],'view_usuarios');
            $data['equipo'] = $this->model['equipo']->find_by(['id' => $data['get'][0]['equipos_id']],'view_equipos');
            include view($this->name.'.edit');
        }        
    }

    public function delete($id){
        $data['get']= $this->model['historialpem']->find($id);
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
        $data['estado']=  $this->estadom[intval($_POST['estado'])];
        $data['tipo']=  $this->tipomant[intval($_POST['tipo'])];
        
        if($this->model['control_pruebaelect']->find_by(['equipos_id' => $data['equipos_id']])){
            /* Preguntamos si existe ese registro con el mismo equipo, fecha y responsable, si existe muestra una alerta  */
            if($this->model['historialpem']->find_by(['equipos_id' => $data['equipos_id'],'fecha'=> $data['fecha'],'responsable'=>$data['responsable']])){
                Flash::error(setError('015'));
            }
            else{
                if($this->model['historialpem']->store($data)){
                    $historial=$this->model['historialpem']->find_by(['equipos_id' => $data['equipos_id'],'fecha'=> $data['fecha'],'responsable'=>$data['responsable']]);
                    $control_calidad=$this->model['control_pruebaelect']->find_by(['equipos_id' => $data['equipos_id']]);
    
                    $data_controlc['id']= $control_calidad[0]['id'];
                    $data_controlc['historialpem_id']= $historial[0]['id'];
                    $data_controlc['proxm']= $this->prox_mantenimiento($data['fecha']);
                                    
                    if($this->model['control_pruebaelect']->update($data_controlc)){
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

        $data['estado']=  $this->estadom[intval($_POST['estado'])];
        $data['tipo']=  $this->tipomant[intval($_POST['tipo'])];

        //unset();
        if(isset($_POST['actualizarm'])){           
            unset($data['actualizarm']);
        }
                               
        if($this->model['control_pruebaelect']->find_by(['equipos_id' => $data['equipos_id']])){
            /* Preguntamos si existe ese registro con el mismo equipo, fecha y responsable, si existe muestra una alerta  */
            if($this->model['historialpem']->find_by(['equipos_id' => $data['equipos_id'],'fecha'=> $data['fecha'],'responsable'=>$data['responsable'],'comentario'=>$data['comentario']])){
                Flash::error(setError('015'));
            }
            else{
                if($this->model['historialpem']->update($data)){
                    if(isset($_POST['actualizarm'])){
                        $historial=$this->model['historialpem']->find_by(['equipos_id' => $data['equipos_id'],'fecha'=> $data['fecha'],'responsable'=>$data['responsable'],'comentario'=>$data['comentario']]);
                        $control_calidad=$this->model['control_pruebaelect']->find_by(['equipos_id' => $data['equipos_id']]);
        
                        $data_controlc['id']= $control_calidad[0]['id'];
                        $data_controlc['historialpem_id']= $historial[0]['id'];
                        $data_controlc['proxm']= $this->prox_mantenimiento($data['fecha']);
                                        
                        if($this->model['control_pruebaelect']->update($data_controlc)){
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
        if($this->model['historialpem']->destroy($data)){
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        } 
    }

    private function prox_mantenimiento($data){

        $fecha= $data;
        //$periodocal=$data['vigencia'];               

        $data= date('Y-m-d', strtotime($fecha . "+6 month"));
        //$data['contadorm']= ($periodocal/6);

        return $data;
    }       
}