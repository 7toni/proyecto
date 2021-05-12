<?php

Session::logged();

class UsuariosController {

    public function __construct() {
        $this->name = "usuarios";
        $this->title = "Módulos";
        $this->subtitle = "Panel de control de módulos ";
        $this->model = [
            'usuario' => new Usuario(),
            'rol' => new Rol(),
            'empresa' => new Empresa(),
            'sucursal' => new Sucursal(),
            'planta' => new Planta(),
        ];

        $_SESSION['script'] = '';
    }

    public function index() {
        $rol =substr(Session::get('roles_id'),-2);

        $_SESSION['menu'] = 'usuarios';
        $_SESSION['submenu'] = $this->name;
        include view($this->name . '.read');
    }

    public function cliente() {
        $rol =substr(Session::get('roles_id'),-2);

        $_SESSION['menu'] = 'usuarios';
        $_SESSION['submenu'] = $this->name. "cliente";
        include view($this->name . '.cliente');
    }

    public function mypsa() {
        $rol =substr(Session::get('roles_id'),-2);
        
        $_SESSION['menu'] = 'usuarios';
        $_SESSION['submenu'] = $this->name. "mypsa";
        include view($this->name . '.mypsa');
    }

    public function alta() {
        $_SESSION['menu'] = 'usuarios';
        $_SESSION['submenu'] = $this->name. "alta";
        include view($this->name . '.alta');
    }

    public function refresh() {
        Session::renew();
        redirect($_SERVER['HTTP_REFERER']);
    }
    
