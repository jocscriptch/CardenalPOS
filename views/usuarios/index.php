<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div></div>
            <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
                        class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="<?php echo BASE_URL . 'usuarios/inactivos'; ?>">
                            <i class="fas fa-trash text-danger mx-2"></i>Inactivos
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-usuarios-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-usuarios" type="button" role="tab" aria-controls="nav-usuarios"
                    aria-selected="true">Usuarios</button>
                <button class="nav-link" id="nav-nuevo-tab" data-bs-toggle="tab" data-bs-target="#nav-nuevo"
                    type="button" role="tab" aria-controls="nav-nuevo" aria-selected="false">Nuevo</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-2" id="nav-usuarios" role="tabpanel"
                aria-labelledby="nav-usuarios-tab">
                <h5 class="card-title text-center "><i class="fas fa-users"></i> Lista de Usuarios Activos</h5>
                <hr>

                <table class="table table-bordered table-striped table-hover nowrap" id="tblUsuarios"
                    style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Rol</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade" id="nav-nuevo" role="tabpanel" aria-labelledby="nav-nuevo-tab">
                <form class="p-4" id="form" autocomplete="off">
                    <input type="hidden" id="id" name="id">
                    <div class="row">
                        <div class="col-lg-4  col-sm-6 mb-2">
                            <label>Nombre</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input type="text" id="nombres" name="nombres" class="form-control"
                                    placeholder="Nombre">
                            </div>
                            <span id="errorNombres" class="text-danger"></span>
                        </div>

                        <div class="col-lg-4  col-sm-6 mb-2">
                            <label>Apellido</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                <input type="text" id="apellidos" name="apellidos" class="form-control"
                                    placeholder="Apellido">
                            </div>
                            <span id="errorApellidos" class="text-danger"></span>
                        </div>

                        <div class="col-lg-4  col-sm-6 mb-2">
                            <label>Correo</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Correo">
                            </div>
                            <span id="errorEmail" class="text-danger"></span>
                        </div>

                        <div class="col-lg-4  col-sm-6 mb-2">
                            <label>Teléfono</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="number" id="telefono" name="telefono" class="form-control"
                                    placeholder="Telefono">
                            </div>
                            <span id="errorTelefono" class="text-danger"></span>
                        </div>

                        <div class="col-lg-8  col-sm-6 mb-2">
                            <label>Dirección</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                <input type="text" id="direccion" name="direccion" class="form-control"
                                    placeholder="Direccion">
                            </div>
                            <span id="errorDireccion" class="text-danger"></span>
                        </div>

                        <div class="col-lg-4  col-sm-6 mb-2">
                            <label>Clave</label>
                            <div class="input-group ">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" id="clave" name="clave" class="form-control" placeholder="Clave">
                            </div>
                            <span id="errorClave" class="text-danger"></span>
                        </div>

                        <div class="col-lg-4  col-sm-6 mb-2">
                            <label>Rol</label>
                            <div class="input-group ">
                                <label class="input-group-text" for="rol"><i class="fas fa-id-card"></i></label>
                                <select class="form-select" id="rol" name="rol">
                                    <option value="" selected>Seleccione...</option>
                                    <option value="1">Administrador</option>
                                    <option value="2">Empleado</option>
                                </select>
                            </div>
                            <span id="errorRol" class="text-danger"></span>
                        </div>

                    </div>
                    <div class="text-end">
                        <button class="btn btn-danger" type="button" id="btnNuevo">Nuevo</button>
                        <button class="btn btn-primary" type="submit" id="btnAccion">Registrar</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
<?php include_once 'views/templates/footer.php'; ?>