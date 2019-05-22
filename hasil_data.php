<?php 
session_start();
require 'pelapak.php';

if (isset($_SESSION["login"])) {
 header("location:pelapakk.php");
 exit;
}

if (isset($_POST["tombol_daftar"])) {


  if (tambah($_POST) > 0) {

    echo"<script>alert('Toko Berhasil Di Buat, Selamat Sekarang Anda Telah Menjadi Member Master_Shop.com');
    document.location.href='index.php';
    </script>";
    
    
  }else{
    echo"<script>alert('Akun Gagal Di Buat.....');
    document.location.href='index.php';
    </script>";
    
    exit;
  }
 
}

if (isset($_POST["submitt"])) {
  $user=$_POST["usernamee"];
  $pass=$_POST["passworddd"];
  $pilih= $_POST["pilihannn"];


  $sumber= mysqli_query($koneksi,"SELECT * FROM data_pelapak WHERE level='$pilih' AND username='$user'");
  $ambil= mysqli_fetch_assoc($sumber);
  $level= $ambil["level"];

   $nama_lengkap=$ambil["nama_pelapak_atau_nama_donatur"];
   $nama_toko= $ambil["nama_toko_atau_tujuan_donatur"];
   $foto_profile=$ambil["foto"];
   $address=$ambil["alamat_lengkap"];
   $hp= $ambil["no_hp"];
   $kategori_toko= $ambil["pilihan"];
   $motto_atau_amanat=$ambil["motto_amanat"];
   $id_pelapak= $ambil["id_pelapak"];

    
  if (mysqli_num_rows($sumber) === 1) {

    $_SESSION["nama_lengkap"]= $nama_lengkap;
    $_SESSION["nama_toko"]= $nama_toko;
    $_SESSION["profile"]= $foto_profile;
    $_SESSION["alamat_lengkap"]= $address;
    $_SESSION["hp"]= $hp;
    $_SESSION["jenis_toko"]= $kategori_toko;
    $_SESSION["motto"]=$motto_atau_amanat;
    $_SESSION["id"]=$id_pelapak;
   

    if (password_verify($pass, $ambil["password"])) {
          $_SESSION["login"]= true;

      if ($level=="donatur") {
       echo "<script>alert('Good Joob', 'Terimakasih Atas Partisipasinya','Success');
       document.location.href='donatur.php';
       </script>";
       exit;
      }elseif($level=="pelapak"){

       echo "<script>alert('Good Joob', 'Terimakasih Atas Partisipasinya','Success');
       document.location.href='pelapakk.php';
       </script>";
       exit;
      }

    }
 
  }

  $error= true;

}

// data tampil//
$jumlahPerhalaman=8;
$result_tampil= mysqli_query($koneksi,"SELECT jenis_barang,nama_barang,diskon,harga_barang,deskripsi_barang,id_tambah,gambar FROM barang");
$jumlah_data=mysqli_num_rows($result_tampil);
$pembagi_data=floor($jumlah_data / $jumlahPerhalaman);
$data_aktif=(isset($_GET["halaman"])) ? $_GET["halaman"]:1;
$awal_data=($jumlahPerhalaman * $data_aktif) - $jumlahPerhalaman;

$jenis=$_GET["jenis"];
$id=$_GET["id"];
$sumber_daya=mysqli_query($koneksi,"SELECT jenis_barang,nama_barang,diskon,harga_barang,deskripsi_barang,id_tambah,gambar FROM barang WHERE jenis_barang='$jenis' LIMIT $awal_data,$jumlahPerhalaman");
 ?>




<!DOCTYPE html>
<html lang="en">
<html>
<head>

  <meta charset="utf-8" />
  <link rel="icon" type="image/png" href="assets/img/favicon.ico">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Ayo Di Golek</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <meta name="theme-color" content="#0f0">

     
    <link rel="stylesheet" type="text/css" href="../master_shop/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../master_shop/css/materialize.css">
    <link rel="stylesheet" type="text/css" href="../master_shop/css/style.css">
    <link href="../master_shop/assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../master_shop/css/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../master_shop/css/font/flaticon.css">
    <link rel="stylesheet" href="../master_shop/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="../master_shop/bower_components/font-awesome/css/font-awesome.min.css">

  
