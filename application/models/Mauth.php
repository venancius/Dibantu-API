<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mauth extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('maccount');
	}

	public function login($logindata){

		switch ($logindata['role']) {
			case 'user':
				unset($logindata['role']);
				$statement = $this->db->get_where('user',$logindata);

				break;
			case 'worker':
				unset($logindata['role']);
				$statement = $this->db->get_where('worker', $logindata);

				break;
			default:
				# code...
				break;
		}

		if($statement->num_rows()>0){
			return $this->maccount->getUserProfile($statement->row()->id);
		}
		else{
			return false;
		}


	}

	public function register($regdata){

		switch ($regdata['role']) {
			case 'user':
				unset($regdata['role']);
				$statement = $this->db->insert('user', $regdata);

				break;
			case 'worker':
				unset($regdata['role']);
				$statement = $this->db->insert('worker', $regdata);

				break;
			default:
				# code...
				break;
		}

		if($statement){
			return true;
		}
		else{
			return false;
		}


	}

}

/* End of file modelName.php */
/* Location: ./application/models/modelName.php */