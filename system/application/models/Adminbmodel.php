<?php
class Adminbmodel extends CI_Model {

    function __construct() {
        parent::__construct();
		$this->load->database();
    }
	
	public function insertData($data,$tb1)
	{	
		$this->db->insert($tb1,$data);
	}
	public function importData($data,$table) {
 
        $res = $this->db->insert_batch($table,$data);
        if($res){
            return TRUE;
        }else{
            return FALSE;
        }
 
    }
}

