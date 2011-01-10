<?php

	if (!$post_values['register']) :

		render_partial('register_form');

	else :

		if ($errors == FALSE) {
			$alert_title = '';
			$alert_intro = '';
			alert('done', $alert_title, $alert_intro);
		}
		else {
			render_partial('register_form', compact('post_values', 'errors'));
		}

	endif;
