<?php
class Home extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $data['title'] = 'Iniciar Sesión';
        $this->views->getView('principal', 'login', $data);
    }
    //validar formulario del login
    public function validateLogin()
    {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            if (empty($_POST['email']) || empty($_POST['password'])) {
                $res = array('msg' => 'Correo y Contraseña inválidos', 'type' => 'warning');
            } else {
                $email = strClean($_POST['email']);
                $password = strClean($_POST['password']);
                $data = $this->model->getData($email);

                if (empty($data) || !password_verify($password, $data['clave'])) {
                    $res = array('msg' => 'Correo y Contraseña inválidos', 'type' => 'warning');
                } else {
                    $_SESSION['id_usuario'] = $data['id'];
                    $_SESSION['nombre_usuario'] = $data['nombre'];
                    $_SESSION['correo'] = $data['correo'];
                    $res = array('msg' => '¡Inicio Sesión Exitoso!', 'type' => 'success');
                }
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

}
?>