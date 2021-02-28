<?php
    

    // rout
    $tpl        = "inclued/templates/"; // template path
    $languages  = "inclued/languages/"; // language directory
    $func       ="inclued/function/";
    $css        = "layout/css/"; // css admin path
    $jsAdmin    = "layout/js/"; // js admin path
    

    // inclued file important
    include  $languages . 'english.php'; // include english language file
    include $func . 'function.php';
    include "connect.php"; // db connect file 
    include  $tpl . 'Header.php'; // include header file 
    if(!isset($noNavbar)){include $tpl . 'navbar.php';}
    