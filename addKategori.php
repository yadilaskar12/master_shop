<?php 
session_start();

require 'pelapak.php';

if (!isset($_SESSION["login"])) {
  header("location:index.php");
  exit;
}

$toko= $_SESSION["nama_toko"];

$query= mysqli_query($koneksi,"SELECT nama_toko,jenis_barang,merek_barang,kondisi_barang,nama_barang,harga_barang,stok_barang,gambar,deskripsi_barang,waktu,diskon FROM barang WHERE nama_toko='$toko'");


            if (isset($_POST["simpan_data"])) {

              if (addKategori($_POST) > 0) {
                echo"<script>alert('Kategori Berhasil Di Tambahkan');
                document.location.href='addKategori.php';
                </script>";
                exit();
              }else{
                echo"<script>alert('Data Gagal Di Input');
                document.location.href='addKategori.php';
                </script>";
                exit();
              }
            }

$riwayat=mysqli_query($koneksi,"SELECT * FROM add_kategori WHERE nama_username_toko='$toko'");



 ?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Data Tables</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../master_shop/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../master_shop/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../master_shop/bower_components/Ionicons/css/ionicons.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="../master_shop/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../master_shop/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../master_shop/dist/css/skins/_all-skins.min.css">
    <link href="../master_shop/assets/css/pe-icon-7-stroke.css" rel="stylesheet" />


  <!-- Google Font -->
  <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
       <link rel="stylesheet" type="text/css" href="../master_shop/css/bootstrap.min.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../../index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b><?php echo $_SESSION["nama_toko"]; ?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">

        <ul class="nav navbar-nav">
        <li><a href="logout.php" style="font-size: 15px;" onclick="return confirm('hallo <?php echo $_SESSION["nama_lengkap"]; ?>, Yakin Anda Ingin Logout Dari Akun Anda ?...');"><i class="fa fa-warning text-yellow" style="color: white;"></i> Logout</a></li>
          <!-- Messages: style can be found in dropdown.less-->
         <!--  -->
          <!-- Notifications: style can be found in dropdown.less -->
         
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
 
              <span class="hidden-xs"><?php echo $_SESSION["nama_lengkap"] ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

                <p>
                  Alexander Pierce - Web Developer
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Body -->
              <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div>
                <div class="pull-right">
                  <a href="#" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="../master_shop/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION["nama_lengkap"]; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Data Statistik</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="pelapakk.php"><i class="fa fa-circle-o"></i> Progess Penjualan</a></li>
      
          </ul>
         </li>

         <li class="treeview">
          <a href="#">
            <i class="fa fa-table"></i> <span> Data Barang</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          	<li><a href="data.php"><i class="fa fa-circle-o"></i>Upload Barang</a></li>
          </ul>
        </li>
       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <section class="content-header">
      <h1>
        Tambah Kategori
        <small>Jika Belum Ada Di Daftar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Barang</a></li>
        <li class="active">Data Tambah Kategori</li>
      </ol>
    </section>

    <section class="content">
      <div class="row">
        <div class="col-lg-6">
          <div class="box">
            <div class="box-header"><h4 class="box-title" style="font-weight: bold;">Add Kategori</h4></div>
            <div class="box-body">
           
              <form action="" method="post">
               <div class="form-group">
                <label>Kode Kategori :</label>
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-hourglass-2"></i>
                  </div>
                  <input type="text" class="form-control" value="<?php echo uniqid(); ?>" name="kode_kategori" readonly="disable"></input>
                </div> 
               </div>

               <div class="form-group">
                <label>Input Kategori :</label>
                 <div class="input-group">
                   <div class="input-group-addon">
                     <i class="glyphicon glyphicon-plus"></i>
                   </div>
                   <input type="text" name="name_kategori" class="form-control" placeholder="input_kategori" required="" maxlength="30" minlength="4"></input>
                 </div>
               </div>

                <div class="form-group">
                <label>Nama Toko :</label>
                 <div class="input-group">
                   <div class="input-group-addon">
                     <i class="glyphicon glyphicon-home"></i>
                   </div>
                   <input type="text" name="pemilik_toko" class="form-control" readonly="disable" required="" maxlength="30" minlength="4" value="<?= $_SESSION["nama_toko"]; ?>"></input>
                 </div>
               </div>


               <div class="form-group">
                 <label>Waktu Upload :</label>
                 <div class="input-group">
                   <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                   </div>
                  <input type="date" name="date_waktu" class="form-control" placeholder="Input Kategrori" required=""></input>
                 </div>
               </div>
               <div class="box-footer">
                  <button type="submit" class="btn btn-primary" name="simpan_data" style="float: right; font-weight: bold;"><i class="glyphicon glyphicon-share"></i> Save Data</button> 
               </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="box">
            <div class="box-header"><h4 class="box-title" style="font-weight: bold;">Riwayat Penambahan Kategori</h4></div>
            <div class="box-body">
              <form action="" method="post">
                   <div class="form-group">
               
                 <div class="input-group">
                   <div class="input-group-addon">
                      <i class="glyphicon glyphicon-search"></i>
                   </div>
                  <input type="text" name="date_waktu" class="form-control" placeholder="Cari Kategrori"></input>
                 </div>
               </div>
              </form>
              <div class="content table-responsive table-full-width">
               <table class="table table-bordered table-hover">
                
                <thead>
                  <tr>
                  <th>No <i class="glyphicon glyphicon-leaf"></i></th>
                  <th>Kode Kategori <i class="glyphicon glyphicon-leaf"></i></th>
                  <th>Kategori <i class="glyphicon glyphicon-leaf"></i></th>
                  <th>Waktu <i class="glyphicon glyphicon-leaf"></i></th>
                   <th>Opsi </th>
                  </tr>
                </thead>
                <tbody>
                <?php $no=1; ?>
                <?php while ($data_row=mysqli_fetch_assoc($riwayat)): ?>
                <tr>
                  <td><?= $no++?></td>
                  <td><?= $data_row["kode_kategori"]; ?></td>
                  <td><?php echo $data_row["nama_kategori"]; ?></td>
                  <td><?php echo $data_row["waktu_kategori"]; ?></td>
                  <td align="center"><a href="file_hapus/hapus_kategori.php?id_kategori=<?php echo $data_row["id_kategori"]; ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
                </tr>
                 <?php endwhile; ?>
                </tbody>
              </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
 
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
 
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="../master_shop/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../master_shop/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="../master_shop/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="../master_shop/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../master_shop/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../master_shop/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../master_shop/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../master_shop/dist/js/demo.js"></script>
<!-- page script -->
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
</body>
</html>
