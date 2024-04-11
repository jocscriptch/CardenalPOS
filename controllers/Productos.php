<?php
require_once 'models/MedidasModel.php';
require_once 'models/CategoriasModel.php';
class Productos extends Controller
{
    private $medidasModel;
    private $categoriasModel;
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['id_usuario'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $this->medidasModel = new MedidasModel();
        $this->categoriasModel = new CategoriasModel();
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
            $foto = ($data[$i]['foto'] == null) ? 'assets/images/productos/default.png' : $data[$i]['foto']  ;
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . BASE_URL . $foto . '" width="50">';
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
                        // imagen temp
                        $temp = $this->model->editar($id);
                        $imgTemp = ($temp['foto'] != null) ? $temp['foto'] : 'default.png' ;
                        $data = $this->model->actualizar(
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
                            if (file_exists($imgTemp) && $imgTemp != 'default.png') {
                                unlink($imgTemp);
                            }
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

    public function inactivos()
    {
        $data['title'] = 'Productos Inactivos';
        $data['script'] = 'productos_inactivos.js';
        $this->views->getView('productos', 'inactivos', $data);
    }

    public function listarInactivos()
    {
        $data = $this->model->getProductos(0);

        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['imagen'] = '<img class="img-thumbnail" src="' . BASE_URL . $data[$i]['foto'] . '" width="50">';
            $data[$i]['acciones'] =
                '<div class="text-center">
                    <button class="btn btn-info" type="button" onClick="restaurarProducto(' . $data[$i]['id'] . ')"><i class="fas fa-check-circle text-white"></i></button>
            </div>';
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function restaurar($idProducto)
    {
        if (isset($_GET) && is_numeric($idProducto)) {
            $data = $this->model->eliminar(1, $idProducto);
            if ($data == 1) {
                $res = array('msg' => 'PRODUCTO RESTAURADO', 'type' => 'success');
            } else {
                $res = array('msg' => 'ERROR AL RESTAURAR', 'type' => 'error');
            }
        } else {
            $data = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }

    //buscar producto por codigo
    public function buscarPorCodigo($valor)
    {
        $array = array('estado' => false, 'datos' => '');
        $data = $this->model->buscarPorCodigo($valor);
        if (!empty($data)) {
            $array['estado'] = true;
            $array['datos'] = $data;
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }

    //buscar productos por nombre
    public function buscarPorNombre()
    {
        $array = array();
        $valor = $_GET['term'];
        $data = $this->model->buscarPorNombre($valor);
        foreach ($data as $row) {
            $result['id'] = $row['id'];
            $result['label'] = $row['descripcion'];
            $result['stock'] = $row['cantidad'];
            array_push($array, $result);
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }

    //mostrar productos desde localstorage
    public function mostrarDatos()
    {
        $json = file_get_contents('php://input');
        $datos = json_decode($json, true);
        $array['productos'] = array();
        $totalCompra = 0;
        $totalVenta = 0;
        if (!empty($datos)) {
            foreach ($datos as $producto) {
                $result = $this->model->editar($producto['id']);
                $data['id'] = $result['id'];
                $data['nombre'] = $result['descripcion'];
                $data['precio_compra'] = $result['precio_compra'];
                $data['precio_venta'] = $result['precio_venta'];
                $data['cantidad'] = $producto['cantidad'];
                $subTotalCompra = $result['precio_compra'] * $producto['cantidad'];
                $subTotalVenta = $result['precio_venta'] * $producto['cantidad'];
                $data['subTotalCompra'] = number_format($subTotalCompra, 2);
                $data['subTotalVenta'] = number_format($subTotalVenta, 2);
                array_push($array['productos'], $data);
                $totalCompra += $subTotalCompra;
                $totalVenta += $subTotalVenta;
            }
        }
        $array['totalCompra'] = number_format($totalCompra, 2);
        $array['totalVenta'] = number_format($totalVenta, 2);
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function insertarProducto()
    {
        // Obtén los datos del producto de la solicitud
        $codigo = strClean($_POST['codigo']);
        $descripcion = strClean($_POST['descripcion']);
        $precio_compra = strClean($_POST['precio_compra']);
        $precio_venta = strClean($_POST['precio_venta']);
        $medida_nombre = strClean($_POST['id_medida']);
        $categoria_nombre = strClean($_POST['id_categoria']);

        // Obtén el ID de la medida y la categoría de la base de datos
        $id_medida = $this->medidasModel->getIdByNombre($medida_nombre);
        $id_categoria = $this->categoriasModel->getIdByNombre($categoria_nombre);

        // Inserta el producto en la base de datos
        $this->model->registrarXML($codigo, $descripcion, $precio_compra, $precio_venta, implode($id_medida), implode($id_categoria));
    }

    // cargar xml
    public function cargarXML()
    {
        if (isset($_FILES['archivo_xml']['tmp_name'])) {
            $xml_file = $_FILES['archivo_xml']['tmp_name'];
            $xml = simplexml_load_file($xml_file);
            $datos = [];

            foreach ($xml->DetalleServicio->LineaDetalle as $item) {
                $codigo = (string) $item->CodigoComercial->Codigo;
                if (!$this->model->productExist($codigo)) {
                    $detalle = (string) $item->Detalle;
                    $precioUnitario = (int) $item->PrecioUnitario;

                    $medidas = $this->medidasModel->getOnlyMedidas(1);
                    $categorias = $this->categoriasModel->getOnlyCategorias(1);

                    $nombresMedidas = array_map(function ($medida) {
                        return $medida['medida'];
                    }, $medidas);
                    $nombresCategorias = array_map(function ($categoria) {
                        return $categoria['categoria'];
                    }, $categorias);

                    // Crea un arreglo con los datos
                    $datos[] = [
                        'Codigo' => $codigo,
                        'Detalle' => $detalle,
                        'PrecioUnitario' => $precioUnitario,
                        'Medidas' => $nombresMedidas,
                        'Categorias' => $nombresCategorias
                    ];
                } else {
                    $datos[] = [
                        'Existe' => true
                    ];
                }
            }
            if (!empty($datos)) {
                $response = array('msg' => 'Productos obtenidos correctamente desde el archivo XML.', 'type' => 'success', 'productos' => $datos);
                echo json_encode($response);
                die();
            }
        } else {
            $response = array('msg' => 'Error: Archivo XML no encontrado.', 'type' => 'error');
            echo json_encode($response);
            die();
        }
    }


}
?>