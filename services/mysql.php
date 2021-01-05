<?php
	function conexion(){
		$contraseña = "rechumanos";
		$usuario = "urechumanos";
		$nombreBaseDeDatos = "RecHumanos";
		# Puede ser 127.0.0.1 o el nombre de tu equipo; o la IP de un servidor remoto
		$rutaServidor = "WIN-4FCB5IHCDOG";
		try {
	    	$conexion = new PDO("sqlsrv:server=$rutaServidor;database=$nombreBaseDeDatos", $usuario, $contraseña);
	    	$conexion -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (Exception $e) {
	    	echo "Ocurrió un error con la base de datos: " . $e->getMessage();
		}

		return $conexion;
	}

?>