<?php
/**
 * Created by PhpStorm.
 * User: Yves Efangon
 * Date: 28/09/2017
 * Time: 15:50
 */

namespace deezer\Model;



use deezer\DB\Database;
use deezer\Entity\UserEntity;
use deezer\Helper\Request;

class UserModel extends Model
{
    public function __construct()
    {
        parent::__construct();
        
        $this->setTable('user');
    }

    public function create(UserEntity $user){

        $query  = "INSERT INTO `user`(`username`, `email`, `password`, `name`) VALUES ('".$user->getUsername()."', '".$user->getEmail()."', '".$user->getPassword()."', '".$user->getName()."')";
        $db     = new Database();

        try {
            $db->exec($query);
            return Request::jsonResponse([],"1 User added", 200);
        }catch (\Exception $e){
            return Request::jsonResponse([],$e->getMessage(),400);
        }
    }
    
    public function edit(userEntity $user){

    }




}