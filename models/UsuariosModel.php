<?php
class UsuariosModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }
    public function getUsuarios($estado)
    {
        $sql = "SELECT id, CONCAT(nombre, ' ', apellido) AS nombres, correo, telefono, direccion, rol FROM tbusuarios WHERE estado = $estado";
        return $this->selectAll($sql);
    }
    public function registrar($nombres, $apellidos,
    $email, $telefono, $direccion, $clave, $rol)
    {
        $sql = "INSERT INTO tbusuarios (nombre, apellido, correo, telefono, direccion, clave, rol) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $array = array($nombres, $apellidos, $email, $telefono, $direccion, $clave, $rol);
        return $this->insertar($sql, $array);
    }

    public function getValidar($campo, $valor, $accion, $id)
    {
        if ($accion == 'registrar' && $id == 0) {
            $sql = "SELECT id, correo, telefono FROM tbusuarios WHERE $campo = '$valor'";

        }else{
            $sql = "SELECT id, correo, telefono FROM tbusuarios WHERE $campo = '$valor' AND id != $id";
        }
        return $this->select($sql);
    }

    public function eliminar($estado, $id)
    {
        $sql = "UPDATE tbusuarios SET estado = ? WHERE id = ?";
        $array = array($estado, $id);
        return $this->save($sql, $array);
    }

    public function editar($id)
    {
        $sql = "SELECT id, nombre, apellido, correo, telefono, direccion, perfil, clave, fecha, rol FROM tbusuarios WHERE id = $id";
        return $this->select($sql);
    }

    public function actualizar($nombres, $apellidos, $email,
    $telefono, $direccion, $rol, $id)
    {
        $sql = "UPDATE tbusuarios SET nombre=?, apellido=?, correo=?, telefono=?, direccion=?, rol=? WHERE id=?";
        $array = array($nombres, $apellidos, $email, $telefono, $direccion, $rol, $id);
        return $this->save($sql, $array);
    }
    public function modificarDatos($nombre, $apellidos, $correo,
    $telefono, $direccion, $clave, $perfil, $id)
    {
        $sql = "UPDATE tbusuarios SET nombre=?, apellido=?, correo=?, telefono=?, direccion=?, clave=?, perfil=? WHERE id=?";
        $array = array($nombre, $apellidos, $correo, $telefono, $direccion, $clave, $perfil, $id);
        return $this->save($sql, $array);
    }

     //registrar log
    //  public function registrarAcceso($evento, $ip, $detalle)
    //  {
    //      $sql = "INSERT INTO acceso (evento, ip, detalle) VALUES (?,?,?)";
    //      $array = array($evento, $ip, $detalle);
    //      return $this->insertar($sql, $array);
    //  }
}
?>