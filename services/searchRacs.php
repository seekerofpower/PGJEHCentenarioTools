<?php
require_once("server.php");
$servidor=filter_input(INPUT_POST, 'server', FILTER_SANITIZE_STRING);
$racg="%".filter_input(INPUT_POST, 'rac', FILTER_SANITIZE_STRING)."%";
//echo "NUCGGG:".$nucg;
$server=GetServerConection($servidor);

$qRACS=$server->prepare("
SELECT 
RAC.idRac
,RAC.racg
,CASE WHEN (NUC.nucg iS NULL) THEN 'NINGUNO' ELSE NUC.nucg END  as 'nucg'
,NUC.idNuc
,RH.IdRHecho
,D.delitos
,D.altoimpacto
,D.delitosespecificos
,RA.FechaHoraRegistro as FechaReporte
,RA.IdRAtencion
,AR.Nombre as 'agenciaRAC'
,RH.ModuloServicioId as 'idModuloHecho'
,MS.Nombre AS 'ModuloHecho'
,CASE WHEN (RA.u_Nombre iS NULL) THEN 'NINGUNO' ELSE RA.u_Nombre END  as 'RANombre'
,RH.RBreve
,RA.u_Puesto as 'RAPuesto'
FROM RAC
LEFT JOIN CAT_RATENCON RA ON RA.racId=RAC.idRac
LEFT JOIN CAT_RHECHO RH ON RA.IdRAtencion=RH.RAtencionId
LEFT JOIN NUC ON RH.NucId=NUC.idNuc
LEFT JOIN C_MODULOSERVICIO MS ON RH.ModuloServicioId=MS.IdModuloServicio
LEFT JOIN C_AGENCIA AR ON RAC.AgenciaId=AR.IdAgencia

LEFT JOIN 
(
SELECT RDH.RHechoId,STRING_AGG((CASE 
        WHEN (CD.AltoImpacto = 1) THEN 'ALTO'
                                  ELSE 'BAJO' 
    END),';') as 'altoimpacto',STRING_AGG(CD.Nombre,';') as 'delitos',STRING_AGG(RDH.DelitoEspecifico,';') as 'delitosespecificos'
--,   RDH.*  
FROM CAT_RDH RDH INNER JOIN C_DELITO CD ON CD.IdDelito= RDH.DelitoId group by RDH.RHechoId
) as D ON D.RHechoId=RH.IdRHecho
WHERE RAC.racg LIKE :RACG
ORDER BY RAC.racg ASC;
");

$qRACS->bindParam(':RACG', $racg,PDO::PARAM_STR);
$qRACS->execute();
//$qNUCS->debugDumpParams();

$tabla="";                      
//if($qNUCS->rowCount()>0)
 //   {
        $resultado['resultado']='OK';
        
        while($fila=$qRACS->fetch(PDO::FETCH_ASSOC)) 
        {
          $tabla.="<tr><td>".$fila['racg']."</td><td>".$fila['nucg']."</td><td>".$fila['agenciaRAC']."</td><td>".$fila['RANombre']."</td><td>".$fila['RAPuesto']."</td><td>".$fila['FechaReporte']."</td></tr>";
        }
        
        $resultado['resultado']='OK';
        $resultado['info']='Info entregada';
        $resultado['table']=$tabla;
  //  }
 //   else
 //   {
 //       $resultado['resultado']='ERROR';
 //       $resultado['info']='No se encontró información en Servidores';
  //  }

    //print_r($distritos);
    echo  json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
?>