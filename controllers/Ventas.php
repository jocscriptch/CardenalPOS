<?php
require 'vendor/autoload.php';

use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Dompdf\Dompdf;

class Ventas extends Controller
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
        $data['title'] = 'Ventas';
        $data['script'] = 'ventas.js';
        $data['busqueda'] = 'busqueda.js';
        $data['carrito'] = 'posVenta';
        $resultSerie = $this->model->getSerie();
        $serie = ($resultSerie['serietotal'] == null) ? 1 : $resultSerie['serietotal'] + 1;
        $data['serie'] = $this->generarNumeros($serie, 1, 8);
        $this->views->getView('ventas', 'index', $data);
    }

    public function registrarVenta()
    {
        $json = file_get_contents('php://input');
        $datos = json_decode($json, true);
        $array['productos'] = array();
        $subtotal = 0;

        if (!empty($datos['productos'])) {
            $fecha = date('Y-m-d');
            $hora = date('H:i:s');
            $metodo = $datos['metodo'];

            $resultSerie = $this->model->getSerie();
            $numSerie = ($resultSerie['serietotal'] == null) ? 1 : $resultSerie['serietotal'] + 1;

            $serie = $this->generarNumeros($numSerie, 1, 8);
            $idCliente = $datos['idCliente'];

            if (empty($idCliente)) {
                $res = array('msg' => 'CLIENTE REQUERIDO', 'type' => 'warning');
            } else if (empty($metodo)) {
                $res = array('msg' => 'METODO DE PAGO REQUERIDO', 'type' => 'warning');
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
                $venta = $this->model->registrarVenta(
                    $datosProductos,
                    $subtotal,
                    $iva,
                    $granTotal,
                    $fecha,
                    $hora,
                    $metodo,
                    $serie[0],
                    $idCliente,
                    $this->idUsuario
                );

                if ($venta > 0) {
                    foreach ($datos['productos'] as $producto) {
                        $result = $this->model->getProducto($producto['id']);
                        // Actualizar stock
                        $nuevaCantidad = $result['cantidad'] - $producto['cantidad'];
                        $totalVentas = $result['ventas'] + $producto['cantidad'];
                        $this->model->actualizarStock($nuevaCantidad, $totalVentas, $result['id']);

                        //movimientos
                        $movimiento = 'Venta N°: ' . $venta;
                        $cantidad = $producto['cantidad'];
                        $this->model->registrarMovimiento(
                            $movimiento,
                            'salida',
                            $cantidad,
                            $nuevaCantidad,
                            $producto['id'],
                            $this->idUsuario
                        );
                    }
                    if ($metodo == 'CREDITO') {
                        $monto = $granTotal;
                        $this->model->registrarCredito($monto, $fecha, $hora, $venta);
                    }
                    // if($datos['impresion']){
                    //     $this->impresionDirecta($venta);
                    // }
                    $res = array('msg' => 'VENTA REGISTRADA', 'type' => 'success', 'idVenta' => $venta);
                } else {
                    $res = array('msg' => 'ERROR AL VENTA COMPRA', 'type' => 'error');
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
        $idVenta = $array[1];
        $data['title'] = 'Reporte';
        $data['empresa'] = $this->model->getEmpresa();
        $data['venta'] = $this->model->getVenta($idVenta);
        if (empty($data['venta'])) {
            echo 'Pagina No Encontrada';
            exit;
        }
        $this->views->getView('ventas', $tipo, $data);
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
        $dompdf->render();
        $dompdf->stream('reporte.pdf', array("Attachment" => false));
    }


    public function listar()
    {
        $data = $this->model->getVentas();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 1) {
                $data[$i]['acciones'] =
                    '<div class="text-center">
                    <a class="btn btn-primary" href="#" onclick="verReporte(' . $data[$i]['id'] . ')"><i class="fas fa-file-pdf"></i></a>
                    <a class="btn btn-danger" href="#" onclick="anularVenta(' . $data[$i]['id'] . ')"><i class="fas fa-trash text-white"></i></a>
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

    public function anular($idVenta)
    {
        if (isset($_GET) && is_numeric($idVenta)) {
            $data = $this->model->anular($idVenta);
            if ($data == 1) {
                $resultVenta = $this->model->getVenta($idVenta);
                $ventaProducto = json_decode($resultVenta['productos'], true);
                foreach ($ventaProducto as $producto) {
                    $result = $this->model->getProducto($producto['id']);
                    $nuevaCantidad = $result['cantidad'] + $producto['cantidad'];
                    $totalVentas = $result['ventas'] - $producto['cantidad'];
                    $this->model->actualizarStock($nuevaCantidad, $totalVentas, $producto['id']);

                    //movimientos
                    $movimiento = 'Devolucion Venta N°: ' . $idVenta;
                    $this->model->registrarMovimiento(
                        $movimiento,
                        'entrada',
                        $producto['cantidad'],
                        $nuevaCantidad,
                        $producto['id'],
                        $this->idUsuario
                    );
                }
                if ($resultVenta['metodo'] == 'CREDITO') {
                    $this->model->anularCredito($idVenta);
                }
                $res = array('msg' => 'VENTA ANULADA', 'type' => 'success');
            } else {
                $res = array('msg' => 'ERROR AL ANULAR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }

    // public function impresionDirecta($idVenta)
    // {
    //     $empresa['empresa'] = $this->model->getEmpresa();
    //     $venta['venta'] = $this->model->getVenta($idVenta);

    //     $nombre_impresora = "POS-58-Series";
    //     $connector = new WindowsPrintConnector($nombre_impresora);
    //     $printer = new Printer($connector);

    //     # Vamos a alinear al centro lo próximo que imprimamos
    //     $printer->setJustification(Printer::JUSTIFY_CENTER);

    //     //configuracion de la impresion logotipo
    //     try {
    //         $logo = EscposImage::load("assest/images/logoPos7.png", false);
    //         $printer->bitImage($logo);
    //     } catch (Exception $e) { /*No hacemos nada si hay error*/
    //     }


    //     //Ahora vamos a imprimir un encabezado

    //     $printer->text($empresa['nombre'] . "\n");
    //     $printer->text('Identificacion: ' . $empresa['id_empresa'] . "\n");
    //     $printer->text('Telefono: ' . $empresa['telefono'] . "\n");
    //     $printer->text('Direccion: ' . $empresa['direccion'] . "\n");
    //     #La fecha también
    //     $printer->text(date("Y-m-d H:i:s") . "\n\n");

    //     #Datos del cliente
    //     $printer->text('Datos del Cliente' . "\n");
    //     $printer->text('--------------------' . "\n");
    //     /*Alinear a la izquierda para la cantidad y el nombre*/
    //     $printer->setJustification(Printer::JUSTIFY_LEFT);
    //     $printer->text($venta['identidad'] . ': ' . $venta['num_identidad'] . "\n");
    //     $printer->text('Nombre: ' . $venta['nombre'] . "\n");
    //     $printer->text('Telefono: ' . $venta['telefono'] . "\n");
    //     $printer->text('Direccion: ' . $venta['direccion'] . "\n\n");

    //     #Detalle de los productos
    //     $printer->setJustification(Printer::JUSTIFY_CENTER);
    //     $printer->text('Detalle del Producto' . "\n");
    //     $printer->text('--------------------' . "\n");
    //     $productos = json_decode($venta['productos'], true);
    //     foreach ($productos as $producto) {

    //         $printer->setJustification(Printer::JUSTIFY_LEFT);
    //         $printer->text($producto['cantidad'] . "x" . $producto['nombre'] . "\n");

    //         /*Y a la derecha para el importe*/
    //         $printer->setJustification(Printer::JUSTIFY_RIGHT);
    //         $printer->text(MONEDA . number_format($producto['precio'],2) . "\n");
    //     }

    //     # Terminamos de imprimir los productos, ahora va el total
    //     $printer->text("--------\n");
    //     $printer->text("TOTAL: " .MODEDA . number_format( $venta['total'], 2). "\n\n");


    //     #Podemos poner también un pie de página
    //     $printer->text($empresa['mensaje']);

    //     # Alimentamos el papel 3 veces*/
    //     $printer->feed(3);
    //     /*
    //         Cortamos el papel. Si nuestra impresora no tiene
    //         soporte para ello, no generará ningún error
    //     */
    //     $printer->cut();
    //     /*
    //         Por medio de la impresora mandamos un pulso.
    //         Esto es útil cuando la tenemos conectada
    //         por ejemplo a un cajón
    //     */
    //     $printer->pulse();
    //     /*
    //         Para imprimir realmente, tenemos que "cerrar"
    //         la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
    //     */
    //     $printer->close();
    // }

    public function verificarStock($idProducto)
    {
        $data = $this->model->getProducto($idProducto);
        echo json_encode($data);
        die();
    }

    public function generarNumeros($start, $count, $digits)
    {
        $result = array();
        for ($n = $start; $n < $start + $count; $n++) {
            $result[] = str_pad($n, $digits, "0", STR_PAD_LEFT);
        }
        return $result;
    }

}

?>