<?php
class Rol{
 
    // database connection and table name
    private $conn;
    private $table_name = "rol";
 
    // object properties
    public $id;
    public $nombre;
    public $activo;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function get_manager(){
     
        // select all query
        $query = "SELECT id FROM " . $this->table_name . " WHERE activo = 1 AND nombre = 'MD' ";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
        
        //ESTE RETURN ES UNICAMENTE PARA QUE ME DEVUELVA EL VALOR DE LA QUERY DIRECTAMENTE
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}