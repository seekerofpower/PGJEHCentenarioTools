<?php
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header('Content-Disposition: attachment; filename=infoReporteDiario.xls');
require_once("server.php");
// ESTP CON EL TIEMPO CAMBAIRLO A BD
$conexionesDistritos = array
(
    'PACHUCA DE SOTO'=>'192.168.14.180',
    "TULANCINGO DE BRAVO"=>"172.16.196.11",
    "TULA DE ALLENDE"=>"172.16.126.11",
    "APAN"=>	"172.16.199.11",
    "TIZAYUCA"=>	"172.16.120.11",
    "ACTOPAN"=>  "172.16.54.11",
    "ATOTONILCO EL GRANDE"=>  "172.16.62.11",
    "ZACUALTIPAN"=>	"172.16.197.11",
    "MOLANGO"=>  "172.16.198.11",
    "ZIMAPAN"=>  "172.16.195.11",
    "HUEJUTLA DE REYES"=>  "172.16.71.11",
    "IXMIQUILPAN"=>  "172.16.200.11",
    "MIXQUIAHUALA"=>  "172.16.91.11",
    "HUICHAPAN"=>  "172.16.76.11",
    "TENANGO DE DORIA"=>  "172.16.192.11",
    "JACALA"=>  "172.16.193.11",
    "METZTITLAN"=>  "172.16.194.11"
);
$fechaInicio=filter_input(INPUT_POST, 'fechainicio', FILTER_SANITIZE_STRING)." 00:00:00";
$fechaFinal=filter_input(INPUT_POST, 'fechafin', FILTER_SANITIZE_STRING)." 23:59:59";;
$sqlDelitos="SELECT 
N.nucg AS NUC
,D.Nombre as agencia
,RA.FechaHoraRegistro as FechaReporte
,RDH.DelitoEspecifico
,CD.Nombre as delito
,A.Nombre as area
,A.Clave as clavearea
,RA.u_Nombre as 'MP'
,RA.u_Puesto
,(CASE 
        WHEN (CD.AltoImpacto = 1) THEN 'ALTO'
                                  ELSE 'BAJO' 
    END) as Impacto
--,* 
,UPPER(V.victimas) as victimas
--,CR.ClasificacionPersona
,RH.FechaHoraSuceso
,CONCAT(DD.Calle,' ',DD.NoInt,' ', [DD].[NoExt],' ',DD.Localidad ) as 'LugarDelito'
FROM NUC N
LEFT JOIN CAT_RHECHO RH ON n.idNuc = RH.NucId
LEFT JOIN C_DISTRITO D ON N.DistritoId= D.IdDistrito
LEFT JOIN CAT_RDH RDH ON RDH.RHechoId= RH.IdRHecho
LEFT JOIN CAT_RATENCON RA ON RH.RAtencionId=RA.IdRAtencion
LEFT JOIN C_DELITO CD ON CD.IdDelito= RDH.DelitoId
LEFT JOIN C_AGENCIA A ON N.AgenciaId= A.IdAgencia
LEFT JOIN (SELECT RAtencionId,STRING_AGG(CONCAT(Nombre,' ',ApellidoPaterno,' ',ApellidoMaterno),';') victimas FROM CAT_RAP
INNER JOIN CAT_PERSONA ON PersonaId=IdPersona WHERE ClasificacionPersona LIKE 'Victima%' group by RAtencionId) AS V ON V.RAtencionId=RA.IdRAtencion
LEFT JOIN CAT_DIRECCION_DELITO DD ON DD.RHechoId=RH.IdRHecho
WHERE RA.FechaHoraRegistro BETWEEN :FECHAINICIO AND  :FECHAFIN
ORDER BY N.nucg ASC";



echo "<table>";
echo "<thead><tr><td>NUC</td><td>Agencia</td><td>Fecha Reporte</td><td>Delito Especifico</td><td>Delito</td><td>Area</td><td>Clave Area</td><td>MP</td><td>Puesto</td><td>Nivel Impacto</td><td>Victimas</td><td>Fecha Hora Suceso</td><td>Lugar Delito</td></tr></thead>";
echo "<tbody>";

foreach($conexionesDistritos as $distrito => $direccion)
{
    //echo "<tr><td>".$distrito."</td></tr>";

    $server=GetServerConection($direccion);
    


    if($server!= false)
    {
        $qReporte=$server->prepare($sqlDelitos);
        //$qReporte->bindParam(':FECHA', $fecha, PDO::PARAM_STR);
        $qReporte->bindParam(':FECHAINICIO',$fechaInicio, PDO::PARAM_STR);
        $qReporte->bindParam(':FECHAFIN', $fechaFinal, PDO::PARAM_STR);
        $qReporte->execute();
        
            while($grid=$qReporte->fetch(PDO::FETCH_ASSOC))
            {
                print utf8_decode( "<tr><td>".$grid['NUC']."</td><td>".$grid['agencia']."</td><td>".$grid['FechaReporte']."</td><td>".$grid['DelitoEspecifico']."</td><td>".$grid['delito']."</td><td>".$grid['area']."</td><td>".$grid['clavearea']."</td><td>".$grid['MP']."</td><td>".$grid['u_Puesto']."</td><td>".$grid['Impacto']."</td><td>".$grid['victimas']."</td><td>".$grid['FechaHoraSuceso']."</td><td>".$grid['LugarDelito']."</td></tr>");
            }
        
    }
    else
    {
		echo "FALSO";
    }
  



}
echo "</tbody>";
echo "</table>";

?>