<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AppReporting | Blank Page</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="<?=base_url();?>adminlte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/daterangepicker/daterangepicker.css">
  <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/jqvmap/jqvmap.min.css">
  <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/datatables/buttons.dataTables.min.css">
  <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/datatables/jquery.dataTables.css">
  <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/datatables/dataTables.bootstrap.css">
  <link rel="stylesheet" href="<?=base_url()?>adminlte/plugins/daterangepicker/daterangepicker-bs3.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="<?=base_url()?>adminlte/plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="<?=base_url()?>adminlte/plugins/colorpicker/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="<?=base_url()?>adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?=base_url()?>adminlte/plugins/select2/select2.min.css">
  <!-- REQUIRED JS SCRIPTS -->
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

<!-- jQuery -->
<script src="<?=base_url();?>adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?=base_url();?>adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url();?>adminlte/dist/js/adminlte.min.js"></script>
<!-- Select2 -->
<script src="<?=base_url();?>adminlte/plugins/select2/js/select2.full.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="<?=base_url();?>adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
<!-- InputMask -->
<script src="<?=base_url();?>adminlte/plugins/moment/moment.min.js"></script>
<script src="<?=base_url();?>adminlte/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="<?=base_url();?>adminlte/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?=base_url();?>/adminlte/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="<?=base_url();?>adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Bootstrap Switch -->
<script src="<?=base_url();?>adminlte/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<!-- BS-Stepper -->
<script src="<?=base_url();?>adminlte/plugins/bs-stepper/js/bs-stepper.min.js"></script>
       
        <script src="<?=base_url();?>adminlte/plugins/bootstrap/js/bootstrap.min.js"></script>
        <script src="<?=base_url();?>adminlte/dist/js/app.min.js"></script>
        <script src="<?=base_url();?>adminlte/plugins/fastclick/fastclick.min.js"></script>
        <script src="<?=base_url();?>adminlte/plugins/chartjs/Chart.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
        <script src="<?=base_url();?>adminlte/plugins/datatables/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js"></script>
        <script src="<?=base_url();?>adminlte/plugins/flot/jquery.flot.min.js"></script>
        <script src="<?=base_url();?>adminlte/plugins/flot/jquery.flot.resize.min.js"></script>
        <script src="<?=base_url();?>adminlte/plugins/flot/jquery.flot.pie.min.js"></script>
        <script src="<?=base_url();?>adminlte/plugins/flot/jquery.flot.categories.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js"></script>
        <script src="<?=base_url();?>adminlte/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="<?=base_url();?>adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>


<!-- dropzonejs -->
<?= $this->renderSection('javascript');?>
<script>

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('yyyy/mm/dd', { 'placeholder': 'yyyy/mm/dd' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date picker
    $('#reservationdate').datetimepicker({
        format: 'YYYY-MM-DD'
    });

    //Date and time picker
    $('#reservationdatetime').datetimepicker({ icons: { time: 'far fa-clock' } });

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({
      timePicker: true,
      timePickerIncrement: 30,
      locale: {
        format: 'YYYYMMDD hh:mm A'
      }
    })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )
    //Timepicker
    $('#timepicker').datetimepicker({
      format: 'LT'
    })
    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    })
  })
  // BS-Stepper Init
  document.addEventListener('DOMContentLoaded', function () {
    window.stepper = new Stepper(document.querySelector('.bs-stepper'))
  })

</script>

</body>
</html>
