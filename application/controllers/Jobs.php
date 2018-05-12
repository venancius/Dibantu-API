<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('mjobs');
	}

	public function getlist(){

		$postdata = $this->input->post();
		$data = $this->mjobs->getlist($postdata);

		foreach($data['activejobs'] as $key=>$value){
			if($value->id_worker==0){
				$data['activejobs'][$key]->workername='Finding Worker';
			}
		}

		if($data!=false){
			$response = array(
				"error" =>'false',
				"message" => 'Success',
				"activejobs" => $data['activejobs'],
				"historyjobs" => $data['historyjobs']
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

	public function inputjob(){
		$postdata = $this->input->post();

		$data = $this->mjobs->inputjob($postdata);

		if($data==true){
			$response = array(
				"error" =>'false',
				"message" => 'Job Inserted',
			);
		}
		else{
			$response = array(
				"error" =>'true',
				"message" => 'Failed to insert job',
			);
		}

		echo json_encode($response);
	}

	public function getsingle(){
		$postdata = $this->input->post();

		$data = $this->mjobs->getsingle($postdata);

		if($data!=false){
			$response = array(
				"error" =>'false',
				"message" => 'Success',
				"jobdata" =>$data
			);
		}
		else{
			$response = array(
				"error" =>'true',
				"message" => 'No data'
			);
		}

		echo json_encode($response);
	}

}

/* End of file jobs.php */
/* Location: ./application/controllers/jobs.php */