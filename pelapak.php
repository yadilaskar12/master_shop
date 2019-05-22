<?php 
$koneksi= mysqli_connect("localhost","root","","tokoku");

if (isset($_POST["id_tambah"])) {
	$id_add=$_POST["id_tambah"];
	$query_add=mysqli_query($koneksi,"SELECT nama_barang,merek_barang,harga_barang,stok_barang,nama_toko FROM barang WHERE id_tambah='$id_add'");

	while ($row_data=mysqli_fetch_assoc($query_add)) {
		$nama_barang= $row_data["nama_barang"];
		$merek_barang=$row_data["merek_barang"];
		$harga_barang=$row_data["harga_barang"];
		$stok_barang=$row_data["stok_barang"];
		$nama_toko=$row_data["nama_toko"];
	}

	$insert_cart=mysqli_query($koneksi,"INSERT INTO tbl_cart VALUES('','$nama_barang','$harga_barang','$merek_barang','$stok_barang','$nama_toko')") or die(mysqli_error($koneksi));
	
	$tampil_cart=mysqli_query($koneksi,"SELECT nama_barang,harga_barang,stok_barang,nama_toko,id_add,jenis_barang FROM tbl_cart") or die(mysqli_error($koneksi));
	$p=mysqli_num_rows($tampil_cart);

	echo json_encode($p);
}



/// halaman sistem crud semua crud ada di sini ///

function beli_barang($pembeli){

	global $koneksi;

	$nama_lengkap=htmlspecialchars(stripcslashes(strtoupper($pembeli["nama_lengkap_c"])));
	$nama_panggilan=htmlspecialchars(stripcslashes(strtoupper($pembeli["nama_panggilan"])));
	$no_hp=htmlspecialchars(stripcslashes(strtoupper($pembeli["no_hpp"])));
	$alamat_lengkap=htmlspecialchars(stripcslashes(strtoupper($pembeli["alamat_l"])));
	$provinsi=htmlspecialchars(stripcslashes(strtoupper($pembeli["provinsi"])));
	$kabupaten=htmlspecialchars(stripcslashes(strtoupper($pembeli["kabupaten"])));
	$kecamatan=htmlspecialchars(stripcslashes(strtoupper($pembeli["kecamatan"])));
	$kode_post=htmlspecialchars(stripcslashes(strtoupper($pembeli["kode_post"])));
	$kode_belanja=$pembeli["kode_belanja"];
	$pemilik_akun=$pembeli["pemilik"];
	$nama_toko=$pembeli["name_toko"];
	$barang_terjual=$pembeli["nama_barang_beli"];
	$harga=$pembeli["harga_barang"];
	$jenis_produk=$pembeli["jenis_produk"];
	$foto_pembeli= unggah_profile();

		if (!$foto_pembeli) {
		return false;
	}

	$beli=mysqli_query($koneksi,"INSERT INTO pembelian_barang VALUES('','$nama_lengkap','$nama_panggilan','$no_hp','$alamat_lengkap','$pemilik_akun','$provinsi','$kabupaten','$kecamatan','$kode_post','$nama_toko','$foto_pembeli','$barang_terjual','$harga','$jenis_produk','$kode_belanja')") or die(mysqli_error($koneksi));

	return mysqli_affected_rows($koneksi);
}


