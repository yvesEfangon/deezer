<?php

namespace deezer;

use deezer\Controller\UserController ;
use deezer\Helper\Request;


class Deezer
{
    public function execute(){

        $controller     = strtolower(Request::getVar('controller'));

        switch ($controller){
            case 'user':
                $classController    = new UserController();
                break;
            case 'song':
            default:
                return Request::jsonResponse(array(),"The controller $controller was not found",400);
        }

        $method         = strtoupper($_SERVER['REQUEST_METHOD']);

        switch ($method) {

            case 'GET':
            case 'POST':
                //Read only
                return $classController->get();
                break;
            case 'DELETE':
                //Write only

                break;
            case 'PUT':
                //Write only
                return $classController->put();
                break;
        }
    }
}
