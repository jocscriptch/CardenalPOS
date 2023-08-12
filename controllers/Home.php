<?php
class Home extends Controller{
    public function __construct() {
        parent::__construct();
    }
    public function index()
    {
        $data['title'] = 'Iniciar Sesión';
        $this->views->View('principal', 'login' , $data);
    }

    //validar formulario del login
    public function validateLogin() {

        if (isset($_POST['email']) && isset($_POST['password'])) {
            
            if(empty($_POST['email'])){

                $res = array('msg' => 'CORREO REQUERIDO SERVER');

            }else if(empty($_POST['password'])){
                $res = array('msg' => 'CONTRASEÑA REQUERIDA SERVER');
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}

?>