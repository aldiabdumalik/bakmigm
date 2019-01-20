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
if(	$SESSION_ROLES=="ATASAN PENCIPTA"||
	$SESSION_ROLES=="PENDISTRIBUSI"
){
	//$DOC_ID,$DOC_NOMOR,$DOC_NAMA,$DOC_MAKER,$DOC_APPROVE,$DOC_STATUS,$DN_ID
	$get_data_ext = $this->M_library_database->DB_GET_SEARCH_DATA_DOCUMENT_ARRAY("","","","","","WAITING",$SESSION_DEPARTEMENT_ID);
if(empty($get_data_ext)||$get_data_ext==""){
	$is_continue = false;
}else{
	$count_notification = count($get_data_ext);
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
<style>
	input[readonly]{
		background-color: white!important;
	}
	.modal-dialog1 {
    width: 100%;
    height: 100%;
    padding: 0;
    margin:0;
	}
	.tooltip-inner {
    max-width: 320px;
    width: 320px; 
}
</style>
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


					<?php foreach ($detaillist as $key) : ?>
						<div class="row">
							<div class="col-md-5">
								<div class="form-group">
									<object data="<?= base_url('assets/original/'.$key['DOCD_PERSETUJUAN']);?>#toolbar=0&navpanes=0&scrollbar=0" width="535px" height="535px">
										<iframe src="<?= base_url('assets/original/'.$key['DOCD_PERSETUJUAN']);?>#toolbar=0&navpanes=0&scrollbar=0" width="535px" height="535px"></iframe>
									</object>
									
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label>Abstrak</label>
									<textarea readonly name="" id="" style="resize: none;" cols="105" rows="6"><?php echo $key['DOC_ABSTRAK'] ?></textarea>
								</div>
								<div class="form-group">
									<h5><b><?php echo $key['DOC_NOMOR'] ?></b></h5>
								</div>
								<form class="form-horizontal">
									<div class="form-group">
										<label for="" class="col-sm-6">Tipe Dokumen</label>
										<label for="" class="col-sm-2">
											<input readonly style="width: 40rem;" type="text" id="" value="<?php echo $key['DTSETE_TIPE'] ?>">
										</label>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-6">Dept. Pemilik Proses</label>
										<label for="" class="col-sm-2">
											<input readonly style="width: 40rem;" type="text" id="" value="<?php echo $key['DN_NAME'] ?>">
										</label>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-6">Group Proses</label>
										<label for="" class="col-sm-2">
											<input readonly style="width: 40rem;" type="text" id="" value="<?php echo $key['DOC_GROUP_PROSES'] ?>">
										</label>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-6">Proses</label>
										<label for="" class="col-sm-2">
											<input readonly style="width: 40rem;" type="text" id="" value="<?php echo $key['DOC_PROSES'] ?>">
										</label>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-6">Jenis Dokumen</label>
										<label for="" class="col-sm-2">
											<input readonly style="width: 40rem;" type="text" id="" value="<?php echo $key['DTSEJS_JENIS'] ?>">
										</label>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-6">Nama Dokumen</label>
										<label for="" class="col-sm-2">
											<input readonly style="width: 40rem;" type="text" id="" value="<?php echo $key['DOC_NAMA'] ?>">
										</label>
									</div>
									<div class="form-group">
										<label for="" class="col-sm-6"><i class="fa fa-book" style="font-size: 9rem;"></i></label>
										<label for="" class="col-sm-6" style="">
											<!-- DOKUMEN UTAMA -->
											<a id="click" href="" data-toggle="modal" data-target="#dokumenutama<?= $key['DOCD_UTAMA'];?>">DOKUMEN UTAMA</a>
											<!-- END DOKUMEN UTAMA -->
											<br>
											<!-- Dokumen Pelengkap 1 -->
											<?php if($key['DOCD_PELENGKAP_1']!="File_Not_Found"): ?>
											<a href="" data-toggle="modal" data-target="#dokumenpelengkap1<?= $key['DOCD_PELENGKAP_1'];?>">DOKUMEN PELENGKAP 1</a> 
											<br>
											<?php endif; ?>
											<!-- Dokumen Pelengkap 2 -->
											<?php if($key['DOCD_PELENGKAP_2']!="File_Not_Found"): ?>
											<a href="" data-toggle="modal" data-target="#dokumenpelengkap2<?= $key['DOCD_PELENGKAP_2'];?>">DOKUMEN PELENGKAP 2</a>
											<br>
											<?php endif; ?>
										</label>

									</div>

								</form>
								<h5 id="show" style="color:orange;"><b>Saya sudah membaca dan memahami dokumen ini</b></h5>
								<?php if ($SESSION_ROLES != "PENGGUNA"): ?>
									<form id="form_detail" name="form_view[]" action="<?php echo base_url('C_notification/detail'); ?>" method="post" enctype="multipart/form-data" target="_blank">
										<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $key['DOC_ID']; ?>" class="form-control" required/>
										<button type="submit" class="btn btn-link"><b style="font-size: 1.6rem;">Detail PMD</b></button>
									</form>
								<?php endif ?>
								
							</div>
							<div class="col-md-3" style="float: left;">
							<?php if ($SESSION_ROLES == "PENGGUNA"): ?>
								<!-- sharelink -->
								<a data-toggle="modal" data-target="#modal-sharelink<?= $key['DOC_ID'];?>" data-popup="tooltip" data-placement="top" title="Sharelink" href="" style="color: black;"><i class="glyphicon glyphicon-link" style="font-size: 2.5rem;float: right;cursor: pointer;margin-left: .7rem"></i></a>
								 <!-- <form id="form_comment[]" style="float: right; " name="form_comment[]" method="post" enctype="multipart/form-data">
								<input type="hidden" id="si_key[]" name="si_key" value="<?php echo $key['DOC_ID']; ?>" class="form-control" required/>
								<button type="submit" class="btn btn-link"><i class="glyphicon glyphicon-link" style="color:black;font-size: 2.5rem;float: right;margin-left:.7rem;cursor: pointer;margin: -.4rem -1.7rem 0 -.7rem;"></i> </button>  -->
							</form>
							<!-- sharelink -->
							<?php endif ?>
							<?php if ($SESSION_ROLES == "PENCIPTA"  ): ?>
								<!-- comment -->
							<form id="form_comment[]" style="float: right; " name="form_comment[]" action="<?php echo base_url('C_news/comment'); ?>" method="post" enctype="multipart/form-data">
								<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $key['DOC_ID']; ?>" class="form-control" required/>
								<button type="submit" class="btn btn-link"><i class="fa fa-comment" style="color:black;font-size: 2.5rem;float: right;margin-left:.7rem;cursor: pointer;margin: -.4rem -1.7rem 0 -.7rem;"></i> </button>
							</form>
							<!-- end comment -->
							<!-- versioning -->
							<a data-toggle="modal" data-target="#modal-versioning<?= $key['DOC_ID'];?>" data-popup="tooltip" data-placement="top" title="Pengkinian" href="" style="color: black;"><i class="glyphicon glyphicon-edit" style="font-size: 2.5rem;float: right;cursor: pointer;margin-left: .7rem"></i></a>
							<!-- end versioning -->
							<?php endif ?>
							<?php if ($SESSION_ROLES == "PENCIPTA" || $SESSION_ROLES == "PENDISTRIBUSI"): ?>
							<!-- archive -->
							<a href="" data-toggle="modal" data-target="#myModal" style="color: black;"><i class="fa fa-archive" style="font-size: 2.5rem;float: right;cursor: pointer;margin-left: .7rem"></i></a>
							<!-- end archive -->
							<?php endif ?>
							
							<!-- bookmark -->
							<form id="form_bookmark[]" style="float: right; " name="form_bookmark" action="<?php echo base_url('C_bookmarks/bookmark'); ?>" method="post" enctype="multipart/form-data">
								<input type="hidden" id="si_key" name="si_key" value="<?php echo $key['DOC_ID']; ?>" class="form-control" required/>
								<input type="hidden" id="ur_id" name="ur_id" value="<?php echo $SESSION_ID; ?>" class="form-control" required/>
								<button type="submit" class="btn btn-link"><i class="glyphicon glyphicon-bookmark" style="color:black;font-size: 2.5rem;float: right;margin-left:.7rem;cursor: pointer;margin: -.4rem -1.5rem 0 -.7rem;"></i> </button>
							</form>
							<!-- bookmark end -->
							</div>
						</div>
						<!-- Modal -->
						<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
						  <div class="modal-dialog" role="document">
						    <div class="modal-content">
						      <div class="modal-header">
						        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						      </div>
						      <div class="modal-body">
						      	<form action="<?php echo base_url('C_bookmarks/archived_by') ?>" method="POST">
						        <h4><b>Alasan Non Aktifkan Dokumen</b></h4>
						        <textarea style="resize: none;" name="note" id="" cols="77" rows="9" minlength="20"></textarea>
						        <input type="hidden" name="si_archived" value="<?php echo $SESSION_ROLES; ?>">
						        <input type="hidden" name="si_key" value="<?php echo $key['DOC_ID']; ?>">
						      </div>
						      <div class="modal-footer">
						        <button type="submit" name="simpan" class="btn btn-default">Simpan</button>
						        <button type="submit" name="nonaktif" class="btn btn-primary">Non Aktifkan</button>
						      </div>
						      	</form>
						    </div>
						  </div>
						</div>
						<!-- Modal Versioning -->
						<div id="modal-versioning<?=$key['DOC_ID'];?>" class="modal" tabindex="-1">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h5 class="blue bigger">Pengkinian Dokumen</h5>
									</div>
									<div class="modal-body">
										<div class="row">
											<div class="col-sm-12">
												<div class="row">
													<div class="col-sm-2" style="width:20%;">
														<p>Nomor Dokumen</p>
													</div>
													<div class="col-sm-2" style="width:5%;">
														<p>:</p>
													</div>
													<div class="col-sm-8">
														<p><?php echo $key['DOC_NOMOR']; ?></p>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-2" style="width:20%;">
														<p>Nama Dokumen</p>
													</div>
													<div class="col-sm-2" style="width:5%;">
														<p>:</p>
													</div>
													<div class="col-sm-8">
														<p><?php echo $key['DOC_NAMA']; ?></p>
													</div>
												</div>
												<div class="row">
													<div class="col-sm-2" style="width:20%;">
														<p>Versi</p>
													</div>
													<div class="col-sm-2" style="width:5%;">
														<p>:</p>
													</div>
													<div class="col-sm-1">
														<input type="number" id="si_history_version2" name="si_history_version" placeholder="1.0" min="0" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==5) return false;" class="form-control" value="<?php echo $key['DOC_VERSI']; ?>" />
													</div>
													<div class="col-sm-2">
																		<button type="button" class="btn btn-link fa fa-info" data-toggle="tooltip" data-placement="right" title="Jika di pilih perubahan isi maka versi di tambah .5 sedangkan perubahan meta maka versi di tambah .1 !"></button>
																	</div>
																</div>
												</div>
												<div class="row" id="radio">
													<div class="col-sm-12">
														<input type="radio" class="radio_isi" id="radio1" name="up_doc" value="perubahan_isi"/> Perubahan Isi Dokumen
													</div>
													<div class="col-sm-12">
														<input type="radio" class="radio_meta" id="radio2" name="up_doc"/> Perubahan Meta Data Dokumen
													</div>
												</div><br/>
												<div class="row">
													<div class="col-sm-12">
														<form id="v_isi" class="hide" name="v_isi[]" action="<?php echo base_url('C_notification/versioning_isi'); ?>" method="post" enctype="multipart/form-data">
														<p>Catatan Versi</p>
														<textarea class="form-control catatan" id="catatan_isi" name="catatan_versi" style="resize:none;height:300px;" required></textarea>
														<br/>
														<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $key['DOC_ID']; ?>" class="form-control" required/>
														<a href="<?=base_url('C_menu/zip/'.$key['DOC_ID']);?>" id="btn-unduh" class="btn-unduh btn btn-sm btn-warning">Unduh</a>
														<button type="submit" class="btn btn-sm btn-success">Registrasi</button>
														</form>
													</div>
													<div class="col-sm-12">
														<form id="v_meta" class="hide" name="v_meta[]" action="<?php echo base_url('C_notification/versioning_meta'); ?>" method="post" enctype="multipart/form-data">
														<p>Catatan Versi</p>
														<textarea class="form-control catatan" id="catatan_meta" name="catatan_versi" style="resize:none;height:300px;" required></textarea>
														<br/>
														<input type="hidden" id="si_key[]" name="si_key[]" value="<?php echo $key['DOC_ID']; ?>" class="form-control" required/>
														<button type="submit" class="btn btn-sm btn-info">Registrasi</button>
														</form>
													</div>
												</div>
											</div>
										</div>
									<div class="modal-footer">
										<button class="btn btn-sm" data-dismiss="modal">
											<i class="ace-icon fa fa-times"></i>
											Close
										</button>
									</div>
									</div>
								</div>
							</div>
						</div>
					<!-- END -->
					<!-- ShareLink -->
						<div id="modal-sharelink<?=$key['DOC_ID'];?>" class="modal" tabindex="-1">
							<div class="modal-dialog modal-md">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h5 class="blue bigger">ShareLink</h5>
									</div>
									<div class="modal-body">
										<form action="<?php echo base_url('C_menu/sharelink'); ?>" id="form_link[]" name="form_link[]" method="post" enctype="multipart/form-data">
										<div class="form-group">
										    <label for="exampleInputEmail1">Email</label>
										    <select id="email" name="email" class="form-control" />
											<option value="">Pilih</option>
											<?php
											$get_data_ext = $this->Model_detail->DB_GET_EMAIL();
											foreach($get_data_ext as $data_row_ext){
											?>
											<option id="<?php echo $data_row_ext->UR_EMAIL; ?>" value="<?php echo $data_row_ext->UR_EMAIL; ?>"><?php echo $data_row_ext->UR_EMAIL; ?></option>
											<?php
											}
											?>
										</select>
										</div>
										<div class="form-group">
										    <label for="exampleInputEmail1">Tulis Pesan</label>
										    <textarea style="resize: none;" class="form-control" name="pesan" id="pesan" cols="30" rows="10"></textarea>
										</div>
									<div class="modal-footer">
										
											<input type="hidden" id="si_key" name="si_key" value="<?php echo $key['DOC_ID']; ?>" class="form-control" required/>
											<button class="btn btn-primary btn-sm">
												<i class="glyphicon glyphicon-plus"></i> Kirim</button>
										<button class="btn btn-sm" data-dismiss="modal">
											<i class="ace-icon fa fa-times"></i>
											Close
										</button>
										</form>
									</div>
									</div>
								</div>
							</div>
						</div>
						<!-- end -->
						<!-- DOKUMEN UTAMA -->
						<div id="dokumenutama<?=$key['DOCD_UTAMA'];?>" class="modal" tabindex="-1">
							<div class="modal-dialog1 modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h5 class="blue bigger"></h5>
									</div>
									<?php if ($key['DOCD_UTAMA_EXT']=='pdf' || $key['DOCD_UTAMA_EXT']=='doc' || $key['DOCD_UTAMA_EXT']=='docx' || $key['DOCD_UTAMA_EXT']=='xls' || $key['DOCD_UTAMA_EXT']=='xlsx' || $key['DOCD_UTAMA_EXT']=='ppt' || $key['DOCD_UTAMA_EXT']=='pptx' || $key['DOCD_UTAMA_EXT']=='vsd' || $key['DOCD_UTAMA_EXT']=='vsdx'): ?>
										<div class="modal-body">
											<object data="<?= base_url('assets/pdf/'.$key['DOCD_UTAMA']).'.pdf';?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="535px">
												<iframe src="<?= base_url('assets/pdf/'.$key['DOCD_UTAMA']).'.pdf';?>#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" width="100%" height="535px"></iframe>
											</object>
										</div>
										<?php else: ?>
										<div class="modal-body">
											<object data="<?= base_url('assets/original/'.$key['DOCD_UTAMA']).'.'.$key['DOCD_UTAMA_EXT'];?>#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="535px">
												<iframe src="<?= base_url('assets/pdf/'.$key['DOCD_UTAMA']).'.pdf';?>#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" width="100%" height="535px"></iframe>
											</object>
										</div>
									<?php endif; ?>

									<?php if ($key['DOCD_UTAMA_STATUS'] == 1){
										$url_download_utama = base_url('C_notification/download_pdf/'.$key['DOCD_UTAMA'].'.pdf');
									}else{
										$url_download_utama = base_url('C_notification/download_ori/'.$key['DOCD_UTAMA'].'.'.$key['DOCD_UTAMA_EXT']);
									}
									?>				
									<div class="modal-footer">
											
										<?php 
										$DOC_ID = $key['DOC_ID'];
										$datu = $this->Model_detail->getDetail($SESSION_DEPARTEMENT_ID,$DOC_ID,$SESSION_JOB_LEVEL_ID); 
										if ($datu):
										?>

										<a href="<?php echo $url_download_utama; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-download-alt"></i> DOWNLOAD</a>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<!-- end -->
						<!-- DOKUMEN PELENGKAP 1 -->
						<div id="dokumenpelengkap1<?=$key['DOCD_PELENGKAP_1'];?>" class="modal" tabindex="-1">
							<div class="modal-dialog1 modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h5 class="blue bigger"></h5>
									</div>
									<?php if ($key['DOCD_PELENGKAP_1_EXT']=='pdf' || $key['DOCD_PELENGKAP_1_EXT']=='doc' || $key['DOCD_PELENGKAP_1_EXT']=='docx' || $key['DOCD_PELENGKAP_1_EXT']=='xls' || $key['DOCD_PELENGKAP_1_EXT']=='xlsx' || $key['DOCD_PELENGKAP_1_EXT']=='ppt' || $key['DOCD_PELENGKAP_1_EXT']=='pptx' || $key['DOCD_PELENGKAP_1_EXT']=='vsd' || $key['DOCD_PELENGKAP_1_EXT']=='vsdx'): ?>
										<div class="modal-body">
											<object data="<?= base_url('assets/pdf/'.$key['DOCD_PELENGKAP_1']).'.pdf';?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="535px">
												<iframe src="<?= base_url('assets/pdf/'.$key['DOCD_PELENGKAP_1']).'.pdf';?>#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" width="100%" height="535px"></iframe>
											</object>
										</div>
										<?php elseif ($key['DOCD_PELENGKAP_1_EXT']=='mp4' ): ?>
											<video width="100%" controlsList="nodownload" height="500px" src="<?= base_url('assets/original/'.$key['DOCD_PELENGKAP_1']).'.'.$key['DOCD_PELENGKAP_1_EXT'];?>" controls></video>
										<?php elseif ($key['DOCD_PELENGKAP_1_EXT']=='dwg'):?>
											<h1 style="text-align: center;">TIDAK BISA MEMBUKA FILE DWG</h1>
										<?php else: ?>
										<div class="modal-body">
											<object data="<?= base_url('assets/original/'.$key['DOCD_PELENGKAP_1']).'.'.$key['DOCD_PELENGKAP_1_EXT'];?>#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="535px">
												<iframe src="<?= base_url('assets/original/'.$key['DOCD_PELENGKAP_1']).'.'.$key['DOCD_PELENGKAP_1_EXT'];?>#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" width="100%" height="535px"></iframe>
											</object>
										</div>
									<?php endif; ?>	

									<?php if ($key['DOCD_PELENGKAP_1_STATUS'] == 1){
										$url_download_pelengkap_1 = base_url('C_notification/download_pdf/'.$key['DOCD_PELENGKAP_1'].'.pdf');
									}else{
										$url_download_pelengkap_1 = base_url('C_notification/download_ori/'.$key['DOCD_PELENGKAP_1'].'.'.$key['DOCD_PELENGKAP_1_EXT']);
									}
									?>				
									<div class="modal-footer">
										<?php
										if ($datu):
										?>
										<a href="<?php echo $url_download_pelengkap_1; ?>" class="btn btn-primary">DOWNLOAD</a>
										<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
						<!-- end -->
						<!-- DOKUMEN PELENGKAP 2 -->
						<div id="dokumenpelengkap2<?=$key['DOCD_PELENGKAP_2'];?>" class="modal" tabindex="-1">
							<div class="modal-dialog1 modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h5 class="blue bigger"></h5>
									</div>
									<?php if ($key['DOCD_PELENGKAP_2_EXT']=='pdf' || $key['DOCD_PELENGKAP_2_EXT']=='doc' || $key['DOCD_PELENGKAP_2_EXT']=='docx' || $key['DOCD_PELENGKAP_2_EXT']=='xls' || $key['DOCD_PELENGKAP_2_EXT']=='xlsx' || $key['DOCD_PELENGKAP_2_EXT']=='ppt' || $key['DOCD_PELENGKAP_2_EXT']=='pptx' || $key['DOCD_PELENGKAP_2_EXT']=='vsd' || $key['DOCD_PELENGKAP_2_EXT']=='vsdx'): ?>
										<div class="modal-body">
											<object data="<?= base_url('assets/pdf/'.$key['DOCD_PELENGKAP_2']).'.pdf';?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="535px">
												<iframe src="<?= base_url('assets/pdf/'.$key['DOCD_PELENGKAP_2']).'.pdf';?>#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" width="100%" height="535px"></iframe>
											</object>
										</div>
										<?php elseif ($key['DOCD_PELENGKAP_2_EXT']=='mp4' ): ?>
											<video width="100%" controlsList="nodownload" height="500px" src="<?= base_url('assets/original/'.$key['DOCD_PELENGKAP_2']).'.'.$key['DOCD_PELENGKAP_2_EXT'];?>" controls></video>
										<?php elseif ($key['DOCD_PELENGKAP_2_EXT']=='dwg'):?>
											<h1>TIDAK BISA MEMBUKA FILE DWG</h1>
										<?php else: ?>
										<div class="modal-body">
											<object data="<?= base_url('assets/original/'.$key['DOCD_PELENGKAP_2']).'.'.$key['DOCD_PELENGKAP_2_EXT'];?>#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="535px">
												<iframe src="<?= base_url('assets/original/'.$key['DOCD_PELENGKAP_2']).'.'.$key['DOCD_PELENGKAP_2_EXT'];?>#toolbar=0&navpanes=0&scrollbar=0" frameborder="0" width="100%" height="535px"></iframe>
											</object>
										</div>
									<?php endif; ?>											
									<?php if ($key['DOCD_PELENGKAP_2_STATUS'] == 1){
										$url_download_pelengkap_2 = base_url('C_notification/download_pdf/'.$key['DOCD_PELENGKAP_2'].'.pdf');
									}else{
										$url_download_pelengkap_2 = base_url('C_notification/download_ori/'.$key['DOCD_PELENGKAP_2'].'.'.$key['DOCD_PELENGKAP_2_EXT']);
									}
									?>				
									<div class="modal-footer">
									<?php
										if ($datu):
										?>
										<a href="<?php echo $url_download_pelengkap_2; ?>" class="btn btn-primary">DOWNLOAD</a>
									<?php endif; ?>
									</div>
								</div>
							</div>
						</div>
							<!-- end -->
						<div class="row">
							<div class="col-md-5">
								<div id="accordion" class="accordion-style1 panel-group" style="margin-top: -7rem;">
									<div class="panel panel-default">
										<div class="panel-heading">
											<h4 class="panel-title">
												<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapse_new_data">
													<i class="ace-icon fa fa-angle-right bigger-110" data-icon-hide="ace-icon fa fa-angle-down" data-icon-show="ace-icon fa fa-angle-right"></i>
													Tulis Komentar Anda
												</a>
											</h4>
										</div>
										<div class="panel-collapse collapse in" id="collapse_new_data">
											<div class="panel-body">

												<form class="form-horizontal" id="form_new_data" name="form_new_data" action="<?php echo base_url('C_notification/comment_process'); ?>" method="post" enctype="multipart/form-data">

													<input type="hidden" id="si_docid" name="si_docid" value="<?php echo $key['DOC_ID']; ?>" class="form-control" required/>
													<input type="hidden" id="si_maker" name="si_maker" value="<?php echo $key['DOC_MAKER']; ?>" class="form-control" required/>

													<div class="form-group">
														<textarea type="text" name="si_review" id="si_review" rows="7" class="form-control" style="resize:none;width: 50.3rem;margin-left: 1rem;" required></textarea>
													</div>

													<button type="submit" id="btn_comment" name="btn_comment" class="ace-icon fa fa-check btn btn-success btn-sm">Kirim</button>
												</form>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php endforeach; ?>
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
<script src="<?php echo base_url('template/backend/assets/js/sweetalert.min.js'); ?>"></script>
	<?php if ($pesan = $this->session->flashdata('pesan')): ?>
	<script>
		swal("<?php echo $pesan; ?>", "Berhasil Di Bookmark!", "success");
	</script>
	<?php endif; ?>
	<?php if ($pesan_gagal = $this->session->flashdata('pesan_gagal')): ?>
	<script>
		swal("Maaf!", "Dokumen telah terbookmark!", "warning");
	</script>
	<?php endif; ?>
	<!-- pesan email -->
	<?php if ($pesan = $this->session->flashdata('pesan_email')): ?>
	<script>
		swal("<?php echo $pesan; ?>", "Email Berhasil Terkirim!", "success");
	</script>
	<?php endif; ?>
	<?php if ($pesan_gagal = $this->session->flashdata('pesan_email_gagal')): ?>
	<script>
		swal("Maaf!", "Email Gagal dikirim!", "error");
	</script>
	<?php endif; ?>

</body>
<!------------------------------------------------------------------------------------------------->
</html>
<!------------------------------------------------------------------------------------------------->
<script>
$('#show').hide();

	$('#click').click(function(){
		$('#show').show();
	});

	$('#myModal').on('shown.bs.modal', function () {
  		$('#myInput').focus()
	});

	$('#modal-versioning').on('shown.bs.modal', function () {
	  $('#myInput').focus()
	});
	
	$(function () {
		$('#radio1').change(function() {
			$('#v_isi').removeClass('hide');
			$('#v_meta').addClass('hide');
		});
		$('#radio2').change(function() {
			$('#v_isi').addClass('hide');
			$('#v_meta').removeClass('hide');
		});
		$('[data-toggle="tooltip"]').tooltip()
	});

	$(function(){
		$('#email').autocomplete({
			source : "<?php echo base_url('C_menu/autocompleteemail'); ?>"
		});
	})
</script>