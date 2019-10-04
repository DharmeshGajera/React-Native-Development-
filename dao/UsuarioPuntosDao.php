<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/GenericDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/model/usuario_puntos.php');

class UsuarioPuntosDao {

	public static function get($id) {
		return GenericDao::get("usuario_puntos", array("id" => $id));
	}

	public static function getXusuario($id_usuario) {
		return GenericDao::find("usuario_puntos", array(array("id_usuario", "=", $id_usuario)));
	}

	public static function listActivos() {
		return GenericDao::find("usuario_puntos", array(array("activo", "=", "1")));
	}

	public static function nuevo($item) {
		$query = "INSERT INTO usuario_puntos(
										id_usuario,
										puntos,
										activo,
										creado_fecha,
										creado_por)
							VALUES(																				
										:id_usuario,
										:puntos,
										1,
										:creadoFecha, 
										:creadoPor)";

		$params = array(
						":id_usuario" => $item->id_usuario,
						":puntos" => $item->puntos,
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
		$query = "UPDATE usuario_puntos SET
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