<?php
Session::logged();
$_SESSION['script']=NULL;

class InventariopeController{

    public function __construct(){
        $this->name="inventariope";
        $this->title="Inventario";
        $this->subtitle="Panel de inventario";
        $this->model=[
            'inventariope'=> new Inventariope(),
            'control_pruebaelect' => new ControlPruebaelect(),
            'equipo'=>new Equipo(),            
            'sucursal'=>new Sucursal(),           
        ];
        //$this->ext=$this->model['sucursal']->extension();

        $_SESSION['menu'] = 'control_pruebaelect';
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
        $data['get']=$this->model['inventariope']->find($id);
        if(exists($data['get'])){
            $data['equipo'] = $this->model['equipo']->find_by(['id' => $data['get'][0]['equipos_id']],'view_equipos');
            include view($this->name. '.edit');
        }
    }

    public function delete($id){
        $data['get']=$this->model['inventariope']->find($id);
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
        if($this->model['control_pruebaelect']->find_by(['equipos_id' => $data['equipos_id']])){
            if($this->model['inventariope']->find_by(['equipos_id'=>$data['equipos_id'],'procedimiento'=>$data['procedimiento'],'campo_aplicacion'=>$data['campo_aplicacion'],'localizacion'=>$data['localizacion'],'comentario'=>$data['comentario']])){
                Flash::error(setError('015'));
            }else{
                if($this->model['inventariope']->store($data)){
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
        $tabla= $this->name;
        $data= validate($_POST,[
            'id'=>'required|toInt|exists:'. $tabla .'',
            'equipos_id'=>'requiere|toInt',
            'procedimiento'=>'requiere',
            'campo_aplicacion'=>'requiere',
            'localizacion'=>'requiere',
            'comentario'=>'comentario',
        ]);

        $data['responsable']= Session::get('email');      

        if($this->model['control_pruebaelect']->find_by(['equipos_id' => $data['equipos_id']])){
            if($this->model['inventariope']->find_by(['equipos_id'=>$data['equipos_id'],'procedimiento'=>$data['procedimiento'],'campo_aplicacion'=>$data['campo_aplicacion'],'localizacion'=>$data['localizacion'],'comentario'=>$data['comentario']])){
                Flash::error(setError('015'));
            }else{                
                if($this->model['inventariope']->update($data)){
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
        $tabla= $this->name;
        $data = validate($_POST, [
            'id' => 'required|toInt|exists:'. $tabla .'', 
        ]);        
        if($this->model['inventariope']->destroy($data)){
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        } 
    }

    public function ajax_load_existeequipo(){
        $clave=$_POST['clave'];
        $data= $this->model['inventariope']->count(['clave' => $clave],'view_inventariope'); 
        //var_dump($data[0]['existe']);
        $dato= $data[0]['existe'];
        echo json_encode($dato);
    }


}
