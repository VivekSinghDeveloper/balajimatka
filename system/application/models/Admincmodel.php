<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Admincmodel extends CI_Model {
    function __construct() {
        parent::__construct();
		$this->load->database();
    }
	//update query 	  
	function update_where($tb1,$data,$where) {
		
		$this->db->where($where);
		$this->db->set($data);
        $this->db->update($tb1);
	}
	
	function update_where_set($tb,$set,$set_add,$where) {
		
		$this->db->set($set, $set.'+'.$set_add, FALSE);
		$this->db->where($where);
		return $this->db->update($tb);
	}
	
	function update_where_set_minus($tb,$set,$set_add,$where) {
		
		$this->db->set($set, $set.'-'.$set_add, FALSE);
		$this->db->where($where);
		return $this->db->update($tb);
	}
	
}

