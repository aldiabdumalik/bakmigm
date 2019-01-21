<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="X-Content-Type-Options: nosniff, width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<title>View Document</title>
	<meta name="description" content="RL" />
	<meta name="author" content="RL" />
	<link rel="icon" href="<?php echo base_url('template/rion/'.$this->M_library_module->WEB_ICON); ?>" />

	<!-- CSS / JAVA SCRIPT / BOOTSTRAP / ETC -->
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/font-awesome/4.5.0/css/font-awesome.min.css'); ?>" />

	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/jquery-ui.custom.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/jquery.gritter.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/select2.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-editable.min.css'); ?>" />

	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/prettify.min.css'); ?>" />

	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/chosen.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-datepicker3.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-timepicker.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/daterangepicker.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-datetimepicker.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-colorpicker.min.css'); ?>" />

	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-duallistbox.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/bootstrap-multiselect.min.css'); ?>" />

	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/fonts.googleapis.com.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style'); ?>" />
	<!--[if lte IE 9]>
		<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace-part2.min.css" class="ace-main-stylesheet'); ?>" />
	<![endif]-->
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace-skins.min.css'); ?>" />
	<link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace-rtl.min.css'); ?>" />
	<!--[if lte IE 9]>
	  <link rel="stylesheet" href="<?php echo base_url('template/backend/assets/css/ace-ie.min.css'); ?>" />
	<![endif]-->
	<script src="<?php echo base_url('template/backend/assets/js/ace-extra.min.js'); ?>"></script>
	<!--[if lte IE 8]>
	<script src="<?php echo base_url('template/backend/assets/js/html5shiv.min.js'); ?>"></script>
	<script src="<?php echo base_url('template/backend/assets/js/respond.min.js'); ?>"></script>
	<![endif]-->
</head>
<body class="no-skin">
	<div id="navbar" class="navbar navbar-default ace-save-state">
		<div class="navbar-container ace-save-state" id="navbar-container">
			<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
				<span class="sr-only">Toggle sidebar</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<div class="navbar-header pull-left">
				<a href="<?php echo base_url('C_index'); ?>" class="navbar-brand">
					<small>
						<img class="nav-user-photo" src="<?php echo base_url('template/backend/assets/images/avatars/logo.png'); ?>" />
					</small>
				</a>
			</div>

			<div class="navbar-buttons navbar-header pull-right" role="navigation">
				<!-- no content -->
			</div>
		</div><!-- /.navbar-container -->
	</div>
	<div class="main-container ace-save-state" id="main-container">
		<div class="main-content">
			<div class="main-content-inner">
				<div class="page-content">
					<div class="row">
						<div class="col-md-12">
							<?php 
							if (
								$ext=='pdf' ||
								$ext=='doc' ||
								$ext=='docx' ||
								$ext=='xls' ||
								$ext=='xlsx' ||
								$ext=='ppt' ||
								$ext=='pptx' ||
								$ext=='vsd' ||
								$ext=='vsdx' ||
								$ext=='jpg' ||
								$ext=='Jpg' ||
								$ext=='jpeg' ||
								$ext=='JPEG' ||
								$ext=='png' ||
								$ext=='PNG' ||
								$ext=='bmp' ||
								$ext=='BMP'
							): ?>
							<div class="embed-responsive embed-responsive-16by9" style="height:500px;">
								<object data="<?=$url;?>#toolbar=0&navpanes=0&scrollbar=0" class="mbed-responsive-item">
								</object>
							</div>
							<?php else: ?>
							<video width="100%" controlsList="nodownload" height="500px" src="<?= $url; ?>" controls></video>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- JAVA SCRIPT / BOOTSTRAP / ETC -->
<!--[if !IE]> -->
<script src="<?php echo base_url('template/backend/assets/js/jquery-2.1.4.min.js'); ?>"></script>
<!-- <![endif]-->
<!--[if IE]>
<script src="<?php echo base_url('template/backend/assets/js/jquery-1.11.3.min.js'); ?>"></script>
<![endif]-->
<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url('template/backend/assets/js/jquery.mobile.custom.min.js'); ?>'>"+"<"+"/script>");
</script>
<script src="<?php echo base_url('template/backend/assets/js/bootstrap.min.js'); ?>"></script>

<!--[if lte IE 8]>
  <script src="<?php echo base_url('template/backend/assets/js/excanvas.min.js'); ?>"></script>
<![endif]-->
<script src="<?php echo base_url('template/backend/assets/js/jquery-ui.custom.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/jquery.ui.touch-punch.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/jquery.gritter.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/bootbox.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/jquery.easypiechart.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/bootstrap-datepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/jquery.hotkeys.index.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/bootstrap-wysiwyg.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/select2.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/spinbox.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/bootstrap-editable.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/ace-editable.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/jquery.maskedinput.min.js'); ?>"></script>

<script src="<?php echo base_url('template/backend/assets/js/prettify.min.js'); ?>"></script>

<script src="<?php echo base_url('template/backend/assets/js/chosen.jquery.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/bootstrap-timepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/moment.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/daterangepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/bootstrap-datetimepicker.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/bootstrap-colorpicker.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/jquery.knob.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/autosize.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/jquery.inputlimiter.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/bootstrap-tag.min.js'); ?>"></script>

<script src="<?php echo base_url('template/backend/assets/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/jquery.dataTables.bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/dataTables.buttons.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/buttons.flash.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/buttons.html5.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/buttons.print.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/buttons.colVis.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/dataTables.select.min.js'); ?>"></script>

<script src="<?php echo base_url('template/backend/assets/js/jquery.bootstrap-duallistbox.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/jquery.raty.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/bootstrap-multiselect.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/jquery-typeahead.js'); ?>"></script>

<script src="<?php echo base_url('template/backend/assets/js/ace-elements.min.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/ace.min.js'); ?>"></script>

<script src="<?php echo base_url('template/rion/jquery_costum.js'); ?>"></script>
<script src="<?php echo base_url('template/backend/assets/js/sweetalert.min.js'); ?>"></script>
</body>
</html>