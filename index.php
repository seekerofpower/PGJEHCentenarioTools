<?php
session_start();
if (isset($_SESSION['user'])) 
{
    //AGREGAR HOJAS DE ESTILO PROPIAS

    //AGREGAR LIBRERIAS DE JAVASCRIPT PROPIAS


    //CARGAR EL MENU DE LA IZQUIERDA 
    $menu = file_get_contents('assets/templates/leftMenu.html', FALSE);
    //CARGAR EL CUERPO PRINCIPAL DE LA PÁGINA
    $main = file_get_contents('assets/templates/mainPage.html', FALSE);
    //CARGAR EL CONTENIDO DEL MODULO EN GENERAL
    $reporte = file_get_contents('assets/templates/inicio.html', FALSE);

    //COLOCAR EL MENU PROCESASDO EN EL CUERPO DE LA PAGINA
    $main = str_replace("++++MENU++++", $menu, $main);
    //COLOCAR EL CONTENIDO DEL MODULO EN EL CUERPO
    $main = str_replace("++++CONTENIDO++++",$reporte, $main);
    //CAMBIAR TITULO
    $main = str_replace("++++TITULO++++","HERRAMIENTAS PARA EL SISTEMA CENTENARIO", $main);
    //CAMBIAR DESCRIPCION
    $main = str_replace("++++DESCRIPCION++++","Este sistema incluye un conjunto de herramientas para el sistema Centenario", $main);
    echo $main;
}
else
{
    header('Location: '.'login.php');
}

?>
