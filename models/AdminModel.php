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

    public function getTotales($table)
    {
        $sql = "SELECT COUNT(*) AS total FROM $table WHERE estado = 1";
        return $this->select($sql);
    }

    public function calcularVentasCompras($table, $desde, $hasta, $idUsuario)
    {
        $sql = "SELECT SUM(IF(MONTH(fecha) = 1, total, 0)) AS ene,
        SUM(IF(MONTH(fecha) = 2, total, 0)) AS feb,
        SUM(IF(MONTH(fecha) = 3, total, 0)) AS mar,
        SUM(IF(MONTH(fecha) = 4, total, 0)) AS abr,
        SUM(IF(MONTH(fecha) = 5, total, 0)) AS may,
        SUM(IF(MONTH(fecha) = 6, total, 0)) AS jun,
        SUM(IF(MONTH(fecha) = 7, total, 0)) AS jul,
        SUM(IF(MONTH(fecha) = 8, total, 0)) AS ago,
        SUM(IF(MONTH(fecha) = 9, total, 0)) AS sep,
        SUM(IF(MONTH(fecha) = 10, total, 0)) AS oct,
        SUM(IF(MONTH(fecha) = 11, total, 0)) AS nov,
        SUM(IF(MONTH(fecha) = 12, total, 0)) AS dic
        FROM $table WHERE fecha BETWEEN '$desde' AND '$hasta' AND id_usuario = $idUsuario";
        return $this->select($sql);
    }

    public function totalVentasCompras($table, $desde, $hasta, $idUsuario)
    {
        $sql = "SELECT COUNT(*) AS total FROM $table WHERE fecha BETWEEN '$desde'
        AND '$hasta' AND estado = 1 AND id_usuario = $idUsuario";
        return $this->select($sql);
    }

   
    public function topProductos($cantidad)
    {
        $sql = "SELECT p.*, c.categoria FROM tbproductos p INNER JOIN
        tbcategorias c ON p.id_categoria = c.id ORDER BY p.ventas DESC LIMIT $cantidad";
        return $this->selectAll($sql);
    }

    public function nuevosProductos($cantidad)
    {
        $sql = "SELECT p.*, c.categoria FROM tbproductos p INNER JOIN
        tbcategorias c ON p.id_categoria = c.id ORDER BY p.id DESC LIMIT $cantidad";
        return $this->selectAll($sql);
    }

    
    public function calcularVentas($desde, $hasta, $idUsuario)
    {
        $sql = "SELECT SUM(IF(MONTH(fecha) = 1, total, 0)) AS ene,
        SUM(IF(MONTH(fecha) = 2, total, 0)) AS feb,
        SUM(IF(MONTH(fecha) = 3, total, 0)) AS mar,
        SUM(IF(MONTH(fecha) = 4, total, 0)) AS abr,
        SUM(IF(MONTH(fecha) = 5, total, 0)) AS may,
        SUM(IF(MONTH(fecha) = 6, total, 0)) AS jun,
        SUM(IF(MONTH(fecha) = 7, total, 0)) AS jul,
        SUM(IF(MONTH(fecha) = 8, total, 0)) AS ago,
        SUM(IF(MONTH(fecha) = 9, total, 0)) AS sep,
        SUM(IF(MONTH(fecha) = 10, total, 0)) AS oct,
        SUM(IF(MONTH(fecha) = 11, total, 0)) AS nov,
        SUM(IF(MONTH(fecha) = 12, total, 0)) AS dic
        FROM tbventas WHERE fecha BETWEEN '$desde' AND '$hasta' AND id_usuario = $idUsuario";
        return $this->select($sql);
    }
    public function minimosProductos()
    {
        $sql = "SELECT descripcion, cantidad FROM tbproductos WHERE cantidad <= 5 LIMIT 4";
        return $this->selectAll($sql);
    }

    //reporte pdf
    public function minimosProductosPDF()
    {
        $sql = "SELECT * FROM tbproductos WHERE cantidad <= 10";
        return $this->selectAll($sql);
    }

    public function getEmpresa()
    {
        $sql = "SELECT * FROM tbconfiguracion";
        return $this->select($sql);
    }

    public function listarLogs(){
        $sql = "SELECT * FROM tbacceso";
        return $this->selectAll($sql);
    }

    public function limpiarLogs(){
        $sql = "TRUNCATE tbacceso";
        return $this->select($sql);
    }

}
?>