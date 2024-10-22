<?php
	echo $this->extend('template/starterpage');
	echo $this->section('konten');
      $bulanLalu = strtotime("last month"); // Mendapatkan timestamp untuk bulan lalu
      $akhirBulanLalu = strtotime("last day of", $bulanLalu); // Mendapatkan timestamp untuk akhir bulan lalu
      // Format tanggal akhir bulan lalu sesuai kebutuhan
      $tanggalAkhirBulanLalu = date("d M Y", $akhirBulanLalu);
?>


    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Laba Posisi <?=$tanggalAkhirBulanLalu;?></span>
                <span class="info-box-number"><?=$laba;?> <small>Milyar</small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">NPL Posisi <?=$tanggalAkhirBulanLalu?></span>
                <span class="info-box-number">
                <?=$npl;?>
                  <small>%</small>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Kredit <?=$tanggalAkhirBulanLalu?></span>
                <span class="info-box-number"><?=$kredit;?> <small>Milyar</small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">DPK & ABP <?=$tanggalAkhirBulanLalu?></span>
                <span class="info-box-number"><?=$dpk;?> <small>Milyar</small></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
<?php      echo $this->endSection();
	echo $this->section('judul');
   		//echo $title;
	echo $this->endSection();
	echo $this->section('mapping');
	//echo $controller;
	echo $this->endSection();
	echo $this->section('controller');
		//echo $controller;
 	echo $this->endSection();
?>
