<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/GenericDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/model/rol.php');

class RolDao {

	public static function get($id) {
		return GenericDao::get("rol", array("id" => $id));
	}// get

	public static function listActivos() {
		return GenericDao::find("rol", array(array("activo", "=", "1")));
	}

	public static function nuevo($rol) {
		$query = "INSERT INTO rol(
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
						":nombre" => $rol->nombre,
						":creadoFecha" => date("Y-m-d H:i:s", time()),
						":creadoPor" => Utiles::obtenerIdUsuarioLogueado()
		);

		return GenericDao::executeQuery($query, $params, null, null, true);
	}// nuevo

	public static function modificarPerfil($rol) {
		$query = "UPDATE rol SET
									nombre= :nombre,
									modificado_fecha = :modificadoFecha, 
									modificado_por = :modificadoPor 
					WHERE id = :id";

		$params = array(
						":nombre" => $rol->nombre,
						":modificadoFecha" => date("Y-m-d H:i:s", time()), 
						":modificadoPor" => Utiles::obtenerIdUsuarioLogueado(), 
						":id" => $rol->id 
		);

		GenericDao::executeQuery($query, $params);
	}// modificarPerfil	

	public static function eliminar($id) {
		$query = "UPDATE rol SET
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
	}
}

?>