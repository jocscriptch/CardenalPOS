<?php
class CotizacionesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getProducto($idProducto)
    {
        $sql = "SELECT * FROM tbproductos WHERE id = '$idProducto'";
        return $this->select($sql);
    }

    public function registrarCotizacion(
        $productos,
        $subtotal,
        $iva,
        $granTotal,
        $fecha,
        $hora,
        $metodo,
        $validez,
        $idCliente
    ) {
        $sql = "INSERT INTO tbcotizaciones (productos, subtotal, iva, total,
        fecha, hora, metodo, validez, id_cliente)
        VALUES (?,?,?,?,?,?,?,?,?)";

        $array = array(
            $productos,
            $subtotal,
            $iva,
            $granTotal,
            $fecha,
            $hora,
            $metodo,
            $validez,
            $idCliente
        );
        return $this->insertar($sql, $array);
    }
    public function getEmpresa()
    {
        $sql = "SELECT * FROM tbconfiguracion";
        return $this->select($sql);
    }
    public function getCotizacion($idCotizacion)
    {
        $sql = "SELECT ct.*, cl.identidad, cl.num_identidad, cl.nombre, cl.telefono, cl.direccion
        FROM tbcotizaciones ct INNER JOIN tbclientes cl ON ct.id_cliente = cl.id
        WHERE ct.id = $idCotizacion";
        return $this->select($sql);
    }

    public function getCotizaciones()
    {
        $sql = "SELECT ct.*, cl.nombre FROM tbcotizaciones ct INNER JOIN tbclientes cl
        ON ct.id_cliente = cl.id";
        return $this->selectAll($sql);
    }
}
?>