<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mauth extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('maccount');
	}

	public function login($logindata){

		$role = $logindata['role'];
		unset($logindata['role']);
		switch ($role) {
			case 'user':

				$statement = $this->db->get_where('user',$logindata);

				break;
			case 'worker':

				$statement = $this->db->get_where('worker', $logindata);

				break;
			default:
				# code...
				break;
		}

		if($statement->num_rows()>0){
			switch ($role) {
				case 'user':
					
					$data = $this->maccount->getUserProfile($statement->row()->id);

					break;
				case 'worker':
					$data = $this->maccount->getWorkerProfile($statement->row()->id);
					break;

			}
			return $data;
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