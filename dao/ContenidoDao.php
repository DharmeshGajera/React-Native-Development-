<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/GenericDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/model/contenido.php');

class ContenidoDao {

	public static function get($id) {
		return GenericDao::get("contenido", array("id" => $id));
	}// get

	public static function listActivos() {
		return GenericDao::find("contenido", array(array("activo", "=", "1")));
	}

	public static function nuevo($item) {
		$query = "INSERT INTO contenido(
										titulo,
										bajada,
										link,
										categoria_contenido,
										fecha_publicacion,
										fecha_actividad,
										compartir,
										foto,
										archivo,
										activo,
										creado_fecha,
										creado_por)
							VALUES(
										:titulo, 
										:bajada, 
										:link,
										:categoria_contenido,
										:fecha_publicacion,
										:fecha_actividad,
										:compartir,
										:foto,
										:archivo,
										1, 
										:creadoFecha, 
										:creadoPor)";

		$params = array(
						":titulo" => $item->titulo,
						":bajada" => $item->bajada,
						":link" => $item->link,
						":categoria_contenido" => $item->categoria_contenido,
						":fecha_publicacion" => $item->fecha_publicacion,
						":fecha_actividad" => $item->fecha_actividad,
						":compartir" => $item->compartir,
						":foto" => $item->foto,
						":archivo" => $item->archivo,
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
		$query = "UPDATE contenido SET
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