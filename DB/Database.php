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

    /** @var  string */
    protected $className;
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
        $port        = $settings['database']['port'];

        $dbUser    = $settings['database']['username'];
        $password    = $settings['database']['password'];
        $database    = $settings['database']['schema'];

        $dns          = $driver.':host=' . $host .':port'.$port. ';dbname=' . $database;

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
    public function setParameters($parameters){

        if(!isset($this->statement)){
            throw new \Exception('Unable to find the PDOStatement object');
        }

        if(!is_array($parameters) || count($parameters) <= 0){
            throw new \Exception('Please supply parameters');
        }

        $pattern = "#^\:#";
        foreach ($parameters as $param => $value){
            $param  = trim($param);

            if(preg_match($pattern,$param)==1){
                $this->statement->bindParam($param, $value);
            } else{
                $this->statement->bindParam(':'.$param, $value);
            }
        }
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
     * @return int
     * @throws \Exception
     */
    public function execute(){

        if(!isset($this->statement)){
            throw new \Exception('Unable to find the PDOStatement object');
        }

        $exe    = $this->exec($this->statement->queryString);

        if($exe === false){
            throw new \Exception($this->getErrorMsg());
        }

        return $exe;
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



}
?>