</head>
<body>


 <div class="navbar-fixed" style="background-color: transparent;position: absolute;">
 <nav>
  <div class="nav-wrapper">

    <a href="#!" class="brand-logo">
      
       <a href="" style="font-size: 18px; font-family: forte; color: white; text-shadow: 3px 3px 5px black;" data-toggle="modal" data-target="#pencarian"><img src="png/008-search.png" style="height: 40px;width:40px; "></a> 

        <span style=" position: relative; cursor: pointer;"> <img src="../master_shop/png/toko.png" style="height: 30px;" id="sentuh">
        <span class="label label-info" style="position: absolute; top: -16px; right: -6px;" id="span_i"></span></span>

        <a href="" style="font-size: 18px; font-family: forte; color: rgb(38,166,154);text-shadow: 3px 3px 5px white; transform: scale(1) rotate(360deg);" data-toggle="modal" data-target="#loginmodal"><img src="png/030-lock.png" style="height: 40px;width:40px; margin-left: 10px; "></a> 
                
    </a>

    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="ion-navicon-round" style="color:rgb(34,45,50); font-weight: bold;"></i></a>
    <ul class="right hide-on-med-and-down">
     
    

     <li><a href="index.php" style="font-size: 18px; font-family: forte;color: white;"><img src="../master_shop/png/home.png" style="height: 30px;"> Home</a></li>
      <li><a href="" style="font-size: 18px; font-family: forte; color: white;"><img src="../master_shop/png/wa.png" style="height: 30px;"> Laporkan Pelapak</a></li>
      <li><a href="" style="font-size: 18px; font-family: forte; color: white;"><img src="../master_shop/png/surat.png" style="height: 30px;"> Jadilah Donatur</a></li>
      <li><a href="" style="font-size: 18px; font-family: forte; color: white;"><i class="pe-7s-cash" style="font-size: 30px;"> </i> Cara Bayar</a></li>
    
      <li><a href="" data-toggle="modal" data-target="#buat_toko" style="font-size: 18px;  font-family: forte; color: white;"><img src="../master_shop/png/toko.png" style="height: 30px;"> Create Toko</a></li>

      <li>
      </li>
         
        

    </ul>

  </div>
</nav>
</div>

<ul class="sidenav" id="mobile-demo">
<div class="header">Menu Utama !!!</div>
<div class="atas-menu">
<a href="" class="btn btn-danger" id="efek">Menu Utama !!!</a>
<a href="" class="btn btndanger" id="efek2"></a>
</div>     
       <li><a href="" style="font-size: 18px; font-family:  Roboto; color: rgb(38,166,154);" data-toggle="modal" data-target="#loginmodal"> <img src="../master_shop/png/010-research.png" style="height: 30px;">  login</a></li>
       <li><a href="" data-toggle="modal" data-target="#buat_toko" style="font-size: 18px;  font-family:  Roboto; color: rgb(38,166,154); text-shadow: 3px 3px 5px white;"><img src="../master_shop/png/010-research.png" style="height: 30px;">  Create Toko</a></li>
     
      <li><a href="" style="font-size: 18px; font-family:  Roboto;color: rgb(38,166,154);"><img src="../master_shop/png/wa.png" style="height: 30px;">  Laporkan Pelapak</a></li>
      <li><a href="" style="font-size: 18px; font-family:  Roboto;color: rgb(38,166,154);"> <img src="../master_shop/png/010-research.png" style="height: 30px;"> Jadilah Donatur</a></li>
      <li><a href="" style="font-size: 18px; font-family:  Roboto; color: rgb(38,166,154);" id="gerak"><img src="../master_shop/png/010-research.png" style="height: 30px;">  Cara Bayar</a></li>
      <li><a href="" style="font-size: 18px;  font-family:  Roboto;color: rgb(38,166,154);"> <img src="../master_shop/png/010-research.png" style="height: 30px;">  Kategori Barang</a></li>
</ul>
  
<?php if (isset($error)):?>
<script type="text/javascript" style="color: red;">
  alert('Anda Bukan pelapak Atau Donatur/ Username Dan Password Anda Salah Coba Check Dengan Benar');
  document.location.href='index.php';
</script>

<?php endif ; ?>

 <div class="alert alert-success" id="message">
 <h4 class="alert-heading">Warning !!</h4>
 <a href="javascript:void(0)">&times</a>
</div>


