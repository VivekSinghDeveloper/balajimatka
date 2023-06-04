<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Volanimage {
	
	public function __construct() 
		{
			$CI =& get_instance();
			$CI->curr_date=date('Y-m-d h:i:s');
		}
	public function upload_image($path,$file)
	{	
		$newfilename = rand() * time();
		if ((!empty($file)) && ($file['error'] == 0)) 
		{
			$filename = strtolower(basename($file['name']));
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$ext = strtolower($ext);
			$filename=$newfilename.'.'.$ext;
			
				$ext = "." . $ext;
				$newname = $path. $filename;
				if (move_uploaded_file($file['tmp_name'], $newname) or die('file not exits')) {
				}
				return  $filename;
			 
		}
	}
	
	public function upload_file($path,$file)
	{	
		if ((!empty($file)) && ($file['error'] == 0)) 
		{
			$basename =  pathinfo($file['name'], PATHINFO_FILENAME);
			$newfilename = preg_replace('/[^a-zA-Z0-9\/_|+ -]/',' ' ,$basename);
			$newfilename = strtolower(trim($newfilename, '-'));
			$newfilename = preg_replace("/[\/_|+ -]+/",'-', $newfilename);
			$newfilename=trim($newfilename,"-");
			
			$filename = strtolower(basename($file['name']));
			$ext = substr($filename, strrpos($filename, '.') + 1);
			$ext = strtolower($ext);
			
			$filename=$newfilename.'.'.$ext;
			
				$ext = "." . $ext;
				$newname = $path. $filename;
				if (move_uploaded_file($file['tmp_name'], $newname) or die('file not exits')) {
				}
				return  $filename;
			 
		}
	}
	
}