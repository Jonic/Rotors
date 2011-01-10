<?php

	if ($errors) {
		alert('error', $alert_title, $alert_intro, $errors);
	}

	if ($_SESSION['logged_out']) {
		$alert_title = 'Logged Out';
		$alert_intro = 'You are no longer logged in to your account';

		alert('done', $alert_title, $alert_intro);
		
		unset($_SESSION['logged_out']);
	}

?>

			<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" class="accounts_form" method="post">
				<fieldset>
					<p class="clearfix">
						<label for="username">Username <span class="asterisk">*</span></label>
						<input <?php is_error($errors, 'username') ?> id="username" name="username" type="text" value="<?php echo $post_values['username'] ?>" />
					</p>

					<p class="clearfix">
						<label for="password">Password <span class="asterisk">*</span></label>
						<input <?php is_error($errors, 'password') ?> id="password" name="password" type="password" />
					</p>

					<p class="submit"><button name="login" type="submit" value="true">Submit &raquo;</button></p>
				</fieldset>
			</form>
