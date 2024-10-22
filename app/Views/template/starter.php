<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AppReporting | Starter Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?=base_url();?>adminlte/dist/css/adminlte.min.css">
  <style>
      .sidebar .nav-sidebar li a {
        padding-top: 2px; /* Atur jarak atas */
        padding-bottom: 2px; /* Atur jarak bawah */
      }
      .sidebar .nav-item .nav-link .fas.fa-angle-left {
      margin-top: -5px; /* Atur jarak atas */
      margin-bottom: 0px; /* Atur jarak bawah */
      }
  </style>
</head>
<body class="text-xs hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li><h4> <?=$this->renderSection('controller');?></h4></li>
    </ul>
  </nav>
  <!-- /.navbar -->



  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=base_url();?>" class="brand-link">
      <img src="<?=base_url();?>/adminlte/dist/img/logo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-thick"><b>Report</b>App</span>
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- SidebarSearch Form -->

      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
                <a href="<?=base_url();?>Users/logout" class="nav-link" style="color:#d86100">
                  <i class="fas fa-sign-out-alt nav-icon"></i>
                  <p style="font-size:18px">Log Out</p>
                </a>
          </li>
          <li class="nav-item">
                <a href="<?=base_url();?>" class="nav-link">
                  <i class="fas fa-home  nav-icon"></i>
                  <p>Home</p>
                </a>
          </li>
          <?php
            foreach ($menu as $controller){
                $submenu=explode('|',$controller['menu']);
                $keterangan=explode('|',$controller['keterangan']);
                $jumlahElemen = count($submenu);
          ?>
            <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-folder"></i>
              <p>
                <?=$controller['controller'];?>
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <?php for($i=0;$i<$jumlahElemen;$i++){?>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?=base_url().$controller['controller'].'/'.$submenu[$i];?>" class="nav-link">
                  <p><?=$keterangan[$i];?></p>
                </a>
              </li>
            </ul>
          <?php }?>
          </li>
                <?php
            }
          ?>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->

          <?= $this->renderSection('konten');?>
        <!-- /.card-footer-->
     
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script src="<?=base_url();?>adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url();?>adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url();?>adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url();?>adminlte/dist/js/demo.js"></script>

</body>
</html>
