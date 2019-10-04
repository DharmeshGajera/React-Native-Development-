<?php

function getConnection() {
	return new PDO("mysql:host=74.208.235.89;dbname=accenture", "fidelizados", "Alan1234!");//servidor
	//return new PDO("mysql:host=127.0.0.1;dbname=accenture", "root", "");//local
}// getConnection

?>