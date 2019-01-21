<?php
//-----------------------------------------------------------------------------------------------//
defined('BASEPATH') OR exit('No direct script access allowed');
//-----------------------------------------------------------------------------------------------//
class M_library_module extends CI_Model {
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public $WEB_TITLE = "BGM EDOCUMENT";
	public $WEB_ICON = "GM_favicon.ico";
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	public function CLEAN_DATA($data){
		$result = "";
		try{
			$result = preg_replace("/[\n\r]/","",$data);
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_MODULE][CLEAN_DATA]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function CLEAN_STRING($data){
		$result = "";
		try{
			$result = preg_replace("/[^0-9]/","",$data);
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_MODULE][CLEAN_STRING]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function CLEAN_NUMBER($data){
		$result = "";
		try{
			$result = preg_replace("/\d+/u","",$data);
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_MODULE][CLEAN_NUMBER]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function GENERATOR_REFF(){
		$result = "";
		try{
			//yyMMddHHmmss1234512
			$result = date('ymdHis').rand(11111,99999).rand(11,99);
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_MODULE][GENERATOR_REFF]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function KODE_GENERATOR(){
		$result = "";
		try{
			$result = rand(11111,99999);
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_MODULE][KODE_GENERATOR]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function GET_XML_VALUE($data,$pad){
		$result = "";
		try{
			$pad_start = "<".$pad.">";
			$pad_end = "</".$pad.">";
			if(	stristr($data,$pad_start)!==false&&
				stristr($data,$pad_end)!==false
			){
				$pad_1 = explode($pad_start,$data);
				$pad_2 = explode($pad_end,$pad_1[1]);
				$result = $pad_2[0];
			}
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_MODULE][GET_XML_VALUE]".$error;
		}		
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function CONVERT_CURRENCY($data){
		$result = "";
		try{
			$format = number_format((double)$data,0,'.','.');
			$result = $format;
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_MODULE][CONVERT_CURRENCY]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function CONVERT_RUPIAH($data){
		$result = "";
		try{
			$format = number_format((double)$data,0,'.','.');
			$result = "Rp ".$format;
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_MODULE][CONVERT_RUPIAH]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function CONVERT_DATE_INPUT_TO_DB($data){
		$result = "";
		try{
			//SAMPLE:
			//dd/mm/yyyy
			//TO
			//2018-11-05
			$array_data = explode("/",$data);
			$result = $array_data[2]."-".str_pad($array_data[1],2,"0",STR_PAD_LEFT)."-".str_pad($array_data[0],2,"0",STR_PAD_LEFT);
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_MODULE][CONVERT_DATE_INPUT_TO_DB]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	public function CONVERT_DATE_DB_TO_INPUT($data){
		$result = "";
		try{
			//SAMPLE:
			//2018-11-05
			//TO
			//dd/mm/yyyy
			$array_data = explode("-",$data);
			$result = str_pad($array_data[2],2,"0",STR_PAD_LEFT)."/".str_pad($array_data[1],2,"0",STR_PAD_LEFT)."/".$array_data[0];
		}catch(Exception $exc){
			$error = $exc->getMessage();
			echo "[ERROR][M_LIBRARY_MODULE][CONVERT_DATE_INPUT_TO_DB]".$error;
		}
		return $result;
	}
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
	//-----------------------------------------------------------------------------------------------//
}
//-----------------------------------------------------------------------------------------------//