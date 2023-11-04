<?php
class VentasModel extends Query
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

    public function registrarVenta(
        $productos,
        $subtotal,
        $iva,
        $total,
        $fecha,
        $hora,
        $metodo,
        $serie,
        $idCliente,
        $idUsuario
    ) {
        $sql = "INSERT INTO tbventas (productos, subtotal, iva, total,
        fecha, hora, metodo,serie, id_cliente, id_usuario)
        VALUES (?,?,?,?,?,?,?,?,?,?)";

        $array = array(
            $productos,
            $subtotal,
            $iva,
            $total,
            $fecha,
            $hora,
            $metodo,
            $serie,
            $idCliente,
            $idUsuario
        );
        return $this->insertar($sql, $array);
    }

    public function actualizarStock($cantidad, $idProducto)
    {
        $sql = "UPDATE tbproductos SET cantidad = ? WHERE id = ?";
        $array = array($cantidad, $idProducto);
        return $this->save($sql, $array);
    }

    public function getEmpresa()
    {
        $sql = "SELECT * FROM tbconfiguracion";
        return $this->select($sql);
    }

    public function getVenta($idVenta)
    {
        $sql = "SELECT v.*, c.identidad, c.num_identidad, c.nombre, c.telefono, c.direccion
        FROM tbventas v INNER JOIN tbclientes c ON v.id_cliente = c.id WHERE v.id = '$idVenta'";
        return $this->select($sql);
    }

    public function getSerie()
    {
        $sql = "SELECT Max(id) AS serietotal FROM tbventas";
        return $this->select($sql);
    }

    public function registrarCredito($monto, $fecha, $hora, $idVenta)
    {
        $sql = "INSERT INTO tbcreditos (monto, fecha, hora, id_venta) VALUES (?,?,?,?)";
        $array = array($monto, $fecha, $hora, $idVenta);
        return $this->insertar($sql, $array);
    }

    public function getVentas()
    {
        $sql = "SELECT v.*, c.nombre FROM tbventas v INNER JOIN tbclientes c ON v.id_cliente = c.id";
        return $this->selectAll($sql);
    }

    public function anular($idVenta)
    {
        $sql = "UPDATE tbventas SET estado = ? WHERE id = ?";
        $array = array(0, $idVenta);
        return $this->save($sql, $array);
    }

    public function anularCredito($idVenta)
    {
        $sql = "UPDATE tbcreditos SET estado = ? WHERE id_venta = ?";
        $array = array(2, $idVenta);
        return $this->save($sql, $array);
    }

}
?>