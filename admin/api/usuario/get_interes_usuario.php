<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/usuario.php';
 
// instantiate database and usuario object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$usuario = new Usuario($db);
 
// query usuario
$stmt = $usuario->get_interes_usuario($_GET['id']);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $usuarios_arr=array();
    $usuarios_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $usuario_item=array(
            "id" => $id,
            "nombre" => $nombre,
            "checked" => $checked,
        );
 
        array_push($usuarios_arr["records"], $usuario_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show usuarios data in json format
    echo json_encode($usuarios_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user no usuarios found
    echo json_encode(
        array("message" => "No usuarios found.")
    );
}