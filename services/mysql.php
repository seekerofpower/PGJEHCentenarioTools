<?php
	function getMySQLConection(){
		$usuario = "root";
		$contraseña = "root";
		
		$nombreBaseDeDatos = "HERRAMIENTAS";
		# Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
		$rutaServidor = "localhost";
		try {
	    	$conexion = new PDO("mysql:host=$rutaServidor;dbname=$nombreBaseDeDatos;charset=utf8", $usuario, $contraseña);
	    	$conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (Exception $e) {
	    	echo "Ocurrió un error con la base de datos: " . $e->getMessage();
		}

		return $conexion;
	}

?>