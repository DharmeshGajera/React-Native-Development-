<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/GenericDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/model/interes.php');

class InteresDao {

	public static function get($id) {
		return GenericDao::get("interes", array("id" => $id));
	}// get

	public static function listActivos() {
		return GenericDao::find("interes", array(array("activo", "=", "1")));
	}

	public static function nuevo($item) {
		$query = "INSERT INTO interes(
										nombre,
										color,
										activo,
										creado_fecha,
										creado_por)
							VALUES(
										:nombre,
										:color,
										1, 
										:creadoFecha, 
										:creadoPor)";

		$params = array(
						":nombre" => $item->nombre,
						":color" => $item->color,
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
		$query = "UPDATE interes SET
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