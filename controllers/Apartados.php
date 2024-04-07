<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;

class Apartados extends Controller
{
    private $idUsuario;
    public function __construct()
    {
        parent::__construct();
        session_start();
        if(empty($_SESSION['id_usuario'])){
            header('Location: '. BASE_URL);
            exit;
        }
        $this->idUsuario = $_SESSION["id_usuario"];
    }
    public function index()
    {
        $data['title'] = 'Apartados';
        $data['script'] = 'apartados.js';
        $data['busqueda'] = 'busqueda.js';
        $data['carrito'] = 'posApartados';
        $this->views->getView('apartados', 'index', $data);
    }
    public function registrarApartado()
    {
        $json = file_get_contents('php://input');
        $datos = json_decode($json, true);
        $array['productos'] = array();
        $subtotal = 0;

        if (!empty($datos['productos'])) {
            $fecha_creado = date('Y-m-d');
            $fecha_apartado = $datos['fecha_apartado'] . ' ' . date('H:i:s');
            $fecha_retiro = $datos['fecha_retiro'] . ' 23:59:59';
            $abono = $datos['abono'];
            $color = $datos['color'];
            $idCliente = $datos['idCliente'];

            if (empty($idCliente)) {
                $res = array('msg' => 'CLIENTE REQUERIDO', 'type' => 'warning');
            } else if (empty($fecha_apartado)) {
                $res = array('msg' => 'FECHA DE APARTADO REQUERIDA', 'type' => 'warning');
            } else if (empty($fecha_retiro)) {
                $res = array('msg' => 'FECHA DE RETIRO REQUERIDA', 'type' => 'warning');
            } else if (empty($abono)) {
                $res = array('msg' => 'MONTO ABONAR REQUERIDO', 'type' => 'warning');
            } else {
                foreach ($datos['productos'] as $producto) {
                    $result = $this->model->getProducto($producto['id']);
                    $data['id'] = $result['id'];
                    $data['nombre'] = $result['descripcion'];
                    $data['precio'] = $result['precio_venta'];
                    $data['cantidad'] = $producto['cantidad'];
                    $subTotalProducto = $result['precio_venta'] * $producto['cantidad'];
                    $subtotal += $subTotalProducto;
                    $iva = $subtotal * 0.13;
                    $granTotal = $subtotal + $iva;
                    array_push($array['productos'], $data);
                }
                $datosProductos = json_encode($array['productos']);
                $apartado = $this->model->registrarApartado(
                    $datosProductos,
                    $fecha_creado,
                    $fecha_apartado,
                    $fecha_retiro,
                    $abono,
                    $granTotal,
                    $color,
                    $idCliente,
                    $this->idUsuario
                );
                if ($apartado > 0) {
                    foreach($datos['productos'] as $producto){
                        $result = $this->model->getProducto($producto['id']);
                        // Actualizar stock
                        $nuevaCantidad = $result['cantidad'] + $producto['cantidad'];
                        $totalVentas = $result['ventas'] + $producto['cantidad'];
                        $this->model->actualizarStock($nuevaCantidad, $totalVentas, $result['id']);

                        //movimientos
                        $movimiento = 'Apartado N°: ' . $apartado;
                        $this->model->registrarMovimiento(
                            $movimiento,
                            'salida',
                            $producto['cantidad'],
                            $nuevaCantidad,
                            $producto['id'],
                            $this->idUsuario
                        );
                    }
                    $res = array('msg' => 'PRODUCTOS APARTADOS', 'type' => 'success', 'idApartado' => $apartado);
                } else {
                    $res = array('msg' => 'ERROR AL APARTAR PRODUCTOS', 'type' => 'error');
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
        $idApartado = $array[1];

        $data['title'] = 'Reporte';
        $data['empresa'] = $this->model->getEmpresa();
        $data['apartado'] = $this->model->getApartado($idApartado);
        if (empty($data['apartado'])) {
            echo 'Pagina no Encontrada';
            exit;
        }
        $this->views->getView('apartados', $tipo, $data);
        $html = ob_get_clean();
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);

        if ($tipo == 'ticked') {
            $dompdf->setPaper(array(0, 0, 250, 842), 'portrait');
        } else {
            $dompdf->setPaper('A4', 'vertical');
        }

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('reporte.pdf', array('Attachment' => false));
    }

    public function listar()
    {
        $data = $this->model->getApartados();
        for ($i = 0; $i < count($data); $i++) {
            $estado = ($data[$i]['estado'] == 0) ? 'Completado' : 'Pendiente';
            $data[$i]['title'] = $estado . ' - ' . $data[$i]['nombre'];
            $data[$i]['start'] = $data[$i]['fecha_apartado'];
            $data[$i]['end'] = $data[$i]['fecha_retiro'];
        }
        echo json_encode($data);
        die();
    }

    public function verDatos($idApartado)
    {
        $data = $this->model->getApartado($idApartado);
        echo json_encode($data);
        die();
    }

    public function procesarApartado($idApartado)
    {
        $apartado = $this->model->getApartado($idApartado);
        $data = $this->model->procesarApartado($apartado['total'], 0, $idApartado);
        if ($data == 1) {
            $res = array('msg' => 'PROCESADO CON ÉXITO', 'type' => 'success');
        } else {
            $res = array('msg' => 'ERROR AL PROCESAR', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function listarHistorial()
    {
        $data = $this->model->getApartados();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 0) {
                $data[$i]['estado'] = '<span class="badge bg-success">Completado</span>';
            } else {
                $data[$i]['estado'] = '<span class="badge bg-danger">Pendiente</span>';
            }
            $data[$i]['cliente'] ='<span class="badge" style="background: ' . $data[$i]['color'] . ';">' . $data[$i]['nombre'] . '</span>';
            $data[$i]['acciones'] =
                '<a class="btn btn-danger" href="#" onclick="verReporte(' . $data[$i]['id'] . ')">
                    <i class="fas fa-file-pdf"></i>
                </a>';
        }
        echo json_encode($data);
        die();
    }
}

?>