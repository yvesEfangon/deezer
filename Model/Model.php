<?php
/**
 * Created by PhpStorm.
 * User: Yves Efangon
 * Date: 28/09/2017
 * Time: 15:50
 */

namespace deezer\Model;


use deezer\DB\Database as database;

/**
 * Class Model
 * @package deezer
 */
class Model{
    
    private $db;

    function __construct()
    {
        $this->db   = new database('127.0.0.1','root', '','deezer');
        
    }

    /**
     * @return database
     */
    public function getDb()
    {
        return $this->db;
    }

    /**
     * @param $db
     * @return $this
     */
    public function setDb($db)
    {
        $this->db = $db;

        return $this;
    }



}
?>
