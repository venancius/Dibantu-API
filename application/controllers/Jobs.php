<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('mjobs');
		$this->load->model('mworker');
		$this->load->model('maccount');
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

		$id_category = $postdata['id_category'];
		$id_city = $postdata['id_city'];

		$topfiveworker = $this->getTopFiveWorker($id_category,$id_city);
		$postdata['exclusive_worker'] = implode(",", $topfiveworker);

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

		echo json_encode($topfiveworker);
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

	public function getTopFiveWorker($category_id,$city_id){

		$data = $this->mworker->getTopFive($category_id,$city_id);

		return $data;

	}

	public function getAvailableJobs(){

		$postdata = $this->input->post();

		$id_worker = $postdata['id_worker'];

		$workerdata = $this->maccount->getWorkerProfile($id_worker);
		$workercity = $workerdata->id_city;
		$workercategory = $workerdata->skill_category;

		$availablejobs = $this->mjobs->getAvailableJobs($id_worker,$workercity,$workercategory);

		echo json_encode($availablejobs);

	}

	public function finishJob(){

		$postdata = $this->input->post();
		$update = $this->mjobs->finishjob($postdata['id_jobs'],$postdata['rate'],$postdata['feedback']);

		if($update!=false){
			$response = array(
				"error" =>'false',
				"message" => 'Success',
			);
		}
		else{
			$response = array(
				"error" =>'true',
				"message" => 'Failed'
			);
		}

		echo json_encode($response);
	}

	public function updateExclusiveWorker(){

		$query = $this->db->query("update jobs set exclusive_worker='0' where created_at < DATE_SUB(NOW(), INTERVAL 30 MINUTE)");

		if($query){
			$response = array(
				"error" =>'false',
				"message" => 'Exclusive worker updated',
			);
		}
		else{
			$response = array(
				"error" =>'true',
				"message" => 'Exclusive worker update failed'
			);
		}

		echo json_encode($response);

	}

}

/* End of file jobs.php */
/* Location: ./application/controllers/jobs.php */