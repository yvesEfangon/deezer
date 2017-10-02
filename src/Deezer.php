<?php

namespace deezer;

use deezer\Controller\UserController as UserController;
use deezer\Helper\Request as Request;

class Deezer
{
    public function execute(){

        $controller     = strtolower(Request::getVar('controller'));
        $controllerName = ucfirst($controller).'Controller';

        if(!class_exists($controllerName)){
            echo Request::jsonResponse(array(),"The controller was not found",400);
        }

        $classController    = new UserController();

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
    }
}
