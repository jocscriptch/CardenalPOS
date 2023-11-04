<?php
class ProductosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getProductos(int $estado)
    {
        $sql = "SELECT p.*, m.medida, c.categoria FROM tbproductos p
        INNER JOIN tbmedidas m ON p.id_medida = m.id
        INNER JOIN tbcategorias c ON p.id_categoria = c.id
        WHERE p.estado = $estado";

        return $this->selectAll($sql);
    }

    public function getDatos($table)
    {
        $sql = "SELECT * FROM $table WHERE estado = 1";
        return $this->selectAll($sql);
    }

    public function registrar(
        $codigo,
        $descripcion,
        $precio_compra,
        $precio_venta,
        $id_medida,
        $id_categoria,
        $foto
    ) {
        $sql = "INSERT INTO tbproductos(codigo, descripcion, precio_compra, precio_venta, id_medida,
         id_categoria, foto) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $array = array($codigo, $descripcion, $precio_compra, $precio_venta, $id_medida, $id_categoria, $foto);
        return $this->insertar($sql, $array);
    }

    public function registrarXML(
        $codigo,
        $descripcion,
        $precio_compra,
        $precio_venta,
        $id_medida,
        $id_categoria
    ) {
        $sql = "INSERT INTO tbproductos(codigo, descripcion, precio_compra, precio_venta, id_medida,
         id_categoria) VALUES (?, ?, ?, ?, ?, ?)";
        $array = array($codigo, $descripcion, $precio_compra, $precio_venta, $id_medida, $id_categoria);
        return $this->insertar($sql, $array);
    }

    public function getValidar($campo, $valor, $accion, $id)
    {
        if ($accion == 'registrar' && $id == 0) {
            $sql = "SELECT id FROM tbproductos WHERE $campo = '$valor'";

        } else {
            $sql = "SELECT id FROM tbproductos WHERE $campo = '$valor' AND id != $id";
        }
        return $this->select($sql);
    }

    public function eliminar($estado, $idProducto)
    {
        $sql = "UPDATE tbproductos SET estado = ? WHERE id = ?";
        $array = array($estado, $idProducto);
        return $this->save($sql, $array);
    }

    public function editar($idProducto)
    {
        $sql = "SELECT * FROM tbproductos WHERE id = $idProducto";
        return $this->select($sql);
    }

    public function actualizar(
        $codigo,
        $descripcion,
        $precio_compra,
        $precio_venta,
        $id_medida,
        $id_categoria,
        $foto,
        $id
    ) {
        $sql = "UPDATE tbproductos SET codigo=?, descripcion=?, precio_compra=?,
        precio_venta=?, id_medida=?,id_categoria=?, foto=? WHERE id = ?";
        $array = array(
            $codigo,
            $descripcion,
            $precio_compra,
            $precio_venta,
            $id_medida,
            $id_categoria,
            $foto,
            $id
        );
        return $this->save($sql, $array);
    }

    public function buscarPorCodigo($valor)
    {
        $sql = "SELECT id, cantidad FROM tbproductos WHERE codigo = '$valor'";
        return $this->select($sql);
    }

    public function buscarPorNombre($valor)
    {
        $sql = "SELECT id, descripcion, cantidad FROM tbproductos WHERE descripcion
        LIKE '%".$valor."%' AND estado = 1 LIMIT 10";
        return $this->selectAll($sql);
    }

}
?>