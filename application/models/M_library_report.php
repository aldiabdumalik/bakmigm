<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_library_report extends CI_Model {

	public function GET_COMMENT($DOC_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from('tb_document_comment');
			$this->db->join('tb_document', 'tb_document_comment.DOC_ID = tb_document.DOC_ID', 'left');
			$this->db->where('tb_document_comment.DOC_ID', $DOC_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_REPORT][GET_COMENTAR]".$error;
		}
		return $result;
	}

	public function GET_DOCUMENT($DOC_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from('tb_document');
			$this->db->join('tb_document_structure_kategori', 'tb_document.DOC_KATEGORI = tb_document_structure_kategori.DTSEKI_ID', 'left');
			$this->db->join('tb_document_structure_jenis', 'tb_document.DOC_JENIS = tb_document_structure_jenis.DTSEJS_ID', 'left');
			$this->db->join('tb_document_structure_tipe', 'tb_document.DOC_TIPE = tb_document_structure_tipe.DTSETE_ID', 'left');
			$this->db->where('tb_document.DOC_ID', $DOC_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_REPORT][GET_DOCUMENT]".$error;
		}
		return $result;
	}

	public function GET_DOCUMENT_REVISI($DOC_ID)
	{
		$result = "";
		try {
			$this->db->select('*');
			$this->db->from('tb_document');
			$this->db->join('tb_document_structure_kategori', 'tb_document.DOC_KATEGORI = tb_document_structure_kategori.DTSEKI_ID', 'left');
			$this->db->join('tb_document_structure_jenis', 'tb_document.DOC_JENIS = tb_document_structure_jenis.DTSEJS_ID', 'left');
			$this->db->join('tb_document_structure_tipe', 'tb_document.DOC_TIPE = tb_document_structure_tipe.DTSETE_ID', 'left');
			$this->db->join('tb_document_detail_status', 'tb_document.DOC_ID = tb_document_detail_status.DOC_ID', 'left');
			$this->db->where('tb_document.DOC_ID', $DOC_ID);
			$query = $this->db->get();
			if ($query->num_rows() > 0) {
				return $query->result();
			}
		} catch (Exception $exc) {
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_REPORT][GET_DOCUMENT_REVISI]".$error;
		}
		return $result;
	}

}

/* End of file M_library_report.php */
/* Location: ./application/models/M_library_report.php */