<div class="col-md-3" id="cart_shop">
    <a href="javascript:void(0)" style="font-size: 38px; float: left;height: 40px; width: 40px; text-align: center;line-height: 40px; color: red;opacity: 1;" class="tutup">&times</a> <br>
    <h2 class="modal-title" style="color: rgb(36,166,157); font-size: 20px;margin-top: 20px; text-align: center;">List Belanja</h2> <br>
 </div>
 
<div id="loginmodal" class="modal fade" style="background:transparent;padding: 0;">
 <div class="modal-header"style="border:none; background:transparent;box-shadow: none;">  
     <a href="" class="close" data-dismiss="modal">&times</a></div>
      <div class="modal-body" style="width: 100%;">
        <h5 class="modal-title" style="color:white; font-family: forte;">Silahkan Login Ke Sistem Kami</h5><br>
          <div class="alert alert-danger" role="alert">
            <form action="" method="post">
               <label id="usernamee"><i class="pe-7s-tools" style="font-size: 25px;color:#0f0;"></i> </label><br>
                 <select class="icons" name="pilihannn" id="username" type="text">
                  <option><i class="pe-7s-shopbag"></i> Kategori</option>
                  <option>donatur</option>
                  <option>pelapak</option>
          </select>
        <br> 
        <label id="usernamee" class="hasil" style="color:rgb(36,166,157); font-size: 18px;font-style: italic;"><img src="png/020-man.png" style="height: 40px;width: 40px;"></label>
        <input type="text" placeholder=" Masukan Username" required="" autocomplete="off" class="form-control masuk" name="usernamee" id="username"></input><br>
        <label id="passwordd"><img src="png/032-lock-2.png" style="height: 40px;width: 40px;"> </label>
        <input type="password" placeholder=" Masukan Password" required="" autocomplete="off" class="form-control keluar" name="passworddd" id="password"></input><br>

           <label>
             <input class="filled-in" type="checkbox" checked="checked" name="ingat_saya"></input>
             <span style="color:rgb(36,166,157)">Ingat Saya</span>
           </label>
          <button type="submit" style="height: 60px;" name="submitt" class="btn" style="background-color: rgb(1,1,100);"><i class="pe-7s-paper-plane" style="font-size: 27px;"></i> Sig In</button>      
       </form>
           <hr>
           <p class="mb-o">Halaman Login Akun</p>
     </div>
  </div> 
</div> 

<div id="datalaporan" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="background-color: white;">
      <h4 class="modal-title">Laporkan Pelapak jika Mereka Melakukan Sesuatu Hal Yang Tidak Menyenangkan Terhadap Customer</h4>
        <a href="" class="close" style="color:red; font-size: 23px;"><i class="pe-7s-close-circle" style="font-size: 45px; color: red;" data-dismiss="modal"></i></a>
          <div class="modal-body">
            <form action="" method="post">
               <label id="usernamee"><i class="ppe-7s-tools" style="font-size: 25px;color:#0f0;"></i> Level</label><br>
                <select class="form-control" name="pilihannn" id="username">
                  <option><i class="pe-7s-shopbag"></i> Kategori</option>
                  <option>donatur</option>
                  <option>pelapak</option>
                </select>
                <br>
           <label id="usernamee"><i class="pe-7s-users" style="font-size: 25px;color:#0f0;"></i> Username</label>
           <input type="text" placeholder=" Masukan Username" required="" autocomplete="off" class="form-control" name="usernamee" id="username"></input><br>
           <label id="passwordd"><i class="pe-7s-unlock" style="font-size: 25px;color:#0f0;"></i> Password</label><br>
          <input type="password" placeholder=" Masukan Password" required="" autocomplete="off" class="form-control" name="passworddd" id="password"></input><br>
          <button type="submit" name="submitt" class="btn btn-primary btn-lg"><i class="pe-7s-paper-plane" style="font-size: 27px;"></i> Sig In</button>
       </form>
      </div>
    </div>
  </div>
</div>

<div id="pencarian" class="modal fade" role="dialog" style="background:transparent;">
 <!--  <div class="modal-content" style="padding: 0;"> -->
       <div class="modal-header"style="border:none; background:transparent;box-shadow: none;">
         <a href="" class="close" data-dismiss="modal">&times</a></div>
          <div class="modal-body" style="width: 100%;">
            <h5 class="modal-title" style="color:white; font-family: forte;">Masukan keyword Pencarian Contoh : elektronik, kosmetik dll</h4><br>
              <form action="cari.php" method="post"><img src="../master_shop/png/007-seo.png" style="height: 30px;">

                <input type="text" required="" placeholder="Cari Barang Yang Anda Inginkan ...." name="dicari" class="form-control" onkeyup="mencari(this.value)" style="color: white;" id="identitas"></input>
                  <div class="mod" style="background-color:transparent; border-radius: 5px; min-height: 10px; width: 100%; color: red; z-index: 10000; margin-top: -10px;"></div></form>
               </div>
            <!-- </div> -->
          </div>



