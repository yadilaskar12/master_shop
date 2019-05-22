<?php 

require '../pelapak.php';

$id=$_GET["id"];
$data_hapus=mysqli_query($koneksi,"SELECT profil_pembeli FROM pembelian_barang WHERE id_pembelian='$id'");
while ($data_row=mysqli_fetch_assoc($data_hapus)) {
	$file=$data_row["profil_pembeli"];
}

unlink("../foto_pembeli/".$file."");

$query_hapus= mysqli_query($koneksi,"DELETE FROM pembelian_barang WHERE id_pembelian='$id'");

if ($query_hapus > 0) {
	 echo "<script>alert('Lapoan Anda Berhasil Di Hapus');
        document.location.href='../pelapakk.php';
        </script>";

   
        exit();
	
}else{

	 echo "<script>alert('Lapoan Anda gagal Di Hapus');
        document.location.href='../pelapakk.php';
        </script>";

   
       return false;

}

// hapus_list belanja//


 ?>