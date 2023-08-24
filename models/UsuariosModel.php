<?php
class UsuariosModel extends Query{
    public function __construct() {
        parent::__construct();
    }
    public function getUsuarios($estado)
    {
        $sql = "SELECT CONCAT(nombre, ' ', apellido) AS nombres, correo, telefono, direccion, rol FROM usuarios WHERE estado = $estado";
        return $this->selectAll($sql);

    }
    public function registrar($nombres, $apellidos,
    $email, $telefono, $direccion, $clave, $rol)
    {
        $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, clave, rol) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $array = array($nombres, $apellidos, $email, $telefono, $direccion, $clave, $rol);
        return $this->insertar($sql, $array);
    }

    public function getValidar($campo, $valor)
    {
        $sql = "SELECT * FROM usuarios WHERE $campo = '$valor'";
        return $this->select($sql);
    }
}
?>