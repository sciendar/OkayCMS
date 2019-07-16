<?php
    ini_set('display_errors', 1);
    session_start();
    
    require_once 'libs/libs.php';
    require_once 'core/Model.php';
    require_once 'core/Design.php';
    require_once 'core/Controller.php';
    require_once 'core/route.php';
    
    Route::start();
    
    