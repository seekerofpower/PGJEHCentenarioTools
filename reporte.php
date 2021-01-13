<?php
include_once("./assets/functions/libsstyles.php");
//CARGAR EL MENU DE LA IZQUIERDA 
$menu = file_get_contents('assets/templates/leftMenu.html', FALSE);
//CARGAR EL CUERPO PRINCIPAL DE LA PÁGINA
$main = file_get_contents('assets/templates/mainPage.html', FALSE);
//CARGAR EL CONTENIDO DEL MODULO EN GENERAL
$reporte = file_get_contents('assets/templates/reporte.html', FALSE);
//AGREGAR HOJAS DE ESTILO PROPIAS
$estilos=array('jquery.datetimepicker.min.css');
$listStyles=getStyles($estilos);
$main = str_replace("++++ESTILOS++++",$listStyles, $main);

//ICONO PERSONALIZADO
$main = str_replace("++++ICON++++",'pe-7s-graph2', $main);

//AGREGAR LIBRERIAS DE JAVASCRIPT PROPIAS
$scripts=array("jquery.datetimepicker.js","jquery.redirect.js","reporte.js");
$listScripts=getScripts($scripts);
$main = str_replace("++++JAVASCRIPTS++++",$listScripts, $main);

//COLOCAR EL MENU PROCESASDO EN EL CUERPO DE LA PAGINA
$main = str_replace("++++MENU++++", $menu, $main);

//COLOCAR EL CONTENIDO DEL MODULO EN EL CUERPO
$main = str_replace("++++CONTENIDO++++",$reporte, $main);
//CAMBIAR TITULO
$main = str_replace("++++TITULO++++","REPORTE DIARIO DE CARPETAS", $main);
//CAMBIAR DESCRIPCION
$main = str_replace("++++DESCRIPCION++++","Se puede generar un archivo de hoja de cálculo de las carpetas genreradas en todos los servidores", $main);
echo $main;
?>