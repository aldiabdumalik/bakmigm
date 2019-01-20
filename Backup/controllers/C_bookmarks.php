<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_bookmarks extends CI_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->model('Model_detail');
		if($this->session->userdata('session_bgm_edocument_status') != "LOGIN"){
			redirect(base_url("C_index"));
		}
    }
	public function index(){
		$SESSION_ID = $this->session->userdata("session_bgm_edocument_id");
		$data['bookmark'] = $this->Model_detail->getBookmark($SESSION_ID);
		$this->load->view('V_bookmarks',$data);
	}
	public function bookmark()
	{
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_menu').'";
				</script>
			';
			exit();
		}
		date_default_timezone_set('Asia/Jakarta');
		$si_key 		= $this->input->post('si_key');
		$ur_id 			= $this->input->post('ur_id');
		$cek = $this->Model_detail->cek_book($si_key,$ur_id);
		if ($cek) {
			$this->session->set_flashdata('pesan_gagal','Gagal!');
			redirect(base_url('C_menu/detail/'.$si_key),'refresh');
		}
		$data = array(
				'DOCB_ID' => $this->M_library_module->GENERATOR_REFF(),
				'DOC_ID' => $si_key,
				'UR_ID' => $ur_id
		);
		$is_ok = $this->M_library_database->DB_INSERT_DATA_BOOKMARK($data);
		if($is_ok){
			$this->session->set_flashdata('pesan','Berhasil!');
			redirect(base_url('C_menu/detail/'.$si_key),'refresh');
		}else{
			$this->session->set_flashdata('pesan_gagal','Gagal!');
			redirect(base_url('C_menu/detail/'.$si_key),'refresh');
		}

	}

	public function cari_bookmark()
	{
		$keyword = $this->input->post('keyword');
		$data['bookmark'] = $this->Model_detail->caribookmark($keyword);
		$this->load->view('V_bookmarks', $data);
	}

	function cari_advance_bookmark()
	{
		$si_doc_type = $this->input->post('si_doc_type');
		$ssa_dept_owner = $this->input->post('ssa_dept_owner');
		$ssa_group_proces = $this->input->post('ssa_group_proces');
		$ssa_proces = $this->input->post('ssa_proces');
		$data['bookmark'] = $this->Model_detail->pencarianbookmark($si_doc_type,$ssa_dept_owner,$ssa_group_proces,$ssa_proces);
		$this->load->view('V_bookmarks', $data);
	}
	public function archived_by()
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
			$DOC_STATUS             = $data_row->DOC_STATUS;
		}
		$si_archived 				= $this->input->post('si_archived');
		$note						= $this->input->post('note');
		$data_update = array(
			'DOC_ID' => $DOC_ID,
			'DOC_STATUS' => "ARCHIVED BY ".$si_archived,
			'DOC_NOTE' => $note
		);
		$is_ok = $this->M_library_database->DB_UPDATE_DATA_DOCUMENT($DOC_ID,$data_update);
		if($is_ok){
			echo '
				<script>
					alert("Pemutakhiran Data Berhasil");
					window.location.href = "'.base_url('C_menu').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("Pemutakhiran Data Gagal, Mohon Cek Kembali");
					window.location.href = "'.base_url('C_menu').'";
				</script>
			';
			exit();
		}
	}
}
