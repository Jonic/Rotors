<?php

    $uri = trim($_GET['_uri'], '/');
	$uri_array = explode('/', $uri);

	list($controller, $action, $id) = $uri_array;

	if ($controller === 'admin') {
		list($admin, $controller, $action, $id) = $uri_array;

		$admin = TRUE;

		if (!$controller) {
			$controller = 'dashboard';
		}
	}

	if (!$controller) {
		$controller = 'home';
	}

	if (!$action) {
		$action = 'index';
	}

	//	Check if this route is intended to invoke a single action
	//	This function can redirect, so watch out for that, yo..
	check_actionable($uri, $actionable_routes, $root);

	//	Check if user is authorised - will redirect if not
	check_authorised($protected_routes, $admin, $controller, $action, $uri);

	//	If admin, alter controller to provide correct inclusion path
	if ($admin) {
		$controller = 'admin/' . $controller;
	}

	//	Check if we're 404ing or not..
	if (!file_exists($root . '/application/views/' . $controller . '/' . $action . '.php')) {
		header('HTTP/1.0 404 Not Found');
		$controller = '404';
		$action     = 'index';
	}
