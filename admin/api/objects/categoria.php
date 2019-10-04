<?php
class Categoria{
 
    // database connection and table name
    private $conn;
    private $table_name = "categoria";
 
    // object properties
    public $id;
    public $nombre;
    public $puntos;
    public $codigo;
    public $activo;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function get_news(){
        $query = "SELECT id FROM " . $this->table_name . " WHERE activo = 1 AND codigo = 'noti' ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        //ESTE RETURN ES UNICAMENTE PARA QUE ME DEVUELVA EL VALOR DE LA QUERY DIRECTAMENTE
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function get_activity(){
        $query = "SELECT id FROM " . $this->table_name . " WHERE activo = 1 AND codigo = 'acti' ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        //ESTE RETURN ES UNICAMENTE PARA QUE ME DEVUELVA EL VALOR DE LA QUERY DIRECTAMENTE
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function get_socialmedia(){
        $query = "SELECT id FROM " . $this->table_name . " WHERE activo = 1 AND codigo = 'redsoc' ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        //ESTE RETURN ES UNICAMENTE PARA QUE ME DEVUELVA EL VALOR DE LA QUERY DIRECTAMENTE
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function increment_categoria_leida($categoria) {
        $query = "UPDATE " . $this->table_name .
                " SET leido = leido + 1" .
                " WHERE codigo =" . $categoria;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function increment_categoria_compartida($categoria) {
        $query = "UPDATE " . $this->table_name .
                " SET compartido = compartido + 1" .
                " WHERE codigo =" . $categoria;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }
}