<?php
class ApartadosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getProducto($idProducto)
    {
        $sql = "SELECT * FROM tbproductos WHERE id = $idProducto";
        return $this->select($sql);
    }
    public function registrarApartado(
        $productos,
        $fecha_creado,
        $fecha_apartado,
        $fecha_retiro,
        $abono,
        $total,
        $color,
        $idCliente
    ) {
        $sql = "INSERT INTO tbapartados (productos, fecha_creado, fecha_apartado,
        fecha_retiro, abono, total, color, id_cliente) VALUES (?,?,?,?,?,?,?,?)";
        $array = array($productos, $fecha_creado, $fecha_apartado,
        $fecha_retiro, $abono, $total, $color, $idCliente);
        return $this->insertar($sql, $array);
    }

    public function getEmpresa()
    {
        $sql = "SELECT * FROM tbconfiguracion";
        return $this->select($sql);
    }
    public function getApartado($idApartado)
    {
        $sql = "SELECT ap.*, cl.identidad, cl.num_identidad, cl.nombre, cl.telefono, cl.direccion
        FROM tbapartados ap INNER JOIN tbclientes cl ON ap.id_cliente = cl.id WHERE ap.id = $idApartado";
        return $this->select($sql);
    }

    public function getApartados()
    {
        $sql = "SELECT ap.*, cl.nombre FROM tbapartados ap INNER JOIN tbclientes cl
        ON ap.id_cliente = cl.id";
        return $this->selectAll($sql);
    }

    public function procesarApartado($abono, $estado, $idApartado)
    {
        $sql = "UPDATE tbapartados SET abono = ?, estado = ? WHERE id = ?";
        $array = array($abono, $estado, $idApartado);
        return $this->save($sql, $array);
    }

    
    //actualizar stock
    public function actualizarStock($nuevaCantidad, $idProducto)
    {
        $sql = "UPDATE tbproductos SET cantidad = ? WHERE id = ?";
        $array = array($nuevaCantidad, $idProducto);
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