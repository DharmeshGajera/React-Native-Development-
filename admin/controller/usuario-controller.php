<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/utiles/Utiles.php');

Utiles::ValidarSesionIniciada();

$token = isset($_POST['token']) ? $_POST['token'] : $_GET['token'];
$accion = isset($_POST['accion']) ? $_POST['accion'] : $_GET['accion'];

if (isset($token) && $token == Utiles::obtenerToken()) {

	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioDao.php');
	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/RedesDao.php');
	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioRedSocialDao.php');
	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/InteresDao.php');
	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioInteresDao.php');
	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioPuntosDao.php');
	include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/utiles/upload/UtilesImagenes.php');

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

			if (!isset($_POST['apellido']) || $_POST['apellido'] == '') {
				$errores .= '<p>- Debe completar el apellido.</p>';
				$valido = false;
			}

			if (!isset($_POST['nombre_usuario']) || $_POST['nombre_usuario'] == '') {
				$errores .= '<p>- Debe completar el nombre_usuario.</p>';
				$valido = false;
			}

			if (!isset($_POST['email']) || $_POST['email'] == '') {
				$errores .= '<p>- Debe completar el email.</p>';
				$valido = false;
			} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			    $errores .= '<p>- El email ingresado no es valido.</p>';
				$valido = false;
			} else {
				$usuario = UsuarioDao::getXemail($_POST['email']);
				if (count($usuario) > 0) {
					$usuario = $usuario[0];
					if ($usuario->id !=  $_POST['id']) {
						$errores .= '<p>- Ya existe un usuario con el email ingresado.</p>';
						$valido = false;
					}
				}
			}

			if (!isset($_POST['clave']) || $_POST['clave'] == '') {
				$errores .= '<p>- Debe completar la contrase&ntilde;a.</p>';
				$valido = false;
			}

			if (!isset($_POST['repetir']) || $_POST['repetir'] == '') {
				$errores .= '<p>- Debe repetir la contrase&ntilde;a.</p>';
				$valido = false;
			}

			if ($_POST['clave'] != $_POST['repetir']) {
				$errores .= '<p>- La repetici&oacute;n de la contrase&ntilde;a es incorrecta.</p>';
				$valido = false;
			}
			
			if (!isset($_POST['id_rol']) || $_POST['id_rol'] == '') {
				$errores .= '<p>- Debe seleccionar una categoria.</p>';
				$valido = false;
			}

			if (!isset($_POST['imagenes']) || $_POST['imagenes'] == '[]' || $_POST['imagenes'] == '{}') {
				$errores .= '<p>- Debe seleccionar una foto de Perfil.</p>';
				$valido = false;
			}
			else{
				$errorAgregado = false;
				foreach(json_decode($_POST['imagenes']) as $imagen){
					$namecode = explode(".", $imagen->namecode);
					if(!$errorAgregado && $namecode[1] != "jpg" && $namecode[1] != "png" && $namecode[1] != "jpeg"){
						$errores .= '<p>- El formato admitido para la foto es JPG, PNG.</p>';
						$valido = false;
						$errorAgregado = true; 
					}
				}
			}

			$redes = RedesDao::listActivos();
			foreach ($redes as $red_social) {
				if (!filter_var($_POST[$red_social->nombre], FILTER_VALIDATE_URL) && $_POST[$red_social->nombre] != '') {
					$errores .= '<p>- Hay Redes Sociales con URL Invalida.</p>';
					$valido = false;
				}
			}

			if ($valido) {
				$item = new usuario();
				$item->nombre = $_POST['nombre'];
				$item->apellido = $_POST['apellido'];
				$item->nombre_usuario = $_POST['nombre_usuario'];
				$item->email = $_POST['email'];
				$item->clave = $_POST['clave'];
				$item->id_rol = $_POST['id_rol'];
				if($_POST['imagenChange']==1)
				{								
					if($item->archivo!=''){
						if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/archivos/" . $item->archivo)) {
							unlink($_SERVER["DOCUMENT_ROOT"] . "/archivos/" . $item->archivo);
						}

						if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/archivos/recortes/" . $item->archivo)) {
							unlink($_SERVER["DOCUMENT_ROOT"] . "/archivos/recortes/" . $item->archivo);
						}				
					}
					
					$item->foto = '';
					$item->archivo = '';
					
					$imagenes = json_decode($_POST['imagenes']);
					
					foreach ($imagenes as $imagen) {
						if ($imagen->place == 'temp') {
							subirArchivo($imagen->namecode);
							$item->foto = $imagen->name;
							$item->archivo = $imagen->namecode;
						}
					}
				}

				UsuarioDao::nuevo($item);

				//AHORA CARGO LAS REDES SOCIALES DEL USUARIO
				$newUser = UsuarioDao::getXemail($item->email);
				$redes = RedesDao::listActivos();
				foreach ($redes as $red_social) {
					if (!isset($_POST[$red_social->nombre]) || $_POST[$red_social->nombre] == '') {
						$link = '';
					} else {
						$link = $_POST[$red_social->nombre];
					}
					$usuarioRedSocial = new usuario_redsocial();
					$usuarioRedSocial->id_usuario = $newUser[0]->id;
					$usuarioRedSocial->id_redsocial = $red_social->id;
					$usuarioRedSocial->link = $link;
					UsuarioRedSocialDao::nuevo($usuarioRedSocial);
				}

				//AHORA CARGO LOS INTERESES DEL USUARIO
				$intereses = InteresDao::listActivos();
				foreach ($intereses as $interes) {
					if (!isset($_POST[$interes->nombre]) || $_POST[$interes->nombre] == '') {
						$checked = 0;
					} else {
						$checked = $_POST[$interes->nombre];
					}
					$usuarioInteres = new usuario_interes();
					$usuarioInteres->id_usuario = $newUser[0]->id;
					$usuarioInteres->id_interes = $interes->id;
					$usuarioInteres->checked = $checked;
					UsuarioInteresDao::nuevo($usuarioInteres);
				}

				//AHORA CARGO LOS PUNTOS DEL USUARIO
				$puntos = new usuario_puntos();
				$puntos->id_usuario = $newUser[0]->id;
				$puntos->puntos = 0;
				UsuarioPuntosDao::nuevo($puntos);

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
				$errores .= '<p>- Debe completar el nombre.</p>';
				$valido = false;
			}

			if (!isset($_POST['apellido']) || $_POST['apellido'] == '') {
				$errores .= '<p>- Debe completar el apellido.</p>';
				$valido = false;
			}

			if (!isset($_POST['nombre_usuario']) || $_POST['nombre_usuario'] == '') {
				$errores .= '<p>- Debe completar el nombre_usuario.</p>';
				$valido = false;
			}

			if (!isset($_POST['email']) || $_POST['email'] == '') {
				$errores .= '<p>- Debe completar el email.</p>';
				$valido = false;
			} else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			    $errores .= '<p>- El email ingresado no es valido.</p>';
				$valido = false;
			} else {
				$usuario = UsuarioDao::getXemail($_POST['email']);
				if (count($usuario) > 0) {
					$usuario = $usuario[0];
					if ($usuario->id !=  $_POST['id']) {
						$errores .= '<p>- Ya existe un usuario con el email ingresado.</p>';
						$valido = false;
					}
				}
			}

			if (!isset($_POST['id_rol']) || $_POST['id_rol'] == '') {
				$errores .= '<p>- Debe seleccionar una categoria.</p>';
				$valido = false;
			}

			if (!isset($_POST['imagenes']) || $_POST['imagenes'] == '[]' || $_POST['imagenes'] == '{}') {
				$errores .= '<p>- Debe seleccionar una foto de Perfil.</p>';
				$valido = false;
			}
			else{
				$errorAgregado = false;
				foreach(json_decode($_POST['imagenes']) as $imagen){
					$namecode = explode(".", $imagen->namecode);
					if(!$errorAgregado && $namecode[1] != "jpg" && $namecode[1] != "png" && $namecode[1] != "jpeg"){
						$errores .= '<p>- El formato admitido para la foto es JPG, PNG.</p>';
						$valido = false;
						$errorAgregado = true; 
					}
				}
			}

			$redes = RedesDao::listActivos();
			foreach ($redes as $red_social) {
				if (!filter_var($_POST[$red_social->nombre], FILTER_VALIDATE_URL) && $_POST[$red_social->nombre] != '') {
					$errores .= '<p>- Hay Redes Sociales con URL Invalida.</p>';
					$valido = false;
				}
			}

			if ($valido) {
				$item = UsuarioDao::get($_POST['id']);
				$item->nombre = $_POST['nombre'];
				$item->apellido = $_POST['apellido'];
				$item->nombre_usuario = $_POST['nombre_usuario'];
				$item->email = $_POST['email'];
				$item->id_rol = $_POST['id_rol'];

				if($_POST['imagenChange']==1)
				{								
					if($item->archivo!=''){
						if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/archivos/" . $item->archivo)) {
							unlink($_SERVER["DOCUMENT_ROOT"] . "/archivos/" . $item->archivo);
						}

						if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/archivos/recortes/" . $item->archivo)) {
							unlink($_SERVER["DOCUMENT_ROOT"] . "/archivos/recortes/" . $item->archivo);
						}				
					}
					
					$item->foto = '';
					$item->archivo = '';
					
					$imagenes = json_decode($_POST['imagenes']);
					
					foreach ($imagenes as $imagen) {
						if ($imagen->place == 'temp') {
							subirArchivo($imagen->namecode);
							$item->foto = $imagen->name;
							$item->archivo = $imagen->namecode;
						}
					}
				}

				UsuarioDao::modificarPerfil($item);

				//AHORA ACTUALIZO LAS REDES SOCIALES DEL USUARIO
				$redes = RedesDao::listActivos();
				foreach ($redes as $red_social) {
					if (!isset($_POST[$red_social->nombre]) || $_POST[$red_social->nombre] == '') {
						$link = '';
					} else {
						$link = $_POST[$red_social->nombre];
					}
					if(UsuarioRedSocialDao::getXusuarioYredsocial($_POST['id'], $red_social->id)) {
						$usuario_redsocial = UsuarioRedSocialDao::getXusuarioYredsocial($_POST['id'], $red_social->id)[0];
						
						$usuarioRedSocial = UsuarioRedSocialDao::get($usuario_redsocial->id);
						$usuarioRedSocial->id_usuario = $_POST['id'];
						$usuarioRedSocial->id_redsocial = $red_social->id;
						$usuarioRedSocial->link = $link;
						UsuarioRedSocialDao::modificar($usuarioRedSocial);
					} else {
						$usuarioRedSocial = new usuario_redsocial();
						$usuarioRedSocial->id_usuario = $_POST['id'];
						$usuarioRedSocial->id_redsocial = $red_social->id;
						$usuarioRedSocial->link = $link;
						UsuarioRedSocialDao::nuevo($usuarioRedSocial);
					}
				}

				//AHORA ACTUALIZO LOS INTERESES DEL USUARIO
				$intereses = InteresDao::listActivos();
				foreach ($intereses as $interes) {
					if (!isset($_POST[$interes->nombre]) || $_POST[$interes->nombre] == '') {
						$checked = 0;
					} else {
						$checked = $_POST[$interes->nombre];
					}
					if(UsuarioInteresDao::getXusuarioYinteres($_POST['id'], $interes->id)) {
						$usuario_interes = UsuarioInteresDao::getXusuarioYinteres($_POST['id'], $interes->id)[0];
						
						$usuarioInteres = UsuarioInteresDao::get($usuario_interes->id);
						$usuarioInteres->id_usuario = $_POST['id'];
						$usuarioInteres->id_interes = $interes->id;
						$usuarioInteres->checked = $checked;
						UsuarioInteresDao::modificar($usuarioInteres);
					} else {
						$usuarioInteres = new usuario_interes();
						$usuarioInteres->id_usuario = $_POST['id'];
						$usuarioInteres->id_interes = $interes->id;
						$usuarioInteres->checked = $checked;
						UsuarioInteresDao::nuevo($usuarioInteres);
					}
				}
			} else {
				echo '<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $errores . '</div>';
			}
			break;

		case 'eliminar':
			UsuarioDao::eliminar($_POST['id']);
			break;

		case 'modificar-clave':
			$valido = true;
			$errores = '<strong>Ocurrieron los siguientes errores:</strong>';
				
			if (!isset($_POST['clave']) || $_POST['clave'] == '') {
				$errores .= '<p>- Debe completar la contrase&ntilde;a.</p>';
				$valido = false;
			}

			if (!isset($_POST['repetir']) || $_POST['repetir'] == '') {
				$errores .= '<p>- Debe repetir la contrase&ntilde;a.</p>';
				$valido = false;
			}

			if ($_POST['clave'] != $_POST['repetir']) {
				$errores .= '<p>- La repetici&oacute;n de la contrase&ntilde;a es incorrecta.</p>';
				$valido = false;
			}
				
			if ($valido) {
				
				UsuarioDao::modificarClave($_POST['id'], $_POST['clave']);
				
			} else {
				echo '<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $errores . '</div>';
			}
			break;
	}// switch accion

}

?>
