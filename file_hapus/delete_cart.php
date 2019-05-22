<?php 
require '../pelapak.php';

if (isset($_POST["id_add"])) {
    $id_add=$_POST["id_add"];
    $query_delete_list=mysqli_query($koneksi,"DELETE FROM tbl_cart WHERE id_add='$id_add'") or die(mysqli_error($koneksi));


    $tampil_cart=mysqli_query($koneksi,"SELECT nama_barang,harga_barang,stok_barang,nama_toko,id_add,jenis_barang FROM tbl_cart") or die(mysqli_error($koneksi));
	$p=mysqli_num_rows($tampil_cart);
	echo json_encode($p);
    
}
?>