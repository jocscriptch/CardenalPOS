<?php

require 'vendor/autoload.php';
use Dompdf\Dompdf;
use FontLib\Table\Type\name;
class Admin extends Controller
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
        $this->idUsuario = $_SESSION['id_usuario'];
    }

    //reportes graficos
    public function index()
    {
        $data['title'] = 'Panel Administrativo';
        $data['script'] = 'index.js';
        $data['usuarios'] = $this->model->getTotales('tbusuarios');
        $data['clientes'] = $this->model->getTotales('tbclientes');
        $data['proveedores'] = $this->model->getTotales('tbproveedor');
        $data['productos'] = $this->model->getTotales('tbproductos');
        $data['top'] = $this->model->topProductos(3);
        $data['nuevos'] = $this->model->nuevosProductos(6);
        $this->views->getView('admin', 'home', $data);
    }

    //datos de la empresa
    public function datos()
    {
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        $data['title'] = 'Datos del Negocio';
        $data['script'] = 'admin.js';
        $data['empresa'] = $this->model->getData();
        $this->views->getView('admin', 'index', $data);
    }

    //modificar datos de la empresa
    public function modificar()
    {
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        if (isset($_POST)) {
            //accediento a los campos nombres del formulario index.php
            $rut = strClean($_POST['rut']);
            $nombre = strClean($_POST['nombre']);
            $telefono = strClean($_POST['telefono']);
            $correo = strClean($_POST['email']);
            $direccion = strClean($_POST['direccion']);
            $impuesto = strClean($_POST['impuesto']);
            $mensaje = strClean($_POST['mensaje']);
            $logo = $_FILES['foto'];
            $id = strClean($_POST['id']);

            if (empty($rut)) {
                $res = array('msg' => 'IDENTIFICACIÓN ES REQUERIDA', 'type' => 'warning');

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
                    if(!empty($logo['name'])){
                        $directorio = 'assets/images/logo.png';
                        move_uploaded_file($logo['tmp_name'], $directorio);
                    }
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

    //reporte graficos
    public function comparacion($anio)
    {
        $desde = $anio . '-01-01';
        $hasta = $anio . '-12-31';

        $data['venta'] = $this->model->calcularVentasCompras('tbventas', $desde, $hasta, $this->idUsuario);
        $data['compra'] = $this->model->calcularVentasCompras('tbcompras', $desde, $hasta, $this->idUsuario);

        $data['totalVentas'] = $this->model->totalVentasCompras('tbventas', $desde, $hasta, $this->idUsuario);
        $data['totalCompras'] = $this->model->totalVentasCompras('tbcompras', $desde, $hasta, $this->idUsuario);

        echo json_encode($data);
        die();
    }
    public function topProductos()
    {
        $data = $this->model->topProductos(3);
        echo json_encode($data);
        die();
    }

    public function ventas($anio)
    {
        $desde = $anio . '-01-01';
        $hasta = $anio . '-12-31';

        $data = $this->model->calcularVentas($desde, $hasta, $this->idUsuario);
        echo json_encode($data);
        die();
    }

    public function minimosProductos()
    {
        $data = $this->model->minimosProductos();
        echo json_encode($data);
        die();
    }

    //reporte pdf
    public function topProductosPdf()
    {
        ob_start();
        $data['title'] = 'Reporte de Top Productos';
        $data['empresa'] = $this->model->getEmpresa();
        $data['productos'] = $this->model->topProductos(20);
        $this->views->getView('reportes', 'topProductos', $data);
        $html = ob_get_clean();
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'vertical');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('reporte.pdf', array('Attachment' => false));
    }

    public function stockMinimoPdf()
    {
        ob_start();
        $data['title'] = 'Reporte de StockMinimo';
        $data['empresa'] = $this->model->getEmpresa();
        $data['productos'] = $this->model->minimosProductosPDF();
        $this->views->getView('reportes', 'stockMinimo', $data);
        $html = ob_get_clean();
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'vertical');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('reporte.pdf', array('Attachment' => false));
    }
    public function recientesPdf()
    {
        ob_start();
        $data['title'] = 'Reporte de StockMinimo';
        $data['empresa'] = $this->model->getEmpresa();
        $data['productos'] = $this->model->nuevosProductos(20);
        $this->views->getView('reportes', 'recientes', $data);
        $html = ob_get_clean();
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'vertical');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream('reporte.pdf', array('Attachment' => false));
    }

    // logs 
    public function logs(){
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        $data['title'] = 'Logs De Acceso';
        $data['script'] = 'logs.js';
        $this->views->getView('admin', 'logs', $data);
    }

    public function listarLogs(){
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        $data = $this->model->listarLogs();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function limpiarLogs(){
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        $data = $this->model->limpiarLogs();
        if(empty($data)){
            $res = array('msg' => 'LOGS LIMPIADOS', 'type' => 'success');
        }else{
            $res = array('msg' => 'ERROR AL LIMPIAR', 'type' => 'error');
        }
        echo json_encode($res);
        die();
    }

    public function permisos(){
        $data['title'] = 'Permisos';
        $this->views->getView('admin', 'permisos', $data);
    }
}