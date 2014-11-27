<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title><?php echo $site_name ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Projet my meetic est un projet pour la Web academie">
	<meta name="author" content="VILLERS Mickaël">
	<meta name="keywords" content="meetic, webacademie, rencontre">

	<!-- Le styles -->
	<link rel="stylesheet" href="<?php echo $base_url.$assets ?>css/bootstrap.min.css">
	<link rel="stylesheet" href="<?php echo $base_url.$assets ?>css/app.css">
</head>

<body>
	<div class="header-wrap">
		<header class="site-header container">
			<div class="site-logo left">
				<a href="<?php echo $base_url ?>" rel="home">
					<img src="<?php echo $base_url.$assets ?>img/logo.png" alt="LoveStory">
				</a>
			</div>
			<nav class="header-menu right">
				<div class="menu">
					<ul id="menu-main-menu" class="menu">
						<li><a href="<?php echo $base_url ?>">Les Profils</a></li>
						<li><a href="<?php echo $base_url ?>profil/get/<?php echo $member->user_id; ?>">Mon Profil</a></li>
						<li><a href="<?php echo $base_url ?>account/logout">Déconnexion</a></li>
					</ul>
				</div>
			</nav>
		</header>
		<div class="container"><?php echo system\Session::getFlash() ?></div>