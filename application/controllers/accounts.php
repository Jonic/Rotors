<?php

    function accounts_logged_in_redirect()
    {

        $destination = isset($_SESSION['login_destination']) ? $_SESSION['login_destination'] : '/admin';

        unset($_SESSION['login_destination']);

        header('location: ' . $destination);
        exit;

    }



    function accounts_start_session($id)
    {

        if ($user = user_exists('id', $id, TRUE)) {
            extract($user);

            session_set('id',        $id);
            session_set('logged_in', TRUE);
            session_set('username',  $username, FALSE);

            if ($admin !== 0) {
                session_set('admin', TRUE, FALSE);
            }

            mysql_query('UPDATE users SET `last_logged_in` = NOW() WHERE id = ' . $id);

            accounts_logged_in_redirect();
        }

    }



    function login_process($post_values, $config)
    {

        $errors = array();

        //  Error checking done - now on to processing it proper

        if ($user = user_exists('username', $post_values['username'], TRUE)) {
            extract($user);

            if ($password == sha1($password_hash . $post_values['password'])) {
                accounts_start_session($id);
            }
            else {
                $errors['password'] = 'Your <strong>password</strong> is incorrect';
            }
        }
        else {
            $errors['username'] = 'No such account with that <strong>username</strong>';
        }

        //  Done.. Now, what are we returning?

        return array($post_values, $errors);

    }



    function register_process($post_values, $config)
    {

        $errors = array();

        $username = $post_values['username'];
        $password = $post_values['password'];
        $email    = validate_email_address($post_values['email']);

        if (!$username || strlen($username) < 5) {
            $errors['username'] = "You username must be at least <strong>5 characters</strong>";
        }

        if ($user = user_exists('username', $username)) {
            $errors['username'] = "Your chosen username is unavailable";
        }

        if (!$password || strlen($password) < 8) {
            $errors['password'] = "Your password must be at least <strong>8 characters</strong>";
        }

        if (!$email) {
            $errors['email'] = "Please provide a <strong>valid email addresss</strong>";
        }

        if ($user = user_exists('email_address', $email)) {
            $errors['email'] = "Your email address is already associated with an account";
        }

        //  Error checking done - now on to processing it proper

        if (count($errors) == 0) {
            $passhash = str_shuffle(sha1(time() . $config['hash_salt']));
            $password = sha1($passhash . $password);

            $user_insert_sql = '
                INSERT INTO users
                (
                    `username`,
                    `password`,
                    `password_hash`,
                    `email_address`,
                    `created_at`,
                    `updated_at`
                )
                VALUES
                (
                    "' . $username . '",
                    "' . $password . '",
                    "' . $passhash . '",
                    "' . $email . '",
                    NOW(),
                    NOW()
                )
            ';

            $user_insert = mysql_query($user_insert_sql) or die (mysql_error());

            if ($user_insert) {
                $user_id = mysql_insert_id();
                accounts_start_session($user_id);
            }
        }

        //    Done.. Now, what are we returning?
        return array($post_values, $errors);

    }



    //    Functions defined - do it up good!

    if ($_POST['register']) {
        list($post_values, $errors) = register_process($post_values, $config);   
    }

    if ($_POST['login']) {
        list($post_values, $errors) = login_process($post_values, $config);
    }
