<?php

namespace deezer\View;

session_start();
error_reporting(1);

//Use http_response_code

$method     = $_SERVER['REQUEST_METHOD'];

switch ($method) {

    case 'GET':
        break;
    case 'POST':
        break;
    case 'DELETE':
        break;
    case 'PUT':
        break;
}



?>
