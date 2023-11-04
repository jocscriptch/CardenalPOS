<?php
class MedidasModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    public function getMedidas($estado)
    {
        $sql = "SELECT * FROM tbmedidas WHERE estado = $estado";
        return $this->selectAll($sql);
    }

    public function getOnlyMedidas($estado)
    {
        $sql = "SELECT medida FROM tbmedidas WHERE estado = $estado";
        return $this->selectAll($sql);
    }

    public function getIdByNombre($medida)
    {
        $sql = "SELECT id FROM tbmedidas WHERE medida = '$medida'";
        return $this->select($sql);
    }

    public function registrar($nombre, $abreviatura)
    {
        $sql = "INSERT INTO tbmedidas (medida, abreviatura) VALUES (?,?)";
        $array = array($nombre, $abreviatura);
        return $this->insertar($sql, $array);
    }

    public function getValidar($campo, $valor, $accion, $id)
    {
        if ($accion == 'registrar' && $id == 0) {
            $sql = "SELECT id FROM tbmedidas WHERE $campo = '$valor'";

        }else{
            $sql = "SELECT id FROM tbmedidas WHERE $campo = '$valor' AND id != $id";
        }
        return $this->select($sql);
    }

    public function eliminar($estado, $idMedida)
    {
        $sql = "UPDATE tbmedidas SET estado = ? WHERE id = ?";
        $array = array($estado, $idMedida);
        return $this->save($sql, $array);
    }

    public function editar($idMedida)
    {
        $sql = "SELECT * FROM tbmedidas WHERE id = $idMedida";
        return $this->select($sql);
    }

    //para actualizar las medidas
    public function actualizar($nombre, $abreviatura, $id)
    {
        $sql = "UPDATE tbmedidas SET medida=?, abreviatura=? WHERE id=?";
        $array = array($nombre, $abreviatura, $id);
        return $this->save($sql, $array);
    }
}
?>