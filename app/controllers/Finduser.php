<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Finduser extends CheckHomeBase {
	function __construct()
	{
		parent::__construct();
	}	
	//找回密码
	public function findpassword(){
		if(isset($_POST['submit'])){			
			$name=isset($_POST['name']) ? $_POST['name'] : "";
			$txtRegSN=strtoupper($_POST['txtRegSN']);
			if(md5($txtRegSN)!=_getcookie('checkcode')){
				$this->_mobileMsg("验证码错误");
			}
			$regtype=null;
			if(_checkmobile($name)){
				$regtype='mobile';				
			}
			if(_checkemail($name)){
				$regtype='email';
			}
			if($regtype==null){
				$this->_mobileMsg("帐号类型不正确!",null,3);
				return false;
			}	
			$info=$this->db->query("SELECT * FROM `go_member` WHERE $regtype = '$name' LIMIT 1");
			if(!$info){
				$this->_mobileMsg("帐号不存在");
				return false;
			}
			header("location:".G_WEB_PATH."/finduser/find".$regtype."check"."/"._encrypt($name));
		}
		$title="找回密码";
		$data['curr'] = 'home';
		$this->load->view('finduser/findpassword');
		$this->load->view('layout/footer',$data);
	}
	//验证码
	public function image(){
		$style = $this->uri->segment(3);
		$cun_type = $this->uri->segment(4);		
		if($cun_type == 'cookie' || $cun_type == 'session'){
			$cun_type = $this->uri->segment(4);
		}else{
			$cun_type = 'cookie';
		}
		$style = explode("_",$style);		
		$width = isset($style[0]) ? intval($style[0]) : '';
		$height = isset($style[1]) ? intval($style[1]) : '';
		$color = isset($style[2]) ? $style[2] : '';
		$bgcolor = isset($style[3]) ? $style[3] : '';
		$lenght = isset($style[4]) ? intval($style[4]) : '';
		$type = isset($style[5]) ? intval($style[5]) : '';
		require_once(ROOTPATH.'/app/libraries/checkcodeimg.php');
		$checkcode= new checkcodeimg();
		$checkcode->config($width,$height,$color,$bgcolor,$lenght,$type);
		if(isset($_GET['dian'])){
			$checkcode->dian(50,$color);
		}
		
		if($cun_type == 'cookie'){
			_setcookie("checkcode",md5($checkcode->code));
		}
		if($cun_type == 'session'){
			_session_start();
			$_SESSION['checkcode'] = md5($checkcode->code);			
			//$this->load->driver('cache');
			//$this->cache->memcached->save('checkcode', md5($checkcode->code));		
		}
		$checkcode->image();
	}	
	//手机重置密码
	public function findsendmobile(){
		$name=_encrypt($this->segment(4),"DECODE");
		$member=$this->db->query("SELECT * FROM `go_member` WHERE `mobile` = '$name' LIMIT 1")->row_array();
		if(!$member){
			$this->_mobileMsg("参数不正确!");
			return false;
		}	
		$checkcode=explode("|",$member['mobilecode']);
		$times=time()-$checkcode[1];		
		if($times > 120){
			//重发验证码
			$mobile_code=rand(100000,999999);
			$mobile_time=time();				
			$mobilecodes=$mobile_code.'|'.$mobile_time;//验证码		
			$this->db()->query("UPDATE `go_member` SET passcode='$mobilecodes' where `uid`='$member[uid]'");
            //2014-11-24 lq
            $temp_m_pwd = $this->db->query("select value from `go_caches` where `key` = 'template_mobile_pwd' LIMIT 1")->row_array();
            $text=str_replace("000000",$mobile_code,$temp_m_pwd['value']);

            $sendok=_sendmobile($name,$text);
			if($sendok[0]!=1){
				$this->_mobileMsg($sendok[1]);
			}
			$this->_mobileMsg("正在重新发送...",WEB_PATH."/mobile/finduser/findmobilecheck/"._encrypt($member['mobile']),2);
			return false;				
		}else{
			$this->_mobileMsg("重发时间间隔不能小于2分钟!",WEB_PATH."/mobile/finduser/findmobilecheck/"._encrypt($member['mobile']));
			return false;
		}		
	}
	public function findmobilecheck(){	
		$title="手机找回密码";	
		$time=120;
		$namestr=$this->uri->segment(3);
		$data['namestr'] = $namestr;
		$name=_encrypt($namestr,"DECODE");
		if(strlen($name)!=11){$this->_mobileMsg("参数错误！");return false;}
		$member=$this->db->query("SELECT * FROM `go_member` WHERE `mobile` = '$name' LIMIT 1")->row_array();
		if(!$member){
			$this->_mobileMsg("参数不正确!");
			return false;
		}

		if($member['passcode']==-1){
			//更新验证码	
			$randcode=rand(100000,999999);
			$checkcodes=$randcode.'|'.time();//验证码
			$this->db->Query("UPDATE `go_member` SET passcode='$checkcodes' where `uid`='$member[uid]'");
            //2014-11-24
            $temp_m_pwd = $this->db->Query("select value from `go_caches` where `key` = 'template_mobile_pwd' LIMIT 1")->row_array();
            $text=str_replace("000000",$randcode,$temp_m_pwd['value']);

			$sendok=$this->_sendmobile($name,$text);
			if($sendok[0]!=1){
				$this->_mobileMsg($sendok[1]);
			}
			header("location:".G_WEB_PATH."/finduser/findmobilecheck/"._encrypt($member['mobile']));
			exit;
		}		
		if(isset($_POST['submit'])){
			$checkcodes=isset($_POST['checkcode']) ? $_POST['checkcode'] : $this->_mobileMsg("参数不正确!");
			if(strlen($checkcodes)!=6){
				$this->_mobileMsg("验证码输入不正确!");
				return false;
			}
			$usercode=explode("|",$member['passcode']);	
			if($checkcodes!=$usercode[0]){
				$this->_mobileMsg("验证码输入不正确!");
				return false;
			}
			$urlcheckcode=_encrypt($member['mobile']."|".$member['passcode']);
			_setcookie("uid",_encrypt($member['uid']));	
			_setcookie("ushell",_encrypt(md5($member['uid'].$member['password'].$member['mobile'].$member['email'])));	
			header("location:".G_WEB_PATH."/finduser/findok/".$urlcheckcode,2);			
		}		
		$enname=substr($name,0,3).'****'.substr($name,7,10);
		$data['enname'] = $enname;
		$data['time']=120;
		$this->load->view('finduser/findmobilecheck',$data);
	}
	public function findok(){		
		$key=$this->uri->segment(3);
		if(empty($key)){
			$this->_mobileMsg("未知错误");	
			return false;
		}else{
			$key = $this->uri->segment(3);
		}
		$data['key'] = $key;
		$checkcode=explode("|",_encrypt($key,"DECODE"));
		if(count($checkcode)!=3){
			$this->_mobileMsg("未知错误",NULL,3);
			return false;
		}
		$data['checkcode'] = $checkcode;
		$emailurl=explode("@",$checkcode[0]);
		if(isset($emailurl[1])){
			$sql="select * from `go_member` where `email`='$checkcode[0]' AND `passcode`= '$checkcode[1]|$checkcode[2]' LIMIT 1";		
		}else{
			$sql="select * from `go_member` where `mobile`='$checkcode[0]' AND `passcode`= '$checkcode[1]|$checkcode[2]' LIMIT 1";		
		}		
		$member=$this->db->query($sql)->row_array();			
		if(!$member){
			$this->_mobileMsg("帐号或验证码错误",NULL,2);
			return false;
		}	
		$usercheck=explode("|",$member['passcode']);			
		$timec=time()-$usercheck[1];	
		$data['curr'] = 'home';		
		if($timec<(3600*24)){
			$data['title']="重置密码";
			$this->load->view('finduser/findok',$data);
			$this->load->view('layout/footer',$data);
		}else{
			$data['title']="验证失败";
			$namestr=_encrypt($checkcode[0]);
			$this->load->view('finduser/finderror');
			$this->load->view('layout/footer',$data);
		}
	}
	public function resetpassword(){
		if(isset($_POST['submit'])){
			$key=$_POST["hidKey"];
			$password=md5($_POST["userpassword"]);
			$checkcode=explode("|",_encrypt($key,"DECODE"));
			if(count($checkcode)!=3){
				$this->_mobileMsg("未知错误",G_WEB_PATH."/user/login",3);
				return false;
			}			
			$emailurl=explode("@",$checkcode[0]);
			if(isset($emailurl[1])){
				$sql="select * from `go_member` where `email`='$checkcode[0]' AND `passcode`= '$checkcode[1]|$checkcode[2]' LIMIT 1";		
			}else{
				$sql="select * from `go_member` where `mobile`='$checkcode[0]' AND `passcode`= '$checkcode[1]|$checkcode[2]' LIMIT 1";		
			}		
			$member=$this->db->query($sql)->row_array();
			if(!$member){
				$this->_mobileMsg("未知错误",G_WEB_PATH."/user/login",3);
				return false;
			}
			$this->db->query("UPDATE `go_member` SET `password`='$password',`passcode`='-1' where `uid`='$member[uid]'");
			$this->_mobileMsg("密码重置成功",G_WEB_PATH."/user/login",2);
			return false;
		}
	}	
		
}
