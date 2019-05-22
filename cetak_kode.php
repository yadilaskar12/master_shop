<?php 
require 'fpdf181/fpdf.php';
require 'pelapak.php';
$kodeBelanja=$_GET["kode"];

/**
* 
*/$title='Kode Belanja';
class PDF extends FPDF
{
	
	function Header()
	{
		global $title;
		$this->SetFont('times','B',27);

	}

	function Content()
	{
		global $kodeBelanja;
		$this->SetFont('times','B',27);
		$this->Ln(40);
		$this->Cell(25);
		$this->Write(10,'Kode Belanja :'.$kodeBelanja. '');
	}
}

$pdf= new PDF();
$pdf->SetTitle($title);
$pdf->AliasNbPages();
$pdf->AddPage('P','A4');
$pdf->Content();
$pdf->Output();


?>