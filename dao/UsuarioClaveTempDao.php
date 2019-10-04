<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/GenericDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/model/usuario_clave_temp.php');

class UsuarioClaveTempDao {

	public static function get($id) {
		return GenericDao::get("usuario_clave_temp", array("id" => $id));
	}

	public static function getByToken($token) {
		$fecha = date("Y-m-d H:i:s", time());
		$query = "SELECT * FROM usuario_clave_temp " .
				" WHERE token ='" . $token . "' AND activo = 1 AND fecha BETWEEN '" . date("Y-m-d H:i:s",strtotime($fecha."- 1 days")) . "' AND '" . date("Y-m-d H:i:s",strtotime($fecha."+ 1 days")) . "'";
		$params = array();
		$usuario_clave_temp = GenericDao::executeQuery($query, $params, "usuario_clave_temp", false);

		return $usuario_clave_temp;

	}

	public static function listActivos() {
		return GenericDao::find("usuario_clave_temp", array(array("activo", "=", "1")));
	}

	public static function nuevo($item) {
		$query = "INSERT INTO usuario_clave_temp(
										email,
										token,
										fecha,
										activo)
							VALUES(
										:email, 
										:token,
										:fecha,
										1)";

		$params = array(
						":email" => $item->email,
						":token" => $item->token,
						":fecha" => date("Y-m-d H:i:s", time())
		);

		return GenericDao::executeQuery($query, $params, null, null, true);
	}

	public static function eliminar($id) {
		$query = "UPDATE usuario_clave_temp SET
									activo = false
					WHERE id = :id";

		$params = array(
						":id" => $id 
		);

		return GenericDao::executeQuery($query, $params);
	}
}

?>