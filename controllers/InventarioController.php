<?php
Session::logged();
$_SESSION['script']=NULL;

class InventarioController{

    public function __construct(){
        $this->name="inventario";
        $this->title="Inventario";
        $this->subtitle="Panel de inventario";
        $this->model=[
            'inventario'=> new Inventario(),
            'control_calidad' => new ControlCalidad(),
            'equipo'=>new Equipo(),
            'sucursal'=>new Sucursal(),
            'control_calidad'=>new ControlCalidad(),
        ];
        $this->ext=$this->model['sucursal']->extension();

        $_SESSION['menu']= 'control_calidad';
        $_SESSION['submenu']= $this->name;
    }

    public function index(){
        include view($this->name.'.read');
    }

    public function add(){
        if(isset($_GET['p'])){
            $id=$_GET['p'];
            $data['equipo'] = $this->model['equipo']->find_by(['id' => $id],'view_equipos');   
        }  
        include view($this->name.'.add');
    }

    public function edit($id){
        $data['get']=$this->model['inventario']->find($id);
        if(exists($data['get'])){
            $data['equipo'] = $this->model['equipo']->find_by(['id' => $data['get'][0]['equipos_id']],'view_equipos');
            include view($this->name. '.edit');
        }
    }

    public function delete($id){
        $data['get']=$this->model['inventario']->find($id);
        if(exists($data['get'])){
            $data['equipo'] = $this->model['equipo']->find_by(['id' => $data['get'][0]['equipos_id']],'view_equipos');
            include view($this->name. '.delete');
        }
    }

    public function store(){
        $data= validate($_POST,[
            'equipos_id'=>'requiere|toInt',
            'procedimiento'=>'requiere',
            'campo_aplicacion'=>'requiere',
            'localizacion'=>'requiere',
            'comentario'=>'comentario',
        ]);

        $data['responsable']= Session::get('email');
        if($this->model['control_calidad']->find_by(['equipos_id' => $data['equipos_id']])){
            if($this->model['inventario']->find_by(['equipos_id'=>$data['equipos_id'],'procedimiento'=>$data['procedimiento'],'campo_aplicacion'=>$data['campo_aplicacion'],'localizacion'=>$data['localizacion'],'comentario'=>$data['comentario']])){
                Flash::error(setError('015'));
            }else{
                if($this->model['inventario']->store($data)){
                    redirect('?c=' . $this->name);
                }else{
                    Flash::error(setError('002'));
                }                
            }                            
        }else{                      
            $_SESSION["error"] = ["data" => $errors, "id" => "001", "title" => "Alerta!", "data"=> array(["msg" => "Ha ocurrido un problema con la validación de los datos. El equipo no se encuentra en el Control de Calidad. "])];
            header('Location: ' . $_SERVER['HTTP_REFERER']);            
        }        

    }

    public function update(){
        $tabla= $this->name.$this->ext;
        $data= validate($_POST,[
            'id'=>'required|toInt|exists:'. $tabla .'',
            'equipos_id'=>'requiere|toInt',
            'procedimiento'=>'requiere',
            'campo_aplicacion'=>'requiere',
            'localizacion'=>'requiere',
            'comentario'=>'comentario',
        ]);

        $data['responsable']= Session::get('email');      

        if($this->model['control_calidad']->find_by(['equipos_id' => $data['equipos_id']])){
            if($this->model['inventario']->find_by(['equipos_id'=>$data['equipos_id'],'procedimiento'=>$data['procedimiento'],'campo_aplicacion'=>$data['campo_aplicacion'],'localizacion'=>$data['localizacion'],'comentario'=>$data['comentario']])){
                Flash::error(setError('015'));
            }else{                
                if($this->model['inventario']->update($data)){
                    redirect('?c=' . $this->name);
                }else{
                    Flash::error(setError('002'));
                }                
            }                            
        }else{                      
            $_SESSION["error"] = ["data" => $errors, "id" => "001", "title" => "Alerta!", "data"=> array(["msg" => "Ha ocurrido un problema con la validación de los datos. El equipo no se encuentra en el Control de Calidad. "])];
            header('Location: ' . $_SERVER['HTTP_REFERER']);            
        } 

    }

    public function destroy(){
        $tabla= $this->name.$this->ext;
        $data = validate($_POST, [
            'id' => 'required|toInt|exists:'. $tabla .'', 
        ]);        
        if($this->model['inventario']->destroy($data)){
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        } 

    }


}
