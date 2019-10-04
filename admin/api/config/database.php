<?php
class Database{
 
    // specify your own database credentials
    private $host = "74.208.235.89";
    private $db_name = "accenture";
    private $username = "fidelizados";
    private $password = "Alan1234!";

    //private $host = "127.0.0.1";
    //private $db_name = "accenture";
    //private $username = "root";
    //private $password = "";
    public $conn;
 
    // get the database connection
    public function getConnection(){
 
        $this->conn = null;
 
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
 
        return $this->conn;
    }
}
?>