<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?php echo BASE_URL; ?>assets/images/logo2.png" type="image/png" />
	<!-- loader-->
	<link href="<?php echo BASE_URL; ?>assets/css/pace.min.css" rel="stylesheet" />
	<script src="<?php echo BASE_URL; ?>assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo BASE_URL; ?>assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="<?php echo BASE_URL; ?>assets/css/app.css" rel="stylesheet">
	<link href="<?php echo BASE_URL; ?>assets/css/icons.css" rel="stylesheet">
	<title>
		<?php echo TITLE . ' - ' . $data['title']; ?>
	</title>
</head>

<body>
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-reset-password d-flex align-items-center justify-content-center">
			<div class="row">
				<div class="col-12 col-lg-10 mx-auto">
					<div class="card">
						<div class="row g-0">
							<div class="col-lg-5 border-end">
								<div class="card-body">
									<div class="p-5">
										<input type="hidden" id="token"
											value="<?php echo $data['Securitytoken']['token'] ?>">
										<h4 class="mt-5 font-weight-bold">Generar Nueva Contraseña</h4>
										<p class="text-muted">Recibimos su solicitud de restablecimiento de contraseña.
											¡Por favor, introduzca su nueva contraseña!</p>
										<div class="mb-3 mt-5">
											<label for="password" class="form-label">Nueva Contraseña <span class="text-danger fw-bold">*</span></label>
											<div class="input-group" id="showHidePassword">
												<input type="password" class="form-control border-end-0" id="nueva_clave"
													name="password" placeholder="Introduzca una nueva contraseña">
												<a href="javascript:;" class="input-group-text bg-transparent"><i
														class='bx bx-hide'>
													</i>
												</a>
											</div>
										</div>
										<div class="mb-3">
											<label for="password" class="form-label">Confirmar Contraseña <span class="text-danger fw-bold">*</span></label>
											<div class="input-group" id="showHidePassword">
												<input type="password" class="form-control border-end-0" id="confirm_clave"
													name="password" placeholder="Introduzca una nueva contraseña">
												<a href="javascript:;" class="input-group-text bg-transparent"><i
														class='bx bx-hide'>
													</i>
												</a>
											</div>
										</div>
										<div class="d-grid gap-2">
											<button type="button" class="btn btn-primary" id="btnCambiar">Cambiar
												Contraseña</button> <a href="<?php echo BASE_URL; ?>"
												class="btn btn-light"><i class='bx bx-arrow-back mr-1'></i>Volver Al
												Inicio</a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-7">
								<img src="<?php echo BASE_URL; ?>assets/images/login-images/forgot-password-frent-img.jpg"
									class="card-img login-img h-100" alt="...">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
	<script src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
	<script>
		$(document).ready(function () {
			$("#showHidePassword a").on('click', function (event) {
				event.preventDefault();
				if ($('#showHidePassword input').attr("type") == "text") {
					$('#showHidePassword input').attr('type', 'password');
					$('#showHidePassword i').addClass("bx-hide");
					$('#showHidePassword i').removeClass("bx-show");
				} else if ($('#showHidePassword input').attr("type") == "password") {
					$('#showHidePassword input').attr('type', 'text');
					$('#showHidePassword i').removeClass("bx-hide");
					$('#showHidePassword i').addClass("bx-show");
				}
			});
		});
	</script>
	<script>
		const base_url = '<?php echo BASE_URL; ?>';
	</script>
	<script src="<?php echo BASE_URL . 'assets/js/sweetalert2.all.min.js'; ?>">
	</script>
	<script src="<?php echo BASE_URL . 'assets/js/modules/restablecer.js'; ?>">
	</script>

</body>

</html>