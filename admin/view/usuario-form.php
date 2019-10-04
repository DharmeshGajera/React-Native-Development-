<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/RedesDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioRedSocialDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/InteresDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioInteresDao.php');

class usuario_form {
	
	public $item;
	public $jsonImagenes;
	
	public function __construct($id) {
		if ($id > 0) {
			$this->item = UsuarioDao::get($id);
		} else {
			$this->item = new usuario();
		}
		$this->redes = RedesDao::listActivos();
		$this->usuario_redsocial = UsuarioRedSocialDao::getXusuario($id);
		$this->intereses = InteresDao::listActivos();
		$this->usuario_interes = UsuarioInteresDao::getXusuario($id);

		$imagenes = array();
		if ($this->item->foto != '' && $this->item->archivo != '') {
			$ext = explode(".", $this->item->archivo);
				
			$img = new stdClass();
			$img->id = $this->item->id;
			$img->ref = $ext[0];
			$img->name = $this->item->foto;
			$img->namecode = $this->item->archivo;
			$img->place = "archivo";
				
			array_push($imagenes, $img);
		}
		$this->jsonImagenes = json_encode($imagenes);
	}
	
}
?>