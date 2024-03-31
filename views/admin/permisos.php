<?php include_once 'views/templates/header.php'; ?>

<div class="error-404 d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="card py-5">
            <div class="row g-0">
                <div class="col col-xl-5">
                    <div class="card-body p-4">
                        <h4 class="font-weight-bold display-4">No tienes Permisos</h4>
                        <p>Has llegado al borde del universo.
                            <br>No se ha podido encontrar la página que ha solicitado.
                            <br>No te preocupes y vuelve a la página anterior.
                        </p>
                        <div class="mt-5"> <a href="<?php echo BASE_URL . 'admin'; ?>"
                                class="btn btn-primary btn-lg px-md-5 radius-30">Volver Al Inicio</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7">
                    <img src="https://cdn.searchenginejournal.com/wp-content/uploads/2019/03/shutterstock_1338315902.png"
                        class="img-fluid" alt="">
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</div>

<?php include_once 'views/templates/footer.php'; ?>