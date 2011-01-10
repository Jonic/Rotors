<?php

	if ($errors) {
		$alert_title = '';
		$alert_intro = '';
		alert('error', $alert_title, $alert_intro, $errors);
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

			<p class="clearfix">
				<label for="emai;">Email Address <span class="asterisk">*</span></label>
				<input <?php is_error($errors, 'email') ?> id="email" name="email" type="text" value="<?php echo $post_values['email'] ?>" />
			</p>

			<p class="submit"><button name="register" type="submit" value="true">Submit &raquo;</button></p>
		</fieldset>
	</form>
