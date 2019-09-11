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
            'alias' => 'required|trim|strtolower',
            'serie' => 'required|trim|strtolower',
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
            'alias' => 'required|trim|strtolower',
            'serie' => 'required|trim|strtolower',
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
    
    public function ajax_load_validacionserie() {
        $serie=$_POST['serie'];
        $dato= $this->model['equipo']->find_by(['serie' => $serie],"view_equipos");                
        echo json_encode($dato);
    }

}
