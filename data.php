<?php 
session_start();

require 'pelapak.php';

if (!isset($_SESSION["login"])) {
  header("location:index.php");
  exit;
}

if (isset($_POST["submitt"])) {


	if (tambah_barang($_POST) > 0) {


		echo "<script>alert('Barang Anda Berhasil Di Upload');
		document.location.href='data.php';
		
		</script>";
    exit;
		
	}else{

		echo "<script>alert('Barang Gagal Di Upload');
		document.location.href='data.php';
		
		</script>";
		exit;


	}
	
}
$toko= $_SESSION["nama_toko"];

$query= mysqli_query($koneksi,"SELECT nama_toko,jenis_barang,merek_barang,kondisi_barang,nama_barang,harga_barang,stok_barang,gambar,deskripsi_barang,waktu,diskon FROM barang WHERE nama_toko='$toko'");
$query_add_kategori=mysqli_query($koneksi,"SELECT nama_kategori FROM add_kategori WHERE nama_username_toko='$toko'")or die(mysqli_error($koneksi));


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
          	<li><a href="#"><i class="fa fa-circle-o"></i>Upload Barang</a></li>
              <li><a href="addKategori.php"><i class="fa fa-circle-o"></i>Tambah Kategori Barang</a></li>
          </ul>
        </li>
       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Data Tables
        <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Hover Data Table</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <a href="#" style="border-radius: none; background-color: green;" class="btn btn-success" data-toggle="modal" data-target="#tambah"><i class="pe-7s-cart" style="font-size: 23px;"></i> Tambah Barang</a><br><br>

            <!-- Bagian Uplaod Barang Inti Dari Halaman ingat yaaaaaaaaa -->

   <div id="tambah" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Ungggah Barang Yang Ingin Anda Jual, Dan Isi Form Di Bawah Ini Dengan jujur</h4>
    		<a href="" class="close"><i class="pe-7s-close-circle" style="font-size: 25px;" data-dismiss="modal"></i></a>
      </div>
      <div class="modal-body">

            <form action="" method="post" enctype="multipart/form-data">
            <label id="passwordd"><i class="pe-7s-unlock" style="font-size: 25px; color: blue;"></i>Pemilik Toko </label><br>
                 <input type="text" placeholder=" Masukan Password" required="" readonly="disable" autocomplete="off" class="form-control" name="nama_pemilik" id="password" value="<?php echo $_SESSION["nama_lengkap"]; ?>"></input><br>

               <label id="passwordd"><i class="pe-7s-unlock" style="font-size: 25px; color: blue;"></i> Nama Toko</label><br>
                 <input type="text" placeholder=" Masukan Password" required="" readonly="disable" autocomplete="off" class="form-control" name="nama_toko" id="password" value="<?php echo $_SESSION["nama_toko"]; ?>"></input><br>

            		 <label id="passwordd"><i class="pe-7s-unlock" style="font-size: 25px; color: blue;"></i> Uplaod Gambar</label><br>
            		 <input type="file" placeholder=" Masukan Password" required="" autocomplete="off" class="form-control" name="gambar" id="password"></input><br>

               <label id="usernamee"><i class="pe-7s-settings" style="font-size: 25px; color: blue;"></i> Jenis Barang</label><br>
               <select class="form-control" name="pilihan_barang" id="username">
                  <option><i class="pe-7s-shopbag"></i> Kategori Barang</option>
                   <option>Elektronik</option>
                    <option>Kosmetik</option>
                     <option>Alat Rumah Tangga</option>
                      <option>Fashion</option>
                       <option>Hardware Kompuer</option>
                       <?php while ($tampil_data=mysqli_fetch_assoc($query_add_kategori)) :?>
                       <option><?= $tampil_data["nama_kategori"]; ?></option>
                      
                     <?php endwhile; ?>

                
                </select>
                <br>

                 <label id="passwordd"><i class="pe-7s-unlock" style="font-size: 25px; color: blue;"></i> Merek Barang</label><br>
            	 <input type="text" placeholder=" Merek Product" required="" autocomplete="off" class="form-control" name="merek_barang" id="password"></input><br>

             
             <label id="usernamee"><i class="pe-7s-settings" style="font-size: 25px; color: blue;"></i> Kondisi Barang</label><br>
               <select class="form-control" name="pilihan_keadaan" id="username">
                  <option><i class="pe-7s-shopbag"></i> Kategori Barang</option>
                   <option>Barang Bekas</option>
                    <option>Baru</option>
                </select>
                <br>

       <label id="usernamee"><i class="pe-7s-users" style="font-size: 25px; color: blue;"></i> Nama Barang</label>
           <input type="text" placeholder=" Nama Barang" required="" autocomplete="off" class="form-control" name="nama_barang" id="username"></input><br>
           <label id="passwordd"><i class="pe-7s-unlock" style="font-size: 25px; color: blue;"></i> Harga Barang</label><br>
             <input type="text" placeholder=" Rp.150.000" required="" autocomplete="off" class="form-control" name="harga_barang" id="password"></input><br>

              <label id="passwordd"><i class="pe-7s-unlock" style="font-size: 25px; color: blue;"></i> Stok Barang</label><br>
             <input type="number" placeholder="Masukan Type Data Angka" required="" autocomplete="off" class="form-control" name="stok_barang" id="password"></input><br>

              <label id="passwordd"><i class="pe-7s-unlock" style="font-size: 25px; color: blue;"></i> Diskon Product(Tulis Angka Saja)</label><br>
             <input type="number" required="" autocomplete="off" class="form-control" name="diskon" id="password" value="0"></input><br>

              <label id="deskripsi"><i class="pe-7s-unlock" style="font-size: 25px; color: blue;"></i> Description</label><br>
             <textarea class="form-control" name="deskripsi"></textarea><br>

             <label id="passwordd"><i class="pe-7s-unlock" style="font-size: 25px; color: blue;"></i> Waktu Upload </label><br>
             <input type="date" required="" autocomplete="off" class="form-control" name="waktu" id="password"></input><br>
           


             <button type="submit" name="submitt" class="btn btn-primary btn-lg"><i class="pe-7s-cart" style="font-size: 27px;"></i> Upload Barang</button>
       </form>

       <!-- penutu[p bagian Uplaod Barang] -->
      </div>
    </div>
  </div>
  
