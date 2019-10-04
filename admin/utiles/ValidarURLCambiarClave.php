<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioClaveTempDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioDao.php');

class usuario_clave_temp_form {
	
	public $item;
	public $usuario;
	
	public function __construct($token) {
		$this->item = UsuarioClaveTempDao::getByToken($token);
		if ($this->item) {
			$this->usuario = UsuarioDao::getXemailYactivo($this->item->email);
		}
	}
	
}
?>