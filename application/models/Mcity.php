<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mcity extends CI_Model {

	public function getlist(){
		$citylist = $this->db->get('city')->result();

		if($citylist){
			return $citylist;
		}
		else return false;
	}

	public function getsingle($id){
		$city = $this->db->get_where('city',array('id'=>$id))->row();

		if($city){
			return $city;
		}
		else return false;
	}

}

/* End of file mcity.php */
/* Location: ./application/models/mcity.php */