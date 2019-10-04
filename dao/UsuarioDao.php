<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/GenericDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/model/usuario.php');

class UsuarioDao {

	public static function get($id) {
		return GenericDao::get("usuario", array("id" => $id));
	}

	public static function listActivos() {
		return GenericDao::find("usuario", array(array("activo", "=", "1")));
	}

	public static function listEmbajadores() {
		return GenericDao::find("usuario", array(array("activo", "=", "1"), array("id_rol", "=", "3")));
	}

	public static function listAsistentes() {
		return GenericDao::find("usuario", array(array("activo", "=", "1"), array("id_rol", "=", "2")));
	}

	public static function listAdministradores() {
		return GenericDao::find("usuario", array(array("activo", "=", "1"), array("id_rol", "=", "1")));
	}

	public static function listLastFiveUsersLogged() {
		return GenericDao::find("usuario", array(array("activo", "=", "1")), "fecha_ultimo_logueo DESC", 0,5);
	}

	public static function nuevo($usuario) {
		$item->modificado_fecha = date("Y-m-d H:i:s", time());
		$item->modificado_por = Utiles::obtenerIdUsuarioLogueado();

		GenericDao::update($item);
	}// nuevo

	public static function modificarPerfil($usuario) {
		$query = "UPDATE usuario SET
									nombre = :nombre,
									apellido = :apellido,
									email = :email,
									id_rol = :id_rol,
									nombre_usuario = :nombre_usuario,
									foto = :foto,
									archivo = :archivo,
									modificado_fecha = :modificadoFecha, 
									modificado_por = :modificadoPor 
					WHERE id = :id";

		$params = array(
						":nombre" => $usuario->nombre, 
						":apellido" => $usuario->apellido, 
						":email" => $usuario->email, 
						":id_rol" => $usuario->id_rol,
						":nombre_usuario" => $usuario->nombre_usuario,
						":foto" => $usuario->foto,
						":archivo" => $usuario->archivo,
						":modificadoFecha" => date("Y-m-d H:i:s", time()), 
						":modificadoPor" => Utiles::obtenerIdUsuarioLogueado(), 
						":id" => $usuario->id 
		);

		GenericDao::executeQuery($query, $params);
	}// modificarPerfil
	
	public static function modificarClave($id, $clave) {
		$query = "UPDATE usuario SET
									clave = PASSWORD(:clave),
									modificado_fecha = :modificadoFecha, 
									modificado_por = :modificadoPor 
					WHERE id = :id";

		$params = array(
						":clave" => $clave,
						":modificadoFecha" => date("Y-m-d H:i:s", time()), 
						":modificadoPor" => Utiles::obtenerIdUsuarioLogueado(), 
						":id" => $id 
		);

		GenericDao::executeQuery($query, $params);
	}// modificarClave

	public static function eliminar($id) {
		$query = "UPDATE usuario SET
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

	public static function login($usuario, $clave) {
		$query = "SELECT * FROM usuario WHERE (email = :usuario OR nombre_usuario = :usuario) AND clave = PASSWORD(:clave) AND activo = 1 AND id_rol != 3 ";

		$params = array(
						":usuario" => $usuario,
						":clave" => $clave
		);

		$usuario = GenericDao::executeQuery($query, $params, "usuario", false);

		return $usuario;
	}// login

	public static function getUsersPush($id) {
		$query = "SELECT DISTINCT u.id AS id_user, u.push_token, c.titulo AS title " .
				" FROM contenido AS c " .
				" INNER JOIN contenido_interes AS ci ON c.id = ci.id_contenido AND ci.checked = 1 " .
				" INNER JOIN interes AS i ON ci.id_interes = i.id " .
				" INNER JOIN usuario_interes AS ui ON i.id = ui.id_interes AND ui.checked = 1 " .
				" INNER JOIN usuario AS u ON u.id = ui.id_usuario " .
				" WHERE c.id=:id";

		$params = array(
						":id" => $id
		);

		$usuario = GenericDao::executeQuery($query, $params, "usuario", true);

		return $usuario;
	}
	
	public static function getXusuario($usuario) {
		return GenericDao::find("usuario", array(array("email", "=", $usuario)));
	}// getXusuario
	
	public static function getXemail($email) {
		return GenericDao::find("usuario", array(array("email", "=", $email)));
	}// getXemail
	
	public static function getXemailYactivo($email) {
		return GenericDao::find("usuario", array(array("email", "=", $email), array("activo", "=", 1)));
	}// getXemail
}

?>