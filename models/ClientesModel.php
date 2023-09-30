<?php
class ClientesModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getClientes($estado)
    {
        $sql = "SELECT * FROM tbclientes WHERE estado = $estado";
        return $this->selectAll($sql);
    }
    
    public function registrar($identidad, $num_identidad, $nombre, $telefono, $correo, $direccion)
    {
        $sql = "INSERT INTO tbclientes (identidad, num_identidad, nombre, telefono, correo, direccion) VALUES (?,?,?,?,?,?)";
        $array = array($identidad, $num_identidad, $nombre, $telefono, $correo, $direccion);
        return $this->insertar($sql, $array);
    }

    public function getValidar($campo, $valor, $accion, $id)
    {
        if ($accion == 'registrar' && $id == 0) {
            $sql = "SELECT id FROM tbclientes WHERE $campo = '$valor'";

        }else{
            $sql = "SELECT id FROM tbclientes WHERE $campo = '$valor' AND id != $id";
        }
        return $this->select($sql);
    }

    public function eliminar($estado, $idCliente)
    {
        $sql = "UPDATE tbclientes SET estado = ? WHERE id = ?";
        $array = array($estado, $idCliente);
        return $this->save($sql, $array);
    }

    public function editar($idCliente)
    {
        $sql = "SELECT * FROM tbclientes WHERE id = $idCliente";
        return $this->select($sql);
    }

    public function actualizar($identidad, $num_identidad, $nombre,
    $telefono, $correo, $direccion, $id)
    {
        $sql = "UPDATE tbclientes SET identidad = ?, num_identidad = ?,
        nombre = ?, telefono = ?, correo = ?, direccion = ? WHERE id = ?";
        $array = array($identidad, $num_identidad, $nombre, $telefono, $correo, $direccion, $id);
        return $this->save($sql, $array);
    }
}

?>