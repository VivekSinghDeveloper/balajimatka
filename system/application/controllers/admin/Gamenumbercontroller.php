<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Gamenumbercontroller extends MY_AdminController {

    public function __construct() {
        parent::__construct();
		if ($this->session->userdata('adminlogin') == 0)
		{
			$allowed = array('login');
			if ( ! in_array($this->router->fetch_method(), $allowed))
			{
				$myurl = base_url() .admin;
				redirect($myurl);
			}
        }  
    }
	
	public function singleDigit()
	{
		if($this->session->userdata('adminlogin') == 1 && $this->session->userdata('admin_type') == 1)
		{
			$this->data['title'] = "Single Digit";
			$this->data['banner_title'] = "Single Digit";
			$this->data['active_menu'] = 'Single Digit';
			$this->data['result']=$this->Adminamodel->getData($this->tb26);
			$this->middle = 'admin/z3'; 
			$this->layout();
		}

		else {

			$myurl = base_url() .admin;

			redirect($myurl);

		}
    }
	 
	public function jodiDigit()
	{
			$this->data['title'] = "Jodi Digit";
			$this->data['banner_title'] = "Jodi Digit";
			$this->data['active_menu'] = 'Jodi Digit';
			$this->data['result']=$this->Adminamodel->getData($this->tb27);
			$this->middle = 'admin/z4'; 
			$this->layout();
		
    }
	
	 public function singlepana()
	{
			$this->data['title'] = "Single Pana";
			$this->data['banner_title'] = "Single Pana";
			$this->data['active_menu'] = 'Single Pana';
			$this->data['result']=$this->Adminamodel->getData($this->tb28);
			$this->middle = 'admin/z5'; 
			$this->layout();
		
    }
	 public function doublepana()
	{
			$this->data['title'] = "Double Pana";
			$this->data['banner_title'] = "Double Pana";
			$this->data['active_menu'] = 'Double Pana';
			$this->data['result']=$this->Adminamodel->getData($this->tb31);
			$this->middle = 'admin/z6'; 
			$this->layout();
		
    }
	 public function tripplepana()
	{
			$this->data['title'] = "Tripple Pana";
			$this->data['banner_title'] = "Tripple Pana";
			$this->data['active_menu'] = 'Tripple Pana';
			$this->data['result']=$this->Adminamodel->getData($this->tb29);
			$this->middle = 'admin/z7'; 
			$this->layout();
		
    }
	
	public function halfsangam()
	{
			$this->data['title'] = "Half Sangam";
			$this->data['banner_title'] = "Half Sangam";
			$this->data['active_menu'] = 'Half Sangam';
			$this->data['result']=$this->Adminamodel->getData($this->tb30);
			$this->middle = 'admin/z8'; 
			$this->layout();
		
    }
	
	public function fullsangam()
	{
			$this->data['title'] = "Full Sangam";
			$this->data['banner_title'] = "Full Sangam";
			$this->data['active_menu'] = 'Full Sangam';
			$this->data['result']=$this->Adminamodel->getData($this->tb32);
			$this->middle = 'admin/z9'; 
			$this->layout();
		
    }
	
	
	
}