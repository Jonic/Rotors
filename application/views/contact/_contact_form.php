<?php

    if ($errors) {
        alert('error', $alert_title, $alert_intro, $errors);
    }

?>

        	<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" class="contact_form" method="post">
        		<fieldset>
        			<p class="clearfix name">
        				<label for="contact_name">Name <span class="asterisk">*</span></label>
        				<input <?php is_error($errors, 'contact_name'); ?> id="contact_name" name="contact_name" type="text" value="<?php echo $post_values['contact_name']; ?>" />
        			</p>

        			<p class="clearfix email">
        				<label for="contact_email">Email Address <span class="asterisk">*</span></label>
        				<input <?php is_error($errors, 'contact_email'); ?> id="contact_email" name="contact_email" type="text" value="<?php echo $post_values['contact_email']; ?>" />
        			</p>

        			<p class="clearfix subject">
        				<label for="contact_subject">Subject <span class="asterisk">*</span></label>
        				<input <?php is_error($errors, 'contact_subject'); ?> id="contact_subject" name="contact_subject" type="text" value="<?php echo $post_values['contact_subject']; ?>" />
        			</p>

        			<p class="clearfix">
        				<label for="contact_message">Message <span class="asterisk">*</span></label>
        				<textarea <?php is_error($errors, 'contact_message'); ?> cols="20" id="contact_message" name="contact_message" rows="5"><?php echo $post_values['contact_message']; ?></textarea>
        			</p>

        			<p class="submit"><button name="contact_submit" type="submit" value="true">Submit &raquo;</button></p>
        		</fieldset>
        	</form>
