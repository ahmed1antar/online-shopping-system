<?php

    /* error reporting */
    ini_set('display_errors','On');
    error_reporting(E_ALL);

    include 'admin/connect.php';

    // routes
    $tpl  = 'includes/templets/';
    $func = 'includes/functions/';
    $lang = 'includes/languages/';
    $css  = 'layout/css/';
    $js   = 'layout/js/';
    $img  = 'layout/images/';

    // includes files
    include $func . 'function.php';
    include $lang . 'english.php';
    include $tpl . 'header.php';
    