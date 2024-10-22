<?php
	echo $this->extend('template/starterpage');
	echo $this->section('konten');
	//Konversi data ke format JSON
	//$rekeningTabungan = json_encode($rekeningTabungan);
	$depo= json_encode($depo);
    $tab= json_encode($tab);
?>
<div class="form-group">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#uploadModal">
        <i class="fa fa-plus"></i>
        </button>
</div>

<!-- Modal untuk form upload -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true" ata-bs-transition="100" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-dark">
        <h5 class="modal-title" id="uploadModalLabel">Upload Spesimen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="uploadForm" enctype="multipart/form-data" action="<?=base_url();?>Nasabah/uploadSpesimen" method="post">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="JenisRekening">Jenis Rekening:</label>
                        <select class="form-control select2" id="JenisRekening" name="JenisRekening">
                            <option value="2">Pilih Salah Satu</option>
                            <option value="DEPOSITO">Deposito</option>
                            <option value="TABUNGAN">Tabungan</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nomorRekening">Nomor Rekening</label>
                        <select class="form-control select2" id="nomorRekening" name="nomorRekening">
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="fileInput">Pilih File(Gambar atau PDF):</label>
                <input type="file" class="form-control-file" id="fileInput" name="file" accept="image/*,application/pdf">
            </div>
            <div class="form-group">
                <img id="filePreview" class="preview-img" src="" alt="Preview" style="display: none;">
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="card">
<div class="card-body">
      <table id="table_id" class="table table-bordered table-striped table-md">
        <thead>
            <tr>
            	<th>Jenis Rekening</th>
                <th>Nomor Rekening</th>
                <th>Nama Nasabah</th>
                <th>Waktu Upload</th>
                <th>User ID</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
         <?php
         
         foreach($spesimen as $row) {
            $nama=explode('-',$row['nomor_rekening']);
            $imageUrl = base_url($row['nama_file']);
            echo  "<tr>
            <td>".$row['jenis_rekening']."</td>
						<td>".$nama[0]."</td>
						<td>".$nama[1]."</td>
            <td>".$row['waktu_upload']."</td>
            <td>".$row['user_id']."</td>
            <td><a href='".base_url()."Nasabah/hapusSpesimen/".$row['id']."' class='btn btn-danger btn-sm'>Hapus</a> <a href='#' class='btn btn-success btn-sm view-specimen' data-id='".$row['id']."' data-file='".$imageUrl."'>View</a></td>
            </tr>";
        }
        ?>
    </tbody>
</table>
</div><!-- /.box-body -->
</div><!-- /.box -->

<!-- Add this modal structure at the end of the file, before the closing PHP tag -->
<div class="modal fade" id="specimenModal" tabindex="-1" role="dialog" aria-labelledby="specimenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="specimenModalLabel">Preview Spesimen</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img id="specimenImage" src="" alt="Specimen" style="max-width: 100%; height: auto;" oncontextmenu="return false;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<?php
	echo $this->endSection();
	echo $this->section('css');?>
   <!-- DataTables -->
   <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
   <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
   <link rel="stylesheet" href="<?=base_url();?>adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>adminlte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?=base_url()?>adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="<?=base_url()?>adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <style>
        .preview-img {
            max-width: 60%;
            height: auto;
        }

        #specimenImage {
        max-width: 60%;
        height: auto;
        display: block;
        margin: 0 auto;
        pointer-events: none;
        user-select: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }
    .modal.fade .modal-dialog {
    transition: transform 0.05s ease-out, opacity 0.05s ease-out;
}
.modal.fade .modal-dialog.modal-dialog-centered {
    transition: transform 0.05s ease-out, opacity 0.05s ease-out;
}
</style>

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

<script src="<?=base_url();?>adminlte/plugins/select2/js/select2.full.min.js"></script>
<script>
      $(function () {
       //Initialize Select2 Elements
       $('.select2').select2({
        dropdownParent: $('#uploadModal'),
        width: '100%'
    })

//Initialize Select2 Elements
$('.select2bs4').select2({
  theme: 'bootstrap4'
})
      });
    </script>
    <script>
        $(document).ready(function() {
            $('#fileInput').on('change', function(event) {
                var file = event.target.files[0];
                var fileType = file ? file.type : '';
                
                // Check if the selected file is an image or a PDF
                if (fileType.startsWith('image/') || fileType === 'application/pdf') {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        if (fileType.startsWith('image/')) {
                            // If it's an image, show the image preview
                            $('#filePreview').attr('src', e.target.result).show();
                        } else {
                            // If it's a PDF, hide the image preview
                            $('#filePreview').hide();
                        }
                    };
                    
                    reader.readAsDataURL(file);
                } else {
                    // Hide the preview and alert the user if the file type is not allowed
                    $('#filePreview').hide();
                    alert('Please select a valid image or PDF file.');
                    $('#fileInput').val(''); // Clear the input
                }
            });
        });
    </script>
     <script>
        $(document).ready(function() {
            // Data nasabah dari PHP
            const depo = <?php echo $depo; ?>;
            const tab = <?php echo $tab; ?>;
            // Fungsi untuk memperbarui opsi nomor rekening
            function updateNomorRekeningOptions(data) {
                const options = data.map(rekening => `<option value="${rekening}">${rekening}</option>`).join('');
                $('#nomorRekening').html('<option value="">Pilih Salah Satu</option>' + options);
            }

            // Event listener untuk perubahan Jenis Rekening
            $('#JenisRekening').change(function() {
                const jenisRekening = $(this).val();
                if (jenisRekening === 'DEPOSITO') {
                    updateNomorRekeningOptions(depo);
                } else if (jenisRekening === 'TABUNGAN') {
                    updateNomorRekeningOptions(tab);
                } else {
                    $('#nomorRekening').html('<option value="">Pilih Salah Satu</option>');
                }
            });

            $('#uploadForm').on('submit', function(event) {
                event.preventDefault();
                
                var jenisRekening = $('#JenisRekening').val();
                var nomorRekening = $('#nomorRekening').val();
                var file = $('#fileInput').val();
                
                if (!jenisRekening || !nomorRekening || !file) {
                    alert('Lengkapi dulu isiannya!!');
                } else {
                    if(confirm('Yakin Upload Spesimen ?')){
                    this.submit(); // Actually submit the frm
                    }
                }
            });
        });
    </script>
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
      "autoWidth":false,

    }).buttons().container().appendTo('#table_id_wrapper .col-md-6:eq(0)');
            });

      </script>
   <script>
$(document).ready(function() {
    // ... existing ready function code ...

    // Add this new code for the modal functionality
    $(document).on('click', '.view-specimen', function(e) {
        e.preventDefault();
        var imageUrl = $(this).data('file');
        console.log('Image URL:', imageUrl); // Tambahkan ini
        $('#specimenImage').attr('src', imageUrl);
        $('#specimenModal').modal('show');
    });

    // Prevent image download
    $('#specimenImage').on('dragstart', function(e) { e.preventDefault(); });

    // Debug: Check if modal exists
    console.log('Modal element exists:', $('#specimenModal').length > 0);
});

// Nonaktifkan klik kanan pada modal
$('#specimenModal').on('contextmenu', function(e) {
    e.preventDefault();
});

// Nonaktifkan drag pada gambar
$('#specimenImage').on('dragstart', function(e) {
    e.preventDefault();
});
</script>
   <?php echo $this->endSection();