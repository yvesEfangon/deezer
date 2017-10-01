<?php

require_once __DIR__.'/../Helper/Request.php';
require_once __DIR__.'/../Controller/UserController.php';


session_start();
error_reporting(1);

$_SESSION['input']   = json_encode(file_get_contents('php://input'), true);


$controller     = strtolower(\deezer\Helper\Request::getVar('controller'));
$controllerName = ucfirst($controller).'Controller';

if(!class_exists($controllerName)){
    echo \deezer\Helper\Request::jsonResponse(array(),"The controller was not found",400);
}

$classController    = new \deezer\Controller\UserController();

$method         = strtoupper($_SERVER['REQUEST_METHOD']);

switch ($method) {

    case 'GET':
    case 'POST':
        //Read only
        echo $classController->get();
        break;
    case 'DELETE':
        //Write only

        break;
    case 'PUT':
        //Write only
        $classController->put();
        break;
}



?>
