<?php
session_start();
if (isset($_SESSION['user'])) 
{
  require_once("server.php");
  require_once('mysql.php');
  
  require_once('permisosUsuario.php');
  $permisosUsuario=obtenerPermisosUsuarioModulo(1);

  $db=getMySQLConection();

  // ID DEL USUARIO
  //$_SESSION['user']


  $sqlPersmisos="SELECT p.descripcion FROM permisosusuario pu 
  INNER JOIN permisos p ON pu.idPermiso=p.idPermiso
  WHERE idUsuario=:USUARIO
  AND pu.activo=1
  AND p.idModulo=1";
  $qPermisos=$db->prepare($sqlPersmisos);
  $qPermisos->bindParam(':USUARIO', $_SESSION['user'],PDO::PARAM_INT);
  //error_log


  $servidor=filter_input(INPUT_POST, 'server', FILTER_SANITIZE_STRING);
  $nucg="%".filter_input(INPUT_POST, 'nuc', FILTER_SANITIZE_STRING)."%";
  //echo "NUCGGG:".$nucg;
  $server=GetServerConection($servidor);

  $qNUCS=$server->prepare("
  SELECT 
  NUC.nucg
  ,NUC.idNuc
  ,RH.IdRHecho
  ,D.delitos
  ,D.altoimpacto
  ,D.delitosespecificos
  ,RA.FechaHoraRegistro as FechaReporte
  ,RA.IdRAtencion
  ,RAC.idRac
  ,RAC.racg
  ,RH.RBreve
  ,RH.ModuloServicioId as 'idModuloHecho'
  ,DA.Nombre as 'distritoAgencia'
  ,A.Nombre as 'Agencia'
  ,MS.Nombre AS 'ModuloHecho'
  ,RA.u_Nombre as 'RANombre'
  ,RA.u_Puesto as 'RAPuesto'
  FROM NUC
  LEFT JOIN CAT_RHECHO RH ON NUC.idNuc=RH.NucId
  LEFT JOIN CAT_RATENCON RA ON RH.RAtencionId=RA.IdRAtencion
  LEFT JOIN RAC ON RA.racId=RAC.idRac
  LEFT JOIN C_MODULOSERVICIO MS ON RH.ModuloServicioId=MS.IdModuloServicio
  LEFT JOIN C_AGENCIA A ON MS.AgenciaId=A.IdAgencia
  LEFT JOIN C_DSP DSP ON DSP.IdDSP=A.DSPId
  LEFT JOIN C_DISTRITO DA ON DA.IdDistrito=DSP.DistritoId
  LEFT JOIN 
  (
  SELECT RDH.RHechoId,STRING_AGG((CASE 
          WHEN (CD.AltoImpacto = 1) THEN 'ALTO'
                                    ELSE 'BAJO' 
      END),';') as 'altoimpacto',STRING_AGG(CD.Nombre,';') as 'delitos',STRING_AGG(RDH.DelitoEspecifico,';') as 'delitosespecificos'
  --,   RDH.*  
  FROM CAT_RDH RDH INNER JOIN C_DELITO CD ON CD.IdDelito= RDH.DelitoId group by RDH.RHechoId
  ) as D ON D.RHechoId=RH.IdRHecho
  WHERE nucg LIKE :NUCG
  ORDER BY NUC.nucg ASC;
  ");

  $qNUCS->bindParam(':NUCG', $nucg,PDO::PARAM_STR);
  $qNUCS->execute();
  //$qNUCS->debugDumpParams();

  $tabla="";                      
  //if($qNUCS->rowCount()>0)
  //   {
          $resultado['resultado']='OK';
          
          while($fila=$qNUCS->fetch(PDO::FETCH_ASSOC)) 
          {
            $tabla.="<tr><td>".$fila['nucg']."</td><td>".$fila['racg']."</td><td>".$fila['FechaReporte']."</td><td>".$fila['RANombre']."</td><td>".$fila['RAPuesto']."</td><td>".$fila['distritoAgencia']."</td><td>".$fila['Agencia']."</td><td>".$fila['ModuloHecho']."</td>";
            if (in_array("BorrarNUC", $permisosUsuario)) 
            {
              $tabla.='<td><button type="button" class="btn mr-2 mb-2 btn-primary deleteNuc" atencion="'.$fila['IdRAtencion'].'" rac="'.$fila['idRac'].'" nuc="'.$fila['idNuc'].'" hecho="'.$fila['IdRHecho'].'" data-toggle="modal" data-target=".bd-example-modal-lg" >Borrar</button></td>';
            }
            
            
            
            $tabla.="</tr>";
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
}
else
{
  $resultado['resultado']='ERROR';
  $resultado['info']="ERROR de inicio de sesion";
}      
echo  json_encode($resultado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
?>