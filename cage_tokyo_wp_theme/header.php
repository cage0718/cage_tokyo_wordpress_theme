<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700" rel="stylesheet">

	<link rel='stylesheet' href='<?php bloginfo('template_url'); ?>/assets/css/reset.css' type='text/css' media='all' />
	<link rel="stylesheet" href="<?php echo get_stylesheet_uri(); ?>">
	<link rel="icon" sizes="36x36" href="<?php bloginfo('template_url'); ?>/assets/img/favicon.ico">
	<title><?php wp_title(); ?></title>
	<?php wp_head(); ?>
</head>
<body>
	<main>
		<header>
			<div class="container">
				<div class="header_logo">
					<a href="<?php bloginfo('url'); ?>">
						<img src="<?php bloginfo('template_url'); ?>/assets/img/logo_cage-tokyo.svg" alt="cage.tokyo">
					</a>
				</div>
				<ul class="header_about">
					<li class="header_about_item">
						<a href="<?php bloginfo('url'); ?>/about">about</a>
					</li>
					<li class="header_about_item twitter">
						<a href="https://twitter.com/cage_yoshida" target="_new">
							<img src="<?php bloginfo('template_url'); ?>/assets/img/icon_twitter.svg">
						</a>
					</li>
				</ul>
			</div>
		</header>
		<nav>
			<div class="container">
				<ul class="nav_list">
					<li class="nav_list_item"><a href="<?php bloginfo('url'); ?>/wordpress/">WordPress</a></li>
					<li class="nav_list_item"><a href="<?php bloginfo('url'); ?>/develop/">プログラミング</a></li>
					<li class="nav_list_item"><a href="<?php bloginfo('url'); ?>/ipad/">iPad</a></li>
					<li class="nav_list_item"><a href="<?php bloginfo('url'); ?>/marketing/">マーケティング</a></li>
					<li class="nav_list_item"><a href="<?php bloginfo('url'); ?>/design/">デザイン</a></li>
					<li class="nav_list_item"><a href="<?php bloginfo('url'); ?>/bouldering/">ボルダリング</a></li>
					<li class="nav_list_item"><a href="<?php bloginfo('url'); ?>/column/">コラム</a></li>
				</ul>
			</div>
		</nav>