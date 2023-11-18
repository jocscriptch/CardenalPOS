<?php
class Medidas extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
        if(empty($_SESSION['id_usuario'])){
            header('Location: '. BASE_URL);
            exit;
        }
    }
    public function index()
    {
        $data['title'] = 'Medidas';
        $data['script'] = 'medidas.js';
        $this->views->getView('medidas', 'index', $data);
    }
    //listar las medidas
    public function listar()
    {
        $data = $this->model->getMedidas(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] =
                '<div class="text-center">
                    <button class="btn btn-info" type="button" onClick="editarMedida(' . $data[$i]['id'] . ')"><i class="fa-solid fa-pen text-white"></i></button>
                    <button class="btn btn-danger" type="button" onClick="eliminarMedida(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
                </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
    //registrar medidas
    public function registrar()
    {
        $nombre = strClean($_POST['nombre']);
        $abreviatura = strClean($_POST['abreviatura']);
        $id = strClean($_POST['id']);
        if (empty($nombre)) {
            $res = array('msg' => 'Nombre Requerido', 'type' => 'warning');
        } else if (empty($abreviatura)) {
            $res = array('msg' => 'Abreviatura Requerida', 'type' => 'warning');
        } else {
            if ($id == '') {
                //verificar que no ingresen medidas repetidas
                $verificar = $this->model->getValidar('medida', $nombre, 'registrar', 0);
                if (empty($verificar)) {
                    $data = $this->model->registrar($nombre, $abreviatura);
                    if ($data > 0) {
                        $res = array('msg' => 'MEDIDA REGISTRADA', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'ERROR AL REGISTRAR', 'type' => 'error');
                    }
                } else {
                    $res = array('msg' => 'LA MEDIDA YA EXISTE!', 'type' => 'warning');
                }
            } else {
                //verificar que ingresen medidas repetidas
                $verificar = $this->model->getValidar('medida', $nombre, 'actualizar', $id);
                if (empty($verificar)) {
                    $data = $this->model->actualizar($nombre, $abreviatura, $id);
                    if ($data == 1) {
                        $res = array('msg' => 'MEDIDA MODIFICADA', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'ERROR AL MODIFICAR', 'type' => 'error');
                    }
                } else {
                    $res = array('msg' => 'LA MEDIDA YA EXISTE!', 'type' => 'warning');
                }
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    //elimnar medidas
    public function eliminar($idMedida)
    {
        if (isset($_GET)) {
            if (is_numeric($idMedida)) {
                $data = $this->model->eliminar(0, $idMedida);

                if ($data == 1) {
                    $res = array('msg' => 'MEDIDA DESACTIVADA', 'type' => 'success');
                } else {
                    $res = array('msg' => 'ERROR AL DESACTIVAR', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
    public function editar($idMedida)
    {
        $data = $this->model->editar($idMedida);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function inactivas()
    {
        $data['title'] = 'Medidas Inactivas';
        $data['script'] = 'medidas_inactivas.js';
        $this->views->getView('medidas', 'inactivas', $data);
    }

    //listar la medidas inactivas
    public function listarInactivas()
    {
        $data = $this->model->getMedidas(0);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] = '
                <div class="text-center">
                    <button class="btn btn-info" type="button" onClick="restaurarMedida(' . $data[$i]['id'] . ')"><i class="fas fa-check-circle text-white"></i></button>
                </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function restaurar($idMedida)
    {
        if (isset($_GET)) {
            if (is_numeric($idMedida)) {
                $data = $this->model->eliminar(1, $idMedida);

                if ($data == 1) {
                    $res = array('msg' => 'MEDIDA RESTAURADA', 'type' => 'success');
                } else {
                    $res = array('msg' => 'ERROR AL RESTAURAR', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>