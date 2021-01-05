<?php
class ReportePDF extends TCPDF 
{

//Page header
public function Header() {
    // Logo
    $image_file = 'images/logohidalgo.jpg';
    $logoProcu = 'images/procu_logo.jpg';
    $this->Image($logoProcu, 15, 10, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
    
    
    // Set font
    $this->SetFont('helvetica', 'B', 17);
    
    // Title
    $this->Cell(0, 15, 'Procuraduría General de Justicia del Estado del Hidalgo', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    
    $this->SetFont('helvetica', 'B', 14);
    $this->Ln(7);
    $this->Cell(0, 0, 'Reporte de resgistros por edificio', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    $this->Image($image_file, 250, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
}

// Page footer
public function Footer() {
    // Position at 15 mm from bottom
    $this->SetY(-15);
    // Set font
    $this->SetFont('helvetica', 'I', 8);
    // Page number
    $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
}

//IMPRIMIR LA TABLA CON CAMBIO DE COLORES
public function ColoredTable($header,$data) 
{
    // Colors, line width and bold font
    $this->SetFillColor(255, 255, 255);
    $this->SetTextColor(0);
    $this->SetDrawColor(118, 120, 121);
    $this->SetLineWidth(0.3);
    $this->SetFont('', 'B');
    // ANCHO DE LAS COLUMNAS
    $w = array(5,30,30,15, 15);
    $num_headers = count($header);

    $style="
    <style>
    tbody td
    {
        font-size:62%; 
        vertical-align: middle;      
    }
    </style>
    ";
    $table=$style.'<table border="1"><thead><tr >';
    
#BFBFBF

    for($i = 0; $i < $num_headers; ++$i) 
    {
        $table.='<td width="'.$w[$i].'%" align="center"><b>'.$header[$i]."</b></td>";
    }
    $table.="</tr></thead><tbody>";
    $fill = 0;
    $i=1;
    error_log("cabecera");
    error_log($table);    
    while($row=$data->fetch(PDO::FETCH_ASSOC)) 
    {
        $fila='<tr>';
        if($fill)
            $color='background-color:#BFBFBF;';
        else
            $color='';    
        $fila.='<td style="font-size:64%;vertical-align: middle;'.$color.'" align="center" width="'.$w[0].'%">'.$i.'</td>';
        $fila.='<td style="font-size:64%;vertical-align: middle;'.$color.'" align="center" width="'.$w[1].'%">'.$row["PERSONA"].'</td>';
        $fila.='<td style="font-size:64%;vertical-align: middle;'.$color.'" align="center" width="'.$w[2].'%">'.$row["AREA"].'</td>';
        $fila.='<td style="font-size:64%;vertical-align: middle;'.$color.'" align="center" width="'.$w[3].'%">'.$row["ENTRADA"].'</td>';
        $fila.='<td style="font-size:64%;vertical-align: middle;'.$color.'" align="center" width="'.$w[4].'%">'.$row["SALIDA"].'</td>';
        $i++;
        $fila.="</tr>";
        //error_log($fila);

        $table.=$fila;
        
        $fill=!$fill;
    }
    $table.="</tbody></table>";
    
    $this->writeHTML($table, true, false, true, false, '');
}
}
?>