<div id="datadonatur" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width: 70%; margin-left: auto; margin-right: auto; ">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#00c0ef; border-bottom: 13px solid gold;">
        <a href="" class="close"><i class="pe-7s-close-circle" style="font-size: 25px; color: red;" data-dismiss="modal"></i></a>
        <h4 class="modal-title"> Donasikanlah Sebagian Dari Harta Anda Karna Itu Semua Hanya Titipan Dari tuhan</h4>
      </div>
      <div class="modal-body">
         <form action="" method="post">
           <label id="usernamee"><i class="pe-7s-users" style="font-size: 25px;color:#0f0;"></i> Nama Lengkap</label><br>
           <input type="text" placeholder=" Masukan Username" required="" autocomplete="off" class="form-control" name="nama_lengkap" id="username"></input><br>
           <label id="passwordd"><i class="pe-7s-users" style="font-size: 25px;color:#0f0;"></i> Kategori User </label><br>
           <input type="text" placeholder=" Masukan Nama Toko Anda" required="" autocomplete="off" class="form-control" name="level" id="password" value="Donatur" readonly="disable"></input><br>

           <label id="passwordd"><i class="pe-7s-home" style="font-size: 25px;color:#0f0;"></i> Tujuan Donasi</label><br>
             <select class="form-control" name="nama_toko" id="username">
                    <option><i class="pe-7s-shopbag"></i> Tujuan Donasi</option>
                    <option>Panti Asuhan</option>
                    <option>Orang Tidak Mampu</option>
                    <option>Pembangunan</option>
                    <option>Penyandang Fisabilitas</option>
                    <option>Pendidikan</option>
                    <option>Lainnya</option>
                </select>
                <br>
              <label id="passwordd"><i class="pe-7s-call" style="font-size: 25px;color:#0f0;"></i> NO Handphone</label><br>
              <input type="number" placeholder=" Masukan No HP" required="" autocomplete="off" class="form-control" name="no_hp" id="password"></input><br>

               <label id="passwordd"><i class="pe-7s-map-marker" style="font-size: 25px;color:#0f0;"></i> Alamat Lengkap</label><br>
               <textarea class="form-control" placeholder="Masukan Alamat Anda" id="alamat" name="alamat" style="height: 100px;"></textarea><br>

                <label id="passwordd"><i class="pe-7s-user" style="font-size: 25px;color:#0f0;"></i> Username</label><br>
                <input type="text" placeholder=" Create Username" required="" autocomplete="off" class="form-control" name="username" id="username"></input><br>

                <label id="passwordd"><i class="pe-7s-door-lock" style="font-size: 25px;color:#0f0;"></i> Password</label><br>
                <input type="password" placeholder=" Masukan Password" required="" autocomplete="off" class="form-control" name="password" id="password"></input><br>


                <label id="passwordd"><i class="pe-7s-door-lock" style="font-size: 25px;color:#0f0;"></i> Konfirmasi Password</label><br>
                <input type="password" placeholder=" Konfirmasi Password" required="" autocomplete="off" class="form-control" name="password1" id="password"></input><br>

                <label id="passwordd"><i class="pe-7s-door-lock" style="font-size: 25px;color:#0f0;"></i> Kategori Akun</label><br>
                <input type="text" placeholder=" Konfirmasi Password" required="" autocomplete="off" class="form-control" name="pilihan" id="password" value="Donasi" readonly="disable"></input><br>

      

                <label id="passwordd"><i class="pe-7s-id" style="font-size: 25px;color:#0f0;"></i> Amanat Yang Ingin Anda Sampaikan Kepada Kami </label><br>
              <textarea class="form-control" placeholder="Isikan Amanat Anda" id="alamat" name="slogan" style="height: 100px;"></textarea><br>
              <input type="hidden" class="form-control" name="date" value="<?php echo date('l, Y-m-d,H:i a'); ?>"></input>
              <button type="submit" name="tombol_daftar" class="btn btn-primary btn-lg"><i class="pe-7s-paper-plane" style="font-size: 27px;"></i> Create Akun Seorang Donatur</button>
       </form>
      </div>
    </div>
  </div>
