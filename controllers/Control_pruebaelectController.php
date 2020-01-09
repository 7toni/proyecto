<?php
Session::logged();
$_SESSION['script'] = NULL;  

class Control_pruebaelectController{

    public function __construct() {
        $this->name = "control_pruebaelect";
        $this->title = "Calidad";
        $this->subtitle = "Panel de control de equipos";
        $this->model=[
            'control_pruebaelect' => new ControlPruebaelect(),
            'informe' => new Informes(),
            'equipo' => new Equipo(),
            'sucursal' => new Sucursal(),
            'magnitud' => new Magnitud(),
            'tipocalibracioncalidad' => new Tipocalibracioncalidad(),
        ];
        $this->ext=$this->model['sucursal']->extension();

        $_SESSION['menu'] = $this->name;
        $_SESSION['submenu'] = $this->name; 
    }

    public function index(){                 
        include view($this->name . '.read');
    }

    public function bajas(){
        $_SESSION['submenu'] = 'bajas';             
        include view($this->name . '.bajas');
    }
    
    // public function pulsocalidad(){        
    //     $_SESSION['submenu'] = 'pulsocalidad';
    //     $tabla= $this->name.$this->ext;
    //     $data['get']   =$this->model['control_calidadc']->find_by([],'view'.$tabla);
    //     include view($this->name . '.pulsocalidad');
    // }
    
    public function add(){
        $data['magnitud']=$this->model['magnitud']->find_by(['departamentos_id'=>'1']);
        $data['tipocalibracionc']=$this->model['tipocalibracioncalidad']->find_by(['departamentos_id'=>'2']);
        include view($this->name . '.add');
    }

    public function edit($id){
        $data['get'] = $this->model['control_pruebaelect']->find($id);
        //var_dump($data['get'][0]);
        if (exists($data['get'])) {
            $data['equipo'] = $this->model['equipo']->find_by(['id' => $data['get'][0]['equipos_id']],'view_equipos');            
            $data['magnitud']=$this->model['magnitud']->find_by(['departamentos_id'=>'2']);
            $data['tipocalibracionc']=$this->model['tipocalibracioncalidad']->find_by(['departamentos_id'=>'2']);     
            include view($this->name . '.edit');
        }        
    }

    public function cancel($id){
        $data['get'] = $this->model['control_pruebaelect']->find($id);
        //var_dump($data['get'][0]);
        if (exists($data['get'])) {
            $data['equipo'] = $this->model['equipo']->find_by(['id' => $data['get'][0]['equipos_id']],'view_equipos');
            //var_dump($data['equipo']);           
            include view($this->name . '.cancel');
        }        
    }

    public function delete($id){
        $data['get'] = $this->model['control_pruebaelect']->find($id);
        //var_dump($data['get'][0]);
        if (exists($data['get'])) {
            $data['equipo'] = $this->model['equipo']->find_by(['id' => $data['get'][0]['equipos_id']],'view_equipos');
            $data['magnitud']=$this->model['magnitud']->find_by(['departamentos_id'=>'1']);
            $data['tipocalibracionc']=$this->model['tipocalibracioncalidad']->find_by(['departamentos_id'=>'1']);             
            include view($this->name . '.delete');
        }      
    }

    public function enable($id){
        $data['get'] = $this->model['control_pruebaelect']->find($id);
        
        $dataequipo['id']= $data['get'][0]['equipos_id'];
        $dataequipo['activo']=1;

        $data['id']= $data['get'][0]['id'];
        $disponible= $data['get'][0]['activo'];        
        if($disponible==0){
            $data['activo']= 1;
        }
        else{
            $data['activo']= 0;
        }        
        unset($data['get']);        
        if($this->model['equipo']->update($dataequipo)){
            if ($this->model['control_pruebaelect']->update($data)) {
                redirect($_SERVER['HTTP_REFERER']);
            } else {                  
                    Flash::error(setError('002'));
            }            
        } else {
            Flash::error(setError('002'));
        }

    }

    public function store(){
        $data = validate($_POST, [
            'equipos_id' => 'required|toInt',            
            'magnitudes_id' => 'required|toInt',
            'calibraciones_id' => 'required|toInt',            
            'fechaingreso' => 'required',            
        ]);
        $data['activo']=1;       
        
        $data['requierec']= (isset($_POST['requierec'])) ? 1 : 0;
        $data['requierem']= (isset($_POST['requierem'])) ? 1 : 0;
        $data['requierev']= (isset($_POST['requierev'])) ? 1 : 0;        

        if($data['requierec'] == 1){
            $data['informe']=$_POST['informe'];
            $data['fecha_calibracion']=$_POST['fecha_calibracion'];
            $data['fecha_vencimiento']=$_POST['fecha_vencimiento'];
            $data['vigencia']=intval($_POST['vigencia']);
            $data['estadoc']=intval($_POST['estadoc']);                      
        }
        else{
            $data['informe']='No requiere';
            $data['fecha_calibracion']=$_POST['fecha_registro'];
            $data['fecha_vencimiento']=$_POST['fecha_registro'];
            $data['vigencia']=6;
            $data['estadoc']=$data['requierec']; 
        }
        if($data['requierem']==1){
            $vigencia=$data['vigencia'];            
            $data=$this->prox_mantenimiento($data, $vigencia);
        }
        else{
            $data['proxm']=NULL;            
        }
        if($data['requierev']==1){
            $vigencia=$data['vigencia'];
            $data=$this->prox_verificacion($data, $vigencia);
        }
        else{
            $data['proxv']=NULL;            
        }
        /* Si existe el equipo, mandara una alerta que el equipo ya existe y no se permite un equipo duplicado */
        if($this->model['control_pruebaelect']->find_by(['equipos_id' => $data['equipos_id']])){
            Flash::error(setError('015'));
        }
        else{
            if ($this->model['control_pruebaelect']->store($data)) {
                redirect('?c=' . $this->name);
            } else {                  
                Flash::error(setError('002'));
            }
        }     
    }

