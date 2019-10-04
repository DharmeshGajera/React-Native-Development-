<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/utiles/Utiles.php');

Utiles::ValidarSesionIniciada();

$token = isset($_POST['token']) ? $_POST['token'] : $_GET['token'];
$accion = isset($_POST['accion']) ? $_POST['accion'] : $_GET['accion'];

if (isset($token) && $token == Utiles::obtenerToken()) {

	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/CategoriaDao.php');

	switch ($accion) {
		case 'nuevo':
			$valido = true;
			$errores = '<strong>Ocurrieron los siguientes errores:</strong>';

			if (!Utiles::validarPermisos("usuarios", "agregar")) {
				$errores .= '<p>- No tiene permisos para la operaci&oacute;n que desea realizar.</p>';
				$valido = false;
			}

			if (!isset($_POST['puntos']) || $_POST['puntos'] == '') {
				$errores .= '<p>- Debe completar los puntos de la Categoria.</p>';
				$valido = false;
			}

			if(!is_numeric($_POST['puntos']) || $_POST['puntos'] < 0) {
				$errores .= '<p>- Los puntos deben ser numericos positivos.</p>';
				$valido = false;
			}
			
			if ($valido) {
				
				$item = new categoria();
				$item->puntos = $_POST['puntos'];
				
				CategoriaDao::nuevo($item);
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

			if (!isset($_POST['puntos']) || $_POST['puntos'] == '') {
				$errores .= '<p>- Debe completar los puntos de la Categoria.</p>';
				$valido = false;
			}

			if(!is_numeric($_POST['puntos']) || $_POST['puntos'] < 0) {
				$errores .= '<p>- Los puntos deben ser numericos positivos.</p>';
				$valido = false;
			}
				
			if ($valido) {
				
				$item = CategoriaDao::get($_POST['id']);
				$item->puntos = $_POST['puntos'];
				
				CategoriaDao::modificar($item);
				
			} else {
				echo '<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $errores . '</div>';
			}
			break;

		case 'eliminar':
			CategoriaDao::eliminar($_POST['id']);
			break;

	}// switch accion

}

?>