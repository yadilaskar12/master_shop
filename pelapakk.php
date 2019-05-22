 <?php 
session_start();

require 'pelapak.php';

if (!isset($_SESSION["login"])) {

  header("location:index.php");
  exit;

}

$kirim_barang= $_SESSION["nama_lengkap"];
$foto_profile=$_SESSION["profile"];
$ubah_profile=$_SESSION["profile"];
$id_pelapak=$_SESSION["id"];
$nama_toko=$_SESSION["nama_toko"];
$alamat_lengkap=$_SESSION["alamat_lengkap"];
$no_hp=$_SESSION["hp"];
$motto=$_SESSION["motto"];

$query_pelapak=mysqli_query($koneksi,"SELECT * FROM data_pelapak WHERE nama_pelapak_atau_nama_donatur='$kirim_barang'")or die(mysqli_error($koneksi));
$query_barang_pembeli= mysqli_query($koneksi,"SELECT * FROM pembelian_barang WHERE pemilik_akun='$kirim_barang'"); 

$data_lengkap=  mysqli_query($koneksi,"SELECT pemilik_akun,nama_pembeli,nama_panggilan,alamat_lengkap,no_hp,provinsi,kabupaten,kecamatan,produk_terjual,harga_produk,jenis_produk,profil_pembeli,kode_pos  FROM pembelian_barang WHERE pemilik_akun='$kirim_barang' ");

$hasil_data=  mysqli_query($koneksi,"SELECT pemilik_akun,nama_pembeli,nama_panggilan,alamat_lengkap,no_hp,provinsi,kabupaten,kecamatan,produk_terjual,harga_produk,jenis_produk,id_pembelian FROM pembelian_barang WHERE pemilik_akun='$kirim_barang'");

$data_untuk_apdate=mysqli_fetch_assoc($query_pelapak);

$nama=$data_untuk_apdate["nama_pelapak_atau_nama_donatur"];
$id=$data_untuk_apdate["id_pelapak"];
$nama_toko_anda=$data_untuk_apdate["nama_toko_atau_tujuan_donatur"];
$hp=$data_untuk_apdate["no_hp"];
$alamat_lengkap_pelapak=$data_untuk_apdate["alamat_lengkap"];
$kategori_toko=$data_untuk_apdate["pilihan"];
$motto_amanat=$data_untuk_apdate["motto_amanat"];
$profile=$data_untuk_apdate["foto"];

 


if (isset($_POST["tombol_edit"])) {

  if (edit_profile_toko($_POST) > 0) {
 
    echo"<script>alert('Data Berhasil Di Ubah');
    document.location.href='pelapakk.php';

    
    </script>";

    exit();
  }else{

     echo"<script>alert('Data Gagal Di Ubah');
    document.location.href='pelapakk.php';
    </script>";
    exit();
  }

}






  ?>



