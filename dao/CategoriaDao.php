<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/GenericDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/model/categoria.php');

class CategoriaDao {

	public static function get($id) {
		return GenericDao::get("categoria", array("id" => $id));
	}// get

	public static function listActivos() {
		return GenericDao::find("categoria", array(array("activo", "=", "1")));
	}

	public static function nuevo($item) {
		$query = "INSERT INTO categoria(
										nombre,
										puntos,
										codigo,
										activo,
										creado_fecha,
										creado_por)
							VALUES(
										:nombre, 
										:puntos,
										:codigo,
										1, 
										:creadoFecha, 
										:creadoPor)";

		$params = array(
						":nombre" => $item->nombre,
						":puntos" => $item->puntos,
						":codigo" => $item->codigo,
						":activo" => $item->activo,
						":creadoFecha" => date("Y-m-d H:i:s", time()),
						":creadoPor" => Utiles::obtenerIdUsuarioLogueado()
		);

		return GenericDao::executeQuery($query, $params, null, null, true);
	}// nuevo

	public static function modificar($item) {
		$query = "UPDATE categoria SET
						puntos = :puntos,
						activo = 1,
						modificado_fecha = :modificadoFecha,
						modificado_por = :modificadoPor
					WHERE id=:id";

		$params = array(
						":puntos" => $item->puntos,
						":modificadoFecha" => date("Y-m-d H:i:s", time()),
						":modificadoPor" => Utiles::obtenerIdUsuarioLogueado(),
						":id" => $item->id
		);

		GenericDao::executeQuery($query, $params);
	}// modificarPerfil
	
	public static function eliminar($id) {
		$query = "UPDATE categoria SET
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