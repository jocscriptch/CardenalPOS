<?php
class Categorias extends Controller
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
        $data['title'] = 'Categorias';
        $data['script'] = 'categorias.js';
        $this->views->getView('categorias', 'index', $data);
    }

    public function listar()
    {
        $data = $this->model->getCategorias(1);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] =
            '<div class="text-center">
                 <button class="btn btn-info" type="button" onclick="editarCategoria(' . $data[$i]['id'] . ')"><i class="fa-solid fa-pen text-white"></i></button>
                 <button class="btn btn-danger" type="button" onclick="eliminarCategoria(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        if (isset($_POST['nombre'])) {
            $categoria = strClean($_POST['nombre']);
            $id = strClean($_POST['id']);
            if (empty($categoria)) {
                $res = array('msg' => 'EL NOMBRE ES REQUERIDO', 'type' => 'warning');
            } else {
                if ($id == '') {
                    $verificar = $this->model->getValidar('categoria', $categoria, 'registrar', 0);
                    if (empty($verificar)) {
                        $data = $this->model->registrar($categoria);
                        if ($data > 0) {
                            $res = array('msg' => 'CATEGORIA REGISTRADA', 'type' => 'success');
                        } else {
                            $res = array('msg' => 'ERROR AL REGISTRAR', 'type' => 'error');
                        }
                    } else {
                        $res = array('msg' => 'LA CATEGORIA YA EXISTE!', 'type' => 'warning');
                    }
                } else {
                    $verificar = $this->model->getValidar('categoria', $categoria, 'actualizar', $id);
                    if (empty($verificar)) {
                        $data = $this->model->actualizar($categoria, $id);
                        if ($data > 0) {
                            $res = array('msg' => 'CATEGORIA ACTUALIZADA', 'type' => 'success');
                        } else {
                            $res = array('msg' => 'ERROR AL ACTUALIZAR', 'type' => 'error');
                        }
                    } else {
                        $res = array('msg' => 'LA CATEGORIA YA EXISTE!', 'type' => 'warning');
                    }
                }
                
                
            }
        }
        echo json_encode($res);
        die();
    }

    public function eliminar($idCategoria)
    {
        if (isset($_GET) && is_numeric($idCategoria)) {
            $data = $this->model->eliminar(0, $idCategoria);
            if ($data == 1) {
                $res = array('msg' => 'CATEGORIA DESACTIVADA', 'type' => 'success');
            } else {
                $res = array('msg' => 'ERROR AL DESACTIVAR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($idCategoria)
    {
        $data = $this->model->editar($idCategoria);
        
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function inactivas()
    {
        $data['title'] = 'Categorias Inactivas';
        $data['script'] = 'categorias_inactivas.js';
        $this->views->getView('categorias', 'inactivas', $data);
    }

    public function listarInactivas()
    {
        $data = $this->model->getCategorias(0);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['acciones'] =
            '<div class="text-center">
                 <button class="btn btn-info" type="button" onclick="restaurarCategoria(' . $data[$i]['id'] . ')"><i class="fas fa-check-circle text-white"></i></button>
            </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function restaurar($idCategoria)
    {
        if (isset($_GET) && is_numeric($idCategoria)) {
            $data = $this->model->eliminar(1, $idCategoria);
            if ($data == 1) {
                $res = array('msg' => 'CATEGORIA RESTAURADA', 'type' => 'success');
            } else {
                $res = array('msg' => 'ERROR AL RESTAURAR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>