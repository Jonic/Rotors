<?php

    session_remove('id');
    session_remove('logged_in');
    session_remove('username');
    session_remove('admin');

    $_SESSION['logged_out'] = TRUE;

    header('location: /accounts/login');
    exit;
