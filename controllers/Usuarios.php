<?php
class Usuarios extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $data['title'] = 'Usuarios';
        $data['script'] = 'usuarios.js';
        $this->views->getView('usuarios','index', $data);
        //se manda el folder usuarios, luego el archivo index que esta dentro de dicho folder

    }

    public function listar()
    {
        $data = $this->model->getUsuarios(1);

        for ($i=0; $i < count($data); $i++) {
            if ($data[$i]['rol'] == 1) {
                $data[$i]['rol'] = '<span class="badge bg-success">ADMINISTRADOR</span>';
            }else{
                $data[$i]['rol'] = '<span class="badge bg-info">EMPLEADO</span>';
            }
            $data[$i]['acciones'] = '';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

}

?>