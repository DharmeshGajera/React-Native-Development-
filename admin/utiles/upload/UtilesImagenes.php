<?php

function subirArchivo($archivo) {
	
	if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/admin/temp/" . $archivo)) {
		copy($_SERVER["DOCUMENT_ROOT"] . "/admin/temp/" . $archivo, $_SERVER["DOCUMENT_ROOT"] . "/archivos/" . $archivo);
		unlink($_SERVER["DOCUMENT_ROOT"] . "/admin/temp/" . $archivo);
	}


	if(file_exists($_SERVER["DOCUMENT_ROOT"] . "/admin/temp/recortes/" . $archivo)) {
		copy($_SERVER["DOCUMENT_ROOT"] . "/admin/temp/recortes/" . $archivo, $_SERVER["DOCUMENT_ROOT"] . "/archivos/recortes/" . $archivo);
		unlink($_SERVER["DOCUMENT_ROOT"] . "/admin/temp/recortes/" . $archivo);
	}
}

?>