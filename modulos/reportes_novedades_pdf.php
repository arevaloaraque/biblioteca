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
    $this->Text(104,10,utf8_decode('REPORTE GENERAL DE NOVEDADES'),0,1,'C');
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
$url_print = 'modulos/reportes_novedades_pdf.php?from_date='.$from_date.'&to_date='.$to_date.'&usuario='.$usuario.'&sts-entregado='.((isset($_GET['sts-libro']))?$_GET['sts-libro']:'').'&sts-tesis='.((isset($_GET['sts-tesis']))?$_GET['sts-tesis']:'').'&sts-materiales='.((isset($_GET['sts-materiales']))?$_GET['sts-materiales']:'');
$wheree = ($from_date != '' && $to_date != '')?' WHERE fecha_novedad>=\''.$from_date.'\' AND fecha_novedad<=\''.$to_date.'\'':'';
$id_libros = array();
$id_tesis = array();
$id_materiales = array();
$mostrar = array();
if (isset($_GET['sts-libro']) && $_GET['sts-libro'] != '') { array_push($mostrar, 'libros'); }
if (isset($_GET['sts-tesis']) && $_GET['sts-tesis'] != '') { array_push($mostrar, 'tesis'); }
if (isset($_GET['sts-materiales']) && $_GET['sts-materiales'] != '') { array_push($mostrar, 'materiales'); }
if (!isset($_GET['sts-libro']) && !isset($_GET['sts-tesis']) && !isset($_GET['sts-materiales'])) { $mostrar = array('libros','tesis','materiales'); }
if ($usuario != ''){
    $prestamos = $consultasbd->select($tabla='tbl_prestamo_libro',$campos='id_prestamo',$where='WHERE id_usuario=\''.$usuario.'\'');
    while ($prestamo = $consultasbd->fetch_array($prestamos)) {
        $id_libros[] = $prestamo['id_prestamo'];
    }
    $libros =(count($id_libros))?$consultasbd->select($tabla='tbl_novedad_libro',$campos='*',$where=(strlen($wheree)>0)?$wheree.' AND id_prestamo IN ('.implode(",",$id_libros).')':' WHERE  id_prestamo IN ('.implode(",",$id_libros).')'):false;
    $prestamos_tesis = $consultasbd->select($tabla='tbl_prestamo_tesis',$campos='id_prestamo_tesis',$where='WHERE id_usuario=\''.$usuario.'\'');
    while ($prestamo = $consultasbd->fetch_array($prestamos_tesis)) {
        $id_tesis[] = $prestamo['id_prestamo_tesis'];
    }
    $tesis =(count($id_tesis)>0)?$consultasbd->select($tabla='tbl_novedad_tesis',$campos='*',$where=(strlen($wheree)>0)?$wheree.' AND id_prestamo_tesis IN ('.implode(",",$id_tesis).')':' WHERE  id_prestamo_tesis IN ('.implode(",",$id_tesis).')'):false;
    $prestamos_material = $consultasbd->select($tabla='tbl_prestamo_material',$campos='id_prestamo_material',$where='WHERE id_usuario=\''.$usuario.'\'');
    while ($prestamo = $consultasbd->fetch_array($prestamos_material)) {
        $id_materiales[] = $prestamo['id_prestamo_material'];
    }
    $material =(count($id_materiales)>0)?$consultasbd->select($tabla='tbl_novedad_material',$campos='*',$where=(strlen($wheree)>0)?$wheree.' AND id_prestamo_material IN ('.implode(",",$id_materiales).')':' WHERE  id_prestamo_material IN ('.implode(",",$id_materiales).')'):false;
} else {
    $libros = $consultasbd->select($tabla='tbl_novedad_libro',$campos='*',$wheree);
    $tesis = $consultasbd->select($tabla='tbl_novedad_tesis',$campos='*',$wheree);
    $material = $consultasbd->select($tabla='tbl_novedad_material',$campos='*',$wheree);
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
$pdf->cell(237,8,'Leyenda de colores',1,1,'C',true);
$pdf->SetFillColor(223,240,216);
$pdf->cell(79,8,'Libros',1,0,'C',true);
$pdf->SetFillColor(242,222,222);
$pdf->cell(79,8,'Tesis',1,0,'C',true);
$pdf->SetFillColor(252,248,227);
$pdf->cell(79,8,'Materiales',1,0,'C',true);
$pdf->Ln(12);
/**************************************/
$pdf->SetFont('Arial','B',9);
$count_libros = 0;
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(223,240,216);
$pdf->Cell(237,8,'LISTA DE LIBROS',1,1,'C',true);
$pdf->cell(28,8,'Cod. Novedad',1,0,'C',true);
$pdf->cell(47,8,utf8_decode('Descripción'),1,0,'C',true);
$pdf->cell(36,8,'Id Prestamo',1,0,'C',true);
$pdf->cell(49,8,'Fecha de Novedad',1,0,'C',true);
$pdf->cell(47,8,utf8_decode('Descripción Final'),1,0,'C',true);
$pdf->cell(30,8,'Status',1,1,'C',true);
if ($consultasbd->num_rows($libros)) {
    $pdf->SetFont('Arial','',9,true);
    $pdf->SetWidths(array(28,47,36,49,47,30));
    $pdf->SetAligns(array('C','C','C','C','C','C'));
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0,0,0);   
    while ($libro = $consultasbd->fetch_array($libros)) {
        if (in_array('libros',$mostrar) == 1){
            $pdf->Row(array($libro['id_novedad'],utf8_decode(strtoupper($libro['descripcion'])),utf8_decode(strtoupper($libro['id_prestamo'])),date('d-m-Y',strtotime($libro['fecha_novedad'])),strtoupper($libro['descripcion_final']),($libro['status'] == 'f')?'FINALIZADO':'PENDIENTE'));
            $count_libros++;
        }
    }
}
if($count_libros==0){$pdf->SetTextColor(0,0,0);$pdf->SetFillColor(221,221,221);$pdf->Cell(237,8,'NO EXISTEN RESULTADOS PARA EL FILTRO SELECCIONADO',1,1,'C',true);};

