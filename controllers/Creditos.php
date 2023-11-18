<?php
require 'vendor/autoload.php';
use Dompdf\Dompdf;
class Creditos extends Controller
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
        $data['title'] = 'Administrar Creditos';
        $data['script'] = 'creditos.js';
        $this->views->getView('creditos', 'index', $data);
    }

    public function listar()
    {
        $data = $this->model->getCreditos();
        for ($i = 0; $i < count($data); $i++) {
            $credito = $this->model->getCredito($data[$i]['id']);
            $result = $this->model->getAbono($data[$i]['id']);
            $abonado = ($result['total'] == null) ? 0 : $result['total'];
            $restante = $data[$i]['monto'] - $abonado;

            if ($restante < 1 && $credito['estado'] == 1) {
                $this->model->actualizarCredito(0, $data[$i]['id']);
            }
            $data[$i]['monto'] = number_format($data[$i]['monto'], 2);
            $data[$i]['abonado'] = number_format($abonado, 2);
            $data[$i]['restante'] = number_format($restante, 2);
            $data[$i]['venta'] = 'N°: ' . $data[$i]['id_venta'];
            $data[$i]['acciones'] =
                '<a class="btn btn-danger" href="'.BASE_URL.'creditos/reporte/'.$data[$i]['id'].'" target="_blank">
                    <i class="fas fa-file-pdf"></i>
                </a>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function buscar()
    {
        $array = array();
        $valor = strClean($_GET['term']);
        $data = $this->model->buscarPorNombre($valor);
        foreach ($data as $row) {
            $resultAbono = $this->model->getAbono($row['id']);
            $abonado = ($resultAbono['total'] == null) ? 0 : $resultAbono['total'];
            //calcular restante  (monto - abono)
            $restante = $row['monto'] - $abonado;
            $result['monto'] = $row['monto'];
            $result['abonado'] = $abonado;
            $result['restante'] = $restante;
            $result['fecha'] = $row['fecha'];
            $result['id'] = $row['id'];
            $result['label'] = $row['nombre'];
            $result['telefono'] = $row['telefono'];
            $result['direccion'] = $row['direccion'];
            array_push($array, $result);
        }
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function registrarAbono()
    {
        $json = file_get_contents('php://input');
        $datos = json_decode($json, true);
        if (!empty($datos)) {
            $idCredito = strClean($datos['idCredito']);
            $monto = strClean($datos['monto_abonar']);
            $data = $this->model->registrarAbono($idCredito, $monto);
            if ($data > 0) {
                $res = array('msg' => 'ABONO REGISTRADO', 'type' => 'success');
            } else {
                $res = array('msg' => 'ERROR AL REGISTRAR', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'TODOS LOS CAMPOS SON REQUERIDOS', 'type' => 'warning');
        }
        echo json_encode($res);
        die();
    }

    public function reporte($idCredito)
    {
        ob_start();
        $data['title'] = 'Reporte';
        $data['empresa'] = $this->model->getEmpresa();
        $data['credito'] = $this->model->getCredito($idCredito);
        $data['abonos'] = $this->model->getAbonos($idCredito);
        if (empty($data['credito'])) {
            echo 'Pagina No Encontrada';
            exit;
        }
        $this->views->getView('creditos', 'reporte', $data);
        $html = ob_get_clean();

        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isJavascriptEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'vertical');
        
        $dompdf->render();
        $dompdf->stream('reporte.pdf', array("Attachment" => false));
    }

    public function listarAbonos()
    {
        $data = $this->model->getHistorialAbonos();
        for ($i=0; $i < count($data) ; $i++) {
            $data[$i]['credito'] = 'N°: '.$data[$i]['id_credito'];
        }
        echo json_encode($data);
        die();
    }
}
?>