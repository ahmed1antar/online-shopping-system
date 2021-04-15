<?php
    include 'connect.php';

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

    if(!isset($noNavbar))
    {
        include $tpl . 'navbar.php';
    }
