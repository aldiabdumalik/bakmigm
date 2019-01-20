<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
$SESSION_ID = $this->session->userdata("session_bgm_edocument_id");
$SESSION_EMAIL = $this->session->userdata("session_bgm_edocument_email");

$SESSION_DIREKTORAT_ID = $this->session->userdata("session_bgm_edocument_direktorat_id");
$SESSION_DIREKTORAT_NAME = $this->session->userdata("session_bgm_edocument_direktorat_name");

$SESSION_DIVISI_ID = $this->session->userdata("session_bgm_edocument_divisi_id");
$SESSION_DIVISI_CODE = $this->session->userdata("session_bgm_edocument_divisi_code");
$SESSION_DIVISI_NAME = $this->session->userdata("session_bgm_edocument_divisi_name");

$SESSION_DEPARTEMENT_ID = $this->session->userdata("session_bgm_edocument_departement_id");
$SESSION_DEPARTEMENT_CODE = $this->session->userdata("session_bgm_edocument_departement_code");
$SESSION_DEPARTEMENT_NAME = $this->session->userdata("session_bgm_edocument_departement_name");

$SESSION_ROLES = $this->session->userdata("session_bgm_edocument_roles");

$SESSION_JOB_LEVEL_ID = $this->session->userdata("session_bgm_edocument_job_level_id");
$SESSION_JOB_LEVEL_NAME = $this->session->userdata("session_bgm_edocument_job_level_name");
$SESSION_JOB_LEVEL_INDEX = $this->session->userdata("session_bgm_edocument_job_level_index");
//-----------------------------------------------------------------------------------------------//
$is_continue = true;
$count_notification = 0;
$count_news = 0;
//-----------------------------------------------------------------------------------------------//
//NOTIFICATION
if ($SESSION_ROLES == "PENDISTRIBUSI") {
	$get_data_ext = $this->M_library_database->DB_GET_SEARCH_DATA_DOCUMENT_ARRAY("","","","","","");
	if (empty($get_data_ext)) {
		$is_continue = false;
	}else{	
		foreach ($get_data_ext as $data_row_ext) {
			$DOC_PENDISTRIBUSI = $data_row_ext->DOC_PENDISTRIBUSI;
			$DI_CODE = $data_row_ext->DI_CODE;
		}
		if ($SESSION_DEPARTEMENT_ID==$DOC_PENDISTRIBUSI) {
			$count_notification = count($get_data_ext);
		}else{
			$is_continue = false;
		}
	}
}
if ($SESSION_ROLES == "ATASAN PENCIPTA") {
	$get_data_ext = $this->M_library_database->DB_GET_SEARCH_DATA_DOCUMENT_ARRAY("","","","","","");
	if (empty($get_data_ext)) {
		$is_continue = false;
	}else{	
		foreach ($get_data_ext as $data_row_ext) {
			$DOC_PENDISTRIBUSI = $data_row_ext->DOC_PENDISTRIBUSI;
			$DI_CODE = $data_row_ext->DI_CODE;
		}
		if ($SESSION_DEPARTEMENT_ID==$DOC_PENDISTRIBUSI||$SESSION_DIVISI_CODE==$DI_CODE) {
			$count_notification = count($get_data_ext);
		}else{
			$is_continue = false;
		}
	}
}
if($SESSION_ROLES=="PENCIPTA"){
	//$DOC_ID,$DOC_NOMOR,$DOC_NAMA,$DOC_MAKER,$DOC_APPROVE,$DOC_STATUS,$DN_ID
	$get_data_ext = $this->M_library_database->DB_GET_SEARCH_DATA_DOCUMENT_ARRAY("","","",$SESSION_ID,"","",$SESSION_DEPARTEMENT_ID);
	if(empty($get_data_ext)||$get_data_ext==""){
		$is_continue = false;
	}else{
		$count_notification = count($get_data_ext);
	}
}
if($SESSION_ROLES=="PENGGUNA"){
	$is_continue = false;
}
//-----------------------------------------------------------------------------------------------//
//NEWS
//$DOC_AKSES_LEVEL,$DOC_PENGGUNA
$get_data_count = $this->M_library_database->DB_GET_SEARCH_NEWS_DATA_DOCUMENT_ARRAY_EVO($SESSION_JOB_LEVEL_ID,$SESSION_DEPARTEMENT_ID);
if(empty($get_data_count)||$get_data_count==""){
	//DO NOTHING
}else{
	$count_news = count($get_data_count);	
}

