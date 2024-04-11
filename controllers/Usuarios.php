<?php
class Usuarios extends Controller
{
    private $idUsuario;
    public function __construct()
    {
        parent::__construct();
        session_start();
        if (empty($_SESSION['id_usuario'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
        $this->idUsuario = $_SESSION['id_usuario'];
    }
    public function index()
    {
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        $data['title'] = 'Usuarios';
        $data['script'] = 'usuarios.js';
        $this->views->getView('usuarios', 'index', $data);
        //se manda el folder usuarios, luego el archivo index que esta dentro de dicho folder

    }

    public function listar()
    {
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        $data = $this->model->getUsuarios(1);

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['id'] == 1) {
                $data[$i]['acciones'] = '';
            } else {
                $data[$i]['acciones'] =
                    '<div class="text-center">
                      <button class="btn btn-info" type="button" onClick="editarUsuario(' . $data[$i]['id'] . ')"><i class="fa-solid fa-pen text-white"></i></button>
                      <button class="btn btn-danger" type="button" onClick="eliminarUsuario(' . $data[$i]['id'] . ')"><i class="fa-solid fa-trash"></i></button>
                    </div>';
            }

            if ($data[$i]['rol'] == 1) {
                $data[$i]['rol'] = '<span class="badge bg-success">ADMINISTRADOR</span>';
            } else {
                $data[$i]['rol'] = '<span class="badge bg-info">EMPLEADO</span>';
            }
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    //metodo registrar y modificar
    public function registrar()
    {
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        if (isset($_POST)) {
            if (empty($_POST['nombres'])) {
                $res = array('msg' => 'Nombre Requerido', 'type' => 'warning');
            } else if (empty($_POST['apellidos'])) {
                $res = array('msg' => 'Apellido Requerido', 'type' => 'warning');
            } else if (empty($_POST['email'])) {
                $res = array('msg' => 'Correo Requerido', 'type' => 'warning');
            } else if (empty($_POST['telefono'])) {
                $res = array('msg' => 'Teléfono Requerido', 'type' => 'warning');
            } else if (empty($_POST['direccion'])) {
                $res = array('msg' => 'Dirección Requerido', 'type' => 'warning');
            } else if (empty($_POST['clave'])) {
                $res = array('msg' => 'Clave Requerido', 'type' => 'warning');
            } else if (empty($_POST['rol'])) {
                $res = array('msg' => 'Rol Requerido', 'type' => 'warning');
            } else if (strlen($_POST['clave']) < 6) {
                $res = array('msg' => 'La contraseña debe tener al menos 6 caracteres', 'type' => 'warning');
            } else if (!$this->validarClave($_POST['clave'])) {
                $res = array(
                    'msg' => 'Contraseña débil, debe contener al menos una letra mayúscula, una letra minúscula y un número',
                    'type' => 'warning'
                );
            } else {
                $nombres = strClean($_POST['nombres']);
                $apellidos = strClean($_POST['apellidos']);
                $email = strClean($_POST['email']);
                $telefono = strClean($_POST['telefono']);
                $direccion = strClean($_POST['direccion']);
                $clave = strClean($_POST['clave']);
                $rol = strClean($_POST['rol']);
                $id = strClean($_POST['id']);

                if ($id == '') {
                    $hash = password_hash($clave, PASSWORD_DEFAULT);
                    //verificar si existe los datos con la db
                    $verificarEmail = $this->model->getValidar('correo', $email, 'registrar', 0);
                    if (empty($verificarEmail)) {

                        $verificarTel = $this->model->getValidar('telefono', $telefono, 'registrar', 0);

                        if (empty($verificarTel)) {

                            $data = $this->model->registrar(
                                $nombres,
                                $apellidos,
                                $email,
                                $telefono,
                                $direccion,
                                $hash,
                                $rol
                            );
                            if ($data > 0) {
                                $res = array('msg' => 'Usuario Registrado', 'type' => 'success');
                            } else {
                                $res = array('msg' => 'Error Registrar', 'type' => 'error');
                            }
                        } else {
                            $res = array('msg' => 'TELÉFONO DEBE SER ÚNICO', 'type' => 'warning');
                        }
                    } else {
                        $res = array('msg' => 'EL CORREO DEBE SER ÚNICO', 'type' => 'warning');
                    }
                } else {
                    //verificar si existe los datos con la db
                    $verificarEmail = $this->model->getValidar('correo', $email, 'editar', $id);
                    if (empty($verificarEmail)) {

                        $verificarTel = $this->model->getValidar('telefono', $telefono, 'editar', $id);

                        if (empty($verificarTel)) {

                            $data = $this->model->actualizar(
                                $nombres,
                                $apellidos,
                                $email,
                                $telefono,
                                $direccion,
                                $rol,
                                $id
                            );
                            if ($data > 0) {
                                $res = array('msg' => 'Usuario Actualizado', 'type' => 'success');
                            } else {
                                $res = array('msg' => 'Error al Acutalizar', 'type' => 'error');
                            }
                        } else {
                            $res = array('msg' => 'TELÉFONO DEBE SER ÚNICO', 'type' => 'warning');
                        }
                    } else {
                        $res = array('msg' => 'EL CORREO DEBE SER ÚNICO', 'type' => 'warning');
                    }
                }
            }
        } else {
            $res = array('msg' => 'Error desconocido', 'type' => 'error');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    // validar si la contraseña es segura
    private function validarClave($clave)
    {
        // verificar si la contraseña contiene al menos una letra mayuscula, una letra minuscula y un numero
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', $clave);
    }

    //metodo eliminar usuario
    public function eliminar($id)
    {
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        if (isset($_GET)) {
            if (is_numeric($id)) {
                $data = $this->model->eliminar(0, $id);
                if ($data == 1) {
                    $res = array('msg' => 'USUARIO DESACTIVADO', 'type' => 'success');
                } else {
                    $res = array('msg' => 'ERROR AL DESACTIVAR', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($id)
    {
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        $data = $this->model->editar($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    //vista de usuarios inactivos
    public function inactivos()
    {
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        $data['title'] = 'Usuarios Inactivos';
        $data['script'] = 'usuarios_inactivos.js';
        $this->views->getView('usuarios', 'inactivos', $data);
    }

    public function listarInactivos()
    {
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        $data = $this->model->getUsuarios(0);

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['rol'] == 1) {
                $data[$i]['rol'] = '<span class="badge bg-success">ADMINISTRADOR</span>';
            } else {
                $data[$i]['rol'] = '<span class="badge bg-info">EMPLEADO</span>';
            }
            $data[$i]['acciones'] =
                '<div class="text-center">
                      <button class="btn btn-info" type="button" onClick="restaurarUsuario(' . $data[$i]['id'] . ')"><i class="fas fa-check-circle text-white"></i></button>
                </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    //restaurar usuarios
    public function restaurar($id)
    {
        if ($_SESSION['rol'] == 2) {
            header('Location: ' . BASE_URL . 'admin/permisos');
            exit;
        }
        if (isset($_GET)) {
            if (is_numeric($id)) {
                $data = $this->model->eliminar(1, $id);
                if ($data == 1) {
                    $res = array('msg' => 'USUARIO RESTAURADO', 'type' => 'success');
                } else {
                    $res = array('msg' => 'ERROR AL RESTAURAR', 'type' => 'error');
                }
            } else {
                $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
            }
        } else {
            $res = array('msg' => 'ERROR DESCONOCIDO', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    //vista perfil usuario
    public function perfil()
    {
        $data['title'] = 'Perfil de Usuario';
        $data['script'] = 'perfil.js';
        $data['usuario'] = $this->model->editar($this->idUsuario);
        $this->views->getView('usuarios', 'perfil', $data);
    }

    public function modificarDatos()
    {
        $nombre = strClean($_POST['nombrePerfil']);
        $apellidos = strClean($_POST['apellidoPerfil']);
        $correo = strClean($_POST['correoPerfil']);
        $telefono = strClean($_POST['telefonoPerfil']);
        $direccion = strClean($_POST['direccionPerfil']);
        $claveNueva = strClean($_POST['claveNueva']);
        $claveActual = strClean($_POST['claveActual']);

        $foto = $_FILES['fotoPerfil'];
        $name = $foto['name'];
        $tmp = $foto['tmp_name'];

        $verificarPerfil = $this->model->editar($this->idUsuario);
        $destino = $verificarPerfil['perfil'];

        // Validar si la contraseña nueva es segura
        if (!empty($claveNueva) && !$this->validarClave($claveNueva)) {
            $res = array('msg' => 'Contraseña débil, debe contener al menos una letra mayúscula, una letra minúscula y un número', 'type' => 'warning');
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }

        if (!empty($name)) {
            if (file_exists($destino)) {
                unlink($destino);
            }
            $perfil = date('YmdHis') . $correo . '.jpg';
            $destino = 'assets/images/perfil/' . $perfil;
        }

        if (empty($nombre)) {
            $res = array('msg' => 'EL NOMBRE ES REQUERIDO', 'type' => 'warning');
        } else if (empty($apellidos)) {
            $res = array('msg' => 'EL APELLIDO ES REQUERIDO', 'type' => 'warning');
        } else if (empty($correo)) {
            $res = array('msg' => 'EL CORREO ES REQUERIDO', 'type' => 'warning');
        } else if (empty($telefono)) {
            $res = array('msg' => 'EL TELÉFONO ES REQUERIDO', 'type' => 'warning');
        } else if (empty($direccion)) {
            $res = array('msg' => 'LA DIRECCIÓN ES REQUERIDA', 'type' => 'warning');
        } else {
            $verificarClave = $this->model->editar($this->idUsuario);
            if (empty($claveNueva)) {
                $hash = $verificarClave['clave'];
                $verificarCorreo = $this->model->getValidar('correo', $correo, 'actualizar', $this->idUsuario);
                if (empty($verificarCorreo)) {
                    $verificarTel = $this->model->getValidar('telefono', $telefono, 'actualizar', $this->idUsuario);
                    if (empty($verificarTel)) {
                        $data = $this->model->modificarDatos($nombre, $apellidos, $correo, $telefono, $direccion, $hash, $destino, $this->idUsuario);
                        if ($data == 1) {
                            if (!empty($name)) {
                                move_uploaded_file($tmp, $destino);
                            }
                            $res = array('msg' => 'DATOS ACTUALIZADOS', 'type' => 'success', 'clave' => false);
                        } else {
                            $res = array('msg' => 'ERROR AL ACTUALIZAR', 'type' => 'error');
                        }
                    } else {
                        $res = array('msg' => 'EL TELEFONO DEBE SER UNICO', 'type' => 'warning');
                    }
                } else {
                    $res = array('msg' => 'EL CORREO DEBE SER UNICO', 'type' => 'warning');
                }
            } else {
                if (password_verify($claveActual, $verificarClave['clave'])) {
                    $verificarCorreo = $this->model->getValidar('correo', $correo, 'actualizar', $this->idUsuario);
                    if (empty($verificarCorreo)) {
                        $verificarTel = $this->model->getValidar('telefono', $telefono, 'actualizar', $this->idUsuario);
                        if (empty($verificarTel)) {
                            $hash = password_hash($claveNueva, PASSWORD_DEFAULT);
                            $data = $this->model->modificarDatos($nombre, $apellidos, $correo, $telefono, $direccion, $hash, $destino, $this->idUsuario);
                            if ($data == 1) {
                                if (!empty($name)) {
                                    move_uploaded_file($tmp, $destino);
                                }
                                $res = array('msg' => 'DATOS ACTUALIZADOS', 'type' => 'success', 'clave' => true);
                            } else {
                                $res = array('msg' => 'ERROR AL ACTUALIZAR', 'type' => 'error');
                            }
                        } else {
                            $res = array('msg' => 'EL TELEFONO DEBE SER UNICO', 'type' => 'warning');
                        }
                    } else {
                        $res = array('msg' => 'EL CORREO DEBE SER UNICO', 'type' => 'warning');
                    }
                } else {
                    $res = array('msg' => 'CONTRASEÑA ACTUAL INCORRECTA', 'type' => 'warning');
                }
            }
        }
        $_SESSION['perfil_usuario'] = $destino;
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function salir()
    {
        $evento = 'Cerrar Sesión';
        $ip = $_SERVER['REMOTE_ADDR'];
        $detalle = $_SERVER['HTTP_USER_AGENT'];
        $acceso = $this->model->registrarAcceso($evento, $ip, $detalle);
        if ($acceso > 0) {
            session_destroy();
            header('Location: ' . BASE_URL);
        }
    }
}
