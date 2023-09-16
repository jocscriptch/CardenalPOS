<?php
class AdminModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }
    public function getData()
    {
        $sql = "SELECT * FROM tbconfiguracion";
        return $this->select($sql);
    }

    public function actualizar($rut, $nombre, $telefono, $correo,
    $direccion, $impuesto, $mensaje, $id)
    {
        $sql = "UPDATE tbconfiguracion SET id_empresa=?, nombre=?, telefono=?,
        correo=?, direccion=?, impuesto=?, mensaje=? WHERE id=?";

        $array = array($rut, $nombre, $telefono,
        $correo, $direccion, $impuesto, $mensaje, $id);

        return $this->save($sql, $array);
    }
}
?>