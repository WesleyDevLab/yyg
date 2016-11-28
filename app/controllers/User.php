<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*登录、注册*/
class User extends NoCheckHomeBase {
	function __construct(){
		parent::__construct();					
	}		
	//登录	
	public function login(){
		$this->load->view('user/login');
	}
	//登录2
	public function login2(){
		$this->load->view('user/login2');
	}
	public function userlogin2(){
		$name = $this->input->post('username');
		$pass = $this->input->post('pass');
		$pass = md5($pass);
		$member=$this->db->query("select * from `go_member` where `username`='$name' and `password`='$pass'")->row_array();
		if(!$member){
			//帐号或密码错误
			$user['state']=1;
			$user['num']=-1;
			echo json_encode($user);die;
		}
		if(!is_array($member)){
			//帐号或密码错误
			$user['state']=1;
			$user['num']=-1;
		}else{
		   //登录成功
			_setcookie("uid",_encrypt($member['uid']),60*60*24*7);
			_setcookie("ushell",_encrypt(md5($member['uid'].$member['password'].$member['mobile'].$member['email'])),60*60*24*7);
			$user['state']=0;
		}
		echo json_encode($user);
	}		
	//内部用户注册 
	public function register2(){
		$data['curr'] = 'home';
		$code = $this->uri->segment(5);
		if(!empty($code)){
			//取出用户id
			_setcookie("code",$code,60*60*24*7);
		}
		$this->load->view('user/register2');
		$this->load->view('layout/footer2',$data);
	}
	//返回注册页面
	public function regAjax(){
		$name = $this->input->post('username');
		$pass = $this->input->post('pass');
		
		$time=time();
		$decode = 0;

		$old = $this->getRow('go_member',"username='".$name."'");
		if($old){
			$out['code'] = 401;
			$out['msg'] = '该用户名已被注册 ，请重新录入';
			exit(json_encode($out));
		}
		$pass=md5($pass);
		//邮箱验证 -1 代表未验证， 1 验证成功 都不等代表等待验证
		$iprow = $this->db->query("SELECT * FROM `go_ip` WHERE status=0 order by rand() limit 1")->row_array();
		$user_ip = $iprow['province'].'省'.$iprow['city'].'市,'.$iprow['ip'];
		$this->db->Query("UPDATE `go_ip` SET status='1' where `id`='$iprow[id]'");
			
		
		$sql="INSERT INTO `go_member`(username,password,user_ip,img,emailcode,mobilecode,reg_key,yaoqing,time,user_type,money)VALUES('$name','$pass','$user_ip','/statics/uploads/photo/member.jpg','1','1','$name','$decode','$time','1','10000')";
		$flag = $this->db->Query($sql);
		$uid = $this->db->insert_id();

		if($flag){
			$out['code']=200;
			$member = $this->getRow('go_member',"uid='".$uid."'");
			_setcookie("uid",_encrypt($uid),60*60*24*7);			
			_setcookie("ushell",_encrypt(md5($member['uid'].$member['password'].$member['mobile'].$member['email'])),60*60*24*7);	
			
		}else{
			$out['code']=400;
			$out['msg'] = '用户注册失败';
		}
	    echo json_encode($out);

	}
		
	//返回注册页面
	public function register(){
		$data['curr'] = 'home';
		$code = $this->uri->segment(5);
		if(!empty($code)){
			//取出用户id
			_setcookie("code",$code,60*60*24*7);
		}
		$this->load->view('user/register');
		$this->load->view('layout/footer2',$data);
	}	
	public function mobilecheck(){
		$title="验证手机";
		$time=3000;
		$name=$this->uri->segment(3);
		$member=$this->getRow('go_member',"`mobile` = '$name'");
		if(!$member){
			$this->_mobileMsg("参数不正确!");
			return false;
		}
		if($member['mobilecode']==1){
			$this->_mobileMsg("该账号验证成功",G_WEB_PATH);
			return false;
		}
		if($member['mobilecode']==-1){
			$sendok = $this->send_mobile_reg_code($name,$member['uid']);
			if($sendok[0]!=1){
				$this->_mobileMsg($sendok[1]);
			}
			header("location:".G_WEB_PATH."/user/mobilecheck/".$member['mobile']);
			exit;

		}
		$data['name'] = $name;
		$enname=substr($name,0,3).'****'.substr($name,7,10);
		$time=120;
		$this->load->view('user/mobilecheck',$data);

	}
	public function cook_end(){

		_setcookie("uid","",time()-3600);

		_setcookie("ushell","",time()-3600);

		//_message("退出成功",WEB_PATH."/mobile/mobile/");

		header("location: ".G_WEB_PATH);

	}		

		
}
