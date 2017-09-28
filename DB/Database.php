<?php
namespace deezer\DB;

class Database {// connexion à la base de donnees!

    private $link;
    private $host, $username, $password, $database;

    /**
     * Database constructor.
     * @param string $host
     * @param string $user
     * @param string $pwd
     * @param $dbName
     */
    public function __construct($host ='127.0.0.1',$user ='root', $pwd='',$dbName){
        $this->host        = $host;
        $this->username    = $user;
        $this->password    = $pwd;
        $this->database    = $dbName;
        
        $this->link = mysqli_connect($this->host, $this->username, $this->password)
            OR die("There was a problem connecting to the database.");
        
        mysqli_select_db($this->link,$this->database)
            OR die("There was a problem selecting the database.");
        
        return $this->link;
    }


    /**
     * @param $str
     * @return string
     */
    function sanitizeString($str) {

    $sanitize = mysqli_real_escape_string($this->link,stripslashes($str));

	return $sanitize;
    }

    /**
     * @param $query
     * @return array|null|string
     */
    public function loadAssoc($query) {// exécution des requetes! 
    
        mysqli_set_charset($this->link, "utf8");
        
        
        $result = mysqli_query($this->link,$query);
        
        if (!$result) return '';
        
        return mysqli_fetch_assoc($result);
    }

    /**
     * @param $query
     * @return null|object|string
     */
    public  function loadObject($query){
         mysqli_set_charset($this->link, "utf8");
        
        $result = mysqli_query($this->link,$query);
        
        if (!$result) return '';
        
        return mysqli_fetch_object($result);
    }

    /**
     * @param $query
     * @return bool|\mysqli_result
     */
    public function query($query){
        
         mysqli_set_charset($this->link, "utf8");
        return  mysqli_query($this->link,$query);
    }

    /**
     * @return string
     */
    function getErrorMsg(){
         return mysqli_error($this->link);
    }

    /**
     * @return int|string
     */
    public function insert_id(){
       
        return mysqli_insert_id($this->link);
    }

    /**
     * @param $query
     * @return bool|mixed
     */
    public function loadResult($query){
        mysqli_set_charset($this->link, "utf8");
        
        $result = mysqli_query($this->link,$query);
        
        if (!$result) return FALSE;
        
        $tab    = mysqli_fetch_assoc($result);
        return array_shift($tab);
    }

    /**
     *
     */
    public function __destruct() {
        mysqli_close($this->link)
            OR die("There was a problem disconnecting from the database.");
    }

    /**
     * @return mysqli
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param mysqli $link
     * @return Database
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return Database
     */
    public function setHost($host)
    {
        $this->host = $host;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Database
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
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



}
?>