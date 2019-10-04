<?php
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/UsuarioDao.php');
include_once ($_SERVER["DOCUMENT_ROOT"] . '/dao/CategoriaDao.php');

class home_form {

	public function __construct() {
		$this->embajadores = UsuarioDao::listEmbajadores();
		$this->asistentes = UsuarioDao::listAsistentes();
		$this->administradores = UsuarioDao::listAdministradores();
		$this->logueosDeUsuarios = UsuarioDao::listActivos();
		$this->cantidad_logueos = 0;
		foreach ($this->logueosDeUsuarios as $logueos) {
			$this->cantidad_logueos += $logueos->cantidad_logueos;
		}
		$this->lastFiveUsers = UsuarioDao::listLastFiveUsersLogged();
		$this->contenido = CategoriaDao::listActivos();
		$this->contenidoTotalLeido = 0;
		$this->contenidoTotalCompartido = 0;
		foreach ($this->contenido as $contenido) {
			$this->contenidoTotalLeido += $contenido->leido;
			$this->contenidoTotalCompartido += $contenido->compartido;
		}
	}
	
}
?>