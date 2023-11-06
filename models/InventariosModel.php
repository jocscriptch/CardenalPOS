<?php
class InventariosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getMovimientos($idUsuario)
    {
        $sql = "SELECT i.*, p.descripcion FROM tbinventario i INNER JOIN
        tbproductos p ON i.id_producto = p.id WHERE i.id_usuario = $idUsuario";
        return $this->selectAll($sql);
    }
    public function getMovimientosMes($anio, $mes, $idUsuario)
    {
        $sql = "SELECT i.*, p.descripcion FROM tbinventario i INNER JOIN tbproductos p
        ON i.id_producto = p.id WHERE MONTH(i.fecha) = $mes AND YEAR(i.fecha) = $anio
        AND i.id_usuario = $idUsuario";
        return $this->selectAll($sql);
    }

    public function getEmpresa()
    {
        $sql = "SELECT * FROM tbconfiguracion";
        return $this->select($sql);
    }

    public function getProducto($idProducto)
    {
        $sql = "SELECT * FROM tbproductos WHERE id = $idProducto";
        return $this->select($sql);
    }

    public function procesarAjuste($cantidad, $idProducto)
    {
        $sql = "UPDATE tbproductos SET cantidad = ? WHERE id = ?";
        $array = array($cantidad, $idProducto);
        return $this->save($sql, $array);
    }

    //movimiento
    public function registrarMovimiento(
        $movimiento,
        $accion,
        $cantidad,
        $stockActual,
        $idProducto,
        $idUsuario
    ) {
        $sql = "INSERT INTO tbinventario (movimiento, accion, cantidad,
        stock_actual, id_producto, id_usuario) VALUES (?,?,?,?,?,?)";
        $array = array($movimiento, $accion, $cantidad, $stockActual, $idProducto, $idUsuario);
        return $this->insertar($sql, $array);
    }

    public function getKardex($idProducto, $idUsuario)
    {
        $sql = "SELECT i.accion, i.cantidad, i.stock_actual, i.fecha, p.descripcion
        FROM tbinventario i INNER JOIN tbproductos p ON i.id_producto = p.id
        WHERE i.id_producto = $idProducto AND i.id_usuario = $idUsuario";
        return $this->selectAll($sql);
    }
}
?>