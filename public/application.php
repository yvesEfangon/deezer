<?php


error_reporting(E_ALL);

function appAutoload($className){

    $className = str_replace(array('deezer\\Helper\\','deezer\\Controller\\','deezer\\Model\\','deezer\\Entity\\','deezer\\DB\\','deezer\\'),'',$className);

    if(is_file(__DIR__.'/../src/Controller/'.$className.'.php')){

        require_once __DIR__.'/../src/Controller/'.$className.'.php';

    }elseif (is_file(__DIR__.'/../src/DB/'.$className.'.php')){
        require_once __DIR__.'/../src/DB/'.$className.'.php';

    }elseif (is_file(__DIR__.'/../src/Entity/'.$className.'.php')){
        require_once __DIR__.'/../src/Entity/'.$className.'.php';

    }elseif (is_file(__DIR__.'/../src/Helper/'.$className.'.php')){

        require_once __DIR__.'/../src/Helper/'.$className.'.php';

    }elseif (is_file(__DIR__.'/../src/Model/'.$className.'.php')){
        require_once __DIR__.'/../src/Model/'.$className.'.php';

    }elseif(is_file(__DIR__.'/../src/'.$className.'.php')){

        require_once( __DIR__.'/../src/'.$className.'.php');
    }
}

//Autoload
spl_autoload_register('appAutoload');


session_start();

use deezer\Deezer;

$_SESSION['input']   = json_decode(file_get_contents('php://input'), true);
$deezer = new Deezer();

echo $deezer->execute();


?>