</div>

             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Barang Yang Di Jual <?= $_SESSION["nama_lengkap"]; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="content table-responsive table-full-width">
             <table class="table table-bordered table-hover" id="example1">
                <thead>
                <tr>
                  <th style="background-color: green; color: white;">Nama Barang</th>
                  <th style="background-color: green; color: white;">Jenis Barang</th>
                  <th style="background-color: green; color: white;">Merek Barang</th>
                  <th style="background-color: green; color: white;">Kondisi Barang</th>
                  <th style="background-color: green; color: white;">Harga Barang</th>
                  <th style="background-color: green; color: white;">Diskon</th>
                  <th style="background-color: green; color: white;">Stok</th>
                  <th style="background-color: green; color: white;">Product</th>
                  <th style="background-color: green; color: white;">Deskripsi</th>
                  <th style="background-color: green; color: white;">Waktu Upload</th>
                </tr>
                </thead>
                <tbody>
                 <?php 
                 while ($row= mysqli_fetch_assoc($query)): ?>
                  <tr>
                  <td><?php echo $row["nama_barang"]; ?></td>
                  <td><?php echo $row["jenis_barang"]; ?></td>
                  <td><?php echo $row["merek_barang"]; ?></td>
                  <td> <?php echo $row["kondisi_barang"]; ?></td>
                  <td><?php echo $row["harga_barang"]; ?></td>
                  <td><?php  echo $row["diskon"]; ?></td>
                  <td><?php echo $row["stok_barang"]; ?>
                   
                  </td>
                  <td><img src="pelapak_gambar/<?php echo $row["gambar"]; ?>" style="width: 320px; height: 100px;" class="img-thumbnail"></td>
                  <td><?php echo $row["deskripsi_barang"]; ?></td>
                  <td><?php echo $row["waktu"]; ?></td>
                </tr>
                
               <?php endwhile; ?>

               
                
                </tbody>
                <tfoot>
                <tr>
                  <th style="background-color: green; color: white;">Rendering engine</th>
                  <th style="background-color: green; color: white;">Browser</th>
                  <th  style="background-color: green; color: white;">Platform(s)</th>
                  <th  style="background-color: green; color: white;">Engine version</th>
                  <th style="background-color: green; color: white;">CSS grade</th>
                   <th style="background-color: green; color: white;">Rendering engine</th>
                  <th style="background-color: green; color: white;">Browser</th>
                  <th  style="background-color: green; color: white;">Platform(s)</th>
                  <th  style="background-color: green; color: white;">Engine version</th>
                  <th style="background-color: green; color: white;">CSS grade</th>
                </tr>
                

                </tfoot>
              </table>
              </div>  
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
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
