<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_news extends CI_Controller {

	public function __construct(){
        parent::__construct();
		if($this->session->userdata('session_bgm_edocument_status') != "LOGIN"){
			redirect(base_url("C_index"));
		}
    }

	public function index()
	{
		redirect(base_url('C_notification'),'refresh');
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
		$this->load->view('V_news_view');
	}

	public function comment()
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
		$this->load->view('V_news_comment');
	}
	
}