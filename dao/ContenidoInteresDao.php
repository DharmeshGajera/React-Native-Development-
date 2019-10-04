<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/GenericDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/model/contenido_interes.php');

class ContenidoInteresDao {

	public static function get($id) {
		return GenericDao::get("contenido_interes", array("id" => $id));
	}

	public static function getXcontenido($id_contenido) {
		return GenericDao::find("contenido_interes", array(array("id_contenido", "=", $id_contenido)));
	}

	public static function getXcontenidoYinteres($id_contenido, $id_interes) {
		return GenericDao::find("contenido_interes", array(array("id_contenido", "=", $id_contenido), array("id_interes", "=", $id_interes), array("activo", "=", "1")));
	}

	public static function listActivos() {
		return GenericDao::find("contenido_interes", array(array("activo", "=", "1")));
	}

	public static function nuevo($item) {
		$query = "INSERT INTO contenido_interes(
										id_contenido,
										id_interes,
										checked,
										activo,
										creado_fecha,
										creado_por)
							VALUES(																				
										:id_contenido,
										:id_interes,
										:checked,
										1,
										:creadoFecha, 
										:creadoPor)";

		$params = array(
						":id_contenido" => $item->id_contenido,
						":id_interes" => $item->id_interes,
						":checked" => $item->checked,
						":creadoFecha" => date("Y-m-d H:i:s", time()),
						":creadoPor" => Utiles::obtenerIdUsuarioLogueado()
		);

		return GenericDao::executeQuery($query, $params, null, null, true);
	}// nuevo

	public static function modificar($item) {
		$item->modificado_fecha = date("Y-m-d H:i:s", time());
		$item->modificado_por = Utiles::obtenerIdUsuarioLogueado();

		GenericDao::update($item);
	}

	public static function eliminar($id) {
		$query = "UPDATE contenido_interes SET
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