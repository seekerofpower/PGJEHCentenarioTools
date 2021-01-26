<?php
require_once("server.php");



$distrito=filter_input(INPUT_POST, 'distrito', FILTER_SANITIZE_STRING);
$nuc=filter_input(INPUT_POST, 'nuc', FILTER_SANITIZE_STRING);
$rac=filter_input(INPUT_POST, 'rac', FILTER_SANITIZE_STRING);
$hecho=filter_input(INPUT_POST, 'hecho', FILTER_SANITIZE_STRING);
$atencion=filter_input(INPUT_POST, 'atencion', FILTER_SANITIZE_STRING);
$completo=filter_input(INPUT_POST, 'completo', FILTER_SANITIZE_STRING);
//$="%".filter_input(INPUT_POST, 'nuc', FILTER_SANITIZE_STRING)."%";

$server=GetServerConection($distrito);


//CONSULTAS PRINCIPALES  PARA EL BORRADO
$sqlBorrarNUC='delete FROM NUC WHERE idNuc=:NUC';
$sqlBorrarDiligencias="delete from CAT_RDILIGENCIAS WHERE rHechoId=:DILIGENCIA";
$sqlBorrarHecho='delete from CAT_RHECHO WHERE IdRHecho=:HECHO';
$sqlBorrarAtencion='delete from CAT_RATENCON where racId=:ATENCION';
$sqlBorrarRAC='delete FROM RAC WHERE idRac=:RAC';
$sqlBorrarTurno='delete FROM CAT_TURNO WHERE RAtencionId=:TURNO';
//if($completo=="1")

    $qBorrarDiligencia=$server->prepare($sqlBorrarDiligencias);
    $qBorrarDiligencia->bindParam(':DILIGENCIA', $hecho, PDO::PARAM_STR);

    if($qBorrarDiligencia->execute())
    {
        $qBorrarHecho=$server->prepare($sqlBorrarHecho);
        $qBorrarHecho->bindParam(':HECHO', $hecho, PDO::PARAM_STR);
        if($qBorrarHecho->execute())
        {
            $qBorrarNuc=$server->prepare($sqlBorrarNUC);
            $qBorrarNuc->bindParam(':NUC', $nuc, PDO::PARAM_STR);
            $qBorrarNuc->execute();
            if($qBorrarNuc->rowCount()>0)
            {
                if($completo=="1")
                {
                    $qBorrarTurno=$server->prepare($sqlBorrarTurno);
                    $qBorrarTurno->bindParam(':TURNO', $atencion, PDO::PARAM_STR);
                    if($qBorrarTurno->execute())
                    {
                        $qBorrarAtencion=$server->prepare($sqlBorrarAtencion);
                        $qBorrarAtencion->bindParam(':ATENCION', $rac, PDO::PARAM_STR);
                        if($qBorrarAtencion->execute())
                        {
                            $qBorrarRac=$server->prepare($sqlBorrarRAC);
                            $qBorrarRac->bindParam(':RAC', $rac, PDO::PARAM_STR);
                            $qBorrarRac->execute();
                            if($qBorrarRac->rowCount()>0)
                            { 
                                $resultado['resultado']="OK";   
                            } 
                            else
                            {
                                $resultado['resultado']="ERROR";
                                $resultado['info']='ERORR al borrar el rac relacionado';    
                            }   
                        }
                            
                    }
                }
                else
                {
                    $resultado['resultado']="OK";
                }
                        
                
            }
            else
            {
                $resultado['resultado']="ERROR";
                $resultado['info']=$server->errorInfo();
            } 
        }
        
    }

    
 

echo  json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK)

?>