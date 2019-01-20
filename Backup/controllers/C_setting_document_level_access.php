<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_setting_document_level_access extends CI_Controller {
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function __construct(){
        parent::__construct();
		
		if($this->session->userdata('session_bgm_edocument_status') != "LOGIN"){
			redirect(base_url("C_index"));
		}
    }
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function index(){
		$this->load->view('V_setting_document_level_access');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function insert(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_setting_document_level_access').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$si_code = $this->input->post('si_code');
		$si_doc_type = $this->input->post('si_doc_type');
		$si_confidential = $this->input->post('si_confidential');
		$si_view = $this->input->post('si_view');
		$si_download = $this->input->post('si_download');
		
		$duallistbox_departement = $this->input->post('duallistbox_departement');
		$duallistbox_departement_length = count($duallistbox_departement);
		$duallistbox_departement_array = "";
		for($x = 0; $x < $duallistbox_departement_length; $x++) {
			$duallistbox_departement_array .= $duallistbox_departement[$x]."|";
		}
		$duallistbox_departement_list = substr($duallistbox_departement_array,0,-1);
		
		$duallistbox_departement_ext = $this->input->post('duallistbox_departement_ext');
		$duallistbox_departement_ext_length = count($duallistbox_departement_ext);
		$duallistbox_departement_ext_array = "";
		for($x = 0; $x < $duallistbox_departement_ext_length; $x++) {
			$duallistbox_departement_ext_array .= $duallistbox_departement_ext[$x]."|";
		}
		$duallistbox_departement_ext_list = substr($duallistbox_departement_ext_array,0,-1);

		$si_userid = $this->input->post('si_userid');
		
		$date_now = date('Y-m-d H:i:s');
		//-----------------------------------------------------------------------------------------------//
		$data_insert = array(
			'DTLLAS_ID' => $si_code,
			'DTLLAS_TYPE' => $si_doc_type,
			'DTLLAS_SECURITY' => $si_confidential,
			'DTLLAS_DEPT_AL_VIEW' => $si_view,
			'DTLLAS_DEPT_AL_DOWNLOAD' => $si_download,
			'DTLLAS_DEPT_ACCESS_LEVEL' => $duallistbox_departement_list,
			'DTLLAS_DEPT_DIST' => $duallistbox_departement_ext_list,
			'DTLLAS_DATE' => $date_now,
			'UR_ID' => $si_userid
		);
		//-----------------------------------------------------------------------------------------------//
		$is_ok = $this->M_library_database->DB_INSERT_DATA_DOCUMENT_LEVEL_ACCESS($data_insert);
		//-----------------------------------------------------------------------------------------------//
		if($is_ok){
			//INSERT TO LOG ???
			//-----------------------------------------------------------------------------------------------//
			echo '
				<script>
					alert("Penambahan Data Berhasil");
					window.location.href = "'.base_url('C_setting_document_level_access').'";
				</script>
			';
			exit();
		}else{
			echo '
				<script>
					alert("Penambahan Data Gagal, Mohon Cek Kembali");
					window.location.href = "'.base_url('C_setting_document_level_access').'";
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
	public function tool_table(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_setting_document_level_access').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$si_tool_table_key = $this->input->post('si_tool_table_key');
		$si_tool_table_key = $si_tool_table_key[0];
		//-----------------------------------------------------------------------------------------------//
		if(isset($_POST['btn_delete'])){
			$is_ok = $this->M_library_database->DB_DELETE_DATA_DOCUMENT_LEVEL_ACCESS($si_tool_table_key);
			//-----------------------------------------------------------------------------------------------//
			if($is_ok){
				//INSERT TO LOG ???
				//-----------------------------------------------------------------------------------------------//
				echo '
					<script>
						alert("Hapus Data Berhasil");
						window.location.href = "'.base_url('C_setting_document_level_access').'";
					</script>
				';
				exit();
			}else{
				echo '
					<script>
						alert("Hapus Data Gagal, Mohon Cek Kembali");
						window.location.href = "'.base_url('C_setting_document_level_access').'";
					</script>
				';
				exit();
			}
		}else{
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_setting_document_level_access').'";
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
