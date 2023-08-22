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
}
?>