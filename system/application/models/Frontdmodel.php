<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Frontdmodel extends CI_Model {
    function __construct() {
        parent::__construct();
		$this->load->database();
    }
	
	function delete($tb,$where_array)
	{
		$this->db->delete($tb,$where_array);
	}
	
}
