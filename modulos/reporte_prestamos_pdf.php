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
    $this->Text(104,10,utf8_decode('LISTADO GENERAL DE PRESTAMOS'),0,1,'C');
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
$from_date = (isset($_GET['from_date']) && $_GET['from_date'] != '')?$_GET['from_date']:'';
$to_date = (isset($_GET['to_date']) && $_GET['to_date'] != '')?$_GET['to_date']:'';
$usuario = (isset($_GET['usuario']) && $_GET['usuario'] !='')?$_GET['usuario']:'';
$url_print = 'modulos/reporte_prestamos_pdf.php?from_date='.$from_date.'&to_date='.$to_date.'&usuario='.$usuario;
$where_user = ($usuario == '')?'':'WHERE id_usuario=\''.$usuario.'\'';
$and_user = ($usuario == '')?'':' AND id_usuario=\''.$usuario.'\'';
$where = ($from_date != '' && $to_date != '')?' WHERE fecha_prestamo>=\''.$from_date.'\' AND fecha_prestamo<=\''.$to_date.'\'':'';
$where.= (strlen($where) > 0)?$and_user:$where_user;
$libros = $consultasbd->select($tabla='tbl_prestamo_libro',$campos='*',$where);
$tesis = $consultasbd->select($tabla='tbl_prestamo_tesis',$campos='*',$where);
$material = $consultasbd->select($tabla='tbl_prestamo_material',$campos='*',$where);
// datos de usuario
if ($usuario != '') {
$usuario = $consultasbd->select($tabla='tbl_usuario',$campos='*',$where=' WHERE id_usuario=\''.$usuario.'\'');
$datos_usuario = $consultasbd->fetch_array($usuario);
}
// datos para filtro
$filtro_status = array();
if (isset($_GET['sts-entregado']) && $_GET['sts-entregado'] != '') { array_push($filtro_status, 'entregado'); }
if (isset($_GET['sts-vencido']) && $_GET['sts-vencido'] != '') { array_push($filtro_status, 'vencido'); }
if (isset($_GET['sts-cerca-vencer']) && $_GET['sts-cerca-vencer'] != '') { array_push($filtro_status, 'cerca-vencer'); }
if (isset($_GET['sts-activo']) && $_GET['sts-activo'] != '') { array_push($filtro_status, 'activo'); }

