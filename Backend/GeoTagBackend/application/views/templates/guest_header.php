
<!-- Marko Hudomal 0112/15 -->


<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
		<link rel="icon" href="<?php echo base_url()?>img/logo.png">
		<title>GeoTag</title>


		<!-- Custom stlylesheet -->
		<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>css/mystyle.css" />
		<script src="<?php echo base_url()?>js/myjs.js"></script>
	</head>
	
	<body >
		
		<nav class="stroke navbar navbar-expand-md navbar-dark" style="background-image: url('<?php echo base_url()?>img/header.jpg'); margin:10px;margin-bottom:60px; border-radius: 3px">
			<!-- Logo -->
			<a class="navbar-brand" href="<?php echo base_url()?>index.php/guest/load/guest_home" style="height:50px; margin-left:50px">
					<img src="<?php echo base_url()?>img/logo.png" alt="logo" align=left style="width:110px;">
			</a>
			<!-- /Logo -->
	
			<!-- kada se smanji prozor da se pojavi collapse button -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<!-- likovi -->
			<div class="collapse navbar-collapse" style="text-align:right" id="collapsibleNavbar">
				<ul class="navbar-nav mx-auto">
					<li class="nav-item">
						<a class="nav-link <?php if ($page == 'guest_home') echo "active"; ?>" href="<?php echo base_url()?>index.php/guest/load/guest_home">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if ($page == 'guest_statistics') echo "active"; ?>" href="<?php echo base_url()?>index.php/guest/getStatistics">View statistics</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if ($page == 'index.php') echo "active"; ?>" href="<?php echo base_url()?>">Sign up</a>
					</li> 
					<li class="nav-item">
						<a class="nav-link <?php if ($page == 'guest_about') echo "active"; ?>" href="<?php echo base_url()?>index.php/guest/load/guest_about">About</a>
					</li> 
					<li class="nav-item">
						<a class="nav-link <?php if ($page == 'guest_help') echo "active"; ?>" href="<?php echo base_url()?>index.php/guest/load/guest_help">Help</a>
					</li> 
				</ul>

				<a href="#"><span id="username_korisnika" style="color:white"> </span></a>
				&nbsp;
				<span id="tip_korisnika" class="badge badge-info">Guest</span>

				<img id="slika_korisnika" class="rounded_circle"  src="<?php echo base_url()?>img/avatar.png" style="width:50px; margin-left:20px;margin-right:10px">

			</div> 
		</nav>
