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

// New Notifiacation
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
<style type="text/css">
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
	-webkit-appearance: none;
	-moz-appearance: none;
	appearance: none;
	margin: 0; 
}
input[readonly] {
	background-color: white !important;
}
.alert {
  margin-bottom : 3px !important;
}
.modal-dialog1 {
	width: 100%;
	height: 100%;
	padding: 0;
	margin:0;
}
</style>
</head>
<!------------------------------------------------------------------------------------------------->
<body class="no-skin">
	<div id="navbar" class="navbar navbar-default ace-save-state navbar-fixed-top">
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
		<script type="text/javascript">
			try{ace.settings.loadState('main-container')}catch(e){}
		</script>

		<div id="sidebar" class="sidebar responsive ace-save-state sidebar-fixed">
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
				<li class="">
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
				<li class="active">
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

		<!-- Content -->
		<div class="main-content">
			<div class="main-content-inner">
				<div class="page-content">
					<div class="row">

						<div class="widget-box">
							<div class="widget-header">
								<h4 class="smaller">
									Notification
								</h4>
							</div>
						</div>
						<?php
						if($is_continue):
							foreach ($get_data_ext as $data_row_ext):
								$FILTER = $data_row_ext->DOC_STATUS;
								// Tanggal
								date_default_timezone_set('Asia/Jakarta');
								$sekarang = date('Y-m-d');
								$exp = $data_row_ext->DOC_TGL_EXPIRED;
								$sebulan = date('Y-m-d', strtotime('+1 month', strtotime($data_row_ext->DOC_TGL_EXPIRED)));
								$tgl_efektif = new DateTime($sekarang);
								$kadaluarsa = new DateTime($exp);
								$tgl_final = $kadaluarsa->diff($tgl_efektif)->format("%a");

								$sebulan2 = new DateTime($sebulan);
								$arcived = $sebulan2->diff($tgl_efektif)->format("%a");
						?>
						<!-- Notification Pendistribusi -->
						<?php if ($SESSION_ROLES=="PENDISTRIBUSI" && $FILTER=="MENUNGGU PENDISTRIBUSI"): ?>
							<div class="alert alert-warning fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?php echo $data_row_ext->DOC_NAMA; ?>, perlu persetujuan Anda!
										<br/>
										<?php echo date('d/m/Y G:i', strtotime($data_row_ext->DOC_DATE));?> WIB
									</div>
									<div class="col-xs-2" style="text-align:right;">
										<a data-toggle="modal" data-target="#modal-preview<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-eye btn btn-sm btn-warning" data-popup="tooltip" data-placement="top" title="Preview"></a>
									</div>
									<!-- <div class="col-xs-2">
										<form id="form_approve[]" name="form_approve[]" action="<?php echo base_url('C_notification/approve'); ?>" method="post" enctype="multipart/form-data">
										<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
										<input type="hidden" id="si_approver" name="si_approver" class="form-control" value="<?=$SESSION_ROLES;?>">
										<button type="submit" class="ace-icon fa fa-check btn btn-sm btn-primary"></button>
										<a data-toggle="modal" data-target="#modal-reject<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-ban btn btn-sm btn-danger" data-popup="tooltip" data-placement="top" title="Reject"></a>
										<a data-toggle="modal" data-target="#modal-preview<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-eye btn btn-sm btn-warning" data-popup="tooltip" data-placement="top" title="Preview"></a>
										</form>
									</div> -->
								</div>
							</div>
						<?php elseif ($SESSION_ROLES=="PENDISTRIBUSI" && $FILTER=="MENUNGGU ATASAN PENCIPTA"): ?>
							<div class="alert alert-warning fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?php echo $data_row_ext->DOC_NAMA; ?>, <?php echo $data_row_ext->DOC_STATUS_ACTIVITY; ?>
										<br/>
										<?php echo date('d/m/Y G:i', strtotime($data_row_ext->DOC_DATE));?> WIB
									</div>
									<div class="col-xs-2" style="text-align:right;">
										<a data-toggle="modal" data-target="#modal-preview<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-eye btn btn-sm btn-warning" data-popup="tooltip" data-placement="top" title="Preview"></a>
									</div>
								</div>
							</div>
						<?php elseif ($SESSION_ROLES=="PENDISTRIBUSI" && $FILTER=="DITOLAK PENDISTRIBUSI"): ?>
							<div class="alert alert-warning fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?php echo $data_row_ext->DOC_NAMA; ?>, <?php echo $data_row_ext->DOC_STATUS_ACTIVITY; ?>
										<br/>
										<?php echo date('d/m/Y G:i', strtotime($data_row_ext->DOC_DATE));?> WIB
									</div>
									<div class="col-xs-2" style="text-align:right;">
										<a data-toggle="modal" data-target="#modal-preview<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-eye btn btn-sm btn-warning" data-popup="tooltip" data-placement="top" title="Preview"></a>
									</div>
								</div>
							</div>
						<?php elseif ($SESSION_ROLES=="PENDISTRIBUSI" && $FILTER=="DITOLAK ATASAN PENCIPTA"): ?>
							<div class="alert alert-warning fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?php echo $data_row_ext->DOC_NAMA; ?>, <?php echo $data_row_ext->DOC_STATUS_ACTIVITY; ?>
										<br/>
										<?php echo date('d/m/Y G:i', strtotime($data_row_ext->DOC_DATE));?> WIB
									</div>
									<div class="col-xs-2" style="text-align:right;">
										<a data-toggle="modal" data-target="#modal-preview<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-eye btn btn-sm btn-warning" data-popup="tooltip" data-placement="top" title="Preview"></a>
									</div>
								</div>
							</div>
						<!-- Notification Atasan Pencipta -->
						<?php elseif ($SESSION_ROLES=="ATASAN PENCIPTA" && $FILTER=="MENUNGGU ATASAN PENCIPTA"): ?>
							<div class="alert alert-warning fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?php echo $data_row_ext->DOC_NAMA; ?>, perlu persetujuan Anda!
										<br/>
										<?php echo date('d/m/Y G:i', strtotime($data_row_ext->DOC_DATE));?> WIB
									</div>
									<div class="col-xs-2" style="text-align:right;">
										<a data-toggle="modal" data-target="#modal-preview<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-eye btn btn-sm btn-warning" data-popup="tooltip" data-placement="top" title="Preview"></a>
									</div>
									<!-- <div class="col-xs-2">
										<form id="form_approve[]" name="form_approve[]" action="<?php echo base_url('C_notification/approve'); ?>" method="post" enctype="multipart/form-data">
										<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
										<input type="hidden" id="si_approver" name="si_approver" class="form-control" value="<?=$SESSION_ROLES;?>">
										<button type="submit" class="ace-icon fa fa-check btn btn-sm btn-primary"></button>
										<a data-toggle="modal" data-target="#modal-reject<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-ban btn btn-sm btn-danger" data-popup="tooltip" data-placement="top" title="Reject"></a>
										<a data-toggle="modal" data-target="#modal-preview<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-eye btn btn-sm btn-warning" data-popup="tooltip" data-placement="top" title="Preview"></a>
										</form>
									</div> -->
								</div>
							</div>
						<?php elseif ($SESSION_ROLES=="ATASAN PENCIPTA" && $FILTER=="MENUNGGU PENDISTRIBUSI"): ?>
							<div class="alert alert-warning fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?php echo $data_row_ext->DOC_NAMA; ?>, <?php echo $data_row_ext->DOC_STATUS_ACTIVITY; ?>
										<br/>
										<?php echo date('d/m/Y G:i', strtotime($data_row_ext->DOC_DATE));?> WIB
									</div>
									<div class="col-xs-2" style="text-align:right;">
										<a data-toggle="modal" data-target="#modal-preview<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-eye btn btn-sm btn-warning" data-popup="tooltip" data-placement="top" title="Preview"></a>
									</div>
								</div>
							</div>
						<?php elseif ($SESSION_ROLES=="ATASAN PENCIPTA" && $FILTER=="DITOLAK PENDISTRIBUSI"): ?>
							<div class="alert alert-warning fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?php echo $data_row_ext->DOC_NAMA; ?>, <?php echo $data_row_ext->DOC_STATUS_ACTIVITY; ?>
										<br/>
										<?php echo date('d/m/Y G:i', strtotime($data_row_ext->DOC_DATE));?> WIB
									</div>
									<div class="col-xs-2" style="text-align:right;">
										<a data-toggle="modal" data-target="#modal-preview<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-eye btn btn-sm btn-warning" data-popup="tooltip" data-placement="top" title="Preview"></a>
									</div>
								</div>
							</div>
						<?php elseif ($SESSION_ROLES=="ATASAN PENCIPTA" && $FILTER=="DITOLAK ATASAN PENCIPTA"): ?>
							<div class="alert alert-warning fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?php echo $data_row_ext->DOC_NAMA; ?>, <?php echo $data_row_ext->DOC_STATUS_ACTIVITY; ?>
										<br/>
										<?php echo date('d/m/Y G:i', strtotime($data_row_ext->DOC_DATE));?> WIB
									</div>
									<div class="col-xs-2" style="text-align:right;">
										<a data-toggle="modal" data-target="#modal-preview<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-eye btn btn-sm btn-warning" data-popup="tooltip" data-placement="top" title="Preview"></a>
									</div>
								</div>
							</div>
						<!-- Notification Pencipta -->
						<?php elseif($SESSION_ROLES=="PENCIPTA" && $FILTER == "DITOLAK PENDISTRIBUSI"): ?>
							<div class="alert alert-danger fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?php echo $data_row_ext->DOC_NAMA; ?>, <?php echo $data_row_ext->DOC_STATUS_ACTIVITY; ?>. Mohon untuk segera di perbaiki!
										<br/>
										<?php
										$get_data_info_reject = $this->M_library_database->DB_GET_DATA_DOCUMENT_DETAIL_STATUS_BY_ID_EVO($data_row_ext->DOC_ID);
										$index_info_reject = 1;
											foreach($get_data_info_reject as $data_row_info_reject){
										?>
												<b>
												<?php echo $index_info_reject; ?>. Oleh : <?php echo $data_row_info_reject->DTDLSS_MAKER; ?>, Note : <?php echo $data_row_info_reject->DTDLSS_NOTE; ?>. Pada : <?php echo date('d/m/Y G:i', strtotime($data_row_info_reject->DTDLSS_DATE)); ?> WIB
												<br/>
												</b>
										<?php
												$index_info_reject++;
											}
										?>
									</div>
									<div class="col-xs-2" style="text-align:right;">
										<form id="form_revisi[]" name="form_revisi[]" action="<?php echo base_url('C_notification/revisi'); ?>" method="post" enctype="multipart/form-data">
										<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
										<button type="submit" class="ace-icon fa fa-pencil btn btn-sm btn-danger"></button>
										</form>
									</div>
								</div>
							</div>
						<?php elseif($SESSION_ROLES=="PENCIPTA" && $FILTER == "DITOLAK ATASAN PENCIPTA"): ?>
							<div class="alert alert-danger fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?php echo $data_row_ext->DOC_NAMA; ?>, <?php echo $data_row_ext->DOC_STATUS_ACTIVITY; ?>. Mohon untuk segera di perbaiki!
										<br/>
										<?php
										$get_data_info_reject = $this->M_library_database->DB_GET_DATA_DOCUMENT_DETAIL_STATUS_BY_ID_EVO($data_row_ext->DOC_ID);
										$index_info_reject = 1;
											foreach($get_data_info_reject as $data_row_info_reject){
										?>
												<b>
												<?php echo $index_info_reject; ?>. Oleh : <?php echo $data_row_info_reject->DTDLSS_MAKER; ?>, Note : <?php echo $data_row_info_reject->DTDLSS_NOTE; ?>. Pada : <?php echo date('d/m/Y G:i', strtotime($data_row_info_reject->DTDLSS_DATE)); ?> WIB
												<br/>
												</b>
										<?php
												$index_info_reject++;
											}
										?>
									</div>
									<div class="col-xs-2" style="text-align:right;">
										<form id="form_revisi[]" name="form_revisi[]" action="<?php echo base_url('C_notification/revisi'); ?>" method="post" enctype="multipart/form-data">
										<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
										<button type="submit" class="ace-icon fa fa-pencil btn btn-sm btn-danger"></button>
										</form>
									</div>
								</div>
							</div>
						<?php elseif($SESSION_ROLES == "ATASAN PENCIPTA" || $SESSION_ROLES == "PENDISTRIBUSI" || $SESSION_ROLES == "PENCIPTA" && $FILTER =="DIPUBLIKASI"): ?>
							<div class="alert alert-success fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?php echo $data_row_ext->DOC_NAMA; ?>, <?php echo $data_row_ext->DOC_STATUS_ACTIVITY; ?>
										<br/>
										<?php echo date('d/m/Y G:i', strtotime($data_row_ext->DOC_DATE));?> WIB
									</div>
								</div>
							</div>
						<?php elseif($SESSION_ROLES == "PENCIPTA" && $FILTER =="DIPUBLIKASI" && $tgl_final <= 90 && $tgl_final >= 1): ?>
							<div class="alert alert-warning fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?=$data_row_ext->DOC_NAMA; ?>, Akan <b>Kadaluarsa</b> dalam <?=$tgl_final; ?> hari
									</div>
									<div class="col-sm-2" style="width:4%;">
										<form id="form_versioning[]" name="form_versioning[]" action="<?php echo base_url('C_notification/versioning'); ?>" method="post" enctype="multipart/form-data" target="_blank">
											<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
											<button type="submit" class="ace-icon fa fa-edit btn btn-sm btn-info" data-popup="tooltip" data-placement="top" title="Pengkinian"></button>
										</form>
									</div>
									<div class="col-sm-2" style="width:4%;">
										<form id="form_comment[]" name="form_comment[]" action="<?php echo base_url('C_news/comment'); ?>" method="post" enctype="multipart/form-data">
											<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
											<button type="submit" class="ace-icon fa fa-comment btn btn-sm btn-success"></button>
										</form>
									</div>
									<div class="col-sm-2" style="width:4%;">
										<form id="form_revisi[]" name="form_revisi[]" action="<?php echo base_url('C_notification/obsolete'); ?>" method="post" enctype="multipart/form-data">
											<input type="hidden" id="si_key" name="si_key" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
											<button type="submit" class="ace-icon fa fa-remove btn btn-sm btn-danger"></button>
										</form>
									</div>
								</div>
							</div>
						<?php elseif($SESSION_ROLES == "PENCIPTA" && $FILTER == "DIPUBLIKASI" && $tgl_final == 0): ?>
							<form id="form_obselete" name="form_obselete" action="<?php echo base_url('C_notification/obsolete'); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" id="si_key" name="si_key" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
							</form>
							<script>
							document.getElementById("form_obselete").submit();
							</script>
						<?php elseif($SESSION_ROLES == "PENCIPTA" && $FILTER == "KADALUARSA" && $arcived <= 30 && $arcived >= 1): ?>
							<div class="alert alert-warning fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?=$data_row_ext->DOC_NAMA; ?>, Akan <b>Diarsipkan</b> dalam <?=$arcived; ?> hari ke depan
									</div>
									<div class="col-sm-2" style="width:4%;">
										<form id="form_versioning[]" name="form_versioning[]" action="<?php echo base_url('C_notification/versioning'); ?>" method="post" enctype="multipart/form-data" target="_blank">
											<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
											<button type="submit" class="ace-icon fa fa-edit btn btn-sm btn-info" data-popup="tooltip" data-placement="top" title="Pengkinian"></button>
										</form>
									</div>
									<div class="col-sm-2" style="width:4%;">
										<form id="form_comment[]" name="form_comment[]" action="<?php echo base_url('C_news/comment'); ?>" method="post" enctype="multipart/form-data">
											<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
											<button type="submit" class="ace-icon fa fa-comment btn btn-sm btn-success"></button>
										</form>
									</div>
									<div class="col-sm-2" style="width:4%;">
										<form id="form_revisi[]" name="form_revisi[]" action="<?php echo base_url('C_notification/obsolete'); ?>" method="post" enctype="multipart/form-data">
											<input type="hidden" id="si_key" name="si_key" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
											<button type="submit" class="ace-icon fa fa-remove btn btn-sm btn-danger"></button>
										</form>
									</div>
								</div>
							</div>
						<?php elseif($SESSION_ROLES == "PENCIPTA" && $FILTER == "KADALUARSA" && $arcived == 0): ?>
							<form id="form_archived" name="form_archived" action="<?php echo base_url('C_notification/archived'); ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" id="si_key" name="si_key" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
							</form>
							<script>
							document.getElementById("form_archived").submit();
							</script>
						<?php else: ?>
							<div class="alert alert-info fade in">
								<div class="row">
									<div class="col-xs-10">
										Dokumen <?php echo $data_row_ext->DOC_NAMA; ?>, <?php echo $data_row_ext->DOC_STATUS_ACTIVITY; ?>
										<br/>
										<?php echo date('d/m/Y G:i', strtotime($data_row_ext->DOC_DATE));?> WIB
									</div>
								</div>
							</div>
						<?php endif; // END if SESSION ?>
						<?php
							endforeach; // END data_row_ext
						endif; // END if is_continue
						?>
					</div><!-- END Row -->
					<div class="row"><!-- Row -->
						<div class="widget-box">
							<div class="widget-header">
								<h4 class="smaller">
									News
								</h4>
							</div>
						</div>
						<div class="widget-box transparent">
							<div class="widget-header widget-header-small">
								<div class="widget-toolbar action-buttons">
									<a href="#" data-action="reload">
										<i class="ace-icon fa fa-refresh blue"></i>
									</a>
								</div>
							</div>
							<div class="widget-body">
								<div class="widget-main padding-8">
									
									<div id="profile-feed-1" class="profile-feed">
										<?php
										if($count_news > 0){
											foreach($get_data_count as $data_row){
												?>
												<div class="profile-activity clearfix">
													<div>
														<img class="pull-left" src="<?php echo base_url('template/backend/assets/images/avatars/avatar2.png'); ?>" />
														<a class="user"> <?php echo $data_row->DOC_MAKER; ?> </a>
														<div>
															<p>
																
																<?php
																if($data_row->DOC_MAKER==$SESSION_ID){
																	?>
																	<table width="100%">
																		<tr>
																			<th class="pull-left">
																				ID Dokumen : <?php echo $data_row->DOC_NOMOR; ?>, Nama Dokumen : <?php echo $data_row->DOC_NAMA; ?>
																			</th>
																			<th class="pull-right">
																				<a href="<?php echo base_url('document-details-'.$data_row->DOC_ID) ?>" class="fa fa-eye btn btn-link" style="font-size: 1.5rem;text-decoration: none;color: black;" target="_blank">Lihat</a>
																				<form id="form_comment[]" name="form_comment[]" action="<?php echo base_url('list-comments'); ?>" method="post" enctype="multipart/form-data">
																					<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row->DOC_ID; ?>" class="form-control" required/>
																					<button type="submit" class="ace-icon fa fa-list btn btn-sm btn-link" style="font-size: 1.5rem;text-decoration: none;"> Komentar </button>
																				</form>
																			</th>
																		</tr>
																	</table>
																	<?php
																}else{
																	?>
																	<table width="100%">
																		<tr>
																			<th class="pull-left">
																				ID Dokumen : <?php echo $data_row->DOC_NOMOR; ?>, Nama Dokumen : <?php echo $data_row->DOC_NAMA; ?>
																			</th>
																			<th class="pull-right">
																				<a href="<?php echo base_url('document-details-'.$data_row->DOC_ID) ?>" class="fa fa-eye btn btn-link" style="font-size: 1.5rem;text-decoration: none;color: black;" target="_blank">Lihat</a>
																			</th>
																		</tr>
																	</table>
																	<?php
																}
																?>

															</p>
														</div>
														<div class="time">
															<i class="ace-icon fa fa-clock-o bigger-110"></i>
															<?php echo date('d/m/Y G:s', strtotime($data_row->DOC_DATE)); ?> WIB
														</div>
													</div>
												</div>
												<?php
											}
										}
										?>
									</div>
									
								</div>
							</div>
						</div>
					</div><!-- END Row -->
				</div>
			</div>
		</div>
		<!-- END Content -->

		<!-- Modal Preview-->
		<?php
		if($is_continue):
			foreach($get_data_ext as $data_row_ext):
		?>

		<div id="modal-preview<?=$data_row_ext->DOC_ID;?>" class="modal" tabindex="-1">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h5 class="blue bigger">Preview</h5>
					</div>
					<div class="modal-body">
						<div class="row">
							<?php
							$get_data_doc = $this->M_library_database->DB_GET_DATA_DOCUMENT_DETAIL_BY_ID_EVO($data_row_ext->DOC_ID);
							// Dokumen Detail
							foreach($get_data_doc as $data_row_doc){
								$DOCD_UTAMA = $data_row_doc->DOCD_UTAMA;
								$EXT_UTAMA	= $data_row_doc->DOCD_UTAMA_EXT;
								$STATUS_UTAMA = $data_row_doc->DOCD_UTAMA_STATUS;

								$DOCD_PELENGKAP_1 = $data_row_doc->DOCD_PELENGKAP_1;
								$EXT_1 = $data_row_doc->DOCD_PELENGKAP_1_EXT;
								$STATUS_1 = $data_row_doc->DOCD_PELENGKAP_1_STATUS;

								$DOCD_PELENGKAP_2 = $data_row_doc->DOCD_PELENGKAP_2;
								$EXT_2 = $data_row_doc->DOCD_PELENGKAP_2_EXT;
								$STATUS_2 = $data_row_doc->DOCD_PELENGKAP_2_STATUS;

								$DOCD_PERSETUJUAN = $data_row_doc->DOCD_PERSETUJUAN;
							}
							if ($EXT_UTAMA=="doc" || $EXT_UTAMA=="docx" || $EXT_UTAMA=="xls" || $EXT_UTAMA=="xlsx" || $EXT_UTAMA=="ppt" || $EXT_UTAMA=="pptx") {
								$url_path_utama = base_url('assets/pdf/').$DOCD_UTAMA.'.pdf';
							}else{
								$url_path_utama = base_url('assets/original/').$DOCD_UTAMA.".".$EXT_UTAMA;
							}
							if ($EXT_1=="doc" || $EXT_1=="docx" || $EXT_1=="xls" || $EXT_1=="xlsx" || $EXT_1=="ppt" || $EXT_1=="pptx") {
								$url_path_pelengkap_1 = base_url('assets/pdf/').$DOCD_PELENGKAP_1.".pdf";
							}else{
								$url_path_pelengkap_1 = base_url('assets/original/').$DOCD_PELENGKAP_1.".".$EXT_1;
							}
							if ($EXT_2=="doc" || $EXT_2=="docx" || $EXT_2=="xls" || $EXT_2=="xlsx" || $EXT_2=="ppt" || $EXT_2=="pptx") {
								$url_path_pelengkap_2 = base_url('assets/pdf/').$DOCD_PELENGKAP_2.".pdf";
							}else{
								$url_path_pelengkap_2 = base_url('assets/original/').$DOCD_PELENGKAP_2.".".$EXT_2;
							}
							$url_path_persetujuan = base_url('assets/original/').$DOCD_PERSETUJUAN;
							// Pemilik Proses
							$DOC_PEMILIK_PROSES = $data_row_ext->DOC_PEMILIK_PROSES;
							$DOC_PEMILIK_PROSES_FINAL = "";
							if($DOC_PEMILIK_PROSES=="BPI"){
								$DOC_PEMILIK_PROSES_FINAL = ""."BPI";
							}else if($DOC_PEMILIK_PROSES==$SESSION_DIVISI_ID ){
								$DOC_PEMILIK_PROSES_FINAL = "".$SESSION_DIVISI_NAME;
							}else{
								$get_data = $this->M_library_database->DB_GET_DATA_DEPARTEMEN_BY_ID_EVO($DOC_PEMILIK_PROSES);
								foreach($get_data as $data_row){
									$DN_ID = $data_row->DN_ID;
									$DN_CODE = $data_row->DN_CODE;
									$DN_NAME = $data_row->DN_NAME;
								}
								$DOC_PEMILIK_PROSES_FINAL = "".$DN_CODE;
							}
							?>
							<?php if ($data_row_ext->DOC_DISTRIBUSI=="EDOC"): ?>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
									<div class="form-group">
										<object data="<?=$url_path_persetujuan;?>" type="application/pdf" width="400px" height="500px">
											<iframe src="<?=$url_path_persetujuan;?>"></iframe>
										</object>
										<label for="" class="col-sm-12 control-label" style="text-align:left">
											<!-- <a target="_blank" href="<?=$url_path_persetujuan;?>">Dokumen Persetujuan</a> -->
										</label>
									</div>
									
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">
											<a target="_blank" href="<?= base_url('C_notification/document/'.$data_row_ext->DOC_ID.'/'.$DOCD_UTAMA); ?>">Dokumen Utama</a>
										</label>
									</div>
									<?php if($data_row_doc->DOCD_PELENGKAP_1!="File_Not_Found"): ?>
										<div class="form-group">
											<label for="" class="col-sm-12 control-label" style="text-align:left">
												<a target="_blank" href="<?= base_url('C_notification/document/'.$data_row_ext->DOC_ID.'/'.$DOCD_PELENGKAP_1); ?>">Dokumen Pelengkap 1</a>
											</label>
										</div>
									<?php endif; ?>
									<?php if($data_row_doc->DOCD_PELENGKAP_2!="File_Not_Found"): ?>
										<div class="form-group">
											<label for="" class="col-sm-12 control-label" style="text-align:left">
												<a target="_blank" href="<?= base_url('C_notification/document/'.$data_row_ext->DOC_ID.'/'.$DOCD_PELENGKAP_2); ?>">Dokumen Pelengkap 2</a>
											</label>
										</div>
									<?php endif; ?>
								</div>
								
							<?php endif; ?>
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
								<div class="row">
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">Abstrak</label>
										<div class="col-sm-12">
											<textarea readonly type="text" rows="3" class="form-control" style="resize:none;background-color:white;"><?=$data_row_ext->DOC_ABSTRAK;?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">Nomor Dokumen</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" value="<?=$data_row_ext->DOC_NOMOR;?>"c>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">Tipe Dokumen</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" value="<?=$data_row_ext->DTSETE_TIPE;?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">Dept Pemilik Proses</label>
										<div class="col-sm-12">
											<textarea type="text" rows="3" class="form-control" style="resize:none;background-color:white;" readonly><?=$DOC_PEMILIK_PROSES_FINAL;?></textarea>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">Group Proses (5M)</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" value="<?=$data_row_ext->DOC_GROUP_PROSES;?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">Proses</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" value="<?=$data_row_ext->DOC_PROSES;?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">Jenis Dokumen</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" value="<?=$data_row_ext->DTSEJS_JENIS;?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">Nama Dokumen</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" value="<?=$data_row_ext->DOC_NAMA;?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">Tanggal Berlaku</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($data_row_ext->DOC_TGL_EFEKTIF)); ?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">Sampai Dengan</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" value="<?= date('d/m/Y', strtotime($data_row_ext->DOC_TGL_EXPIRED));?>" readonly>
										</div>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">Versi</label>
										<div class="col-sm-12">
											<input type="text" class="form-control" value="<?=$data_row_ext->DOC_VERSI;?>" readonly>
										</div>
									</div>
								</div>
								
								<!-- <div class="row">
									<div class="form-group">
										<label for="" class="col-sm-12 control-label" style="text-align:left">
											<form id="form_detail" name="form_view[]" action="<?php echo base_url('C_notification/detail'); ?>" method="post" enctype="multipart/form-data" target="_blank">
												<input type="text" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
												<button type="submit" class="ace-icon fa fa-eye btn btn-sm btn-success"> Detail PMD </button>
											</form>
										</label>
									</div>
								</div> -->
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="row">
							<?php if($data_row_ext->DOC_STATUS == "MENUNGGU PENDISTRIBUSI" && $SESSION_ROLES == "PENDISTRIBUSI"): ?>
							<div class="col-sm-6" style="text-align:left;">
								<form id="form_approve[]" name="form_approve[]" action="<?php echo base_url('C_notification/approve'); ?>" method="post" enctype="multipart/form-data">
									<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
									<input type="hidden" id="si_approver" name="si_approver" class="form-control" value="<?=$SESSION_ROLES;?>">
									<button type="submit" class="ace-icon fa fa-check btn btn-sm btn-primary">Terima</button>
									<a data-toggle="modal" data-target="#modal-reject<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-ban btn btn-sm btn-danger" data-popup="tooltip" data-placement="top" title="Reject">Tolak Sirkulasi</a>
								</form>
							</div>
						<?php elseif($data_row_ext->DOC_STATUS == "MENUNGGU ATASAN PENCIPTA" && $SESSION_ROLES == "ATASAN PENCIPTA"): ?>
							<div class="col-sm-6" style="text-align:left;">
								<form id="form_approve[]" name="form_approve[]" action="<?php echo base_url('C_notification/approve'); ?>" method="post" enctype="multipart/form-data">
									<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
									<input type="hidden" id="si_approver" name="si_approver" class="form-control" value="<?=$SESSION_ROLES;?>">
									<button type="submit" class="ace-icon fa fa-check btn btn-sm btn-primary">Terima</button>
									<a data-toggle="modal" data-target="#modal-reject<?=$data_row_ext->DOC_ID;?>" class="ace-icon fa fa-ban btn btn-sm btn-danger" data-popup="tooltip" data-placement="top" title="Reject">Tolak Sirkulasi</a>
								</form>
							</div>
						<?php else: ?>
							<div class="col-sm-6">
								
							</div>
						<?php endif; ?>
							<div class="col-sm-6">
								<form id="form_detail" name="form_view[]" action="<?php echo base_url('pmd-details'); ?>" method="post" enctype="multipart/form-data" target="_blank">
									<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
									<button type="button" class="btn btn-sm" data-dismiss="modal">
										<i class="ace-icon fa fa-times"></i>
										Close
									</button>
									<button type="submit" class="ace-icon fa fa-eye btn btn-sm btn-success"> Detail PMD </button>
								</form>
							</div>
						</div>
						<!-- <form id="form_detail" name="form_view[]" action="<?php echo base_url('pmd-details'); ?>" method="post" enctype="multipart/form-data" target="_blank">
							<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $data_row_ext->DOC_ID; ?>" class="form-control" required/>
							<button type="button" class="btn btn-sm" data-dismiss="modal">
								<i class="ace-icon fa fa-times"></i>
								Close
							</button>
							<button type="submit" class="ace-icon fa fa-eye btn btn-sm btn-success"> Detail PMD </button>
						</form> -->

					</div>
				</div>
			</div>
		</div>

		<?php
			endforeach;
		endif;
		?>
		<!-- END Modal Preview-->

		<!-- Modal Reject -->
		<?php
		if($is_continue):
			foreach($get_data_ext as $data_row_ext):
		?>

		<div id="modal-reject<?=$data_row_ext->DOC_ID;?>" class="modal" tabindex="-1">
			<div class="modal-dialog">
				<div class="modal-content">
					<form class="form-horizontal" action="<?php echo base_url('C_notification/reject'); ?>" method="post" enctype="multipart/form-data">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h5 class="blue bigger">Tolak Sirkulasi</h5>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="form-group">
									<label class="col-sm-12 control-label" style="text-align:left">Catatan Untuk Diperhatikan</label>
								</div>
								<div class="form-group">
									<label class="col-sm-12 control-label" style="text-align:left">Maksimum 400 Karakter</label>
								</div>
								<div class="form-group">
									<div class="col-sm-12">
										<input type="hidden" id="si_key" name="si_key" class="form-control" value="<?=$data_row_ext->DOC_ID;?>">
										<input type="hidden" id="si_approver" name="si_approver" class="form-control" value="<?=$SESSION_ROLES;?>">
										<textarea type="text" id="si_note" name="si_note" rows="3" maxlength="400" class="form-control"></textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button class="btn btn-sm" data-dismiss="modal">
								<i class="ace-icon fa fa-times"></i>
								Cancel
							</button>
							<button type="submit" class="btn btn-sm btn-primary">
								<i class="ace-icon fa fa-check"></i>
								Submit
							</button>
						</div>
					</form>
					
				</div>
			</div>
		</div>

		<?php
			endforeach;
		endif;
		?>
		<!-- END Modal Reject -->

	</div><!-- /.main-container -->
	<!------------------------------------------------------------------------------------------------->
	<!-- JAVA SCRIPT / BOOTSTRAP / ETC -->
	<script src="<?php echo base_url('template/backend/assets/js/jquery-2.1.4.min.js'); ?>"></script>
	<script type="text/javascript">
		if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url('template/backend/assets/js/jquery.mobile.custom.min.js'); ?>'>"+"<"+"/script>");
	</script>
	<script src="<?php echo base_url('template/backend/assets/js/bootstrap.min.js'); ?>"></script>
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
	<?php if ($pesan = $this->session->flashdata('pesan')): ?>
		<script>
			swal("<?php echo $pesan; ?>", "Pemutakhiran Data Berhasil!", "success");
		</script>
	<?php endif; ?>
	<?php if ($pesan_gagal = $this->session->flashdata('pesan_gagal')): ?>
		<script>
			swal("<?php echo $pesan_gagal; ?>", "Pemutakhiran Data Gagal, Mohon Cek Kembali!", "error");
		</script>
	<?php endif; ?>
	<script type="text/javascript">
		jQuery(function($) {
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
			//------------------------------------------------------------------------------------------------//
			//------------------------------------------------------------------------------------------------//
			//------------------------------------------------------------------------------------------------//
			window.prettyPrint && prettyPrint();
			$('#id-check-horizontal').removeAttr('checked').on('click', function(){
				$('#dt-list-1').toggleClass('dl-horizontal').prev().html(this.checked ? '&lt;dl class="dl-horizontal"&gt;' : '&lt;dl&gt;');
			});
			//------------------------------------------------------------------------------------------------//
			//------------------------------------------------------------------------------------------------//
			//------------------------------------------------------------------------------------------------//
			$('#id-disable-check').on('click', function() {
				var inp = $('#form-input-readonly').get(0);
				if(inp.hasAttribute('disabled')) {
					inp.setAttribute('readonly' , 'true');
					inp.removeAttribute('disabled');
					inp.value="This text field is readonly!";
				}
				else {
					inp.setAttribute('disabled' , 'disabled');
					inp.removeAttribute('readonly');
					inp.value="This text field is disabled!";
				}
			});
			
			if(!ace.vars['touch']) {
				$('.chosen-select').chosen({allow_single_deselect:true}); 
				//resize the chosen on window resize
				
				$(window)
				.off('resize.chosen')
				.on('resize.chosen', function() {
					$('.chosen-select').each(function() {
						var $this = $(this);
						$this.next().css({'width': $this.parent().width()});
					})
				}).trigger('resize.chosen');
				//resize chosen on sidebar collapse/expand
				$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
					if(event_name != 'sidebar_collapsed') return;
					$('.chosen-select').each(function() {
						var $this = $(this);
						$this.next().css({'width': $this.parent().width()});
					})
				});
				
				$('#chosen-multiple-style .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
					else $('#form-field-select-4').removeClass('tag-input-style');
				});
			}
			
			$('[data-rel=tooltip]').tooltip({container:'body'});
			$('[data-rel=popover]').popover({container:'body'});
			
			autosize($('textarea[class*=autosize]'));
			
			$('textarea.limited').inputlimiter({
				remText: '%n character%s remaining...',
				limitText: 'max allowed : %n.'
			});
			
			$.mask.definitions['~']='[+-]';
			$('.input-mask-date').mask('99/99/9999');
			$('.input-mask-phone').mask('(999) 999-9999');
			$('.input-mask-eyescript').mask('~9.99 ~9.99 999');
			$(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
			
			$( "#input-size-slider" ).css('width','200px').slider({
				value:1,
				range: "min",
				min: 1,
				max: 8,
				step: 1,
				slide: function( event, ui ) {
					var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
					var val = parseInt(ui.value);
					$('#form-field-4').attr('class', sizing[val]).attr('placeholder', '.'+sizing[val]);
				}
			});
			
			$( "#input-span-slider" ).slider({
				value:1,
				range: "min",
				min: 1,
				max: 12,
				step: 1,
				slide: function( event, ui ) {
					var val = parseInt(ui.value);
					$('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
				}
			});
			
			//"jQuery UI Slider"
			//range slider tooltip example
			$( "#slider-range" ).css('height','200px').slider({
				orientation: "vertical",
				range: true,
				min: 0,
				max: 100,
				values: [ 17, 67 ],
				slide: function( event, ui ) {
					var val = ui.values[$(ui.handle).index()-1] + "";
					
					if( !ui.handle.firstChild ) {
						$("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
						.prependTo(ui.handle);
					}
					$(ui.handle.firstChild).show().children().eq(1).text(val);
				}
			}).find('span.ui-slider-handle').on('blur', function(){
				$(this.firstChild).hide();
			});
			
			$( "#slider-range-max" ).slider({
				range: "max",
				min: 1,
				max: 10,
				value: 2
			});
			
			$( "#slider-eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
				// read initial values from markup and remove that
				var value = parseInt( $( this ).text(), 10 );
				$( this ).empty().slider({
					value: value,
					range: "min",
					animate: true
					
				});
			});
			
			$("#slider-eq > span.ui-slider-purple").slider('disable');//disable third item
			
			$('#id-input-file-1 , #id-input-file-2').ace_file_input({
				no_file:'No File ...',
				btn_choose:'Choose',
				btn_change:'Change',
				droppable:false,
				onchange:null,
				thumbnail:false //| true | large
				//whitelist:'gif|png|jpg|jpeg'
				//blacklist:'exe|php'
				//onchange:''
				//
			});
			//pre-show a file name, for example a previously selected file
			//$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])
			
			$('#id-input-file-3').ace_file_input({
				style: 'well',
				btn_choose: 'Drop files here or click to choose',
				btn_change: null,
				no_icon: 'ace-icon fa fa-cloud-upload',
				droppable: true,
				thumbnail: 'small'//large | fit
				//,icon_remove:null//set null, to hide remove/reset button
				/**,before_change:function(files, dropped) {
					//Check an example below
					//or examples/file-upload.html
					return true;
				}*/
				/**,before_remove : function() {
					return true;
				}*/
				,
				preview_error : function(filename, error_code) {
					//name of the file that failed
					//error_code values
					//1 = 'FILE_LOAD_FAILED',
					//2 = 'IMAGE_LOAD_FAILED',
					//3 = 'THUMBNAIL_FAILED'
					//alert(error_code);
				}
				
			}).on('change', function(){
				//console.log($(this).data('ace_input_files'));
				//console.log($(this).data('ace_input_method'));
			});
			
			//$('#id-input-file-3')
			//.ace_file_input('show_file_list', [
				//{type: 'image', name: 'name of image', path: 'http://path/to/image/for/preview'},
				//{type: 'file', name: 'hello.txt'}
			//]);
			
			//dynamically change allowed formats by changing allowExt && allowMime function
			$('#id-file-format').removeAttr('checked').on('change', function() {
				var whitelist_ext, whitelist_mime;
				var btn_choose
				var no_icon
				if(this.checked) {
					btn_choose = "Drop images here or click to choose";
					no_icon = "ace-icon fa fa-picture-o";
					
					whitelist_ext = ["jpeg", "jpg", "png", "gif" , "bmp"];
					whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
				}
				else {
					btn_choose = "Drop files here or click to choose";
					no_icon = "ace-icon fa fa-cloud-upload";
					
					whitelist_ext = null;//all extensions are acceptable
					whitelist_mime = null;//all mimes are acceptable
				}
				var file_input = $('#id-input-file-3');
				file_input
				.ace_file_input('update_settings',
				{
					'btn_choose': btn_choose,
					'no_icon': no_icon,
					'allowExt': whitelist_ext,
					'allowMime': whitelist_mime
				})
				file_input.ace_file_input('reset_input');
				
				file_input
				.off('file.error.ace')
				.on('file.error.ace', function(e, info) {
					//console.log(info.file_count);//number of selected files
					//console.log(info.invalid_count);//number of invalid files
					//console.log(info.error_list);//a list of errors in the following format
					
					//info.error_count['ext']
					//info.error_count['mime']
					//info.error_count['size']
					
					//info.error_list['ext']  = [list of file names with invalid extension]
					//info.error_list['mime'] = [list of file names with invalid mimetype]
					//info.error_list['size'] = [list of file names with invalid size]
					
					/**
					if( !info.dropped ) {
						//perhapse reset file field if files have been selected, and there are invalid files among them
						//when files are dropped, only valid files will be added to our file array
						e.preventDefault();//it will rest input
					}
					*/
					
					//if files have been selected (not dropped), you can choose to reset input
					//because browser keeps all selected files anyway and this cannot be changed
					//we can only reset file field to become empty again
					//on any case you still should check files with your server side script
					//because any arbitrary file can be uploaded by user and it's not safe to rely on browser-side measures
				});
				
				/**
				file_input
				.off('file.preview.ace')
				.on('file.preview.ace', function(e, info) {
					console.log(info.file.width);
					console.log(info.file.height);
					e.preventDefault();//to prevent preview
				});
				*/
				
			});
			
			$('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
			.closest('.ace-spinner')
			.on('changed.fu.spinbox', function(){
				//console.log($('#spinner1').val())
			}); 
			$('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'ace-icon fa fa-caret-up bigger-110', icon_down:'ace-icon fa fa-caret-down bigger-110'});
			$('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
			$('#spinner4').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus', icon_down:'ace-icon fa fa-minus', btn_up_class:'btn-purple' , btn_down_class:'btn-purple'});
			
			//$('#spinner1').ace_spinner('disable').ace_spinner('value', 11);
			//or
			//$('#spinner1').closest('.ace-spinner').spinner('disable').spinner('enable').spinner('value', 11);//disable, enable or change value
			//$('#spinner1').closest('.ace-spinner').spinner('value', 0);//reset to 0
			
			//datepicker plugin
			//link
			$('.date-picker').datepicker({
				autoclose: true,
				todayHighlight: true
			})
			//show datepicker when clicking on the icon
			.next().on(ace.click_event, function(){
				$(this).prev().focus();
			});
			
			//or change it into a date range picker
			$('.input-daterange').datepicker({autoclose:true});
			
			//to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
			$('input[name=date-range-picker]').daterangepicker({
				'applyClass' : 'btn-sm btn-success',
				'cancelClass' : 'btn-sm btn-default',
				locale: {
					applyLabel: 'Apply',
					cancelLabel: 'Cancel',
				}
			})
			.prev().on(ace.click_event, function(){
				$(this).next().focus();
			});
			
			$('#timepicker1').timepicker({
				minuteStep: 1,
				showSeconds: true,
				showMeridian: false,
				disableFocus: true,
				icons: {
					up: 'fa fa-chevron-up',
					down: 'fa fa-chevron-down'
				}
			}).on('focus', function() {
				$('#timepicker1').timepicker('showWidget');
			}).next().on(ace.click_event, function(){
				$(this).prev().focus();
			});
			
			if(!ace.vars['old_ie']) $('#date-timepicker1').datetimepicker({
			 //format: 'MM/DD/YYYY h:mm:ss A',//use this option to display seconds
			 icons: {
			 	time: 'fa fa-clock-o',
			 	date: 'fa fa-calendar',
			 	up: 'fa fa-chevron-up',
			 	down: 'fa fa-chevron-down',
			 	previous: 'fa fa-chevron-left',
			 	next: 'fa fa-chevron-right',
			 	today: 'fa fa-arrows ',
			 	clear: 'fa fa-trash',
			 	close: 'fa fa-times'
			 }
			}).next().on(ace.click_event, function(){
				$(this).prev().focus();
			});
			
			$('#colorpicker1').colorpicker();
			//$('.colorpicker').last().css('z-index', 2000);//if colorpicker is inside a modal, its z-index should be higher than modal'safe
			
			$('#simple-colorpicker-1').ace_colorpicker();
			//$('#simple-colorpicker-1').ace_colorpicker('pick', 2);//select 2nd color
			//$('#simple-colorpicker-1').ace_colorpicker('pick', '#fbe983');//select #fbe983 color
			//var picker = $('#simple-colorpicker-1').data('ace_colorpicker')
			//picker.pick('red', true);//insert the color if it doesn't exist
			
			$(".knob").knob();
			
			var tag_input = $('#form-field-tags');
			try{
				tag_input.tag(
				{
					placeholder:tag_input.attr('placeholder'),
					//enable typeahead by specifying the source array
					source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
					/**
					//or fetch data from database, fetch those that match "query"
					source: function(query, process) {
					  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
					  .done(function(result_items){
						process(result_items);
					  });
					}
					*/
				}
				)
				
				//programmatically add/remove a tag
				var $tag_obj = $('#form-field-tags').data('tag');
				$tag_obj.add('Programmatically Added');
				
				var index = $tag_obj.inValues('some tag');
				$tag_obj.remove(index);
			}
			catch(e) {
				//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
				tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
				//autosize($('#form-field-tags'));
			}
			
			$('#modal-form input[type=file]').ace_file_input({
				style:'well',
				btn_choose:'Drop files here or click to choose',
				btn_change:null,
				no_icon:'ace-icon fa fa-cloud-upload',
				droppable:true,
				thumbnail:'large'
			})
			
			//chosen plugin inside a modal will have a zero width because the select element is originally hidden
			//and its width cannot be determined.
			//so we set the width after modal is show
			$('#modal-form').on('shown.bs.modal', function () {
				if(!ace.vars['touch']) {
					$(this).find('.chosen-container').each(function(){
						$(this).find('a:first-child').css('width' , '210px');
						$(this).find('.chosen-drop').css('width' , '210px');
						$(this).find('.chosen-search input').css('width' , '200px');
					});
				}
			})
			/**
			//or you can activate the chosen plugin after modal is shown
			//this way select element becomes visible with dimensions and chosen works as expected
			$('#modal-form').on('shown', function () {
				$(this).find('.modal-chosen').chosen();
			})
			*/
			
			$(document).one('ajaxloadstart.page', function(e) {
				autosize.destroy('textarea[class*=autosize]')
				
				$('.limiterBox,.autosizejs').remove();
				$('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
			});
			//------------------------------------------------------------------------------------------------//
			//------------------------------------------------------------------------------------------------//
			//------------------------------------------------------------------------------------------------//
			////initiate dataTables plugin
			//var myTable = 
			//$('#dynamic-table')
			////.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
			//.DataTable( {
			//	bAutoWidth: false,
			//	//PLEASE CHECK columns TABLE!!!
			//	"aoColumns": [
			//	  { "bSortable": false },
			//	  null, 
			//	  null, 
			//	  null, 
			//	  null, 
			//	  { "bSortable": false }
			//	],
			//	"aaSorting": [],
			//	
			//	//"bProcessing": true,
			//    //"bServerSide": true,
			//    //"sAjaxSource": "http://127.0.0.1/table.php"	,
			//
			//	//,
			//	//"sScrollY": "200px",
			//	//"bPaginate": false,
			//
			//	//"sScrollX": "100%",
			//	//"sScrollXInner": "120%",
			//	//"bScrollCollapse": true,
			//	//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
			//	//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			//
			//	//"iDisplayLength": 50
			//
			//	select: {
			//		style: 'multi'
			//	}
			//} );
			//
			//$.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';
			//
			//new $.fn.dataTable.Buttons( myTable, {
			//	buttons: [
			//	  {
			//		"extend": "colvis",
			//		"text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
			//		"className": "btn btn-white btn-primary btn-bold",
			//		columns: ':not(:first):not(:last)'
			//	  },
			//	  {
			//		"extend": "copy",
			//		"text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
			//		"className": "btn btn-white btn-primary btn-bold"
			//	  },
			//	  {
			//		"extend": "csv",
			//		"text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
			//		"className": "btn btn-white btn-primary btn-bold"
			//	  },
			//	  {
			//		"extend": "excel",
			//		"text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
			//		"className": "btn btn-white btn-primary btn-bold"
			//	  },
			//	  {
			//		"extend": "pdf",
			//		"text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
			//		"className": "btn btn-white btn-primary btn-bold"
			//	  },
			//	  {
			//		"extend": "print",
			//		"text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
			//		"className": "btn btn-white btn-primary btn-bold",
			//		autoPrint: false,
			//		message: 'This print was produced using the Print button for DataTables'
			//	  }		  
			//	]
			//} );
			//myTable.buttons().container().appendTo( $('.tableTools-container') );
			//
			////style the message box
			//var defaultCopyAction = myTable.button(1).action();
			//myTable.button(1).action(function (e, dt, button, config) {
			//	defaultCopyAction(e, dt, button, config);
			//	$('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
			//});
			//
			//var defaultColvisAction = myTable.button(0).action();
			//myTable.button(0).action(function (e, dt, button, config) {
			//	
			//	defaultColvisAction(e, dt, button, config);
			//	
			//	
			//	if($('.dt-button-collection > .dropdown-menu').length == 0) {
			//		$('.dt-button-collection')
			//		.wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
			//		.find('a').attr('href', '#').wrap("<li />")
			//	}
			//	$('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
			//});
            //
			//setTimeout(function() {
			//	$($('.tableTools-container')).find('a.dt-button').each(function() {
			//		var div = $(this).find(' > div').first();
			//		if(div.length == 1) div.tooltip({container: 'body', title: div.parent().text()});
			//		else $(this).tooltip({container: 'body', title: $(this).text()});
			//	});
			//}, 500);
			//
			//myTable.on( 'select', function ( e, dt, type, index ) {
			//	if ( type === 'row' ) {
			//		$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', true);
			//	}
			//} );
			//myTable.on( 'deselect', function ( e, dt, type, index ) {
			//	if ( type === 'row' ) {
			//		$( myTable.row( index ).node() ).find('input:checkbox').prop('checked', false);
			//	}
			//} );			
			//
			///////////////////////////////////
			////table checkboxes
			//$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
			//
			////select/deselect all rows according to table header checkbox
			//$('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function(){
			//	var th_checked = this.checked;//checkbox inside "TH" table header
			//	
			//	$('#dynamic-table').find('tbody > tr').each(function(){
			//		var row = this;
			//		if(th_checked) myTable.row(row).select();
			//		else  myTable.row(row).deselect();
			//	});
			//});
			//
			////select/deselect a row when the checkbox is checked/unchecked
			//$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
			//	var row = $(this).closest('tr').get(0);
			//	if(this.checked) myTable.row(row).deselect();
			//	else myTable.row(row).select();
			//});
			//		
			//$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
			//	e.stopImmediatePropagation();
			//	e.stopPropagation();
			//	e.preventDefault();
			//});
			//------------------------------------------------------------------------------------------------//
			//------------------------------------------------------------------------------------------------//
			//------------------------------------------------------------------------------------------------//
			var demo1 = $('select[name="duallistbox_demo1[]"]').bootstrapDualListbox({infoTextFiltered: '<span class="label label-purple label-lg">Filtered</span>'});
			var container1 = demo1.bootstrapDualListbox('getContainer');
			container1.find('.btn').addClass('btn-white btn-info btn-bold');
			
			/**var setRatingColors = function() {
				$(this).find('.star-on-png,.star-half-png').addClass('orange2').removeClass('grey');
				$(this).find('.star-off-png').removeClass('orange2').addClass('grey');
			}*/
			$('.rating').raty({
				'cancel' : true,
				'half': true,
				'starType' : 'i'
				/**,
				
				'click': function() {
					setRatingColors.call(this);
				},
				'mouseover': function() {
					setRatingColors.call(this);
				},
				'mouseout': function() {
					setRatingColors.call(this);
				}*/
			})//.find('i:not(.star-raty)').addClass('grey');

			//select2
			$('.select2').css('width','200px').select2({allowClear:true})
			$('#select2-multiple-style .btn').on('click', function(e){
				var target = $(this).find('input[type=radio]');
				var which = parseInt(target.val());
				if(which == 2) $('.select2').addClass('tag-input-style');
				else $('.select2').removeClass('tag-input-style');
			});

			$('.multiselect').multiselect({
				enableFiltering: true,
				enableHTML: true,
				buttonClass: 'btn btn-white btn-primary',
				templates: {
					button: '<button type="button" class="multiselect dropdown-toggle" data-toggle="dropdown"><span class="multiselect-selected-text"></span> &nbsp;<b class="fa fa-caret-down"></b></button>',
					ul: '<ul class="multiselect-container dropdown-menu"></ul>',
					filter: '<li class="multiselect-item filter"><div class="input-group"><span class="input-group-addon"><i class="fa fa-search"></i></span><input class="form-control multiselect-search" type="text"></div></li>',
					filterClearBtn: '<span class="input-group-btn"><button class="btn btn-default btn-white btn-grey multiselect-clear-filter" type="button"><i class="fa fa-times-circle red2"></i></button></span>',
					li: '<li><a tabindex="0"><label></label></a></li>',
					divider: '<li class="multiselect-item divider"></li>',
					liGroup: '<li class="multiselect-item multiselect-group"><label></label></li>'
				}
			});

			//typeahead.js
			//example taken from plugin's page at: https://twitter.github.io/typeahead.js/examples/
			var substringMatcher = function(strs) {
				return function findMatches(q, cb) {
					var matches, substringRegex;
					
					// an array that will be populated with substring matches
					matches = [];
					
					// regex used to determine if a string contains the substring `q`
					substrRegex = new RegExp(q, 'i');
					
					// iterate through the pool of strings and for any string that
					// contains the substring `q`, add it to the `matches` array
					$.each(strs, function(i, str) {
						if (substrRegex.test(str)) {
							// the typeahead jQuery plugin expects suggestions to a
							// JavaScript object, refer to typeahead docs for more info
							matches.push({ value: str });
						}
					});
					
					cb(matches);
				}
			}
			
			$('input.typeahead').typeahead({
				hint: true,
				highlight: true,
				minLength: 1
			}, {
				name: 'states',
				displayKey: 'value',
				source: substringMatcher(ace.vars['US_STATES']),
				limit: 10
			});
			
			//in ajax mode, remove remaining elements before leaving page
			$(document).one('ajaxloadstart.page', function(e) {
				$('[class*=select2]').remove();
				$('select[name="duallistbox_demo1[]"]').bootstrapDualListbox('destroy');
				$('.rating').raty('destroy');
				$('.multiselect').multiselect('destroy');
			});
			//------------------------------------------------------------------------------------------------//
			//------------------------------------------------------------------------------------------------//
			//------------------------------------------------------------------------------------------------//
		});
	</script>
	<!------------------------------------------------------------------------------------------------->
</body>
<!------------------------------------------------------------------------------------------------->
</html>
<!------------------------------------------------------------------------------------------------->