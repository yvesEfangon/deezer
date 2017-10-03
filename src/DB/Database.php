<?php
/**
 * Created by PhpStorm.
 * User: Yves Efangon
 * Date: 28/09/2017
 * Time: 15:59
 */

namespace deezer\DB;

class Database extends \PDO {

  
    /** @var  \PDOStatement */
    protected $statement;

    /** @var  array */
    protected $parameters;

    /** @var  string */
    protected $className;

    protected $error;

    /**
     * Database constructor.
     * @param string $conf
     * @throws \Exception
     */
    public function __construct($conf="settings.ini"){

        if (!$settings = parse_ini_file($conf, TRUE)){
            throw new \Exception('Unable to open ' . $conf . '.');
        }


        $driver       = $settings['database']['driver'];
        $host        = $settings['database']['host'];

        $dbUser    = $settings['database']['username'];
        $password    = $settings['database']['password'];
        $database    = $settings['database']['schema'];

        $dns          = "$driver:host=$host;dbname=$database";
        
        try{
            parent::__construct($dns,$dbUser,$password);
        }catch (\PDOException $e){
            die($e->getMessage());
        };

    }

    /**
     * @param $query
     * @param array $options
     * @return \PDOStatement
     */
    public function prepareQuery($query, $options = [\PDO::ATTR_CURSOR => \PDO::CURSOR_FWDONLY]){


            if( !($this->statement = $this->prepare($query, $options)) ){
                throw new \Exception($this->getErrorMsg());
            }

        return $this->statement;
    }

    /**
     * @param $parameters
     * @throws \Exception
     */
    public function setParameters($parameters = array()){
        $params = array();
        foreach ($parameters as $key=>$value){
            if($value != ''){
                $params[':'.$key]   = $value;
            }
        }
       $this->parameters    = $params;
    }

    /**
     * @param $criteria
     * @param string $operator
     * @return string
     */
    public function setWhere($criteria, $operator='AND'){
        $where  = array();

        foreach ($criteria as $key=>$value){
            if($value != '' && !is_null($value))
                $where[]    = " $key LIKE :$key ";
        }

        if(count($where)<=0) return '';

        return implode(" $operator ",$where);
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }



    /**
     * @return array
     * @throws \Exception
     */
    public function fetchAllResults(){
        if(!isset($this->statement)){
            throw new \Exception('Unable to find the PDOStatement object');
        }
        
        if( !($result = $this->query($this->statement->queryString)) ){
            throw new \Exception($this->getErrorMsg());
        }

        if(isset($this->className) && class_exists($this->className)) {
            $result->setFetchMode(self::FETCH_CLASS, $this->className);
        }

        return $result->fetchAll();
    }

    /**
     * @param $query
     * @return bool|\PDOStatement
     */
    public function run($query) {
        $this->error = "";

        try {
            $this->prepareQuery((string) $query);
            foreach ($this->getParameters() as $bind => $value) {
                $type = \PDO::PARAM_STR;

                switch (gettype($value)) {
                    case 'integer':
                        $type = \PDO::PARAM_INT;
                        $value = (integer) $value;
                        break;
                    case 'string':
                        $type = \PDO::PARAM_STR;
                        $value = (string) $value;
                        break;
                    case 'boolean':
                        $type = \PDO::PARAM_BOOL;
                        $value = (boolean) $value;
                        break;
                    case 'NULL':
                        $type = \PDO::PARAM_NULL;
                        break;
                }

                $this->getPDOStatement()->bindValue($bind, $value, $type);
            }

            if ($this->getPDOStatement()->execute() !== FALSE) {
                return $this->getPDOStatement();
            }else{
                throw new \Exception("PDO error: ".$this->getErrorMsg());
            }
        }
        catch (\PDOException $e) {
            $this->error = $e->getMessage();
            return false;
        }
    }

    /**
     * @return mixed
     */
    function getRunError(){
        return $this->error;
    }


    /**
     * @return string
     */
    public function getErrorMsg(){
        $infos  = $this->errorInfo();

        return 'SQLSTATE: '.$infos[0].' Driver Error Code: '.$infos[1].' Message: '.$infos[2];
    }
    /**
     * @return \PDOStatement
     */
    public function getPDOStatement(){
        return $this->statement;
    }

    public function setClassName($className){
        $this->className    = $className;
    }


}
?>