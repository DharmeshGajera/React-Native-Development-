<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/model/GenericEntity.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/RolDao.php');

final class rol extends GenericEntity{

	public $id;
	public $nombre;	
	public $activo;	

	public $creado_fecha;
	public $creado_por;
	public $modificado_fecha;
	public $modificado_por;
	public $eliminado_fecha;
	public $eliminado_por;

	private $creado = null;
	private $modificado = null;
	private $eliminado = null;

	public function __construct() {
		$this->setPk(array("id"));
	}

	public function getCreado() {
		if ($this->creado == null) {
			$this->creado = UsuarioDao::get($this->creado_por);
		}
		return $this->creado;
	}

	public function getModificado() {
		if ($this->modificado == null) {
			$this->modificado = UsuarioDao::get($this->modificado_por);
		}
		return $this->modificado;
	}

	public function getEliminado() {
		if ($this->eliminado == null) {
			$this->eliminado = UsuarioDao::get($this->eliminado_por);
		}
		return $this->eliminado;
	}

};
?>