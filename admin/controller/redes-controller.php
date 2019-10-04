<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/utiles/Utiles.php');

Utiles::ValidarSesionIniciada();

$token = isset($_POST['token']) ? $_POST['token'] : $_GET['token'];
$accion = isset($_POST['accion']) ? $_POST['accion'] : $_GET['accion'];

if (isset($token) && $token == Utiles::obtenerToken()) {

	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/RedesDao.php');

	switch ($accion) {
		case 'nuevo':
			$valido = true;
			$errores = '<strong>Ocurrieron los siguientes errores:</strong>';

			if (!Utiles::validarPermisos("usuarios", "agregar")) {
				$errores .= '<p>- No tiene permisos para la operaci&oacute;n que desea realizar.</p>';
				$valido = false;
			}
			
			if (!isset($_POST['nombre']) || $_POST['nombre'] == '') {
				$errores .= '<p>- Debe completar el nombre de la Red Social.</p>';
				$valido = false;
			}
			
			if ($valido) {
				
				$item = new redes_sociales();
				$item->nombre = $_POST['nombre'];
				
				RedesDao::nuevo($item);
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
				$errores .= '<p>- Debe completar el nombre de la Red Social.</p>';
				$valido = false;
			}
				
			if ($valido) {
				
				$item = RedesDao::get($_POST['id']);
				$item->nombre = $_POST['nombre'];
				
				RedesDao::modificar($item);
				
			} else {
				echo '<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $errores . '</div>';
			}
			break;

		case 'eliminar':
			RedesDao::eliminar($_POST['id']);
			break;

	}// switch accion

}

?>