<?php
/**
 * Created by PhpStorm.
 * User: Yves Efangon
 * Date: 28/09/2017
 * Time: 15:55
 */

namespace deezer\Model;

use deezer\DB\Database;

/**
 * Class Model
 * @package deezer
 */
class Model{

    /** @var Database */
    private $db;

    private $table;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->db   = new Database();
        
    }

    /**
     * @return Database
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


    public function findAllBy($criteria){

        $db         = $this->getDb();

        $query      = "SELECT * FROM ".$this->getTable()." WHERE ";
        $where      = $db->setWhere($criteria);

        if($where == ''){
            $query  .= ' 1';
        }else{
            $query      .= $where;
        }

        $db->setParameters($criteria);

        $statement = $db->prepare($query, array(\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY));

        if( $statement->execute($db->getParameters())){
            return $statement->fetchAll();
        }else{
            throw new \Exception("SQL statement error");
            return false;
        }

    }



}
?>
