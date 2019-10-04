<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/RolDao.php');

class rol_form {
	
	public $item;
	
	public function __construct($id) {
		if ($id > 0) {
			$this->item = RolDao::get($id);
		} else {
			$this->item = new rol();
		}
	}
	
}
?>