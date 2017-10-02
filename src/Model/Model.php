<?php
/**
 * Created by PhpStorm.
 * User: Yves Efangon
 * Date: 28/09/2017
 * Time: 15:55
 */

namespace deezer\Model;


use deezer\DB\Database as DB;

/**
 * Class Model
 * @package deezer
 */
class Model{

    /** @var DB */
    private $db;

    private $table;

    /**
     * Model constructor.
     */
    public function __construct()
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
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param mixed $table
     * @return Model
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    
    /**
     * @param string $query
     * @param array $parameters
     * @throws \Exception
     */
    public function setQuery($query, $parameters){

       $this->db->prepareQuery($query);
        $this->db->setParameters($parameters);

    }

    /**
     * @return array
     * @throws \Exception
     */
    public function loadResults(){
        return $this->db->fetchAllResults();
    }

    /**
     * @param $query
     * @param $parameters
     * @return int
     * @throws \Exception
     */
    public function execute($query, $parameters){
        $this->db->prepareQuery($query);
        $this->db->setParameters($parameters);

        return $this->db->execute();
    }

    /**
     * @param string $query
     * @param array $parameters
     * @return array
     */
    public function findAllBy($query,$parameters){
        $this->setQuery($query, $parameters);

        return $this->loadResults();
    }

}
?>
