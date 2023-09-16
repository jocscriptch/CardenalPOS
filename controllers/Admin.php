<?php
class Admin extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    //reportes graficos
    public function index()
    {
        $data['title'] = 'Panel Administrativo';
        $data['script'] = 'index.js';
        $this->views->getView('admin', 'home', $data);
    }

    //datos de la empresa
    public function datos()
    {
        $data['title'] = 'Datos del Negocio';
        $data['script'] = 'admin.js';
        $data['empresa'] = $this->model->getData();
        $this->views->getView('admin', 'index', $data);
    }

    //modificar datos de la empresa
    public function modificar()
    {
        if (isset($_POST)) {
            //accediento a los campos nombres del formulario index.php
            $rut = strClean($_POST['rut']);
            $nombre = strClean($_POST['nombre']);
            $telefono = strClean($_POST['telefono']);
            $correo = strClean($_POST['email']);
            $direccion = strClean($_POST['direccion']);
            $impuesto = strClean($_POST['impuesto']);
            $mensaje = strClean($_POST['mensaje']);
            $id = strClean($_POST['id']);

            if (empty($rut)) {
                $res = array('msg' => 'EL RUT ES REQUERIDO', 'type' => 'warning');

            } else if (empty($nombre)) {
                $res = array('msg' => 'EL NOMBRE ES REQUERIDO', 'type' => 'warning');

            } else if (empty($telefono)) {
                $res = array('msg' => 'EL TELEFONO ES REQUERIDO', 'type' => 'warning');
            } else if (empty($correo)) {
                $res = array('msg' => 'EL CORREO ES REQUERIDO', 'type' => 'warning');
            } else if (empty($direccion)) {
                $res = array('msg' => 'LA DIRECCION ES REQUERIDA', 'type' => 'warning');

            } else {
                $data = $this->model->actualizar(
                    $rut,
                    $nombre,
                    $telefono,
                    $correo,
                    $direccion,
                    $impuesto,
                    $mensaje,
                    $id
                );

                if ($data == 1) {
                    $res = array('msg' => 'DATOS MODIFICADOS', 'type' => 'success');
                } else {
                    $res = array('msg' => 'ERROR AL ACTUALIZAR', 'type' => 'error');
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