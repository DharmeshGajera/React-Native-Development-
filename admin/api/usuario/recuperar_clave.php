<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../config/database.php';
include_once '../objects/usuario.php';
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/phpmailer/PHPMailer.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/phpmailer/Exception.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/phpmailer/SMTP.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
// instantiate database and usuario object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$usuario = new Usuario($db);
 
// query usuario
$stmt = $usuario->recuperar_clave($_GET['email']);
$num = $stmt->rowCount();
 
$usuarios_arr=array();
$usuarios_arr["records"]=array();
if($num>0){
 
 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $token = uniqid();
        $usuario->ingresar_usuario_clave_temp($_GET['email'], $token);

        $mail = new PHPMailer(true);

        //Server settings
        //$mail->SMTPDebug = 2;                                       // Enable verbose debug output
        $mail->isSMTP();                                            // Set mailer to use SMTP
        $mail->Host       = 'gum.digital';  // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'enviodemails@gum.digital';                     // SMTP username
        $mail->Password   = 'Castillo3230!';                               // SMTP password
        $mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
        $mail->Port       = 587;                                    // TCP port to connect to

        $mail->setFrom('info@accenture-fidelizados.com', 'Club de Embajadores');
        $mail->addAddress($_GET['email']);

        $mail->isHTML(true);
        $mail->Subject = 'Club de Embajadores - Recuperar Contraseña';

        $link = "<a href='https://gum.digital/plesk-site-preview/accenture-fidelizados.com/admin/recuperar_clave.php?token=".$token."'>Click Aqui.</a>";
        $mail->Body    = 'Para generar una nueva contrase&ntilde;a haga '.$link;

        $mail->send();



        extract($row);
 
        $usuario_item=array(
            "mensaje" => "Mensaje enviado con exito! Por favor verifique su casilla de correo para modificar su clave.",
        );
 
        array_push($usuarios_arr["records"], $usuario_item);
    }
 
    // set response code - 200 OK
    http_response_code(200);
 
    // show usuarios data in json format
    echo json_encode($usuarios_arr);
}
 
else{

    $usuario_item=array(
        "mensaje" => "El email ingresado no existe en el sistema. Intente nuevamente.",
    );

    array_push($usuarios_arr["records"], $usuario_item);
 
    // tell the user no usuarios found
    echo json_encode($usuarios_arr);
}