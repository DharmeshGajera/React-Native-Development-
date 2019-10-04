<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/utiles/Utiles.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioClaveTempDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/phpmailer/PHPMailer.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/phpmailer/Exception.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/phpmailer/SMTP.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$accion = isset($_POST['accion']) ? $_POST['accion'] : $_GET['accion'];

switch ($accion) {
	case 'login':
		$valido = true;

		if (!isset($_POST['usuario']) || $_POST['usuario'] == '') {
			echo "- Debe ingresar el nombre de usuario. <br>";
			$valido = false;
		}
		
		if (!isset($_POST['clave']) || $_POST['clave'] == '') {
			echo "- Debe ingresar la clave. <br>";
			$valido = false;
		}

		if ($valido) {
			$usuario = UsuarioDao::login($_POST['usuario'], $_POST['clave']);

			if ($usuario != null) {
				Utiles::iniciarSesion($usuario);
			} else {
				echo "- Nombre de usuario y/o clave incorrectos. <br>";
				$valido = false;
			}
		}
		break;

	case 'logout':
		Utiles::cerrarSesion();
		break;

	case 'updatePass':
		$valido = true;
		$errores = '<strong>Ocurrieron los siguientes errores:</strong>';

		if (!isset($_POST['clave']) || $_POST['clave'] == '') {
				$errores .= '<p>- Debe completar la contrase&ntilde;a.</p>';
				$valido = false;
			}

			if (!isset($_POST['claveRepetida']) || $_POST['claveRepetida'] == '') {
				$errores .= '<p>- Debe repetir la contrase&ntilde;a.</p>';
				$valido = false;
			}

			if ($_POST['clave'] != $_POST['claveRepetida']) {
				$errores .= '<p>- La repetici&oacute;n de la contrase&ntilde;a es incorrecta.</p>';
				$valido = false;
			}

		if ($valido) {
			UsuarioDao::modificarClave($_POST['idUsuario'], $_POST['clave']);
			UsuarioClaveTempDao::eliminar($_POST['id']);
			
		} else {
			echo '<div class="alert fade in">' . $errores . '</div>';
		}
		break;

	case 'recuperar_clave':
		$valido = true;

		if (!isset($_POST['email']) || $_POST['email'] == '') {
			echo "- Debe ingresar su direcci&oacute;n de email. <br>";
			$valido = false;
		} else {
			$usuario = UsuarioDao::getXemailYactivo($_POST['email']);
			if ($usuario == null || count($usuario) < 1) {
				echo "- No se encontr&oacute; nung&uacute;n usuario con la direcci&oacute;n de email ingresada. <br>";
				$valido = false;
			}

		}

		if($valido) {
			$item = new usuario_clave_temp();
			$item->email = $_POST['email'];
			$token = uniqid();
			$item->token = $token;
			UsuarioClaveTempDao::nuevo($item);

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
		    $mail->addAddress($_POST['email']);

		    $mail->isHTML(true);
		    $mail->Subject = 'Club de Embajadores - Recuperar Contraseña';

		    $link = "<a href='https://gum.digital/plesk-site-preview/accenture-fidelizados.com/admin/recuperar_clave.php?token=".$token."'>Click Aqui.</a>";
		    $mail->Body    = 'Para generar una nueva contrase&ntilde;a haga '.$link;

		    $mail->send();
		    echo 'Mensaje enviado con exito! Por favor verifique su casilla de correo para modificar su clave';

		}
		break;
}// switch accion

?>