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





}