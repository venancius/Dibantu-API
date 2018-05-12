<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcity');
	}

	public function getlist(){
		$citylist = $this->mcity->getlist();

		if($citylist!=false){
			$response = array(
				'error' => 'false', 
				'message' => 'City List',
				'citydata' => $citylist
			);
		}

		else{
			$response = array(
				'error' => 'true', 
				'message' => 'Failed Getting City List'
			);			
		}

		echo json_encode($response);

	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */