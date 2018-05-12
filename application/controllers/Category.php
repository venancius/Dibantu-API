<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mcategory');
	}

	public function getlist()
	{
		$data = $this->mcategory->getlist();

		if($data!=false){
			$response = array(
				"error" =>'false',
				"message" => 'Success',
				"allcategory" => $data
			);
		}
		else{
			$response = array(
				"error" =>'true',
				"message" => 'No data',
			);
		}

		echo json_encode($response);

	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */