<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/ContenidoDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/InteresDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/ContenidoInteresDao.php');

class contenido_form {
	
	public $item;
	public $jsonImagenes;
	
	public function __construct($id) {
		if ($id > 0) {
			$this->item = ContenidoDao::get($id);
		} else {
			$this->item = new contenido();
		}
		$this->intereses = InteresDao::listActivos();
		$this->contenido_interes = ContenidoInteresDao::getXcontenido($id);

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