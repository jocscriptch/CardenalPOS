<?php
class PrincipalModel extends Query {
    public function __construct() {
        parent::__construct();
    }
    // datos login
    public function getData($email)
    {
        $sql = "SELECT id, nombre, correo, perfil, clave FROM tbusuarios WHERE correo = '$email'";
        return $this->select($sql);
    }

    public function verificarCorreo($email) {
        $sql = "SELECT id FROM tbusuarios WHERE correo = '$email'";
        $request = $this->select($sql);
        return $request;
    }

    public function registrarToken($token, $email) {
        $sql = "UPDATE tbusuarios SET token = ? WHERE correo = ?";
        $arrData = array($token, $email);
        $request = $this->save($sql, $arrData);
        return $request;
    }

    public function verificarToken($token) {
        $sql = "SELECT id, token FROM tbusuarios WHERE token = '$token'";
        $request = $this->select($sql);
        return $request;
    }

    public function modificarClave($nueva, $token){
        $sql = "UPDATE tbusuarios SET clave = ?, token = ? WHERE token = ?";
        $arrData = array($nueva,null, $token);
        $request = $this->save($sql, $arrData);
        return $request;
    }

    //registrar logs en el sistema
    public function registrarAcceso($evento, $ip, $detalle)
    {
        $sql = "INSERT INTO tbacceso (evento, ip, detalle) VALUES (?,?,?)";
        $arrData = array($evento, $ip, $detalle);
        $request = $this->insertar($sql, $arrData);
        return $request;
    }
}


?>