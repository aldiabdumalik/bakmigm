<?php

class M_employee extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function getEmployee() {
        $db = $this->load->database('sql_server', TRUE);
        if(!$db) {
          echo "Not connected";
          die;
        }
        $employee = $db->query('exec USEREDOC');
        return $employee->result_array();
    }
}
