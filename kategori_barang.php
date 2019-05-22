<?php 
require 'koneksi.php';

$data=$_POST["jenis_barang"];
$sumber_data_kategori= mysqli_query($koneksi,"SELECT jenis_barang,nama_barang,diskon,harga_barang,deskripsi_barang,id_tambah,gambar FROM barang WHERE jenis_barang='$data' LIMIT 10") or die (mysqli_error($koneksi));
$simpan_data=[];

while ($row=mysqli_fetch_assoc($sumber_data_kategori)) {
	$simpan_data[]=$row;
}

echo json_encode($simpan_data);





 ?>