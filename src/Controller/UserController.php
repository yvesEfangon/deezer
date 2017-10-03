<?php
/**
 * Created by PhpStorm.
 * User: Yves Efangon
 * Date: 28/09/2017
 * Time: 15:58
 */

namespace deezer\Controller;

use deezer\Entity\UserEntity;
use deezer\Helper\Request;
use deezer\Model\UserModel;


/**
 * Class UserController
 * @package deezer\Controller
 */
class UserController extends Controller
{

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return string
     * @throws \Exception
     */

    public function get()
    {
        $criteria   = array();
        $criteria['name']       = Request::getString('name');
        $criteria['username']   = Request::getString('username');
        $criteria['email']      = Request::getString('email');
        $criteria['id']         = Request::getString('id');

        $model  = new UserModel();

        $results        = array();

        try{
            $results = $model->findAllBy($criteria);
            $message    = "200 OK";
            $status     = 200;
        }catch (\Exception $e){
            $message    = $e->getMessage();
            $status     = 400;
        }

        return Request::jsonResponse($results,$message,$status);
    }

    public function put()
    {
        $name       = Request::getString('name');
        $username   = Request::getString('username');
        $email      = Request::getEmail('email');
        $password   = Request::getString('password');

        if($username == '' || $email == ''){
            return Request::jsonResponse([],"The username and the email must are mandatory",400);
        }

        $user   = new UserEntity();
        $user->setEmail($email);
        $user->setName($name);
        $user->setUsername($username);
        $user->setPassword($password);
        $model  = new UserModel();
        return $model->create($user);

    }
}