<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_recent_history extends CI_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Model_detail');
		if ($this->session->userdata('session_bgm_edocument_status') != "LOGIN") {
			redirect(base_url("C_index"));
		}
	}
	public function index()
	{
		$SESSION_DEPARTEMENT_ID = $this->session->userdata("session_bgm_edocument_departement_id");
		$SESSION_JOB_LEVEL_ID = $this->session->userdata("session_bgm_edocument_job_level_id");
		$data['detail'] = $this->Model_detail->GET_DETAIL_SERCH($SESSION_DEPARTEMENT_ID,$SESSION_JOB_LEVEL_ID);
		$this->load->view('V_menu', $data);
	}

}
