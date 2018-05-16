<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mjobs extends CI_Model {

	public function getlist($data){

		$this->db->select('jobs.*, worker.name as workername, user.name as username, worker.picture as workerpicture, user.picture as userpicture,category.name as categoryname');
		$this->db->where('jobs.status',0);
		if(isset($data['id_user'])){
		$this->db->where('jobs.id_user', $data['id_user']);			
		}
		else if(isset($data['id_worker'])){
		$this->db->where('jobs.id_worker', $data['id_worker']);			
		}


		$this->db->join('category', 'jobs.id_category = category.id', 'left');
		$this->db->join('user', 'jobs.id_user = user.id', 'left');
		$this->db->join('worker', 'jobs.id_worker = worker.id', 'left');
		$this->db->order_by('id','DESC');
		$activejobs = $this->db->get('jobs')->result();

		$this->db->select('jobs.*, worker.name as workername, user.name as username, worker.picture as workerpicture, user.picture as userpicture,category.name as categoryname');
		$this->db->where('jobs.status',1);
		if(isset($data['id_user'])){
		$this->db->where('jobs.id_user', $data['id_user']);			
		}
		else if(isset($data['id_worker'])){
		$this->db->where('jobs.id_worker', $data['id_worker']);			
		}


		$this->db->join('category', 'jobs.id_category = category.id', 'left');
		$this->db->join('user', 'jobs.id_user = user.id', 'left');
		$this->db->join('worker', 'jobs.id_worker = worker.id', 'left');
		$this->db->order_by('id','DESC');
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

	public function takejob($id_worker,$id_job){
		$this->db->set('id_worker',$id_worker);
		$this->db->set('accept_count','accept_count+1');
		$this->db->where('id', $id_job);
		$statement = $this->db->update('jobs');

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
			$this->db->select('jobs.*, user.name as name,category.name as categoryname,user.phone as phone,user.picture as picture');
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
			"jobs.id_city" => $id_city,
			"jobs.id_category" =>$id_category,
			"jobs.status"=>0,
			"jobs.id_worker"=>0
		);

		$this->db->select('jobs.*, worker.name as workername, user.name as username, worker.picture as workerpicture, user.picture as userpicture,category.name as categoryname');
		$this->db->join('category', 'jobs.id_category = category.id', 'left');
		$this->db->join('user', 'jobs.id_user = user.id', 'left');
		$this->db->join('worker', 'jobs.id_worker = worker.id', 'left');
		$this->db->order_by('id','DESC');
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

	public function finishjob($id,$rate,$feedback){
		$this->db->set('status',1);
		$this->db->set('rate',$rate);
		$this->db->set('feedback',$feedback);
		$this->db->where('id', $id);
		$update = $this->db->update('jobs');

		$jobdata = $this->db->get_where('jobs',array('id'=>$id))->row();
		$id_worker = $jobdata->id_worker;

		$workerdata = $this->db->get_where('worker',array('id'=>$id_worker))->row_array();
		$worker_rate = $workerdata['rate'];
		$worker_rate_count = $workerdata['rate_count'];
		$new_rate_count =$worker_rate_count+1;

		$new_rate = (($worker_rate*$worker_rate_count) + $rate)/$new_rate_count;

		$this->db->set('rate',$new_rate);
		$this->db->set('rate_count',$new_rate_count);
		$this->db->where('id',$id_worker);
		$updateall = $this->db->update('worker');


		if($updateall){
			return true;
		}
		else return false;

	}

}

/* End of file modelName.php */
/* Location: ./application/models/modelName.php */