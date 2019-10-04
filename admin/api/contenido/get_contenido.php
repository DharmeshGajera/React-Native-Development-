<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/contenido.php';
 
// instantiate database and contenido object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$contenido = new contenido($db);
 
// query contenido
$stmt = $contenido->get_contenido($_GET['id']);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $contenidos_arr=array();
    $contenidos_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $contenido_item=array(
            "id" => $id,
            "titulo" => $titulo,
            "bajada" => $bajada,
            "link" => $link,
            "fecha_publicacion" => $fecha_publicacion,
            "fecha_actividad" => $fecha_actividad,
            "archivo" => $archivo,
            "codigo" => $codigo,
        );
 
        array_push($contenidos_arr["records"], $contenido_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show contenidos data in json format
    echo json_encode($contenidos_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no contenidos found
    echo json_encode(
        array("message" => "No contenidos found.")
    );
}