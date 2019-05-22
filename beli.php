<?php 
session_start();
require 'pelapak.php';

if (isset($_SESSION["login"])) {
 header("location:pelapakk.php");
 exit;
}

if (isset($_POST["tombol_beli"])) {
  if (beli_barang($_POST) > 0) {
  echo"<script>alert('Biodata anda berhasil di kirim ke kami');
    document.location.href='index.php';
    </script>"; 
  }

  else{

     echo"<script>alert('Data Gagal Di kirim 404 not found');
    document.location.href='index.php';
    </script>";

  }
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

          // check ingat saya//

          if (isset($_POST["ingat_saya"])) {
           setcookie('login_ingat_saya', 'true',time() + 60);
          }

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
$get_data=$_GET["id"];
$data_query_barang=mysqli_query($koneksi,"SELECT * FROM barang WHERE id_tambah='$get_data'");
$data_row=mysqli_fetch_assoc($data_query_barang);
 $kunci=$data_row["nama_toko"];
 $query_pelapak=mysqli_query($koneksi,"SELECT * FROM data_pelapak WHERE nama_toko_atau_tujuan_donatur='$kunci'"); 
 $data_row_pelapak=mysqli_fetch_assoc($query_pelapak);
 $kode_akses_barang=uniqid();
 $_SESSION["kode"]=$kode_akses_barang;


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

    <link rel="stylesheet" type="text/css" href="../master_shop/css/materialize.css">
    <link rel="stylesheet" type="text/css" href="../master_shop/css/bootstrap.min.css">
    <link href="../master_shop/assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="../master_shop/css/sweetalert.css">
    <link rel="stylesheet" type="text/css" href="../master_shop/css/font/flaticon.css">
    <link rel="stylesheet" href="../master_shop/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="../master_shop/css/style.css">
  
</head>
<body>



 <div class="navbar-fixed" style="background-color: transparent;position: absolute;">
 <nav>
  <div class="nav-wrapper">

    <a href="#!" class="brand-logo">
      
       <a href="" style="font-size: 18px; font-family: forte; color: white; text-shadow: 3px 3px 5px black;" data-toggle="modal" data-target="#pencarian"><img src="png/008-search.png" style="height: 40px;width:40px; "></a> 

        <span style=" position: relative; cursor: pointer;"> <img src="../master_shop/png/toko.png" style="height: 30px;" id="sentuh">
        <span class="label label-info" style="position: absolute; top: -16px; right: -6px;"></span></span>

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
        <li><a href="index.php" style="font-size: 18px; font-family: forte;color: rgb(171,41,37);"><img src="../master_shop/png/home.png" style="height: 30px;"> Home</a></li>    
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

 <div class="alert alert-danger" id="message">
 <a href="javascript:void(0)">&times</a>
</div>

 <div class="col-md-3" id="cart_shop">
    <a href="javascript:void(0)" style="font-size: 38px; float: left;height: 40px; width: 40px; text-align: center;line-height: 40px; color: red;opacity: 1;" class="tutup">&times</a> <br>
    <h2 class="modal-title" style="color: rgb(36,166,157); font-size: 20px;margin-top: 20px; text-align: center;">List Belanja</h2> <br>
 </div>
 
<div id="loginmodal" class="modal fade" style="background:transparent;padding: 0;">
  <div class="modal-dialog">
   <!--  <div class="modal-content"> -->
   <div class="modal-header" style="box-shadow: none; border:none;">
     <a href="" data-dismiss="modal" style="font-size: 53px;color: red;">&times</a>
   </div>
      <div class="modal-body">
            <form action="" method="post">
               <label id="usernamee"><i class="pe-7s-tools" style="font-size: 25px;color:#0f0;"></i> Level</label><br>
               <select class="icons" name="pilihannn" id="username" type="text">
                  <option><i class="pe-7s-shopbag"></i> Kategori</option>
                   <option>donatur</option>
                    <option>pelapak</option>
                
                </select>
                <br> 

      <label id="usernamee" class="hasil" style="color:rgb(36,166,157); font-size: 18px;font-style: italic;"><img src="png/020-man.png" style="height: 40px;width: 40px;"></label>
           <input type="text" placeholder=" Masukan Username" required="" autocomplete="off" class="form-control masuk" name="usernamee" id="username"></input><br>
           <label id="passwordd"><img src="png/032-lock-2.png" style="height: 40px;width: 40px;">  Password</label>
             <input type="password" placeholder=" Masukan Password" required="" autocomplete="off" class="form-control keluar" name="passworddd" id="password"></input><br>

           <label>
             <input class="filled-in" type="checkbox" checked="checked" name="ingat_saya"></input>
             <span style="color:rgb(36,166,157)">Ingat Saya</span>
           </label>

             <button type="submit" style="height: 60px;" name="submitt" class="btn" style="background-color: rgb(1,1,100);"><i class="pe-7s-paper-plane" style="font-size: 27px;"></i> Sig In</button>

              
       </form>
      </div>
  <!--   </div> -->
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
       <h4 class="modal-title" style="color:white; font-family: forte;">Masukan keyword Pencarian Contoh : elektronik, kosmetik dll</h4><br>
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

           <label id="passwordd"><i class="pe-7s-home" style="font-size: 25px;color:#0f0;"></i> Tujuan Donasi  </label><br>
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

            <label id="passwordd"><img src="png/user.png" style="height: 40px;width: 40px; color:rgb(36,166,157);"> Kategori User </label><br>
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

<!-- data Pembelian isi biodata -->

<div id="beli_barang" class="modal fade" role="dialog" style="width: 90%; background-color:rgb(1,1,70);">
  <div class="modal-dialog" style="width: 100%; margin-left: auto; margin-right: auto;">
    <div class="modal-content">
      <div class="modal-header" style="background-color:#00c0ef; border-bottom: 13px solid gold;">
        <a href="" class="close"><i class="pe-7s-close-circle" style="font-size: 45px; color: red;" data-dismiss="modal"></i></a>
        <h4 class="modal-title"> Isi Data Formulir Pembelian Barang Dengan Benar,Untuk Memudahkan Pelapak Dalam Melakukan Pengiriman Barang</h4>
      </div>
      <div class="modal-body">
         <form action="" method="post" enctype="multipart/form-data">
          <div class="row">
            <div class="col-md-7">
 
                <label id="usernamee"><i class="pe-7s-users" style="font-size: 25px; color: #0f0;"></i> Foto Profile Anda</label><br>
                <input type="file" name="foto_pembeli" class="form-control" id="username"></input>
                <br>
             <label id="usernamee"><i class="pe-7s-users" style="font-size: 25px; color: #0f0;"></i> Nama Lengkap Customer</label><br>
           <input type="text" placeholder=" Nama Lengkap" required="" autocomplete="off" class="form-control" name="nama_lengkap_c" id="username"></input><br>


           <label id="passwordd"><i class="pe-7s-home" style="font-size: 25px; color: #0f0;"></i> Nama Panggilan </label><br>
             <input type="text" placeholder=" Nama Panggilan" required="" autocomplete="off" class="form-control" name="nama_panggilan" id="password"></input><br>

             <label id="passwordd"><i class="pe-7s-call" style="font-size: 25px; color: #0f0;"></i> NO Handphone</label><br>
             <input type="number" placeholder=" Masukan No HP" required="" autocomplete="off" class="form-control" name="no_hpp" id="password"></input><br>

              <label id="passwordd"><i class="pe-7s-map-marker" style="font-size: 25px; color: #0f0;"></i> Alamat Lengkap</label><br>
              <textarea class="form-control" placeholder="Masukan Alamat Anda" id="alamat" name="alamat_l" style="height: 100px;"></textarea><br>

                <label id="passwordd"><i class="pe-7s-user" style="font-size: 25px; color: #0f0;"></i> Provinsi</label><br>
               <input type="text" placeholder=" provinsi" required="" autocomplete="off" class="form-control" name="provinsi" id="username"></input><br>

                <label id="passwordd"><i class="pe-7s-door-lock" style="font-size: 25px; color: #0f0;"></i>Kabupaten</label><br>
                <input type="text" placeholder=" Masukan Nama Kabupaten Anda" required="" autocomplete="off" class="form-control" name="kabupaten" id="password"></input><br>

                <label id="passwordd"><i class="pe-7s-door-lock" style="font-size: 25px; color: #0f0;"></i> Kecamatan</label><br>
                <input type="text" placeholder=" Kecamatan" required="" autocomplete="off" class="form-control" name="kecamatan" id="password"></input><br>

                 <label id="passwordd"><i class="pe-7s-door-lock" style="font-size: 25px; color: #0f0;"></i>Kode Pos</label><br>
                <input type="number" placeholder=" Masukan Kode Post" required="" autocomplete="off" class="form-control" name="kode_post" id="password"></input><br>

                <label id="passwordd"><i class="pe-7s-users" style="font-size: 25px; color: #0f0;"></i> kode akses </label><br>
             <input type="text"required="" autocomplete="off" class="form-control" name="kode_belanja" id="password" value="<?php echo $kode_akses_barang; ?>" readonly="disable"></input><br>

             <label id="passwordd"><i class="pe-7s-users" style="font-size: 25px; color: #0f0;"></i> pemilik akun </label><br>

             <input type="text" placeholder=" Masukan Nama Toko Anda" required="" autocomplete="off" class="form-control" name="pemilik" id="password" value="<?php echo $data_row["pemilk"]; ?>" readonly="disable"></input><br>


             </div>

          <div class="col-md-4" style="border-left:10px solid white;">
           <div class="bg" style="height: 40px; width: 100%; background:rgb(1,1,70); box-shadow: 1px 1px 4px white; text-align: center; line-height: 40px; font-size: 19px; color: white;">List Belanja </div><br>

            <label id="toko" style="color:rgb(38,166,154); text-align: left;font-size: 16px; float: left;"> Nama Toko</label><br>
               <input type="text" class="form-control" name="name_toko" value=" <?php echo $data_row["nama_toko"]; ?>" readonly="disable"></input><br>

                <label id="toko"  style="color:rgb(38,166,154); text-align: left;font-size: 16px; float: left;"> Barang Yang Di Beli</label><br>
               <input type="text" class="form-control" name="nama_barang_beli" value=" <?php echo $data_row["nama_barang"]; ?>" readonly="disable"></input>

               <img src="pelapak_gambar/<?php echo $data_row["gambar"]; ?>" style="width: 320px; height: 200px;" class="img-thumbnail"><br><br>

                  <label id="toko"  style="color:rgb(38,166,154); text-align: left;font-size: 16px; float: left;"> Harga Barang</label><br>
               <input type="text" class="form-control" name="harga_barang" value="Rp. <?php echo $data_row["harga_barang"]; ?>" readonly="disable"></input>

                  <label id="toko"  style="color:rgb(38,166,154); text-align: left;font-size: 16px; float: left;">Jenis Barang</label><br>
               <input type="text" class="form-control" name="jenis_produk" value=" <?php echo $data_row["jenis_barang"]; ?>" readonly="disable"></input>
       </div>
      </div>

       <button type="submit" name="tombol_beli" class="btn btn-primary btn-lg" style="height: 60px; background-color: rgb(38,166,154); border:none;"><i class="pe-7s-paper-plane" style="font-size: 27px;"></i> Send Data</button>
         
       </form>
      
      
     
      </div>
    </div>
  </div>
</div>
<!-- end biodata -->



 
     
    <div class="jumbotron text-center" style="height: 400px; s">
        <a href="" class="btn btn-primary" id="cd">laskar kmakan </a>
        <a href="" class="btn btn-danger toko"></a>
        <a href="" class="btn" id="daftar2"></a>  
  </div>
  <div class="row" style="position: absolute; top:210px; width: 90%; margin: 10px; ">
    <div class="col-lg-4 col-lg-offset-2 text-center" style="box-shadow: 2px 2px 5px rgb(0,0,0,0.2); background-color: white;transform: rotate(-10deg);">
     <div class="box">
       <div class="box-header">
         <div class="bg" style="height: 40px; width: 100%; background-color: rgb(1,1,80); line-height: 40px; font-size: 19px; color: white;">Daftar Belanja </div>
       </div>
       <div class="box-body">
      
         <p style="color:rgb(36,166,157); font-weight: bold; font-size: 21px;"><?php echo $data_row["nama_barang"]; ?></p>
          <img src="pelapak_gambar/<?php echo $data_row["gambar"]; ?>" class="img-thumbnail" style="height: 200px;width: 200px;">
          <p style="color:rgb(36,166,157); font-weight: bold;">Merek Barang    | <?php echo $data_row["merek_barang"]; ?></p>
          <p style="color:rgb(36,166,157); font-weight: bold;">Harga Barang    | <?php echo $data_row["harga_barang"]; ?></p>
          <p style="color:rgb(36,166,157); font-weight: bold;">kondisi Barang  | <?php echo $data_row["kondisi_barang"]; ?></p>
          <p style="color:rgb(36,166,157); font-weight: bold;">Jenis Barang    | <?php echo $data_row["jenis_barang"]; ?></p>
         <div class="box-footer"><a href="" class="btn btn-success" data-toggle="modal" data-target="#beli_barang">Isi Biodata Pembeli</a></div><br>
       </div>
     </div>
    </div><br>
    <div class="col-lg-4 col-lg-offset-2" style="box-shadow: 2px 2px 5px rgb(0,0,0,0.2); background-color: white;">
     <div class="box">
       <div class="box-header">
         <h4>Biodata Pelapak</h4>
         <h5>Simpan Kode Belanja Di Bawah</h5>
       </div>
       <div class="box-body">
          <p style="color:rgb(36,166,157); font-weight: bold;">Pemilik Toko / Akun Pelapak : <?php echo $data_row["pemilk"]; ?></p>
           <p style="color:rgb(36,166,157); font-weight: bold;">Nama Toko : <?php echo $data_row["nama_toko"]; ?></p>
            <p style="color:rgb(36,166,157); font-weight: bold;">No Handphone : <?php echo $data_row_pelapak["no_hp"]; ?></p>
            <label style="color:red; font-size: 13px; text-align: left; margin-left: 0;">Kode Belanja</label>
            <input type="text" class="form-control" readonly="disable" value="<?php echo $kode_akses_barang; ?>"></input>
            <h3 style="color:red;">Warning !!</h3>
            <a href="cetak_kode.php?kode='<?php echo $kode_akses_barang; ?>'" class="btn btn-warning" id="kode">Save Kode</a>
           <p class="alert-danger" style="padding: 10px;">Simpan Kode Belanja Di Atas Untuk Syarat Melaporkan Pelapak Ke Admin Web jika Barang Belum Di Kirim Lebih Dari 2 Hari</p>
       </div>
     </div>
    </div>
  </div><br><br>
  <div class="fg" style="height: 300px;width: 100%;background:linear-gradient(rgb(255,0,255,0.6),white);"></div>

            <div class="backtop"><i class="pe-7s-upload" style="font-size: 60px; background-color:rgb(38,166,154);  color: white; box-shadow: 3px 3px 4px white;"></i></div>
        
      <!-- <div id="callback-output"></div> -->
            <!-- menu bawah -->           
</body>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/cari.js"></script>
<script type="text/javascript" src="js/sweetalert.js"></script>
<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="js/materialize.js"></script>
<script type="text/javascript" src="js/jquery.waterwheelCarousel.js"></script>
</html>

