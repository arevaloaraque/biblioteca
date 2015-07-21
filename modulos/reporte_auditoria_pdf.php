<?php
include_once('modelo.php');
require_once("../librerias/fpdf/fpdf.php");
// Clase PDF-extends-FPDF
class PDF extends FPDF
{
var $widths;
var $aligns;
// funcion SetWidths()
function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}
// funcion SetAligns()
function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}
// funcion Row()
function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=5*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
//
        $this->Rect($x,$y,$w,$h);
//
        $this->MultiCell($w,5,$data[$i],'LTR',$a,'true');
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}
// funcion CheckPageBreak()
function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}
// funcion NbLines()
function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}
// funcion Header()
function Header()
{
    $this->Ln(3);
    $this->SetFont('Arial','B',12);
    $this->Text(104,10,utf8_decode('REGISTRO DE AUDITORIA'),0,1,'C');
    $this->Ln(3);
}
// funcion Footer()
	function Footer()
	{
	    $this->SetY(-15);
	    $this->SetFont('Arial','',7);
	    $this->Cell(0,1,'Derechos Reservados - BibloWeb-v1.0',0,1,'R');
	    $this->Cell(0,10,utf8_decode('Página ').$this->PageNo(),0,0,'C');
	}
}   // fin de la Clase PDF-extends-FPDF
$from_date = (isset($_GET['from_date']))?$_GET['from_date']:'';
$to_date = (isset($_GET['to_date']))?$_GET['to_date']:'';
$usuario = (isset($_GET['usuario']))?$_GET['usuario']:'';
$url_print = 'modulos/reporte_auditoria_pdf.php?from_date='.$from_date.'&to_date='.$to_date.'&usuario='.$usuario;
$wheree = ($from_date != '' && $to_date != '')?' WHERE fecha_auditoria>=\''.$from_date.'\' AND fecha_auditoria<=\''.$to_date.'\'':'';
if ($usuario != ''){
    $auditoria = $consultasbd->select($tabla='tbl_auditoria',$campos='*',$where=(strlen($wheree)>0)?$wheree.' AND id_operador=\''.$usuario.'\'':'WHERE id_operador=\''.$usuario.'\'');
} else {
    $auditoria = $consultasbd->select($tabla='tbl_auditoria',$campos='*',$where=$wheree);
}
if ($usuario != '') {
$usuario = $consultasbd->select($tabla='tbl_operador',$campos='*',$where=' WHERE id_operador=\''.$usuario.'\'');
$datos_usuario = $consultasbd->fetch_array($usuario);
}
/************ crea el objeto FPDF***********/
$pdf=new PDF('L','mm','Letter');
$pdf->Open();
$pdf->AddPage();
$pdf->SetMargins(20,20,20);
$pdf->Ln(4);
/**************************************/
$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,5,utf8_decode('Usuario: ').(isset($datos_usuario) && (count($datos_usuario)>0)?trim($datos_usuario['nombre']).' '.trim($datos_usuario['apellido']).'. Cedula: '.number_format($datos_usuario['cedula'],0,".","."):'Todos'),0,1);
$pdf->Cell(0,5,((isset($from_date) && (isset($to_date))) && ($from_date != '' && $to_date != ''))?'Rango Fecha: '.date('d-m-Y',strtotime($from_date)).' - '.date('d-m-Y',strtotime($to_date)):'',0,1);
$pdf->Ln(8);
/**************************************/
$pdf->SetFillColor(255,255,255);
$pdf->Ln(8);
/**************************************/
$pdf->SetFont('Arial','B',9);
$count = 0;
$pdf->SetTextColor(0,0,0);
$pdf->Cell(237,8,'REGISTRO ACTUAL DE AUTORIA',1,1,'C',true);
$pdf->cell(28,8,'Cod. Auditoria',1,0,'C',true);
$pdf->cell(73,8,'Operador',1,0,'C',true);
$pdf->cell(80,8,utf8_decode('Descripción'),1,0,'C',true);
$pdf->cell(28,8,'Hora',1,0,'C',true);
$pdf->cell(28,8,'Fecha Auditoria',1,1,'C',true);
if ($consultasbd->num_rows($auditoria)){
    $pdf->SetFont('Arial','',9,true);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetWidths(array(28,73,80,28,28));
    $pdf->SetAligns(array('C','C','C','C','C'));
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0,0,0);    
    while ($det_auditoria = $consultasbd->fetch_array($auditoria)) {
        // datos del libro
        $operador = $consultasbd->select($tabla='tbl_operador',$campos='*',$where='WHERE id_operador=\''.$det_auditoria['id_operador'].'\'');
        $datos_ope = $consultasbd->fetch_array($operador);
        $pdf->Row(array($det_auditoria['id_auditoria'],strtoupper(trim(utf8_decode($datos_ope['nombre'])).' '.trim(utf8_decode($datos_ope['apellido']))),utf8_decode($det_auditoria['descripcion']),$det_auditoria['hora'],($det_auditoria['fecha_auditoria'] != '')?date('d-m-Y',strtotime($det_auditoria['fecha_auditoria'])):''));
        $count++;
    }
}
if($count==0){$pdf->SetTextColor(0,0,0);$pdf->SetFillColor(221,221,221);$pdf->Cell(237,8,'NO EXISTEN RESULTADOS PARA EL FILTRO SELECCIONADO',1,1,'C',true);};
/**************************************/
// muestra la pagina
$pdf->Output( utf8_decode('Reporte_de_Prestamos-BibloWeb-v1.0'.'.pdf'),'I');
/*****************************--- FIN ---******************************************************/
?>