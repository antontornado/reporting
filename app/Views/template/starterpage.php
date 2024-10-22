<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aplikasi Reporting| Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url();?>adminlte/dist/css/adminlte.min.css">
  <?=$this->renderSection('css');?>
    <!-- ... kode lainnya ... -->
    <style>
      .nav-sidebar .nav-item > .nav-link {
        font-size: 0.8rem;
        padding: 0.3rem 0.8rem;
      }
      .nav-sidebar .nav-treeview > .nav-item > .nav-link {
        font-size: 0.8rem;
        padding-top: 0.2rem;
        padding-bottom: 0.2rem;
      }

      .sidebar-search .form-control {
        border-top-right-radius: 2px;
        border-top-left-radius: 2px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
        box-shadow: none;
      }

      .sidebar-search .btn {
        border-top-left-radius: 0;
        border-top-right-radius: 0;
        border-bottom-right-radius: 2px;
        border-bottom-left-radius: 2px;
        box-shadow: none;
      }
    </style>

</head>
<body class="hold-transition light-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__wobble" src="<?=base_url();?>/adminlte/dist/img/logo.png" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a class="nav-link" href="tes.html"><?=$title;?></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

      
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <img src="<?=base_url();?>assets/dist/img/operator.png" class="user-image img-circle elevation-2" alt="User Image">
          <span class="d-none d-md-inline"><?=$namaUser;?></span>
        </a>
        <ul class="dropdown-menu" style="width:100px">
            <li><a href="<?=base_url();?>Users/logout" class="dropdown-item">Sign out</a></li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=base_url();?>" class="brand-link">
      <img src="<?=base_url();?>/adminlte/dist/img/logoapp.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <?php $bpr=explode(' ',$namabpr);?>
      <span class="brand-text font-weight-thick"><b><?=strtoupper($bpr[0]);?></b><?=ucwords($bpr[1]);?></span>
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
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-home"></i>
              <p>
                Index
              </p>
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
    
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
    <?= $this->renderSection('konten');?>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?=base_url();?>adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?=base_url();?>adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url();?>adminlte/dist/js/adminlte.js"></script>
<?= $this->renderSection('javascript');?>
<script>
</body>
</html>
