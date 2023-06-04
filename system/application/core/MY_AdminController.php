<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_AdminController extends CI_Controller
{
	var $template  = array();
	var $data      = array();

	function __construct()
	{
		parent::__construct();
		$this->load->library(array('session', 'pagination', 'encryption', 'Volanlib', 'Volanemail', 'Volanimage', 'Curl', 'phpmailer_lib'));
		$this->load->helper('url');
		$this->load->helper('security');
		$this->load->helper('file');
		$this->load->helper('download');
		$this->load->library('zip');
		$this->load->helper('captcha');

		$this->load->Model(array('Adminamodel', 'Adminbmodel', 'Admincmodel', 'Admindmodel'));
	}

	public function custom_curl($url)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$data = curl_exec($ch);

		if (curl_errno($ch)) {
			print "Error: " . curl_error($ch);
		} else {
			$transaction = json_decode($data, TRUE);
			curl_close($ch);
			return  $transaction['rates']['INR'];
		}
	}

	public function layout()
	{
		$this->data['admin_type'] = $this->session->userdata('admin_type');

		$this->template['header'] = $this->load->view('admin_layout/header', $this->data, true);
		$this->template['middle'] = $this->load->view($this->middle, $this->data, true);
		$this->template['footer'] = $this->load->view('admin_layout/footer', $this->data, true);
		$this->load->view('admin_layout/index', $this->template);
	}

	public function loginLayout()
	{
		$this->template['middle'] = $this->load->view($this->middle, $this->data, true);
		$this->load->view('admin_layout/index', $this->template);
	}

	public function randToken()
	{
		$randAlpha = substr(str_shuffle("ABCDEFGHIJKLMNOPQURSTUVWXYZ"), 0, 2);
		$randNum = rand(1111, 9999);
		$token = $randAlpha . $randNum;
		return $token;
	}

	public function decType($string)
	{
		return $this->encryption->decrypt($string);
	}

	public function encType($string)
	{
		return $this->encryption->encrypt($string);
	}

	public function String2Stars($string = '', $first = 0, $last = 0, $rep = '*')
	{
		$begin  = substr($string, 0, $first);
		$middle = str_repeat($rep, strlen(substr($string, $first, $last)));
		$end    = substr($string, $last);
		$email  = $begin . $middle . $end;
		return $email;
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

	function random_num($length)
	{
		$alphabets = range('A', 'Z');
		$numbers = range('0', '9');

		$final_array = array_merge($alphabets, $numbers);

		$password = '';

		while ($length--) {
			$key = array_rand($final_array);
			$password .= $final_array[$key];
		}

		return $password;
	}

	function ifscCode($ifsc)
	{
		$url = ('https://ifsc.razorpay.com/' . $ifsc);
		$data = $this->curl->simple_get($url);
		return $data;
	}

	public function replaceSpace($message)
	{
		return str_replace(" ", "%20", $message);
	}

	public function sendMessage($mobile, $message)
	{

		//$url=('http://alerts.prioritysms.com/api/web2sms.php?workingkey=Ae4b1ddb8a9898e0f75b7d41194992fda&to='.$mobile.'&sender=VFRESH&'.'message='.$message);
		// $url=('http://2factor.in/API/V1/46882ac9-80b8-11eb-a9bc-0200cd936042/SMS/'.$mobile.'/'.$message);
		//fast2sms
		$url = ('https://www.fast2sms.com/dev/bulkV2?authorization=ClbnHeWRjPsFYwv4iQ37NfDk6pKo2A0TtMGd5B9hIOaJmrZuE88g6os0nYXzOQe5pv73ctIqmrxPdZK1&route=otp&variables_values=' . $message . '&flash=0&numbers=' . $mobile);
		$result = $this->curl->simple_get($url);
		return "1";
	}

	public function randomNumber()
	{
		return mt_rand(100000, 999999);
	}

	public function getOtp()
	{
		return rand(1111, 9999);
		//return '1234';
	}
}
