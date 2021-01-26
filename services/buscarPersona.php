<?php
//header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
//header('Content-Disposition: attachment; filename=infoReporteDiario.xls');
require_once("server.php");
// ESTP CON EL TIEMPO CAMBAIRLO A BD
$conexionesDistritos = array
(
    'PACHUCA DE SOTO'=>'192.168.14.180',
    "TULANCINGO DE BRAVO"=>"172.16.196.11",
    //"TULA DE ALLENDE"=>"172.16.126.11",
    "APAN"=>	"172.16.199.11",
    "TIZAYUCA"=>	"172.16.120.11",
    "ACTOPAN"=>  "172.16.54.11",
    "ATOTONILCO EL GRANDE"=>  "172.16.62.11",
    "ZACUALTIPAN"=>	"172.16.197.11",
    "MOLANGO"=>  "172.16.198.11",
    //"ZIMAPAN"=>  "172.16.195.11",
    "HUEJUTLA DE REYES"=>  "172.16.71.11",
    "IXMIQUILPAN"=>  "172.16.200.11",
    //"MIXQUIAHUALA"=>  "172.16.91.11",
    //"HUICHAPAN"=>  "172.16.76.11",
    //"TENANGO DE DORIA"=>  "172.16.192.11",
    "JACALA"=>  "172.16.193.11",
    "METZTITLAN"=>  "172.16.194.11"
);
//$fechaInicio=filter_input(INPUT_POST, 'fechainicio', FILTER_SANITIZE_STRING)." 00:00:00";
//$fechaFinal=filter_input(INPUT_POST, 'fechafin', FILTER_SANITIZE_STRING)." 23:59:59";
$sqlDelitos="SELECT 
* FROM CAT_PERSONA

WHERE Nombre like 'Carlos%'
AND ApellidoPaterno='Martinez'
AND ApellidoMaterno='Negrete'
;";



echo "<table>";
echo "<thead><tr><td>Nombre</td><td>Distrito</td></tr></thead>";
echo "<tbody>";

foreach($conexionesDistritos as $distrito => $direccion)
{
    //echo "<tr><td>".$distrito."</td></tr>";

    $server=GetServerConection($direccion);
    


    if($server!= false)
    {
        $qReporte=$server->prepare($sqlDelitos);
        //$qReporte->bindParam(':FECHA', $fecha, PDO::PARAM_STR);
        //$qReporte->bindParam(':FECHAINICIO',$fechaInicio, PDO::PARAM_STR);
        //$qReporte->bindParam(':FECHAFIN', $fechaFinal, PDO::PARAM_STR);
        $qReporte->execute();
        
            while($grid=$qReporte->fetch(PDO::FETCH_ASSOC))
            {
                print utf8_decode( "<tr><td>".$grid['Nombre']."</td><td>".$distrito."</td></tr>");
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