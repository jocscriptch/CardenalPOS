<?php
require_once 'config/Config.php';
$ruta = (!empty($_GET['url'])) ? $_GET['url'] : 'home/index';
$array = explode('/', $ruta);
$controller = ucfirst($array[0]);
$metodo = 'index';
$parametro = '';
if (!empty($array[1])) {
    if ($array[1] != '') {
        $metodo = $array[1];
    }
}
if (!empty($array[2])) {
    if ($array[2] != '') {
        for ($i=2; $i < count($array); $i++) { 
            $parametro .= $array[$i] . ',';
        }
        $parametro = trim($parametro, ',');
    }
}
require_once 'config/app/Autoload.php';
$dirControllorer = 'controllers/' . $controller . '.php';
if (file_exists($dirControllorer)) {
    require_once $dirControllorer;
    $controller = new $controller();
    if (method_exists($controller, $metodo)) {
       $controller->$metodo($parametro);
    }else{
        echo 'No existe el metodo';
    }
}else{
    echo 'No existe el controlador';
}
?>