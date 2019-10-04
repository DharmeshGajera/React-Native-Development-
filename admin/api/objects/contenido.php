<?php
class Contenido{
 
    // database connection and table name
    private $conn;
    private $table_name = "contenido";
 
    // object properties
    public $id;
    public $titulo;
    public $bajada;
    public $link;
    public $fecha_publicacion;
    public $fecha_actividad;
    public $compartir;
    public $activo;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function list_news($contenidoID, $id){
        $this->contenidoID = $contenidoID['id'];
        $query = "SELECT c.id, CONVERT(CAST(titulo as BINARY) USING utf8) AS titulo, c.archivo, fecha_publicacion, ".
                    " (SELECT nombre FROM contenido_interes AS ci INNER JOIN interes AS i ON i.id = ci.id_interes WHERE c.id = ci.id_contenido AND checked = 1 AND ci.activo = 1 AND c.activo = 1 LIMIT 1) AS interes, ".
                    " (SELECT color FROM contenido_interes AS ci INNER JOIN interes AS i ON i.id = ci.id_interes WHERE c.id = ci.id_contenido AND checked = 1 AND ci.activo = 1 AND c.activo = 1 LIMIT 1) AS color ".
                    " FROM contenido AS c " .
                    " INNER JOIN contenido_interes AS ci ON c.id = ci.id_contenido AND ci.checked = 1 " .
                    " INNER JOIN interes AS i ON i.id = ci.id_interes " .
                    " INNER JOIN usuario_interes AS ui ON ui.id_interes = i.id AND ui.checked = 1 AND ui.id_usuario =" . $id .
                    " WHERE c.activo = 1 AND categoria_contenido = " . $this->contenidoID .
                    " GROUP BY c.id";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function list_activities($contenidoID, $id){
        $this->contenidoID = $contenidoID['id'];
        $query = "SELECT c.id, CONVERT(CAST(titulo as BINARY) USING utf8) AS titulo, c.archivo, fecha_publicacion, ".
                    " (SELECT nombre FROM contenido_interes AS ci INNER JOIN interes AS i ON i.id = ci.id_interes WHERE c.id = ci.id_contenido AND checked = 1 AND ci.activo = 1 AND c.activo = 1 LIMIT 1) AS interes, ".
                    " (SELECT color FROM contenido_interes AS ci INNER JOIN interes AS i ON i.id = ci.id_interes WHERE c.id = ci.id_contenido AND checked = 1 AND ci.activo = 1 AND c.activo = 1 LIMIT 1) AS color ".
                    " FROM contenido AS c " .
                    " INNER JOIN contenido_interes AS ci ON c.id = ci.id_contenido AND ci.checked = 1 " .
                    " INNER JOIN interes AS i ON i.id = ci.id_interes " .
                    " INNER JOIN usuario_interes AS ui ON ui.id_interes = i.id AND ui.checked = 1 AND ui.id_usuario =" . $id .
                    " WHERE c.activo = 1 AND categoria_contenido = " . $this->contenidoID .
                    " GROUP BY c.id";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function list_socialmedia($contenidoID, $id){
        $this->contenidoID = $contenidoID['id'];
        $query = "SELECT c.id, CONVERT(CAST(titulo as BINARY) USING utf8) AS titulo, c.archivo, fecha_publicacion, ".
                    " (SELECT nombre FROM contenido_interes AS ci INNER JOIN interes AS i ON i.id = ci.id_interes WHERE c.id = ci.id_contenido AND checked = 1 AND ci.activo = 1 AND c.activo = 1 LIMIT 1) AS interes, ".
                    " (SELECT color FROM contenido_interes AS ci INNER JOIN interes AS i ON i.id = ci.id_interes WHERE c.id = ci.id_contenido AND checked = 1 AND ci.activo = 1 AND c.activo = 1 LIMIT 1) AS color ".
                    " FROM contenido AS c " .
                    " INNER JOIN contenido_interes AS ci ON c.id = ci.id_contenido AND ci.checked = 1 " .
                    " INNER JOIN interes AS i ON i.id = ci.id_interes " .
                    " INNER JOIN usuario_interes AS ui ON ui.id_interes = i.id AND ui.checked = 1 AND ui.id_usuario =" . $id .
                    " WHERE c.activo = 1 AND categoria_contenido = " . $this->contenidoID .
                    " GROUP BY c.id";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function get_contenido($id){
        // select all query
        $query = "SELECT con.id, CONVERT(CAST(titulo as BINARY) USING utf8) AS titulo, CONVERT(CAST(bajada as BINARY) USING utf8) AS bajada, link, fecha_publicacion, fecha_actividad, archivo, codigo" .
                " FROM " . $this->table_name . " AS con " .
                " INNER JOIN categoria AS cat ON con.categoria_contenido = cat.id " .
                " WHERE con.activo = 1 AND compartir = 1 AND con.id = " . $id;
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function get_last_news($id){
        $query = " SELECT DISTINCT c.id, CONVERT(CAST(titulo as BINARY) USING utf8) AS titulo, CONVERT(CAST(bajada as BINARY) USING utf8) AS bajada, link, fecha_publicacion, fecha_actividad, c.archivo " .
                " FROM " . $this->table_name . " AS c " .
                " INNER JOIN contenido_interes AS ci ON ci.id_contenido = c.id AND ci.checked = 1 " .
                " INNER JOIN interes AS i ON i.id = ci.id_interes " .
                " INNER JOIN usuario_interes AS ui ON ui.id_interes = i.id AND ui.id_usuario =" . $id . " AND ui.checked = 1 " .
                " WHERE c.activo = 1 AND compartir = 1 AND fecha_publicacion <= DATE(NOW()) " .
                " GROUP BY c.id " .
                " ORDER BY c.creado_fecha DESC " .
                " LIMIT 3 ";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function get_interes_contenido($id){
        $query = "SELECT nombre, color" .
                " FROM " . $this->table_name . " AS c " .
                " INNER JOIN contenido_interes AS ci ON ci.id_contenido = c.id " .
                " INNER JOIN interes AS i ON ci.id_interes = i.id " .
                " WHERE checked = 1 AND i.activo = 1 AND c.id = " . $id .
                " GROUP BY nombre, color ";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
    }

    function get_puntos_categoria($codigo) {
        $query = "SELECT puntos" .
                " FROM categoria " .
                " WHERE codigo=" . $codigo;
     
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        //ESTE RETURN ES UNICAMENTE PARA QUE ME DEVUELVA EL VALOR DE LA QUERY DIRECTAMENTE
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}