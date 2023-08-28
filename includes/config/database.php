<?php

function conectarDB() : mysqli {
	$db = mysqli_connect('localhost', 'root', '', 'login');

	if(!$db) {
		echo "Error no se pudo conectar";
		exit;
	}

	return $db;
}