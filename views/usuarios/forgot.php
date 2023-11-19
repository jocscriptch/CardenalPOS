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

<body class="bg-forgot">
	<!-- wrapper -->
	<div class="wrapper">
		<div class="authentication-forgot d-flex align-items-center justify-content-center">
			<div class="card forgot-box">
				<div class="card-body">
					<div class="p-4 rounded  border">
						<div class="text-center">
							<img src="<?php echo BASE_URL; ?>assets/images/icons/forgot-2.png" width="120" alt="" />
						</div>
						<h4 class="mt-5 font-weight-bold">¿Olvidó su contraseña?</h4>
						<p class="text-muted">Ingrese su ID de correo electrónico registrado para restablecer la contraseña</p>
						<div class="my-4">
							<label class="form-label">Identificación de correo electrónico</label>
							<input type="email" class="form-control form-control-lg" id="email" placeholder="jose@gmail.com" autocomplete="off" />
						</div>
						<div class="d-grid gap-2">
							<button type="button" class="btn btn-primary btn-lg" id="btnEnviar">Enviar</button> <a href="<?php echo BASE_URL;?>" class="btn btn-light btn-lg"><i class='bx bx-arrow-back me-1'></i>Back to Login</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end wrapper -->
	<script>
		const base_url = '<?php echo BASE_URL; ?>';
	</script>
	<script src="<?php echo BASE_URL . 'assets/js/sweetalert2.all.min.js'; ?>">
	</script>
	<script src="<?php echo BASE_URL . 'assets/js/modules/reset.js'; ?>">
	</script>
</body>

</html>