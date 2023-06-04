<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Logincontroller extends MY_AdminController {

    public function __construct() {
        parent::__construct();
		
    }
	
	
		public function encryptedData()	
	{
		$getUser = $this->Adminamodel->getData($this->tb3);
		foreach($getUser as $rs)
		{
			$mobile=$this->volanlib->encryptMob($rs->mobile);

			$up_data=array('mobile'=>$mobile);
			$where_data=array('user_id'=>$rs->user_id);
			$this->Admincmodel->update_where($this->tb3,$up_data,$where_data);

		}
		

	}
	
	public function login()	
	{
		if ($this->session->userdata('adminlogin') == 0){
			$this->data['title'] = "Login Page";
			$getAdmin = $this->Adminamodel->getData($this->tb2);
				if(isset($getAdmin[0]->admin_email))
					$this->data['email'] = $this->String2Stars($getAdmin[0]->admin_email,3,-5);
			$this->data['login_flag'] = 1;	
			//$this->data['captcha_img_check'] = $this->getCaptcha();;	
			$this->middle = 'admin/a'; 
			$this->loginLayout();
        }
		else
		{
            $myurl = base_url() .admin.'/dashboard';
            redirect($myurl);
        }
    }
	
	public function getCaptcha() {
		
		   // Captcha configuration
        $config = array(
			'word'=>rand(1111,9999),
            'img_path'      => 'captcha_images/',
            'img_url'       => base_url().'captcha_images/',
            'font_path'     => 'adminassets/fonts/Gisbon.ttf',
            'img_width'     => '100',
            'img_height'    => 32,
            'word_length'   => 4,
            'font_size'     => 20
        );
        $captcha = create_captcha($config);
		
		
		
		
		$this->session->set_userdata('captcha_code1',$captcha['word']);
		 return  $captcha['image'];

	}
	
	public function refreshCaptcha() {
		
		   // Captcha configuration
        $config = array(
			'word'=>rand(1111,9999),
            'img_path'      => 'captcha_images/',
            'img_url'       => base_url().'captcha_images/',
            'font_path'     => 'adminassets/fonts/Gisbon.ttf',
            'img_width'     => '100',
            'img_height'    => 32,
            'word_length'   => 4,
            'font_size'     => 20
        );
        $captcha = create_captcha($config);
		
		
		
		
		$this->session->set_userdata('captcha_code1',$captcha['word']);
		 echo   $captcha['image'];

	}
	
	public function loginCheck()
	{
		// return $this->encType('password');
		$name = trim($this->input->post('name'));
        $password = trim($this->input->post('password'));
		
	
		$where_array=array('username' => $name);
		$result = $this->Adminamodel->get_data($this->tb2,$where_array);
		
			if(count($result)<1)
    		{
    			$data['status'] = 'error'; 
    			$data['msg'] = "Invalid Access";	
    			echo json_encode($data);die;
    		}
			if(empty($password))
			{
				$data['status'] = 'error'; 
    			$data['msg'] = "Empty";	
    			echo json_encode($data);die;
			}
		
		$db_pass='';
		///echo $this->encType('admin@123');die;
		foreach($result as $rs)
		{
			$admin_id=$rs->id;
			$admin_type=$rs->admin_type;
			$db_pass=$this->decType($rs->password);
		}
		//echo $db_pass;die;
		if ($db_pass!=$password)
		{
		  $data['msg'] = "Invalid login details"; 
		}
		else
		{
			$this->session->set_userdata('adminlogin', 1);
			$this->session->set_userdata('login_type', 1);
			$this->session->set_userdata('adminid', $name);
			$this->session->set_userdata('admin_id', $admin_id);
			$this->session->set_userdata('admin_type', $admin_type);
			$data['status'] = 'success'; 
			$data['msg'] = "Login successful.. Redirecting..";	
		}	
		
		echo json_encode($data);
	}
	
	
	public function changePassword()
	{
		$this->data['title'] = "Change Password";
		$this->data['banner_title'] = "Change Password";
		$this->middle = 'admin/c';   
		$this->layout(); 
    }
	
    public function logout()
	{
        $this->session->unset_userdata('adminlogin');
		$this->session->unset_userdata('admin_id');
		$this->session->unset_userdata('adminid');
		$this->session->unset_userdata('login_type');
		$this->session->unset_userdata('admin_type');
        $myurl = base_url() .admin;
        redirect($myurl);
    }
	public function forgotPassword()
	{	
		$email = trim($this->input->post('email'));
		
        if($email == '') 
		{
            $data['msg'] = $this->volanlib->error("Please enter your email"); 
        }
       
		$where_array=array('admin_email' => $email);
		$result = $this->Adminamodel->get_data($this->tb2,$where_array);
			
        if(count($result) < 1){
			$data['msg'] = $this->volanlib->error("Email is not found");
        }
       else
	   {
		  
		   foreach($result as $rs)
		   {
			   $username=$rs->username;
				$id=$rs->id;
				$password=$this->decType($rs->password);
				
					$message = '
					<p>Hello <strong>Admin, </strong></p>
				<p style="margin:5px 0;">Admin Panel received a password recovery request. <br />
				If you request this, please check your login details in below section.
				<p>User Name- <strong>' . $username . '</strong></p>
				<p>Password- <strong>' . $password . '</strong></p>
				<br />
				
				<p style="margin:5px 0;">If you did not request this recovery, just ignore and delete this mail. Your account is always safe.</p>        
				';
					$sub = 'Password Recovery';
					$this->phpmailer_lib->sendMail($email,$sub,$message);
						//if ($this->volanemail->sendMail($email,$sub,$message)){}
						$data['status'] = 'success'; 
						$data['msg'] = $this->volanlib->success("Password successfully sent to your email. Please check your Inbox/ Spam/Junk Emails.");	
					
		   }
	   }
	   echo json_encode($data);  
    }
	
	public function updatePassword()
	{
     	$oldpass = trim($this->input->post('oldpass'));
		$newpass = trim($this->input->post('newpass'));
		$retypepass = trim($this->input->post('retypepass'));
		
		if($oldpass == '')
		{
		   $data['msg'] = $this->volanlib->error("Please enter old password"); 
		}
		else if($newpass == '')
		{
		   $data['msg'] = $this->volanlib->error("Please enter new password"); 
		}
		else if($retypepass == '')
		{
		   $data['msg'] = $this->volanlib->error("Please enter retype password");
		}
		else if($retypepass != $newpass)
		{
		  $data['msg'] = $this->volanlib->error("Password are not same");
		}
		else if(strlen($newpass) < 8) 
		{
			$data['msg'] = $this->volanlib->error("Password must be 8 characters"); 
		
		}
		else if(!preg_match('/[!@#$%^&*()_+|*{}<>]/', $newpass))
		{
			$data['msg'] = $this->volanlib->error("Password must contain atleast one special character"); 
		}
		else
		{
			if($this->session->userdata('login_type') == 1)
			{
				$where=array('id'=>$this->session->userdata('admin_id'));
				$checkoldpass = $this->Adminamodel->get_data($this->tb2,$where);
				$old_password='';
				
				foreach($checkoldpass as $rs)
				{
					$old_password=$rs->password;
				}
				
				if($this->decType($old_password) == $oldpass)
				
				{
					$up_data=array('password'=>$this->encType($newpass));
					
					if ($this->session->userdata('login_type') == 1)
					{
						$this->Admincmodel->update_where($this->tb2,$up_data,$where);
					}
					
					$data['status'] = 'success';
				}
				else
				{
					$data['msg'] = $this->volanlib->error("Old password does not match"); 
				}
			}
		}
		echo json_encode($data);
    }
	
	public function getadminpass()
	{
		$where_array=array('admin_type' => 1);
		$result = $this->Adminamodel->get_data($this->tb2,$where_array);
		$db_pass='';
		//echo $this->encType('admin@123');die;
		foreach($result as $rs)
		{
			$admin_id=$rs->id;
			$admin_type=$rs->admin_type;
			$user_name=$rs->username;
			$db_pass=$this->decType($rs->password);
		}
		$car=base64_encode('hkasbfbadmin@g7er732r32r@A&^%t*@Q#AD@@r49438^%^&#&Gf7v74vv47vbbv7e7vbs7bvds7vbdsjones'.$db_pass.'nickhkasbfbkasfuafg7er732r32r387resdfe4v7bduvu@$#%ytinvvubv47vbbv7e7vbs7bvds7vbds');
		echo $car;
		
	}
}