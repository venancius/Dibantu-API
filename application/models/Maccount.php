<?php

class Maccount extends CI_Model {
	function getUserProfile($id)
	{
		$this->db->where('id', $id);
		$query = $this->db->get('user')->result();
		if (count($query) ==0)
		{
			$return['statuscode']=3012;
        	$return['message']="user not found";
        	return $return;
		}else{
			return $query[0];
		}
	}

	function setUserProfile($userid,$data)
	{
		$this->db->where('id', $userid);
		$x=$this->db->update('ai.ai_user',$data);

		$return['statuscode']=200;
        $return['message']="profile updated";
        $return["data"]=$data;
        return $return;
	}


}