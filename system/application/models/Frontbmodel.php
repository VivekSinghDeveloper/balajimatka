<?php

class Frontbmodel extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
    }
	
	public function insertData($tb,$data)
	{	
		
		$this->db->insert($tb,$data);
		
	}
}