function tambah($data){

global $koneksi;


$nama_lengkap= strtoupper(stripcslashes($data["nama_lengkap"]));
$nama_toko = htmlspecialchars($data["nama_toko"]);
$no_hp= strtolower(htmlspecialchars($data["no_hp"]));
$alamat_lengkap= htmlspecialchars($data["alamat"]);
$username= htmlspecialchars($data["username"]);
$password= mysqli_real_escape_string($koneksi,$data["password"]);
$password1= mysqli_real_escape_string($koneksi,$data["password1"]);
$pilihan= strtoupper( htmlspecialchars($data["pilihan"]));
$slogan= htmlspecialchars($data["slogan"]);
$level= htmlspecialchars($data["level"]);
$date= $data["date"];
$profile= profile_toko();

if (!$profile) {
	return false;
}




$result= mysqli_query($koneksi, "SELECT username FROM data_pelapak WHERE username= '$username'");
$data_result= mysqli_query($koneksi, "SELECT nama_toko_atau_tujuan_donatur FROM data_pelapak WHERE nama_toko_atau_tujuan_donatur= '$nama_toko'");

if (mysqli_fetch_assoc($result)) {

	echo "<script>alert('Maaf Username Yang Anda Daftarkan Sudah Ada, Tolong Cari Nama Lain !!!')</script>";
	return false;
	
}elseif(mysqli_fetch_assoc($data_result)){
	echo "<script>alert('Nama Toko Yang Anda Daftarkan Sudah Ada, Tolong Cari Nama Lain !!!')</script>";
	return false;
}else{
	mysqli_error($koneksi);
}

if ($password !== $password1) {

	echo "<script>alert('Maaf Verifikasi Password Tidak Sesuai')</script>";
	return false;
}else{
	mysqli_error($koneksi);
}

$password= password_hash($password, PASSWORD_DEFAULT);

$tambah=mysqli_query($koneksi,"INSERT INTO data_pelapak VALUES('','$nama_lengkap','$nama_toko','$no_hp','$alamat_lengkap','$username','$password','$pilihan','$slogan','$date','$level','$profile')");



return mysqli_affected_rows($koneksi);

}

function tambah_barang($tambah){


global $koneksi;

	 $pemilik= strtoupper(stripcslashes($tambah["nama_pemilik"]));
	 $toko= strtoupper(stripcslashes($tambah["nama_toko"]));
	 $jenis_barang= strtoupper(stripcslashes($tambah["pilihan_barang"]));
	 $merek_barang = htmlspecialchars($tambah["merek_barang"]);
	$kondisi_barang= strtolower(htmlspecialchars($tambah["pilihan_keadaan"]));
	$nama_barang= strtoupper(htmlspecialchars($tambah["nama_barang"]));
	$harga_barang=strtoupper(htmlspecialchars($tambah["harga_barang"]));
	$stok=htmlspecialchars($tambah["stok_barang"]);
	$deskripsi= htmlspecialchars($tambah["deskripsi"]);
	$waktu= strtoupper( htmlspecialchars($tambah["waktu"]));
	$diskon= stripcslashes(htmlspecialchars(strtolower($tambah["diskon"])));
	$gambar= unggah_gambar();

if (!$gambar) {
	return false;
}


$tambah_barang=mysqli_query($koneksi,"INSERT INTO barang VALUES('','$pemilik','$toko','$jenis_barang','$merek_barang','$kondisi_barang','$nama_barang','$harga_barang','$stok','$deskripsi','$waktu','$gambar','$diskon')");


return mysqli_affected_rows($koneksi);



}



function unggah_gambar(){

$nama_file= $_FILES["gambar"]["name"];
$ukuran= $_FILES["gambar"]["size"];
$error=$_FILES["gambar"]["error"];
$simpan=$_FILES["gambar"]["tmp_name"];


if ($error=== 4) {
	
	echo "<script>alert('Maff Anda Belum Mengupload File Gambarnya');</script>";

	return false;
}

$ekstensi_gambar=['jpg','jpeg','png'];
$gabung_file= explode('.', $nama_file);
$gabung_file= strtolower(end($gabung_file));

if (!in_array($gabung_file, $ekstensi_gambar)) {
	echo "<script>alert('Yang Anda Upload Tidak Sesuai Dengan Format Dari Kami');</script>";
	return false;
}

if ($ukuran > 2000000) {

	echo "<script>alert('Ukuran file anda terlalu besar');</script>";
	return false;
	
}

$nama_file_baru= uniqid();
$nama_file_baru .='.';
$nama_file_baru .= $gabung_file;

move_uploaded_file($simpan, 'pelapak_gambar/'. $nama_file_baru);


return $nama_file_baru;



}


function unggah_profile(){

	$nama_file_gambar= $_FILES["foto_pembeli"]["name"];
	$ukuran_file=$_FILES["foto_pembeli"]["size"];
	$penyimpanan_sementara=$_FILES["foto_pembeli"]["tmp_name"];
	$error=$_FILES["foto_pembeli"]["error"];


	if ($error === 4) {
		echo "<script>alert('Maaf anda belum mengupload foto anda');</script>";
		return false;
	}

	$ekstensi_gambar=["jpg","png","JPG","jpeg"];
	$gabung_file=explode('.', $nama_file_gambar);
	$gabung_file=strtolower(end($gabung_file));



	if (!in_array($gabung_file, $ekstensi_gambar)) {

		echo "<script>alert('Yang Anda Upload Tidak Berformatkan foto atau tidak sesuai ekstensi foto berdsarkan kriteria kami (jpg,png, jpeg)');</script>";

		return false;
	
	}

	if ($ukuran_file > 2000000) {
	echo "<script>alert('Ukuran file anda terlalu besar');</script>";
	return false;
	
	}


	$nama_file_baru=uniqid();
	$nama_file_baru .= '.';
	$nama_file_baru .=  $gabung_file;

	move_uploaded_file($penyimpanan_sementara, 'foto_pembeli/'. $nama_file_baru);

	return $nama_file_baru;

}


