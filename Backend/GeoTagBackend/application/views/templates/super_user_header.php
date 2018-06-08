
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
			<a class="navbar-brand" href="<?php echo base_url()?>index.php/super_user/load/guest_home" style="height:50px; margin-left:50px">
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
						<a class="nav-link <?php if ($page == 'guest_home') echo "active"; ?>" href="<?php echo base_url()?>index.php/super_user/load/guest_home">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if ($page == 'guest_statistics') echo "active"; ?>" href="<?php echo base_url()?>index.php/super_user/getStatistics">View statistics</a>
					</li>
					<li class="nav-item">
						<a class="nav-link <?php if ($page == 'super_user_add_destination') echo "active"; ?>" href="<?php echo base_url()?>index.php/super_user/load/super_user_add_destination">Add destination</a>
					</li> 
					<li class="nav-item <?php if ($page == 'guest_about') echo "active"; ?>">
						<a class="nav-link" href="<?php echo base_url()?>index.php/super_user/load/guest_about">About</a>
					</li> 
					<li class="nav-item <?php if ($page == 'guest_help') echo "active"; ?>">
						<a class="nav-link" href="<?php echo base_url()?>index.php/super_user/load/guest_help">Help</a>
					</li> 
				</ul>

				<a href="<?php echo base_url()?>index.php/super_user/preview_profile"><span id="username_korisnika" style="color:white"><?php echo $this->session->userdata('user')->firstname." ".$this->session->userdata('user')->lastname ?></span></a>
				&nbsp;
				<span id="tip_korisnika" class="badge badge-warning">SuperUser</span>
                              
                                <a href="<?php echo base_url()?>index.php/super_user/preview_profile">
				<img id="slika_korisnika" class="rounded_circle_header" src="<?php echo $profile_pic;?>" style="width:50px; margin-left:20px;margin-right:10px">
				</a>
                                <a href="<?php echo base_url()?>index.php/super_user/logout" class="btn btn-dark">logout</a>
			</div> 
		</nav>