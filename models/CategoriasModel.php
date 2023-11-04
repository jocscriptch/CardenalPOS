<?php
class CategoriasModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCategorias($estado)
    {
        $sql = "SELECT * FROM tbcategorias WHERE estado = $estado";
        return $this->selectAll($sql);
    }

    public function getOnlyCategorias($estado)
    {
        $sql = "SELECT categoria FROM tbcategorias WHERE estado = $estado";
        return $this->selectAll($sql);
    }
    
    public function getIdByNombre($categoria)
    {
        $sql = "SELECT id FROM tbcategorias WHERE categoria = '$categoria'";
        return $this->select($sql);
    }

    public function registrar($categoria)
    {
        $sql = "INSERT INTO tbcategorias (categoria) VALUES (?)";
        $array = array($categoria);
        return  $this->insertar($sql, $array);
    }
    public function getValidar($campo, $valor, $accion, $id)
    {
        if ($accion == 'registrar' && $id == 0) {
            $sql = "SELECT id FROM tbcategorias WHERE $campo = '$valor'";

        }else{
            $sql = "SELECT id FROM tbcategorias WHERE $campo = '$valor' AND id != $id";
        }
        return $this->select($sql);
    }

    public function eliminar($estado, $idCategoria)
    {
        $sql = "UPDATE tbcategorias SET estado = ? WHERE id = ?";
        $array = array($estado, $idCategoria);
        return $this->save($sql, $array);
    }

    public function editar($idCategoria)
    {
        $sql = "SELECT * FROM tbcategorias WHERE id = $idCategoria";
        return $this->select($sql);
    }

    
    public function actualizar($categoria, $id)
    {
        $sql = "UPDATE tbcategorias SET categoria = ? WHERE id = ?";
        $array = array($categoria, $id);
        return  $this->save($sql, $array);
    }
}

?>