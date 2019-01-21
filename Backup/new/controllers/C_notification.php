<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_notification extends CI_Controller {
	public function __construct()
	{
        parent::__construct();
		if($this->session->userdata('session_bgm_edocument_status') != "LOGIN"){
			redirect(base_url(""));
		}
    }

	public function index()
	{
		$this->load->view('V_notification');
	}

	public function approve()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		date_default_timezone_set('Asia/Jakarta');
		$si_key 		= $this->input->post('si_key');
		$si_key 		= $si_key[0];
		
		$si_approver 	= $this->input->post('si_approver');
		
		$si_userid		= $this->session->userdata("session_bgm_edocument_id");
		$date_now		= date('Y-m-d H:i:s');
		//-----------------------------------------------------------------------------------------------//
		$get_data = $this->M_library_database->DB_GET_SEARCH_DATA_DOCUMENT_BY_ID_EVO($si_key);
		if(empty($get_data)||$get_data==""){
			echo '
				<script>
					alert("DATA NOT FOUND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		foreach($get_data as $data_row){
			$DOC_ID					= $data_row->DOC_ID;
			$DOC_DATE               = $data_row->DOC_DATE;
			$DOC_KATEGORI           = $data_row->DOC_KATEGORI;
			$DOC_JENIS              = $data_row->DOC_JENIS;
			$DOC_TIPE               = $data_row->DOC_TIPE;
			$DOC_GROUP_PROSES       = $data_row->DOC_GROUP_PROSES;
			$DOC_PROSES             = $data_row->DOC_PROSES;
			$DOC_NOMOR              = $data_row->DOC_NOMOR;
			$DOC_NAMA               = $data_row->DOC_NAMA;
			$DOC_WUJUD              = $data_row->DOC_WUJUD;
			$DOC_DISTRIBUSI         = $data_row->DOC_DISTRIBUSI;
			$DOC_KERAHASIAAN        = $data_row->DOC_KERAHASIAAN;
			$DOC_AKSES_LEVEL        = $data_row->DOC_AKSES_LEVEL;
			$DOC_PENGGUNA           = $data_row->DOC_PENGGUNA;
			$DOC_PEMILIK_PROSES     = $data_row->DOC_PEMILIK_PROSES;
			$DOC_PENYIMPAN          = $data_row->DOC_PENYIMPAN;
			$DOC_PENDISTRIBUSI      = $data_row->DOC_PENDISTRIBUSI;
			$DOC_VERSI              = $data_row->DOC_VERSI;
			$DOC_TGL_EFEKTIF        = $data_row->DOC_TGL_EFEKTIF;
			$DOC_PERIODE_PREVIEW	= $data_row->DOC_PERIODE_PREVIEW;
			$DOC_KATA_KUNCI         = $data_row->DOC_KATA_KUNCI;
			$DOC_ABSTRAK            = $data_row->DOC_ABSTRAK;
			$DOC_TERKAIT            = $data_row->DOC_TERKAIT;
			$DOC_MAKER              = $data_row->DOC_MAKER;
			$DOC_APPROVE            = $data_row->DOC_APPROVE;
			$DOC_STATUS             = $data_row->DOC_STATUS;
			$DOC_STATUS_ACTIVITY	= $data_row->DOC_STATUS_ACTIVITY;
			$DOC_NOTE               = $data_row->DOC_NOTE;
			$DTSEKI_ID				= $data_row->DTSEKI_ID;
			$DTSEKI_KATEGORI        = $data_row->DTSEKI_KATEGORI;
			$DTSEJS_ID				= $data_row->DTSEJS_ID;
			$DTSEJS_JENIS           = $data_row->DTSEJS_JENIS;
			$DTSETE_ID				= $data_row->DTSETE_ID;
			$DTSETE_TIPE            = $data_row->DTSETE_TIPE;
			$DTSETE_SINGKATAN       = $data_row->DTSETE_SINGKATAN;
			$DTFM_ID				= $data_row->DTFM_ID;
			$DTFM_NAME              = $data_row->DTFM_NAME;
			$DNMD_ID				= $data_row->DNMD_ID;
			$DNMD_NAME              = $data_row->DNMD_NAME;
			$CL_ID					= $data_row->CL_ID;
			$CL_NAME                = $data_row->CL_NAME;
			$DOCD_UTAMA				= $data_row->DOCD_UTAMA;
			$DOCD_UTAMA_TYPE		= $data_row->DOCD_UTAMA_TYPE;
			$DOCD_PELENGKAP_1		= $data_row->DOCD_PELENGKAP_1;
			$DOCD_PELENGKAP_1_TYPE	= $data_row->DOCD_PELENGKAP_1_TYPE;
			$DOCD_PELENGKAP_2		= $data_row->DOCD_PELENGKAP_2;
			$DOCD_PELENGKAP_2_TYPE	= $data_row->DOCD_PELENGKAP_2_TYPE;
			$DOCD_PERSETUJUAN		= $data_row->DOCD_PERSETUJUAN;
			$DOCD_PERSETUJUAN_TYPE	= $data_row->DOCD_PERSETUJUAN_TYPE;
		}
		$getAtasan = $this->M_library_database->getAtasan($DOC_MAKER);
		foreach ($getAtasan as $getAtasan) {
			$DI_CODE = $getAtasan->DI_CODE;
			$DI_NAME = $getAtasan->DI_NAME;
		}
		//-----------------------------------------------------------------------------------------------//
		if($si_approver=="PENDISTRIBUSI"){
			$data_update = array(
				'DOC_ID' => $DOC_ID,
				'DOC_APPROVE' => $si_userid,
				'DOC_STATUS' => "MENUNGGU ATASAN PENCIPTA",
				'DOC_STATUS_ACTIVITY' => "Menunggu Persetujuan dari ".$DI_CODE." (".$DI_NAME.")",
				'DOC_NOTE' => "-"
			);
		}else{
			$data_update = array(
				'DOC_ID' => $DOC_ID,
				'DOC_APPROVE' => $si_userid,
				'DOC_STATUS' => "DIPUBLIKASI",
				'DOC_STATUS_ACTIVITY' => "DIPUBLIKASI",
				'DOC_NOTE' => "-"
			);
		}
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT($DOC_ID,$data_update);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT TO LOG ???
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("Pemutakhiran Data Berhasil");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
	}

	public function reject()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$si_key 		= $this->input->post('si_key');
		$si_note		= $this->input->post('si_note');
		
		$si_approver 	= $this->input->post('si_approver');
		
		$si_userid		= $this->session->userdata("session_bgm_edocument_id");
		date_default_timezone_set('Asia/Jakarta');
		$date_now		= date('Y-m-d H:i:s');
		//-----------------------------------------------------------------------------------------------//
		if($si_note==""){
			echo '
				<script>
					alert("Mohon Isi Catatan Tolak Sirkulasi");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$get_data = $this->M_library_database->DB_GET_SEARCH_DATA_DOCUMENT_BY_ID_EVO($si_key);
		if(empty($get_data)||$get_data==""){
			echo '
				<script>
					alert("DATA NOT FOUND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		foreach($get_data as $data_row){
			$DOC_ID					= $data_row->DOC_ID;
			$DOC_DATE               = $data_row->DOC_DATE;
			$DOC_KATEGORI           = $data_row->DOC_KATEGORI;
			$DOC_JENIS              = $data_row->DOC_JENIS;
			$DOC_TIPE               = $data_row->DOC_TIPE;
			$DOC_GROUP_PROSES       = $data_row->DOC_GROUP_PROSES;
			$DOC_PROSES             = $data_row->DOC_PROSES;
			$DOC_NOMOR              = $data_row->DOC_NOMOR;
			$DOC_NAMA               = $data_row->DOC_NAMA;
			$DOC_WUJUD              = $data_row->DOC_WUJUD;
			$DOC_DISTRIBUSI         = $data_row->DOC_DISTRIBUSI;
			$DOC_KERAHASIAAN        = $data_row->DOC_KERAHASIAAN;
			$DOC_AKSES_LEVEL        = $data_row->DOC_AKSES_LEVEL;
			$DOC_PENGGUNA           = $data_row->DOC_PENGGUNA;
			$DOC_PEMILIK_PROSES     = $data_row->DOC_PEMILIK_PROSES;
			$DOC_PENYIMPAN          = $data_row->DOC_PENYIMPAN;
			$DOC_PENDISTRIBUSI      = $data_row->DOC_PENDISTRIBUSI;
			$DOC_VERSI              = $data_row->DOC_VERSI;
			$DOC_TGL_EFEKTIF        = $data_row->DOC_TGL_EFEKTIF;
			$DOC_PERIODE_PREVIEW	= $data_row->DOC_PERIODE_PREVIEW;
			$DOC_KATA_KUNCI         = $data_row->DOC_KATA_KUNCI;
			$DOC_ABSTRAK            = $data_row->DOC_ABSTRAK;
			$DOC_TERKAIT            = $data_row->DOC_TERKAIT;
			$DOC_MAKER              = $data_row->DOC_MAKER;
			$DOC_APPROVE            = $data_row->DOC_APPROVE;
			$DOC_STATUS             = $data_row->DOC_STATUS;
			$DOC_STATUS_ACTIVITY    = $data_row->DOC_STATUS_ACTIVITY;
			$DOC_NOTE               = $data_row->DOC_NOTE;
			$DTSEKI_ID				= $data_row->DTSEKI_ID;
			$DTSEKI_KATEGORI        = $data_row->DTSEKI_KATEGORI;
			$DTSEJS_ID				= $data_row->DTSEJS_ID;
			$DTSEJS_JENIS           = $data_row->DTSEJS_JENIS;
			$DTSETE_ID				= $data_row->DTSETE_ID;
			$DTSETE_TIPE            = $data_row->DTSETE_TIPE;
			$DTSETE_SINGKATAN       = $data_row->DTSETE_SINGKATAN;
			$DTFM_ID				= $data_row->DTFM_ID;
			$DTFM_NAME              = $data_row->DTFM_NAME;
			$DNMD_ID				= $data_row->DNMD_ID;
			$DNMD_NAME              = $data_row->DNMD_NAME;
			$CL_ID					= $data_row->CL_ID;
			$CL_NAME                = $data_row->CL_NAME;
			$DOCD_UTAMA				= $data_row->DOCD_UTAMA;
			$DOCD_UTAMA_TYPE		= $data_row->DOCD_UTAMA_TYPE;
			$DOCD_PELENGKAP_1		= $data_row->DOCD_PELENGKAP_1;
			$DOCD_PELENGKAP_1_TYPE	= $data_row->DOCD_PELENGKAP_1_TYPE;
			$DOCD_PELENGKAP_2		= $data_row->DOCD_PELENGKAP_2;
			$DOCD_PELENGKAP_2_TYPE	= $data_row->DOCD_PELENGKAP_2_TYPE;
			$DOCD_PERSETUJUAN		= $data_row->DOCD_PERSETUJUAN;
			$DOCD_PERSETUJUAN_TYPE	= $data_row->DOCD_PERSETUJUAN_TYPE;
		}
		//-----------------------------------------------------------------------------------------------//
		$data_update = array(
			'DOC_ID' => $DOC_ID,
			'DOC_APPROVE' => $si_userid,
			'DOC_STATUS' => "DITOLAK ".$si_approver,
			'DOC_STATUS_ACTIVITY' => "DITOLAK ".$si_approver,
			'DOC_NOTE' => "-"
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT($DOC_ID,$data_update);
		//-----------------------------------------------------------------------------------------------//
		$data_insert_status = array(
			'DTDLSS_ID' => $this->M_library_module->GENERATOR_REFF(),
			'DOC_ID' => $DOC_ID,
			'DTDLSS_DATE' => $date_now,
			'DTDLSS_MAKER' => $si_userid,
			'DTDLSS_STATUS' => "DITOLAK ".$si_approver,
			'DTDLSS_NOTE' => $si_note
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_INSERT_DATA_DOCUMENT_DETAIL_STATUS_EVO($data_insert_status);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT TO LOG ???
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("Pemutakhiran Data Berhasil");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
	}

	public function obsolete()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		$si_key 		= $this->input->post('si_key');
		$get_data = $this->M_library_database->DB_GET_SEARCH_DATA_DOCUMENT_BY_ID_EVO($si_key);
		if(empty($get_data)||$get_data==""){
			echo '
				<script>
					alert("DATA NOT FOUND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		foreach($get_data as $data_row){
			$DOC_ID					= $data_row->DOC_ID;
			$DOC_DATE               = $data_row->DOC_DATE;
			$DOC_KATEGORI           = $data_row->DOC_KATEGORI;
			$DOC_JENIS              = $data_row->DOC_JENIS;
			$DOC_TIPE               = $data_row->DOC_TIPE;
			$DOC_GROUP_PROSES       = $data_row->DOC_GROUP_PROSES;
			$DOC_PROSES             = $data_row->DOC_PROSES;
			$DOC_NOMOR              = $data_row->DOC_NOMOR;
			$DOC_NAMA               = $data_row->DOC_NAMA;
			$DOC_WUJUD              = $data_row->DOC_WUJUD;
			$DOC_DISTRIBUSI         = $data_row->DOC_DISTRIBUSI;
			$DOC_KERAHASIAAN        = $data_row->DOC_KERAHASIAAN;
			$DOC_AKSES_LEVEL        = $data_row->DOC_AKSES_LEVEL;
			$DOC_PENGGUNA           = $data_row->DOC_PENGGUNA;
			$DOC_PEMILIK_PROSES     = $data_row->DOC_PEMILIK_PROSES;
			$DOC_PENYIMPAN          = $data_row->DOC_PENYIMPAN;
			$DOC_PENDISTRIBUSI      = $data_row->DOC_PENDISTRIBUSI;
			$DOC_VERSI              = $data_row->DOC_VERSI;
			$DOC_TGL_EFEKTIF        = $data_row->DOC_TGL_EFEKTIF;
			$DOC_PERIODE_PREVIEW	= $data_row->DOC_PERIODE_PREVIEW;
			$DOC_KATA_KUNCI         = $data_row->DOC_KATA_KUNCI;
			$DOC_ABSTRAK            = $data_row->DOC_ABSTRAK;
			$DOC_TERKAIT            = $data_row->DOC_TERKAIT;
			$DOC_MAKER              = $data_row->DOC_MAKER;
			$DOC_APPROVE            = $data_row->DOC_APPROVE;
			$DOC_STATUS             = $data_row->DOC_STATUS;
			$DOC_NOTE               = $data_row->DOC_NOTE;
			$DTSEKI_ID				= $data_row->DTSEKI_ID;
			$DTSEKI_KATEGORI        = $data_row->DTSEKI_KATEGORI;
			$DTSEJS_ID				= $data_row->DTSEJS_ID;
			$DTSEJS_JENIS           = $data_row->DTSEJS_JENIS;
			$DTSETE_ID				= $data_row->DTSETE_ID;
			$DTSETE_TIPE            = $data_row->DTSETE_TIPE;
			$DTSETE_SINGKATAN       = $data_row->DTSETE_SINGKATAN;
			$DTFM_ID				= $data_row->DTFM_ID;
			$DTFM_NAME              = $data_row->DTFM_NAME;
			$DNMD_ID				= $data_row->DNMD_ID;
			$DNMD_NAME              = $data_row->DNMD_NAME;
			$CL_ID					= $data_row->CL_ID;
			$CL_NAME                = $data_row->CL_NAME;
			$DOCD_UTAMA				= $data_row->DOCD_UTAMA;
			$DOCD_UTAMA_TYPE		= $data_row->DOCD_UTAMA_TYPE;
			$DOCD_PELENGKAP_1		= $data_row->DOCD_PELENGKAP_1;
			$DOCD_PELENGKAP_1_TYPE	= $data_row->DOCD_PELENGKAP_1_TYPE;
			$DOCD_PELENGKAP_2		= $data_row->DOCD_PELENGKAP_2;
			$DOCD_PELENGKAP_2_TYPE	= $data_row->DOCD_PELENGKAP_2_TYPE;
			$DOCD_PERSETUJUAN		= $data_row->DOCD_PERSETUJUAN;
			$DOCD_PERSETUJUAN_TYPE	= $data_row->DOCD_PERSETUJUAN_TYPE;
		}
		date_default_timezone_set('Asia/Jakarta');
		$date_now = date('Y-m-d');
		$data_update = array(
			'DOC_ID' => $DOC_ID,
			'DOC_TGL_EXPIRED' => $date_now,
			'DOC_STATUS' => "KADALUARSA",
			'DOC_STATUS_ACTIVITY' => "KADALUARSA"
		);
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT($DOC_ID,$data_update);
		if($is_ok){
			redirect(base_url('C_notification'),'refresh');
		}else{
			echo '
				<script>
					alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
	}

	public function archived()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		$si_key 		= $this->input->post('si_key');
		$get_data = $this->M_library_database->DB_GET_SEARCH_DATA_DOCUMENT_BY_ID_EVO($si_key);
		if(empty($get_data)||$get_data==""){
			echo '
				<script>
					alert("DATA NOT FOUND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		foreach($get_data as $data_row){
			$DOC_ID					= $data_row->DOC_ID;
			$DOC_DATE               = $data_row->DOC_DATE;
			$DOC_KATEGORI           = $data_row->DOC_KATEGORI;
			$DOC_JENIS              = $data_row->DOC_JENIS;
			$DOC_TIPE               = $data_row->DOC_TIPE;
			$DOC_GROUP_PROSES       = $data_row->DOC_GROUP_PROSES;
			$DOC_PROSES             = $data_row->DOC_PROSES;
			$DOC_NOMOR              = $data_row->DOC_NOMOR;
			$DOC_NAMA               = $data_row->DOC_NAMA;
			$DOC_WUJUD              = $data_row->DOC_WUJUD;
			$DOC_DISTRIBUSI         = $data_row->DOC_DISTRIBUSI;
			$DOC_KERAHASIAAN        = $data_row->DOC_KERAHASIAAN;
			$DOC_AKSES_LEVEL        = $data_row->DOC_AKSES_LEVEL;
			$DOC_PENGGUNA           = $data_row->DOC_PENGGUNA;
			$DOC_PEMILIK_PROSES     = $data_row->DOC_PEMILIK_PROSES;
			$DOC_PENYIMPAN          = $data_row->DOC_PENYIMPAN;
			$DOC_PENDISTRIBUSI      = $data_row->DOC_PENDISTRIBUSI;
			$DOC_VERSI              = $data_row->DOC_VERSI;
			$DOC_TGL_EFEKTIF        = $data_row->DOC_TGL_EFEKTIF;
			$DOC_PERIODE_PREVIEW	= $data_row->DOC_PERIODE_PREVIEW;
			$DOC_KATA_KUNCI         = $data_row->DOC_KATA_KUNCI;
			$DOC_ABSTRAK            = $data_row->DOC_ABSTRAK;
			$DOC_TERKAIT            = $data_row->DOC_TERKAIT;
			$DOC_MAKER              = $data_row->DOC_MAKER;
			$DOC_APPROVE            = $data_row->DOC_APPROVE;
			$DOC_STATUS             = $data_row->DOC_STATUS;
			$DOC_NOTE               = $data_row->DOC_NOTE;
			$DTSEKI_ID				= $data_row->DTSEKI_ID;
			$DTSEKI_KATEGORI        = $data_row->DTSEKI_KATEGORI;
			$DTSEJS_ID				= $data_row->DTSEJS_ID;
			$DTSEJS_JENIS           = $data_row->DTSEJS_JENIS;
			$DTSETE_ID				= $data_row->DTSETE_ID;
			$DTSETE_TIPE            = $data_row->DTSETE_TIPE;
			$DTSETE_SINGKATAN       = $data_row->DTSETE_SINGKATAN;
			$DTFM_ID				= $data_row->DTFM_ID;
			$DTFM_NAME              = $data_row->DTFM_NAME;
			$DNMD_ID				= $data_row->DNMD_ID;
			$DNMD_NAME              = $data_row->DNMD_NAME;
			$CL_ID					= $data_row->CL_ID;
			$CL_NAME                = $data_row->CL_NAME;
			$DOCD_UTAMA				= $data_row->DOCD_UTAMA;
			$DOCD_UTAMA_TYPE		= $data_row->DOCD_UTAMA_TYPE;
			$DOCD_PELENGKAP_1		= $data_row->DOCD_PELENGKAP_1;
			$DOCD_PELENGKAP_1_TYPE	= $data_row->DOCD_PELENGKAP_1_TYPE;
			$DOCD_PELENGKAP_2		= $data_row->DOCD_PELENGKAP_2;
			$DOCD_PELENGKAP_2_TYPE	= $data_row->DOCD_PELENGKAP_2_TYPE;
			$DOCD_PERSETUJUAN		= $data_row->DOCD_PERSETUJUAN;
			$DOCD_PERSETUJUAN_TYPE	= $data_row->DOCD_PERSETUJUAN_TYPE;
		}
		$data_update = array(
			'DOC_ID' => $DOC_ID,
			'DOC_STATUS' => "DIARSIPKAN",
			'DOC_STATUS_ACTIVITY' => "Diarsipkan Oleh System"
		);
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT($DOC_ID,$data_update);
		if($is_ok){
			redirect(base_url('C_notification'),'refresh');
		}else{
			redirect(base_url('C_notification'),'refresh');
		}
	}

	public function sign(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		date_default_timezone_set('Asia/Jakarta');
		$si_key 	= $this->input->post('si_key');
		
		$si_userid	= $this->session->userdata("session_bgm_edocument_id");
		$date_now	= date('Y-m-d H:i:s');
		//-----------------------------------------------------------------------------------------------//
		$get_data = $this->M_library_database->DB_GET_SEARCH_DATA_DOCUMENT_BY_ID_EVO($si_key);
		if(empty($get_data)||$get_data==""){
			echo '
				<script>
					alert("DATA NOT FOUND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		foreach($get_data as $data_row){
			$DOC_ID					= $data_row->DOC_ID;
			$DOC_DATE               = $data_row->DOC_DATE;
			$DOC_KATEGORI           = $data_row->DOC_KATEGORI;
			$DOC_JENIS              = $data_row->DOC_JENIS;
			$DOC_TIPE               = $data_row->DOC_TIPE;
			$DOC_GROUP_PROSES       = $data_row->DOC_GROUP_PROSES;
			$DOC_PROSES             = $data_row->DOC_PROSES;
			$DOC_NOMOR              = $data_row->DOC_NOMOR;
			$DOC_NAMA               = $data_row->DOC_NAMA;
			$DOC_WUJUD              = $data_row->DOC_WUJUD;
			$DOC_DISTRIBUSI         = $data_row->DOC_DISTRIBUSI;
			$DOC_KERAHASIAAN        = $data_row->DOC_KERAHASIAAN;
			$DOC_AKSES_LEVEL        = $data_row->DOC_AKSES_LEVEL;
			$DOC_PENGGUNA           = $data_row->DOC_PENGGUNA;
			$DOC_PEMILIK_PROSES     = $data_row->DOC_PEMILIK_PROSES;
			$DOC_PENYIMPAN          = $data_row->DOC_PENYIMPAN;
			$DOC_PENDISTRIBUSI      = $data_row->DOC_PENDISTRIBUSI;
			$DOC_VERSI              = $data_row->DOC_VERSI;
			$DOC_TGL_EFEKTIF        = $data_row->DOC_TGL_EFEKTIF;
			$DOC_PERIODE_PREVIEW	= $data_row->DOC_PERIODE_PREVIEW;
			$DOC_KATA_KUNCI         = $data_row->DOC_KATA_KUNCI;
			$DOC_ABSTRAK            = $data_row->DOC_ABSTRAK;
			$DOC_TERKAIT            = $data_row->DOC_TERKAIT;
			$DOC_MAKER              = $data_row->DOC_MAKER;
			$DOC_APPROVE            = $data_row->DOC_APPROVE;
			$DOC_STATUS             = $data_row->DOC_STATUS;
			$DOC_NOTE               = $data_row->DOC_NOTE;
			$DTSEKI_ID				= $data_row->DTSEKI_ID;
			$DTSEKI_KATEGORI        = $data_row->DTSEKI_KATEGORI;
			$DTSEJS_ID				= $data_row->DTSEJS_ID;
			$DTSEJS_JENIS           = $data_row->DTSEJS_JENIS;
			$DTSETE_ID				= $data_row->DTSETE_ID;
			$DTSETE_TIPE            = $data_row->DTSETE_TIPE;
			$DTSETE_SINGKATAN       = $data_row->DTSETE_SINGKATAN;
			$DTFM_ID				= $data_row->DTFM_ID;
			$DTFM_NAME              = $data_row->DTFM_NAME;
			$DNMD_ID				= $data_row->DNMD_ID;
			$DNMD_NAME              = $data_row->DNMD_NAME;
			$CL_ID					= $data_row->CL_ID;
			$CL_NAME                = $data_row->CL_NAME;
			$DOCD_UTAMA				= $data_row->DOCD_UTAMA;
			$DOCD_UTAMA_TYPE		= $data_row->DOCD_UTAMA_TYPE;
			$DOCD_PELENGKAP_1		= $data_row->DOCD_PELENGKAP_1;
			$DOCD_PELENGKAP_1_TYPE	= $data_row->DOCD_PELENGKAP_1_TYPE;
			$DOCD_PELENGKAP_2		= $data_row->DOCD_PELENGKAP_2;
			$DOCD_PELENGKAP_2_TYPE	= $data_row->DOCD_PELENGKAP_2_TYPE;
			$DOCD_PERSETUJUAN		= $data_row->DOCD_PERSETUJUAN;
			$DOCD_PERSETUJUAN_TYPE	= $data_row->DOCD_PERSETUJUAN_TYPE;
		}
		//-----------------------------------------------------------------------------------------------//
		$data_update = array(
			'DOC_ID' => $DOC_ID,
			'DOC_APPROVE' => $si_userid,
			'DOC_STATUS' => "PUBLISH",
			'DOC_NOTE' => "-"
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT($DOC_ID,$data_update);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT TO LOG ???
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("Pemutakhiran Data Berhasil");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
	}

	public function update()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		date_default_timezone_set('Asia/Jakarta');
		$si_key 	= $this->input->post('si_key');
		
		$si_userid	= $this->session->userdata("session_bgm_edocument_id");
		$date_now	= date('Y-m-d H:i:s');
		//-----------------------------------------------------------------------------------------------//
		$get_data = $this->M_library_database->DB_GET_SEARCH_DATA_DOCUMENT_BY_ID_EVO($si_key);
		if(empty($get_data)||$get_data==""){
			echo '
				<script>
					alert("DATA NOT FOUND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		foreach($get_data as $data_row){
			$DOC_ID					= $data_row->DOC_ID;
			$DOC_DATE               = $data_row->DOC_DATE;
			$DOC_KATEGORI           = $data_row->DOC_KATEGORI;
			$DOC_JENIS              = $data_row->DOC_JENIS;
			$DOC_TIPE               = $data_row->DOC_TIPE;
			$DOC_GROUP_PROSES       = $data_row->DOC_GROUP_PROSES;
			$DOC_PROSES             = $data_row->DOC_PROSES;
			$DOC_NOMOR              = $data_row->DOC_NOMOR;
			$DOC_NAMA               = $data_row->DOC_NAMA;
			$DOC_WUJUD              = $data_row->DOC_WUJUD;
			$DOC_DISTRIBUSI         = $data_row->DOC_DISTRIBUSI;
			$DOC_KERAHASIAAN        = $data_row->DOC_KERAHASIAAN;
			$DOC_AKSES_LEVEL        = $data_row->DOC_AKSES_LEVEL;
			$DOC_PENGGUNA           = $data_row->DOC_PENGGUNA;
			$DOC_PEMILIK_PROSES     = $data_row->DOC_PEMILIK_PROSES;
			$DOC_PENYIMPAN          = $data_row->DOC_PENYIMPAN;
			$DOC_PENDISTRIBUSI      = $data_row->DOC_PENDISTRIBUSI;
			$DOC_VERSI              = $data_row->DOC_VERSI;
			$DOC_TGL_EFEKTIF        = $data_row->DOC_TGL_EFEKTIF;
			$DOC_PERIODE_PREVIEW	= $data_row->DOC_PERIODE_PREVIEW;
			$DOC_KATA_KUNCI         = $data_row->DOC_KATA_KUNCI;
			$DOC_ABSTRAK            = $data_row->DOC_ABSTRAK;
			$DOC_TERKAIT            = $data_row->DOC_TERKAIT;
			$DOC_MAKER              = $data_row->DOC_MAKER;
			$DOC_APPROVE            = $data_row->DOC_APPROVE;
			$DOC_STATUS             = $data_row->DOC_STATUS;
			$DOC_NOTE               = $data_row->DOC_NOTE;
			$DTSEKI_ID				= $data_row->DTSEKI_ID;
			$DTSEKI_KATEGORI        = $data_row->DTSEKI_KATEGORI;
			$DTSEJS_ID				= $data_row->DTSEJS_ID;
			$DTSEJS_JENIS           = $data_row->DTSEJS_JENIS;
			$DTSETE_ID				= $data_row->DTSETE_ID;
			$DTSETE_TIPE            = $data_row->DTSETE_TIPE;
			$DTSETE_SINGKATAN       = $data_row->DTSETE_SINGKATAN;
			$DTFM_ID				= $data_row->DTFM_ID;
			$DTFM_NAME              = $data_row->DTFM_NAME;
			$DNMD_ID				= $data_row->DNMD_ID;
			$DNMD_NAME              = $data_row->DNMD_NAME;
			$CL_ID					= $data_row->CL_ID;
			$CL_NAME                = $data_row->CL_NAME;
			$DOCD_UTAMA				= $data_row->DOCD_UTAMA;
			$DOCD_UTAMA_TYPE		= $data_row->DOCD_UTAMA_TYPE;
			$DOCD_PELENGKAP_1		= $data_row->DOCD_PELENGKAP_1;
			$DOCD_PELENGKAP_1_TYPE	= $data_row->DOCD_PELENGKAP_1_TYPE;
			$DOCD_PELENGKAP_2		= $data_row->DOCD_PELENGKAP_2;
			$DOCD_PELENGKAP_2_TYPE	= $data_row->DOCD_PELENGKAP_2_TYPE;
			$DOCD_PERSETUJUAN		= $data_row->DOCD_PERSETUJUAN;
			$DOCD_PERSETUJUAN_TYPE	= $data_row->DOCD_PERSETUJUAN_TYPE;
		}
		//-----------------------------------------------------------------------------------------------//
		$data_update = array(
			'DOC_ID' => $DOC_ID,
			'DOC_APPROVE' => "-",
			'DOC_STATUS' => "WAITING",
			'DOC_NOTE' => "-"
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT($DOC_ID,$data_update);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT TO LOG ???
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("Pemutakhiran Data Berhasil");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
	}

	public function view()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$this->load->view('V_news_view');
	}
	//-----------------------------------------------------------------------------------------------//
	public function detail()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$this->load->view('V_notification_detail');
	}
	//-----------------------------------------------------------------------------------------------//
	public function revisi()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$this->load->view('V_notification_revisi');
	}
	// Versioning
	public function versioning()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		$this->load->view('V_versioning');
	}
	public function versioning_meta()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$this->load->view('V_versioning_meta');
	}
	public function versioning_isi()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		$this->load->view('V_versioning_isi');
	}

	public function versioning_isi_proses()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		date_default_timezone_set('Asia/Jakarta');
		$SESSION_DEPARTEMENT_ID = $this->session->userdata("session_bgm_edocument_departement_id");
		$SESSION_DIVISI_ID = $this->session->userdata("session_bgm_edocument_divisi_id");
		include(APPPATH.'libraries/pdf2txt/PdfToText.phpclass');
		include (APPPATH.'libraries/FPDF/Fpdf.php');
		include (APPPATH.'libraries/FPDI/fpdi.php');
		//STEP 1
		$catatan_versi 							= $this->input->post('catatan_versi');
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
			$duallistbox_dokumen_terkait_array 	= "";
			for($x = 0; $x < $duallistbox_dokumen_terkait_length; $x++) {
				$duallistbox_dokumen_terkait_array .= $duallistbox_dokumen_terkait[$x]."|";
			}
			$duallistbox_dokumen_terkait_list 	= substr($duallistbox_dokumen_terkait_array,0,-1);
		}else{
			$duallistbox_dokumen_terkait_listerkait = "";
		}
		//SYSTEM
		$si_code								= $this->input->post('si_code');
		$si_userid								= $this->input->post('si_userid');
		$date_now								= date('Y-m-d H:i:s');
		$si_approve 							= $this->input->post('si_approve');
		//Check on
		$dokumen_utama_on 						= $this->input->post('dokumen_utama_on');
		$dokumen_pelengkap_1_on 				= $this->input->post('dokumen_pelengkap_1_on');
		$dokumen_pelengkap_2_on 				= $this->input->post('dokumen_pelengkap_2_on');
		// Ambil Pendistribusi
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
		//Upload Doc
		$config1['upload_path'] 				= './assets/original';
		$config1['upload_url'] 					= './assets/original';
		$config1['remove_spaces'] 				= TRUE;
		$config1['allowed_types'] 				= '*';
		$this->load->library('upload', $config1);
		//Dokumen Utama
		$dokumen_utama = $_FILES['dokumen_utama'];
		if ($_FILES['dokumen_utama']['size'] != 0) {
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
			}else{
				$errors = $this->upload->display_errors();
				die($errors);
			}
			$data_update_detail = array(
				'DOCD_UTAMA' => $dokumen_utama_name,
				'DOCD_UTAMA_TYPE' => $dokumen_utama_ext,
				'DOCD_UTAMA_STATUS' => $convert_dokumen_utama,
				'DOCD_UTAMA_EXT' => $dokumen_utama_extention,
				'DOCD_SEARCH' => $dokumen_search_acr
			);
			$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT_DETAIL_REFISI_EVO($si_code,$data_update_detail);
			if(!$is_ok){
				echo '
					<script>
						alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
						window.location.href = "'.base_url('C_notification').'";
					</script>
				';
				exit();
			}
		}
		//Dokumen Pelengkap 1
		$dokumen_pelengkap_1 = $_FILES['dokumen_pelengkap_1'];
		if ($_FILES['dokumen_pelengkap_1']['size'] != 0) {
			$dokumen_pelengkap_1_ext = $_FILES['dokumen_pelengkap_1']['type'];
			$dokumen_pelengkap_1_size = ($_FILES['dokumen_pelengkap_1']['size'])/(1000*1000);
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
			$data_update_detail = array(
				'DOCD_PELENGKAP_1' => $dokumen_pelengkap_1_name,
				'DOCD_PELENGKAP_1_TYPE' => $dokumen_pelengkap_1_ext,
				'DOCD_PELENGKAP_1_STATUS' => $convert_dokumen_pelengkap_1,
				'DOCD_PELENGKAP_1_EXT' => $dokumen_pelengkap_1_extention
			);
			$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT_DETAIL_REFISI_EVO($si_code,$data_update_detail);
			if(!$is_ok){
				echo '
					<script>
						alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
						window.location.href = "'.base_url('C_notification').'";
					</script>
				';
				exit();
			}
		}
		//Dokumen Pelengkap 2
		$dokumen_pelengkap_2 = $_FILES['dokumen_pelengkap_2'];
		if ($_FILES['dokumen_pelengkap_2']['size'] != 0) {
			$dokumen_pelengkap_2_ext = $_FILES['dokumen_pelengkap_2']['type'];
			$dokumen_pelengkap_2_size = ($_FILES['dokumen_pelengkap_2']['size'])/(1000*1000);//IN MEGABYTE(MB)
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
			$data_update_detail = array(
				'DOCD_PELENGKAP_2' => $dokumen_pelengkap_2_name,
				'DOCD_PELENGKAP_2_TYPE' => $dokumen_pelengkap_2_ext,
				'DOCD_PELENGKAP_2_STATUS' => $convert_dokumen_pelengkap_2,
				'DOCD_PELENGKAP_2_EXT' => $dokumen_pelengkap_2_extention
			);
			$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT_DETAIL_REFISI_EVO($si_code,$data_update_detail);
			if(!$is_ok){
				echo '
					<script>
						alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
						window.location.href = "'.base_url('C_notification').'";
					</script>
				';
				exit();
			}
		}
		//Dokumen Persetujuan
		$dokumen_persetujuan = $_FILES['dokumen_persetujuan'];
		if ($_FILES['dokumen_persetujuan']['size'] != 0) {
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
			if ($this->upload->do_upload('dokumen_persetujuan')){}
			$data_update_detail = array(
				'DOCD_PERSETUJUAN' => $dokumen_persetujuan_name,
				'DOCD_PERSETUJUAN_TYPE' => $dokumen_persetujuan_ext
			);
			$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT_DETAIL_REFISI_EVO($si_code,$data_update_detail);
			if(!$is_ok){
				echo '
					<script>
						alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
						window.location.href = "'.base_url('C_notification').'";
					</script>
				';
				exit();
			}
		}
		//Dokumen Meta Data
		$data_update = array(
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
			'DOC_STATUS' => $STATUS_FINAL,
			'DOC_STATUS_ACTIVITY' => "Menunggu Persetujuan dari ".$PENDISTRIBUSI_FINAL_CODE." (".$PENDISTRIBUSI_FINAL_NAME.")",
			'DOC_NOTE' => "-"
		);
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT_REFISI_EVO($si_code,$data_update);
		// Insert Detail
		$data_versi = array(
			'DOCV_ID' => $this->M_library_module->GENERATOR_REFF(),
			'DOC_ID' => $si_code,
			'DOCV_DATE' => $date_now,
			'DOCV_DETAIL' => "PERUBAHAN META DATA DOKUMEN",
			'DOCV_CATATAN' => $catatan_versi,
		);
		$is_ok = $this->M_library_database->DB_INPUT_DATA_VERSIONING($data_versi);
		if($is_ok){
			$this->session->set_flashdata('pesan','Berhasil!');
			redirect(base_url('notification'),'refresh');
		}else{
			$this->session->set_flashdata('pesan_gagal','Gagal!');
			redirect(base_url('notification'),'refresh');
		}
	}
	public function versioning_meta_proses()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		date_default_timezone_set('Asia/Jakarta');
		$date_now								= date('Y-m-d');
		$duallistbox_pengguna_dokumen = $this->input->post('duallistbox_pengguna_dokumen');
		$duallistbox_pengguna_dokumen_length = count($duallistbox_pengguna_dokumen);
		$duallistbox_pengguna_dokumen_array = "";
		for($x = 0; $x < $duallistbox_pengguna_dokumen_length; $x++) {
			$duallistbox_pengguna_dokumen_array .= $duallistbox_pengguna_dokumen[$x]."|";
		}
		$duallistbox_pengguna_dokumen_list = substr($duallistbox_pengguna_dokumen_array,0,-1);
		$si_history_version						= $this->input->post('si_history_version');
		$si_history_date1						= $this->input->post('si_history_date');
		$si_history_date 						= date('Y-m-d', strtotime($si_history_date1));
		$si_history_period						= $this->input->post('si_history_period');
		$si_history_date_final1					= $this->input->post('si_history_date_final');
		$si_history_date_final 					= date('Y-m-d', strtotime($si_history_date_final1));
		$si_history_keyword						= $this->input->post('si_history_keyword');
		$si_history_abstract					= $this->input->post('si_history_abstract');
		$duallistbox_dokumen_terkait = $this->input->post('duallistbox_dokumen_terkait');
		$duallistbox_dokumen_terkait_length = count($duallistbox_dokumen_terkait);
		$duallistbox_dokumen_terkait_array = "";
		for($x = 0; $x < $duallistbox_dokumen_terkait_length; $x++) {
			$duallistbox_dokumen_terkait_array .= $duallistbox_dokumen_terkait[$x]."|";
		}
		$duallistbox_dokumen_terkait_list = substr($duallistbox_dokumen_terkait_array,0,-1);
		$si_code								= $this->input->post('si_code');
		$si_userid								= $this->input->post('si_userid');
		$si_approve 							= $this->input->post('si_approve');
		
		$versi 									= $this->input->post('si_history_version');
		$catatan_versi 							= $this->input->post('catatan_versi');

		$data_update = array(
			'DOC_PENGGUNA' => $duallistbox_pengguna_dokumen_list,
			'DOC_VERSI' => $versi,
			'DOC_TGL_EFEKTIF' => $si_history_date,
			'DOC_PERIODE_PREVIEW' => $si_history_period,
			'DOC_TGL_EXPIRED' => $si_history_date_final,
			'DOC_KATA_KUNCI' => $si_history_keyword,
			'DOC_ABSTRAK' => $si_history_abstract,
			'DOC_TERKAIT' => $duallistbox_dokumen_terkait_list,
			'DOC_MAKER' => $si_userid,
			'DOC_STATUS' => "MENUNGGU ".$si_approve
		);
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT_REFISI_EVO($si_code,$data_update);

		// Insert Detail
		$data_versi = array(
			'DOCV_ID' => $this->M_library_module->GENERATOR_REFF(),
			'DOC_ID' => $si_code,
			'DOCV_DATE' => $date_now,
			'DOCV_DETAIL' => "PERUBAHAN META DATA DOKUMEN",
			'DOCV_CATATAN' => $catatan_versi,
		);
		$is_ok = $this->M_library_database->DB_INPUT_DATA_VERSIONING($data_versi);
		if($is_ok){
			$this->session->set_flashdata('pesan','Berhasil!');
			redirect(base_url('notification'),'refresh');
		}else{
			$this->session->set_flashdata('pesan_gagal','Gagal!');
			redirect(base_url('notification'),'refresh');
		}

	}
	public function revisi_process()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		date_default_timezone_set('Asia/Jakarta');
		$SESSION_DEPARTEMENT_ID = $this->session->userdata("session_bgm_edocument_departement_id");
		$SESSION_DIVISI_ID = $this->session->userdata("session_bgm_edocument_divisi_id");
		include(APPPATH.'libraries/pdf2txt/PdfToText.phpclass');
		include (APPPATH.'libraries/FPDF/Fpdf.php');
		include (APPPATH.'libraries/FPDI/fpdi.php');
		//STEP 1
		$catatan_versi 							= $this->input->post('catatan_versi');
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
			$duallistbox_dokumen_terkait_array 	= "";
			for($x = 0; $x < $duallistbox_dokumen_terkait_length; $x++) {
				$duallistbox_dokumen_terkait_array .= $duallistbox_dokumen_terkait[$x]."|";
			}
			$duallistbox_dokumen_terkait_list 	= substr($duallistbox_dokumen_terkait_array,0,-1);
		}else{
			$duallistbox_dokumen_terkait_listerkait = "";
		}
		//SYSTEM
		$si_code								= $this->input->post('si_code');
		$si_userid								= $this->input->post('si_userid');
		$date_now								= date('Y-m-d H:i:s');
		$si_approve 							= $this->input->post('si_approve');
		//Check on
		$dokumen_utama_on 						= $this->input->post('dokumen_utama_on');
		$dokumen_pelengkap_1_on 				= $this->input->post('dokumen_pelengkap_1_on');
		$dokumen_pelengkap_2_on 				= $this->input->post('dokumen_pelengkap_2_on');
		// Ambil Pendistribusi
		if ($si_approve == "PENDISTRIBUSI") {
			if ($si_owner_dept_pendistribusi==$SESSION_DEPARTEMENT_ID) {
				$getPendistribusi = $this->M_library_database->getDEPARTEMEN($si_owner_dept_pendistribusi);
				foreach ($getPendistribusi as $data) {
					$dpt 		= $data->DN_ID;
					$dpt_code 	= $data->DN_CODE;
					$dpt_name 	= $data->DN_NAME;
				}
				$PENDISTRIBUSI_FINAL_CODE 	= $dpt_code;
				$PENDISTRIBUSI_FINAL_NAME 	= $dpt_name;
				$STATUS_FINAL				= "Menunggu Persetujuan dari ".$PENDISTRIBUSI_FINAL_CODE." (".$PENDISTRIBUSI_FINAL_NAME.")";
			}else{
				$getPendistribusi = $this->M_library_database->getDEPARTEMEN($si_owner_dept_pendistribusi);
				foreach ($getPendistribusi as $data) {
					$dpt 		= $data->DN_ID;
					$dpt_code 	= $data->DN_CODE;
					$dpt_name 	= $data->DN_NAME;
				}
				$PENDISTRIBUSI_FINAL_CODE 	= $dpt_code;
				$PENDISTRIBUSI_FINAL_NAME 	= $dpt_name;
				$STATUS_FINAL				= "Menunggu Persetujuan dari ".$PENDISTRIBUSI_FINAL_CODE." (".$PENDISTRIBUSI_FINAL_NAME.")";
			}
		}else{
			$SESSION_DIVISI_CODE = $this->session->userdata("session_bgm_edocument_divisi_code");
			$SESSION_DIVISI_NAME = $this->session->userdata("session_bgm_edocument_divisi_name");
			$STATUS_FINAL				= "Menunggu Persetujuan dari ".$SESSION_DIVISI_CODE." (".$SESSION_DIVISI_NAME.")";
		}
		//Upload Doc
		$config1['upload_path'] 				= './assets/original';
		$config1['upload_url'] 					= './assets/original';
		$config1['remove_spaces'] 				= TRUE;
		$config1['allowed_types'] 				= '*';
		$this->load->library('upload', $config1);
		//Dokumen Utama
		$dokumen_utama = $_FILES['dokumen_utama'];
		if ($_FILES['dokumen_utama']['size'] != 0) {
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
			}else{
				$errors = $this->upload->display_errors();
				die($errors);
			}
			$data_update_detail = array(
				'DOCD_UTAMA' => $dokumen_utama_name,
				'DOCD_UTAMA_TYPE' => $dokumen_utama_ext,
				'DOCD_UTAMA_STATUS' => $convert_dokumen_utama,
				'DOCD_UTAMA_EXT' => $dokumen_utama_extention,
				'DOCD_SEARCH' => $dokumen_search_acr
			);
			$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT_DETAIL_REFISI_EVO($si_code,$data_update_detail);
			if(!$is_ok){
				echo '
					<script>
						alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
						window.location.href = "'.base_url('C_notification').'";
					</script>
				';
				exit();
			}
		}
		//Dokumen Pelengkap 1
		$dokumen_pelengkap_1 = $_FILES['dokumen_pelengkap_1'];
		if ($_FILES['dokumen_pelengkap_1']['size'] != 0) {
			$dokumen_pelengkap_1_ext = $_FILES['dokumen_pelengkap_1']['type'];
			$dokumen_pelengkap_1_size = ($_FILES['dokumen_pelengkap_1']['size'])/(1000*1000);
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
			$data_update_detail = array(
				'DOCD_PELENGKAP_1' => $dokumen_pelengkap_1_name,
				'DOCD_PELENGKAP_1_TYPE' => $dokumen_pelengkap_1_ext,
				'DOCD_PELENGKAP_1_STATUS' => $convert_dokumen_pelengkap_1,
				'DOCD_PELENGKAP_1_EXT' => $dokumen_pelengkap_1_extention
			);
			$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT_DETAIL_REFISI_EVO($si_code,$data_update_detail);
			if(!$is_ok){
				echo '
					<script>
						alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
						window.location.href = "'.base_url('C_notification').'";
					</script>
				';
				exit();
			}
		}
		//Dokumen Pelengkap 2
		$dokumen_pelengkap_2 = $_FILES['dokumen_pelengkap_2'];
		if ($_FILES['dokumen_pelengkap_2']['size'] != 0) {
			$dokumen_pelengkap_2_ext = $_FILES['dokumen_pelengkap_2']['type'];
			$dokumen_pelengkap_2_size = ($_FILES['dokumen_pelengkap_2']['size'])/(1000*1000);//IN MEGABYTE(MB)
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
			$data_update_detail = array(
				'DOCD_PELENGKAP_2' => $dokumen_pelengkap_2_name,
				'DOCD_PELENGKAP_2_TYPE' => $dokumen_pelengkap_2_ext,
				'DOCD_PELENGKAP_2_STATUS' => $convert_dokumen_pelengkap_2,
				'DOCD_PELENGKAP_2_EXT' => $dokumen_pelengkap_2_extention
			);
			$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT_DETAIL_REFISI_EVO($si_code,$data_update_detail);
			if(!$is_ok){
				echo '
					<script>
						alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
						window.location.href = "'.base_url('C_notification').'";
					</script>
				';
				exit();
			}
		}
		//Dokumen Persetujuan
		$dokumen_persetujuan = $_FILES['dokumen_persetujuan'];
		if ($_FILES['dokumen_persetujuan']['size'] != 0) {
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
			if ($this->upload->do_upload('dokumen_persetujuan')){}
			$data_update_detail = array(
				'DOCD_PERSETUJUAN' => $dokumen_persetujuan_name,
				'DOCD_PERSETUJUAN_TYPE' => $dokumen_persetujuan_ext
			);
			$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT_DETAIL_REFISI_EVO($si_code,$data_update_detail);
			if(!$is_ok){
				echo '
					<script>
						alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
						window.location.href = "'.base_url('C_notification').'";
					</script>
				';
				exit();
			}
		}
		//Dokumen Meta Data
		$data_update = array(
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
			'DOC_STATUS' => "MENUNGGU ".$si_approve,
			'DOC_STATUS_ACTIVITY' => $STATUS_FINAL,
			'DOC_NOTE' => "-"
		);
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT_REFISI_EVO($si_code,$data_update);
		if($is_ok){
			$this->session->set_flashdata('pesan','Berhasil!');
			redirect(base_url('C_notification'),'refresh');
		}else{
			$this->session->set_flashdata('pesan_gagal','Gagal!');
			redirect(base_url('C_notification'),'refresh');
		}
	}
	public function download_pdf($file)
	{
		$this->load->helper('download');
		$name = $file;
		$data = file_get_contents('./assets/pdf/'.$file); 
		force_download($name, $data); 
		redirect('index','refresh');
	}
	public function download_ori($file)
	{
		$this->load->helper('download');
		$name = $file;
		$data = file_get_contents('./assets/original/'.$file); 
		force_download($name, $data); 
		redirect('index','refresh');
	}
	//-----------------------------------------------------------------------------------------------//
	public function get_data_document_structure_kategori_jenis_tipe(){
		$post_data = $this->input->post();
		$id_key = $post_data['id_key'];
		$data = $this->M_library_database->DB_GET_DATA_DOCUMENT_TEMPLATE_AUTO_BUILD_EVO($id_key);
		$result = json_encode($data);
		echo $result;exit();
	}
	//-----------------------------------------------------------------------------------------------//
	public function get_data_document_structure_jenis(){
		$post_data = $this->input->post();
		$id_key = $post_data['id_key'];
		$data = $this->M_library_database->DB_GET_DATA_DOCUMENT_STRUCTURE_JENIS_EVO($id_key);
		$result = json_encode($data);
		echo $result;exit();
	}
	//-----------------------------------------------------------------------------------------------//
	public function get_data_document_structure_tipe(){
		$post_data = $this->input->post();
		$id_key = $post_data['id_key'];
		$data = $this->M_library_database->DB_GET_DATA_DOCUMENT_STRUCTURE_TIPE_EVO($id_key);
		$result = json_encode($data);
		echo $result;exit();
	}
	//-----------------------------------------------------------------------------------------------//
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
	//-----------------------------------------------------------------------------------------------//
	public function get_data_job_level_evo(){
		$data = $this->M_library_database->DB_GET_JOB_LEVEL_EVO();
		$result = json_encode($data);
		echo $result;exit();
	}
	//-----------------------------------------------------------------------------------------------//
	public function get_data_job_level_evo_ext(){
		$post_data = $this->input->post();
		$id_key = $post_data['id_key'];
		$data = $this->M_library_database->DB_GET_JOB_LEVEL_EVO_EXT($id_key);
		$result = json_encode($data);
		echo $result;exit();
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function comment_process(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		date_default_timezone_set('Asia/Jakarta');
		$si_docid	= $this->input->post('si_docid');
		$si_maker	= $this->input->post('si_maker');
		$si_review	= $this->input->post('si_review');
		
		$si_reff	= $this->M_library_module->GENERATOR_REFF();
		$si_userid	= $this->session->userdata("session_bgm_edocument_id");
		$date_now	= date('Y-m-d H:i:s');
		//-----------------------------------------------------------------------------------------------//
		$data_insert = array(
			'DTCT_ID' => $si_reff,
			'DOC_ID' => $si_docid,
			'DTCT_DATE' => $date_now,
			'DTCT_AUTHOR' => $si_maker,
			'DTCT_USER' => $si_userid,
			'DTCT_NOTE' => $si_review
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_INSERT_DATA_DOCUMENT_COMMENT_EVO($data_insert);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT TO LOG ???
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("Penambahan Data Berhasil");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("Penambahan Data Gagal, Mohon Cek Kembali");
					window.location.href = "'.base_url('C_notification').'";
				</script>
			';
			exit();
		}
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//
