<?php
class Usuarios extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $data['title'] = 'Usuarios';
        $this->views->getView('usuarios','index', $data);
        //se manda el folder usuarios, luego el archivo index que esta dentro de dicho folder

    }


}

?>