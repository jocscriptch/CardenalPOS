<?php
class Connection{
    private $conect;
    public function __construct() {
        $pdo = "mysql:host=" . HOST . ";dbname=" . DBNAME . ";" . CHARSET;
        try {
            $this->conect = new PDO($pdo, USER, PASS);
            $this->conect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo 'conectado';
        } catch (PDOException $e) {
            echo 'Error en la conexion: ' . $e->getMessage();
        }
    }
    public function connect()
    {
        return $this->conect;
    }
}

?>