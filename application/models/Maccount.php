<?php

class Maccount extends CI_Model {
	function getUserProfile($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('user')->result();
		if (count($query) ==0)
		{
			return false;
		}else{
			return $query[0];
		}
	}

	function getWorkerProfile($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('worker')->result();
		if (count($query) ==0)
		{
			return false;
		}else{
			return $query[0];
		}
	}

	function setUserProfile($data){

		$object = array(
			"name" => $data['name'],
			"phone" => $data['phone'],
			"email" => $data['email']
		);

		$this->db->where('id',$data['id']);
		$update = $this->db->update('user', $object);

		if($update){
			return true;
		}
		else return false;

	}

		function setWorkerProfile($data){

		$object = array(
			"name" => $data['name'],
			"phone" => $data['phone'],
			"email" => $data['email']
		);

		$this->db->where('id',$data['id']);
		$update = $this->db->update('worker', $object);

		if($update){
			return true;
		}
		else return false;

	}




}