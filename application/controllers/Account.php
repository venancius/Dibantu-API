<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('maccount');
		$this->load->model('mcity');
	}

	public function getUserProfile(){
		$postdata = $this->input->post();
		$userdata = $this->maccount->getUserProfile($postdata['id_user']);

		$city_id = $userdata->id_city;

		$citydata = $this->mcity->getsingle($city_id);


		if($userdata){
			$response = array(
				"error"=>"false",
				"message"=>"get User Profile Success",
				"userdata" =>$userdata,
				"citydata" =>$citydata

			);
		}
		else{
			$response = array(
				"error"=>"true",
				"message"=>"User Not Found"
			);
		}
		echo json_encode($response);

	}

    public function uploadImage(){

    		$file = $this->input->post('userfile');
    		$id = $this->input->post('id');
    		$role = $this->input->post('role');

            $config['upload_path']          = './uploads/';
            $config['allowed_types']        = 'jpg|png|jpeg';
            $config['max_size']             = 5000000;
            $config['max_width']            = 10240;
            $config['max_height']           = 7680;

            $this->load->library('upload', $config);

            if ( ! $this->upload->do_upload('userfile'))
            {

                    $error = array('error' => $this->upload->display_errors(),"file"=>$uploaddata);

                    echo json_encode($error);
            }
            else
            {
            	    $uploaddata = $this->upload->data();
                    $data = array('error'=>"false",'upload_data' => $this->upload->data());


                    $this->db->set('picture',$uploaddata['orig_name']);
                    $this->db->where('id',$id);

                    if($role =='user'){
                    	$this->db->update('user');
                    }

                    else if($role =='worker'){
                    	$this->db->update('worker');
                    }

                    echo json_encode($data);
            }
    }
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */