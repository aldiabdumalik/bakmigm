<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_contribution extends CI_Controller {
	public function __construct(){
        parent::__construct();
		
		if($this->session->userdata('session_bgm_edocument_status') != "LOGIN"){
			redirect(base_url("C_index"));
		}
    }
	public function index(){
		$SESSION_ROLES = $this->session->userdata("session_bgm_edocument_roles");
		if ($SESSION_ROLES != "PENCIPTA") {
			redirect(base_url('C_menu'),'refresh');
		}
		$this->load->view('V_contribution');
	}
	public function insert(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_contribution').'";
				</script>
			';
			exit();
		}
		$SESSION_DEPARTEMENT_ID = $this->session->userdata("session_bgm_edocument_departement_id");
		$SESSION_DIVISI_ID = $this->session->userdata("session_bgm_edocument_divisi_id");
		include(APPPATH.'libraries/pdf2txt/PdfToText.phpclass');
		include (APPPATH.'libraries/FPDF/Fpdf.php');
		include (APPPATH.'libraries/FPDI/fpdi.php');
		date_default_timezone_set('Asia/Jakarta');
		//STEP 1
		$si_template_default_name				= $this->input->post('si_template_default_name');
		
		$si_template_new_kategori				= $this->input->post('si_template_new_kategori');
		$si_template_new_jenis					= $this->input->post('si_template_new_jenis');
		$si_template_new_tipe					= $this->input->post('si_template_new_tipe');
		$si_template_new_group_proses			= $this->input->post('si_template_new_group_proses');
		$si_template_new_proses					= $this->input->post('si_template_new_proses');
		//STEP 2
		$si_header_no							= $this->input->post('si_header_no');
		$si_header_name							= $this->input->post('si_header_name');
		$si_header_master						= $this->input->post('si_header_master');
		$si_header_distribution					= $this->input->post('si_header_distribution');
		$si_header_confidential					= $this->input->post('si_header_confidential');
		//STEP 3
		$duallistbox_akses_level = $this->input->post('duallistbox_akses_level');
		$duallistbox_akses_level_length = count($duallistbox_akses_level);
		$duallistbox_akses_level_array = "";
		for($x = 0; $x < $duallistbox_akses_level_length; $x++) {
			$duallistbox_akses_level_array .= $duallistbox_akses_level[$x]."|";
		}
		$duallistbox_akses_level_list = substr($duallistbox_akses_level_array,0,-1);
		
		$duallistbox_pengguna_dokumen = $this->input->post('duallistbox_pengguna_dokumen');
		$duallistbox_pengguna_dokumen_length = count($duallistbox_pengguna_dokumen);
		$duallistbox_pengguna_dokumen_array = "";
		for($x = 0; $x < $duallistbox_pengguna_dokumen_length; $x++) {
			$duallistbox_pengguna_dokumen_array .= $duallistbox_pengguna_dokumen[$x]."|";
		}
		$duallistbox_pengguna_dokumen_list = substr($duallistbox_pengguna_dokumen_array,0,-1);
		
		$si_owner_pemilik_proses				= $this->input->post('si_owner_pemilik_proses');
		$si_owner_dept_penyimpan				= $this->input->post('si_owner_dept_penyimpan');
		$si_owner_dept_pendistribusi			= $this->input->post('si_owner_dept_pendistribusi');
		//STEP 4
		$si_history_version						= $this->input->post('si_history_version');
		$si_history_date1						= $this->input->post('si_history_date');
		$si_history_date 						= date('Y-m-d', strtotime($si_history_date1));
		$si_history_period						= $this->input->post('si_history_period');
		$si_history_date_final1					= $this->input->post('si_history_date_final');
		$si_history_date_final 					= date('Y-m-d', strtotime($si_history_date_final1));
		$si_history_keyword						= $this->input->post('si_history_keyword');
		$si_history_abstract					= $this->input->post('si_history_abstract');
		//STEP 5
		$duallistbox_dokumen_terkait = $this->input->post('duallistbox_dokumen_terkait');
		if (!empty($duallistbox_dokumen_terkait)) {
			$duallistbox_dokumen_terkait_length = count($duallistbox_dokumen_terkait);
			$duallistbox_dokumen_terkait_array = "";
			for($x = 0; $x < $duallistbox_dokumen_terkait_length; $x++) {
				$duallistbox_dokumen_terkait_array .= $duallistbox_dokumen_terkait[$x]."|";
			}
			$duallistbox_dokumen_terkait_list = substr($duallistbox_dokumen_terkait_array,0,-1);
		}else{
			$duallistbox_dokumen_terkait_list = "";
		}

		$si_template_new_name					= $this->input->post('si_template_new_name');
		//SYSTEM
		$si_code								= $this->input->post('si_code');
		$si_userid								= $this->input->post('si_userid');
		$date_now								= date('Y-m-d H:i:s');

		$dokumen_utama_on = $this->input->post('dokumen_utama_on');
		$dokumen_pelengkap_1_on = $this->input->post('dokumen_pelengkap_1_on');
		$dokumen_pelengkap_2_on = $this->input->post('dokumen_pelengkap_2_on');

		// Ambil Pendistribusi
		if ($si_owner_dept_pendistribusi==$SESSION_DEPARTEMENT_ID) {
			$getPendistribusi = $this->M_library_database->getDEPARTEMEN($si_owner_dept_pendistribusi);
			foreach ($getPendistribusi as $data) {
				$dpt 		= $data->DN_ID;
				$dpt_code 	= $data->DN_CODE;
				$dpt_name 	= $data->DN_NAME;
			}
			$PENDISTRIBUSI_FINAL_CODE 	= $dpt_code;
			$PENDISTRIBUSI_FINAL_NAME 	= $dpt_name;
			$STATUS_FINAL				= "MENUNGGU PENDISTRIBUSI";
		}elseif ($si_owner_dept_pendistribusi==$SESSION_DIVISI_ID) {
			$getPendistribusi = $this->M_library_database->getDIVISI($si_owner_dept_pendistribusi);
			foreach ($getPendistribusi as $data) {
				$dv 		= $data->DI_ID;
				$dv_code	= $data->DI_CODE;
				$dv_name	= $data->DI_NAME;
			}
			$PENDISTRIBUSI_FINAL_CODE 	= $dv_code;
			$PENDISTRIBUSI_FINAL_NAME 	= $dv_name;
			$STATUS_FINAL				= "MENUNGGU ATASAN PENCIPTA";
		}else{
			$getPendistribusi = $this->M_library_database->getDEPARTEMEN($si_owner_dept_pendistribusi);
			foreach ($getPendistribusi as $data) {
				$dpt 		= $data->DN_ID;
				$dpt_code 	= $data->DN_CODE;
				$dpt_name 	= $data->DN_NAME;
			}
			$PENDISTRIBUSI_FINAL_CODE 	= $dpt_code;
			$PENDISTRIBUSI_FINAL_NAME 	= $dpt_name;
			$STATUS_FINAL				= "MENUNGGU PENDISTRIBUSI";
		}
		if ($si_header_distribution != "EDOC") {
			$get_data_template_by_user = $this->M_library_database->DB_GET_DATA_DOCUMENT_TEMPLATE_BY_ID_EVO($si_userid);
			if(empty($get_data_template_by_user)||$get_data_template_by_user==""){
				$count_template = 0;
			}else{
				$count_template = count($get_data_template_by_user);
			}
			if($si_template_new_name!=""){
				if($count_template < 10){
					$data_insert_template = array(
						'DOCTEMP_ID' => $si_code,
						'DOCTEMP_NAME' => $si_template_new_name,
						'DTSEKI_ID' => $si_template_new_kategori,
						'DTSEJS_ID' => $si_template_new_jenis,
						'DTSETE_ID' => $si_template_new_tipe,
						'DOCTEMP_GROUP_PROSES' => $si_template_new_group_proses,
						'DOCTEMP_PROSES' => $si_template_new_proses,
						'DOCTEMP_NOMOR' => $si_header_no,
						'DOCTEMP_NAMA' => $si_header_name,
						'DOC_WUJUD' => $si_header_master,
						'DOC_DISTRIBUSI' => $si_header_distribution,
						'DOC_KERAHASIAAN' => $si_header_confidential,
						'UR_ID' => $si_userid
					);
					$is_ok = $this->M_library_database->DB_INSERT_DATA_DOCUMENT_TEMPLATE_EVO($data_insert_template);
				}else{
					echo '<script>alert("Template Lebih Dari 10, Penyimpanan Template Tidak Berhasil");</script>';
				}
			}

			$data_insert = array(
				'DOC_ID' => $si_code,
				'DOC_DATE' => $date_now,		
				'DOC_KATEGORI' => $si_template_new_kategori,
				'DOC_JENIS' => $si_template_new_jenis,
				'DOC_TIPE' => $si_template_new_tipe,
				'DOC_GROUP_PROSES' => $si_template_new_group_proses,
				'DOC_PROSES' => $si_template_new_proses,
				'DOC_NOMOR' => $si_header_no,
				'DOC_NAMA' => $si_header_name,
				'DOC_WUJUD' => $si_header_master,
				'DOC_DISTRIBUSI' => $si_header_distribution,
				'DOC_KERAHASIAAN' => $si_header_confidential,
				'DOC_AKSES_LEVEL' => $duallistbox_akses_level_list,
				'DOC_PENGGUNA' => $duallistbox_pengguna_dokumen_list,
				'DOC_PEMILIK_PROSES' => $si_owner_pemilik_proses,
				'DOC_PENYIMPAN' => $si_owner_dept_penyimpan,
				'DOC_PENDISTRIBUSI' => $si_owner_dept_pendistribusi,
				'DOC_VERSI' => $si_history_version,
				'DOC_TGL_EFEKTIF' => $si_history_date,
				'DOC_PERIODE_PREVIEW' => $si_history_period,
				'DOC_TGL_EXPIRED' => $si_history_date_final,
				'DOC_KATA_KUNCI' => $si_history_keyword,
				'DOC_ABSTRAK' => $si_history_abstract,
				'DOC_TERKAIT' => $duallistbox_dokumen_terkait_list,
				'DOC_MAKER' => $si_userid,
				'DOC_APPROVE' => "-",
				'DOC_STATUS' => $STATUS_FINAL,
				'DOC_STATUS_ACTIVITY' => "Menunggu Persetujuan dari ".$PENDISTRIBUSI_FINAL_CODE." (".$PENDISTRIBUSI_FINAL_NAME.")",
				'DOC_NOTE' => "-"
			);
			$is_ok = $this->M_library_database->DB_INSERT_DATA_DOCUMENT($data_insert);
			$data_insert_detail = array(
				'DOC_ID' => $si_code,
				'DOCD_UTAMA' => "File_Not_Found",
				'DOCD_UTAMA_TYPE' => "-",
				'DOCD_UTAMA_STATUS' => "-",
				'DOCD_UTAMA_EXT' => "-",
				'DOCD_PELENGKAP_1' => "File_Not_Found",
				'DOCD_PELENGKAP_1_TYPE' => "-",
				'DOCD_PELENGKAP_1_STATUS' => "-",
				'DOCD_PELENGKAP_1_EXT' => "-",
				'DOCD_PELENGKAP_2' => "File_Not_Found",
				'DOCD_PELENGKAP_2_TYPE' => "-",
				'DOCD_PELENGKAP_2_STATUS' => "-",
				'DOCD_PELENGKAP_2_EXT' => "-",
				'DOCD_PERSETUJUAN' => "File_Not_Found",
				'DOCD_PERSETUJUAN_TYPE' => "-",
				'DOCD_SEARCH' => "-"
			);
			$is_ok = $this->M_library_database->DB_INSERT_DATA_DOCUMENT_DETAIL_EVO($data_insert_detail);
		}else{
			$get_data_template_by_user = $this->M_library_database->DB_GET_DATA_DOCUMENT_TEMPLATE_BY_ID_EVO($si_userid);
			if(empty($get_data_template_by_user)||$get_data_template_by_user==""){
				$count_template = 0;
			}else{
				$count_template = count($get_data_template_by_user);
			}
			if($si_template_new_name!=""){
				if($count_template < 10){
					$data_insert_template = array(
						'DOCTEMP_ID' => $si_code,
						'DOCTEMP_NAME' => $si_template_new_name,
						'DTSEKI_ID' => $si_template_new_kategori,
						'DTSEJS_ID' => $si_template_new_jenis,
						'DTSETE_ID' => $si_template_new_tipe,
						'DOCTEMP_GROUP_PROSES' => $si_template_new_group_proses,
						'DOCTEMP_PROSES' => $si_template_new_proses,
						'DOCTEMP_NOMOR' => $si_header_no,
						'DOCTEMP_NAMA' => $si_header_name,
						'DOC_WUJUD' => $si_header_master,
						'DOC_DISTRIBUSI' => $si_header_distribution,
						'DOC_KERAHASIAAN' => $si_header_confidential,
						'UR_ID' => $si_userid
					);
					$is_ok = $this->M_library_database->DB_INSERT_DATA_DOCUMENT_TEMPLATE_EVO($data_insert_template);
				}else{
					echo '<script>alert("Template Lebih Dari 10, Penyimpanan Template Tidak Berhasil");</script>';
				}
			}

			$config1['upload_path'] = './assets/original';
			$config1['upload_url'] = './assets/original';
			$config1['remove_spaces'] = TRUE;
			$config1['allowed_types']='*';
			$this->load->library('upload', $config1);
			// Dokumen Utama
			$dokumen_utama = $_FILES['dokumen_utama'];
			$dokumen_utama_ext = $_FILES['dokumen_utama']['type'];
			$dokumen_utama_size = ($_FILES['dokumen_utama']['size'])/(1000*1000);
			$dokumen_utama_temp = $dokumen_utama['tmp_name'];
			$dokumen_utama_name = $_FILES['dokumen_utama']['name'];
			// Extention
			$dokumen_utama_extention = substr($dokumen_utama_name, strrpos($dokumen_utama_name, '.')+1);
			if ($this->upload->do_upload('dokumen_utama')) {
				$file1 = $this->upload->data('file_name');
				$file1Name = $this->upload->data('raw_name');
				if ($dokumen_utama_extention == 'doc' || $dokumen_utama_extention == 'docx' || $dokumen_utama_extention == 'xls' || $dokumen_utama_extention == 'xlsx' || $dokumen_utama_extention == 'ppt' || $dokumen_utama_extention == 'pptx' || $dokumen_utama_extention == 'vsd' || $dokumen_utama_extention == 'vsdx' || $dokumen_utama_extention == 'pdf') {
					// Converter
					shell_exec('export HOME=/tmp && libreoffice --headless --convert-to pdf --outdir assets/pdf assets/original/'.$file1);
					$dokumen_search_acr = "";
					$txt1 = new PdfToText(base_url('assets/pdf/'.$file1Name.'.pdf'));
					$dokumen_search_acr = $txt1->Text;
					// Watermark Pdf
					if ($dokumen_utama_extention != 'pdf') {
						$GLOBALS['dokumen_utama'] = './assets/pdf/'.$file1Name.'.pdf';
						chmod($GLOBALS['dokumen_utama'], 0777);
					}else{
						$GLOBALS['dokumen_utama'] = './assets/original/'.$file1Name.'.pdf';
						chmod($GLOBALS['dokumen_utama'], 0777);
					}
					include (APPPATH.'libraries/watermark_utama.php');
					$pdf = new Watermark_utama();
					$pdf->AddPage();
					$pdf->SetFont('Arial', '', 12);
					if($pdf->numPages>1) {
						for($i=2;$i<=$pdf->numPages;$i++) {
							$pdf->_tplIdx = $pdf->importPage($i);
							$pdf->AddPage();
						}
					}
					$pdf->Output($GLOBALS['dokumen_utama'],'F');
				}else{
					$dokumen_search_acr = $si_history_abstract;
				}
				
				$dokumen_utama_name = $file1Name;
				if (isset($dokumen_utama_on)) {
					$convert_dokumen_utama = 1;
				}else{
					$convert_dokumen_utama = 0;
				}
			} else {
				$errors = $this->upload->display_errors();
				die($errors);
			}

			// Dokumen Pelengkap 1
			$dokumen_pelengkap_1 = $_FILES['dokumen_pelengkap_1'];
			if ($_FILES['dokumen_pelengkap_1']['size']!=0) {
				$dokumen_pelengkap_1_ext = $_FILES['dokumen_pelengkap_1']['type'];
				$dokumen_pelengkap_1_temp = $dokumen_pelengkap_1['tmp_name'];
				$dokumen_pelengkap_1_name = $_FILES['dokumen_pelengkap_1']['name'];
				// Extention
				$dokumen_pelengkap_1_extention = substr($dokumen_pelengkap_1_name, strrpos($dokumen_pelengkap_1_name, '.')+1);
				if($this->upload->do_upload('dokumen_pelengkap_1')) {
					$file2 = $this->upload->data('file_name');
					$file2Name = $this->upload->data('raw_name');
					if ($dokumen_pelengkap_1_extention == 'doc' || $dokumen_pelengkap_1_extention == 'docx' || $dokumen_pelengkap_1_extention == 'xls' || $dokumen_pelengkap_1_extention == 'xlsx' || $dokumen_pelengkap_1_extention == 'ppt' || $dokumen_pelengkap_1_extention == 'pptx' || $dokumen_pelengkap_1_extention == 'vsd' || $dokumen_pelengkap_1_extention == 'vsdx' || $dokumen_pelengkap_1_extention == 'pdf') {
						shell_exec('export HOME=/tmp && libreoffice --headless -convert-to pdf --outdir assets/pdf assets/original/'.$file2);
						// Watermark Pdf
						if ($dokumen_pelengkap_1_extention != 'pdf') {
							$GLOBALS['dokumen_pelengkap_1'] = './assets/pdf/'.$file2Name.'.pdf';
							chmod($GLOBALS['dokumen_pelengkap_1'], 0777);
						}else{
							$GLOBALS['dokumen_pelengkap_1'] = './assets/original/'.$file2Name.'.pdf';
							chmod($GLOBALS['dokumen_pelengkap_1'], 0777);
						}
						include (APPPATH.'libraries/watermark_p1.php');
						$pdf = new Watermark_p1();
						$pdf->AddPage();
						$pdf->SetFont('Arial', '', 12);
						if($pdf->numPages>1) {
							for($i=2;$i<=$pdf->numPages;$i++) {
								$pdf->_tplIdx = $pdf->importPage($i);
								$pdf->AddPage();
							}
						}
						$pdf->Output($GLOBALS['dokumen_pelengkap_1'],'F');
					}
					$dokumen_pelengkap_1_name = $file2Name;
					if (isset($dokumen_pelengkap_1_on)) {
						$convert_dokumen_pelengkap_1 = 1;
					}else{
						$convert_dokumen_pelengkap_1 = 0;
					}
				}else{
					$errors = $this->upload->display_errors();
					die($errors);
				}
			}else{
				$dokumen_pelengkap_1_ext = '-';
				$dokumen_pelengkap_1_name = 'File Not Found';
				$convert_dokumen_pelengkap_1 = 0;
				$dokumen_pelengkap_1_extention = '-';
			}

			// Dokumen Pelengkap 2
			$dokumen_pelengkap_2 = $_FILES['dokumen_pelengkap_2'];
			if ($_FILES['dokumen_pelengkap_2']['size']!=0) {
				$dokumen_pelengkap_2_ext = $_FILES['dokumen_pelengkap_2']['type'];
				$dokumen_pelengkap_2_temp = $dokumen_pelengkap_2['tmp_name'];
				$dokumen_pelengkap_2_name = $_FILES['dokumen_pelengkap_2']['name'];
				// Extention
				$dokumen_pelengkap_2_extention = substr($dokumen_pelengkap_2_name, strrpos($dokumen_pelengkap_2_name, '.')+1);
				if ($this->upload->do_upload('dokumen_pelengkap_2')){
					$file3 = $this->upload->data('file_name');
					$file3Name = $this->upload->data('raw_name');
					if ($dokumen_pelengkap_2_extention == 'doc' || $dokumen_pelengkap_2_extention == 'docx' || $dokumen_pelengkap_2_extention == 'xls' || $dokumen_pelengkap_2_extention == 'xlsx' || $dokumen_pelengkap_2_extention == 'ppt' || $dokumen_pelengkap_2_extention == 'pptx' || $dokumen_pelengkap_2_extention == 'vsd' || $dokumen_pelengkap_2_extention == 'vsdx' || $dokumen_pelengkap_2_extention == 'pdf') {
						shell_exec('export HOME=/tmp && libreoffice --headless -convert-to pdf --outdir assets/pdf assets/original/'.$file3);
						// Watermark Pdf
						if ($dokumen_pelengkap_2_extention != 'pdf') {
							$GLOBALS['dokumen_pelengkap_2'] = './assets/pdf/'.$file3Name.'.pdf';
							chmod($GLOBALS['dokumen_pelengkap_2'], 0777);
						}else{
							$GLOBALS['dokumen_pelengkap_2'] = './assets/original/'.$file3Name.'.pdf';
							chmod($GLOBALS['dokumen_pelengkap_2'], 0777);
						}
						include (APPPATH.'libraries/watermark_p2.php');
						$pdf = new Watermark_p2();
						$pdf->AddPage();
						$pdf->SetFont('Arial', '', 12);
						if($pdf->numPages>1) {
							for($i=2;$i<=$pdf->numPages;$i++) {
								$pdf->_tplIdx = $pdf->importPage($i);
								$pdf->AddPage();
							}
						}
						$pdf->Output($GLOBALS['dokumen_pelengkap_2'],'F');
					}
					
					$dokumen_pelengkap_2_name = $file3Name;
					if (isset($dokumen_pelengkap_2_on)) {
						$convert_dokumen_pelengkap_2 = 1;
					}else{
						$convert_dokumen_pelengkap_2 = 0;
					}
				}else{
					$errors = $this->upload->display_errors();
					die($errors);
				}
			}else{
				$dokumen_pelengkap_2_ext = '-';
				$dokumen_pelengkap_2_name = 'File Not Found';
				$convert_dokumen_pelengkap_2 = 0;
				$dokumen_pelengkap_2_extention = '-';
			}
			

			// Dokumen Persetujuan
			$dokumen_persetujuan = $_FILES['dokumen_persetujuan'];
			$dokumen_persetujuan_ext = $_FILES['dokumen_persetujuan']['type'];
			$dokumen_persetujuan_temp = $dokumen_persetujuan['tmp_name'];
			$dokumen_persetujuan_name = $_FILES['dokumen_persetujuan']['name'];
			if($this->upload->do_upload('dokumen_persetujuan')){
				$file4 = $this->upload->data('file_name');
				$GLOBALS['dokumen_persetujuan'] = './assets/original/'.$file4;
				chmod($GLOBALS['dokumen_persetujuan'], 0777);
				include (APPPATH.'libraries/watermark_persetujuan.php');
				$pdf = new Watermark_persetujuan();
				$pdf->AddPage();
				$pdf->SetFont('Arial', '', 12);
				if($pdf->numPages>1) {
					for($i=2;$i<=$pdf->numPages;$i++) {
						$pdf->_tplIdx = $pdf->importPage($i);
						$pdf->AddPage();
					}
				}
				$pdf->Output($GLOBALS['dokumen_persetujuan'],'F');
				$dokumen_persetujuan_name = $file4;
			}

			$data_insert = array(
				'DOC_ID' => $si_code,
				'DOC_DATE' => $date_now,		
				'DOC_KATEGORI' => $si_template_new_kategori,
				'DOC_JENIS' => $si_template_new_jenis,
				'DOC_TIPE' => $si_template_new_tipe,
				'DOC_GROUP_PROSES' => $si_template_new_group_proses,
				'DOC_PROSES' => $si_template_new_proses,
				'DOC_NOMOR' => $si_header_no,
				'DOC_NAMA' => $si_header_name,
				'DOC_WUJUD' => $si_header_master,
				'DOC_DISTRIBUSI' => $si_header_distribution,
				'DOC_KERAHASIAAN' => $si_header_confidential,
				'DOC_AKSES_LEVEL' => $duallistbox_akses_level_list,
				'DOC_PENGGUNA' => $duallistbox_pengguna_dokumen_list,
				'DOC_PEMILIK_PROSES' => $si_owner_pemilik_proses,
				'DOC_PENYIMPAN' => $si_owner_dept_penyimpan,
				'DOC_PENDISTRIBUSI' => $si_owner_dept_pendistribusi,
				'DOC_VERSI' => $si_history_version,
				'DOC_TGL_EFEKTIF' => $si_history_date,
				'DOC_PERIODE_PREVIEW' => $si_history_period,
				'DOC_TGL_EXPIRED' => $si_history_date_final,
				'DOC_KATA_KUNCI' => $si_history_keyword,
				'DOC_ABSTRAK' => $si_history_abstract,
				'DOC_TERKAIT' => $duallistbox_dokumen_terkait_list,
				'DOC_MAKER' => $si_userid,
				'DOC_APPROVE' => "-",
				'DOC_STATUS' => $STATUS_FINAL,
				'DOC_STATUS_ACTIVITY' => "Menunggu Persetujuan dari ".$PENDISTRIBUSI_FINAL_CODE." (".$PENDISTRIBUSI_FINAL_NAME.")",
				'DOC_NOTE' => "-"
			);
			$is_ok = $this->M_library_database->DB_INSERT_DATA_DOCUMENT($data_insert);
			$data_insert_detail = array(
				'DOC_ID' => $si_code,
				'DOCD_UTAMA' => str_replace(' ', '_', $dokumen_utama_name),
				'DOCD_UTAMA_TYPE' => $dokumen_utama_ext,
				'DOCD_UTAMA_STATUS' => $convert_dokumen_utama,
				'DOCD_UTAMA_EXT' => $dokumen_utama_extention,
				'DOCD_PELENGKAP_1' => str_replace(' ', '_', $dokumen_pelengkap_1_name),
				'DOCD_PELENGKAP_1_TYPE' => $dokumen_pelengkap_1_ext,
				'DOCD_PELENGKAP_1_STATUS' => $convert_dokumen_pelengkap_1,
				'DOCD_PELENGKAP_1_EXT' => $dokumen_pelengkap_1_extention,
				'DOCD_PELENGKAP_2' => str_replace(' ', '_', $dokumen_pelengkap_2_name),
				'DOCD_PELENGKAP_2_TYPE' => $dokumen_pelengkap_2_ext,
				'DOCD_PELENGKAP_2_STATUS' => $convert_dokumen_pelengkap_2,
				'DOCD_PELENGKAP_2_EXT' => $dokumen_pelengkap_2_extention,
				'DOCD_PERSETUJUAN' => str_replace(' ', '_', $dokumen_persetujuan_name),
				'DOCD_PERSETUJUAN_TYPE' => $dokumen_persetujuan_ext,
				'DOCD_SEARCH' => $dokumen_search_acr
			);
			$is_ok = $this->M_library_database->DB_INSERT_DATA_DOCUMENT_DETAIL_EVO($data_insert_detail);
		}
		if($is_ok){
			$this->session->set_flashdata('pesan','Berhasil!');
			redirect(base_url('C_contribution'),'refresh');
		}else{
			$this->session->set_flashdata('pesan_gagal','Gagal!');
			redirect(base_url('C_contribution'),'refresh');
		}
	}

	public function cek_nomor()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			redirect(base_url('C_contribution'),'refresh');
		}
		$this->load->model('M_library_database');
		if($this->M_library_database->get_nomor($_POST['si_header_no'])){
			echo '<label class="text-danger"><span id="boleh"><i class="fa fa-times" aria-hidden="true"></i> Nomor Dokumen Sudah Terpakai!</span></label><input type="hidden" name="" id="boleh_lanjut" value="">';
		}else{
			echo '<label class="text-success"><span id="tidak"><i class="fa fa-check" aria-hidden="true"></i> Nomor Dokumen Tersedia!</span></label><input type="hidden" name="" id="boleh_lanjut" value="lanjut">';
		}
	}

	// Belum
	public function insert_template()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			redirect(base_url('C_contribution'),'refresh');
		}
		$nama_temp	= $this->input->post('nama_template');

		$kategori 	= $this->input->post('kategori');
		$jenis 		= $this->input->post('jenis');
		$tipe 		= $this->input->post('tipe');
		$grup 		= $this->input->post('grup_proses');
		$proses		= $this->input->post('proses');

		$nomor 		= $this->input->post('nomor');
		$nama 		= $this->input->post('nama');
		$wujud 		= $this->input->post('wujud');
		$metode 	= $this->input->post('metode');
		$rahasia	= $this->input->post('rahasia');

		$user 		= $this->input->post('user');

		$data = array(
			'DOCTEMP_ID' => $this->M_library_module->GENERATOR_REFF(),
			'DOCTEMP_NAME' => $nama_temp,
			'DTSEKI_ID' => $kategori,
			'DTSEJS_ID' => $jenis,
			'DTSETE_ID' => $tipe,
			'DOCTEMP_GROUP_PROSES' => $grup,
			'DOCTEMP_PROSES' => $proses,
			'DOCTEMP_NOMOR' => $nomor,
			'DOCTEMP_NAMA' => $nama,
			'DOC_WUJUD' => $wujud,
			'DOC_DISTRIBUSI' => $metode,
			'DOC_KERAHASIAAN' => $rahasia,
			'UR_ID' => $user
		);
		$insert = $this->M_library_database->DB_INSERT_DATA_DOCUMENT_TEMPLATE_EVO($data);
        echo json_encode(array("status" => TRUE));
	}
	public function get_data_document_structure_kategori_jenis_tipe(){
		$post_data = $this->input->post();
		$id_key = $post_data['id_key'];
		$data = $this->M_library_database->DB_GET_DATA_DOCUMENT_TEMPLATE_AUTO_BUILD_EVO($id_key);
		$result = json_encode($data);
		echo $result;exit();
	}
	public function get_data_document_structure_jenis(){
		$post_data = $this->input->post();
		$id_key = $post_data['id_key'];
		$data = $this->M_library_database->DB_GET_DATA_DOCUMENT_STRUCTURE_JENIS_EVO($id_key);
		$result = json_encode($data);
		echo $result;exit();
	}
	public function get_data_document_structure_tipe(){
		$post_data = $this->input->post();
		$id_key = $post_data['id_key'];
		$data = $this->M_library_database->DB_GET_DATA_DOCUMENT_STRUCTURE_TIPE_EVO($id_key);
		$result = json_encode($data);
		echo $result;exit();
	}
	public function get_data_document_structure_tipe_confidental(){
		$post_data = $this->input->post();
		$id_key = $post_data['id_key'];
		$data = $this->M_library_database->DB_GET_DATA_DOCUMENT_STRUCTURE_TIPE_CONFIDENTAL_EVO($id_key);
		$result = json_encode($data);
		echo $result;exit();
	}
	public function get_data_document_template_or_document_structure_tipe(){
		$post_data = $this->input->post();
		$id_key = $post_data['id_key'];
		$data = $this->M_library_database->DB_GET_DATA_DOCUMENT_TEMPLATE_OR_DOCUMENT_STRUCTURE_TIPE($id_key);
		$result = json_encode($data);
		echo $result;exit();
	}
	public function get_data_job_level_evo(){
		$data = $this->M_library_database->DB_GET_JOB_LEVEL_EVO();
		$result = json_encode($data);
		echo $result;exit();
	}
	public function get_data_job_level_evo_ext(){
		$post_data = $this->input->post();
		$id_key = $post_data['id_key'];
		$data = $this->M_library_database->DB_GET_JOB_LEVEL_EVO_EXT($id_key);
		$result = json_encode($data);
		echo $result;exit();
	}
	public function getDocumentList() {
		
			// Datatables Variables
			$draw = intval($this->input->get("draw"));
			$start = intval($this->input->get("start"));
			$length = intval($this->input->get("length"));
			$searchParams = $this->input->get('search');
			$searchValue = $searchParams['value'];
  
  
			$query = $this->db->query("SELECT a.DOC_ID,b.DOC_NAMA,c.DN_NAME,b.DOC_DATE,b.DOC_STATUS,a.DOCD_UTAMA,a.DOCD_SEARCH
									   FROM  tb_document_detail a 
									   JOIN tb_document b ON a.DOC_ID=b.DOC_ID
									   JOIN tb_departemen c ON c.DN_ID=b.DOC_PEMILIK_PROSES
									   WHERE  b.DOC_STATUS = 'PUBLISH'
									   AND (a.DOC_ID LIKE '%".$searchValue."%'
									   OR a.DOCD_SEARCH LIKE '%".$searchValue."%'
									   OR b.DOC_NAMA LIKE '%".$searchValue."%')
									");
  
			$data = array();
  
			foreach($query->result() as $r) {
  
				 $data[] = array(
					  'DOC_ID' => $r->DOC_ID,
					  'DOC_NAMA' => $r->DOC_NAMA,
					  'DN_NAME' =>$r->DN_NAME,
					  'DOC_DATE' => $r->DOC_DATE,
					  'DOC_STATUS' => $r->DOC_STATUS,
					  'DOCD_UTAMA' => $r->DOCD_UTAMA,
					  'DOCD_SEARCH' => $r->DOCD_SEARCH
				 );
			}
  
			$output = array(
				 "draw" => $draw,
				   "recordsTotal" => $query->num_rows(),
				   "recordsFiltered" => $query->num_rows(),
				   "data" => $data
			  );
			echo json_encode($output);
			exit();
	}
}