<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>DASHBOARD ADMIN</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../master_shop/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../master_shop/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../master_shop/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../master_shop/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../master_shop/dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="../master_shop/bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="../master_shop/bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="../master_shop/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="../master_shop/bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="../master_shop/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link href="../master_shop/assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
   
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="index2.html" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>LT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin</b>LTE</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         <li><a href="logout.php" style="font-size: 15px;" onclick="return confirm('Hallo <?php echo $_SESSION["nama_lengkap"]; ?>, Yakin Anda Ingin Logout Dari Akun Anda ?...');"><i class="fa fa-warning text-yellow" style="color: white;"></i> Logout</a></li>
          <!-- daftar pembeli -->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="ion ion-bag"></i>
              <?php $hitung= mysqli_num_rows($query_barang_pembeli); ?>
              <span class="label label-info"><?php echo $hitung; ?></span>
            </a>

            <ul class="dropdown-menu">
              <li class="header">Kamu Dapat <?php echo $hitung; ?> Pembeli</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">

                <?php while($pengambilan_data= mysqli_fetch_assoc($query_barang_pembeli)): ?>
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="foto_pembeli/<?php echo $pengambilan_data["profil_pembeli"]; ?>" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        <?php echo $pengambilan_data["nama_pembeli"]; ?>
                        <small><i class="fa fa-clock-o"></i> <?php echo date('l'); ?></small>
                      </h4>
                      <p>Customer Anda</p>
                    </a>
                  </li>

                <?php endwhile ; ?>
                  <!-- end message -->
                  
                 
      
                </ul>
              </li>

          
              <!-- <li class="footer"><a href="#" data-toggle="modal" data-target="#lihat_data">Lihat Semua Data Customer ></a></li> -->
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Anda Mendapat 10 Notifikasi Peringatan Dari Admin !!</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i><?php echo $_SESSION["nama_lengkap"]; ?>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
              <span class="hidden-xs">Alexander Pierce</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

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

       <img src="foto_profile_toko/<?php echo $foto_profile; ?>" alt="User Image" style="height: 80px; width: 80px; border:3px solid white;" class="img-circle">

  
          <a href="#" style="font-weight: bold; color: white;"><i class="fa fa-circle text-success"></i> <?php echo $_SESSION["nama_lengkap"];   ?></a><br>
         <a href="" style="color: #0f0;"><i class="fa fa-circle text-success"></i>    Online</a> 
         <a href="" data-toggle="modal" data-target="#profile_pelapak"><i class="fa fa-circle text-success"></i> Profile Data</a>

        <div class="pull-left image">
         
        </div>
        <div class="pull-left info">
               <p></p>
        </div>
      </div>
       
      </form>
      <!-- /.search form -->

      <!-- Menu  -->




      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Data Statistik</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
           <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o"></i> Progess Penjualan</a></li>
      
          </ul>
        </li>  
       
        <li class="treeview">
          <a href="data.php">
            <i class="fa fa-table"></i> <span> Data Barang</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
         <ul class="treeview-menu">
            <li><a href="data.php"><i class="fa fa-circle-o"></i>Upload Barang</a></li>
            <li><a href="addKategori.php"><i class="fa fa-circle-o"></i>Tambah Kategori Barang</a></li>
          </ul>
          </li>
      </ul>
    </section>
    <!-- end menu -->





  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>

    <!-- content utama -->




    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3><?php echo $hitung; ?></h3>

              <p>Data Pelanggan Baru</p>
            </div>
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer" data-toggle="modal" data-target="#hasil_data">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>53<sup style="font-size: 20px">%</sup></h3>

              <p>Bounce Rate</p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>Cetak Data Pelanggan</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#"class="small-box-footer" data-toggle="modal" data-target="#lihat_data">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>









        <!-- end content utama -->
      </div>
      <!-- /.row -->
      <!-- Main row -->
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          <div class="nav-tabs-custom">
            <!-- Tabs within a box -->
            <ul class="nav nav-tabs pull-right">
              <li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>
              <li><a href="#sales-chart" data-toggle="tab">Donut</a></li>
              <li class="pull-left header"><i class="fa fa-inbox"></i> Sales</li>
            </ul>
            <div class="tab-content no-padding">
              <!-- Morris chart - Sales -->
              <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
              <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
            </div>
          </div>
          <!-- /.nav-tabs-custom -->

          <!-- Chat box -->
          <div class="box box-success">
            <div class="box-header">
              
            </div>
          </div>
          <!-- /.box (chat box) -->

          <!-- TO DO List -->
          <div class="box box-primary">
            <div class="box-header">
              \
            </div>
          </div>
          <!-- /.box -->

          <!-- quick email widget -->
          <div class="box box">
            <div class="box-header">
             
            </div>
          </div>

        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

          <!-- Map box -->
          <div class="box box-solid bg-light-blue-gradient">
            <div class="box-header">
              <!-- tools box -->
              
            </div>
          </div>
          <!-- /.box -->

          <!-- solid sales graph -->
          <div class="box box-solid bg-teal-gradient">
            <div class="box-header">
              <i class="fa fa-th"></i>

              <h3 class="box-title">Sales Graph</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn bg-teal btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn bg-teal btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <div class="box-body border-radius-none">
              <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer no-border">
              <div class="row">
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <input type="text" class="knob" data-readonly="true" value="20" data-width="60" data-height="60"
                         data-fgColor="#39CCCC">

                  <div class="knob-label">Mail-Orders</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 text-center" style="border-right: 1px solid #f4f4f4">
                  <input type="text" class="knob" data-readonly="true" value="50" data-width="60" data-height="60"
                         data-fgColor="#39CCCC">

                  <div class="knob-label">Online</div>
                </div>
                <!-- ./col -->
                <div class="col-xs-4 text-center">
                  <input type="text" class="knob" data-readonly="true" value="30" data-width="60" data-height="60"
                         data-fgColor="#39CCCC">

                  <div class="knob-label">In-Store</div>
                </div>
                <!-- ./col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->

          <!-- Calendar -->
          <div class="box box-solid bg-green-gradient">
            <div class="box-header">
              
            </div>
          </div>
          <!-- /.box -->

        </section>
        <!-- right col -->
      </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
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
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>
                
              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>

<!-- ./wrapper -->