$pdf->Ln(8);
$pdf->SetFont('Arial','B',9);
$count_tesis = 0;
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(242,222,222);
$pdf->Cell(237,8,'LISTA DE TESIS',1,1,'C',true);
$pdf->cell(28,8,'Cod. Novedad',1,0,'C',true);
$pdf->cell(47,8,utf8_decode('Descripción'),1,0,'C',true);
$pdf->cell(36,8,'Id Prestamo',1,0,'C',true);
$pdf->cell(49,8,'Fecha de Novedad',1,0,'C',true);
$pdf->cell(47,8,utf8_decode('Descripción Final'),1,0,'C',true);
$pdf->cell(30,8,'Status',1,1,'C',true);
if ($consultasbd->num_rows($tesis)) {
    $pdf->SetFont('Arial','',9,true);
    $pdf->SetWidths(array(28,47,36,49,47,30));
    $pdf->SetAligns(array('C','C','C','C','C','C'));
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0,0,0);
    while ($tesi = $consultasbd->fetch_array($tesis)) {
        if (in_array('tesis',$mostrar) == 1){
            $pdf->Row(array($tesi['id_novedad_tesis'],utf8_decode(strtoupper($tesi['descripcion'])),utf8_decode(strtoupper($tesi['id_prestamo_tesis'])),date('d-m-Y',strtotime($tesi['fecha_novedad'])),strtoupper($tesi['descripcion_final']),($tesi['status'] == 'f')?'FINALIZADO':'PENDIENTE'));
            $count_tesis++;
        }
    }
}
if($count_tesis==0){$pdf->SetTextColor(0,0,0);$pdf->SetFillColor(221,221,221);$pdf->Cell(237,8,'NO EXISTEN RESULTADOS PARA EL FILTRO SELECCIONADO',1,1,'C',true);};
$pdf->Ln(8);
$pdf->SetFont('Arial','B',9);
$count_mat=0;
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(252,248,227);
$pdf->Cell(237,8,'LISTA DE MATERIALES',1,1,'C',true);
$pdf->cell(28,8,'Cod. Novedad',1,0,'C',true);
$pdf->cell(47,8,utf8_decode('Descripción'),1,0,'C',true);
$pdf->cell(36,8,'Id Prestamo',1,0,'C',true);
$pdf->cell(49,8,'Fecha de Novedad',1,0,'C',true);
$pdf->cell(47,8,utf8_decode('Descripción Final'),1,0,'C',true);
$pdf->cell(30,8,'Status',1,1,'C',true);
if ($consultasbd->num_rows($material)) {
    $pdf->SetFont('Arial','',9,true);
    $pdf->SetWidths(array(28,47,36,49,47,30));
    $pdf->SetAligns(array('C','C','C','C','C','C'));
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0,0,0);
    while ($mat = $consultasbd->fetch_array($material)) {
        if (in_array('materiales',$mostrar) == 1){
            $pdf->Row(array($mat['id_novedad_material'],utf8_decode(strtoupper($mat['descripcion'])),utf8_decode(strtoupper($mat['id_prestamo_material'])),date('d-m-Y',strtotime($mat['fecha_novedad'])),strtoupper($tesi['descripcion_final']),($tesi['status'] == 'f')?'FINALIZADO':'PENDIENTE'));
            $count_mat++;
        }
    }
}
if($count_mat==0){$pdf->SetTextColor(0,0,0);$pdf->SetFillColor(221,221,221);$pdf->Cell(237,8,'NO EXISTEN RESULTADOS PARA EL FILTRO SELECCIONADO',1,1,'C',true);};
/**************************************/
// muestra la pagina
$pdf->Output( utf8_decode('Reporte_de_Prestamos-BibloWeb-v1.0'.'.pdf'),'I');
/*****************************--- FIN ---******************************************************/
?>