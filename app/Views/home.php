<?php
	echo $this->extend('template/blank');
	echo $this->section('konten');
  $i=0;
  $judul=['','','','','','','','','','','','',''];
  $nominal=['','','','','','','','','','','','',''];
  $nominal2=['','','','','','','','','','','','',''];
  foreach($saldo as $datanya){
    $judul[$i]=date("My", strtotime($datanya['tgl_posting']));
    $nominal[$i]=round($datanya['saldo']/1000000000,0);
    $i+=1;
  }
  $i=0;
  foreach($saldo2 as $datanya){
    $nominal2[$i]=round($datanya['saldo']/1000000000,0);
    $i+=1;
  }

      $bulanLalu = strtotime("last month"); // Mendapatkan timestamp untuk bulan lalu
      $akhirBulanLalu = strtotime("last day of", $bulanLalu); // Mendapatkan timestamp untuk akhir bulan lalu
      // Format tanggal akhir bulan lalu sesuai kebutuhan
      $tanggalAkhirBulanLalu = date("d M Y", $akhirBulanLalu);
?>
<div class="row">
<div class="col-lg-3 col-6">

<div class="small-box bg-info">
<div class="inner">
<h3><?=$laba;?> Juta</h3>
<p>Laba Posisi <?=$tanggalAkhirBulanLalu;?></p>
</div>
<div class="icon">
<i class="ion ion-bag"></i>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

<div class="col-lg-3 col-6">

<div class="small-box bg-success">
<div class="inner">
<h3><?=$npl;?><sup style="font-size: 20px">%</sup></h3>
<p> NPL Posisi
<?=$tanggalAkhirBulanLalu?>
</p>
</div>
<div class="icon">
<i class="ion ion-stats-bars"></i>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>



<div class="col-lg-3 col-6">

<div class="small-box bg-danger">
<div class="inner">
<h3><?=$closed;?></h3>
<p>Closed Account periode <?=date('Y');?></p>
</div>
<div class="icon">
<i class="ion ion-pie-graph"></i>
</div>
<a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
</div>
</div>

</div>
 <div class="row">
 <!-- /.col (LEFT) -->
          <div class="col-md-6">
            <!-- LINE CHART -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Total Kredit <?=$bpr;?>(dalam Milyar Rupiah)</h3>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="lineChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

 </div>
        <!-- /.row -->
<?php
	echo $this->endSection();
	echo $this->section('judul');
   		//echo $title;
	echo $this->endSection();
	echo $this->section('mapping');
	//echo $controller;
	echo $this->endSection();
	echo $this->section('controller');
		//echo $controller;
 	echo $this->endSection();

  echo $this->section('javascript');?>
  <script src="<?=base_url();?>/adminlte/plugins/chart.js/Chart.min.js"></script>
  <script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $('#lineChart').get(0).getContext('2d')

    var areaChartData = {
      labels  : ['<?=$judul[0];?>','<?=$judul[1];?>', '<?=$judul[2];?>','<?=$judul[3];?>', '<?=$judul[4];?>', '<?=$judul[5];?>','<?=$judul[6];?>','<?=$judul[7];?>','<?=$judul[8];?>','<?=$judul[9];?>','<?=$judul[10];?>','<?=$judul[11];?>','<?=$judul[12];?>'],
      
      datasets: [
        {
          label               : 'Total Kredit',
          backgroundColor     : 'rgba(60,141,188,0.9)',
          borderColor         : 'rgba(60,141,188,0.8)',
          pointRadius         : false,
          pointColor          : '#3b8bba',
          pointStrokeColor    : 'rgba(60,141,188,1)',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data                : [<?=$nominal[0];?>,<?=$nominal[1];?>, <?=$nominal[2];?>,<?=$nominal[3];?>, <?=$nominal[4];?>, <?=$nominal[5];?>,<?=$nominal[6];?>,<?=$nominal[7];?>,<?=$nominal[8];?>,<?=$nominal[9];?>,<?=$nominal[10];?>,<?=$nominal[11];?>,<?=$nominal[12];?>],
          lineTension: 0
        },
        {
          label               : 'Total DPK',
          backgroundColor     : 'rgba(210, 214, 222, 1)',
          borderColor         : 'rgba(210, 214, 222, 1)',
          pointRadius         : false,
          pointColor          : 'rgba(210, 214, 222, 1)',
          pointStrokeColor    : '#c1c7d1',
          pointHighlightFill  : '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data                : [<?=$nominal2[0];?>,<?=$nominal2[1];?>, <?=$nominal2[2];?>,<?=$nominal2[3];?>, <?=$nominal2[4];?>, <?=$nominal2[5];?>,<?=$nominal2[6];?>,<?=$nominal2[7];?>,<?=$nominal2[8];?>,<?=$nominal2[9];?>,<?=$nominal2[10];?>,<?=$nominal2[11];?>,<?=$nominal2[12];?>],
          lineTension: 0
        },
      ]
    }

    var areaChartOptions = {
      maintainAspectRatio : false,
      responsive : true,
      legend: {
        display: true
      },
      scales: {
        xAxes: [{
          gridLines : {
            display : true,
          }
        }],
        yAxes: [{
          gridLines : {
            display : true,
          }
        }]
      }
    }

    // This will get the first returned node in the jQuery collection.
    new Chart(areaChartCanvas, {
      type: 'line',
      data: areaChartData,
      options: areaChartOptions
    })

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = true

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    })
  })
    </script>
  <?php echo $this->endSection();
  ?>