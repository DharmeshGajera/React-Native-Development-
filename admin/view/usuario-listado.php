<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/utiles/Utiles.php');

if (Utiles::validarPermisos("usuarios", "consultar")) {

	$response = array();

	if (isset($_GET['token']) && $_GET['token'] == Utiles::obtenerToken()) {

		include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioDao.php');

		$result = UsuarioDao::listActivos();
		$listado = array();
		foreach ($result as $item) {

			array_push($listado, array(
									$item->nombre,
									$item->apellido,  
									$item->email,
									$item->nombre_usuario,
									$item->getCategoria()->nombre,
									'
									<button onclick="javascript:clave(' . $item->id . ');" type="button" class="btn btn-default btn-sm mr5"><i class="fa fa-lock"></i> Modificar contrase&ntilde;a</button>
									<button onclick="javascript:editar(' . $item->id . ');" type="button" class="btn btn-primary btn-sm mr5"><i class="fa fa-pencil"></i> Editar</button>
									<button onclick="javascript:eliminar(' . $item->id . ');" type="button" class="btn btn-danger btn-sm mr5"><i class="fa fa-trash"></i> Eliminar</button>
									'));
		}
		
		$response['data'] = $listado;

		echo json_encode($response);

	} else {
		$response['aaData'] = array();
		echo json_encode($response);
	}// if-else token

} else {
	$response['aaData'] = array();
	echo json_encode($response);
}

?>