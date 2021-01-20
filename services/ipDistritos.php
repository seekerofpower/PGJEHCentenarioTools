<?php
include_once('mysql.php'); 
$db=getMySQLConection();
$qDistritos=$db->prepare("SELECT
                        ip,nombre FROM distritos WHERE activo=1 ORDER BY numero ");

$qDistritos->execute();

$distritos=array();                        
if($qDistritos->rowCount()>0)
    {
        $resultado['resultado']='OK';
        
        while($fila=$qDistritos->fetch(PDO::FETCH_ASSOC)) 
        {
            $distritos[]= array($fila['ip']=>$fila['nombre']);
        }
        $resultado['info']=$distritos;   
    }
    else
    {
        $resultado['resultado']='ERROR';
        $resultado['info']='No se encontró información de Servidores';
    }

    //print_r($distritos);
    echo  json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
?>