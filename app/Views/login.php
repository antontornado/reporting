<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>Reporting Service</title>
	<link rel="stylesheet" href="<?=base_url()?>/assets/mylogin/vendor/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>/assets/mylogin/css/my-login.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url();?>/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url();?>/adminlte/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="<?=base_url();?>/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <style>
    @media (max-width: 767px) {
        .my-login-page .card-wrapper {
            width: 95%;
            margin: 0 auto;
        }
        .my-login-page .card {
            margin-top: 20px;
        }
        .my-login-page .brand {
            margin-bottom: 20px;
        }
        .my-login-page .card-body {
            padding-left: 15px;
            padding-right: 15px;
        }
    }
  </style>
</head>

<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-center align-items-center h-100">
				<div class="card-wrapper">
					<div class="brand">
					
					</div>
					<div class="card fat">
					<div>
						<img src="<?=base_url();?>/adminlte/dist/img/logoapp.png" alt="AdminLTE Logo" class="brand-image" style="opacity: .8;height:40px;">
						<span class="brand-text font-weight-thick" style="font-size:20px"><b>Link</b>Report</span>
					</div>	
						<div class="card-body">
							<form method="POST" class="my-login-validation" novalidate="" action="<?=base_url()?>Users/login">
								<div class="form-group">
									<label for="email">Username</label>
									<input id="email" type="text" class="form-control" name="namauser" value="" required autofocus>
									<div class="invalid-feedback">harus diisi
									</div>
								</div>
								<div class="form-group">
									<label for="password">Password
									<input id="password" type="password" class="form-control" name="password" required data-eye>
								    <div class="invalid-feedback">
								    	harus diisi
							    	</div>
								</div>
								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Login
									</button>
								</div>
								<div class="form-group">
										<a href="<?=base_url()?>/home/lupapassword" class="float-right">
										</a>
									</label>
								</div>
								
							</form>
						</div>
					</div>
					<div>
	
					</div>
					<div class="box-body">
					<?php if(!empty($statusError)){?>
<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
<h4><i class="icon fa fa-ban"></i> Error!</h4>
<?php echo $statusError;?>
</div>
<?php }?>
					<div class="footer">
						Created &copy; 2024 &mdash; @ntonius
					</div>
				</div>
			</div>
		</div>

	</section>

	<script src="<?=base_url()?>/assets/mylogin/vendor/jquery/jquery.slim.min.js"></script>
	<script src="<?=base_url()?>/assets/mylogin/vendor/popper/popper.min.js"></script>
	<script src="<?=base_url()?>/assets/mylogin/vendor/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=base_url()?>/assets/mylogin/js/my-login.js"></script>

</body>
</html>