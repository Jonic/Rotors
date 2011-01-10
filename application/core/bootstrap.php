<?php

    //  Turn on Zlib output compression - regular OB fallback if not supported
    if (!ob_start('ob_gzhandler')) {
        ob_start();
    }

	//	Make Session go now
	session_start();

    //  Site won't and don't work if this file ain't included, yo..
	require_once $root . '/application/core/functions.php';

    //	We've done as much as we can without connecting to the database
	$db_cnx = db_connect();

	//	Handle routes
	require_once $root . '/application/core/routes.php';

	//	Where's the content coming from, then?
	$content_file = $root . '/application/views/' . $controller . '/' . $action . '.php';

	//	Has anything been posted?
	if (!empty($_POST)) {
		$post_values = clean_post_values($_POST);
	}

	//	Get the model, if there is one
	$model_file = $root . '/application/models/' . $controller . '.php';

	if (file_exists($model_file)) {
		require_once $model_file;
	}

	//	Get section specific functions
	$functions_file = $root . '/application/controllers/' . $controller . '.php';

	if (file_exists($functions_file)) {
		require_once $functions_file;
	}

	//	Get Header
	require_once $root . '/application/templates/header.php';

	//  Include content
	require_once $content_file;

	//	Get Footer
	require_once $root . '/application/templates/footer.php';

    //  Close the damn database connection
    mysql_close($db_cnx);

    //  Flush and return output buffer
    header('Content-length: ' . ob_get_length());
    while (@ob_end_flush());
