<?php 
require ('fpdf181/fpdf.php');
require 'pelapak.php';
session_start();
$kirim_barang= $_SESSION["nama_lengkap"];
$data_lengkap=  mysqli_query($koneksi,"SELECT pemilik_akun,nama_pembeli,nama_panggilan,alamat_lengkap,no_hp,provinsi,kabupaten,kecamatan,produk_terjual,harga_produk,jenis_produk,profil_pembeli,kode_pos  FROM pembelian_barang WHERE pemilik_akun='$kirim_barang' ");



/**
* 
*/
class PDF extends FPDF
{
	
	function Header()
	{
		$this->Setfont('times','B',18);
		$this->Cell(25);
		$this->Cell(230,10,'TERIMAKASIH SUDAH MENJADI MEMBER DI AYO DI GOLEK.COM',0,1,'C');
		$this->Cell(285,8,'UNTUK MENGEMBNGKAN USAHA ANDA MENJADI LEBIH MAJU',0,1,'C');
		$this->Cell(285,8,'WEBSITE MARKETPLACE TERPERCAYA DI INDONESIA',0,1,'C');
		$this->Ln(15);
		$this->SetLineWidth(1);
		$this->Line(10,38,289,38);
		$this->SetLineWidth(0);
		$this->Line(10,39,289,39);

		
	}

	function Content()
	{	
		global $data_lengkap;
		while ($row=mysqli_fetch_assoc($data_lengkap)) {
		$this->Setfont('times','B',16);
		$this->Cell(220);
		$this->Cell(45,45,''.$this->Image('foto_pembeli/'.$row["profil_pembeli"].'',231,52,43,43).'',1,0,'C');
		$this->Cell(-250);
		$this->Cell(-100,20,'BIODATA PELANGGAN',0,1,'L');
		
		// $this->Image('foto_pembeli/'.$row["profil_pembeli"].'',255,45,27,27);
		
		$this->Ln(5);
			
		$this->Setfont('times','',15);
		$this->Cell(11);
		$this->Write(10,'Nama Lengkap');
		$this->Cell(13);
		$this->Write(10,': 	'.$row["nama_pembeli"].'');
		$this->Ln(10);

		$this->Cell(11);
		$this->Write(10,'Nama Panggilan');
		$this->Cell(11);
		$this->Write(9,': 	'.$row["nama_panggilan"].'');

		$this->Ln(10);
		$this->Cell(11);
		$this->Write(10,'No Handphone');
		$this->Cell(14);
		$this->Write(9,': 	'.$row["no_hp"].'');

		$this->Ln(10);
		$this->Cell(11);
		$this->Write(10,'Alamat Lengkap');
		$this->SetFont('times','',13);
		$this->Cell(11);
		$this->Write(9,''.$this->Cell(250,10,''.$row["alamat_lengkap"].'',0,0,'L').'');

		$this->Ln(10);
		$this->Cell(11);
		$this->SetFont('times','',15);
		$this->Write(10,'Provinsi');
		$this->Cell(27);
		$this->Write(9,':	'.$row["provinsi"].'','R');

		$this->Ln(10);
		$this->Cell(11);
		$this->Write(10,'Kabupaten');
		$this->Cell(22);
		$this->Write(9,':  '.$row["kabupaten"].'','R');

		$this->Ln(10);
		$this->Cell(11);
		$this->Write(10,'Kecamatan');
		$this->Cell(22);
		$this->Write(9,':   '.    $row["kecamatan"]  .'','R');
		$this->Ln(40);



	}

	}

	function Footer()
	{
		// atur posisi 1.5 cm dari bawah//
		$this->SetY(-15);
		//buat garis horizontal//
		$this->Line(10,$this->GetY(),289,$this->GetY());
		// aria italic 9//
		$this->SetFont('Arial','I',9);

		// no halaman//

		$this->Cell(0,10,'Halaman'.$this->PageNo().'dari{nb}',0,0,'R');
	}
}

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4');
$pdf->Content();
$pdf->Output();



 ?>