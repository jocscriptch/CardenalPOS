<?php
class HomeModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }
    public function getData($email)
    {
        $sql = "SELECT nombre, correo, clave FROM tbusuarios WHERE correo = '$email'";
        return $this->select($sql);
    }
}
?>