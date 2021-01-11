<?php
include_once 'includes/db-connect.php';
include_once 'includes/functions.php';
 
sec_session_start();
// var_dump($_SESSION);
if(isset($_SESSION['uid'])){
$uid = preg_replace("/[^0-9]/", "", $_SESSION['uid']); //XSS Security
$user=getUser($uid, $conn);
$devices=getActdevicesFromuid($uid, $conn);
$inactdevices=getInactdevicesFromuid($uid, $conn);

}

if(isUserLoggedIn($uid,$conn)=="false")
header('Location: ./index.php');


?>
<!doctype html>
<html class="fixed">
	<head>

		<!-- Basic -->
		<meta charset="UTF-8">

		<title>Smart Wave | Dashboard | SYNCY WAVE LTD.</title>

		<!-- Mobile Metas -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<!-- Web Fonts  -->
		<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">

		<!-- Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/bootstrap/css/bootstrap.css" />
		<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.css" />
		<link rel="stylesheet" href="assets/vendor/magnific-popup/magnific-popup.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-datepicker/css/datepicker3.css" />

		<!-- Specific Page Vendor CSS -->
		<link rel="stylesheet" href="assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
		<link rel="stylesheet" href="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css" />
		<link rel="stylesheet" href="assets/vendor/morris/morris.css" />

		<!-- Theme CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme.css" />

		<!-- Skin CSS -->
		<link rel="stylesheet" href="assets/stylesheets/skins/default.css" />

		<!-- Theme Custom CSS -->
		<link rel="stylesheet" href="assets/stylesheets/theme-custom.css">

		<!-- Head Libs -->
		<script src="assets/vendor/modernizr/modernizr.js"></script>

	</head>
	<body>
		<section class="body">

			<!-- start: header -->
			<header class="header">
				<div class="logo-container">
					<a href="../" class="logo">
						<img src="assets/images/logo.png" height="35" alt="Smart Wave | Dashboard" />
					</a>
					<div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
						<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
					</div>
				</div>
			
				<!-- start: search & user box -->
				<div class="header-right">
			
					<form action="pages-search-results.html" class="search nav-form">
						<div class="input-group input-search">
							<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>
			
					<span class="separator"></span>
			
					<div id="userbox" class="userbox">
						<a href="#" data-toggle="dropdown">
							<figure class="profile-picture">
								<img src="assets/images/user.png" alt="<?php echo decrypt($user['username']);?>" class="img-circle" data-lock-picture="assets/images/user.png" />
							</figure>
							<div class="profile-info" data-lock-name="<?php echo decrypt($user['username']);?>" data-lock-email="<?php echo decrypt($user['email']);?>">
								<span class="name"><?php echo decrypt($user['username']); ?></span>
								<span class="role">Administrator</span>
							</div>
			
							<i class="fa custom-caret"></i>
						</a>
			
						<div class="dropdown-menu">
							<ul class="list-unstyled">
								<li class="divider"></li>
								<li>
									<a role="menuitem" tabindex="-1" href="account.php"><i class="fa fa-user"></i> My Profile</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="log.php" data-lock-screen="true"><i class="fa fa-lock"></i> Lock Screen</a>
								</li>
								<li>
									<a role="menuitem" tabindex="-1" href="logout.php"><i class="fa fa-power-off"></i> Logout</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<!-- end: search & user box -->
			</header>
			<!-- end: header -->

			<div class="inner-wrapper">
				<!-- start: sidebar -->
				<aside id="sidebar-left" class="sidebar-left">
				
					<div class="sidebar-header">
						<div class="sidebar-title">
							Navigation
						</div>
						<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
							<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
						</div>
					</div>
				
					<div class="nano">
						<div class="nano-content">
							<nav id="menu" class="nav-main" role="navigation">
								<ul class="nav nav-main">
									<li class="nav-active">
										<a href="index.php">
											<i class="fa fa-home" aria-hidden="true"></i>
											<span>Dashboard</span>
										</a>
									</li>
									
									<li class="nav-parent">
										<a>
											<i class="fa fa-cogs" aria-hidden="true"></i>
											<span>Device Settings</span>
										</a>
										<ul class="nav nav-children">
											<li>
												<a href="add-device.php">
													 Add Device
												</a>
											</li>
										</ul>
									</li>
									
								</ul>
							</nav>	
					</div>
				
				</aside>
				<!-- end: sidebar -->

				<section role="main" class="content-body">
					<header class="page-header">
						<h2>Dashboard</h2>
					
						<div class="right-wrapper pull-right">
							<ol class="breadcrumbs">
								<li>
									<a href="index.php">
										<i class="fa fa-home"></i>
									</a>
								</li>
								<li><span>Dashboard</span></li>
							</ol>
					
							<a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
						</div>
					</header>

					<div class="row">

					<div class="col-md-6">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Inactive Devices</h2>
								</header>
								<div class="panel-body">
										<div class="table-responsive">
											<?php if(count($inactdevices)<=0){?>
												<div class="col-md-12">
													<section class="panel panel-danger">
														<header class="panel-heading">
															<h2 class="panel-title">No Devices</h2>
														</header>
														<div class="panel-body">
															<code>Currently No devices added.</code>
															<code>Please add your device..</code>
															<h4><a href="add-device.php"><i class="fa fa-plus"> ADD </i></a></h4>
														</div>
													</section>
												</div>
<!-- 
												<h2>Currently No devices added.</h2>
												<h3>Please add your device.</h3>
												<h4><a href="add-device.php"><i class="fa fa-plus"> ADD </i></a></h4> -->
											<?php } else{?>
											<table class="table mb-none">
												<thead>
													<tr>
														<th>Device Name</th>
														<th>Device Number</th>
													</tr>
												</thead>
												<tbody>
												<?php for ($Y = 0; $Y < count($inactdevices); $Y++) {?>
													<tr>
														<td><?php echo($inactdevices[$Y]["DeviceName"]); ?></td>
														<td><?php echo($inactdevices[$Y]["DeviceID"]);?></td>
														<td class="actions">
														<form id="on-device-form" action="./includes/process-on-device.php" method="post" role="form">
															<input type="hidden" name="DeviceID" id="DeviceID" value="<?php echo($inactdevices[$Y]["DeviceID"]);?>">
															<button type="submit" value="ON"><i class="fa fa-bolt">ON</i></button>
														</form>
														</td>
													</tr>
												<?php }?>
												</tbody>
											</table>
											<?php }?>
										</div>
									</div>
								</div>
							</section>
						</div>

						<div class="col-md-6">
							<section class="panel">
								<header class="panel-heading">
									<h2 class="panel-title">Active Devices</h2>
								</header>
								<div class="panel-body">
										<div class="table-responsive">
											<?php if(count($devices)<=0){?>
												<div class="col-md-12">
													<section class="panel panel-danger">
														<header class="panel-heading">
															<h2 class="panel-title">No Devices</h2>
														</header>
														<div class="panel-body">
															<code>Currently No devices added.</code>
															<code>Please add your device..</code>
															<h4><a href="add-device.php"><i class="fa fa-plus"> ADD </i></a></h4>
														</div>
													</section>
												</div>
<!-- 
												<h2>Currently No devices added.</h2>
												<h3>Please add your device.</h3>
												<h4><a href="add-device.php"><i class="fa fa-plus"> ADD </i></a></h4> -->
											<?php } else{?>
											<table class="table mb-none">
												<thead>
													<tr>
														<th>Device Name</th>
														<th>Device Number</th>
													</tr>
												</thead>
												<tbody>
												<?php for ($x = 0; $x < count($devices); $x++) {?>
													<tr>
														<td><?php echo($devices[$x]["DeviceName"]); ?></td>
														<td><?php echo($devices[$x]["DeviceID"]);?></td>
														<td class="actions">
														<form id="on-device-form" action="./includes/process-off-device.php" method="post" role="form">
															<input type="hidden" name="DeviceID" id="DeviceID" value="<?php echo($devices[$x]["DeviceID"]);?>">
															<button type="submit" value="OFF"><i class="fa fa-bolt">OFF</i></button>
														</form>
														</td>
													</tr>
												<?php }?>
												</tbody>
											</table>
											<?php }?>
										</div>
									</div>
								</div>
							</section>
						</div>
					</div>

					<!-- start: page -->
					
					
					<!-- end: page -->
				</section>
			</div>

			<aside id="sidebar-right" class="sidebar-right">
				<div class="nano">
					<div class="nano-content">
						<a href="#" class="mobile-close visible-xs">
							Collapse <i class="fa fa-chevron-right"></i>
						</a>
			
						<div class="sidebar-right-wrapper">
			
							<div class="sidebar-widget widget-calendar">
								<h6>Upcoming Tasks</h6>
								<div data-plugin-datepicker data-plugin-skin="dark" ></div>
			
								<ul>
									<li>
										<time datetime="<?php echo date("Y-m-d");?>"><?php echo date("Y-m-d");?></time>
										<span>Company Meeting</span>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</aside>
		</section>

		<!-- Vendor -->
		<script src="assets/vendor/jquery/jquery.js"></script>
		<script src="assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.js"></script>
		<script src="assets/vendor/nanoscroller/nanoscroller.js"></script>
		<script src="assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="assets/vendor/magnific-popup/magnific-popup.js"></script>
		<script src="assets/vendor/jquery-placeholder/jquery.placeholder.js"></script>
		
		<!-- Specific Page Vendor -->
		<script src="assets/vendor/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="assets/vendor/jquery-ui-touch-punch/jquery.ui.touch-punch.js"></script>
		<script src="assets/vendor/jquery-appear/jquery.appear.js"></script>
		<script src="assets/vendor/bootstrap-multiselect/bootstrap-multiselect.js"></script>
		<script src="assets/vendor/jquery-easypiechart/jquery.easypiechart.js"></script>
		<script src="assets/vendor/flot/jquery.flot.js"></script>
		<script src="assets/vendor/flot-tooltip/jquery.flot.tooltip.js"></script>
		<script src="assets/vendor/flot/jquery.flot.pie.js"></script>
		<script src="assets/vendor/flot/jquery.flot.categories.js"></script>
		<script src="assets/vendor/flot/jquery.flot.resize.js"></script>
		<script src="assets/vendor/jquery-sparkline/jquery.sparkline.js"></script>
		<script src="assets/vendor/raphael/raphael.js"></script>
		<script src="assets/vendor/morris/morris.js"></script>
		<script src="assets/vendor/gauge/gauge.js"></script>
		<script src="assets/vendor/snap-svg/snap.svg.js"></script>
		<script src="assets/vendor/liquid-meter/liquid.meter.js"></script>
		<script src="assets/vendor/jqvmap/jquery.vmap.js"></script>
		<script src="assets/vendor/jqvmap/data/jquery.vmap.sampledata.js"></script>
		<script src="assets/vendor/jqvmap/maps/jquery.vmap.world.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.africa.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.asia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.australia.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.europe.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.north-america.js"></script>
		<script src="assets/vendor/jqvmap/maps/continents/jquery.vmap.south-america.js"></script>
		
		<!-- Theme Base, Components and Settings -->
		<script src="assets/javascripts/theme.js"></script>
		
		<!-- Theme Custom -->
		<script src="assets/javascripts/theme.custom.js"></script>
		
		<!-- Theme Initialization Files -->
		<script src="assets/javascripts/theme.init.js"></script>


		<!-- Examples -->
		<script src="assets/javascripts/dashboard/examples.dashboard.js"></script>
	</body>
</html>