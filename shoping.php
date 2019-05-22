<?php 
require 'pelapak.php';

$tampil_cart=mysqli_query($koneksi,"SELECT nama_barang,harga_barang,stok_barang,nama_toko,id_add,jenis_barang FROM tbl_cart") or die(mysqli_error($koneksi));
$data_array=[];
while ($row= mysqli_fetch_assoc($tampil_cart)) {

	$data_array[]=$row;
}

echo json_encode($data_array);




 ?>