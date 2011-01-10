<?php

    function _e($string) {

        echo _($string);

    }



	function alert($type, $title = FALSE, $intro = FALSE, $messages = FALSE)
	{

		echo "\n\t" . '<div class="alert ' . $type . '">';
		
		if ($title) {
			echo "\n\t\t" . '<h2>' . $title . '</h2>';
		}

		if ($intro) {
			echo "\n\t\t" . '<p>' . $intro . '</p>';
		}

		if ($messages) {
			foreach ($messages as $message) {
				if ($message !== TRUE) {
					$output_messages[] = $message;
				}
			}
		}

		if ($output_messages) {
			echo "\n\t\t" . '<ul>';

			foreach ($output_messages as $message) {
				echo "\n\t\t\t" . '<li>' . $message . '</li>';
			}

			echo "\n\t\t" . '</ul>';
		}

		echo "\n\t" . '</div>';

	}



	function check_actionable($uri, $actionable_routes, $root)
	{

		if ($action = $actionable_routes[$uri]) {
			$action_file = $root . '/application/actions/' . $action . '.php';

			if (file_exists($action_file)) {
				require_once $action_file;
			}
			else {
				exit('Could not invoke action: ' . $action_file);
			}
		}

	}



	function check_authorised($protected_routes, $admin = FALSE, $controller, $action, $uri)
	{

		$protected  = FALSE;
		$controller = $admin === FALSE ? $protected_routes[$controller] : $protected_routes['admin'][$controller];
		$actions    = array();

		if ($controller !== FALSE) {
			if ($controller === TRUE) {
				$protected = TRUE;
			}
			else {
				if (is_array($controller)) {
					$actions = $controller;
				}
				else {
					$actions[] = $controller;
				}

				if (in_array($action, $actions)) {
					$protected = TRUE;
				}
			}

			if ($protected === TRUE) {
				$id = session_get('id');

				if ($id !== FALSE && ($user = user_exists('id', $id, TRUE) !== FALSE)) {
					if ($username != session_get('username', FALSE)) {
						$_SESSION['login_destination'] = $uri;

						header ('location: /accounts/login');
						exit;
					}
				}
			}
		}

	}



	function clean_post_values($values)
	{

		if ($values) {
		    $cleaned = array();

			foreach ($values as $key => $val) {
				if (is_array($val)) {
					$cleaned[$key] = clean_post_values($val);
				}
				else {
					$cleaned[$key] = stripslashes($val);
				}
			}

			return $cleaned;
		}

	}



	function config_val($name)
	{

		global $config;

		return $config[$name];
		
	}



	function db_connect()
	{

		extract(config_val('db'));

		$link = mysql_connect($host, $user, $pass);

		if (!$link) {
		    die ('Not connected: ' . mysql_error());
		}

		$db_selected = mysql_select_db($name, $link);

		if (!$db_selected) {
		    die ("Can't connect to {$name}: " . mysql_error());
		}

		return $link;

	}



	function get_meta($controller, $type, $meta)
	{

		return $meta = isset($meta[$controller][$type]) ? $meta[$controller][$type] : $meta['default'][$type];

	}



	function get_title($controller, $action)
	{

		$title = $action === 'index' ? $controller : $action;
		$title = $title  === 'home'  ? $default    : ucwords(str_replace('-', ' ', $title));

		return $title;

	}



	function get_value($array, $key)
	{

		if (isset($array[$key])) {
			echo $array[$key];
		}

	}



    function google_analytics($analytics_code = FALSE)
    {

        if ($analytics_code !== FALSE) {
            $return = '<script type="text/javascript">';
    		$return.= "\n\t\t" . 'var _gaq = _gaq || [];' . "\n";

    		$return.= "\n\t\t" . '_gaq.push(["_setAccount", "' . $analytics_code . '"]);';
    		$return.= "\n\t\t" . '_gaq.push(["_trackPageview"]);' . "\n";

    		$return.= "\n\t\t" . '(function () {';
    		$return.= "\n\t\t\t" . 'var ga = document.createElement("script"),';
    		$return.= "\n\t\t\t" . 's  = document.getElementsByTagName("script")[0];' . "\n";

    		$return.= "\n\t\t\t" . 'ga.async = true;';
    		$return.= "\n\t\t\t" . 'ga.src   = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";' . "\n";

    		$return.= "\n\t\t" . 's.parentNode.insertBefore(ga, s);';
    		$return.= "\n\t\t" . '}());';
    		$return.= "\n\t" . '</script>';

    		return $return;
        }

    }



    function flash($key, $val) {



    }



	function is_active($this, $that, $return = false)
	{

		if ($this === $that) {
			if (!$return) {
				return 'active';
			}

			echo 'active';
		}

	}



	function is_checked($this, $that, $return = FALSE)
	{

		if ($this === $that) {
			$result = 'checked="checked"';

			if ($return) {
				return $result;
			}

			echo $result;
		}

	}



	function is_error($array, $key, $return = FALSE)
	{

		if (isset($array[$key])) {
			$result = 'class="error"';

			if ($return) {
				return $result;
			}

			echo $result;
		}

	}



	function obfuscate_email($email, $text = '" + d + "')
	{

		$character_set = '+-.0123456789@ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
		$key           = str_shuffle($character_set);
		$cipher_text   = '';
		$id            = 'e' . rand(1, 999999999);

		for ($i = 0; $i < strlen($email); ++$i) {
			$cipher_text .= $key[strpos($character_set, $email[$i])];
		}

		$script  = 'var a = "' . $key .'",' . "\n";		
		$script .= 'b = a.split("").sort().join(""),' . "\n";
		$script .= 'c = "' . $cipher_text . '",' . "\n";
		$script .= 'd = "",' . "\n";
		$script .= 'e = 0;' . "\n";

		$script .= 'for (e; e < c.length; e++) {' . "\n";
		$script .= 'd += b.charAt(a.indexOf(c.charAt(e)));' . "\n";
		$script .= '}' . "\n";

		$script .= 'document.getElementById("' . $id . '").innerHTML = "<a href=\\"mailto:" + d + "\\">' . $text . '</a>";';

		$script = "eval(\"" . str_replace(array("\\", '"'), array("\\\\", '\"'), $script) . "\");";
		$script = '<script type="text/javascript">/*<![CDATA[*/' . $script . '/*]]>*/</script>';

		return '<span id="' . $id . '">[Email address protected by JavaScript]</span>' . $script;

	}



	function render_partial($partial, $arguments = FALSE)
	{

		global $root, $controller;

		$partial_file = $root . '/application/views/' . $controller . '/_' . $partial . '.php';

		if (file_exists($partial_file)) {
			if (is_array($arguments)) {
				extract($arguments);
			}

			require $partial_file;
		}
		else {
			exit('<h1>Unable to include partial: ' . $partial_file . '</h1>');
		}
		
	}



	function session_get($key)
	{

		if ($key) {
			if (!$_SESSION[$key]) {
				$key = string_encrypt(config_val('session_name') . $key);
			}

			return $_SESSION[$key];
		}

	}



	function session_remove($key)
	{

		if ($key) {
			if ($_SESSION[$key]) {
				$key = string_encrypt(config_val('session_name') . $key);
			}

			unset($_SESSION[$key]);
		}

	}



	function session_set($key, $val, $secure = TRUE)
	{

		if ($key && $val) {
			if ($secure) {
				$key = string_encrypt(config_val('session_name') . $key);
				$val = string_encrypt($val);
			}

			$_SESSION[$key] = $val;
		}

	}



	function string_decrypt($value)
	{

		$key = config_val('hash_salt');

		if ($key && $value) {
			return rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($value), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
		}

	}



	function string_encrypt($value)
	{

		$key = config_val('hash_salt');

		if ($key && $value) {
			return base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $value, MCRYPT_MODE_CBC, md5(md5($key))));
		}

	}



	function user_exists($column, $value, $return_user = FALSE)
	{

		$get_user_q = 'SELECT * FROM users WHERE `' . $column . '` = "' . $value . '" LIMIT 1';
		$get_user   = mysql_query($get_user_q);

		if (!$get_user) {
			exit(mysql_error());
		}

		if (mysql_num_rows($get_user) > 0) {
			return $return_user !== FALSE ? mysql_fetch_assoc($get_user) : TRUE;
		}

		return;

	}



	function validate_email_address($email)
	{

		if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
			return false;
		}

		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);

		for ($i = 0; $i < sizeof($local_array); $i++) {
			if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
				return false;
			}
		}

		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
			$domain_array = explode(".", $email_array[1]);

			if (sizeof($domain_array) < 2) {
				return false;
			}

			for ($i = 0; $i < sizeof($domain_array); $i++) {
				if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
					return false;
				}
			}
		}

		return $email;

	}
