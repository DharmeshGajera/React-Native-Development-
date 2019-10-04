<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/InteresDao.php');

class interes_form {
	
	public $item;
	
	public function __construct($id) {
		if ($id > 0) {
			$this->item = InteresDao::get($id);
		} else {
			$this->item = new interes();
		}
	}
	
}
?>