<div id="lihat_data" class="modal fade" role="dialog">

  <div class="modal-dialog" style="width: 88%;">
    <div class="modal-content" style="width: 100%;">
      <div class="modal-header">

      <h4 class="modal-title">Data Para Pelanggan</h4><br>
           <a href="" class="close"><i class="pe-7s-close-circle" style="font-size: 45px; color: red;" data-dismiss="modal"></i></a>
          <a href="print_data_pembeli.php" class="btn btn-warning"><i class="pe-7s-print" style="font-size: 25px;"></i> Cetak Data</a>
        </div>
        <div class="modal-body">
          <div class="row">
           <?php while ($ambil=mysqli_fetch_assoc($data_lengkap)) :?>
            <div class="col-md-4" style="float: left;">
            <img src="foto_pembeli/<?= $ambil["profil_pembeli"] ?>" class="img-thumbnail" height="100" width="200">
              <h3 style="font-weight: bold; font-style: underline;">BIODATA PELANGGAN</h3>
              <p style=" font-size: 15px;"> Nama Lengkap    : <?php echo $ambil["nama_pembeli"] ; ?></p>
              <p style=" font-size: 15px;"> Nama Panggilan     : <?php echo $ambil["nama_panggilan"] ; ?></p>
              <p style=" font-size: 15px;"> No Handphone      : <?php echo $ambil["no_hp"] ; ?></p>
              <p style=" font-size: 15px;"> Provinsi      : <?php echo $ambil["provinsi"] ; ?></p>
              <p style=" font-size: 15px;"> Kabupaten      : <?php echo $ambil["kabupaten"] ; ?></p>
              <p style=" font-size: 15px;"> Kecamatan     : <?php echo $ambil["kecamatan"] ; ?></p>
              <p style=" font-size: 15px;"> Kode Post     : <?php echo $ambil["kode_pos"]; ?></p>
               <p style=" font-size: 15px;"> Alamat Lengkap   : <?php echo $ambil["alamat_lengkap"] ; ?></p><br>

             <h4>Daftar belanja</h4>

          <p>Nama Barang          : <?php echo $ambil["produk_terjual"]; ?> </p>
          <p>Harga barang    : <?php echo $ambil["harga_produk"]; ?></p>
          <p>jenis Barang          : <?php echo $ambil["jenis_produk"]; ?></p>
          <br>
          <hr>
        </div>
        <?php endwhile; ?>
      </div>
           
     

        </div>
      </div>
    </div>
</div>


<!-- Data pembeli -->


  <div id="hasil_data" class="modal fade" role="dialog">

  <div class="modal-dialog" style="width: 95%;">
    <div class="modal-content" style="width: 100%;">
      <div class="modal-header">

      <h4 class="modal-title">Data Para Pelanggan
        
      </h4>
           <a href="" class="close"><i class="pe-7s-close-circle" style="font-size: 45px; color: red;" data-dismiss="modal"></i></a>
        </div>
        <div class="modal-body">

        
       


         <div class="content table-responsive table-full-width">

         <p style="font-weight: bold; color: red;">TOTAL PELANGGAN : <?php echo $hitung; ?> ORANG</p>
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <th>ID</th>
                                        <th class="warning">Nama Customers</th>
                                        <th class="danger">Nama Panggilan</th>
                                        <th class="success">Alamat Lengkap</th>
                                        <th class="primary">No Handphone</th>
                                        <th class="warning">Provinsi</th>
                                        <th class="danger">Kabupaten</th>
                                        <th class="success">Kecamatan</th>
                                        <th class="primary">Barang Yg Di Beli</th>
                                        <th class="danger">Harga (Rp.)</th>
                                        <th class="info">Jenis Barang</th>
                                        <th class="danger">Opsi</th>
                                    </thead>
                                    <tbody>
                                    <?php $no= 1; ?>
                                    <?php while ($data=mysqli_fetch_assoc($hasil_data)) :

                                 
                                    ?>
                                        <tr>
                                          <td><?php echo $no ; ?></td>
                                          <td><?php echo $data["nama_pembeli"]; ?></td>
                                          <td><?php echo $data["nama_panggilan"]; ?></td>
                                          <td><?php echo $data["alamat_lengkap"]; ?></td>
                                          <td><?= $data["no_hp"] ?></td>
                                          <td><?php echo $data["provinsi"]; ?></td>
                                          <td><?php echo $data["kabupaten"]; ?></td>
                                          <td><?php echo $data["kecamatan"]; ?></td>
                                          <td><?php echo $data["produk_terjual"]; ?></td>
                                          <td><?php echo $data["harga_produk"]; ?></td>
                                          <td><?php echo $data["jenis_produk"]; ?></td>
                                          <td><a href="file_hapus/delete_pembeli.php?id=<?php echo $data["id_pembelian"]; ?>"onclick="return confirm('Data Anda Akan Di Hapus');" class="btn btn-danger"><i class="pe-7s-trash" style="font-size: 24px;"></i> Delete</a></td>
                                        </tr>
                                        <?php $no ++; ?>
                                       <?php endwhile ; ?>

                                    </tbody>
                                </table>

                            </div>


          

          
        </div>
     
    </div>
  
    </div>
  
