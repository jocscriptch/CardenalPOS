<?php
class Usuarios extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $data['title'] = 'Usuarios';
        $data['script'] = 'usuarios.js';
        $this->views->getView('usuarios', 'index', $data);
        //se manda el folder usuarios, luego el archivo index que esta dentro de dicho folder

    }

    public function listar()
    {
        $data = $this->model->getUsuarios(1);

        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['rol'] == 1) {
                $data[$i]['rol'] = '<span class="badge bg-success">ADMINISTRADOR</span>';
            } else {
                $data[$i]['rol'] = '<span class="badge bg-info">EMPLEADO</span>';
            }
            $data[$i]['acciones'] =
                '<div class="text-center">
                      <button class="btn btn-danger" type="button" onClick="eliminarUsuario(' . $data[$i]['id'] . ')"><i class="fa-solid fa-trash"></i></button>
                      <button class="btn btn-info" type="button" onClick="editarUsuario(' . $data[$i]['id'] . ')"><i class="fa-solid fa-pen text-white"></i></button>
                 </div>';
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    //metodo registrar y modificar
    public function registrar()
    {
        if (isset($_POST)) {
            if (empty($_POST['nombres'])) {
                $res = array('msg' => 'Nombre Requerido', 'type' => 'warning');

            } else if (empty($_POST['apellidos'])) {
                $res = array('msg' => 'Apellidos Requerido', 'type' => 'warning');

            } else if (empty($_POST['email'])) {
                $res = array('msg' => 'Correo Requerido', 'type' => 'warning');

            } else if (empty($_POST['telefono'])) {
                $res = array('msg' => 'Telefono Requerido', 'type' => 'warning');

            } else if (empty($_POST['direccion'])) {
                $res = array('msg' => 'Direccion Requerido', 'type' => 'warning');

            } else if (empty($_POST['clave'])) {
                $res = array('msg' => 'Clave Requerido', 'type' => 'warning');

            } else if (empty($_POST['rol'])) {
                $res = array('msg' => 'Rol Requerido', 'type' => 'warning');

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
                            $res = array('msg' => 'TELEFONO DEBE SER UNICO', 'type' => 'warning');
                        }
                    } else {
                        $res = array('msg' => 'EL CORREO DEBE SER UNICO', 'type' => 'warning');
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
                        $res = array('msg' => 'TELEFONO DEBE SER UNICO', 'type' => 'warning');
                    }
                } else {
                    $res = array('msg' => 'EL CORREO DEBE SER UNICO', 'type' => 'warning');
                }
                }



            }
        } else {
            $res = array('msg' => 'Error desconocido', 'type' => 'error');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    //metodo eliminar usuario
    public function eliminar($id)
    {
        if (isset($_GET)) {
            if (is_numeric($id)) {
                $data = $this->model->eliminar(0, $id);
                if ($data == 1) {
                    $res = array('msg' => 'USUARIO DE BAJA', 'type' => 'success');
                } else {
                    $res = array('msg' => 'ERROR AL ELIMINAR', 'type' => 'error');
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

        $data = $this->model->editar($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    //vista de usuarios inactivos
    public function inactivos()
    {
        $data['title'] = 'Usuarios Inactivos';
        $data['script'] = 'usuarios_inactivos.js';
        $this->views->getView('usuarios', 'inactivos', $data);
    }

    public function listarInactivos()
    {
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


}

?>