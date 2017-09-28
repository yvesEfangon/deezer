<?php
/**
 * Created by PhpStorm.
 * User: Yves Efangon
 * Date: 28/09/2017
 * Time: 15:50
 */

namespace deezer\Model;


use deezer\DB\Database as DB;

/**
 * Class Model
 * @package deezer
 */
class Model{
    
    private $db;

    function __construct()
    {
        $this->db   = new DB();
        
    }

    /**
     * @return DB
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
