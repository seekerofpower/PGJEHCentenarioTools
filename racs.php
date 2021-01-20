<?php
include_once("./assets/functions/libsstyles.php");
//CARGAR EL MENU DE LA IZQUIERDA 
$menu = file_get_contents('assets/templates/leftMenu.html', FALSE);
//CARGAR EL CUERPO PRINCIPAL DE LA PÁGINA
$main = file_get_contents('assets/templates/mainPage.html', FALSE);
//CARGAR EL CONTENIDO DEL MODULO EN GENERAL
$reporte = file_get_contents('assets/templates/racs.html', FALSE);
//AGREGAR HOJAS DE ESTILO PROPIAS
$estilos=array('jquery.datetimepicker.min.css');
$listStyles=getStyles($estilos);
$main = str_replace("++++ESTILOS++++",$listStyles, $main);

//ICONO PERSONALIZADO
$main = str_replace("++++ICON++++",'pe-7s-folder', $main);

//AGREGAR LIBRERIAS DE JAVASCRIPT PROPIAS
$scripts=array("jquery.datetimepicker.js","jquery.redirect.js","racs.js");
$listScripts=getScripts($scripts);
$main = str_replace("++++JAVASCRIPTS++++",$listScripts, $main);

// MODAL DEL MODIFICADOR DE NUC
$modRAC=file_get_contents('assets/templates/modificarRAC.html', FALSE);
//ALGO DESPUES DEL HTML

$main = str_replace("++++EXTRAS++++", $modRAC, $main);

//COLOCAR EL MENU PROCESASDO EN EL CUERPO DE LA PAGINA
$main = str_replace("++++MENU++++", $menu, $main);

//COLOCAR EL CONTENIDO DEL MODULO EN EL CUERPO
$main = str_replace("++++CONTENIDO++++",$reporte, $main);
//CAMBIAR TITULO
$main = str_replace("++++TITULO++++","MANEJO DE RACs", $main);
//CAMBIAR DESCRIPCION
$main = str_replace("++++DESCRIPCION++++","Se pueden Eliminar, revisar y modificar RACs", $main);
echo $main;
?>