<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
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
                <h5 class="card-title text-center mb-3"><i class="fas fa-users"></i> Lista de Usuarios</h5>
                <hr>
                <table class="table table-bordered table-striped table-hove" id="tblUsuarios" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Correo</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
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
                <div class="row p-4">
                    <div class="col-lg-4 col-sm-6">
                        <label>Nombre</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                            <input type="text" class="form-control" placeholder="Nombre">
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <label>Apellido</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                            <input type="text" class="form-control" placeholder="Apellido">
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <label>Correo</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" placeholder="Correo">
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <label>Telefono</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="number" class="form-control" placeholder="Telefono">
                        </div>
                    </div>

                    <div class="col-lg-8 col-sm-6">
                        <label>Direccion</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                            <input type="text" class="form-control" placeholder="Direccion">
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <label>Clave</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" placeholder="Clave">
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6">
                        <label>Rol</label>
                        <div class="input-group mb-3">
                            <label class="input-group-text" for="inputGroupSelect01"><i class="fas fa-id-card"></i></label>
                            <select class="form-select" id="inputGroupSelect01">
                                <option selected>Seleccione...</option>
                                <option value="1">Administrador</option>
                                <option value="2">Empleado</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="text-end">
                    <button class="btn btn-primary" type="button">Registrar</button>
                </div>
            </div>
        </div>

    </div>
</div>
<?php include_once 'views/templates/footer.php'; ?>