</div>

<div id="buat_toko" class="modal fade" role="dialog" style="width: 97%; background-color: transparent;">
  <div class="modal-dialog" style="width: 100%; margin-left: auto; margin-right: auto;  ">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#00c0ef; border-bottom: 13px solid gold;">
        <a href="" class="close"><i class="pe-7s-close-circle" style="font-size: 25px; color: red;" data-dismiss="modal"></i></a>
        <h4 class="modal-title"> Create Toko Dan Mulailah Berbisnis Online Di Situs Kami</h4>
      </div>
      <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data">
         <label id="passwordd"><img src="png/file.png" style="height: 40px;width: 40px;">Foto Profile </label><br>
          <input type="file" placeholder=" Masukan Nama Toko Anda" autocomplete="off" class="form-control" name="foto" id="password"></input><br>
            <label id="usernamee"><img src="png/020-man.png" style="height: 40px;width: 40px; color:rgb(36,166,157);"> Nama Lengkap</label><br>
             <input type="text" placeholder=" Nama Lengkap Anda" required="" autocomplete="off" class="form-control" name="nama_lengkap" id="username" maxlength="40" minlength="5" ></input><br>

            <label id="passwordd"><img src="png/user.png" style="height: 40px;width: 40px; color:rgb(36,166,157);"> Kategori User  </label><br>
             <input type="text" placeholder=" Masukan Nama Toko Anda" required="" autocomplete="off" class="form-control" name="level" id="password" value="Pelapak" readonly="disable"></input><br>

            <label id="passwordd"><img src="png/home.png" style="height: 40px;width: 40px; color:rgb(36,166,157);">Nama Toko </label><br>
             <input type="text" placeholder=" Masukan Nama Toko Anda" required="" autocomplete="off" class="form-control" name="nama_toko" id="password"maxlength="30" minlength="5" ></input><br>

             <label id="passwordd"><img src="png/wa.png" style="height: 40px;width: 40px; color:rgb(36,166,157);"> NO Handphone</label><br>
             <input type="number" placeholder=" Masukan No HP" required="" autocomplete="off" class="form-control" name="no_hp" id="password" maxlength="14"></input><br>

              <label id="passwordd"><img src="png/024-route.png" style="height: 40px;width: 40px; color:rgb(36,166,157);"> Alamat Lengkap</label><br>
              <textarea class="form-control" placeholder="Masukan Alamat Anda" id="alamat" name="alamat" style="height: 100px;"></textarea><br>

              <label id="passwordd"><img src="png/021-user.png" style="height: 40px;width: 40px; color:rgb(36,166,157);"></i> Username</label><br>
               <input type="text" placeholder=" Create Username" required="" autocomplete="off" class="form-control" name="username" id="username" minlength="3" maxlength="15"></input><br>

              <label id="passwordd"><img src="png/031-lock-1.png" style="height: 40px;width: 40px; color:rgb(36,166,157);"> Password</label><br>
              <input type="password" placeholder=" Masukan Password" required="" autocomplete="off" class="form-control" name="password" id="password" minlength="8" maxlength="15"></input><br>

              <label id="passwordd"><img src="png/031-lock-1.png" style="height: 40px;width: 40px; color:rgb(36,166,157);"> Konfirmasi Password</label><br>
                <input type="password" placeholder=" Konfirmasi Password" required="" autocomplete="off" class="form-control" name="password1" id="password"></input><br>
              <select class="icons" name="pilihan" id="username">
                    <option><i class="pe-7s-shopbag"></i> Pilih Jenis Toko</option>
                    <option>Elektronik</option>
                    <option>Kosmetik</option>
                    <option>Product Makanan</option>
                    <option>Fashion</option>
                    <option>Bangunan</option>
                    <option>Lainnya</option>
                </select>
                <br>
              <label id="passwordd"><img src="png/slo.png" style="height: 40px;width: 40px; color:rgb(36,166,157);"> Motto Toko Anda</label><br>
              <textarea class="form-control" placeholder="SLogan Toko" id="alamat" name="slogan" style="height: 100px;" minlength="10" maxlength="30"></textarea><br>
             <input type="hidden" class="form-control" name="date" value="<?php echo date('l, Y-m-d,H:i a'); ?>"></input>
             <button type="submit" name="tombol_daftar" class="btn btn-primary btn-lg" style="height: 50px; width: 400px;float:right;  " id="verifikasi"><i class="pe-7s-paper-plane" style="font-size: 27px;"></i> Create Akun Toko</button><br>
            <a href="index.php" class="btn btn-danger" style="height: 40px; background-color: red;border:none;">Cancel</a>
       </form>
      </div>
    </div>
  </div>
