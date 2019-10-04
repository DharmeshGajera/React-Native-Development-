<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/GenericDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/model/redes_sociales.php');

class RedesDao {

	public static function get($id) {
		return GenericDao::get("redes_sociales", array("id" => $id));
	}// get

	public static function listActivos() {
		return GenericDao::find("redes_sociales", array(array("activo", "=", "1")));
	}

	public static function nuevo($item) {
		$query = "INSERT INTO redes_sociales(
										nombre,
										activo,
										creado_fecha,
										creado_por)
							VALUES(
										:nombre, 
										1, 
										:creadoFecha, 
										:creadoPor)";

		$params = array(
						":nombre" => $item->nombre,
						":creadoFecha" => date("Y-m-d H:i:s", time()),
						":creadoPor" => Utiles::obtenerIdUsuarioLogueado()
		);

		return GenericDao::executeQuery($query, $params, null, null, true);
	}// nuevo

	public static function modificar($item) {
		$item->modificado_fecha = date("Y-m-d H:i:s", time());
		$item->modificado_por = Utiles::obtenerIdUsuarioLogueado();

		GenericDao::update($item);
	}// modificarPerfil
	
	public static function eliminar($id) {
		$query = "UPDATE redes_sociales SET
									activo = false,
									eliminado_fecha = :modificadoFecha, 
									eliminado_por = :modificadoPor 
					WHERE id = :id";

		$params = array(
						":modificadoFecha" => date("Y-m-d H:i:s", time()), 
						":modificadoPor" => Utiles::obtenerIdUsuarioLogueado(), 
						":id" => $id 
		);

		GenericDao::executeQuery($query, $params);
	}// eliminar
}

?>