<?php
include_once("./assets/functions/libsstyles.php");

//CARGAR EL MENU DE LA IZQUIERDA 
$menu = file_get_contents('assets/templates/leftMenuLogin.html', FALSE);
//CARGAR EL CUERPO PRINCIPAL DE LA PÁGINA
$main = file_get_contents('assets/templates/pageLogin.html', FALSE);
//CARGAR EL CONTENIDO DEL MODULO EN GENERAL
$reporte = file_get_contents('assets/templates/login.html', FALSE);

//AGREGAR HOJAS DE ESTILO PROPIAS
$estilos=array();
$listStyles=getStyles($estilos);
$main = str_replace("++++ESTILOS++++",$listStyles, $main);

//AGREGAR LIBRERIAS DE JAVASCRIPT PROPIAS
$scripts=array("login.js");
$listScripts=getScripts($scripts);
$main = str_replace("++++JAVASCRIPTS++++",$listScripts, $main);

//COLOCAR EL MENU PROCESASDO EN EL CUERPO DE LA PAGINA
$main = str_replace("++++MENU++++", $menu, $main);
//COLOCAR EL CONTENIDO DEL MODULO EN EL CUERPO
$main = str_replace("++++CONTENIDO++++",$reporte, $main);
//CAMBIAR TITULO
$main = str_replace("++++TITULO++++","SISTEMA DE HERRAMIENTAS PARA EL SISTEMA CENTENARIO", $main);
//CAMBIAR DESCRIPCION
$main = str_replace("++++DESCRIPCION++++","Ingrese usuario y contraseña en la seccuón de la izquierda para poder ingresar al sistema", $main);
echo $main;
?>