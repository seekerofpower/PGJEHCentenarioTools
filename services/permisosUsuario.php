<?php
include_once('mysql.php');
function obtenerPermisosUsuarioModulo($modulo)
{
    if(isset($_SESSION['user']))
    {     
        $db=getMySQLConection();

        $sqlPersmisos="SELECT p.descripcion FROM permisosusuario pu 
        INNER JOIN permisos p ON pu.idPermiso=p.idPermiso
        WHERE idUsuario=:USUARIO
        AND pu.activo=1
        AND p.idModulo=:MODULO";
        $qPermisos=$db->prepare($sqlPersmisos);
        $qPermisos->bindParam(':USUARIO', $_SESSION['user'],PDO::PARAM_INT);
        $qPermisos->bindParam(':MODULO', $modulo,PDO::PARAM_INT);
        $qPermisos->execute();
        $permisos= array();
        while($fila=$qPermisos->fetch(PDO::FETCH_ASSOC)) 
        {
            
            //echo $fila['descripcion']."<br>";
            array_push($permisos,$fila['descripcion']);
        }
        //echo "USUARIO:".$_SESSION['user']."<br>";
        //print_r($permisos);
        return $permisos;
    }
    else
    {
        echo  "error de sesion";
        return false;    
    }

}