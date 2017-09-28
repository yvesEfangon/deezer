<?php
/**
 * Created by PhpStorm.
 * User: Yves Efangon
 * Date: 28/09/2017
 * Time: 15:50
 */

namespace deezer\Model;

use deezer\Entity\User as userEntity;

class User extends Model
{

    public function __construct()
    {
        parent::__construct();
        
        $this->setTable('user');
    }

    public function create(userEntity $user){

    }
    
    public function edit(userEntity $user){

    }



}