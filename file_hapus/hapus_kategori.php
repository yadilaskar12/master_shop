<?php 
require '../pelapak.php';
$get_id=$_GET["id_kategori"];
$query=mysqli_query($koneksi,"DELETE FROM add_kategori WHERE id_kategori='$get_id'");
if ($query > 0) {
	
	echo"<script>alert('Data berhasl dihapus');
			document.location.href='../addKategori.php';
		</script>";
	exit();
}
else{
	echo"<script>alert('Data gagal dihapus');
			document.location.href='../addKategori.php';
		</script>";
	return false;
}

 ?>