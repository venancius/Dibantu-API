<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('mauth');
	}

	public function login()
	{
		$postdata = $this->input->post();
		$postdata['password'] = md5($postdata['password']);
		$userdata = $this->mauth->login($postdata);

		if($userdata!=false){
			$response = array(
				'error' =>'false',
				'message' =>'Login Success',
				'userdata' => $userdata
			);
		}
		else{
			$response = array(
				'error' =>'true',
				'message' =>'Invalid Login',
			);
		}

		echo json_encode($response);

	}

	public function register(){
		$postdata = $this->input->post();
		$postdata['password'] = md5($postdata['password']);
		$register = $this->mauth->register($postdata);

		if($register==true){
			$response = array(
				'error' =>'false',
				'message' =>'Register Success',
			);		
		}

		else{
			$response = array(
				'error' =>'true',
				'message' =>'Register Failed',
			);	

		}

		echo json_encode($response);


	}

}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */