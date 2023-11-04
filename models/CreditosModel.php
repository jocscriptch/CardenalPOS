<?php
class CreditosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCreditos()
    {
        $sql = "SELECT cr.*,  cl.nombre FROM tbcreditos cr INNER JOIN tbventas v
        ON cr.id = v.id INNER JOIN tbclientes cl ON v.id_cliente = cl.id";
        return $this->selectAll($sql);
    }

    public function getAbono($idCredito)
    {
        $sql = "SELECT SUM(abono) AS total FROM tbabonos WHERE id_credito = $idCredito";
        return $this->select($sql);
    }
   
    public function buscarPorNombre($valor)
    {
        $sql = "SELECT cr.*,  cl.nombre, cl.telefono, cl.direccion FROM tbcreditos cr
        INNER JOIN tbventas v ON cr.id = v.id INNER JOIN tbclientes cl ON v.id_cliente = cl.id
        WHERE cl.nombre LIKE '%".$valor."%' AND cr.estado = 1 LIMIT 10";
        return $this->selectAll($sql);
    }

    public function registrarAbono($idCredito, $monto)
    {
        $sql = "INSERT INTO tbabonos(id_credito, abono) VALUES (?,?)";
        $array = array($idCredito, $monto);
        return $this->insertar($sql, $array);
    }

    public function actualizarCredito($estado, $idCredito)
    {
        $sql = "UPDATE tbcreditos SET estado = ? WHERE id = ?";
        $array = array($estado, $idCredito);
        return $this->save($sql, $array);
    }

    public function getCredito($idCredito)
    {
        $sql = "SELECT cr.*, v.productos, cl.identidad, cl.num_identidad, cl.nombre,
        cl.telefono, cl.direccion FROM tbcreditos cr INNER JOIN tbventas v ON cr.id = v.id
        INNER JOIN tbclientes cl ON v.id_cliente = cl.id WHERE cr.id = $idCredito";
        return $this->select($sql);
    }

    public function getEmpresa()
    {
        $sql = "SELECT * FROM tbconfiguracion";
        return $this->select($sql);
    }

    public function getAbonos($idCredito)
    {
        $sql = "SELECT * FROM tbabonos WHERE id_credito = $idCredito";
        return $this->selectAll($sql);
    }

    public function getHistorialAbonos()
    {
        $sql = "SELECT * FROM tbabonos";
        return $this->selectAll($sql);
    }
}
?>