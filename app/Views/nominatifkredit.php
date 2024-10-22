<?php
	echo $this->extend('template/starterpage');
	echo $this->section('konten');
?>
<div class="card">

<div class="card-body">
<form method="POST" action ="<?=base_url();?>pinjaman/nominatifpinjaman">
	<div class="form-group">
    	<label>Posisi Data:</label>
        <div class="input-group date" id="reservationdate" data-target-input="nearest">
        <input type="text" class="form-control datetimepicker-input" data-target="#reservationdate" name="posisiData"/>
        	  <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
        	      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
              </div>
        </div>
    </div>
	<div class="form-group">
		<?php foreach($kantor as $listKantor){?>
		<div class="custom-control custom-checkbox">
        	<input class="custom-control-input" type="checkbox" id="customCheckbox<?=$listKantor['kode_kantor'];?>" name="kantor[]" value="<?=$listKantor['kode_kantor'];?>">
			<label for="customCheckbox<?=$listKantor['kode_kantor'];?>" class="custom-control-label"><?=ucwords(strtolower($listKantor['nama_kantor']));?></label>
        </div>
		<?php }?>
	</div>

	<div class="form-group">
        <button type="submit" class="btn btn-sm btn-primary" name="download">Simpan</button>
    </div>
</form>
</div>
</div>
<?php
	echo $this->endSection();
	echo $this->section('mapping');
	echo $controller;
	echo $this->endSection();
	echo $this->section('controller');
		echo $controller;
 	echo $this->endSection();
	echo $this->section('javascript');?>
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
   <?php echo $this->endSection();
?>