<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

class Compras extends Controller
{
    private $idUsuario;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->idUsuario = $_SESSION["id_usuario"];
    }

    public function index()
    {
        $data['title'] = 'Compras';
        $data['script'] = 'compras.js';
        $data['busqueda'] = 'busqueda.js';
        $data['carrito'] = 'posCompra';
        $this->views->getView('compras', 'index', $data);
    }

    public function registrarCompra()
    {
        $json = file_get_contents('php://input');
        $datos = json_decode($json, true);
        $array['productos'] = array();
        $subtotal = 0;
    
        if (!empty($datos['productos'])) {
            $serie = str_pad(rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            
            $idProveedor = $datos['idProveedor'];
            if (empty($idProveedor)) {
                $res = array('msg' => 'PROVEEDOR REQUERIDO', 'type' => 'warning');
            } else {
                foreach ($datos['productos'] as $producto) {
                    $result = $this->model->getProducto($producto['id']);
                    $data['id'] = $result['id'];
                    $data['nombre'] = $result['descripcion'];
                    $data['precio'] = $result['precio_compra'];
                    $data['cantidad'] = $producto['cantidad'];
                    $subTotalProducto = $result['precio_compra'] * $producto['cantidad'];
                    $subtotal += $subTotalProducto;
                    $iva = $subtotal * 0.13;
                    $granTotal = $subtotal + $iva;
                    array_push($array['productos'], $data);

                    // Actualizar stock
                    $nuevaCantidad = $result['cantidad'] + $producto['cantidad'];
                    $this->model->actualizarStock($nuevaCantidad, $result['id']);
                }
                $datosProductos = json_encode($array['productos']);
                $compra = $this->model->registrarCompra(
                    $datosProductos,
                    $subtotal,
                    $iva,
                    $granTotal,
                    $fecha,
                    $hora,
                    $serie,
                    $idProveedor,
                    $this->idUsuario
                );

                if ($compra > 0) {
                    $res = array(
                        'msg' => 'COMPRA REGISTRADA',
                        'type' => 'success',
                        'idCompra' => $compra
                    );
                } else {
                    $res = array('msg' => 'ERROR AL CREAR COMPRA', 'type' => 'error');
                }
            }
        } else {
            $res = array('msg' => 'CARRITO VACIO', 'type' => 'warning');
        }
        echo json_encode($res);
        die();
    }


    public function reporte($datos)
    {
        ob_start();
        $array = explode(',', $datos);
        $tipo = $array[0];
        $idCompra = $array[1];
        $data['title'] = 'Reporte';
        $data['empresa'] = $this->model->getEmpresa();
        $data['compra'] = $this->model->getCompra($idCompra);
        if (empty($data['compra'])) {
            echo 'Pagina No Encontrada';
            exit;
        }
        $this->views->getView('compras', $tipo, $data);
        $html = ob_get_clean();

        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);

        if ($tipo == 'ticked') {
            $dompdf->setPaper(array(0, 0, 222, 841), 'portrait');
        } else {
            $dompdf->setPaper('A4', 'vertical');
        }
        $dompdf->render();
        $dompdf->stream('ticket.pdf', array("Attachment" => false));
    }

    public function listar()
    {
        $data = $this->model->getCompras();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['acciones'] =
                    '<div class="text-center">
                    <a class="btn btn-primary" href="#" onclick="verReporte(' . $data[$i]['id'] . ')"><i class="fas fa-file-pdf"></i></a>
                    <a class="btn btn-danger" href="#" onclick="anularCompra(' . $data[$i]['id'] . ')"><i class="fas fa-trash text-white"></i></a>
                </div>';
            } else {
                $data[$i]['acciones'] =
                    '<div class="text-center">
                        <span class="badge bg-info">Anulado</span>
                        <a class="btn btn-danger" href="#" onclick="verReporte(' . $data[$i]['id'] . ')"><i class="fas fa-file-pdf"></i></a>
                    </div>';
            }
        }
        echo json_encode($data);
        die();
    }

    public function anular($idCompra)
    {
        if (isset($_GET) && is_numeric($idCompra)) {
            $data = $this->model->anular($idCompra);
            if ($data == 1) {
                $resultCompra = $this->model->getCompra($idCompra);
                $compraProducto = json_decode($resultCompra['productos'], true);
                foreach ($compraProducto as $producto) {
                    $result = $this->model->getProducto($producto['id']);
                    $nuevaCantidad = $result['cantidad'] - $producto['cantidad'];
                    $this->model->actualizarStock($nuevaCantidad, $producto['id']);
                }
                $res = array('msg' => 'COMPRA ANULADA', 'type' => 'success');
            } else {
                $res = array('msg' => 'ERROR AL ANULAR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }
}
?>