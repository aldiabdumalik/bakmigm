<?php
defined('BASEPATH') or exit('No direct script access allowed');
class C_menu extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_detail');
		$this->load->library('user_agent');
		// if ($this->session->userdata('session_bgm_edocument_status') != "LOGIN") {
		// 	redirect(base_url("C_index"));
		// }
	}
	public function index()
	{
		if ($this->session->userdata('session_bgm_edocument_status') != "LOGIN") {
			redirect(base_url("C_index"));
		}
		$SESSION_DEPARTEMENT_ID = $this->session->userdata("session_bgm_edocument_departement_id");
		$SESSION_JOB_LEVEL_ID = $this->session->userdata("session_bgm_edocument_job_level_id");
		$data['detail'] = $this->Model_detail->GET_DETAIL_SERCH($SESSION_DEPARTEMENT_ID,$SESSION_JOB_LEVEL_ID);
		$this->load->view('V_menu', $data);
	}

	function detail($id)
	{
		$_SESSION['link'] = base_url('C_menu/detail/'.$id);
		if ($this->session->userdata('session_bgm_edocument_status') != "LOGIN") {
			redirect(base_url("C_index"));
		}
		$get = $this->Model_detail->getDetailList($id);
		if(empty($get)){
			echo '
				<script>
					alert("DATA NOT FOUND");
					window.location.href = "'.base_url('C_menu').'";
				</script>
			';
			exit();
		}
		$data['detaillist'] = $this->Model_detail->getDetailList($id);
		$this->load->view('V_detail_list', $data);
	}

	public function cari()
	{
		if ($this->session->userdata('session_bgm_edocument_status') != "LOGIN") {
			redirect(base_url("C_index"));
		}
		$keyword = $this->input->post('keyword');
		$data['detail'] = $this->Model_detail->search($keyword);
		$this->load->view('V_menu', $data);
	}

	function cari_advance()
	{
		if ($this->session->userdata('session_bgm_edocument_status') != "LOGIN") {
			redirect(base_url("C_index"));
		}
		$si_doc_type = $this->input->post('si_doc_type');
		$ssa_dept_owner = $this->input->post('ssa_dept_owner');
		$ssa_group_proces = $this->input->post('ssa_group_proces');
		$ssa_proces = $this->input->post('ssa_proces');
		$data['detail'] = $this->Model_detail->pencarian($si_doc_type,$ssa_dept_owner,$ssa_group_proces,$ssa_proces);
		$this->load->view('V_menu', $data);
	}
	public function sharelink()
	{
		if ($this->session->userdata('session_bgm_edocument_status') != "LOGIN") {
			redirect(base_url("C_index"));
		}
		$si_key 	= $this->input->post('si_key');
		$email 		= $this->input->post('email');
		$pesan 		= $this->input->post('pesan');
		// $pengguna 	= "PENGGUNA";
		// $user 		= $this->Model_detail->getLevel($pengguna);
		// $user_email = array();
		// foreach ($user as $key) {
		// 	$user_email[] = $key["UR_EMAIL"];
		// }
		$url 		= base_url('C_menu/detail/'.$si_key);
		$config = [
			'useragent' => 'CodeIgniter',
			'protocol'  => 'smtp',
			'mailpath'  => '/usr/sbin/sendmail',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_user' => 'akuntest437@gmail.com',
			'smtp_pass' => 'akuntest123',
			'smtp_port' => 465,
			'smtp_keepalive' => TRUE,
			'smtp_crypto' => 'SSL',
			'wordwrap'  => TRUE,
			'wrapchars' => 80,
			'mailtype'  => 'html',
			'charset'   => 'utf-8',
			'validate'  => TRUE,
			'crlf'      => "\r\n",
			'newline'   => "\r\n",
		];
		$this->load->library('email', $config);
		$this->email->from('no-reply@bakmigm.com', 'Bakmi GM');
		$this->email->to($email);
		$this->email->subject('Dokumen Baru');
		$this->email->message(''.$pesan.'<br/> URL : '.$url.'<br/>'
		);
		if($this->email->send()){
			$this->session->set_flashdata('pesan_email','Berhasil!');
			redirect($url,'refresh');
		}else{
			$this->session->set_flashdata('pesan_email_gagal','Gagal!');
			redirect($url,'refresh');
		}

	}

	function email()
	{
		if ($this->session->userdata('session_bgm_edocument_status') != "LOGIN") {
			redirect(base_url("C_index"));
		}
		$data['email'] = $this->Model_detail->getEmail();
		$this->load->view('V_detail_list', $data);
	}

	public function zip($ID)
	{
		if ($this->session->userdata('session_bgm_edocument_status') != "LOGIN") {
			redirect(base_url("C_index"));
		}
		if (empty($ID)) {
			redirect(base_url('C_menu'),'refresh');
		}
		$SESSION_ID = $this->session->userdata('session_bgm_edocument_id');
		$this->load->library('zip');
		$get_data_doc = $this->Model_detail->getDOCD($ID);
		foreach($get_data_doc as $data_row_doc){
			$DOC_NOMOR = $data_row_doc->DOC_NOMOR;
			$DOC_NAMA = $data_row_doc->DOC_NAMA;
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
		// FIle Dokumen Utama
		if ($STATUS_UTAMA==1) {
			$file_utama = $DOCD_UTAMA.'.pdf';
			$getUtama = './assets/pdf/'.$file_utama;
		}else{
			$file_utama = $DOCD_UTAMA.'.'.$EXT_UTAMA;
			$getUtama = './assets/original/'.$file_utama;
		}
		// File Dokumen Pelengkap 1
		if ($DOCD_PELENGKAP_1!='File_Not_Found') {
			if ($EXT_1=='doc'||$EXT_1=='docx'||$EXT_1=='xls'||$EXT_1=='xlsx'||$EXT_1=='vsd'||$EXT_1=='vsdx'||$EXT_1=='ppt'||$EXT_1=='pptx') {
				if ($STATUS_1==1) {
					$file_1 = $DOCD_PELENGKAP_1.'.pdf';
					$get_1 =  './assets/pdf/'.$file_1;
				}else{
					$file_1 = $DOCD_PELENGKAP_1.'.'.$EXT_1;
					$get_1 =  './assets/original/'.$file_1;
				}
			}else{
				$file_1 = $DOCD_PELENGKAP_1.'.'.$EXT_1;
				$get_1 =  './assets/original/'.$file_1;
			}
		}
		// File Dokumen Pelengkap 2
		if ($DOCD_PELENGKAP_2!='File_Not_Found') {
			if ($EXT_2=='doc'||$EXT_2=='docx'||$EXT_2=='xls'||$EXT_2=='xlsx'||$EXT_2=='vsd'||$EXT_2=='vsdx'||$EXT_2=='ppt'||$EXT_2=='pptx') {
				if ($STATUS_2==1) {
					$file_2 = $DOCD_PELENGKAP_2.'.pdf';
					$get_2 = './assets/pdf/'.$file_2;
				}else{
					$file_2 = $DOCD_PELENGKAP_2.'.'.$EXT_2;
					$get_2 = './assets/original/'.$file_2;
				}
			}else{
				$file_2 = $DOCD_PELENGKAP_2.'.'.$EXT_2;
				$get_2 = './assets/original/'.$file_2;
			}
		}
		// File Dokumen Persetujuan
		$file_persetujuan = $DOCD_PERSETUJUAN;
		$get_persetujuan = './assets/original/'.$file_persetujuan;
		// Add Info
		$tgl = date('Y-m-d');
		$name = 'info.txt';
		$text = 'Nomor Dokumen           : '.$DOC_NOMOR.
				"\n\n".
				'Nama Dokumen            : '.$DOC_NAMA.
				"\n\n".
				'Di Unduh pada tanggal   : '.date('d/m/Y', strtotime($tgl)).
				"\n\n".
				'Oleh                    : '.$SESSION_ID.
				"\n\n\n".
				'==========================================='.
				"\n".
				'           © Copyright Bakmi GM'.
				"\n".
				'===========================================';
		$this->zip->add_data($name, $text);

		$this->zip->read_file($getUtama);
		$this->zip->read_file($get_1);
		$this->zip->read_file($get_2);
		$this->zip->read_file($get_persetujuan);
		$this->zip->download('['.$ID.'] - '.$DOC_NAMA.'.zip');
	}

	public function logout()
	{
		$this->session->sess_destroy();
		redirect(base_url('C_index'));
	}
}
