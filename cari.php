<!DOCTYPE html>
<html>
<head>
	<title></title>
	 <link href="../master_shop/assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
	 <style type="text/css">
	 	.jumb:hover{
	 		background-color: blue;
	 	}
	 	li:hover{
	 		background-color: rgb(0,0,0,0.1);
	 		cursor: pointer;

	 	}
	 	li a:hover{
	 		cursor: pointer;
	 	}

	 </style>
</head>
<body>

<ul id="hasil-pencarian">
	<?php 

	require 'koneksi.php';
	if (isset($_POST['tombol_cari'])) {
	
	$input= mysqli_real_escape_string($koneksi,$_POST["tombol_cari"]);

	if (strlen($input) > 0) {
		$query_pencarian= mysqli_query($koneksi,"SELECT * FROM barang WHERE nama_barang LIKE '%$input%' OR jenis_barang  LIKE '%$input%'ORDER BY id_tambah LIMIT 6" );

		if (mysqli_num_rows($query_pencarian) > 0) {
				while ($hasil_pencarian = mysqli_fetch_array($query_pencarian)) {
					

					?>

					<div class="jumb" style=" min-height:1px; padding: 10px; background-color: #fff; font-size: 14px; width: 100%; margin-right: auto; margin-left: auto; line-height: auto;border-radius: 5px;">
					<img src="pelapak_gambar/<?php echo $hasil_pencarian["gambar"]; ?>" style="width: 40px; height: 40px;" class="img-circle"> <a href="hasil_data.php?id=<?php echo $hasil_pencarian['id_tambah'];?>& jenis=<?php echo $hasil_pencarian["jenis_barang"]; ?>" style="font-size: 13px; color: rgb(38,166,154); text-align: right;"><?php echo $hasil_pencarian['nama_barang']; ?></a> <br></div>

					<?php
				}
			}else{
				echo "<div class='alert-danger' style='font-size:29px; text-align:center; border-radius:5px; padding:10px; font-weight:bold;'>Barang Yang Anda Cari Tidak Ada  | 404 NOT FOUND !!</div>";
			}
		}
	}

	 ?>

	
</ul>
</body>
</html>