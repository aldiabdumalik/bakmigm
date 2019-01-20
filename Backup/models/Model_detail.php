<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_detail extends CI_Model {

	function cek_book($si_key,$ur_id)
	{
		$this->db->where('DOC_ID' , $si_key);
		$this->db->where('UR_ID' , $ur_id);
		$query = $this->db->get('tb_document_bookmark');
		if ($query->num_rows()>0) {
			return true;
		}else{
			return false;
		}
	}

	function getLevel($pengguna)
	{
		$this->db->select('UR_EMAIL');
		$this->db->from('tb_user');
		$this->db->where('RS_ID', $pengguna);
		$query = $this->db->get();
		// $result = $query->result_array();
		$result = $query->result_array();
		return $result;
	}

	function getDokPengguna(){
		$this->db->select('DOC_PENGGUNA');
		$this->db->from('tb_document');
		$q = $this->db->get();
		return $q->result_array();
	}

	function GET_DETAIL_SERCH($SESSION_DEPARTEMENT_ID,$SESSION_JOB_LEVEL_ID){
		$this->db->select('*');
		$this->db->join('tb_document', 'tb_document.DOC_ID = tb_document_detail.DOC_ID', 'left');
		$this->db->join('tb_departemen', 'tb_departemen.DN_ID = tb_document.DOC_PEMILIK_PROSES', 'left');
		$this->db->join('tb_document_structure_tipe', 'tb_document_structure_tipe.DTSETE_ID = tb_document.DOC_TIPE', 'left');
		$this->db->where('DOC_STATUS', 'PUBLISH');
		$this->db->like('DOC_AKSES_LEVEL', $SESSION_JOB_LEVEL_ID, 'BOTH');
		$this->db->like('DOC_PENGGUNA', $SESSION_DEPARTEMENT_ID, 'BOTH');
		$q = $this->db->get('tb_document_detail');
		$result = $q->result_array();
		return $result;
	}

	function getDetail($SESSION_DEPARTEMENT_ID,$DOC_ID,$SESSION_JOB_LEVEL_ID){
		
		// $this->db->select('*');
		// $this->db->join('tb_document', 'tb_document.DOC_ID = tb_document_detail.DOC_ID', 'left');
		// $this->db->join('tb_departemen', 'tb_departemen.DN_ID = tb_document.DOC_PEMILIK_PROSES', 'left');
		// $this->db->join('tb_document_structure_tipe', 'tb_document_structure_tipe.DTSETE_ID = tb_document.DOC_TIPE', 'left');
		// $this->db->where('DOC_STATUS', 'PUBLISH');
		// $this->db->where('DOC_PENGGUNA', $SESSION_DEPARTEMENT_ID);
		// $q = $this->db->get('tb_document_detail');
		// $result = $q->result_array();
		// return $result;
		$this->db->where('DOC_ID', $DOC_ID);
		$this->db->like('DOC_AKSES_LEVEL', $SESSION_JOB_LEVEL_ID, 'BOTH');
		$this->db->like('DOC_PENGGUNA', $SESSION_DEPARTEMENT_ID, 'BOTH');
		$q = $this->db->get('tb_document');
		$result = $q->result_array();
		return $result;
	}

	function getDetailList($id){
		$this->db->select('*');
		$this->db->join('tb_document', 'tb_document.DOC_ID = tb_document_detail.DOC_ID', 'left');
		$this->db->join('tb_departemen', 'tb_departemen.DN_ID = tb_document.DOC_PEMILIK_PROSES', 'left');
		$this->db->join('tb_document_structure_jenis', 'tb_document_structure_jenis.DTSEJS_ID = tb_document.DOC_JENIS', 'left');
		$this->db->join('tb_document_structure_tipe', 'tb_document_structure_tipe.DTSETE_ID = tb_document.DOC_TIPE', 'left');
		$this->db->where('tb_document.DOC_ID',$id);
		$q = $this->db->get('tb_document_detail');
		$result = $q->result_array();
		return $result;
	}

	public function DB_GET_EMAIL(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from('tb_user');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][Model_detail][DB_GET_EMAIL]".$error;
		}
		return $result;
	}

	function search($keyword){
		$query = $this->db->query("SELECT * FROM tb_document LEFT JOIN tb_document_detail ON tb_document_detail.DOC_ID = tb_document.DOC_ID JOIN tb_departemen ON tb_departemen.DN_ID = tb_document.DOC_PEMILIK_PROSES WHERE tb_document.DOC_STATUS = 'PUBLISH' AND tb_document_detail.DOCD_SEARCH LIKE '%".$keyword."%' ");
		$q = $query->result_array();
		return $q;
	}

	function pencarian($si_doc_type,$ssa_dept_owner,$ssa_group_proces,$ssa_proces)
	{
		$query = $this->db->query("SELECT * FROM tb_document LEFT JOIN tb_document_detail ON tb_document_detail.DOC_ID = tb_document.DOC_ID JOIN tb_departemen ON tb_departemen.DN_ID = tb_document.DOC_PEMILIK_PROSES WHERE tb_document.DOC_STATUS = 'PUBLISH' AND tb_document.DOC_PEMILIK_PROSES LIKE '%".$ssa_dept_owner."%' AND tb_document.DOC_TIPE LIKE '%".$si_doc_type."%' AND tb_document.DOC_GROUP_PROSES LIKE '%".$ssa_group_proces."%' AND tb_document.DOC_PROSES LIKE '%".$ssa_proces."%'");
		$q = $query->result_array();
		return $q;
	}	

	// MODEL BOOKMARK
	function getBookmark($SESSION_ID){
		$this->db->select('*');
		$this->db->join('tb_document', 'tb_document.DOC_ID = tb_document_bookmark.DOC_ID', 'left');
		$this->db->join('tb_document_detail', 'tb_document_detail.DOC_ID = tb_document.DOC_ID', 'left');
		$this->db->join('tb_departemen', 'tb_departemen.DN_ID = tb_document.DOC_PEMILIK_PROSES', 'left');
		$this->db->join('tb_document_structure_tipe', 'tb_document_structure_tipe.DTSETE_ID = tb_document.DOC_TIPE', 'left');
		$this->db->where('UR_ID', $SESSION_ID);
		$q = $this->db->get('tb_document_bookmark');
		$result = $q->result_array();
		return $result;
	}

	function caribookmark($keyword){
		$query = $this->db->query("SELECT * FROM tb_document 
								   LEFT JOIN tb_document_detail 
								   ON tb_document_detail.DOC_ID = tb_document.DOC_ID 
								   JOIN tb_departemen 
								   ON tb_departemen.DN_ID = tb_document.DOC_PEMILIK_PROSES 
								   WHERE tb_document.DOC_STATUS = 'PUBLISH'
								   AND tb_document_detail.DOCD_SEARCH 
								   LIKE '%".$keyword."%' ");
		$q = $query->result_array();
		return $q;
	}

	function pencarianbookmark($si_doc_type,$ssa_dept_owner,$ssa_group_proces,$ssa_proces)
	{
		$query = $this->db->query("SELECT * FROM tb_document 
								   LEFT JOIN tb_document_detail 
								   ON tb_document_detail.DOC_ID = tb_document.DOC_ID 
								   JOIN tb_departemen 
								   ON tb_departemen.DN_ID = tb_document.DOC_PEMILIK_PROSES 
								   WHERE tb_document.DOC_STATUS = 'PUBLISH'
								   AND tb_document.DOC_PEMILIK_PROSES LIKE '%".$ssa_dept_owner."%' 
								   AND tb_document.DOC_TIPE LIKE '%".$si_doc_type."%' 
								   AND tb_document.DOC_GROUP_PROSES LIKE '%".$ssa_group_proces."%' 
								   AND tb_document.DOC_PROSES LIKE '%".$ssa_proces."%'");
		$q = $query->result_array();
		return $q;
	}

	public function getDOCD($ID)
	{
		$this->db->select('*');
		$this->db->from('tb_document_detail');
		$this->db->join('tb_document', 'tb_document.DOC_ID = tb_document_detail.DOC_ID', 'left');
		$this->db->where('tb_document_detail.DOC_ID', $ID);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
	}

	
}

/* End of file Model_detail.php */
/* Location: ./application/models/Model_detail.php */