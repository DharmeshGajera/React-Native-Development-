<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/contenido.php';
include_once '../objects/categoria.php';
 
// instantiate database and get connection
$database = new Database();
$db = $database->getConnection();
 
// initialize objects
$contenido = new Contenido($db);
$categoria = new Categoria($db);
 
// query
$socialmediaId = $categoria->get_socialmedia();
$stmt = $contenido->list_socialmedia($socialmediaId, $_GET['id']);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
    $contenidos_arr=array();
    $contenidos_arr["records"]=array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to just $name only
        extract($row);
 
        $contenido_item=array(
            "id" => $id,
            "titulo" => $titulo,
            "archivo" => $archivo,
            "fecha_publicacion" => $fecha_publicacion,
            "interes" => $interes,
            "color" => $color
        );
 
        array_push($contenidos_arr["records"], $contenido_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show usuarios data in json format
    echo json_encode($contenidos_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no usuarios found
    echo json_encode(
        array("message" => "No contenido found.")
    );
}