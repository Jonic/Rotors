<?php

	function contact_form($values, $errors) {

		if ($errors) {
			$alert_title = 'Oops';
			$alert_intro = 'There was a problem processing your contact submission. Please fix any errors below and try again.';
			alert('error', $alert_title, $alert_intro, $errors);
		}

?>

			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="contact_form" method="post">
				<fieldset>
					<p class="clearfix name">
						<label for="contact_name">Name <span class="asterisk">*</span></label>
						<input <?php is_error($errors, 'contact_name'); ?> id="contact_name" name="contact_name" type="text" value="<?php echo $values['contact_name']; ?>" />
					</p>

					<p class="clearfix email">
						<label for="contact_email">Email Address <span class="asterisk">*</span></label>
						<input <?php is_error($errors, 'contact_email'); ?> id="contact_email" name="contact_email" type="text" value="<?php echo $values['contact_email']; ?>" />
					</p>

					<p class="clearfix subject">
						<label for="contact_subject">Subject <span class="asterisk">*</span></label>
						<input <?php is_error($errors, 'contact_subject'); ?> id="contact_subject" name="contact_subject" type="text" value="<?php echo $values['contact_subject']; ?>" />
					</p>

					<p class="clearfix">
						<label for="contact_message">Message <span class="asterisk">*</span></label>
						<textarea <?php is_error($errors, 'contact_message'); ?> cols="20" id="contact_message" name="contact_message" rows="5"><?php echo $values['contact_message']; ?></textarea>
					</p>

					<p class="submit"><button name="contact_submit" type="submit" value="true">Submit &raquo;</button></p>
				</fieldset>
			</form>

<?php

	}



	function contact_process($values, $config) {

		$errors = array();

		$contact_name    = $values['contact_name'];
		$contact_email   = $values['contact_email'];
		$contact_subject = $values['contact_subject'];
		$contact_message = $values['contact_message'];

		if (!$contact_name) {
			$errors['contact_name'] = "You must enter your <strong>name</strong>";
		}

		if (!check_email_address($contact_email)) {
			$errors['contact_email'] = "Please enter a valid <strong>email address</strong>";
		}

		if (!$contact_subject) {
			$errors['contact_subject'] = "You must give your messages a <strong>subject</strong>";
		}

		if (!$contact_message) {
			$errors['contact_message'] = "You did not write your <strong>message</strong>";
		}

		//	Error checking done - now on to processing it proper

		if (count($errors) == 0) {

			//	Prep email vars
			$email['to_name']  = $config['contact_name'];
			$email['to_email'] = $config['contact_email'];

			$email['from_name']  = $contact_name;
			$email['from_email'] = $contact_email;

			$email['subject']  = $contact_subject;

			$email['message']  = 'Someone has gotten in touch through the contact form on your site, yo...'."\n\n";

			$email['message'] .= 'Name:    '.$contact_name."\n";
			$email['message'] .= 'Message: '.$contact_message."\n";

			//	Send it

			$email['headers'] = "MIME-Version: 1.0\r\n";
			$email['headers'].= "From: ".$email['from_name']." <".$email['from_email'].">\r\n"; 
			$email['headers'].= "Reply-To: ".$email['from_name']." <".$email['from_email'].">\r\n"; 
			$email['headers'].= "X-Mailer: Just My Server";

			$mail_sent = mail($email['to_email'], $email['subject'], $email['message'], $email['headers']);

			if (!$mail_sent) {
				$errors['general'] = "There was a problem sending your email. Please try again, or call us instead.";
			}

		}

		//	Done.. Now, what are we returning?

		return array($values, $errors);

	}



	//	Functions defined - do it up good!

	if ($_POST['contact_submit']) {
		list($values, $errors) = contact_process($values, $config);
	}
