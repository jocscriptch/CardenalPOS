<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title text-center"><i class="fa-solid fa-users-slash me-2"></i>Lista De Clientes Inactivos</h5>
        <hr>
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


    <?php include_once 'views/templates/footer.php'; ?>