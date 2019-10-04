<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/utiles/Utiles.php');

Utiles::ValidarSesionIniciada();

$token = isset($_POST['token']) ? $_POST['token'] : $_GET['token'];
$accion = isset($_POST['accion']) ? $_POST['accion'] : $_GET['accion'];

if (isset($token) && $token == Utiles::obtenerToken()) {

	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioDao.php');
	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/ContenidoDao.php');
	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/InteresDao.php');
	include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/ContenidoInteresDao.php');
	include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/utiles/upload/UtilesImagenes.php');

	switch ($accion) {
		case 'nuevo':
			$valido = true;
			$errores = '<strong>Ocurrieron los siguientes errores:</strong>';

			if (!Utiles::validarPermisos("usuarios", "agregar")) {
				$errores .= '<p>- No tiene permisos para la operaci&oacute;n que desea realizar.</p>';
				$valido = false;
			}
			
			if (!isset($_POST['titulo']) || $_POST['titulo'] == '') {
				$errores .= '<p>- Debe completar el titulo del contenido.</p>';
				$valido = false;
			}
			
			if (!isset($_POST['bajada']) || $_POST['bajada'] == '') {
				$errores .= '<p>- Debe completar la bajada del contenido.</p>';
				$valido = false;
			}

			if (!isset($_POST['link']) || $_POST['link'] == '') {
				$errores .= '<p>- Debe completar el link del contenido.</p>';
				$valido = false;
			}

			if (!isset($_POST['categoria_contenido']) || $_POST['categoria_contenido'] == '') {
				$errores .= '<p>- Debe seleccionar la categoria del contenido.</p>';
				$valido = false;
			} else {
				if ($_POST['categoria_contenido'] == 3) {
					if (!isset($_POST['fecha_actividad']) || $_POST['fecha_actividad'] == '') {
						$errores .= '<p>- Debe completar la fecha de la actividad del contenido.</p>';
						$valido = false;
					}
				}
			}
			
			if (!isset($_POST['fecha_publicacion']) || $_POST['fecha_publicacion'] == '') {
				$errores .= '<p>- Debe completar la fecha de publicacion del contenido.</p>';
				$valido = false;
			}

			if (!isset($_POST['compartir']) || $_POST['compartir'] == '') {
				$errores .= '<p>- Debe seleccionar si desea compartir el contenido.</p>';
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

			if ($valido) {

				$item = new contenido();
				$item->titulo = $_POST['titulo'];
				$item->bajada = $_POST['bajada'];
				$item->link = $_POST['link'];
				$item->categoria_contenido = $_POST['categoria_contenido'];

				$fechaPublicacion = strtotime(str_replace('/', '-', $_POST['fecha_publicacion']));
				$fechaPublicacionEditado = date('Y-m-d',$fechaPublicacion);
				$item->fecha_publicacion = $fechaPublicacionEditado;

				if (isset($_POST['fecha_actividad'])) {
					$fechaActividad = strtotime(str_replace('/', '-', $_POST['fecha_actividad']));
					$fechaActividadEditado = date('Y-m-d',$fechaActividad);
					$item->fecha_actividad = $fechaActividadEditado;
				};

				$item->compartir = $_POST['compartir'];
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
				
				ContenidoDao::nuevo($item);

				//AHORA CARGO LOS INTERESES DEL CONTENIDO
				/*$newContenido = ContenidoDao::get($item->id);
				$intereses = InteresDao::listActivos();
				foreach ($intereses as $interes) {
					if (!isset($_POST[$interes->nombre]) || $_POST[$interes->nombre] == '') {
						$checked = 0;
					} else {
						$checked = $_POST[$interes->nombre];
					}
					$contenidoInteres = new contenido_interes();
					$contenidoInteres->id_contenido = $newContenido[0]->id;
					$contenidoInteres->id_interes = $interes->id;
					$contenidoInteres->checked = $checked;
					ContenidoInteresDao::nuevo($contenidoInteres);
				}*/
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
			
			if (!isset($_POST['titulo']) || $_POST['titulo'] == '') {
				$errores .= '<p>- Debe completar el titulo del contenido.</p>';
				$valido = false;
			}
			
			if (!isset($_POST['bajada']) || $_POST['bajada'] == '') {
				$errores .= '<p>- Debe completar la bajada del contenido.</p>';
				$valido = false;
			}

			if (!isset($_POST['link']) || $_POST['link'] == '') {
				$errores .= '<p>- Debe completar el link del contenido.</p>';
				$valido = false;
			}

			if (!isset($_POST['categoria_contenido']) || $_POST['categoria_contenido'] == '') {
				$errores .= '<p>- Debe seleccionar la categoria del contenido.</p>';
				$valido = false;
			} else {
				if ($_POST['categoria_contenido'] == 3) {
					if (!isset($_POST['fecha_actividad']) || $_POST['fecha_actividad'] == '') {
						$errores .= '<p>- Debe completar la fecha de la actividad del contenido.</p>';
						$valido = false;
					}
				}
			}
			
			if (!isset($_POST['fecha_publicacion']) || $_POST['fecha_publicacion'] == '') {
				$errores .= '<p>- Debe completar la fecha de publicacion del contenido.</p>';
				$valido = false;
			}

			if (!isset($_POST['compartir']) || $_POST['compartir'] == '') {
				$errores .= '<p>- Debe seleccionar si desea compartir el contenido.</p>';
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
			
			if ($valido) {
											
				$item = ContenidoDao::get($_POST['id']);
				$item->titulo = $_POST['titulo'];
				$item->bajada = $_POST['bajada'];
				$item->link = $_POST['link'];
				$item->categoria_contenido = $_POST['categoria_contenido'];

				$fechaPublicacion = strtotime(str_replace('/', '-', $_POST['fecha_publicacion']));
				$fechaPublicacionEditado = date('Y-m-d',$fechaPublicacion);
				$item->fecha_publicacion = $fechaPublicacionEditado;

				if (isset($_POST['fecha_actividad'])) {
					$fechaActividad = strtotime(str_replace('/', '-', $_POST['fecha_actividad']));
					$fechaActividadEditado = date('Y-m-d',$fechaActividad);
					$item->fecha_actividad = $fechaActividadEditado;
				};
				
				$item->compartir = $_POST['compartir'];
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
				
				ContenidoDao::modificar($item);
				
				//AHORA ACTUALIZO LOS INTERESES DEL CONTENIDO
				$intereses = InteresDao::listActivos();
				foreach ($intereses as $interes) {
					if (!isset($_POST[$interes->nombre]) || $_POST[$interes->nombre] == '') {
						$checked = 0;
					} else {
						$checked = $_POST[$interes->nombre];
					}
					if(ContenidoInteresDao::getXcontenidoYinteres($_POST['id'], $interes->id)) {
						$contenido_interes = ContenidoInteresDao::getXcontenidoYinteres($_POST['id'], $interes->id)[0];
						
						$contenidoInteres = ContenidoInteresDao::get($contenido_interes->id);
						$contenidoInteres->id_contenido = $_POST['id'];
						$contenidoInteres->id_interes = $interes->id;
						$contenidoInteres->checked = $checked;
						ContenidoInteresDao::modificar($contenidoInteres);
					} else {
						$contenidoInteres = new contenido_interes();
						$contenidoInteres->id_contenido = $_POST['id'];
						$contenidoInteres->id_interes = $interes->id;
						$contenidoInteres->checked = $checked;
						ContenidoInteresDao::nuevo($contenidoInteres);
					}
				}
			} else {
				echo '<div class="alert alert-danger fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' . $errores . '</div>';
			}
			break;

		case 'eliminar':
			ContenidoDao::eliminar($_POST['id']);
			break;

		case 'publish':
			//HERE IS WHERE THE PUSH NOTIFICATIONS MUST BE
			$usersPush = UsuarioDao::getUsersPush($_POST['id']);

			foreach ($usersPush as $user) {
				//$token is the devide token where the push has to be sended
				$token = $user->push_token;
				//$title is the message that has to be in the push
				$title = $user->title;
			}
			break;

	}// switch accion

}

?>