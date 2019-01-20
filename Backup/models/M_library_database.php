<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class M_library_database extends CI_Model {
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	private $tb_business_rule	  	 		= "tb_business_rule";
	private $tb_confidential				= "tb_confidential";
	private $tb_distribution_method			= "tb_distribution_method";
	private $tb_document					= "tb_document";
	private $tb_document_comment			= "tb_document_comment";
	private $tb_document_detail				= "tb_document_detail";
	private $tb_document_detail_status		= "tb_document_detail_status";
	private $tb_document_form	  	 		= "tb_document_form";
	private $tb_document_level_access		= "tb_document_level_access";
	private $tb_document_status	  	 		= "tb_document_status";
	private $tb_document_structure_jenis	= "tb_document_structure_jenis";
	private $tb_document_structure_kategori	= "tb_document_structure_kategori";
	private $tb_document_structure_tipe		= "tb_document_structure_tipe";
	private $tb_document_template			= "tb_document_template";
	private $tb_job_level	  	 			= "tb_job_level";
	private $tb_master	  	 				= "tb_master";
	private $tb_review	  	 				= "tb_review";
	private $tb_roles	  	 				= "tb_roles";
	private $tb_structure_document			= "tb_structure_document";
	private $tb_structure_organization		= "tb_structure_organization";
	private $tb_user						= "tb_user";
	private $tb_periode_preview				= "tb_periode_preview";
	private $tb_direktorat					= "tb_direktorat";
	private $tb_divisi						= "tb_divisi";
	private $tb_departemen					= "tb_departemen";
	private $tb_document_versioning			= "tb_document_versioning";
	private $tb_document_bookmark			= "tb_document_bookmark";

	public function get_nomor($si_header_no)
	{
		$this->db->where('DOC_NOMOR' , $si_header_no);
		$query = $this->db->get('tb_document');
		if ($query->num_rows()>0) {
			return true;
		}else{
			return false;
		}
	}
	public function DB_GET_DATA_DOCUMENT_TEMPLATE_OR_DOCUMENT_STRUCTURE_TIPE($ID_KEY){
		$result = "";
		try{
			if(strpos($ID_KEY,'DTSETE')!==false){
				$query = $this->db->query('
				SELECT
				tb_document_structure_tipe.DTSETE_ID,
				tb_document_structure_tipe.DTSEJS_ID,
				tb_document_structure_tipe.DTSEKI_ID,
				tb_document_structure_tipe.DTSETE_TIPE,
				tb_document_structure_tipe.DTSETE_SINGKATAN,
				tb_document_structure_tipe.CL_ID,
				tb_document_structure_tipe.JBLL_ID,
				tb_job_level.JBLL_NAME,
				tb_job_level.JBLL_INDEX
				FROM
				tb_document_structure_tipe
				INNER JOIN tb_job_level ON tb_document_structure_tipe.JBLL_ID = tb_job_level.JBLL_ID
				WHERE tb_document_structure_tipe.DTSETE_ID = "'.$ID_KEY.'"
				LIMIT 1
				');
			}else{
				$query = $this->db->query('
				SELECT
				tb_document_template.DOCTEMP_ID,
				tb_document_template.DOCTEMP_NAME,
				tb_document_template.DTSEKI_ID,
				tb_document_template.DTSEJS_ID,
				tb_document_template.DTSETE_ID,
				tb_document_template.DOCTEMP_GROUP_PROSES,
				tb_document_template.DOCTEMP_PROSES,
				tb_document_template.DOCTEMP_NOMOR,
				tb_document_template.DOCTEMP_NAMA,
				tb_document_template.DOC_WUJUD,
				tb_document_template.DOC_DISTRIBUSI,
				tb_document_template.DOC_KERAHASIAAN,
				tb_document_template.UR_ID,
				tb_document_structure_tipe.DTSEJS_ID,
				tb_document_structure_tipe.DTSEKI_ID,
				tb_document_structure_tipe.DTSETE_TIPE,
				tb_document_structure_tipe.DTSETE_SINGKATAN,
				tb_document_structure_tipe.CL_ID,
				tb_document_structure_tipe.JBLL_ID,
				tb_job_level.JBLL_NAME,
				tb_job_level.JBLL_INDEX
				FROM
				tb_document_template
				INNER JOIN tb_document_structure_tipe ON tb_document_template.DTSETE_ID = tb_document_structure_tipe.DTSETE_ID
				INNER JOIN tb_job_level ON tb_document_structure_tipe.JBLL_ID = tb_job_level.JBLL_ID
				WHERE tb_document_template.DOCTEMP_ID = "'.$ID_KEY.'"
				LIMIT 1
				');
			}
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_TEMPLATE_OR_DOCUMENT_STRUCTURE_TIPE]".$error;
		}
		return $result;
	}
	public function DB_INSERT_DATA_BOOKMARK($data)
	{
		$status = false;
		try{
			$this->db->insert($this->tb_document_bookmark, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_BOOKMARK]".$error;
		}
		return $status;
	}
	public function DB_INPUT_DATA_VERSIONING($data)
	{
		$status = false;
		try{
			$this->db->insert($this->tb_document_versioning, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INPUT_DATA_VERSIONING]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//public function DB_GET_DATA_EXAMPLE_ARRAY($ID){
	//	$result = "";
	//	try{
	//		$this->db->select('*');
	//		$this->db->from($this->tb_example);
	//		$this->db->like('ID', $ID);
	//		$query = $this->db->get();
	//		if ($query->num_rows() > 0) {
	//			return $query->result();
	//		}
	//	}catch(Exception $exc){
	//		$error = $exc->getMessage();
	//		echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_EXAMPLE_ARRAY]".$error;
	//	}
	//	return $result;
	//}
	////-----------------------------------------------------------------------------------------------//
	//public function DB_GET_DATA_EXAMPLE($ID){
	//	$result = "";
	//	try{
	//		$this->db->select('*');
	//		$this->db->from($this->tb_example);
	//		$this->db->where('ID', $ID);
	//		$this->db->limit(1);
	//		$query = $this->db->get();
	//		if ($query->num_rows() > 0) {
	//			return $query->result();
	//		}
	//	}catch(Exception $exc){
	//		$error = $exc->getMessage();
	//		echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_EXAMPLE]".$error;
	//	}
	//	return $result;
	//}
	////-----------------------------------------------------------------------------------------------//
	//public function DB_INSERT_DATA_EXAMPLE($data){
	//	$status = false;
	//	try{
	//		$this->db->insert($this->tb_example, $data);
	//		if($this->db->affected_rows() == 1){
	//			$status = true;
	//		}
	//	}catch(Exception $exc){
	//		$error = $exc->getMessage();
	//		echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_EXAMPLE]".$error;
	//	}
	//	return $status;
	//}
	////-----------------------------------------------------------------------------------------------//
	//public function DB_UPDATE_DATA_EXAMPLE($ID,$data){
	//	$status = false;
	//	try{
	//		$this->db->where('ID', $ID);
	//		$this->db->update($this->tb_example, $data);
	//		if($this->db->affected_rows() == 1){
	//			$status = true;
	//		}
	//	}catch(Exception $exc){
	//		$error = $exc->getMessage();
	//		echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_EXAMPLE]".$error;
	//	}
	//	return $status;
	//}
	////-----------------------------------------------------------------------------------------------//
	//public function DB_DELETE_DATA_EXAMPLE($ID){
	//	$status = false;
	//	try{
	//		$this->db->where('ID', $ID);
	//		$this->db->delete($this->tb_example);
	//		if($this->db->affected_rows() == 1){
	//			$status = true;
	//		}
	//	}catch(Exception $exc){
	//		$error = $exc->getMessage();
	//		echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_EXAMPLE]".$error;
	//	}
	//	return $status;
	//}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_LOGIN($UR_ID,$UR_PASSWORD){
		$result = "";
		try{
			//OLD
			//$this->db->select('*');
			//$this->db->from($this->tb_user);
			//$this->db->where('UR_ID', $UR_ID);
			//$this->db->where('UR_PASSWORD', $UR_PASSWORD);
			//$query = $this->db->get();
			//if ($query->num_rows() > 0) {
			//	return $query->result();
			//}
			//
			//NEW
			$query = $this->db->query('
			SELECT
			tb_user.UR_ID,
			tb_user.UR_PASSWORD,
			tb_user.UR_EMAIL,
			tb_user.DN_ID,
			tb_user.RS_ID,
			tb_user.JBLL_ID,
			tb_user.UR_DATE,
			tb_departemen.DN_CODE,
			tb_departemen.DN_NAME,
			tb_departemen.DI_ID,
			tb_divisi.DI_CODE,
			tb_divisi.DI_NAME,
			tb_divisi.DT_ID,
			tb_direktorat.DT_NAME,
			tb_job_level.JBLL_NAME,
			tb_job_level.JBLL_INDEX
			FROM
			tb_user
			INNER JOIN tb_departemen ON tb_user.DN_ID = tb_departemen.DN_ID
			INNER JOIN tb_divisi ON tb_departemen.DI_ID = tb_divisi.DI_ID
			INNER JOIN tb_direktorat ON tb_divisi.DT_ID = tb_direktorat.DT_ID
			INNER JOIN tb_roles ON tb_user.RS_ID = tb_roles.RS_ID
			INNER JOIN tb_job_level ON tb_user.JBLL_ID = tb_job_level.JBLL_ID
			WHERE tb_user.UR_ID = "'.$UR_ID.'"
			AND tb_user.UR_PASSWORD = "'.$UR_PASSWORD.'"
			LIMIT 1
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_LOGIN]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_MASTER_ARRAY(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_master);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_MASTER_ARRAY]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_MASTER($data){
		$status = false;
		try{
			$this->db->insert($this->tb_master, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_MASTER]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_MASTER($MR_ID){
		$status = false;
		try{
			$this->db->where('MR_ID', $MR_ID);
			$this->db->delete($this->tb_master);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_MASTER]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_STRUCTURE_ORGANIZATION_ARRAY(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_structure_organization);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_STRUCTURE_ORGANIZATION_ARRAY]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_STRUCTURE_ORGANIZATION($data){
		$status = false;
		try{
			$this->db->insert($this->tb_structure_organization, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_STRUCTURE_ORGANIZATION]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_STRUCTURE_ORGANIZATION($SEON_ID){
		$status = false;
		try{
			$this->db->where('SEON_ID', $SEON_ID);
			$this->db->delete($this->tb_structure_organization);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_STRUCTURE_ORGANIZATION]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_USER($data){
		$status = false;
		try{
			$this->db->insert($this->tb_user, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_USER]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_USER($UR_ID){
		$status = false;
		try{
			$this->db->where('UR_ID', $UR_ID);
			$this->db->delete($this->tb_user);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_USER]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_JOB_ROLE_ARRAY(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_job_role);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_JOB_ROLE_ARRAY]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ROLES(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_roles);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ROLES]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_LEVEL_ACCESS_ARRAY(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_level_access);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_LEVEL_ACCESS_ARRAY]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_DOCUMENT_LEVEL_ACCESS($data){
		$status = false;
		try{
			$this->db->insert($this->tb_document_level_access, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_DOCUMENT_LEVEL_ACCESS]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_DOCUMENT_LEVEL_ACCESS($DTLLAS_ID){
		$status = false;
		try{
			$this->db->where('DTLLAS_ID', $DTLLAS_ID);
			$this->db->delete($this->tb_document_level_access);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_DOCUMENT_LEVEL_ACCESS]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_ARRAY(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_ARRAY]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_DOCUMENT($data){
		$status = false;
		try{
			$this->db->insert($this->tb_document, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_DOCUMENT]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_DOCUMENT($DOC_ID,$data){
		$status = false;
		try{
			$this->db->where('DOC_ID', $DOC_ID);
			$this->db->update($this->tb_document, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_DOCUMENT]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_DELETE_DATA_DOCUMENT($DOC_ID){
		$status = false;
		try{
			$this->db->where('DOC_ID', $DOC_ID);
			$this->db->delete($this->tb_document);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_DELETE_DATA_DOCUMENT]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_SEARCH_DATA_DOCUMENT_ARRAY($DOC_ID,$DOC_NOMOR,$DOC_NAMA,$DOC_MAKER,$DOC_APPROVE,$DOC_STATUS){
		$result = "";
		try{
			//OLD
			//$this->db->select('*');
			//$this->db->from($this->tb_document);
			//$this->db->like('DOC_ID', $DOC_ID);
			//$this->db->like('DOC_NOMOR', $DOC_NOMOR);
			//$this->db->like('DOC_NAMA', $DOC_NAMA);
			//$this->db->like('DOC_MAKER', $DOC_MAKER);
			//$this->db->like('DOC_APPROVE', $DOC_APPROVE);
			//$this->db->like('DOC_STATUS', $DOC_STATUS);
			//$query = $this->db->get();
			//if ($query->num_rows() > 0) {
			//	return $query->result();
			//}
			//
			//NEW
			$query = $this->db->query('
			SELECT
			tb_document.DOC_ID,
			tb_document.DOC_DATE,
			tb_document.DOC_KATEGORI,
			tb_document.DOC_JENIS,
			tb_document.DOC_TIPE,
			tb_document.DOC_GROUP_PROSES,
			tb_document.DOC_PROSES,
			tb_document.DOC_NOMOR,
			tb_document.DOC_NAMA,
			tb_document.DOC_WUJUD,
			tb_document.DOC_DISTRIBUSI,
			tb_document.DOC_KERAHASIAAN,
			tb_document.DOC_AKSES_LEVEL,
			tb_document.DOC_PENGGUNA,
			tb_document.DOC_PEMILIK_PROSES,
			tb_document.DOC_PENYIMPAN,
			tb_document.DOC_PENDISTRIBUSI,
			tb_document.DOC_VERSI,
			tb_document.DOC_TGL_EFEKTIF,
			tb_document.DOC_PERIODE_PREVIEW,
			tb_document.DOC_TGL_EXPIRED,
			tb_document.DOC_KATA_KUNCI,
			tb_document.DOC_ABSTRAK,
			tb_document.DOC_TERKAIT,
			tb_document.DOC_MAKER,
			tb_document.DOC_APPROVE,
			tb_document.DOC_STATUS,
			tb_document.DOC_NOTE,
			tb_document_structure_kategori.DTSEKI_KATEGORI,
			tb_document_structure_jenis.DTSEJS_JENIS,
			tb_document_structure_tipe.DTSETE_TIPE,
			tb_document_structure_tipe.DTSETE_SINGKATAN,
			tb_document_form.DTFM_NAME,
			tb_distribution_method.DNMD_NAME,
			tb_confidential.CL_NAME,
			tb_user.DN_ID,
			tb_departemen.DN_CODE,
			tb_departemen.DN_NAME,
			tb_divisi.DI_CODE,
			tb_divisi.DI_NAME,
			tb_direktorat.DT_NAME
			FROM
			tb_document
			INNER JOIN tb_document_structure_kategori ON tb_document_structure_kategori.DTSEKI_ID = tb_document.DOC_KATEGORI
			INNER JOIN tb_document_structure_jenis ON tb_document_structure_jenis.DTSEJS_ID = tb_document.DOC_JENIS
			INNER JOIN tb_document_structure_tipe ON tb_document_structure_tipe.DTSETE_ID = tb_document.DOC_TIPE
			INNER JOIN tb_document_form ON tb_document_form.DTFM_ID = tb_document.DOC_WUJUD
			INNER JOIN tb_distribution_method ON tb_distribution_method.DNMD_ID = tb_document.DOC_DISTRIBUSI
			INNER JOIN tb_confidential ON tb_confidential.CL_ID = tb_document.DOC_KERAHASIAAN
			INNER JOIN tb_user ON tb_document.DOC_MAKER = tb_user.UR_ID
			INNER JOIN tb_departemen ON tb_user.DN_ID = tb_departemen.DN_ID
			INNER JOIN tb_divisi ON tb_departemen.DI_ID = tb_divisi.DI_ID
			INNER JOIN tb_direktorat ON tb_divisi.DT_ID = tb_direktorat.DT_ID
			WHERE tb_document.DOC_ID LIKE "%'.$DOC_ID.'%"
			AND tb_document.DOC_NOMOR LIKE "%'.$DOC_NOMOR.'%"
			AND tb_document.DOC_NAMA LIKE "%'.$DOC_NAMA.'%"
			AND tb_document.DOC_MAKER LIKE "%'.$DOC_MAKER.'%"
			AND tb_document.DOC_APPROVE LIKE "%'.$DOC_APPROVE.'%"
			AND tb_document.DOC_STATUS LIKE "%'.$DOC_STATUS.'%"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_SEARCH_DATA_DOCUMENT_ARRAY]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_SEARCH_DATA_DOCUMENT_ARRAY2($DOC_ID,$DOC_NOMOR,$DOC_NAMA,$DOC_MAKER,$DOC_APPROVE,$DOC_STATUS){
		$result = "";
		try{
			//OLD
			//$this->db->select('*');
			//$this->db->from($this->tb_document);
			//$this->db->like('DOC_ID', $DOC_ID);
			//$this->db->like('DOC_NOMOR', $DOC_NOMOR);
			//$this->db->like('DOC_NAMA', $DOC_NAMA);
			//$this->db->like('DOC_MAKER', $DOC_MAKER);
			//$this->db->like('DOC_APPROVE', $DOC_APPROVE);
			//$this->db->like('DOC_STATUS', $DOC_STATUS);
			//$query = $this->db->get();
			//if ($query->num_rows() > 0) {
			//	return $query->result();
			//}
			//
			//NEW
			$query = $this->db->query('
			SELECT
			tb_document.DOC_ID,
			tb_document.DOC_DATE,
			tb_document.DOC_KATEGORI,
			tb_document.DOC_JENIS,
			tb_document.DOC_TIPE,
			tb_document.DOC_GROUP_PROSES,
			tb_document.DOC_PROSES,
			tb_document.DOC_NOMOR,
			tb_document.DOC_NAMA,
			tb_document.DOC_WUJUD,
			tb_document.DOC_DISTRIBUSI,
			tb_document.DOC_KERAHASIAAN,
			tb_document.DOC_AKSES_LEVEL,
			tb_document.DOC_PENGGUNA,
			tb_document.DOC_PEMILIK_PROSES,
			tb_document.DOC_PENYIMPAN,
			tb_document.DOC_PENDISTRIBUSI,
			tb_document.DOC_VERSI,
			tb_document.DOC_TGL_EFEKTIF,
			tb_document.DOC_PERIODE_PREVIEW,
			tb_document.DOC_TGL_EXPIRED,
			tb_document.DOC_KATA_KUNCI,
			tb_document.DOC_ABSTRAK,
			tb_document.DOC_TERKAIT,
			tb_document.DOC_MAKER,
			tb_document.DOC_APPROVE,
			tb_document.DOC_STATUS,
			tb_document.DOC_NOTE,
			tb_document_structure_kategori.DTSEKI_KATEGORI,
			tb_document_structure_jenis.DTSEJS_JENIS,
			tb_document_structure_tipe.DTSETE_TIPE,
			tb_document_structure_tipe.DTSETE_SINGKATAN,
			tb_document_form.DTFM_NAME,
			tb_distribution_method.DNMD_NAME,
			tb_confidential.CL_NAME,
			tb_user.DN_ID,
			tb_departemen.DN_CODE,
			tb_departemen.DN_NAME,
			tb_divisi.DI_CODE,
			tb_divisi.DI_NAME,
			tb_direktorat.DT_NAME
			FROM
			tb_document
			INNER JOIN tb_document_structure_kategori ON tb_document_structure_kategori.DTSEKI_ID = tb_document.DOC_KATEGORI
			INNER JOIN tb_document_structure_jenis ON tb_document_structure_jenis.DTSEJS_ID = tb_document.DOC_JENIS
			INNER JOIN tb_document_structure_tipe ON tb_document_structure_tipe.DTSETE_ID = tb_document.DOC_TIPE
			INNER JOIN tb_document_form ON tb_document_form.DTFM_ID = tb_document.DOC_WUJUD
			INNER JOIN tb_distribution_method ON tb_distribution_method.DNMD_ID = tb_document.DOC_DISTRIBUSI
			INNER JOIN tb_confidential ON tb_confidential.CL_ID = tb_document.DOC_KERAHASIAAN
			INNER JOIN tb_user ON tb_document.DOC_MAKER = tb_user.UR_ID
			INNER JOIN tb_departemen ON tb_user.DN_ID = tb_departemen.DN_ID
			INNER JOIN tb_divisi ON tb_departemen.DI_ID = tb_divisi.DI_ID
			INNER JOIN tb_direktorat ON tb_divisi.DT_ID = tb_direktorat.DT_ID
			WHERE tb_document.DOC_STATUS = "PUBLISH" AND tb_document.DOC_ID LIKE "%'.$DOC_ID.'%"
			AND tb_document.DOC_NOMOR LIKE "%'.$DOC_NOMOR.'%"
			AND tb_document.DOC_NAMA LIKE "%'.$DOC_NAMA.'%"
			AND tb_document.DOC_MAKER LIKE "%'.$DOC_MAKER.'%"
			AND tb_document.DOC_APPROVE LIKE "%'.$DOC_APPROVE.'%"
			AND tb_document.DOC_STATUS LIKE "%'.$DOC_STATUS.'%"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_SEARCH_DATA_DOCUMENT_ARRAY]".$error;
		}
		return $result;
	}
	public function DB_GET_SEARCH_NEWS_DATA_DOCUMENT_ARRAY($DOC_AKSES_LEVEL,$DOC_PENGGUNA){
		$result = "";
		try{
			//OLD
			//$this->db->select('*');
			//$this->db->from($this->tb_document);
			//$this->db->like('DOC_ID', $DOC_ID);
			//$this->db->like('DOC_NOMOR', $DOC_NOMOR);
			//$this->db->like('DOC_NAMA', $DOC_NAMA);
			//$this->db->like('DOC_MAKER', $DOC_MAKER);
			//$this->db->like('DOC_APPROVE', $DOC_APPROVE);
			//$this->db->like('DOC_STATUS', $DOC_STATUS);
			//$query = $this->db->get();
			//if ($query->num_rows() > 0) {
			//	return $query->result();
			//}
			//
			//NEW
			$query = $this->db->query('
			SELECT
			tb_document.DOC_ID,
			tb_document.DOC_DATE,
			tb_document.DOC_KATEGORI,
			tb_document.DOC_JENIS,
			tb_document.DOC_TIPE,
			tb_document.DOC_GROUP_PROSES,
			tb_document.DOC_PROSES,
			tb_document.DOC_NOMOR,
			tb_document.DOC_NAMA,
			tb_document.DOC_WUJUD,
			tb_document.DOC_DISTRIBUSI,
			tb_document.DOC_KERAHASIAAN,
			tb_document.DOC_AKSES_LEVEL,
			tb_document.DOC_PENGGUNA,
			tb_document.DOC_PEMILIK_PROSES,
			tb_document.DOC_PENYIMPAN,
			tb_document.DOC_PENDISTRIBUSI,
			tb_document.DOC_VERSI,
			tb_document.DOC_TGL_EFEKTIF,
			tb_document.DOC_PERIODE_PREVIEW,
			tb_document.DOC_TGL_EXPIRED,
			tb_document.DOC_KATA_KUNCI,
			tb_document.DOC_ABSTRAK,
			tb_document.DOC_TERKAIT,
			tb_document.DOC_MAKER,
			tb_document.DOC_APPROVE,
			tb_document.DOC_STATUS,
			tb_document.DOC_NOTE,
			tb_document_structure_kategori.DTSEKI_KATEGORI,
			tb_document_structure_jenis.DTSEJS_JENIS,
			tb_document_structure_tipe.DTSETE_TIPE,
			tb_document_structure_tipe.DTSETE_SINGKATAN,
			tb_document_form.DTFM_NAME,
			tb_distribution_method.DNMD_NAME,
			tb_confidential.CL_NAME,
			tb_user.DN_ID,
			tb_departemen.DN_CODE,
			tb_departemen.DN_NAME,
			tb_divisi.DI_CODE,
			tb_divisi.DI_NAME,
			tb_direktorat.DT_NAME
			FROM
			tb_document
			INNER JOIN tb_document_structure_kategori ON tb_document_structure_kategori.DTSEKI_ID = tb_document.DOC_KATEGORI
			INNER JOIN tb_document_structure_jenis ON tb_document_structure_jenis.DTSEJS_ID = tb_document.DOC_JENIS
			INNER JOIN tb_document_structure_tipe ON tb_document_structure_tipe.DTSETE_ID = tb_document.DOC_TIPE
			INNER JOIN tb_document_form ON tb_document_form.DTFM_ID = tb_document.DOC_WUJUD
			INNER JOIN tb_distribution_method ON tb_distribution_method.DNMD_ID = tb_document.DOC_DISTRIBUSI
			INNER JOIN tb_confidential ON tb_confidential.CL_ID = tb_document.DOC_KERAHASIAAN
			INNER JOIN tb_user ON tb_document.DOC_MAKER = tb_user.UR_ID
			INNER JOIN tb_departemen ON tb_user.DN_ID = tb_departemen.DN_ID
			INNER JOIN tb_divisi ON tb_departemen.DI_ID = tb_divisi.DI_ID
			INNER JOIN tb_direktorat ON tb_divisi.DT_ID = tb_direktorat.DT_ID
			WHERE tb_document.DOC_AKSES_LEVEL LIKE "%'.$DOC_AKSES_LEVEL.'%"
			AND tb_document.DOC_PENGGUNA LIKE "%'.$DOC_PENGGUNA.'%"
			AND tb_document.DOC_STATUS = "PUBLISH"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_SEARCH_NEWS_DATA_DOCUMENT_ARRAY]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_SEARCH_DATA_DOCUMENT($DOC_ID){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document);
			$this->db->where('DOC_ID', $DOC_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_SEARCH_DATA_DOCUMENT]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_BUSINESS_RULE_EVO(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_business_rule);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_BUSINESS_RULE_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_CONFIDENTIAL_EVO(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_confidential);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_CONFIDENTIAL_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DISTRIBUTION_METHOD_EVO(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_distribution_method);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DISTRIBUTION_METHOD_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DOCUMENT_FORM_EVO(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_form);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DOCUMENT_FORM_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DOCUMENT_STATUS_EVO(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_status);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DOCUMENT_STATUS_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_JOB_LEVEL_EVO(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_job_level);
			$this->db->order_by("JBLL_INDEX","ASC");
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_JOB_LEVEL_EVO]".$error;
		}
		return $result;
	}
	public function DB_GET_JOB_LEVEL_EVO_EXT($arrays){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_job_level);
			$this->db->where_in("JBLL_ID", $arrays);
			$this->db->order_by("JBLL_INDEX","DESC");
			$this->db->limit(1);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_JOB_LEVEL_EVO_EXT]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_JOB_LEVEL_NOT_IN_EVO($data){
		$result = "";
		try{
			$array_data = explode(",",$data);
			
			$this->db->select('*');
			$this->db->from($this->tb_job_level);
			$this->db->where_not_in('JBLL_ID', $array_data);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_JOB_LEVEL_NOT_IN_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_JOB_LEVEL_BY_ID_EVO($JBLL_ID){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_job_level);
			$this->db->where('JBLL_ID', $JBLL_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_JOB_LEVEL_BY_ID_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_ROLES_EVO(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_roles);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_ROLES_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_STRUCTURE_KATEGORI_EVO(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_structure_kategori);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_STRUCTURE_KATEGORI_EVO]".$error;
		}
		return $result;
	}
	public function DB_GET_DATA_DOCUMENT_STRUCTURE_TIPE_ALL(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_structure_tipe);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_STRUCTURE_TIPE_ALL]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_STRUCTURE_JENIS_EVO($DTSEKI_ID){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_structure_jenis);
			$this->db->where('DTSEKI_ID', $DTSEKI_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_STRUCTURE_JENIS_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_STRUCTURE_TIPE_EVO($DTSEJS_ID){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_structure_tipe);
			$this->db->where('DTSEJS_ID', $DTSEJS_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_STRUCTURE_TIPE_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_STRUCTURE_TIPE_CONFIDENTAL_EVO($DTSETE_ID){
		$result = "";
		try{
			$query = $this->db->query('
			SELECT
			tb_document_structure_tipe.DTSETE_ID,
			tb_document_structure_tipe.DTSEJS_ID,
			tb_document_structure_tipe.DTSEKI_ID,
			tb_document_structure_tipe.DTSETE_TIPE,
			tb_document_structure_tipe.DTSETE_SINGKATAN,
			tb_document_structure_tipe.CL_ID,
			tb_document_structure_tipe.JBLL_ID,
			tb_confidential.CL_NAME,
			tb_document_structure_kategori.DTSEKI_KATEGORI,
			tb_document_structure_jenis.DTSEJS_JENIS
			FROM
			tb_document_structure_tipe
			INNER JOIN tb_confidential ON
			tb_document_structure_tipe.CL_ID = tb_confidential.CL_ID 
			INNER JOIN tb_document_structure_jenis ON tb_document_structure_tipe.DTSEJS_ID = tb_document_structure_jenis.DTSEJS_ID 
			INNER JOIN tb_document_structure_kategori ON tb_document_structure_tipe.DTSEKI_ID = tb_document_structure_kategori.DTSEKI_ID 
			WHERE tb_document_structure_tipe.DTSETE_ID = "'.$DTSETE_ID.'"
			LIMIT 1
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_STRUCTURE_TIPE_CONFIDENTAL_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_PERIODE_PREVIEW_EVO(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_periode_preview);
			$this->db->order_by("PEPW_INDEX","ASC");
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_PERIODE_PREVIEW_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_DETAIL_ALL_EVO(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_detail);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_DETAIL_ALL_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_DETAIL_BY_ID_EVO($DOC_ID){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_detail);
			$this->db->where('DOC_ID', $DOC_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_DETAIL_BY_ID_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_DOCUMENT_DETAIL_EVO($data){
		$status = false;
		try{
			$this->db->insert($this->tb_document_detail, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_DOCUMENT_DETAIL_EVO]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_DOCUMENT_DETAIL_EVO($DOC_ID,$data){
		$status = false;
		try{
			$this->db->where('DOC_ID', $DOC_ID);
			$this->db->update($this->tb_document_detail, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_DOCUMENT_DETAIL_EVO]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_TEMPLATE_EVO(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_template);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_TEMPLATE_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_TEMPLATE_BY_ID_EVO($UR_ID){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_template);
			$this->db->where('UR_ID', $UR_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_TEMPLATE_BY_ID_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_TEMPLATE_AUTO_BUILD_EVO($DOCTEMP_ID){
		$result = "";
		try{
			$query = $this->db->query('
			SELECT
			tb_document_template.DOCTEMP_ID,
			tb_document_template.DOCTEMP_NAME,
			tb_document_template.DTSEKI_ID,
			tb_document_structure_kategori.DTSEKI_KATEGORI,
			tb_document_template.DTSEJS_ID,
			tb_document_structure_jenis.DTSEJS_JENIS,
			tb_document_template.DTSETE_ID,
			tb_document_structure_tipe.DTSETE_TIPE,
			tb_document_structure_tipe.DTSETE_SINGKATAN,
			tb_document_structure_tipe.JBLL_ID,
			tb_document_template.DOCTEMP_GROUP_PROSES,
			tb_document_template.DOCTEMP_PROSES,
			tb_document_template.DOCTEMP_NOMOR,
			tb_document_template.DOCTEMP_NAMA,
			tb_document_template.DOC_WUJUD,
			tb_document_template.DOC_DISTRIBUSI,
			tb_document_template.DOC_KERAHASIAAN,
			tb_document_template.UR_ID,
			tb_confidential.CL_NAME,
			tb_document_form.DTFM_NAME,
			tb_distribution_method.DNMD_NAME
			FROM
			tb_document_template
			INNER JOIN tb_document_structure_tipe ON tb_document_template.DTSETE_ID = tb_document_structure_tipe.DTSETE_ID
			INNER JOIN tb_document_structure_jenis ON tb_document_template.DTSEJS_ID = tb_document_structure_jenis.DTSEJS_ID
			INNER JOIN tb_document_structure_kategori ON tb_document_template.DTSEKI_ID = tb_document_structure_kategori.DTSEKI_ID
			INNER JOIN tb_confidential ON tb_document_template.DOC_KERAHASIAAN = tb_confidential.CL_ID
			INNER JOIN tb_document_form ON tb_document_template.DOC_WUJUD = tb_document_form.DTFM_ID
			INNER JOIN tb_distribution_method ON tb_document_template.DOC_DISTRIBUSI = tb_distribution_method.DNMD_ID
			WHERE tb_document_template.DOCTEMP_ID = "'.$DOCTEMP_ID.'"
			LIMIT 1
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_TEMPLATE_AUTO_BUILD_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_DOCUMENT_TEMPLATE_EVO($data){
		$status = false;
		try{
			$this->db->insert($this->tb_document_template, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_DOCUMENT_TEMPLATE_EVO]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_DOCUMENT_TEMPLATE_EVO($DOCTEMP_ID,$data){
		$status = false;
		try{
			$this->db->where('DOCTEMP_ID', $DOCTEMP_ID);
			$this->db->update($this->tb_document_template, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_DOCUMENT_TEMPLATE_EVO]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_DETAIL_STATUS_BY_ID_EVO($DOC_ID){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_detail_status);
			$this->db->where('DOC_ID', $DOC_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_DETAIL_STATUS_BY_ID_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_DOCUMENT_DETAIL_STATUS_EVO($data){
		$status = false;
		try{
			$this->db->insert($this->tb_document_detail_status, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_DOCUMENT_DETAIL_STATUS_EVO]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_SEARCH_DATA_DOCUMENT_BY_ID_EVO($DOC_ID){
		$result = "";
		try{
			$query = $this->db->query('
			SELECT
			tb_document.DOC_ID,
			tb_document.DOC_DATE,
			tb_document.DOC_KATEGORI,
			tb_document.DOC_JENIS,
			tb_document.DOC_TIPE,
			tb_document.DOC_GROUP_PROSES,
			tb_document.DOC_PROSES,
			tb_document.DOC_NOMOR,
			tb_document.DOC_NAMA,
			tb_document.DOC_WUJUD,
			tb_document.DOC_DISTRIBUSI,
			tb_document.DOC_KERAHASIAAN,
			tb_document.DOC_AKSES_LEVEL,
			tb_document.DOC_PENGGUNA,
			tb_document.DOC_PEMILIK_PROSES,
			tb_document.DOC_PENYIMPAN,
			tb_document.DOC_PENDISTRIBUSI,
			tb_document.DOC_VERSI,
			tb_document.DOC_TGL_EFEKTIF,
			tb_document.DOC_PERIODE_PREVIEW,
			tb_document.DOC_TGL_EXPIRED,
			tb_document.DOC_KATA_KUNCI,
			tb_document.DOC_ABSTRAK,
			tb_document.DOC_TERKAIT,
			tb_document.DOC_MAKER,
			tb_document.DOC_APPROVE,
			tb_document.DOC_STATUS,
			tb_document.DOC_NOTE,
			tb_document_structure_kategori.DTSEKI_ID,
			tb_document_structure_kategori.DTSEKI_KATEGORI,
			tb_document_structure_jenis.DTSEJS_ID,
			tb_document_structure_jenis.DTSEJS_JENIS,
			tb_document_structure_tipe.DTSETE_ID,
			tb_document_structure_tipe.DTSETE_TIPE,
			tb_document_structure_tipe.DTSETE_SINGKATAN,
			tb_document_form.DTFM_ID,
			tb_document_form.DTFM_NAME,
			tb_distribution_method.DNMD_ID,
			tb_distribution_method.DNMD_NAME,
			tb_confidential.CL_ID,
			tb_confidential.CL_NAME,
			tb_document_detail.DOCD_UTAMA,
			tb_document_detail.DOCD_UTAMA_TYPE,
			tb_document_detail.DOCD_UTAMA_STATUS,
			tb_document_detail.DOCD_UTAMA_EXT,
			tb_document_detail.DOCD_PELENGKAP_1,
			tb_document_detail.DOCD_PELENGKAP_1_TYPE,
			tb_document_detail.DOCD_PELENGKAP_1_STATUS,
			tb_document_detail.DOCD_PELENGKAP_1_EXT,
			tb_document_detail.DOCD_PELENGKAP_2,
			tb_document_detail.DOCD_PELENGKAP_2_TYPE,
			tb_document_detail.DOCD_PELENGKAP_2_STATUS,
			tb_document_detail.DOCD_PELENGKAP_2_EXT,
			tb_document_detail.DOCD_PERSETUJUAN,
			tb_document_detail.DOCD_PERSETUJUAN_TYPE
			FROM
			tb_document
			INNER JOIN tb_document_structure_kategori ON tb_document_structure_kategori.DTSEKI_ID = tb_document.DOC_KATEGORI
			INNER JOIN tb_document_structure_jenis ON tb_document_structure_jenis.DTSEJS_ID = tb_document.DOC_JENIS
			INNER JOIN tb_document_structure_tipe ON tb_document_structure_tipe.DTSETE_ID = tb_document.DOC_TIPE
			INNER JOIN tb_document_form ON tb_document_form.DTFM_ID = tb_document.DOC_WUJUD
			INNER JOIN tb_distribution_method ON tb_distribution_method.DNMD_ID = tb_document.DOC_DISTRIBUSI
			INNER JOIN tb_confidential ON tb_confidential.CL_ID = tb_document.DOC_KERAHASIAAN
			INNER JOIN tb_document_detail ON tb_document_detail.DOC_ID = tb_document.DOC_ID
			WHERE tb_document.DOC_ID = "'.$DOC_ID.'"
			');
		if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_SEARCH_DATA_DOCUMENT_BY_ID_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_DOCUMENT_REFISI_EVO($DOC_ID,$data){
		$status = false;
		try{
			$this->db->where('DOC_ID', $DOC_ID);
			$this->db->update($this->tb_document, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_DOCUMENT_REFISI_EVO]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_UPDATE_DATA_DOCUMENT_DETAIL_REFISI_EVO($DOC_ID,$data){
		$status = false;
		try{
			$this->db->where('DOC_ID', $DOC_ID);
			$this->db->update($this->tb_document_detail, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_UPDATE_DATA_DOCUMENT_DETAIL_REFISI_EVO]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_INSERT_DATA_DOCUMENT_COMMENT_EVO($data){
		$status = false;
		try{
			$this->db->insert($this->tb_document_comment, $data);
			if($this->db->affected_rows() == 1){
				$status = true;
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_INSERT_DATA_DOCUMENT_COMMENT_EVO]".$error;
		}
		return $status;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DOCUMENT_COMMENT_BY_AUTHOR($DTCT_AUTHOR,$DOC_ID){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_document_comment);
			$this->db->where('DTCT_AUTHOR', $DTCT_AUTHOR);
			$this->db->where('DOC_ID', $DOC_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DOCUMENT_COMMENT_BY_AUTHOR]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DEPARTEMEN_BY_ID_EVO($DN_ID){
		$result = "";
		try{
			$query = $this->db->query('
			SELECT
			tb_direktorat.DT_ID,
			tb_direktorat.DT_NAME,
			tb_divisi.DI_ID,
			tb_divisi.DI_CODE,
			tb_divisi.DI_NAME,
			tb_departemen.DN_ID,
			tb_departemen.DN_CODE,
			tb_departemen.DN_NAME
			FROM
			tb_direktorat
			INNER JOIN tb_divisi ON tb_divisi.DT_ID = tb_direktorat.DT_ID
			INNER JOIN tb_departemen ON tb_departemen.DI_ID = tb_divisi.DI_ID
			WHERE tb_departemen.DN_ID = "'.$DN_ID.'"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DEPARTEMEN_BY_ID_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DEPARTEMENT_ARRAY(){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_departemen);
			$this->db->order_by('DN_NAME','ASC');
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DEPARTEMENT_ARRAY]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DEPARTEMENT_NOT_IN_EVO($data){
		$result = "";
		try{
			$array_data = explode(",",$data);
			
			$this->db->select('*');
			$this->db->from($this->tb_departemen);
			$this->db->where_not_in('DN_ID', $array_data);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DEPARTEMENT_NOT_IN_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DIREKTORAT_BY_ID_EVO($DT_ID){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_direktorat);
			$this->db->where('DT_ID', $DT_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DIREKTORAT_BY_ID_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DIVISI_BY_ID_DIREKTORAT_EVO($DT_ID){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_divisi);
			$this->db->where('DT_ID', $DT_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DIVISI_BY_ID_DIREKTORAT_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_DATA_DEPARTEMEN_BY_ID_DIVISI_EVO($DI_ID){
		$result = "";
		try{
			$this->db->select('*');
			$this->db->from($this->tb_departemen);
			$this->db->where('DI_ID', $DI_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_DATA_DEPARTEMEN_BY_ID_DIVISI_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	//
	//-----------------------------------------------------------------------------------------------//
	//
	//-----------------------------------------------------------------------------------------------//
	//
	//-----------------------------------------------------------------------------------------------//
	//
	//-----------------------------------------------------------------------------------------------//
	//
	//-----------------------------------------------------------------------------------------------//
	//
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_SEARCH_DATA_DOCUMENT_ARRAY_EVO($DOC_ID,$DOC_NOMOR,$DOC_NAMA,$DOC_MAKER,$DOC_APPROVE,$DOC_STATUS,$DN_ID){
		$result = "";
		try{
			//OLD
			//$this->db->select('*');
			//$this->db->from($this->tb_document);
			//$this->db->like('DOC_ID', $DOC_ID);
			//$this->db->like('DOC_NOMOR', $DOC_NOMOR);
			//$this->db->like('DOC_NAMA', $DOC_NAMA);
			//$this->db->like('DOC_MAKER', $DOC_MAKER);
			//$this->db->like('DOC_APPROVE', $DOC_APPROVE);
			//$this->db->like('DOC_STATUS', $DOC_STATUS);
			//$query = $this->db->get();
			//if ($query->num_rows() > 0) {
			//	return $query->result();
			//}
			//
			//NEW
			$query = $this->db->query('
			SELECT
			tb_document.DOC_ID,
			tb_document.DOC_DATE,
			tb_document.DOC_KATEGORI,
			tb_document.DOC_JENIS,
			tb_document.DOC_TIPE,
			tb_document.DOC_GROUP_PROSES,
			tb_document.DOC_PROSES,
			tb_document.DOC_NOMOR,
			tb_document.DOC_NAMA,
			tb_document.DOC_WUJUD,
			tb_document.DOC_DISTRIBUSI,
			tb_document.DOC_KERAHASIAAN,
			tb_document.DOC_AKSES_LEVEL,
			tb_document.DOC_PENGGUNA,
			tb_document.DOC_PEMILIK_PROSES,
			tb_document.DOC_PENYIMPAN,
			tb_document.DOC_PENDISTRIBUSI,
			tb_document.DOC_VERSI,
			tb_document.DOC_TGL_EFEKTIF,
			tb_document.DOC_PERIODE_PREVIEW,
			tb_document.DOC_TGL_EXPIRED,
			tb_document.DOC_KATA_KUNCI,
			tb_document.DOC_ABSTRAK,
			tb_document.DOC_TERKAIT,
			tb_document.DOC_MAKER,
			tb_document.DOC_APPROVE,
			tb_document.DOC_STATUS,
			tb_document.DOC_NOTE,
			tb_document_structure_kategori.DTSEKI_KATEGORI,
			tb_document_structure_jenis.DTSEJS_JENIS,
			tb_document_structure_tipe.DTSETE_TIPE,
			tb_document_structure_tipe.DTSETE_SINGKATAN,
			tb_document_form.DTFM_NAME,
			tb_distribution_method.DNMD_NAME,
			tb_confidential.CL_NAME,
			tb_user.DN_ID,
			tb_departemen.DN_CODE,
			tb_departemen.DN_NAME,
			tb_divisi.DI_CODE,
			tb_divisi.DI_NAME,
			tb_direktorat.DT_NAME
			FROM
			tb_document
			INNER JOIN tb_document_structure_kategori ON tb_document_structure_kategori.DTSEKI_ID = tb_document.DOC_KATEGORI
			INNER JOIN tb_document_structure_jenis ON tb_document_structure_jenis.DTSEJS_ID = tb_document.DOC_JENIS
			INNER JOIN tb_document_structure_tipe ON tb_document_structure_tipe.DTSETE_ID = tb_document.DOC_TIPE
			INNER JOIN tb_document_form ON tb_document_form.DTFM_ID = tb_document.DOC_WUJUD
			INNER JOIN tb_distribution_method ON tb_distribution_method.DNMD_ID = tb_document.DOC_DISTRIBUSI
			INNER JOIN tb_confidential ON tb_confidential.CL_ID = tb_document.DOC_KERAHASIAAN
			INNER JOIN tb_user ON tb_document.DOC_MAKER = tb_user.UR_ID
			INNER JOIN tb_departemen ON tb_user.DN_ID = tb_departemen.DN_ID
			INNER JOIN tb_divisi ON tb_departemen.DI_ID = tb_divisi.DI_ID
			INNER JOIN tb_direktorat ON tb_divisi.DT_ID = tb_direktorat.DT_ID
			WHERE tb_document.DOC_ID LIKE "%'.$DOC_ID.'%"
			AND tb_document.DOC_NOMOR LIKE "%'.$DOC_NOMOR.'%"
			AND tb_document.DOC_NAMA LIKE "%'.$DOC_NAMA.'%"
			AND tb_document.DOC_MAKER LIKE "%'.$DOC_MAKER.'%"
			AND tb_document.DOC_APPROVE LIKE "%'.$DOC_APPROVE.'%"
			AND tb_document.DOC_STATUS LIKE "%'.$DOC_STATUS.'%"
			AND tb_user.DN_ID LIKE "%'.$DN_ID.'%"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_SEARCH_DATA_DOCUMENT_ARRAY_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function DB_GET_SEARCH_NEWS_DATA_DOCUMENT_ARRAY_EVO($DOC_AKSES_LEVEL,$DOC_PENGGUNA){

		$result = "";
		try{
			//OLD
			//$this->db->select('*');
			//$this->db->from($this->tb_document);
			//$this->db->like('DOC_ID', $DOC_ID);
			//$this->db->like('DOC_NOMOR', $DOC_NOMOR);
			//$this->db->like('DOC_NAMA', $DOC_NAMA);
			//$this->db->like('DOC_MAKER', $DOC_MAKER);
			//$this->db->like('DOC_APPROVE', $DOC_APPROVE);
			//$this->db->like('DOC_STATUS', $DOC_STATUS);
			//$query = $this->db->get();
			//if ($query->num_rows() > 0) {
			//	return $query->result();
			//}
			//
			//NEW
			$query = $this->db->query('
			SELECT
			tb_document.DOC_ID,
			tb_document.DOC_DATE,
			tb_document.DOC_KATEGORI,
			tb_document.DOC_JENIS,
			tb_document.DOC_TIPE,
			tb_document.DOC_GROUP_PROSES,
			tb_document.DOC_PROSES,
			tb_document.DOC_NOMOR,
			tb_document.DOC_NAMA,
			tb_document.DOC_WUJUD,
			tb_document.DOC_DISTRIBUSI,
			tb_document.DOC_KERAHASIAAN,
			tb_document.DOC_AKSES_LEVEL,
			tb_document.DOC_PENGGUNA,
			tb_document.DOC_PEMILIK_PROSES,
			tb_document.DOC_PENYIMPAN,
			tb_document.DOC_PENDISTRIBUSI,
			tb_document.DOC_VERSI,
			tb_document.DOC_TGL_EFEKTIF,
			tb_document.DOC_PERIODE_PREVIEW,
			tb_document.DOC_TGL_EXPIRED,
			tb_document.DOC_KATA_KUNCI,
			tb_document.DOC_ABSTRAK,
			tb_document.DOC_TERKAIT,
			tb_document.DOC_MAKER,
			tb_document.DOC_APPROVE,
			tb_document.DOC_STATUS,
			tb_document.DOC_NOTE,
			tb_document_structure_kategori.DTSEKI_KATEGORI,
			tb_document_structure_jenis.DTSEJS_JENIS,
			tb_document_structure_tipe.DTSETE_TIPE,
			tb_document_structure_tipe.DTSETE_SINGKATAN,
			tb_document_form.DTFM_NAME,
			tb_distribution_method.DNMD_NAME,
			tb_confidential.CL_NAME,
			tb_user.DN_ID,
			tb_departemen.DN_CODE,
			tb_departemen.DN_NAME,
			tb_divisi.DI_CODE,
			tb_divisi.DI_NAME,
			tb_direktorat.DT_NAME
			FROM
			tb_document
			INNER JOIN tb_document_structure_kategori ON tb_document_structure_kategori.DTSEKI_ID = tb_document.DOC_KATEGORI
			INNER JOIN tb_document_structure_jenis ON tb_document_structure_jenis.DTSEJS_ID = tb_document.DOC_JENIS
			INNER JOIN tb_document_structure_tipe ON tb_document_structure_tipe.DTSETE_ID = tb_document.DOC_TIPE
			INNER JOIN tb_document_form ON tb_document_form.DTFM_ID = tb_document.DOC_WUJUD
			INNER JOIN tb_distribution_method ON tb_distribution_method.DNMD_ID = tb_document.DOC_DISTRIBUSI
			INNER JOIN tb_confidential ON tb_confidential.CL_ID = tb_document.DOC_KERAHASIAAN
			INNER JOIN tb_user ON tb_document.DOC_MAKER = tb_user.UR_ID
			INNER JOIN tb_departemen ON tb_user.DN_ID = tb_departemen.DN_ID
			INNER JOIN tb_divisi ON tb_departemen.DI_ID = tb_divisi.DI_ID
			INNER JOIN tb_direktorat ON tb_divisi.DT_ID = tb_direktorat.DT_ID
			WHERE tb_document.DOC_AKSES_LEVEL LIKE "%'.$DOC_AKSES_LEVEL.'%"
			AND tb_document.DOC_PENGGUNA LIKE "%'.$DOC_PENGGUNA.'%"
			AND tb_document.DOC_STATUS = "PUBLISH"
			');
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_DATABASE][DB_GET_SEARCH_NEWS_DATA_DOCUMENT_ARRAY_EVO]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//