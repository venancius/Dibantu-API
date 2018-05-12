<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcategory extends CI_Model {

	public function getlist(){

		$data = $this->db->get('category')->result();

		if($data){
			return $data;
		}

		else return false;

	}

}

/* End of file modelName.php */
/* Location: ./application/models/modelName.php */