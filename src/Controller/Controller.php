<?php
/**
 * Created by PhpStorm.
 * User: Yves Efangon
 * Date: 28/09/2017
 * Time: 15:59
 */

namespace deezer\src\Controller;

use deezer\src\DB\Database;

class Controller
{

    private $db;
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->db  = new Database();
    }

    public function getDB(){
        return $this->db;
    }

    public function get(){

    }

    public function delete(){

    }

    public function put(){

    }
}