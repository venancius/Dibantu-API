<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mjobs extends CI_Model {

	public function getlist($data){

		$this->db->select('jobs.*, worker.name as workername, user.name as username, worker.picture as workerpicture, user.picture as userpicture,category.name as categoryname');
		$this->db->where('jobs.status',0);

		$this->db->join('category', 'jobs.id_category = category.id', 'left');
		$this->db->join('user', 'jobs.id_user = user.id', 'left');
		$this->db->join('worker', 'jobs.id_worker = worker.id', 'left');

		$activejobs = $this->db->get('jobs')->result();

		$this->db->select('jobs.*, worker.name as workername, user.name as username, worker.picture as workerpicture, user.picture as userpicture,category.name as categoryname');
		$this->db->where('jobs.status',1);

		$this->db->join('category', 'jobs.id_category = category.id', 'left');
		$this->db->join('user', 'jobs.id_user = user.id', 'left');
		$this->db->join('worker', 'jobs.id_worker = worker.id', 'left');

		$historyjobs = $this->db->get('jobs')->result();


		$alljobs = array('activejobs'=>$activejobs,'historyjobs'=>$historyjobs);

		if($data){
			return $alljobs;
		}

		else return false;

	}

	public function inputjob($data){

		$statement = $this->db->insert('jobs', $data);

		if($statement){
			return true;
		}
		else return false;


	}

	public function getsingle($data){

		if($data['role'] == 'user'){
			$this->db->select('jobs.*, worker.name as name,category.name as categoryname,worker.phone as phone,worker.picture as picture,worker.rate');
			$this->db->join('worker', 'jobs.id_worker = worker.id', 'left');
		}

		else if($data['role'] == 'worker'){
			$this->db->select('jobs.*, user.name as name,user.phone as phone,user.picture as picture');
			$this->db->join('user', 'jobs.id_user = user.id', 'left');
		}

		$this->db->join('category', 'jobs.id_category = category.id', 'left');
		$this->db->where('jobs.id', $data['id_jobs']);
		$jobdata = $this->db->get('jobs')->row();;


		if($jobdata){
			return $jobdata;
		}
		else return false;


	}

	public function getAvailableJobs($id,$id_city,$id_category){

		$data = array(
			"id_city" => $id_city,
			"id_category" =>$id_category,
			"status"=>0,
			"id_worker"=>0
		);

		$jobs = $this->db->get_where('jobs', $data)->result_array();

		foreach ($jobs as $key=>$value) {
			if($value['exclusive_worker']!=0){
				$exclusive_worker = explode(",",$value['exclusive_worker']);

				if(!in_array($id, $exclusive_worker)){
					unset($jobs[$key]);
				}

			}
		}

		if($jobs){
			return $jobs;
		}

		else return false;

	}

	public function finishjob($id){
		$this->db->set('status',1);
		$this->db->where('id', $id);
		$update = $this->db->update('jobs');

		if($update){
			return true;
		}
		else return false;

	}

}

/* End of file modelName.php */
/* Location: ./application/models/modelName.php */