</div>


<div class="bayar">
    <a href="" id="close"><i class="pe-7s-close-circle" style="font-size: 50px; text-align: center; color: red;"></i></a>
  <div class="col-md-5">
     <p style="color: white; margin-top: 100px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>
  <div class="col-md-7"><p style="color: white; margin-top: 100px;">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p></div>
  </div>
 
     
  <div class="jumbotron text-center">
    <a href="" class="btn btn-primary" id="cd">laskar kmakan </a>
    <a href="" class="btn btn-danger toko"></a>
    <a href="" class="btn" id="daftar2"></a>
    <a href="" class="btn btn-danger" data-toggle="modal" data-target="#buat_toko" target="_BLANK" style="transform: scale(0.9); margin-top: 130px; background-color: rgb(172,41,37); font-size: 18px;line-height: 50px; font-weight: bold; box-shadow:rgb(0,0,0,0.3);height: 60px;width: 300px;border-radius: 50px;" id="button-pendaftaran"><i class="ion-android-cart" style="font-size: 30px;"></i>  Belum Ada Toko >></a><br><br><br>
    <p style="font-family: forte; font-size: 24px; transform: scale(0.9); text-shadow: rgb(0,0,0,0.4);">Lorem ipsum dolor sit amet, consectetur dipisicing elit, <br>sed do eiusmod
    tempor incididunt ut labore et<br>Ut enim ad minim veniam Ut enim <br>ad minim veniam  !!!!!!
    </p>
       <form action="" method="post" id="posisi">
        <select class="from-control" id="kategori" style="color:white; border-bottom:15px solid red; background-color: aqua;">
          <option value="" disabled selected>Kategori Barang</option>
          <option style="color: red;">Kosmetik</option>
          <option style="color: red;">Alat Rumah Tangga</option>
          <option style="color: red;">Elektronik</option>
          <option style="color: red;">Hardware Komputer</option>
          <option style="color: red;">Fashion</option>
      </select>       
    </form> 
     
</div>

 <div class="promosi">
  <span class="label label-info balok"></span>  
  <div class="col-md-12">
   <div class="bg text-center" style="font-size: 20px; font-style: italic;background-color:white; width: 100%; position: absolute; top: 0;left: 0;right: 0; box-shadow: 2px 2px 7px rgb(0,0,0,0.4); line-height: 50px;">   -----|||||| Rekomendasi Produck |||||| ------</div><br><br><br>
      <div class="col-md-8 text-left">               
          <p style="background-color: transparent; min-height: 200px; color: white; overflow: hidden;border-radius: 4px;"id="carousel" class="box">

            <img src="../master_shop/gambar/images.png" id="item-1">     
             <img src="../master_shop/gambar/ul.jpg"id="item-2">     
             <img src="../master_shop/gambar/shopping.jpg"id="item-3">
              <img src="../master_shop/gambar/images.png" id="item-4">     
             <img src="../master_shop/gambar/ul.jpg"id="item-5">     
          </p> 
       </div>  

<div class="col-md-4 text-center" style="padding: 5px;">
  <div class="pull-left"></div>
          <p style="background-color: rgb(255,255,255); min-height: 200px; color: rgb(38,166,154,0.8); padding: 5px; border-radius: 4px;" class="pa"><img src="png/023-placeholder.png" style="min-height: 100px;width: 100px;"><br>
          Lorem ipsu5m dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          </p> 
       </div>
   <div class="col-md-4 text-center">
   <!-- <div class="pull-left info"></div> -->
          <p style="background-color: rgb(255,255,255); min-height: 200px; color: rgb(38,166,154,0.8); padding: 5px; border-radius: 4px;" class="pa"><img src="png/global.png" style="height: 100px;width: 100px;"><br>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        
          </p> 
       </div>
<div class="col-md-4  text-center" style="margin-top: 10px;">
    <p style="background-color: rgb(255,255,255); min-height: 200px; color: rgb(38,166,154,0.8); padding: 5px; border-radius: 4px; " class="pa">
    <img src="png/032-lock-2.png" style="height: 100px;width: 100px;"><br>
           Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo.
    </p>      
  </div>
   
