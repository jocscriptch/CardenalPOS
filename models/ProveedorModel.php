<?php

class ProveedorModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getProveedores($estado)
    {
        $sql = "SELECT * FROM tbproveedor WHERE estado = $estado";
        return $this->selectAll($sql);
    }

    public function registrar($nombre, $telefono, $correo, $direccion)
    {
        $sql = "INSERT INTO tbproveedor(nombre, telefono, correo, direccion) VALUES(?,?,?,?)";
        $data = array($nombre, $telefono, $correo, $direccion);
        return $this->insertar($sql, $data);
    }

    public function getValidar($campo, $valor, $accion, $id)
    {
        if($accion == 'registrar' && $id == 0){
            $sql = "SELECT * FROM tbproveedor WHERE $campo = '$valor'";
        }else{
            $sql = "SELECT * FROM tbproveedor WHERE $campo = '$valor' AND id != $id";
        }
        return $this->select($sql);
    }

    public function eliminar($estado, $idProveedor)
    {
        $sql = "UPDATE tbproveedor SET estado = ? WHERE id = ?";
        $data = array($estado, $idProveedor);
        return $this->save($sql, $data);
    }

    public function editar($idProveedor)
    {
        $sql = "SELECT * FROM tbproveedor WHERE id = $idProveedor";
        return $this->select($sql);
    }

    public function actualizar($nombre, $telefono, $correo, $direccion, $id)
    {
        $sql = "UPDATE tbproveedor SET nombre = ?, telefono = ?, correo = ?, direccion = ? WHERE id = ?";
        $data = array($nombre, $telefono, $correo, $direccion, $id);
        return $this->save($sql, $data);
    }
}
?>