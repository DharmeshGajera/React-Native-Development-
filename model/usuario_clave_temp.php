<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/model/GenericEntity.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioClaveTempDao.php');

final class usuario_clave_temp extends GenericEntity{

	public $id;
	public $email;
	public $token;
	public $fecha;
	public $activo;

	public function __construct() {
		$this->setPk(array("id"));
	}

};
?>