$count_notification = $count_notification + $count_news;
//-----------------------------------------------------------------------------------------------//
?>
<!------------------------------------------------------------------------------------------------->
<!DOCTYPE html>
<html lang="en">
<!------------------------------------------------------------------------------------------------->
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="viewport" content="X-Content-Type-Options: nosniff, width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<title><?php echo $this->M_library_module->WEB_TITLE; ?></title>
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
<!------------------------------------------------------------------------------------------------->
<body class="no-skin">
	<!------------------------------------------------------------------------------------------------->
	<!-- CONTENT -->
	<div id="navbar" class="navbar navbar-default ace-save-state">
		<div class="navbar-container ace-save-state" id="navbar-container">
			<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
				<span class="sr-only">Toggle sidebar</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>

			<div class="navbar-header pull-left">
				<a href="<?php echo base_url(); ?>" class="navbar-brand">
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
		<script type="text/javascript">
			try{ace.settings.loadState('main-container')}catch(e){}
		</script>

		<div id="sidebar" class="sidebar responsive ace-save-state">
			<script type="text/javascript">
				try{ace.settings.loadState('sidebar')}catch(e){}
			</script>

			<div id="user-profile-1" class="user-profile row">
				<div class="col-12 center">
					<span class="profile-picture">
						<img id="avatar" class="editable img-responsive" src="<?php echo base_url('template/backend/assets/images/avatars/profile-pic.jpg'); ?>" />
					</span>
					<br />
					<i class="menu-icon fa fa-user"></i>
					<span class="menu-text">
						<?php echo $SESSION_ID; ?>
					</span>
					<br />
				</div>
			</div>
			


			<ul class="nav nav-list">

				<li class="active">
					<a href="<?php echo base_url('document-search'); ?>">
						<i class="menu-icon fa fa-history"></i>
						<span class="menu-text"> Pencarian </span>
					</a>
					<b class="arrow"></b>
				</li>
				
				<li class="">
					<a href="<?php echo base_url('bookmarks'); ?>">
						<i class="menu-icon fa fa-bookmark"></i>
						<span class="menu-text"> Favorit </span>
					</a>
					<b class="arrow"></b>
				</li>
				
				<?php if(
				$SESSION_ROLES=="PENGGUNA"||
				$SESSION_ROLES=="PENCIPTA"||
				$SESSION_ROLES=="PENDISTRIBUSI"||
				$SESSION_ROLES=="ATASAN PENCIPTA"
				){ ?>
				<li class="">
					<a href="<?php echo base_url('notification'); ?>">
						<i class="menu-icon fa fa-exclamation"></i>
						<span class="menu-text">
							Aktifitas
							<span class="badge badge-primary"><?php echo $count_notification; ?></span>
						</span>
					</a>
					<b class="arrow"></b>
				</li>
				<?php } ?>
				
				<?php if($SESSION_ROLES=="PENCIPTA"){ ?>
				<li class="">
					<a href="<?php echo base_url('contribution'); ?>">
						<i class="menu-icon fa fa-database"></i>
						<span class="menu-text"> Kontribusi </span>
					</a>
					<b class="arrow"></b>
				</li>
				<?php } ?>
				
				<?php if(
				$SESSION_ROLES=="PENCIPTA"||
				$SESSION_ROLES=="ADMIN DOKUMEN"
				){ ?>
				<li class="">
					<a href="<?php echo base_url('report'); ?>">
						<i class="menu-icon fa fa-database"></i>
						<span class="menu-text"> Laporan </span>
					</a>
					<b class="arrow"></b>
				</li>
				<?php } ?>

				<?php if($SESSION_ROLES=="ADMIN KONFIGURASI"){ ?>
				<li class="">
					<a href="#" class="dropdown-toggle">
						<i class="menu-icon fa fa-cog"></i>
						<span class="menu-text"> Setting </span>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<li class="">
							<a href="<?php echo base_url('C_setting_data_master'); ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								Data Master
							</a>
							<b class="arrow"></b>
						</li>
						<li class="">
							<a href="<?php echo base_url('C_setting_structure_organization'); ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								Struktur Organisasi
							</a>
							<b class="arrow"></b>
						</li>
						<li class="">
							<a href="<?php echo base_url('C_setting_user'); ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								User
							</a>
							<b class="arrow"></b>
						</li>
						<li class="">
							<a href="<?php echo base_url('C_setting_structure_document'); ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								Struktur Dokumen
							</a>
							<b class="arrow"></b>
						</li>
						<li class="">
							<a href="<?php echo base_url('C_setting_business_rule'); ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								Aturan Bisnis
							</a>
							<b class="arrow"></b>
						</li>
						<li class="">
							<a href="<?php echo base_url('C_setting_document_level_access'); ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								Tingkat Akses Dokumen
							</a>
							<b class="arrow"></b>
						</li>
					</ul>
				</li>
				<?php } ?>

				<li class="">
					<a href="<?php echo base_url('C_menu/logout'); ?>">
						<i class="menu-icon fa fa-power-off"></i>
						<span class="menu-text"> Keluar </span>
					</a>
					<b class="arrow"></b>
				</li>

			</ul><!-- /.nav-list -->
		</div>

		<div class="main-content">
			<div class="main-content-inner">
				<div class="page-content">
					<!------------------------------------------------------------------------------------------------->
					<!-- PAGE CONTENT BEGINS -->
					<!------------------------------------------------------------------------------------------------->
					<div class="row">
						<div class="center">
							<p class="lead">
								Halo <?php echo $SESSION_ID; ?>, Selamat datang di e-Document
							</p>
							<ul class="list-unstyled spaced">
								<li>
									<h1>
										<img class="nav-user-photo" src="<?php echo base_url('template/backend/assets/images/avatars/logo_big.png'); ?>"/> e-DOKUMEN
									</h1>
								</li>
							</ul>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
							<div id="accordion" class="accordion-style1 panel-group">
								<form class="form-horizontal" id="form_search" name="form_search" action="<?php echo base_url('search'); ?>" method="POST">
									<div class="input-group">
										<span class="input-group-addon">
											<i class="ace-icon fa fa-check"></i>
										</span>
										<input type="text" id="keyword" name="keyword" class="form-control" placeholder="Search (Write A Keyword)" />
										<span class="input-group-btn">
											<button type="submit" id="search" name="cari" class="btn btn-purple btn-sm">
												<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
												Search
											</button>
										</span>
									</div>
								</form>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
							<div id="accordion" class="accordion-style1 panel-group">
								<div class="panel panel-default">
									<div class="panel-heading">
										<h4 class="panel-title">
											<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse_advance_search">
												<i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i> Pencarian Lanjutan
											</a>
										</h4>
									</div>
									<div class="panel-collapse collapse" id="collapse_advance_search">
										<div class="panel-body">
											<form class="form-horizontal" id="form_advance_search" name="form_advance_search" action="<?php echo base_url('advanced-search'); ?>" method="post" enctype="multipart/form-data">
												<div class="form-group">
													<label for="si_doc_type" class="col-sm-4 control-label" style="text-align:left">Tipe Dokumen</label>
													<div class="col-sm-8">
														<select id="si_doc_type" name="si_doc_type" class="form-control">
															<option value="">Pilih</option>
															<?php
															$is_continue = true;
															$get_data_ext = $this->M_library_database->DB_GET_DATA_DOCUMENT_STRUCTURE_TIPE_ALL();
															if(empty($get_data_ext)||$get_data_ext==""){
																	$is_continue = false;
															}
															if($is_continue){
																foreach($get_data_ext as $data_row_ext){
																	?>
																	<option value="<?php echo $data_row_ext->DTSETE_ID; ?>"><?php echo $data_row_ext->DTSETE_TIPE; ?></option>
																	<?php
																}
															}
															?>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label for="ssa_dept_owner" class="col-sm-4 control-label" style="text-align:left">Dept Pemilik</label>
													<div class="col-sm-8">
														<select id="ssa_dept_owner" name="ssa_dept_owner" class="form-control">
															<option value="">Pilih</option>
															<option value="<?php echo $SESSION_DIVISI_ID; ?>"><?php echo $SESSION_DIVISI_NAME; ?></option>
															<option value="<?php echo $SESSION_DEPARTEMENT_ID; ?>"><?php echo $SESSION_DEPARTEMENT_NAME; ?></option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label for="ssa_group_proces" class="col-sm-4 control-label" style="text-align:left">Group Proses</label>
													<div class="col-sm-8">
														<select id="ssa_group_proces" name="ssa_group_proces" class="form-control">
															<option value="">Pilih</option>
															<option value="GROUP PROSES">GROUP PROSES</option>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label for="ssa_proces" class="col-sm-4 control-label" style="text-align:left">Proses</label>
													<div class="col-sm-8">
														<select id="ssa_proces" name="ssa_proces" class="form-control">
															<option value="">Pilih</option>
															<option value="PROSES">PROSES</option>
														</select>
													</div>
												</div>
												<button type="submit" id="btn_advance_search" name="btn_advance_search" class="btn btn-purple btn-sm">
													<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
													Search
												</button>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row" id="table">
						<table id="example" class="table table-bordered table-striped table-hovered example">
							<thead>
								<tr>
									<!-- <th>Kode Dokumen</th> -->
									<th>Nama Dokumen</th>
									<th>Pemilik Proses / Dept</th>
									<th>Tgl Upload</th>
									<th>Status Dokumen</th>
									<th>Aging</th>
									<th>Action</th>
								</tr>
							</thead>
							<?php if ($is_continue) : ?>
							<?php foreach ($detail as $key) : ?>
								
								<?php 
								date_default_timezone_set('Asia/Jakarta');
								$DOC_DATE = date('Y-m-d',strtotime($key['DOC_DATE']));

								$tanggal = new DateTime($DOC_DATE);
								$today = new DateTime('today');
								$y = $today->diff($tanggal)->y;
								$m = $today->diff($tanggal)->m;
								$d = $today->diff($tanggal)->d;
								?>
								<tbody>
									<tr>
										<!-- <td><?php echo $key['DOC_ID']?></td> -->
										<td><?php echo $key['DOC_NAMA']?></td>
										<td><?php echo $key['DN_NAME']?></td>
										<td><?php echo date('d/m/Y G:s',strtotime($key['DOC_DATE']))?></td>
										<td><?php echo $key['DOC_STATUS']?></td>
										<td><?php echo "" . $y . " tahun " . $m . " bulan " . $d . " hari";?></td>
										<td>
											<a href="<?php echo base_url('document-details-'.$key['DOC_ID']) ?>" class="fa fa-eye" style="font-size: 2rem;text-decoration: none;color: black;" target="_blank"></a>
											<a style="font-size: 2rem;text-decoration: none;color: black;" class="fa fa-download" href="<?=base_url('download-'.$key['DOC_ID'].".zip");?>" id="btn-unduh" class="btn btn-sm btn-warning"></a>
										</td>
									</tr>
								</tbody>
							<?php endforeach; ?>
						<?php endif; ?>
						</table>
					</div>
					<!------------------------------------------------------------------------------------------------->
					<!-- PAGE CONTENT ENDS -->
					<!------------------------------------------------------------------------------------------------->
				</div><!-- /.page-content -->
			</div>
		</div><!-- /.main-content -->

		<div class="footer"></div>

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
			<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
		</a>
	</div><!-- /.main-container -->
	<!------------------------------------------------------------------------------------------------->
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
	
	<script type="text/javascript">
		$(document).ready( function () {
			$('#example').DataTable({
				"searching": false
			});
		});

		jQuery(function($) {
			//------------------------------------------------------------------------------------------------//
			//------------------------------------------------------------------------------------------------//
			//------------------------------------------------------------------------------------------------//
			$('#avatar').on('click', function(){
				var modal = 
				'<div class="modal fade">\
				  <div class="modal-dialog">\
				   <div class="modal-content">\
					<div class="modal-header">\
						<button type="button" class="close" data-dismiss="modal">&times;</button>\
						<h4 class="blue">Change Avatar</h4>\
					</div>\
					\
					<form class="no-margin">\
					 <div class="modal-body">\
						<div class="space-4"></div>\
						<div style="width:75%;margin-left:12%;"><input type="file" name="file-input" /></div>\
					 </div>\
					\
					 <div class="modal-footer center">\
						<button type="submit" class="btn btn-sm btn-success"><i class="ace-icon fa fa-check"></i> Submit</button>\
						<button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancel</button>\
					 </div>\
					</form>\
				  </div>\
				 </div>\
				</div>';
				
				var modal = $(modal);
				modal.modal("show").on("hidden", function(){
					modal.remove();
				});
			
				var working = false;
			
				var form = modal.find('form:eq(0)');
				var file = form.find('input[type=file]').eq(0);
				file.ace_file_input({
					style:'well',
					btn_choose:'Click to choose new avatar',
					btn_change:null,
					no_icon:'ace-icon fa fa-picture-o',
					thumbnail:'small',
					before_remove: function() {
						//don't remove/reset files while being uploaded
						return !working;
					},
					allowExt: ['jpg', 'jpeg', 'png', 'gif'],
					allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif']
				});
			
				form.on('submit', function(){
					if(!file.data('ace_input_files')) return false;
					
					file.ace_file_input('disable');
					form.find('button').attr('disabled', 'disabled');
					form.find('.modal-body').append("<div class='center'><i class='ace-icon fa fa-spinner fa-spin bigger-150 orange'></i></div>");
					
					var deferred = new $.Deferred;
					working = true;
					deferred.done(function() {
						form.find('button').removeAttr('disabled');
						form.find('input[type=file]').ace_file_input('enable');
						form.find('.modal-body > :last-child').remove();
						
						modal.modal("hide");
			
						var thumb = file.next().find('img').data('thumb');
						if(thumb) $('#avatar').get(0).src = thumb;
			
						working = false;
					});
					
					setTimeout(function(){
						deferred.resolve();
					} , parseInt(Math.random() * 800 + 800));
			
					return false;
				});
			});
		});

		// $(document).ready(function(){
		// 	var table = $('#example').DataTable({	
		// 		serverSide: true,
		// 		"ajax":{
		// 			"url": "<?php echo base_url('C_contribution/getDocumentList');?>",
		// 			"dataType": "json",
		// 			"type": "GET",
		// 		},
		// 		"column": [
		// 		{
		// 			"targets": [ 7 ],
		// 			"visible": false
		// 		},
		// 		],
		// 		"columns": [
		// 		{ "data": "DOC_ID" },
		// 		{ "data": "DOC_NAMA" },
		// 		{ "data": "DN_NAME" },
		// 		{ "data": "DOC_DATE" },
		// 		{ "data": "DOC_STATUS" },
		// 		{ "data": "DOCD_UTAMA", render: function(data, type, row) {
		// 			return "<a target='_blank' href='<?php echo base_url('assets/pdf/');?>"+data+"'>"+data+"</a>";
		// 		}},
		// 		],	
		// 	});
		// });
	</script>
	<!------------------------------------------------------------------------------------------------->
</body>
<!------------------------------------------------------------------------------------------------->
</html>
<!------------------------------------------------------------------------------------------------->