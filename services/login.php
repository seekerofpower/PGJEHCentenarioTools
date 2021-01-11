<?php
include_once('mysql.php'); 
$db=getMySQLConection();
$qLogin=$db->prepare("SELECT
                        U.idUsuario
                        ,U.nombreUsuario
                       ,UPPER(CONCAT(U.nombre,' ',U.paterno,' ',U.materno)) USUARIO
                        FROM usuarios U
                        WHERE U.password= SHA2(:PASSWORD,512)
                        AND U.nombreUsuario=:USERNAME
                        AND U.activo=1");

$qLogin->bindParam(':USERNAME', $_POST['usuario'], PDO::PARAM_STR);
$qLogin->bindParam(':PASSWORD', $_POST['password'], PDO::PARAM_STR);
$qLogin->execute();

$resultado['resultado']='';                        
if($qLogin->rowCount()>0)
    {
        $dLogin=$qLogin->fetch(PDO::FETCH_ASSOC);
        //error_log("USUARIO OBTENIDO");
        $resultado['resultado']='OK';
        session_start();
        $_SESSION['user']=$dLogin['idUsuario'];
        $_SESSION['nombre']=$dLogin['USUARIO'];
    }
    else
    {
        $resultado['resultado']='ERROR';
        $resultado['info']='Usuario y/p contraseña no encontrados';
    }
    echo  json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
?>