    public function turn_off($id){
        $data['usuario'] = $this->model['usuario']->find($id);
        if (exists($data['usuario'])) {  
            if (intval($data['usuario'][0]['roles_id']) == 10000 and Session::get("rol") != "Administrador") {
                        redirect('?c=error&a=error_403');
            }
            else{
                $disponible = $data['usuario'][0]['activo'];
                $data['id'] = $id;
                if($disponible == 1){
                    $data['activo'] = 0;
                } else{
                    $data['activo'] = 1;
                }
                unset($data['usuario']);
                if ($this->model['usuario']->update($data)) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    Flash::error(setError('002'));
                }
            }
        }
    }

    public function add() {
        $_SESSION['pageback']=$_SERVER['HTTP_REFERER'];
        //var_dump(Session::get("rol")); //Administrador         
        $data['rol'] = $this->model['rol']->all();
        $data['empresa'] = $this->model['empresa']->all();
        include view($this->name . '.add');
    }

    public function edit($id) {
        $_SESSION['pageback']=$_SERVER['HTTP_REFERER'];

        $data['usuario'] = $this->model['usuario']->find($id);
        //var_dump($data['usuario'][0]['roles_id']);
        if (exists($data['usuario'])) {  
            if (intval($data['usuario'][0]['roles_id']) == 10000 and Session::get("rol") != "Administrador") {
                        redirect('?c=error&a=error_403');
            }
            else{
            $plantas_id = $data['usuario'][0]['plantas_id'];
            $empresa = $this->model['planta']->find_by(['id'=>$plantas_id]);
            $empresas_id = $empresa[0]['empresas_id'];
            $data['empresa'] = $this->model['empresa']->all();
            $data['planta'] = $this->model['planta']->find_by(['empresas_id'=>$empresas_id]);
            $data['direccion']= $this->model['planta']->find_by(['id' => $plantas_id ], "view_plantas");
            $data['rol'] = $this->model['rol']->all();
            

            include view($this->name . '.edit');
            }         
            
        }
    }

    public function delete($id) {
        $_SESSION['pageback']=$_SERVER['HTTP_REFERER'];
        $data['usuario'] = $this->model['usuario']->find($id);
        if (exists($data['usuario'])) {
            if (intval($data['usuario'][0]['roles_id']) == 10000 and Session::get("rol") != "Administrador") {
                redirect('?c=error&a=error_403');
            }
            else{
                $plantas_id = $data['usuario'][0]['plantas_id'];
                $empresa = $this->model['planta']->find_by(['id'=>$plantas_id]);
                $empresas_id = $empresa[0]['empresas_id'];
                $data['empresa'] = $this->model['empresa']->all();
                $data['planta'] = $this->model['planta']->find_by(['empresas_id'=>$empresas_id]);
                $data['direccion']= $this->model['planta']->find_by(['id' => $plantas_id], "view_plantas");
                $data['rol'] = $this->model['rol']->all();
                include view($this->name . '.delete');
            }
        }
    }

    public function store() {
        $data = validate($_POST, [
            'nombre' => 'required|ucwords',
            'apellido' => 'required|ucwords',
            'plantas_id' => 'required|trimlower|exists:plantas:id',
            'email' => 'required|trimlower|unique:usuarios',
            'password' => 'required',
            'roles_id' => 'required|trimlower|exists:roles:id',
            'activo' => 'required|toInt',
        ]);
        
        $data["nombre"] = ucfirst($data["nombre"]);
        $data["apellido"] = ucfirst($data["apellido"]);
        $data["password"] = Crypt::encrypt($data["password"]);
        if($_FILES['avatar']['size'] > 0){
            if($avatar = Storage::validate($_FILES['avatar'], [
                'max-size' => 4096,
                'allow_extension' => ['jpg','png'],
                'timestamp' => true,
            ])){
                $data["imagen"] = $avatar['timestamp_ext'];
                if ($this->model['usuario']->store($data)) {
                    Storage::upload_image('avatares',700, $avatar['name'], $avatar['tmp_name']);                    
                    
                    redirect($_SESSION['pageback']);

                    //redirect('?c=' . $this->name);
                } else {
                    Flash::error(setError('002'));
                }
            } else{
                Flash::error(setError('006'));
            }
         } else{
            if ($this->model['usuario']->store($data)) {
                if(Session::get('id') == $data['id']){
                    Session::renew();
                }
                redirect($_SESSION['pageback']);

                //redirect('?c=' . $this->name);
            } else {
                Flash::error(setError('002'));
            }
        }
    }

    public function update() {        
        $data = validate($_POST, [
            'id' => 'required|exists:usuarios',
            'nombre' => 'required|ucwords',
            'apellido' => 'required|ucwords',
            'email' => 'required|trimlower',
            'plantas_id' => 'required|trimlower|exists:plantas:id',
            'roles_id' => 'required|trimlower|exists:roles:id',
            'activo' => 'required|toInt',
        ]);

        /* ..................................... */
        /*      Envio de notificacion            */
        /* ..................................... */
        if (isset($_POST['check_email'])) {

            $dataemail['nombre']=$data['nombre'];
            $dataemail['apellido']=$data['apellido'];
            $dataemail['email']=$data['email'];
            $dataemail['body']=EnvioCorreo::_bodyusernotificacion($dataemail);                                     
            $dataemail['cco'] = array(
                                'email' => array('bitacora.soporte@mypsa.com.mx','mvega@mypsa.mx'), 
                                'alias' => array('Bitacora S.','Manuel V.'),                       
                            );                                

            $dataemail['asunto']="Usuario de alta MyPSA";            
            EnvioCorreo::_enviocorreo($dataemail);            
        } 
        unset($data['check_email']);
        $data["nombre"] = ucfirst($data["nombre"]);
        $data["apellido"] = ucfirst($data["apellido"]);
        if($_FILES['avatar']['size'] > 0){
            if($avatar = Storage::validate($_FILES['avatar'], [
                'max-size' => 4096,
                'allow_extension' => ['jpg','png'],
                'timestamp' => true,
            ])){
                $data["imagen"] = $avatar['timestamp_ext'];
                if ($this->model['usuario']->update($data)) {
                    Storage::upload_image('avatares',700, $avatar['name'], $avatar['tmp_name']);
                    if ($_POST['imagen'] != 'default.png') {
                        Storage::delete('avatares', $_POST['imagen']);
                    }
                    if(Session::get('id') == $data['id']){
                        Session::renew();
                    }

                    redirect($_SESSION['pageback']);

                    //header('Location: ' . $_SERVER['HTTP_REFERER']);

                    //redirect('?c=' . $this->name);
                } else {
                    Flash::error(setError('002'));
                }
            } else{
                Flash::error(setError('006'));
            }
        } else{    
            if ($this->model['usuario']->update($data)) {
                if(Session::get('id') == $data['id']){
                    Session::renew();
                }

                redirect($_SESSION['pageback']);
            } else {
                Flash::error(setError('002'));
            }
        }
    }

    public function destroy() {
        $data = validate($_POST, [
            'id' => 'required|exists:usuarios|toInt',
        ]);
        if ($this->model['usuario']->destroy($data)) {
            Logs::this('Delete','Se elimino el usuario '.json_encode($data));
            redirect($_SESSION['pageback']);            
            //redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function ajax_load_plantas() {
        $idempresa = $_POST['empresas_id'];
        echo $data = json_encode($data['planta'] = $this->model['planta']->find_by(['empresas_id'=> $idempresa]));
    }

    public function password($id) {
        $data['usuario'] = $this->model['usuario']->find($id);
         if (intval($data['usuario'][0]['roles_id']) == 10000 and Session::get("rol") != "Administrador") {
                        redirect('?c=error&a=error_403');
            }
            else{
                include view($this->name . '.password');
            }   
    }

    public function update_password() {
        $data = validate($_POST, [
            'id'    => 'required|exists:usuarios|toInt',
            'password'  => 'required|min:3',
        ]);
        $data["password"] = Crypt::encrypt($data["password"]);
        if ($this->model['usuario']->update($data)) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            //redirect('?c=' . $this->name);
        } else {
            Flash::error(setError('002'));
        }
    }

    public function get_usuario_alta(){
        if(Session::get("rol") == "Administrador"){
            echo $data = json_encode($data['usuario'] = $this->model['usuario']->usuario_alta_notification());
        }        
        else{
            $arraydefault = array();
            echo json_encode($arraydefault);
        }
    }

    public function ajax_load_usermypsa() {
        $sucursal = $_POST['sucursal'];
        $view="view_usuarios_mypsa";
        $data = json_encode($this->model['usuario']->find_by(['sucursal' => $sucursal, 'roles_id'=>'10003'], $view));
        echo $data;
    } 


}
