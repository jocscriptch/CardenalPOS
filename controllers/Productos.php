<?php
class Productos extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        $data['title'] = 'Productos';
        $data['script'] = 'productos.js';
        $data['medidas'] = $this->model->getDatos('tbmedidas');
        $data['categorias'] = $this->model->getDatos('tbcategorias');
        $this->views->getView('productos', 'index', $data);
    }
    public function listar()
    {
        $data = $this->model->getProductos(1);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . $data[$i]['foto'] . '" width="100">';
            $data[$i]['acciones'] =
                '<div class="text-center">
                    <button class="btn btn-info" type="button" onClick="editarProducto(' . $data[$i]['id'] . ')"><i class="fa-solid fa-pen text-white"></i></button>
                    <button class="btn btn-danger" type="button" onClick="eliminarProducto(' . $data[$i]['id'] . ')"><i class="fas fa-trash"></i></button>
            </div>';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrar()
    {
        if (isset($_POST['codigo']) && isset($_POST['descripcion'])) {
            $id = strClean($_POST['id']);
            $codigo = strClean($_POST['codigo']);
            $descripcion = strClean($_POST['descripcion']);
            $precio_compra = strClean($_POST['precio_compra']);
            $precio_venta = strClean($_POST['precio_venta']);
            $id_medida = strClean($_POST['id_medida']);
            $id_categoria = strClean($_POST['id_categoria']);
            $fotoActual = strClean($_POST['foto_actual']);
            $foto = $_FILES['foto'];
            $name = $foto['name'];
            $tmp = $foto['tmp_name'];
            $destino = null;

            if (!empty($name)) {
                $fecha = date('YmdHis');
                $destino = 'assets/images/productos/' . $fecha . '.jpg';
            } else if (!empty($fotoActual && empty($name))) {
                $destino = $fotoActual;
            }
            if (empty($codigo)) {
                $res = array('msg' => 'CODIGO REQUERIDO', 'type' => 'warning');
            } else if (empty($descripcion)) {
                $res = array('msg' => 'DESCRIPCION REQUERIDA', 'type' => 'warning');
            } else if (empty($precio_compra)) {
                $res = array('msg' => 'PRECIO DE COMPRA REQUERIDO', 'type' => 'warning');
            } else if (empty($precio_venta)) {
                $res = array('msg' => 'PRECIO DE VENTA REQUERIDO', 'type' => 'warning');
            } else if (empty($id_medida)) {
                $res = array('msg' => 'MEDIDA REQUERIDA', 'type' => 'warning');
            } else if (empty($id_categoria)) {
                $res = array('msg' => 'CATEGORIA REQUERIDA', 'type' => 'warning');
            } else {
                if ($id == '') {
                $verificar = $this->model->getValidar('codigo', $codigo, 'registrar', 0);
                if (empty($verificar)) {
                    $data = $this->model->registrar
                    (
                        $codigo,
                        $descripcion,
                        $precio_compra,
                        $precio_venta,
                        $id_medida,
                        $id_categoria,
                        $destino
                    );

                    if ($data > 0) {
                        if (!empty($name)) {
                            move_uploaded_file($tmp, $destino);
                        }
                        $res = array('msg' => 'PRODUCTO REGISTRADO', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'ERROR AL REGISTRAR', 'type' => 'error');
                    }
                } else {
                    $res = array('msg' => 'EL CODIGO YA EXISTE', 'type' => 'warning');
                }
                } else {
                $verificar = $this->model->getValidar('codigo', $codigo, 'actualizar', $id);
                if (empty($verificar)) {
                    $data = $this->model->actualizar
                    (
                        $codigo,
                        $descripcion,
                        $precio_compra,
                        $precio_venta,
                        $id_medida,
                        $id_categoria,
                        $destino,
                        $id
                    );

                    if ($data > 0) {
                        if (!empty($name)) {
                            move_uploaded_file($tmp, $destino);
                        }
                        $res = array('msg' => 'PRODUCTO ACTUALIZADO', 'type' => 'success');
                    } else {
                        $res = array('msg' => 'ERROR AL ACTUALIZAR', 'type' => 'error');
                    }
                } else {
                    $res = array('msg' => 'EL CODIGO YA EXISTE', 'type' => 'warning');
                }
                }
          
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }

    public function eliminar($idProducto)
    {
        if (isset($_GET) && is_numeric($idProducto)) {
            $data = $this->model->eliminar(0, $idProducto);
            if ($data == 1) {
                $res = array('msg' => 'PRODUCTO DADO DE BAJA', 'type' => 'success');
            } else {
                $res = array('msg' => 'ERROR AL ELIMINAR', 'type' => 'error');
            }
        } else {
            $data = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }

    public function editar($idProducto)
    {
        $data = $this->model->editar($idProducto);

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
?>