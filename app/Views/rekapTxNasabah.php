<?php
	echo $this->extend('template/starterpage');
	echo $this->section('konten');
	// Konversi data ke format JSON
	$individualJson = json_encode($individual);
	$institusiJson = json_encode($institusi);
?>

<div class="card">
  <div class="card-body">
    <form method="POST" action="<?=base_url();?>Nasabah/historiTransaksiNasabah">
      <div class="row">
        <div class="col-md-3 col-sm-12 mb-3">
          <label>Jenis Nasabah</label>
          <select class="form-control select2" style="width: 100%;" name="jenisNasabah" id="type">
            <option value="2" placeholder="pilih jenis nasabah" <?php if($postingan['jenisNasabah']==2){echo 'selected';}?>></option>
            <option value="1" <?php if($postingan['jenisNasabah']==1){echo 'selected';}?>>Individual</option>
            <option value="0" <?php if($postingan['jenisNasabah']==0){echo 'selected';}?>>Institusi</option>
          </select>
        </div>
        <div class="col-md-3 col-sm-12 mb-3">
          <label>Periode Data:</label>
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="far fa-calendar-alt"></i>
              </span>
            </div>
            <input type="text" name="periode" class="form-control float-right" id="daterange-btn">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label>Nama Nasabah</label>
          <select class="form-control select2" style="width: 100%;" name="namaNasabah" id="nasabah">
            <option value="<?=$postingan['namaNasabah'];?>"><?=$postingan['namaNasabah'];?></option>
            <!-- ini bakal diisi pakai jQuery-->
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-sm btn-primary" name="download">Cari Data</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div class="card">
<div class="card-body">
      <table id="table_id" class="table table-bordered table-striped table-md">
        <thead>
            <tr>
            		<th>Nomor CIF</th>
                <th>Nama Nasabah</th>
                <th>Tgl Valuta</th>
                <th>Jenis Rekening</th>
                <th>Nomor Rekening</th>
                <th>Kode Program</th>
                <th>Posisi</th>
                <th>Keterangan Tx</th>
                <th>Nilai Tx</th>
            </tr>
        </thead>
        <tbody>
         <?php
         $nama=explode('-',$postingan['namaNasabah']);
         foreach($rec as $row) {

            echo  "<tr>
						<td>".$nama[0]."</td>
						<td>".$nama[1]."</td>
            <td>".$row['tgl_valuta']."</td>
            <td>".$row['produk']."</td>
            <td>".$row['nomor_rekening']."</td>
            <td>".$row['menu']."</td>
            <td>".$row['posisi']."</td>
            <td>".$row['keterangan_transaksi']."</td>
            <td>".number_format($row['nilai_transaksi'],0,".",",")."</td>
            </tr>";
        }
        ?>
    </tbody>
</table>
</div><!-- /.box-body -->
</div><!-- /.box -->
<?php
	echo $this->endSection();
	echo $this->section('mapping');
	echo $controller;
	echo $this->endSection();
	echo $this->section('controller');
		echo $controller;
 	echo $this->endSection();
   echo $this->section('css');?>
   <!-- DataTables -->
   <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
   <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
   <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/daterangepickerold/daterangepicker-bs3.css">
    <link rel="stylesheet" href="<?=base_url()?>adminlte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?=base_url()?>adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">

<?php echo $this->endSection();
echo $this->section('javascript');
?>
<!-- DataTables  & Plugins -->
<script src="<?=base_url();?>adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url();?>adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url();?>adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=base_url();?>adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=base_url();?>adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=base_url();?>adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=base_url();?>adminlte/plugins/jszip/jszip.min.js"></script>
<script src="<?=base_url();?>adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=base_url();?>adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=base_url();?>adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=base_url();?>adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=base_url();?>adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- date-range-picker -->
<script src="<?=base_url();?>adminlte/plugins/daterangepickerold/moment.min.js"></script>
<script src="<?=base_url();?>adminlte/plugins/daterangepickerold/daterangepicker.js"></script>
<script src="<?=base_url();?>adminlte/plugins/select2/js/select2.full.min.js"></script>
<script>
      $(function () {
       //Initialize Select2 Elements
       $('.select2').select2()

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})
//Date picker
$('#daterange-btn').daterangepicker(
  {
      locale: {
        format: 'YYYYMMDD',
      },
      separator: '-'
    }
);
$('#daterange-btn').on('apply.daterangepicker', function(ev, picker) {
  var startDate = picker.startDate.format('YYYYMMDD');
  var endDate = picker.endDate.format('YYYYMMDD');
  $(this).val(startDate +'-'+ endDate);
});

      });
    </script>
        <script>
            $(document).ready(function () {
              $("#table_id").DataTable({
      "responsive": false, 
      "lengthChange": true, 
      "scrollX": true,     // Aktifkan scroll horizontal
      "scrollCollapse": false,
      "paging": true,
      "lengthMenu": [5, 10, 25, 50, 100], // Jumlah record yang bisa dipilih
      "pageLength": 10,
      "autoWidth":true,
      "buttons": [
        {
          extend: 'excel',
          title: null,
          filename: function() {
          var d = new Date();
          return 'Data Nasabah' + d.getFullYear() + 
                 ('0' + (d.getMonth() + 1)).slice(-2) + 
                 ('0' + d.getDate()).slice(-2) + '_' + 
                 ('0' + d.getHours()).slice(-2) + 
                 ('0' + d.getMinutes()).slice(-2);
        },
          exportOptions: {
            columns: ':visible'
          },
          customize: function(xlsx) {
          var sheet = xlsx.xl.worksheets['sheet1.xml'];
          $('row c', sheet).attr('s', '50');
          $('row c[r^="D"]', sheet).attr('t', 'n'); // Kolom D
        }
        },
        {
          extend: 'csv',
          title: null,
          exportOptions: {
            columns: ':visible'
          }
        },
        {
          extend: 'pdf',
          title: null,
          exportOptions: {
            columns: ':visible'
          }
        },
        'print', 
        'colvis'
      ]
    }).buttons().container().appendTo('#table_id_wrapper .col-md-6:eq(0)');
            });

      </script>
      <script>
        $(document).ready(function() {
            // Data nasabah dari PHP
            const individual = <?php echo $individualJson; ?>;
            const institusi = <?php echo $institusiJson; ?>;

            // Fungsi untuk memperbarui opsi nasabah
            function updateNasabahOptions(data) {
                const options = data.map(nasabah => `<option value="${nasabah}">${nasabah}</option>`).join('');
                $('#nasabah').html(options);
            }

            // Atur opsi berdasarkan nilai awal
            //updateNasabahOptions(individual);

            // Tambahkan event listener untuk perubahan select
            $('#type').change(function() {
                const type = $(this).val();
                if (type === '1') {
                    updateNasabahOptions(individual);
                } else if (type === '0') {
                    updateNasabahOptions(institusi);
                } else if (type === '2') {$('#nasabah').html('');
                }
            });
        });
    </script>
   <?php echo $this->endSection();
?>