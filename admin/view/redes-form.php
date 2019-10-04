<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/RedesDao.php');

class redes_sociales_form {
	
	public $item;
	
	public function __construct($id) {
		if ($id > 0) {
			$this->item = RedesDao::get($id);
		} else {
			$this->item = new redes_sociales();
		}
	}
	
}
?>