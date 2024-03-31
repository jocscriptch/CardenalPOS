<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title text-center"><i class="fa-solid fa-house-laptop me-2"></i>Datos de tu Negocio</h5>
        <hr>
        <form class="p-4" id="form" autocomplete="off">
            <input type="hidden" id="id" name="id" value="<?php echo $data['empresa']['id']; ?>">
            <div class="row">
                <div class="col-lg-4  col-sm-6 mb-2">
                    <label>Identificación de la empresa<span class="text-danger">*</span></label>
                    <div class="input-group ">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" id="rut" name="rut" class="form-control" value="<?php echo $data['empresa']['id_empresa']; ?>" placeholder="Identificación">
                    </div>
                    <span id="errorRut" class="text-danger"></span>
                </div>

                <div class="col-lg-4  col-sm-6 mb-2">
                    <label>Nombre <span class="text-danger">*</span> </label>
                    <div class="input-group ">
                        <span class="input-group-text"><i class="fas fa-list"></i></span>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="<?php echo $data['empresa']['nombre']; ?>" placeholder="Nombre">
                    </div>
                    <span id="errorNombre" class="text-danger"></span>
                </div>

                <div class="col-lg-4  col-sm-6 mb-2">
                    <label>Teléfono <span class="text-danger">*</span> </label>
                    <div class="input-group ">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="number" id="telefono" name="telefono" class="form-control" value="<?php echo $data['empresa']['telefono']; ?>" placeholder="Telefono">
                    </div>
                    <span id="errorTelefono" class="text-danger"></span>
                </div>

                <div class="col-lg-4  col-sm-6 mb-2">
                    <label>Correo <span class="text-danger">*</span> </label>
                    <div class="input-group ">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" class="form-control" value="<?php echo $data['empresa']['correo']; ?>" placeholder="Correo">
                    </div>
                    <span id="errorEmail" class="text-danger"></span>
                </div>

                <div class="col-lg-8  col-sm-6 mb-2">
                    <label>Dirección <span class="text-danger">*</span></label>
                    <div class="input-group ">
                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                        <input type="text" id="direccion" name="direccion" class="form-control" value="<?php echo $data['empresa']['direccion']; ?>" placeholder="Direccion">
                    </div>
                    <span id="errorDireccion" class="text-danger"></span>
                </div>

                <div class="col-lg-3  col-sm-6 mb-2">
                    <label>Impuesto (Opcional)</label>
                    <div class="input-group ">
                        <span class="input-group-text"><i class="fas fa-percent"></i></span>
                        <input type="number" id="impuesto" name="impuesto" class="form-control" value="<?php echo $data['empresa']['impuesto']; ?>" placeholder="Impuesto">
                    </div>
                </div>

                <div class="col-lg-9 col-sm-6 mb-2">
                    <div class="form-group">
                        <label for="mensaje">Mensaje (Opcional)</label>
                        <textarea id="mensaje" class="form-control" name="mensaje" rows="3" placeholder="Mensaje"><?php echo $data['empresa']['mensaje']; ?></textarea>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="foto">Logo(PNG)</label>
                        <input id="foto" class="form-control" type="file" name="foto">
                    </div>
                    <div class="pt-3" id="containerPreview">
                        <img class="img-thumbnail" src="<?php echo BASE_URL . 'assets/images/logo.png'; ?>" alt="LOGO_PNG" width="200">
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button class="btn btn-primary" type="submit" id="btnAccion">Actualizar</button>
            </div>
        </form>
    </div>
</div>

<?php include_once 'views/templates/footer.php'; ?>