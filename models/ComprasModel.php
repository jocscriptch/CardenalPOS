<?php
class ComprasModel extends Query
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

    public function registrarCompra(
        $productos,
        $subtotal,
        $iva,
        $total,
        $fecha,
        $hora,
        $serie,
        $idProveedor,
        $idUsuario
    ) {
        $sql = "INSERT INTO tbcompras(productos, subtotal, iva, total, fecha, hora, serie, id_proveedor, id_usuario)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $array = array($productos, $subtotal, $iva, $total, $fecha, $hora, $serie, $idProveedor, $idUsuario);
        return $this->insertar($sql, $array);
    }

    public function getEmpresa()
    {
        $sql = "SELECT * FROM tbconfiguracion";
        return $this->select($sql);
    }

    public function getCompra($idCompra)
    {
        $sql = "SELECT c.*, p.nombre, p.telefono, p.direccion FROM tbcompras c INNER JOIN tbproveedor p
        ON c.id_proveedor = p.id WHERE c.id = '$idCompra'";
        return $this->select($sql);
    }

    //actualizar stock
    public function actualizarStock($nuevaCantidad, $idProducto)
    {
        $sql = "UPDATE tbproductos SET cantidad = ? WHERE id = ?";
        $array = array($nuevaCantidad, $idProducto);
        return $this->save($sql, $array);
    }

    public function getCompras()
    {
        $sql = "SELECT c.*, p.nombre FROM tbcompras c INNER JOIN tbproveedor p
        ON c.id_proveedor = p.id ";
        return $this->selectAll($sql);
    }

    public function anular($idCompra)
    {
        $sql = "UPDATE tbcompras SET estado = ? WHERE id = ?";
        $array = array(0, $idCompra);
        return $this->save($sql, $array);
    }

    public function registrarMovimiento($movimiento, $accion, $cantidad, $stockActual, $idProducto, $idUsuario)
    {
        $sql = "INSERT INTO tbinventario (movimiento, accion, cantidad, stock_actual, id_producto, id_usuario)
        VALUES (?, ?, ?, ?, ?, ?)";
        $array = array($movimiento, $accion, $cantidad, $stockActual, $idProducto, $idUsuario);
        return $this->insertar($sql, $array);
    }
}
?>