function profile_toko(){


	$nama_file_gambar= $_FILES["foto"]["name"];
	$ukuran_file=$_FILES["foto"]["size"];
	$penyimpanan_sementara=$_FILES["foto"]["tmp_name"];
	$error=$_FILES["foto"]["error"];


	if ($error === 4) {
		echo "<script>alert('Maaf anda belum mengupload foto anda');</script>";
		return false;
	}

	$ekstensi_gambar=["jpg","png","JPG","jpeg"];
	$gabung_file=explode('.', $nama_file_gambar);
	$gabung_file=strtolower(end($gabung_file));



	if (!in_array($gabung_file, $ekstensi_gambar)) {

		echo "<script>alert('Yang Anda Upload Tidak Berformatkan foto atau tidak sesuai ekstensi foto berdsarkan kriteria kami (jpg,png, jpeg)');</script>";

		return false;
	
	}

	if ($ukuran_file > 2000000) {
	echo "<script>alert('Ukuran file anda terlalu besar');</script>";
	return false;
	
	}


	$nama_file_baru=uniqid();
	$nama_file_baru .= '.';
	$nama_file_baru .=  $gabung_file;

	move_uploaded_file($penyimpanan_sementara, 'foto_profile_toko/'. $nama_file_baru);

	return $nama_file_baru;


}

function edit_profile_toko($edit_profile){

 	global $koneksi;

 	$id=$edit_profile["id"];
	$nama_lengkap= htmlspecialchars(strtoupper(stripslashes($edit_profile["name_lengkap"])));
	$nama_toko= htmlspecialchars(strtoupper(stripslashes($edit_profile["name_toko"])));
	$nama_alamat= htmlspecialchars(stripcslashes($edit_profile["address_lengkap"]));
	$hp= htmlspecialchars(strtolower(stripcslashes($edit_profile["no_hppp"])));
	$jenis_toko= htmlspecialchars(strtolower(stripcslashes($edit_profile["jenis_toko_saudara"])));
	$moto= htmlspecialchars(strtolower(stripcslashes($edit_profile["moto"])));
	

	$foto_toko=$edit_profile["file_lama"];

	if ($_FILES["foto"]["error"]=== 4) {
		$file=$foto_toko;
	}else{
		$file=profile_toko();

		if (!$file) {
			return false;
		}
	}

	$result=mysqli_query($koneksi,"UPDATE data_pelapak SET nama_pelapak_atau_nama_donatur='$nama_lengkap',nama_toko_atau_tujuan_donatur='$nama_toko',no_hp='$hp',alamat_lengkap='$nama_alamat',pilihan='$jenis_toko',motto_amanat='$moto',foto='$file' WHERE id_pelapak= $id")or die(mysqli_error($koneksi));

	return $result;

}

// add kategori//

function addKategori($add){

	global $koneksi;

	$kodeKategori=htmlspecialchars(stripcslashes($add["kode_kategori"]));
	$nama_kategori=htmlspecialchars(stripcslashes($add["name_kategori"]));
	$data_waktu=$add["date_waktu"];
	$pemilik_toko=$add["pemilik_toko"];

	$data_kategori=mysqli_query($koneksi,"SELECT nama_kategori FROM add_kategori WHERE nama_kategori='$nama_kategori'");

	if (mysqli_fetch_assoc($data_kategori)) {
		echo"<script>alert('nama Kategori Sudah Ada')</script>";
		return false;
	}

	$query_data=mysqli_query($koneksi,"INSERT INTO add_kategori VALUES('','$kodeKategori','$nama_kategori','$data_waktu','$pemilik_toko')");

	return mysqli_affected_rows($koneksi);



}






 ?>