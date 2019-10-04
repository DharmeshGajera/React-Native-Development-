<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/categoria.php';
 
// instantiate database and usuario object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$categoria = new Categoria($db);

// query categoria
$stmt = $categoria->increment_categoria_leida($_GET['categoria']);
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $categorias_arr=array();
    $categorias_arr["records"]=array();
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
 
        $categoria_item=array(
            "id" => $id,
        );
 
        array_push($categorias_arr["records"], $categoria_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    echo json_encode($categorias_arr);
}
 
else{
 
    // set response code - 404 Not found
    http_response_code(404);
 
    echo json_encode(
        array("message" => "No categorias found.")
    );
}