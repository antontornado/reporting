<?php
	echo $this->extend('template/blank');
	echo $this->section('konten');
?>
<form method="POST" action ="<?=base_url();?>repslik/generator">
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
        <button type="submit" class="btn btn-sm btn-primary" name="download">CreateTxt</button>
    </div>
</form>
<?php
	echo $this->endSection();
	echo $this->section('judul');
   		echo $title;
	echo $this->endSection();
	echo $this->section('mapping');
	echo $controller;
	echo $this->endSection();
	echo $this->section('controller');
		echo $controller;
 	echo $this->endSection();
?>