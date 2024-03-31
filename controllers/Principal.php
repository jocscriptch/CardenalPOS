<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
class Principal extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    // metodos login
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
                    $_SESSION['perfil_usuario'] = $data['perfil'];
                    $_SESSION['rol'] = $data['rol'];
                    $evento = 'Inicio de Sesión';
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $detalle = $_SERVER['HTTP_USER_AGENT'];
                    $acceso = $this->model->registrarAcceso($evento, $ip, $detalle);
                    if ($acceso > 0) {
                        $res = array('msg' => '¡Inicio Sesión Exitoso!', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'No se pudo registrar el acceso', 'type' => 'error');
                    }
                }
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function forgot()
    {
        $data['title'] = 'Olvidó su contraseña?';
        $this->views->getView('usuarios', 'forgot', $data);
    }

    public function reset($token)
    {
        $data['title'] = 'Restablecer Contraseña';
        $data['Securitytoken'] = $this->model->verificarToken($token);
        if ($data['Securitytoken']['token'] != $token || empty($token) || $data['Securitytoken']['token'] == null) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $this->views->getView('usuarios', 'reset', $data);
    }

    public function resetPassword()
    {
        $json = file_get_contents('php://input');
        $datos = json_decode($json);
        $nueva = strClean($datos->nueva_clave);
        $confirm = strClean($datos->confirm_clave);
        $token = strClean($datos->token);

        if (empty($nueva) || empty($confirm)) {
            $res = array('msg' => 'Todos los campos con * son obligatorios', 'type' => 'warning');
        } else if (strlen($nueva) < 6) {
            $res = array('msg' => 'La contraseña debe tener al menos 6 caracteres', 'type' => 'warning');
        } else if (!$this->validarClave($nueva)) {
            $res = array('msg' => 'La contraseña debe contener al menos una letra mayúscula, una letra minúscula y un número', 'type' => 'warning');
        } else if ($nueva != $confirm) {
            $res = array('msg' => 'Las contraseñas no coinciden', 'type' => 'warning');
        } else {
            $hash = password_hash($nueva, PASSWORD_DEFAULT);
            $data = $this->model->modificarClave($hash, $token);
            if ($data == 1) {
                $res = array('msg' => 'Contraseña modificada correctamente', 'type' => 'success');
            } else {
                $res = array('msg' => 'No se pudo modificar la contraseña', 'type' => 'error');
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    // validar si la contraseña es segura
    private function validarClave($clave)
    {
        // verificar si la contraseña contiene al menos una letra mayuscula, una letra minuscula y un numero
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $clave);
    }

    public function sendEmail($email)
    {
        $verificar = $this->model->verificarCorreo($email);
        if (!empty($verificar)) {
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            $fecha = date('YmdHis');
            $token = md5($fecha);
            try {
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->SMTPDebug = 0; //PRODUCTION
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host = HOST_SMTP;                     //Set the SMTP server to send through
                $mail->SMTPAuth = true;                                   //Enable SMTP authentication
                $mail->Username = USER_SMTP;                     //SMTP username
                $mail->Password = CLAVE_SMTP;                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port = PORT_SMTP;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('uabdias49@gmail.com', 'Cliente');
                $mail->addAddress($email);

                //Content
                $mail->isHTML(true);
                $mail->CharSet = 'UTF-8';                              //Set email format to HTML
                $mail->Subject = 'Restablecer Contraseña - ' . TITLE;
                $mail->Body = '<p>Estimado usuario,</p><p>Hemos recibido una solicitud para restablecer la contraseña de 
            su cuenta. Si usted hizo esta solicitud, por favor haga clic en el siguiente enlace para establecer una nueva 
            contraseña:</p><a href="' . BASE_URL . 'principal/reset/' . $token . '">Restablecer Contraseña</a><p>Si no solicitó un restablecimiento 
            de contraseña, ignore este correo electrónico o póngase en contacto con nosotros si tiene
            alguna duda.</p><p>Atentamente,</p><p>El Equipo de ' . TITLE . '</p>';
                $mail->AltBody = 'Estimado usuario,\n\nHemos recibido una solicitud para restablecer la contraseña de 
            su cuenta. Si usted hizo esta solicitud, por favor siga el enlace proporcionado en este correo electrónico para 
            establecer una nueva contraseña.\n\nSi no solicitó un restablecimiento de contraseña, ignore este correo electrónico 
            o póngase en contacto con nosotros si tiene alguna duda.\n\nAtentamente,\nEl Equipo de ' . TITLE;


                $mail->send();
                $verificarToken = $this->model->registrarToken($token, $email);
                if ($verificarToken == 1) {
                    $res = array('msg' => 'Se envio el correo con un token de seguridad', 'type' => 'success');
                } else {
                    $res = array('msg' => 'No se pudo registrar el token', 'type' => 'error');
                }
            } catch (Exception $e) {
                $res = array('msg' => 'No se pudo enviar el correo: ' . $mail->ErrorInfo, 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'El correo no esta registrado', 'type' => 'warning');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function errors()
    {
        if (empty($_SESSION['id_usuario'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $data['title'] = 'Página no Encontrada';
        $this->views->getView('admin', 'error', $data);
    }
}
