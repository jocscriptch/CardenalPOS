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
                        <a class="dropdown-item" href="<?php echo BASE_URL . 'clientes/inactivos'; ?>">
                            <i class="fas fa-trash text-danger mx-2"></i>Inactivos
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-clientes-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-clientes" type="button" role="tab" aria-controls="nav-clientes"
                    aria-selected="true">Clientes</button>
                <button class="nav-link" id="nav-nuevo-tab" data-bs-toggle="tab" data-bs-target="#nav-nuevo"
                    type="button" role="tab" aria-controls="nav-nuevo" aria-selected="false">Nuevo Cliente</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-2" id="nav-clientes" role="tabpanel"
                aria-labelledby="nav-clientes-tab">
                <h5 class="card-title text-center "><i class="fas fa-users me-2"></i></i>Lista de Clientes Activos
                </h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblClientes"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Identidad</th>
                                <th>N° Cedula</th>
                                <th>Nombre</th>
                                <th>Telefono</th>
                                <th>Correo</th>
                                <th>Direccion</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-nuevo" role="tabpanel" aria-labelledby="nav-nuevo-tab">
                <form id="form" autocomplete="off">
                    <input type="hidden" id="id" name="id">
                    <div class="row mb-3">
                        <div class="col-md-2 mb-3">
                            <div class="form-group">
                                <label for="identidad">Identidad <span class="text-danger">*</span></label>
                                <select id="identidad" class="form-control" name="identidad">
                                    <option value="">Seleccionar</option>
                                    <option value="Nacional">Nacional</option>
                                    <option value="Extranjero">Extranjero</option>
                                </select>
                            </div>
                            <span id="errorIdentidad" class="text-danger"></span>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="num_identidad">N° Cédula <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-hashtag"></i></span>
                                <input class="form-control" type="text" name="num_identidad" id="num_identidad"
                                    placeholder="N° Cédula" inputmode="numeric">
                            </div>
                            <span id="errorNumIdentidad" class="text-danger"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nombre">Nombre <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input class="form-control" type="text" name="nombre" id="nombre" placeholder="Nombre">
                            </div>
                            <span id="errorNombre" class="text-danger"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="telefono">Telefono <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input class="form-control" type="number" name="telefono" id="telefono"
                                    placeholder="Numero de telefono">
                            </div>
                            <span id="errorTelefono" class="text-danger"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="correo">Correo (Opcional)</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input class="form-control" type="text" name="correo" id="correo"
                                    placeholder="Correo Electronico">
                            </div>
                            <span id="errorCorreo" class="text-danger"></span>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="direccion">Direccion <span class="text-danger">*</span></label>
                                <textarea id="direccion" class="form-control" name="direccion" rows="3"
                                    placeholder="Direccion"></textarea>
                            </div>
                            <span id="errorDireccion" class="text-danger"></span>
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