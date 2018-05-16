<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mworker extends CI_Model {

	public function getTopFive($category_id,$city_id){

		$object = array(
			"skill_category" => $category_id,
			"id_city" => $city_id
		);

		$workers = $this->db->get_where('worker',$object)->result();

		if($workers){
			$BARS = array();

			foreach($workers as $worker){
				$accept_count = $worker->accept_count;

				$rate = $worker->rate;

				$score = $rate + $accept_count;

				$BARS[] = array("id"=>$worker->id,"score"=>$score);
			}

			foreach ($BARS as $key => $row) {
			    $volume[$key]  = $row['id'];
			    $edition[$key] = $row['score'];
			}

			// Sort the data with volume descending, edition ascending
			// Add $data as the last parameter, to sort by the common key
			array_multisort($edition, SORT_DESC, $BARS);
			$BARS = array_slice($BARS, 0,5);

			$topfive = array();
			foreach($BARS as $key=>$value){
				$topfive[$key]=$value['id'];
			}
		}

		else{
			$topfive = array("0");
		}

		return $topfive;

	}

}

/* End of file mworker.php */
/* Location: ./application/models/mworker.php */