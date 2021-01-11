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

$fecha="10 de enero del 2021";
$sqlDelitos="SELECT 
N.nucg AS NUC
,D.Nombre as agencia
,RH.FechaReporte
,RDH.DelitoEspecifico
,CD.Nombre as delito
,A.Nombre as area
,A.Clave as clavearea
,(CASE 
        WHEN (CD.AltoImpacto = 1) THEN 'ALTO'
                                  ELSE 'BAJO' 
    END) as Impacto
FROM NUC N
LEFT JOIN CAT_RHECHO RH ON n.idNuc = RH.NucId
LEFT JOIN C_DISTRITO D ON N.DistritoId= D.IdDistrito
LEFT JOIN CAT_RDH RDH ON RDH.RHechoId= RH.IdRHecho
LEFT JOIN C_DELITO CD ON CD.IdDelito= RDH.DelitoId
LEFT JOIN C_AGENCIA A ON N.AgenciaId= A.IdAgencia
WHERE RH.FechaReporte=:FECHA"
;
echo "<table>";
echo "<thead><tr><td>NUC</td><td>Agencia</td><td>Fecha Reporte</td><td>Delito Especifico</td><td>Delito</td><td>Area</td><td>Clave Area</td><td>Nivel Impacto</td></tr></thead>";
echo "<tbody>";

foreach($conexionesDistritos as $distrito => $direccion)
{
    //echo "<tr><td>".$distrito."</td></tr>";

    $server=GetServerConection($direccion);
    


    if($server!= false)
    {
        $qReporte=$server->prepare($sqlDelitos);
        $qReporte->bindParam(':FECHA', $fecha, PDO::PARAM_STR);
        $qReporte->execute();
        
            while($grid=$qReporte->fetch(PDO::FETCH_ASSOC))
            {
                print utf8_decode( "<tr><td>".$grid['NUC']."</td><td>".$grid['agencia']."</td><td>".$grid['FechaReporte']."</td><td>".$grid['DelitoEspecifico']."</td><td>".$grid['delito']."</td><td>".$grid['area']."</td><td>".$grid['aclavearearea']."</td><td>".$grid['Impacto']."</td></tr>");
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