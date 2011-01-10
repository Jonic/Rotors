<?php

	if (!$post_values['contact_submit']) :

		render_partial('contact_form');

	else :

		if ($errors == FALSE) {
			$alert_title = _('Thank you');
			$alert_intro = _('Your message is on its way to us. We will be in touch shortly!');
			alert('done', $alert_title, $alert_intro);
		}
		else {
			render_partial('contact_form', compact('post_values', 'errors'));
		}

	endif;
