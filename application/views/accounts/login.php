<?php

	if (!$post_values['login']) :

		render_partial('login_form');

	else :

		if ($errors == FALSE) {
			$alert_title = '';
			$alert_intro = '';
			alert('done', $alert_title, $alert_intro);
		}
		else {
			render_partial('login_form', compact('post_values', 'errors'));
		}

	endif;
