<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class C_index extends CI_Controller {
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function __construct(){
        parent::__construct();

		if($this->session->userdata('session_bgm_edocument_status') == "LOGIN"){
			redirect(base_url("menu"));
		}
    }
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function index(){
		$this->load->view('V_index');
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function login_check(){
		if($_SERVER['REQUEST_METHOD']!="POST"){
			echo '
				<script>
					alert("UNKNOWN COMMAND");
					window.location.href = "'.base_url('C_index').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		$si_userid = $this->input->post('si_userid');
		$si_password = $this->input->post('si_password');
		//-----------------------------------------------------------------------------------------------//
		$data_login = $this->M_library_database->DB_GET_DATA_LOGIN($si_userid,$si_password);
		if(empty($data_login)){
			echo '
				<script>
					alert("USERID & PASSWORD NOT FOUND");
					window.location.href = "'.base_url('C_index').'";
				</script>
			';
			exit();
		}
		//-----------------------------------------------------------------------------------------------//
		//$data_login[0] BECAUSE ONLY RETURN 1 ARRAY
		$session_data['session_bgm_edocument_status'] = "LOGIN";
		$session_data['session_bgm_edocument_id'] = $data_login[0]->UR_ID;
		$session_data['session_bgm_edocument_email'] = $data_login[0]->UR_EMAIL;
		
		$session_data['session_bgm_edocument_direktorat_id'] = $data_login[0]->DT_ID;
		$session_data['session_bgm_edocument_direktorat_name'] = $data_login[0]->DT_NAME;
		
		$session_data['session_bgm_edocument_divisi_id'] = $data_login[0]->DI_ID;
		$session_data['session_bgm_edocument_divisi_code'] = $data_login[0]->DI_CODE;
		$session_data['session_bgm_edocument_divisi_name'] = $data_login[0]->DI_NAME;
		
		$session_data['session_bgm_edocument_departement_id'] = $data_login[0]->DN_ID;
		$session_data['session_bgm_edocument_departement_code'] = $data_login[0]->DN_CODE;
		$session_data['session_bgm_edocument_departement_name'] = $data_login[0]->DN_NAME;
		
		$session_data['session_bgm_edocument_roles'] = $data_login[0]->RS_ID;
		$session_data['session_bgm_edocument_job_level_id'] = $data_login[0]->JBLL_ID;
		$session_data['session_bgm_edocument_job_level_name'] = $data_login[0]->JBLL_NAME;
		$session_data['session_bgm_edocument_job_level_index'] = $data_login[0]->JBLL_INDEX;
		//-----------------------------------------------------------------------------------------------//
		//SET VARIABLE SESSION
		$this->session->set_userdata($session_data);
		//-----------------------------------------------------------------------------------------------//
		if ($_SESSION['link']) {
			redirect($_SESSION['link'],'refresh');
		}else{
			redirect(base_url('menu'));
		}
		
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//
