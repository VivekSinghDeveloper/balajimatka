<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class MY_Controller extends CI_Controller 
 { 
    
   var $template  = array();
   var $data      = array();
   function __construct() {
        parent::__construct();
		$this->load->library(array('session','encryption','Capcha','Curl','Volanlib','Volanimage','Volanemail','phpmailer_lib'));
		$this->load->helper(array('url','captcha'));
		$this->load->Model(array('Frontamodel','Frontbmodel','Frontcmodel','Frontdmodel'));
		
	}
	
	public function frontLayout()
	{
		$select = 'facebook,twitter,youtube,google_plus,instagram,';
		$result = $this->Frontamodel->getDataSelect($this->tb19,$select);
		foreach($result as $rs)
		{
			$this->data['facebook'] = $rs->facebook;
			$this->data['twitter'] = $rs->twitter;
			$this->data['youtube'] = $rs->youtube;
			$this->data['google_plus'] = $rs->google_plus;
			$this->data['instagram'] = $rs->instagram;
		}
		
		$this->template['header'] = $this->load->view('layout/header', $this->data, true);
		$this->template['middle'] = $this->load->view($this->middle, $this->data, true);
		$this->template['footer'] = $this->load->view('layout/footer', $this->data, true);
		$this->load->view('layout/index', $this->template);
	}
	public function Layout()
	{
		$select = 'facebook,twitter,youtube,google_plus,instagram,whatsapp_no,mobile_1,email_1';
		$result = $this->Frontamodel->getDataSelect($this->tb19,$select);
		foreach($result as $rs)
		{
			$this->data['facebook'] = $rs->facebook;
			$this->data['twitter'] = $rs->twitter;
			$this->data['youtube'] = $rs->youtube;
			$this->data['google_plus'] = $rs->google_plus;
			$this->data['instagram'] = $rs->instagram;
			$this->data['whatsapp_no'] = $rs->whatsapp_no;
			$this->data['mobile_1'] = $rs->mobile_1;
			$this->data['email_1'] = $rs->email_1;
		}
		
		
		$this->template['header'] = $this->load->view('frontlayout/header', $this->data, true);
		$this->template['middle'] = $this->load->view($this->middle, $this->data, true);
		$this->template['footer'] = $this->load->view('frontlayout/footer', $this->data, true);
		$this->load->view('frontlayout/index', $this->template);
	}
	
	public function loginLayout()
	{
		$this->template['middle'] = $this->load->view($this->middle, $this->data, true);
		$this->load->view('user_layout/index', $this->template);
	}
	public function userLayout()
	{
		$institute_id=$this->session->userdata('institute_id');
		$where=array('institute_id'=>$institute_id);
		$result=$this->Frontamodel->get_data_row($this->tb6,$where);
		$this->data['institute_name']=$result->institute_name;
		$this->data['owner_name'] = $result->owner_name;
		$this->template['header'] = $this->load->view('user_layout/header', $this->data, true);
		$this->template['middle'] = $this->load->view($this->middle, $this->data, true);
		$this->template['footer'] = $this->load->view('user_layout/footer', $this->data, true);
		$this->load->view('user_layout/index', $this->template);
	}
	
	
	
	public function decType($string){
		return $this->encryption->decrypt($string);
	}
	
	public function encType($string){
		return $this->encryption->encrypt($string);
	}
	
	 public function String2Stars($string='',$first=0,$last=0,$rep='*'){
	  $begin  = substr($string,0,$first);
	  $middle = str_repeat($rep,strlen(substr($string,$first,$last)));
	  $end    = substr($string,$last);
	  $num  = $begin.$middle.$end;
	  return $num;
	} 
	
	public function base64Encode($string)
	{
		return base64_encode(strtr($string,'/','/'));
	}
	
	public function base64Decode($string)
	{
		return base64_decode(strtr($string, '._-', '+/='));
	}
	
	function getRandomString($length = 40) 
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
    }
	
	function ifscCode($ifsc)
	{
		$url=('https://ifsc.razorpay.com/'.$ifsc);	
		$data = $this->curl->simple_get($url);
		
			return $data;
		
	}
	
	public function replaceSpace($message)
	{
		return str_replace(" ","%20",$message);
	}
	
	public function sendMessage($mobile,$message)
	{
		
		$url=('http://alerts.prioritysms.com/api/web2sms.php?workingkey=Ae4b1ddb8a9898e0f75b7d41194992fda&to='.$mobile.'&sender=VFRESH&'.'message='.$message);
		$url=('http://2factor.in/API/V1/46882ac9-80b8-11eb-a9bc-0200cd936042/SMS/'.$mobile.'/'.$message);
		$result = $this->curl->simple_get($url); 
		return "1";
	}
	public function getOtp()
	{
		//return rand(1111,9999);
		return '1234';
	}
	
}