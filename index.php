<?php

	//	Variables
	$debug_mode = TRUE;

    //	Error reporting
	if ($debug_mode !== FALSE) {
		ini_set('display_errors', TRUE);
		error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
	}

	//	Init some vars and include some stuff
	$root = $_SERVER['DOCUMENT_ROOT'];

	//	Production Mode Config
	$config = array(
		'db' => array(
			'host' => 'localhost',
			'user' => '',
			'pass' => '',
			'name' => '',
		),
		'dev' => FALSE,
		'contact_email' => 'admin@example.com',
		'contact_name'  => 'Johnny Appleseed',
		'hash_salt'     => '_ev}Dt,U5`wc;!=Hs^!,vW4_y-mc1)[U5|Opi1qiGQmp[inNe;$i-w/ `uUKW>:S',
		'session_name'  => 'rotors',
	);

    //	Override bits for Dev Mode
	if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
		$config['db'] = array(
			'host' => 'localhost',
			'user' => 'root',
			'pass' => 'root',
			'name' => 'rotors',
		);

		$config['dev']           = TRUE;
		$config['contact_email'] = 'jonic@100yen.co.uk';
		$config['contact_name']  = 'Jonic Linley - Website Name';
		$config['hash_salt']     = 'YryUg/jPJ@#ftf8c, X-yyKkS.+j>u5-Y6!]_-=c*-,F[Ph+F@abh7(|XR3qVMMN';
	}

    //  If a route is intended to invoke an action, declare it here
	$actionable_routes = array(	
		'accounts/logout' => 'logout',
	);

    //  The routes are only accessible to users who are logged in
	$protected_routes = array(
		'admin' => array(
			'dashboard' => TRUE,
			'posts'     => array('new', 'edit', 'delete', 'view'),
		),
		'accounts'  => 'edit',
		'forum'     => TRUE,
	);

    //  FIX UP; LOOK SHARP
    require_once $root . '/application/core/bootstrap.php';
