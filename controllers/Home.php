<?php
class Home extends Controller{
    public function __construct() {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $data['title'] = 'Iniciar Sesión';
        $this->views->View('principal', 'login' , $data);
    }
    //validar formulario del login
    public function validateLogin()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            if(empty($_POST['email'])){
                $res = array('msg' => 'CORREO REQUERIDO', 'type' => 'warning');
            }else if(empty($_POST['password'])){
                $res = array('msg' => 'CONTRASEÑA REQUERIDA','type' => 'warning');
            }else{
                $email = strClean($_POST['email']);
                $password = strClean($_POST['password']);
                $data = $this->model->getData($email);

                if(empty($data)){
                    $res = array('msg' => 'EL CORREO NO EXISTE','type' => 'warning');
                }else{
                    if(password_verify($password, $data['clave'])){
                        $_SESSION['nombre_usuario'] = $data['nombre'];
                        $_SESSION['correo'] = $data['correo'];

                        $res = array('msg' => 'DATOS CORRECTOS', 'type' => 'success');

                    }else{
                        $res = array('msg' => 'CONTRASEÑA INCORRECTA', 'type' => 'warning');
                    }
                }
            }
        }else{
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}

?>