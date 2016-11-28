<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class User extends AdminBase {
	/*后台框架首页*/
	public function index()
	{
		$this->load->view('admin/iframe');
	}
	public function login(){
		if(isset($_POST['ajax'])){			
			$location=G_WEB_PATH.'/admin/goods';
			$message=array("error"=>false,'text'=>$location);
			$username=$_POST['username'];
			$password=$_POST['password'];
			if(empty($username)){$message['error']=true;$message['text']="请输入用户名!";echo json_encode($message);exit;}
			if(empty($password)){$message['error']=true;$message['text']="请输入密码!";echo json_encode($message);exit;}			
			
			$info=$this->getRow('go_admin', "`username` = '$username'");		
			if(!$info){$message['error']=true;$message['text']="登录失败,请检查用户名或密码!";echo json_encode($message);exit;}
			if($info['userpass']!=md5($password)){$message['error']=true;$message['text']="登陆失败!";echo json_encode($message);exit;}
			
			if(!$message['error']){		
				_setcookie("AID",_encrypt($info['uid'],'ENCODE'));
				_setcookie("ASHELL",_encrypt(md5($info['username'].$info['userpass']).md5($_SERVER['HTTP_USER_AGENT'])));				
				$time=time();
				$ip=_get_ip();
				$this->db->Query("UPDATE `go_admin` SET `logintime`='$time' WHERE (`uid`='$info[uid]')");
				$this->db->Query("UPDATE `go_admin` SET `loginip`='$ip' WHERE (`uid`='$info[uid]')");
			}
			echo json_encode($message);
			exit;			
		}		
		$this->load->view('admin/login');
	}
	
}
