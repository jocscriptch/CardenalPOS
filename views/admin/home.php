<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="<?php echo BASE_URL; ?>assets/images/favicon-32x32.png" type="image/png" />
	<link href="<?php echo BASE_URL; ?>assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="<?php echo BASE_URL; ?>assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
	<link href="<?php echo BASE_URL; ?>assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
	<!-- loader-->
	<link href="<?php echo BASE_URL; ?>assets/css/pace.min.css" rel="stylesheet" />
	<script src="<?php echo BASE_URL; ?>assets/js/pace.min.js"></script>
	<!-- Bootstrap CSS -->
	<link href="<?php echo BASE_URL; ?>assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="<?php echo BASE_URL; ?>assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="<?php echo BASE_URL; ?>assets/css/app.css" rel="stylesheet">
	<link href="<?php echo BASE_URL; ?>assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/dark-theme.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/semi-dark.css" />
	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/header-colors.css" />
	<title>
        <?php echo TITLE . ' - ' .$data['title']; ?>
    </title>
</head>

<body>
	<!--wrapper-->
	<div class="wrapper">
		<!--sidebar wrapper -->
		<div class="sidebar-wrapper" data-simplebar="true">
			<div class="sidebar-header">
				<div>
					<img src="<?php echo BASE_URL; ?>assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">CAPOS</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
			<!--navigation-->
			<ul class="metismenu" id="menu">
				<li>
					<a href="javascript:;">
						<div class="parent-icon"><i class='bx bx-home-circle'></i>
						</div>
						<div class="menu-title">Principal</div>
					</a>
				</li>
				<li>
					<a href="javascript:;" class="has-arrow">
						<div class="parent-icon"><i class="bx bx-category"></i>
						</div>
						<div class="menu-title">Mantenimiento</div>
					</a>
					<ul>
						<li> <a href="app-emailbox.html"><i class="bx bx-right-arrow-alt"></i>Medidas</a>
						</li>
						<li> <a href="app-chat-box.html"><i class="bx bx-right-arrow-alt"></i>Categorias</a>
						</li>
                        <li> <a href="app-chat-box.html"><i class="bx bx-right-arrow-alt"></i>Productos</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="widgets.html">
						<div class="parent-icon"><i class='bx bx-cookie'></i>
						</div>
						<div class="menu-title">Clientes</div>
					</a>
				</li>
                <li>
					<a href="widgets.html">
						<div class="parent-icon"><i class='bx bx-cookie'></i>
						</div>
						<div class="menu-title">Proveedores</div>
					</a>
				</li>
                <li>
					<a href="widgets.html">
						<div class="parent-icon"><i class='bx bx-cookie'></i>
						</div>
						<div class="menu-title">Cajas</div>
					</a>
				</li>
                <li>
					<a href="widgets.html">
						<div class="parent-icon"><i class='bx bx-cookie'></i>
						</div>
						<div class="menu-title">Compras</div>
					</a>
				</li>
                <li>
					<a href="widgets.html">
						<div class="parent-icon"><i class='bx bx-cookie'></i>
						</div>
						<div class="menu-title">Ventas</div>
					</a>
				</li>
                <li>
					<a href="widgets.html">
						<div class="parent-icon"><i class='bx bx-cookie'></i>
						</div>
						<div class="menu-title">Creditos</div>
					</a>
				</li>
                <li>
					<a href="widgets.html">
						<div class="parent-icon"><i class='bx bx-cookie'></i>
						</div>
						<div class="menu-title">Cotizaciones</div>
					</a>
				</li>
                <li>
					<a href="widgets.html">
						<div class="parent-icon"><i class='bx bx-cookie'></i>
						</div>
						<div class="menu-title">Apartados</div>
					</a>
				</li>
                <li>
					<a href="widgets.html">
						<div class="parent-icon"><i class='bx bx-cookie'></i>
						</div>
						<div class="menu-title">Inventario</div>
					</a>
				</li>
			</ul>
			<!--end navigation-->
		</div>
		<!--end sidebar wrapper -->
		<!--start header -->
		<header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
					</div>
					<div class="search-bar flex-grow-1">
						<div class="position-relative">
							<h6> <?php echo TITLE; ?></h6>
						</div>
					</div>
					<div class="user-box dropdown">
						<a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#"
							role="button" data-bs-toggle="dropdown" aria-expanded="false">
							<img src="<?php echo BASE_URL; ?>assets/images/avatars/avatar-2.png" class="user-img" alt="user avatar">
							<div class="user-info ps-3">
								<p class="user-name mb-0">Pauline Seitz</p>
								<p class="designattion mb-0">Web Designer</p>
							</div>
						</a>
						<ul class="dropdown-menu dropdown-menu-end">
							<li><a class="dropdown-item" href="javascript:;"><i
										class="bx bx-user"></i><span>Profile</span></a>
							</li>
							<li>
								<div class="dropdown-divider mb-0"></div>
							</li>
							<li><a class="dropdown-item" href="javascript:;"><i
										class='bx bx-log-out-circle'></i><span>Logout</span></a>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</header>
		<!--end header -->
		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">
				<div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
					<div class="col">
						<div class="card radius-10 border-start border-0 border-3 border-info">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total Orders</p>
										<h4 class="my-1 text-info">4805</h4>
										<p class="mb-0 font-13">+2.5% from last week</p>
									</div>
									<div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
										<i class='bx bxs-cart'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 border-start border-0 border-3 border-danger">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total Revenue</p>
										<h4 class="my-1 text-danger">$84,245</h4>
										<p class="mb-0 font-13">+5.4% from last week</p>
									</div>
									<div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i
											class='bx bxs-wallet'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 border-start border-0 border-3 border-success">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Bounce Rate</p>
										<h4 class="my-1 text-success">34.6%</h4>
										<p class="mb-0 font-13">-4.5% from last week</p>
									</div>
									<div
										class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
										<i class='bx bxs-bar-chart-alt-2'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col">
						<div class="card radius-10 border-start border-0 border-3 border-warning">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<p class="mb-0 text-secondary">Total Customers</p>
										<h4 class="my-1 text-warning">8.4K</h4>
										<p class="mb-0 font-13">+8.4% from last week</p>
									</div>
									<div class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
										<i class='bx bxs-group'></i>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end row-->

				<div class="row">
					<div class="col-12 col-lg-8">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<h6 class="mb-0">Sales Overview</h6>
									</div>
									<div class="dropdown ms-auto">
										<a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
											data-bs-toggle="dropdown"><i
												class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
										</a>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="javascript:;">Action</a>
											</li>
											<li><a class="dropdown-item" href="javascript:;">Another action</a>
											</li>
											<li>
												<hr class="dropdown-divider">
											</li>
											<li><a class="dropdown-item" href="javascript:;">Something else here</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="d-flex align-items-center ms-auto font-13 gap-2 my-3">
									<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1"
											style="color: #14abef"></i>Sales</span>
									<span class="border px-1 rounded cursor-pointer"><i class="bx bxs-circle me-1"
											style="color: #ffc107"></i>Visits</span>
								</div>
								<div class="chart-container-1">
									<canvas id="chart1"></canvas>
								</div>
							</div>
							<div
								class="row row-cols-1 row-cols-md-3 row-cols-xl-3 g-0 row-group text-center border-top">
								<div class="col">
									<div class="p-3">
										<h5 class="mb-0">24.15M</h5>
										<small class="mb-0">Overall Visitor <span> <i
													class="bx bx-up-arrow-alt align-middle"></i> 2.43%</span></small>
									</div>
								</div>
								<div class="col">
									<div class="p-3">
										<h5 class="mb-0">12:38</h5>
										<small class="mb-0">Visitor Duration <span> <i
													class="bx bx-up-arrow-alt align-middle"></i> 12.65%</span></small>
									</div>
								</div>
								<div class="col">
									<div class="p-3">
										<h5 class="mb-0">639.82</h5>
										<small class="mb-0">Pages/Visit <span> <i
													class="bx bx-up-arrow-alt align-middle"></i> 5.62%</span></small>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-12 col-lg-4">
						<div class="card radius-10">
							<div class="card-body">
								<div class="d-flex align-items-center">
									<div>
										<h6 class="mb-0">Trending Products</h6>
									</div>
									<div class="dropdown ms-auto">
										<a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
											data-bs-toggle="dropdown"><i
												class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
										</a>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="javascript:;">Action</a>
											</li>
											<li><a class="dropdown-item" href="javascript:;">Another action</a>
											</li>
											<li>
												<hr class="dropdown-divider">
											</li>
											<li><a class="dropdown-item" href="javascript:;">Something else here</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="chart-container-2 mt-4">
									<canvas id="chart2"></canvas>
								</div>
							</div>
							<ul class="list-group list-group-flush">
								<li
									class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
									Jeans <span class="badge bg-success rounded-pill">25</span>
								</li>
								<li
									class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
									T-Shirts <span class="badge bg-danger rounded-pill">10</span>
								</li>
								<li
									class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
									Shoes <span class="badge bg-primary rounded-pill">65</span>
								</li>
								<li
									class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
									Lingerie <span class="badge bg-warning text-dark rounded-pill">14</span>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!--end row-->

				<div class="card radius-10">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<h6 class="mb-0">Recent Orders</h6>
							</div>
							<div class="dropdown ms-auto">
								<a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i
										class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
								</a>
								<ul class="dropdown-menu">
									<li><a class="dropdown-item" href="javascript:;">Action</a>
									</li>
									<li><a class="dropdown-item" href="javascript:;">Another action</a>
									</li>
									<li>
										<hr class="dropdown-divider">
									</li>
									<li><a class="dropdown-item" href="javascript:;">Something else here</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table align-middle mb-0">
								<thead class="table-light">
									<tr>
										<th>Product</th>
										<th>Photo</th>
										<th>Product ID</th>
										<th>Status</th>
										<th>Amount</th>
										<th>Date</th>
										<th>Shipping</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>Iphone 5</td>
										<td><img src="<?php echo BASE_URL; ?>assets/images/products/01.png" class="product-img-2"
												alt="product img"></td>
										<td>#9405822</td>
										<td><span
												class="badge bg-gradient-quepal text-white shadow-sm w-100">Paid</span>
										</td>
										<td>$1250.00</td>
										<td>03 Feb 2020</td>
										<td>
											<div class="progress" style="height: 6px;">
												<div class="progress-bar bg-gradient-quepal" role="progressbar"
													style="width: 100%"></div>
											</div>
										</td>
									</tr>

									<tr>
										<td>Earphone GL</td>
										<td><img src="<?php echo BASE_URL; ?>assets/images/products/02.png" class="product-img-2"
												alt="product img"></td>
										<td>#8304620</td>
										<td><span
												class="badge bg-gradient-blooker text-white shadow-sm w-100">Pending</span>
										</td>
										<td>$1500.00</td>
										<td>05 Feb 2020</td>
										<td>
											<div class="progress" style="height: 6px;">
												<div class="progress-bar bg-gradient-blooker" role="progressbar"
													style="width: 60%"></div>
											</div>
										</td>
									</tr>

									<tr>
										<td>HD Hand Camera</td>
										<td><img src="<?php echo BASE_URL; ?>assets/images/products/03.png" class="product-img-2"
												alt="product img"></td>
										<td>#4736890</td>
										<td><span
												class="badge bg-gradient-bloody text-white shadow-sm w-100">Failed</span>
										</td>
										<td>$1400.00</td>
										<td>06 Feb 2020</td>
										<td>
											<div class="progress" style="height: 6px;">
												<div class="progress-bar bg-gradient-bloody" role="progressbar"
													style="width: 70%"></div>
											</div>
										</td>
									</tr>

									<tr>
										<td>Clasic Shoes</td>
										<td><img src="<?php echo BASE_URL; ?>assets/images/products/04.png" class="product-img-2"
												alt="product img"></td>
										<td>#8543765</td>
										<td><span
												class="badge bg-gradient-quepal text-white shadow-sm w-100">Paid</span>
										</td>
										<td>$1200.00</td>
										<td>14 Feb 2020</td>
										<td>
											<div class="progress" style="height: 6px;">
												<div class="progress-bar bg-gradient-quepal" role="progressbar"
													style="width: 100%"></div>
											</div>
										</td>
									</tr>
									<tr>
										<td>Sitting Chair</td>
										<td><img src="<?php echo BASE_URL; ?>assets/images/products/06.png" class="product-img-2"
												alt="product img"></td>
										<td>#9629240</td>
										<td><span
												class="badge bg-gradient-blooker text-white shadow-sm w-100">Pending</span>
										</td>
										<td>$1500.00</td>
										<td>18 Feb 2020</td>
										<td>
											<div class="progress" style="height: 6px;">
												<div class="progress-bar bg-gradient-blooker" role="progressbar"
													style="width: 60%"></div>
											</div>
										</td>
									</tr>
									<tr>
										<td>Hand Watch</td>
										<td><img src="<?php echo BASE_URL; ?>assets/images/products/05.png" class="product-img-2"
												alt="product img"></td>
										<td>#8506790</td>
										<td><span
												class="badge bg-gradient-bloody text-white shadow-sm w-100">Failed</span>
										</td>
										<td>$1800.00</td>
										<td>21 Feb 2020</td>
										<td>
											<div class="progress" style="height: 6px;">
												<div class="progress-bar bg-gradient-bloody" role="progressbar"
													style="width: 40%"></div>
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<!--end row-->

				<div class="row row-cols-1 row-cols-lg-3">
					<div class="col d-flex">
						<div class="card radius-10 w-100">
							<div class="card-body">
								<p class="font-weight-bold mb-1 text-secondary">Weekly Revenue</p>
								<div class="d-flex align-items-center mb-4">
									<div>
										<h4 class="mb-0">$89,540</h4>
									</div>
									<div class="">
										<p class="mb-0 align-self-center font-weight-bold text-success ms-2">4.4% <i
												class="bx bxs-up-arrow-alt mr-2"></i>
										</p>
									</div>
								</div>
								<div class="chart-container-0">
									<canvas id="chart3"></canvas>
								</div>
							</div>
						</div>
					</div>
					<div class="col d-flex">
						<div class="card radius-10 w-100">
							<div class="card-header bg-transparent">
								<div class="d-flex align-items-center">
									<div>
										<h6 class="mb-0">Orders Summary</h6>
									</div>
									<div class="dropdown ms-auto">
										<a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
											data-bs-toggle="dropdown"><i
												class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
										</a>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="javascript:;">Action</a>
											</li>
											<li><a class="dropdown-item" href="javascript:;">Another action</a>
											</li>
											<li>
												<hr class="dropdown-divider">
											</li>
											<li><a class="dropdown-item" href="javascript:;">Something else here</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="chart-container-1">
									<canvas id="chart4"></canvas>
								</div>
							</div>
							<ul class="list-group list-group-flush">
								<li
									class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
									Completed <span class="badge bg-gradient-quepal rounded-pill">25</span>
								</li>
								<li
									class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
									Pending <span class="badge bg-gradient-ibiza rounded-pill">10</span>
								</li>
								<li
									class="list-group-item d-flex bg-transparent justify-content-between align-items-center">
									Process <span class="badge bg-gradient-deepblue rounded-pill">65</span>
								</li>
							</ul>
						</div>
					</div>
					<div class="col d-flex">
						<div class="card radius-10 w-100">
							<div class="card-header bg-transparent">
								<div class="d-flex align-items-center">
									<div>
										<h6 class="mb-0">Top Selling Categories</h6>
									</div>
									<div class="dropdown ms-auto">
										<a class="dropdown-toggle dropdown-toggle-nocaret" href="#"
											data-bs-toggle="dropdown"><i
												class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
										</a>
										<ul class="dropdown-menu">
											<li><a class="dropdown-item" href="javascript:;">Action</a>
											</li>
											<li><a class="dropdown-item" href="javascript:;">Another action</a>
											</li>
											<li>
												<hr class="dropdown-divider">
											</li>
											<li><a class="dropdown-item" href="javascript:;">Something else here</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="chart-container-0">
									<canvas id="chart5"></canvas>
								</div>
							</div>
							<div class="row row-group border-top g-0">
								<div class="col">
									<div class="p-3 text-center">
										<h4 class="mb-0 text-danger">$45,216</h4>
										<p class="mb-0">Clothing</p>
									</div>
								</div>
								<div class="col">
									<div class="p-3 text-center">
										<h4 class="mb-0 text-success">$68,154</h4>
										<p class="mb-0">Electronic</p>
									</div>
								</div>
							</div>
							<!--end row-->
						</div>
					</div>
				</div>
				<!--end row-->

			</div>
		</div>
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button-->
		<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © 2021. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->
	<!--start switcher-->
	<div class="switcher-wrapper">
		<div class="switcher-btn"> <i class='bx bx-cog bx-spin'></i>
		</div>
		<div class="switcher-body">
			<div class="d-flex align-items-center">
				<h5 class="mb-0 text-uppercase">Theme Customizer</h5>
				<button type="button" class="btn-close ms-auto close-switcher" aria-label="Close"></button>
			</div>
			<hr />
			<h6 class="mb-0">Theme Styles</h6>
			<hr />
			<div class="d-flex align-items-center justify-content-between">
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="lightmode" checked>
					<label class="form-check-label" for="lightmode">Light</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="darkmode">
					<label class="form-check-label" for="darkmode">Dark</label>
				</div>
				<div class="form-check">
					<input class="form-check-input" type="radio" name="flexRadioDefault" id="semidark">
					<label class="form-check-label" for="semidark">Semi Dark</label>
				</div>
			</div>
			<hr />
			<div class="form-check">
				<input class="form-check-input" type="radio" id="minimaltheme" name="flexRadioDefault">
				<label class="form-check-label" for="minimaltheme">Minimal Theme</label>
			</div>
			<hr />
			<h6 class="mb-0">Header Colors</h6>
			<hr />
			<div class="header-colors-indigators">
				<div class="row row-cols-auto g-3">
					<div class="col">
						<div class="indigator headercolor1" id="headercolor1"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor2" id="headercolor2"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor3" id="headercolor3"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor4" id="headercolor4"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor5" id="headercolor5"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor6" id="headercolor6"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor7" id="headercolor7"></div>
					</div>
					<div class="col">
						<div class="indigator headercolor8" id="headercolor8"></div>
					</div>
				</div>
			</div>
			<hr />
			<h6 class="mb-0">Sidebar Colors</h6>
			<hr />
			<div class="header-colors-indigators">
				<div class="row row-cols-auto g-3">
					<div class="col">
						<div class="indigator sidebarcolor1" id="sidebarcolor1"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor2" id="sidebarcolor2"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor3" id="sidebarcolor3"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor4" id="sidebarcolor4"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor5" id="sidebarcolor5"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor6" id="sidebarcolor6"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor7" id="sidebarcolor7"></div>
					</div>
					<div class="col">
						<div class="indigator sidebarcolor8" id="sidebarcolor8"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--end switcher-->
	<!-- Bootstrap JS -->
	<script src="<?php echo BASE_URL; ?>assets/js/bootstrap.bundle.min.js"></script>
	<!--plugins-->
	<script src="<?php echo BASE_URL; ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/plugins/metismenu/js/metisMenu.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/plugins/chartjs/js/Chart.min.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/plugins/chartjs/js/Chart.extension.js"></script>
	<script src="<?php echo BASE_URL; ?>assets/js/index.js"></script>
	<!--app JS-->
	<script src="<?php echo BASE_URL; ?>assets/js/app.js"></script>
</body>

</html>