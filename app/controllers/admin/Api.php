<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends AdminBase {
	function __construct()
	{
		parent::__construct();
	}	
	/*
	*	@上传图片
	*	@参数1 	$title	标题
	*	@参数2 	$type	上传类型
	*	缩略图上传/image/image/1/500000/uploadify/picurl/undefined
	*/	
	public function uploadify(){
		$time = $this->input->post('timestamp', TRUE);			//对传进来的图片 进行xss过滤
		$token = $this->input->post('token');
		$dir = $this->input->post('dir');
		if($dir){
			$targetFolder = '/statics/uploads/'.$dir.'/'; // Relative to the root
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
            if (!file_exists($targetPath)) {
                mkdir($targetPath);
            }				
		}else{
			$targetFolder = '/statics/uploads/'; // Relative to the root
			$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;	
		}	
		$verifyToken = md5('unique_salt' . $time);

        $ymd = date("Ymd");
        $targetFolder .= $ymd . "/";
        $targetPath .= $ymd . "/";
        if (!file_exists($targetPath)) {
            mkdir($targetPath);
        }		//创建日期仓库				
		if (!empty($_FILES) && $token == $verifyToken) {
			$tempFile = $_FILES['Filedata']['tmp_name'];
			$targetFile = rtrim($targetPath,'/') . '/' . $_FILES['Filedata']['name'];
						
			// Validate the file type
			$fileTypes = config_item('enable_file_ext'); // File extensions
			$fileParts = pathinfo($_FILES['Filedata']['name']);
			
			$file_before = date("YmdHis") . '_' . rand(10000, 99999);
			$new_file_name = $file_before . '.' . $fileParts['extension'];
			$file_path = $targetPath . $new_file_name;
			
			if (in_array($fileParts['extension'],$fileTypes)) {
				move_uploaded_file($tempFile,$file_path);
				echo $targetFolder.$new_file_name;
				//echo $_FILES['Filedata']['size'];
			} else {
				echo 'Invalid file type.';
			}
		}
	}

		
}