if (!isset($_GET['sts-entregado']) && !isset($_GET['sts-vencido']) && !isset($_GET['sts-cerca-vencer']) && !isset($_GET['sts-activo'])) { $filtro_status = array('entregado','vencido','cerca-vencer','activo'); } else
if ($_GET['sts-entregado'] == '' && $_GET['sts-vencido'] == '' && $_GET['sts-cerca-vencer'] == '' && $_GET['sts-activo'] == '') { $filtro_status = array('entregado','vencido','cerca-vencer','activo'); }
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
$pdf->cell(59.25,8,'Entregado',1,0,'C',true);
$pdf->SetFillColor(242,222,222);
$pdf->cell(59.25,8,'Vencido',1,0,'C',true);
$pdf->SetFillColor(252,248,227);
$pdf->cell(59.25,8,'Cerca a vencer',1,0,'C',true);
$pdf->SetFillColor(221,221,221);
$pdf->cell(59.25,8,'Activo',1,1,'C',true);
$pdf->Ln(8);
/**************************************/
$pdf->SetFont('Arial','B',9);
$count_libros = 0;
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(221,221,221);
$pdf->Cell(237,8,'LISTA DE LIBROS',1,1,'C',true);
$pdf->cell(28,8,'Cod. Prestamo',1,0,'C',true);
$pdf->cell(28,8,'Autor Libro',1,0,'C',true);
$pdf->cell(36,8,'Editorial',1,0,'C',true);
$pdf->cell(48,8,utf8_decode('Descripción'),1,0,'C',true);
$pdf->cell(31,8,'Fecha Prestamo',1,0,'C',true);
$pdf->cell(36,8,utf8_decode('Fecha Devolución'),1,0,'C',true);
$pdf->cell(30,8,'Status',1,1,'C',true);
if ($consultasbd->num_rows($libros)) {
    $pdf->SetFont('Arial','',9,true);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetWidths(array(28,28,36,48,31,36,30));
    $pdf->SetAligns(array('C','C','C','C','C','C','C'));
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0,0,0);    
    while ($libro = $consultasbd->fetch_array($libros)) {
        // datos del libro
        $datos_libro = $consultasbd->select($tabla='tbl_libros',$campos='*',$where='WHERE id_libro=\''.$libro['id_libro'].'\'');
        $datos_libro = $consultasbd->fetch_array($datos_libro);
        // datos de autor
        $res_autor = $consultasbd->select($tabla='tbl_autor',$campos='*',$where = ((!empty($datos_libro['id_autor']))?'WHERE id_autor=\''.$datos_libro['id_autor'].'\'':''));
        $fetch_autor = $consultasbd->fetch_array($res_autor);
        $autor = $fetch_autor['nombre'].' '.$fetch_autor['apellido'];
        // datos de editorial
        $res_editorial = $consultasbd->select($tabla='tbl_editorial',$campos='*',$where = ((!empty($datos_libro['id_editorial']))?'WHERE id_editorial=\''.$datos_libro['id_editorial'].'\'':''));
        $fetch_editorial = $consultasbd->fetch_array($res_editorial);
        $editorial = $fetch_editorial['nombre'].' '.$fetch_editorial['ciudad'];
        // datos de materia
        $res_materia = $consultasbd->select($tabla='tbl_materia',$campos='*',$where = ((!empty($datos_libro['id_materia']))?'WHERE id_materia=\''.$datos_libro['id_materia'].'\'':''));
        $fetch_materia = $consultasbd->fetch_array($res_materia);
        $materia = $fetch_materia['nombre_materia'];

        $datos_libro['id_autor'] = $autor;
        $datos_libro['id_editorial'] = $editorial;
        $datos_libro['id_materia'] = $materia;
        $datos_libro['fecha_publicacion'] = date('d-m-Y',strtotime($datos_libro['fecha_publicacion']));
        // total dias prestamo
        $segundos=strtotime($libro['fecha_devolucion']) - strtotime($libro['fecha_prestamo']);
        $diferencia_dias=intval($segundos/60/60/24);
        // total dias prestamo
        $segundos=strtotime($libro['fecha_devolucion']) - strtotime($libro['fecha_prestamo']);
        $diferencia_dias=intval($segundos/60/60/24);
        $a='';$b='';$c='';
        $status = '';
        if (date('Y-m-d') > $libro['fecha_devolucion']) {
            $a = 242; $b = 222; $c= 222; $status = 'vencido';
        } else {
            if ($diferencia_dias > 0 && $diferencia_dias < 2) { $a = 252; $b = 248; $c= 227; $status = 'cerca-vencer'; } else
            if ($diferencia_dias <= 0) { $a = 242; $b = 222; $c= 222; $status = 'vencido'; }
            else { $a = 255; $b = 255; $c= 255; $status = 'activo'; }
        }
        if (trim($libro['status']) == 'f') { $a = 223; $b = 240; $c= 216; $pdf->SetFillColor($a,$b,$c); $status = 'entregado'; } else { $pdf->SetFillColor($a,$b,$c); }
        if (in_array($status,$filtro_status) == 1){
            $pdf->Row(array($libro['id_prestamo'],utf8_decode(strtoupper($datos_libro['id_autor'])),utf8_decode(strtoupper($datos_libro['id_editorial'])),utf8_decode(strtoupper($datos_libro['descripcion'])),date('d-m-Y',strtotime($libro['fecha_prestamo'])),date('d-m-Y',strtotime($libro['fecha_devolucion'])),(($libro['status'] == 'f')?'ENTREGADO':'PENDIENTE')));
            $count_libros++;
        }
    }
}
if($count_libros==0){$pdf->SetTextColor(0,0,0);$pdf->SetFillColor(221,221,221);$pdf->Cell(237,8,'NO EXISTEN RESULTADOS PARA EL FILTRO SELECCIONADO',1,1,'C',true);};
$pdf->Ln(8);
$pdf->SetFont('Arial','B',9);
$count_tesis = 0;
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(221,221,221);
$pdf->Cell(237,8,'LISTA DE TESIS',1,1,'C',true);
$pdf->cell(28,8,'Cod. Prestamo',1,0,'C',true);
$pdf->cell(36,8,'Materia',1,0,'C',true);
$pdf->cell(28,8,'Autor Tesis',1,0,'C',true);
$pdf->cell(48,8,utf8_decode('Titulo'),1,0,'C',true);
$pdf->cell(31,8,'Fecha Prestamo',1,0,'C',true);
$pdf->cell(36,8,utf8_decode('Fecha Devolución'),1,0,'C',true);
$pdf->cell(30,8,'Status',1,1,'C',true);
if ($consultasbd->num_rows($tesis)) {
    $pdf->SetFont('Arial','',9,true);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetWidths(array(28,28,36,48,31,36,30));
    $pdf->SetAligns(array('C','C','C','C','C','C','C'));
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0,0,0);
    while ($tesi = $consultasbd->fetch_array($tesis)) {
        $datos_tesis = $consultasbd->select($tabla='tbl_tesis',$campos='*',$where='WHERE id_tesis=\''.$tesi['id_tesis'].'\'');
        $datos_tesis = $consultasbd->fetch_array($datos_tesis);
        // datos de materia
        $res_materia = $consultasbd->select($tabla='tbl_materia',$campos='*',$where = ((!empty($datos_tesis['id_materia']))?'WHERE id_materia=\''.$datos_tesis['id_materia'].'\'':''));
        $fetch_materia = $consultasbd->fetch_array($res_materia);
        $materia = $fetch_materia['nombre_materia'];
        // datos de autor
        $res_autor = $consultasbd->select($tabla='tbl_autor_tesis',$campos='*',$where = ((!empty($datos_tesis['id_autor_tesis']))?'WHERE id_autor_tesis=\''.$datos_tesis['id_autor_tesis'].'\'':''));
        $fetch_autor = $consultasbd->fetch_array($res_autor);
        $autor = $fetch_autor['nombre'].' '.$fetch_autor['apellido'];

        $datos_tesis['id_autor_tesis'] = $autor;
        $datos_tesis['id_materia'] = $materia;
        // total dias prestamo
        $segundos=strtotime($tesi['fecha_devolucion']) - strtotime($tesi['fecha_prestamo']);
        $diferencia_dias=intval($segundos/60/60/24);
        $a='';$b='';$c='';
        $status = '';
        if (date('Y-m-d') > $libro['fecha_devolucion']) {
            $a = 242; $b = 222; $c= 222; $status = 'vencido';
        } else {
            if ($diferencia_dias > 0 && $diferencia_dias < 2) { $a = 252; $b = 248; $c= 227; $status = 'cerca-vencer'; } else
            if ($diferencia_dias <= 0) { $a = 242; $b = 222; $c= 222; $status = 'vencido'; }
            else { $a = 255; $b = 255; $c= 255; $status = 'activo'; }
        }
        if (trim($tesi['status']) == 'f') { $a = 223; $b = 240; $c= 216; $pdf->SetFillColor($a,$b,$c); $status = 'entregado'; } else { $pdf->SetFillColor($a,$b,$c); }
        if (in_array($status,$filtro_status) == 1){
            $pdf->Row(array($tesi['id_prestamo_tesis'],utf8_decode(strtoupper($datos_tesis['id_materia'])),utf8_decode(strtoupper($datos_tesis['id_autor_tesis'])),utf8_decode(strtoupper($datos_tesis['titulo'])),date('d-m-Y',strtotime($tesi['fecha_prestamo'])),date('d-m-Y',strtotime($tesi['fecha_devolucion'])),(($tesi['status'] == 'f')?'ENTREGADO':'PENDIENTE')));
            $count_tesis++;
        }
    }
}
if($count_tesis==0){$pdf->SetTextColor(0,0,0);$pdf->SetFillColor(221,221,221);$pdf->Cell(237,8,'NO EXISTEN RESULTADOS PARA EL FILTRO SELECCIONADO',1,1,'C',true);};
$pdf->Ln(8);
$pdf->SetFont('Arial','B',9);
$count_mat=0;
$pdf->SetTextColor(0,0,0);
$pdf->SetFillColor(221,221,221);
$pdf->Cell(237,8,'LISTA DE MATERIALES',1,1,'C',true);
$pdf->cell(28,8,'Cod. Prestamo',1,0,'C',true);
$pdf->cell(36,8,'Tipo',1,0,'C',true);
$pdf->cell(76,8,'Nombre',1,0,'C',true);
$pdf->cell(31,8,'Fecha Prestamo',1,0,'C',true);
$pdf->cell(36,8,utf8_decode('Fecha Devolución'),1,0,'C',true);
$pdf->cell(30,8,'Status',1,1,'C',true);
if ($consultasbd->num_rows($material)) {
    $pdf->SetFont('Arial','',9,true);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetWidths(array(28,36,76,31,36,30));
    $pdf->SetAligns(array('C','C','C','C','C','C','C'));
    $pdf->SetTextColor(0,0,0);
    $pdf->SetDrawColor(0,0,0);
    while ($mat = $consultasbd->fetch_array($material)) {
        $datos_materiales = $consultasbd->query($sql = 'select * from tbl_material as tbl_mat left outer join tbl_tipo_material tbl_tipo on tbl_mat.id_tipo=tbl_tipo.id_tipo_material WHERE id_material=\''.$mat['id_material'].'\'');
        $datos_materiales = $consultasbd->fetch_array($datos_materiales);
        // total dias prestamo
        $segundos=strtotime($mat['fecha_devolucion']) - strtotime($mat['fecha_prestamo']);
        $diferencia_dias=intval($segundos/60/60/24);
        $a='';$b='';$c='';
        $status = '';
        if (date('Y-m-d') > $libro['fecha_devolucion']) {
            $a = 242; $b = 222; $c= 222; $status = 'vencido';
        } else {
            if ($diferencia_dias > 0 && $diferencia_dias < 2) { $a = 252; $b = 248; $c= 227; $status = 'cerca-vencer'; } else
            if ($diferencia_dias <= 0) { $a = 242; $b = 222; $c= 222; $status = 'vencido'; }
            else { $a = 255; $b = 255; $c= 255; $status = 'activo'; }
        }
        if (trim($mat['status']) == 'f') { $a = 223; $b = 240; $c= 216; $pdf->SetFillColor($a,$b,$c); $status = 'entregado'; } else { $pdf->SetFillColor($a,$b,$c); }
        if (in_array($status,$filtro_status) == 1){
            $pdf->Row(array($mat['id_prestamo_material'],utf8_decode(strtoupper($datos_materiales['descripcion_tipo'])),utf8_decode(strtoupper($datos_materiales['nombre'])),date('d-m-Y',strtotime($mat['fecha_prestamo'])),date('d-m-Y',strtotime($mat['fecha_devolucion'])),(($mat['status'] == 'f')?'ENTREGADO':'PENDIENTE')));
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