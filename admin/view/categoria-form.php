<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/CategoriaDao.php');

class categoria_form {
	
	public $item;
	
	public function __construct($id) {
		if ($id > 0) {
			$this->item = CategoriaDao::get($id);
		} else {
			$this->item = new categoria();
		}
	}
	
}
?>