<div class="col-md-4 text-center" style="margin-top: 10px;">
  <p style="background-color:  rgb(255,255,255); min-height: 200px; color: rgb(38,166,154,0.8); padding: 5px; border-radius:4px; " class="pa">
    <img src="png/pelapak.png" style="height: 100px;width: 100px;"><br>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
    </p> 
   </div>
  </div>
</div> 




<div class="container">
  <div class="container-fluid">
  <div class="row" style="float: left;padding: 0;">
    <?php while ($row=mysqli_fetch_assoc($sumber_daya)) : ?>
      <div class="col-lg-3 text-left " style="background:linear-gradient(rgb(1,220,245,0.2), white);">
        <div class="card">
          <div class="card-image waves-effect waves-block waves-light">
            <p style="color:white;  font-weight: bold; width: 100%; background:rgb(1,1,100);" class="btn btn-danger"><?php echo $row["nama_barang"]; ?> </p>
                <p class="btn-info" style="border-radius: 50%; height: 50px; width: 50px; position: absolute; top: 20px; left: -5px; font-size:19px; text-align: right; line-height: 50px; background-color: rgb(1,1,107);"><?= $row["diskon"]; ?>%</p>
              <img src="pelapak_gambar/<?php echo $row["gambar"]; ?>" style="height: 250px; width: 250px;" id="gambar" class="img-thumbnail">
                </div>
                  <div class="card-content">
                    <span class="card-title activator blue-text text-darken-4" style="font-size: 15px; font-weight: bold; color:white;"><?php echo $row["jenis_barang"]; ?><i class="material-icons flaticon-menu right"></i></span>
                           <a href="beli.php?id=<?php echo $row["id_tambah"]; ?>" onclick="return confirm('Barang Akan Di Beli');" style=" float: right;">
                       <button type="button" class="btn btn-info" name="tombol_beli" id="jual" ><i class="pe-7s-cart" style="font-size: 20px; font-weight: bold; line-height: 40px;"> Beli Barang</i></button>
                        </a>
                        <button type="button"class="from-control" id="card" name="card_simpan" onclick='addCart("<?php echo $row["id_tambah"]; ?>");'><i class="flaticon-full-shoping-cart" style="height: 90px; margin-left: -21px;"></i>+</button>
                          <a href="" data-toggle="modal" data-target="#datadonatur" style="font-weight: bold; text-align: right;"><i class="pe-7s-cash"></i> Rp. <?php echo $row["harga_barang"]; ?></a>
                        </div>
                        <div class="card-reveal">
                          <span class="card-title grey-text text-darken-4"><i class="material-icons pe-7s-close-circle right"></i></span><br>
                          <p style="color: rgb(38,166,154);"><?php echo $row["deskripsi_barang"]; ?></p>
                        </div>
                      </div> 
                        
                 </div>
          
               <?php endwhile ; ?> 
              <!-- hasil pagination -->

              <?php if ($data_aktif > 1 ) :?>
              <a href="?halaman=<?php echo $data_aktif -1; ?>" class="btn btn-danger" style="background-color: rgb(1,1,100);">&lt Previos</a>
              <?php endif ;?>

              <?php for ($i=1; $i <= $pembagi_data; $i++) :?>

                <?php if ($i == $data_aktif) :?>

                <a href="?halaman= <?php echo $i; ?>" class="btn btn-danger" style="background-color:rgb(1,255,1);"><?php echo $i; ?></a>

                  <?php else: ?>

                <a href="?halaman= <?php echo $i; ?>" class="btn btn-danger" style="background-color: rgb(1,1,100);"><?php echo $i; ?></a>

                <?php endif; ?>
              <?php endfor; ?>


             <?php if ($data_aktif < $pembagi_data ) :?>
              <a href="?halaman=<?php echo $data_aktif +1; ?>" class="btn btn-danger" style="background-color: rgb(1,1,100);">Next &gt</a>
              <?php endif ;?>
          

               </div>
               </div>
           </div>  
            <br><br>

          <div class="footer-c col-md-12">
           
          <div class="modal-header">
            <p style="color: rgb(36,166,157);">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="card" style="height: 400px;">
                 <div class="card-image waves-effect waves-block waves-light" id="card1">
                 <img src="gambar/images.png" style="height: 300px;width: 100%; " >
                    
                    </div>
        <div class="card-content">
          <span class="card-title activator grey-text text-darken-4">Promo Terbaru<i class="material-icons flaticon-menu right"></i></span>
          <p><a href="">This Link Barang</a></p>
        </div>

        <div class="card-reveal">
          <span class="card-title grey-text text-darken-4"><i class="material-icons right">Close</i></span>
          <p style="color: rgb(0,0,0,0.6);">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
          cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
          proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
          </p>
        </div> 

          </div>
            </div>
             <div class="col-md-4 ">
              <div class="card" style="height: 400px;">
                 <div class="card-image waves-effect waves-block waves-light">
                 <img src="png/024-route.png" style="height: 100px;width: 100px; ">
                    </div>
        <div class="card-content">
          <span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons flaticon-menu right"></i></span>
          <p><a href="">This Link Barang</a></p>
        </div>

        <div class="card-reveal">
          <span class="card-title grey-text text-darken-4"><i class="material-icons right">Close</i></span>
          <p style="color: rgb(0,0,0,0.4);">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          </p>
        </div> 

          </div>
            </div>

             <div class="col-md-4">
              <div class="card" style="height: 400px;">
                 <div class="card-image waves-effect waves-block waves-light">
                 <img src="png/024-route.png" style="height: 100px;width: 100px; ">
                    </div>
        <div class="card-content">
          <span class="card-title activator grey-text text-darken-4">Card Title<i class="material-icons flaticon-menu right"></i></span>
          <p><a href="">This Link Barang</a></p>
        </div>

        <div class="card-reveal">
          <span class="card-title grey-text text-darken-4"><i class="material-icons right">Close</i></span>
          <p style="color: rgb(0,0,0,0.4);">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          </p>
        </div> 

          </div>
            </div>
          </div>

        
            
          </div><br><br>
            <footer>

                <div class="col-md-3">
                <br>
                  <div class="bg1"><i class="pe-7s-notebook" style="font-size: 27px;"></i> Support</div>
                    <p style="color: rgb(36,166,157);">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis.</p>
                </div>


                <div class="col-md-3">
                  <br>
                 <div class="bg1"><i class="pe-7s-notebook" style="font-size: 27px;"></i>  Support</div>
                    <p style="color: rgb(36,166,157);">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>

                <div class="col-md-3">
                  <br>
                 <div class="bg1"><i class="pe-7s-notebook" style="font-size: 27px;"></i>  Support</div>
                    <p style="color: rgb(36,166,157);">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>

                   <div class="col-md-3">
                     <br>
                    <div class="bg1"><i class="pe-7s-notebook" style="font-size: 27px;"></i>  Support</div>
                    <p style="color: rgb(36,166,157);">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>

            

                <div class="col-md-3"rgb(36,166,157)>
                  <br>
                 <div class="bg1"><i class="pe-7s-notebook" style="font-size: 27px;"></i>  Support</div>
                    <p style="color: rgb(36,166,157);">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>

                <div class="col-md-3">
                  <br>
                 <div class="bg1"><i class="pe-7s-notebook" style="font-size: 27px;"></i>  Support</div>
                    <p style="color: rgb(36,166,157);">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>

                   <div class="col-md-3">
                     <br>
                    <div class="bg1"><i class="pe-7s-notebook" style="font-size: 27px;"></i>  Support</div>
                    <p style="color: rgb(36,166,157);">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                    consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
                    cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                    proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </div>
               
                

                <p style="text-align: center; color: aqua; font-weight: bold;text-decoration: underline;"><i class="pe-7s-paper-plane" style="font-size: 27px;"></i> CopyRight Rahmad Riyadi | Hak Cipta Di Miliki Master_Shop</p><br>
            </footer> 
              <div class="backtop"><i class="pe-7s-upload" style="font-size: 60px; background-color:rgb(38,166,154);  color: white; box-shadow: 3px 3px 4px white;"></i>
            </div>
          
        
      <!-- <div id="callback-output"></div> -->
            <!-- menu bawah -->           
</body>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/cari.js"></script>

<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="js/materialize.js"></script>
<script type="text/javascript" src="js/jquery.waterwheelCarousel.js"></script>
<!-- <script type="text/javascript" src="js/sweetalert.js"></script> -->
<script type="text/javascript">
</script>
</html>

