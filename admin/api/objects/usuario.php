<?php
class Usuario{
 
    // database connection and table name
    private $conn;
    private $table_name = "usuario";
 
    // object properties
    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $id_rol;
    public $clave;
    public $activo;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function list_all(){
     
        // select all query
        $query = "SELECT id, nombre, apellido, email, id_rol, clave FROM " . $this->table_name . " WHERE activo = 1 AND nombre <> 'Administrador' ORDER BY apellido ASC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function list_managers_puntos($managerID){
        $this->managerID = $managerID['id'];
        // select all query
        $query = " SELECT u.id, nombre, apellido, email, id_rol, puntos, archivo " .
                " FROM " . $this->table_name . " AS u " .
                " INNER JOIN usuario_puntos AS up ON u.id = up.id_usuario" .
                " WHERE u.activo = 1 AND id_rol = " . $this->managerID .
                " ORDER BY puntos DESC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }    

    function list_managers($managerID){
        $this->managerID = $managerID['id'];
        // select all query
        $query = "SELECT id, nombre, apellido, email, id_rol, archivo FROM " . $this->table_name . " WHERE activo = 1 AND id_rol = " . $this->managerID . " ORDER BY apellido ASC";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function get_embajador_interes($id){
        // select all query
        $query = "SELECT u.id, u.nombre, apellido, email, id_rol, i.nombre as interes, archivo" .
                " FROM " . $this->table_name . " AS u" .
                " INNER JOIN usuario_interes AS ui ON u.id = ui.id_usuario" .
                " INNER JOIN interes AS i ON ui.id_interes = i.id" .
                " WHERE checked = 1 AND u.activo = 1 AND ui.activo = 1 AND i.activo = 1 AND u.id = " . $id;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function get_embajador_redsocial($id){
        // select all query
        $query = "SELECT u.id, u.nombre, apellido, email, id_rol, r.nombre as red_social, archivo, ur.link" .
                " FROM " . $this->table_name . " AS u" .
                " INNER JOIN usuario_redsocial AS ur ON u.id = ur.id_usuario" .
                " INNER JOIN redes_sociales AS r ON ur.id_redsocial = r.id" .
                " WHERE u.activo = 1 AND link != '' AND ur.activo = 1 AND r.activo = 1 AND u.id = " . $id;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function get_redes_usuario($id){
        $query = "SELECT rs.nombre, link" .
                " FROM " . $this->table_name . " AS u " .
                " INNER JOIN usuario_redsocial AS ur ON u.id = ur.id_usuario " .
                " INNER JOIN redes_sociales AS rs ON ur.id_redsocial = rs.id " .
                " WHERE rs.activo = 1 AND link != '' AND u.id = " . $id;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function get_interes_usuario($id){
        $query = "SELECT ui.id, i.nombre, checked" .
                " FROM " . $this->table_name . " AS u " .
                " INNER JOIN usuario_interes AS ui ON u.id = ui.id_usuario " .
                " INNER JOIN interes AS i ON ui.id_interes = i.id " .
                " WHERE i.activo = 1 AND u.id = " . $id;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function login($username, $password){
        $query = " SELECT id, nombre, apellido, email, archivo " .
                " FROM " . $this->table_name .
                " WHERE (nombre_usuario = ". $username ." OR email = ". $username .") AND clave = PASSWORD(". $password .")";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function update_interes_usuario($id, $value) {
        $query = "UPDATE usuario_interes " .
                " SET checked =" . $value .
                " WHERE id =" . $id;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function update_push_token($id, $token) {
        $query = "UPDATE " . $this->table_name .
                " SET push_token =" . $token .
                " WHERE id =" . $id;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function increment_logins($id) {
        $fecha = date("Y-m-d H:i:s", time());
        $query = "UPDATE " . $this->table_name .
                " SET cantidad_logueos = cantidad_logueos + 1, fecha_ultimo_logueo = '" . $fecha . "'" .
                " WHERE id =" . $id;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function sumar_puntos($id, $puntos) {
        $query = " UPDATE usuario_puntos " .
                " SET puntos = puntos + " . $puntos .
                " WHERE id_usuario =" . $id;
        
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function recuperar_clave($email) {
        $query = "SELECT id" .
                " FROM " . $this->table_name .
                " WHERE email='". $email ."' AND activo=1";
        
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function ingresar_usuario_clave_temp($email, $token) {
        $fecha = date("Y-m-d H:i:s", time());
        $query = "INSERT INTO usuario_clave_temp " .
                " (email, token, fecha, activo) " .
                " VALUES('".$email."', '".$token."', '".$fecha."', 1)";

        $stmt = $this->conn->prepare($query);

        // execute query
        $stmt->execute();
     
        return $stmt;
    }

}