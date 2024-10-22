<?php
	echo $this->extend('template/starterpage');
	echo $this->section('konten');

  function potongKalimat($kalimat, $jumlahBagian) {
    $kataArray = explode(' ', $kalimat);
    $hasil = [];
    $temp = '';

    foreach ($kataArray as $kata) {
        // Jika menambahkan kata melebihi 30 karakter, simpan bagian
        if (strlen($temp) + strlen($kata) + 1 > 30) {
            $hasil[] = trim($temp);
            $temp = $kata; // Mulai dengan kata saat ini
        } else {
            // Tambahkan kata ke bagian saat ini
            $temp .= ($temp ? ' ' : '') . $kata;
        }
    }
    
    // Simpan sisa bagian yang belum disimpan
    if ($temp) {
        $hasil[] = trim($temp);
    }

    // Redistribusi jika terlalu banyak bagian
    while (count($hasil) > $jumlahBagian) {
        $gabungan = array_shift($hasil);
        $hasil[0] = trim($gabungan . ' ' . $hasil[0]);
    }

    return $hasil;
}

?>

<div class="card">
	<div class="card-body">
		<form method="POST" action="<?=base_url();?>Deposito/listOTShinhan">
			<div class="form-group">
      			<div class="row-mt2">
        			<div class="col-md-3">
          				<label>Periode Data:</label>
          				<div class="input-group">
          					<div class="input-group-prepend">
          						<span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
          					</div>
          					<input type="text" class="form-control float-right" id="daterange-btn" name="periode" readonly>
          				</div>
          			</div>
          		</div>
        	  </div>
        		<!-- Dropdown untuk memilih jenis data -->
            <div class="row-mt2">
          			<div class="col-md-6">
          				<label>Pilih Kantor Cabang:</label>
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <select class="form-control" name="kodeKantor">
                        <option value="'001','002'">Semua</option>
                        <option value="'001'">Kantor Pusat</option>
                        <option value="'002'">Kantor Cabang Kelapa Gading</option>
                        <!-- Tambahkan opsi lain sesuai kebutuhan -->
                      </select>
                    </div>
                    <div class="input-group-append">
          						<button type="submit" class="btn btn-primary" name="download">Cari Data</button>
          					</div>
                  </div>
          			</div>
          	</div>
		</form>
	</div>
</div>
<div class="card">
<div class="card-body">
      <table id="tab" class="table table-bordered table-striped small">
        <thead>
            <tr>
                <th>Tgl Jt.Bunga</th>
                <th>Nomor Bilyet</th>
                <th>Beneficiary Account No.</th>
                <th>Transfer Amount</th>
                <th>Bank ID</th>
                <th>Beneficiary type</th>
                <th>Resident Type</th>
                <th>Beneficiary Customer Name 1</th>
                <th>Beneficiary Customer Name 2</th>
                <th>Payment Details 1</th>
                <th>Payment Details 2</th>
                <th>Payment Details 3</th>
                <th>Payment Details 4</th>
                <th>Tax Code</th>
                <th>Tax Reference</th>
                <th>Remittance Type</th>
            </tr>
        </thead>
        <tbody>
         <?php
         foreach($rec as $row) {
            $potongNama=potongKalimat($row['beneficiary_customer_name_1'],2);
            $potongan[0]='';
            $potongan[1]='';
            $i=0;
            foreach($potongNama as $nama){
              $potongan[$i]=$nama;
              $i++;
            }
            echo  "<tr>
            <td>".$row['tgl_jatuh_tempo_bunga']."</td>
            <td>".$row['nomor_bilyet']."</td>
            <td>".$row['beneficiary_account_no']."</td>
            <td>".$row['transfer_amount']."</td>
            <td>".$row['bank_id']."</td>
            <td>".$row['beneficiary_ID_type']."</td>
            <td>".$row['resident_type']."</td>
            <td>".$potongan[0]."</td>
            <td>".$potongan[1]."</td>
            <td>".$row['payment_detail_1']."</td>
            <td>".$row['payment_detail_2']."</td>
            <td>".$row['payment_detail_3']."</td>
            <td>".$row['payment_detail_4']."</td>
            <td>".$row['tax_code']."</td>
            <td>".$row['tax_reference']."</td>
            <td>".$row['remittance_type']."</td>
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
<script>
$(function() {
  $('#daterange-btn').daterangepicker({
    ranges: {
      'Hari Ini': [moment(), moment()],
      'Besok': [moment().add(1, 'days'), moment().add(1, 'days')],
      '3 Hari ke Depan': [moment(), moment().add(2, 'days')],
      '1 Minggu ke Depan': [moment(), moment().add(6, 'days')],
    },
    locale: {
      format: 'YYYYMMDD',
      separator: ' - ',
      applyLabel: 'Pilih',
      cancelLabel: 'Batal',
      fromLabel: 'Dari',
      toLabel: 'Sampai',
      customRangeLabel: 'Pilih Sendiri',
      weekLabel: 'M',
      daysOfWeek: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
      monthNames: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
      firstDay: 1
    },
    startDate: moment(),
    endDate: moment()
  }, function(start, end) {
    $('#daterange-btn').val(start.format('YYYYMMDD') + ' - ' + end.format('YYYYMMDD'));
  });
});
</script>


<script>
  $(function () {
    $("#tab").DataTable({
      "responsive": false, 
      "lengthChange": false, 
      "scrollX": true,     // Aktifkan scroll horizontal
      "scrollCollapse": false,
      "paging": true,
      "pageLength": 10,
      "autoWidth":true,
      "buttons": [
        {
          extend: 'excel',
          title: null,
          filename: function() {
          var d = new Date();
          return 'Data_OT_Shinhan_' + d.getFullYear() + 
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
    }).buttons().container().appendTo('#tab_wrapper .col-md-6:eq(0)');
  });
</script>
   <?php echo $this->endSection();
?>