</div>




<!-- end data pembeli -->

<!-- data profile pelapak -->


 <div id="profile_pelapak" class="modal fade" role="dialog">

  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

      <h4 class="modal-title">Biodata Pelapak
        
      </h4>
      <span>Data Ini Berdasarkan data yang anda inputkan pada saat pendaftran,jika ada kesalahan data dapat anda ubah</span>
           <a href="" class="close"><i class="pe-7s-close-circle" style="font-size: 45px; color: red;" data-dismiss="modal"></i></a>
        </div>
        <div class="modal-body text-left">

       <div class="pull-center"> <img src="foto_profile_toko/<?php echo $foto_profile; ?>" class="img-circle" style="height: 200px; width: 200px; border:4px solid rgb(0,0,0,0.4); box-shadow: 2px 2px 5px black; margin-left: 26%;"></div><br>

       Nama Lengkap      : <p style="font-weight: bold;"><?php echo $_SESSION["nama_lengkap"]; ?></p>
       Nama Toko         : <p style="font-weight: bold;"> <?php echo $_SESSION["nama_toko"];?>    </p>
       Alamat            : <p style="font-weight: bold;"> <?php echo $_SESSION["alamat_lengkap"];?></p>
       No Handphone      : <p style="font-weight: bold;"> <?php echo $_SESSION["hp"];?>            </p>
       Kategori Toko     :  <p style="font-weight: bold;"><?php echo $_SESSION["jenis_toko"];?>    </p>
       Motto             : <p style="font-weight: bold;"> <?php echo $_SESSION["motto"];?>           </p>
   
        <a href="" class="btn btn-info" data-toggle="modal" data-target="#edit">Ubah Data</a>         

          
        </div>
     
    </div>
  
    </div>
  
</div>



<!-- end data profile -->


<div id="edit" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Perbarui Data Pelapak </h4>
        <span>Jika Terdapat Kesalahan Dalam input Data</span>

         <a href="" class="close"><i class="pe-7s-close-circle" style="font-size: 45px; color: red;" data-dismiss="modal"></i></a>
      </div>
      <div class="modal-body">

      <form method="post" action="" enctype="multipart/form-data">

       <input class="form-control" type="hidden" name="id" value="<?php echo $id ; ?>"></input>
 
       <input class="form-control" type="hidden" name="file_lama" value="<?php echo $profile ; ?>"></input>

      <p><?php echo $foto_profile; ?></p>
      <input type="file" name="foto"  value="<?php echo $profile; ?>" class="form-control" id="nama"></input><br>

      <label for="nama">Nama Lengkap</label>
      <input type="text" name="name_lengkap" required="" readonly="disable" value="<?php echo $nama; ?>" class="form-control" id="nama"></input><br>

       <label for="nama">Nama Toko</label>
      <input type="text" name="name_toko" required="" value="<?php echo $nama_toko_anda; ?>" class="form-control" id="nama"></input><br>

       <label for="nama">Nama Alamat Lengkap</label>
      <input type="text" name="address_lengkap" required="" value="<?php echo $alamat_lengkap_pelapak; ?>" class="form-control" id="nama"></input><br>

       <label for="nama">No Handphone</label>
      <input type="text" name="no_hppp" required="" value="<?php echo $hp; ?>" class="form-control" id="nama"></input><br>

       <label for="nama">Jenis Toko</label>
     
       <select class="form-control" name="jenis_toko_saudara" id="nama">
                  <option><i class="pe-7s-shopbag"></i><?php echo $kategori_toko; ?></option>
                  <option>Elektronik</option>
                  <option>Kosmetik</option>
                  <option>Product Makanan</option>
                  <option>Fashion</option>
                  <option>Bangunan</option>
                  <option>Lainnya</option>
        </select>

       <label for="nama">Motto</label>
      <input type="text" name="moto" required="" value="<?php echo $motto_amanat; ?>" class="form-control" id="nama"></input><br>

      <button class="btn btn-primary" name="tombol_edit" style="width: 100%; font-weight: bold; height: 50px;" >Ubah Data</button>




        
      </form>
        
      </div>
    </div>
  </div>
</div>

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="bower_components/raphael/raphael.min.js"></script>
<script src="bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="bower_components/moment/min/moment.min.js"></script>
<script src="bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
