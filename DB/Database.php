<?php
/**
 * Created by PhpStorm.
 * User: Yves Efangon
 * Date: 28/09/2017
 * Time: 15:59
 */

namespace deezer\DB;

class Database extends \PDO {

    protected $driver;
    protected  $host;
    protected $port;
    protected $dbUser;
    protected $password;
    protected $database;
    protected $dns;


    /**
     * Database constructor.
     * @param string $conf
     * @throws \Exception
     */
    public function __construct($conf="settings.ini"){

        if (!$settings = parse_ini_file($conf, TRUE)) throw new \Exception('Unable to open ' . $conf . '.');


        $this->driver       = $settings['database']['driver'];
        $this->host        = $settings['database']['host'];
        $this->port        = $settings['database']['port'];

        $this->dbUser    = $settings['database']['username'];
        $this->password    = $settings['database']['password'];
        $this->database    = $settings['database']['schema'];

        $this->dns          = $this->driver.':host=' . $this->host .':port'.$this->port. ';dbname=' . $this->database;

        try{
            parent::__construct($this->dns,$this->dbUser,$this->password);
        }catch (\PDOException $e){
            die($e->getMessage());
        };

    }

    /**
     * @return mixed
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @param mixed $driver
     * @return Database
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param mixed $host
     * @return Database
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @param mixed $port
     * @return Database
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDbUser()
    {
        return $this->dbUser;
    }

    /**
     * @param mixed $dbUser
     * @return Database
     */
    public function setDbUser($dbUser)
    {
        $this->dbUser = $dbUser;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Database
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @param mixed $database
     * @return Database
     */
    public function setDatabase($database)
    {
        $this->database = $database;

        return $this;
    }

    /**
     * @return string
     */
    public function getDns()
    {
        return $this->dns;
    }

    /**
     * @param string $dns
     * @return Database
     */
    public function setDns($dns)
    {
        $this->dns = $dns;

        return $this;
    }



}
?>