<?php

class LoginController {

    public function __construct() { 

         $this->model = [
            'usuario' => new Usuario(),
            'informe' => new Informes(),
        ];            
    }

    public function index() {       
        include view('login.index');
    }

    public function lock(){
        if(!isset($_SESSION['lock']) && !isset($_COOKIE['lock'])){
            Session::lock();
        }
        include view('login.lockscreen');
    }
    
    public function unlock(){
        if ($data = validate($_POST, [
            'password' => 'required|min:3',
        ])) {
            $data['email'] = Session::get('email');
            if ($this->data = $this->model['usuario']->get_password($data['email'])) {
                $user = $this->data[0];
                if ($login = password_verify($data['password'], $user['password'])) {
                    Session::unlock();
                    redirect('index.php');
                } else {
                    Flash::error(setError('005'));
                }
            } else{
                Flash::error(setError('004'));
            }
        } else{
            Flash::error(setError('003'));
        }
    }
    public function login() {
        if ($data = validate($_POST, [
            'email' => 'required',
            'password' => 'required|min:3',
        ])) {            
            if ($this->data = $this->model['usuario']->get_password($data['email'])) {
                $user = $this->data[0];
                if ($login = password_verify($data['password'], $user['password'])) {
                    if (isset($data['remember'])) {
                        Session::store($user['id'], true);
                        if(Session::get('activo') == 'si'){
                            Logs::this('Inicio sesión','Se usó opción de “Recordar”');
                            $_SESSION['log'] = true;
                            redirect('index.php');
                        } else{
                            unset($_SESSION['session']);
                            setcookie('session', '', time() - 3600, '/');
                            Flash::error(setError('007'));
                        }
                    } else {
                        Session::store($user['id'], false);
                        if(Session::get('activo') == 'si'){
                            Logs::this('Inicio sesión');
                            $_SESSION['log'] = true;
                            redirect('index.php');
                        } else{
                            unset($_SESSION['session']);
                            setcookie('session', '', time() - 3600, '/');
                            Flash::error(setError('007'));
                        }
                    }
                } else {
                    Flash::error(setError('005'));
                }
            } else {
                Flash::error(setError('004'));
            }
        } else {
            Flash::error(setError('003'));
        }
    }

    public function ajax_load_acceso() {
        $dato="";
        if ($data = validate($_POST, [
            'email' => 'required',
            'password' => 'required|min:3',
        ])) {                         
            if ($this->data = $this->model['usuario']->get_password($data['email'])) {
                $user = $this->data[0];
                if ($login = password_verify($data['password'], $user['password'])) {
                    
                    if($this->model['usuario']->find_by(['email' => $data['email'],'accesopass'=> 1],"view_usuarios")){
                        $dato="exitoso"; 
                    }
                    else{
                        $dato="Alerta!. Usuario no permitido, ingresar un usuario valido por favor. Gracias."; 
                    }                   
                } else {
                   $dato="Error. Usuario y contraseña no coinciden.";
                }
            } else {
                  $dato="Error.La contraseña no es valida.";
            }

        } else {
            $dato="Error.Campos no validos.";
        }

        echo json_encode($dato);
    }

    public function logout() {        
        Session::destroy();
        Logs::this('Cerro sesión','El usuario cerro sesión');
    }

}