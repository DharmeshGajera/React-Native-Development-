<?php
session_start();

set_time_limit(0);

include_once ($_SERVER["DOCUMENT_ROOT"] . '/model/usuario.php');

class Utiles {

	public static function iniciarSesion($usuario) {
		$_SESSION['user-logged'] = $usuario;
		$_SESSION['user-token'] = $usuario->id . time();
	}// iniciarSesion

	public static function cerrarSesion() {
		unset($_SESSION['user-logged']);
		unset($_SESSION['user-token']);
	}// cerrarSesion

	public static function sesionIniciada() {
		return (isset($_SESSION['user-logged']) && $_SESSION['user-logged'] != '') ? true : false;
	}// sesionIniciada

	public static function obtenerUsuarioLogueado() {
		return (isset($_SESSION['user-logged']) && $_SESSION['user-logged'] != '') ? unserialize(serialize($_SESSION['user-logged'])) : null;
	}// obtenerUsuarioLogueado

	public static function obtenerIdUsuarioLogueado() {
		$logueado = Utiles::obtenerUsuarioLogueado();
		return isset($logueado) ? $logueado->id : 1;
	}// obtenerIdUsuarioLogueado

	public static function obtenerToken() {
		return (isset($_SESSION['user-token']) && $_SESSION['user-token'] != '') ? $_SESSION['user-token'] : null;
	}// obtenerUsuarioLogueado

	public static final function ValidarSesionIniciada() {
		if (!Utiles::sesionIniciada()) {
			header("Location: login.php");
		}
	}// ValidarSesionIniciada

	public static final function obtenerNombreDia($i) {
		$dias = array("Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado");
		return $dias[$i];
	}// obtenerNombreDia

	public static final function obtenerNombreMes($i) {
		$dias = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
		return $dias[$i - 1];
	}// obtenerNombreMes
	public static final function get_code_youtube($link){
		$code = explode("v=", $link);
		return $code[count($code)-1];
	}
	public static final function renderizar_youtube($code)
	{
		$link_completo='<iframe class="img-responsive" src="https://www.youtube.com/embed/'.$code.'" frameborder="0" allowfullscreen></iframe>';
		return $link_completo;
	}

	public static function validarPermisos($lmodel, $view) {
		$usuario = Utiles::obtenerUsuarioLogueado();
		if ($usuario->id_rol == 1) {
			return true;
		} else {
			return false;
		}
		return true;
	}
	
	public static function validarPermisosAdministrador($lmodel, $view) {
		$usuario = Utiles::obtenerUsuarioLogueado();
		if ($usuario->id_rol == 1) {
			return true;
		} else {
			return false;
		}

		return true;
	}

	public static function enviarEmail($to, $cco, $asunto, $mensaje) {
		$headers = "From: Club de Embajadores <Info@accenture-fidelizados.com> \r\n";
		$headers .= 'MIME-Version: 1.0' . " \r\n";
		$headers .= 'Content-type: text/html; charset=utf-8' . " \r\n";

		if ($cco != null && $cco != '') {
			$headers .= 'Bcc: ' . $cco . "\r\n";
		}

		mail($to, $asunto, $mensaje, $headers);
		if (mail($to, $asunto, $mensaje, $headers)) {
		    echo "Mensaje Enviado";
		} else {
		    echo "Error: Mensaje no pudo ser enviado";
		}
	}
	
}

?>