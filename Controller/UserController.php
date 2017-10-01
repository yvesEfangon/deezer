<?php
/**
 * Created by PhpStorm.
 * User: Yves Efangon
 * Date: 28/09/2017
 * Time: 15:58
 */

namespace deezer\Controller;

use deezer\Helper\Request;

/**
 * Class UserController
 * @package deezer\Controller
 */
class UserController
{
    private $db;
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->db  = new \deezer\DB\Database();
    }

    public function getDB(){
        return $this->db;
    }

    /**
     * @return string
     * @throws \Exception
     */

    public function get()
    {
        $name       = Request::getString('name');
        $username   = Request::getString('username');
        $email      = Request::getEmail('email');
        $id         = Request::getInt('id');

        $db         = $this->getDB();

        $query      = "SELECT * FROM user WHERE ";
        $where      = array();
        $parameters = array();
        
        if($id != ''){
            $where[]    = "id = :id";
            $parameters['id']   = $id;
        }else {

            if ($email != '') {
                $where[] = "email like :email ";
                $parameters['email'] = $email;
            }

            if ($name != '') {
                $where[] = "name LIKE :name";
                $parameters['name'] = $name;
            }

            if ($username != '') {
                $where[] = "username like :username ";
                $parameters['username'] = $username;
            }
        }
        
        if(count($where)<=0){
            return Request::jsonResponse([],"Please supply at least one criteria",400);
        }
        
        $query      .= implode(' AND ',$where);
        $db->prepareQuery($query);
        $db->setParameters($parameters);
        $db->setClassName('deezer\Entity\User');

        $results        = array();

        try{
            $results = $db->fetchAllResults();
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
            return Request::jsonResponse([],"The username and the must are mandatory",400);
        }

        $query  = "INSERT INTO `user`(`username`, `email`, `password`, `name`) VALUES ('$username', '$email', '$password', '$name')";
        $db     = $this->getDB();

        $db->prepareQuery($query);

        try {
           $db->execute();
            return Request::jsonResponse([],"1 User added", 200);
        }catch (\Exception $e){
            return Request::jsonResponse([],$e->getMessage(),400);
        }

    }
}