<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/utiles/Utiles.php');

Utiles::ValidarSesionIniciada();

$token = isset($_POST['token']) ? $_POST['token'] : $_GET['token'];
$accion = isset($_POST['accion']) ? $_POST['accion'] : $_GET['accion'];

if (isset($token) && $token == Utiles::obtenerToken()) {

	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/RolDao.php');

	switch ($accion) {
		case 'nuevo':
			$valido = true;
			$errores = '<strong>Ocurrieron los siguientes errores:</strong>';

			if (!Utiles::validarPermisos("usuarios", "agregar")) {
				$errores .= '<p>- No tiene permisos para la operaci&oacute;n que desea realizar.</p>';
				$valido = false;
			}

			if (!isset($_POST['nombre']) || $_POST['nombre'] == '') {
				$errores .= '<p>- Debe completar el nombre.</p>';
				$valido = false;
			}
						

			if (!isset($_POST['permisos']) || $_POST['permisos'] == '') {
				$errores .= '<p>- Debe completar los permisos.</p>';
				$valido = false;
			}			

			if ($valido) {				
				$item->nombre = $_POST['nombre'];
				$item->permisos = $_POST['permisos'];								

				RolDao::nuevo($item);
			} else {
				echo '<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $errores . '</div>';
			}
			break;

		case 'editar':
			$valido = true;
			$errores = '<strong>Ocurrieron los siguientes errores:</strong>';			
			
			if (!Utiles::validarPermisos("usuarios", "editar")) {
				$errores .= '<p>- No tiene permisos para la operaci&oacute;n que desea realizar.</p>';
				$valido = false;
			}

			if (!isset($_POST['nombre']) || $_POST['nombre'] == '') {
				$errores .= '<p>- Debe completar el Nombre.</p>';
				$valido = false;
			}

			if (!isset($_POST['permisos']) || $_POST['permisos'] == '') {
				$errores .= '<p>- Debe completar los permisos.</p>';
				$valido = false;
			}


			//			if (!isset($_POST['clave']) || $_POST['clave'] == '') {
			//				$errores .= '<p>- Debe completar la contrase&ntilde;a.</p>';
			//				$valido = false;
			//			}
			//
			//			if (!isset($_POST['repetir']) || $_POST['repetir'] == '') {
			//				$errores .= '<p>- Debe repetir la contrase&ntilde;a.</p>';
			//				$valido = false;
			//			}
			//
			//			if ($_POST['clave'] != $_POST['repetir']) {
			//				$errores .= '<p>- La repetici&oacute;n de la contrase&ntilde;a es incorrecta.</p>';
			//				$valido = false;
			//			}

			if ($valido) {
				$item = RolDao::get($_POST['id']);
				$item->nombre = $_POST['nombre'];
				$item->permisos = $_POST['permisos'];				

				RolDao::modificarPerfil($item);
			} else {
				echo '<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $errores . '</div>';
			}
			break;

		case 'eliminar':
			RolDao::eliminar($_POST['id']);
			break;

		case 'modificar-clave':
			$valido = true;
			$errores = '<strong>Ocurrieron los siguientes errores:</strong>';
				
			
			break;
	}// switch accion

}

?>