    public function update(){
        $tabla= $this->name;
        $data = validate($_POST, [
            'id' => 'required|toInt|exists:'. $tabla .'',            
            'equipos_id' => 'required|toInt',            
            'magnitudes_id' => 'required|toInt',
            'calibraciones_id' => 'required|toInt',            
            'fechaingreso' => 'required',            
        ]);        
        
        $data['requierec']= (isset($_POST['requierec'])) ? 1 : 0;
        $data['requierem']= (isset($_POST['requierem'])) ? 1 : 0;
        $data['requierev']= (isset($_POST['requierev'])) ? 1 : 0;

        if($data['requierec'] == 1){                                   
            $data['informe']=$_POST['informe'];
            $data['fecha_calibracion']=$_POST['fecha_calibracion'];
            $data['fecha_vencimiento']=$_POST['fecha_vencimiento'];
            $data['vigencia']=intval($_POST['vigencia']);
            $data['estadoc']=intval($_POST['estadoc']);                      
        }
        else{            
            $data['informe']='No requiere';
            $data['fecha_calibracion']=$_POST['fecha_registro'];
            $data['fecha_vencimiento']=$_POST['fecha_registro'];
            $data['vigencia']=6;
            $data['estadoc']=$data['requierec']; 
        }
        if($data['requierem']==1){
            $vigencia=$data['vigencia'];            
            $data=$this->prox_mantenimiento($data, $vigencia);
        }
        else{
            $data['proxm']=NULL;            
        }
        if($data['requierev']==1){
            $vigencia=$data['vigencia'];
            $data=$this->prox_verificacion($data, $vigencia);
        }
        else{
            $data['proxv']=NULL;            
        }

        if ($this->model['control_pruebaelect']->update($data)) {
            redirect('?c=' . $this->name);
        } else {                  
                Flash::error(setError('002'));
        }
    }

    public function disabled(){
        $tabla= $this->name;
        $data = validate($_POST, [
            'id' => 'required|toInt|exists:'. $tabla .'',            
            'equipos_id' => 'required|toInt',                                                
            'comentario' => 'required',
            'fecha'=>'required',
        ]); 
        $dataequipo['id']= $data['equipos_id'];
        $dataequipo['activo']=0;
        //$dataequipo['comentarios']=$data['comentario'];

        $data['responsable']= Session::get('email');
        $data['activo']=0;

        unset($data['equipos_id']);        
        
        if($this->model['equipo']->update($dataequipo)){
            if ($this->model['control_pruebaelect']->update($data)) {
                redirect('?c=' . $this->name);
            } else {                  
                    Flash::error(setError('002'));
            }            
        } else {
            Flash::error(setError('002'));
        }        
    }

    public function destroy(){ 
        $tabla= $this->name;
        $data = validate($_POST, [
            'id' => 'required|toInt|exists:'. $tabla .'', 
        ]);
        if($this->model['control_pruebaelect']->destroy($data)){
            redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }        

    }    

    public function ajax_load_equipo() {
        $idequipo = $_POST['idequipo'];                    
         $data = json_encode($data['equipo'] = $this->model['equipo']->find_by(['alias' => $idequipo],'view_equipos'));
        echo $data;
    }

    public function ajax_load_informe() {
        $idinforme = $_POST['idinforme']; 
        $view_informes="view_informes". $this->ext;
        $data = json_encode($data['informes'] = $this->model['informe']->find_by(['id' => $idinforme],$view_informes));
        echo $data;
    }

    private function prox_mantenimiento($data, $vigencia){
        $fecha= $data['fecha_calibracion'];
        if($vigencia == 6){
            $data['proxm'] = date('Y-m-d', strtotime($fecha . "+12 month"));          
        }
        else{
            $data['proxm'] = date('Y-m-d', strtotime($fecha . "+6 month"));
        }              
        return $data;
    }
    
    private function prox_verificacion($data, $vigencia){
        $fecha= $data['fecha_calibracion'];
        if($vigencia == 6){
            $data['proxv'] = date('Y-m-d', strtotime($fecha . "+12 month"));
        }
        else{
            $data['proxv'] = date('Y-m-d', strtotime($fecha . "+6 month"));
        }                
        return $data;
    }

    private function proximos_mantenimientos(){
        return $data;
    }

    private function proximas_verificaciones(){
        return $data;
    }

    private function calibraciones_vencer(){
        return $data;
    }

    private function estado_actual(){
        return $data;
    }


}
