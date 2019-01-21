<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C_employee extends CI_Controller {
 function __construct() {
   parent::__construct();
   $this->load->model('M_employee');
 }
 function index() {
    $data['employee'] = $this->M_employee->getEmployee();
    $this->load->view('V_employee', $data);
 }
 public function level($level)
 {
 	$data['employee'] = $this->M_employee->getEmployeeLevel($level);
    $this->load->view('V_employee', $data);
 }
}
