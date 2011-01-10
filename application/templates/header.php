<!doctype html>
<!--[if lt IE 7 ]> <html class="ie6 no-js"> <![endif]-->
<!--[if IE 7 ]>    <html class="ie7 no-js"> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 no-js"> <![endif]-->
<!--[if IE 9 ]>    <html class="ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

		<title><?php echo get_meta($controller, 'title', $meta) ?> &mdash; <?php echo $site ?></title>

		<meta name="description" content="<?php echo get_meta($controller, 'desc', $meta) ?>" />
		<meta name="viewport"    content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />

		<link rel="shortcut icon"    href="/favicon.ico" />
		<link rel="apple-touch-icon" href="/apple-touch-icon.png" />

		<link rel="stylesheet" media="screen" href="/-/stylesheets/common.css" />
		<link rel="stylesheet" media="screen" href="/-/stylesheets/master.css" />
		<link rel="stylesheet" media="print"  href="/-/stylesheets/print.css" />

        <!--[if lte IE 6]>
        <link rel="stylesheet" href="http://universal-ie6-css.googlecode.com/files/ie6.1.1.css" media="screen, projection">
        <![endif]-->

        <?php // echo google_analytics('lkajhrdgkljearg') ?>

		<script src="/-/js/modernizr-1.5.min.js"></script>
	</head>

	<?php ob_flush() ?>
		
	<body id="<?php echo $controller ?>" class="<?php echo $action ?>">
		<div class="access_links no_print">
			<a href="/">Return to the home page</a> &middot;
			<a href="#navigation">Skip to main navigation</a> &middot;
			<a href="#content">Skip to content</a>
		</div>

		<div class="wrapper">
			<header class="clearfix">
				<h1><a href="/"><?php echo $site ?></a></h1>
			</header>

			<h1 id="page_title"><?php echo get_title($controller, $action) ?></h1>

			<div class="clearfix" id="page">
