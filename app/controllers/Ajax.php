<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CheckHomeBase {
	private $Mcartlist;
	function __construct()
	{
		parent::__construct();
		$Mcartlist=_getcookie("Cartlist");
		$this->Mcartlist=json_decode(stripslashes($Mcartlist),true);		
	}	
	//首页
	public function init(){
	    if(__FUNCTION__!='userphotoup' and __FUNCTION__!='singphotoup'){
			if(!$this->userinfo)$this->_message("请登录",G_WEB_PATH."/mobile/user/login",3);
		}

		$member=$this->userinfo;
		$title="我的用户中心";

		 $user['code']=1;
		 $user['username']=$this->get_user_name($member['uid']);
		 $user['uid']=$member['uid'];
		 if(!empty($member)){
		   $user['code']=0;
		 }
		echo json_encode($user);		
	}
	//心愿商品留言
	public function goodcomment(){
		$comment = $this->input->post('comment');
		$gid = $this->input->post('gid');
		$good = $this->getRow("go_goods","id='".$gid."' and status=0");
		$username = $this->get_user_name($this->userinfo['uid']);
		$data = array(
			'good_id' => $gid,
			'sid' => $good['sid'],
			'q_uid' => $this->userinfo['uid'],
			'q_user' => $username,
			'q_pic' => $this->userinfo['img'],
			'good_comment'=> $comment
			
		);
		$flag = $this->db->insert('go_goods_comment', $data);
		$arr['code'] = 400;
		if($flag){
			$arr['code'] = 200;
		}
		exit(json_encode($arr));
	}
	//是否登录【判断是否能购买】
	public function islogin(){
		$out['code'] = 200;
		$goods_id=safe_replace($this->uri->segment(3));
		if(!$this->userinfo){
			$out['code'] = 400;
		}else{
			$out['init_step']=5;
			$out['person_enable'] = $this->userinfo['money'];
			$good = $this->getRow("go_goods","id='".$goods_id."' and status=0");
			if($good){
				$out['goods_enable'] = $good['shenyurenshu'];	
			}
		}
		exit(json_encode($out));
	}	
	//login
	public function userlogin(){
	    $username=safe_replace($this->uri->segment(3));
	    $pwd = safe_replace($this->uri->segment(4));
	    $password=md5(safe_replace($pwd));
		$logintype='';

		$member=$this->db->query("select * from `go_member` where `mobile`='$username' and `password`='$password'")->row_array();
		$arr['url'] = "select * from `go_member` where `mobile`='$username' and `password`='$password'";
		if(!$member){
			//帐号或密码错误
			$user['state']=1;
			$user['num']=-1;
			echo json_encode($user);die;
		}
		if($member['mobilecode'] != 1 && $member['emailcode'] != 1){
			$user['state']=2; //未验证
			echo json_encode($user);die;
		}
		if(!is_array($member)){
			//帐号或密码错误
			$user['state']=1;
			$user['num']=-1;
		}else{
		   //登录成功
			$time=time();
			$ip=_get_ip();
			$this->db->Query("UPDATE `go_member` SET `login_time`='$time',`login_ip`='$ip' WHERE (`uid`='$member[uid]')");

			_setcookie("uid",_encrypt($member['uid']),60*60*24*7);
			_setcookie("ushell",_encrypt(md5($member['uid'].$member['password'].$member['mobile'].$member['email'])),60*60*24*7);

			$user['state']=0;

		}
		echo json_encode($user);
	}
	//登录成功后
	public function loginok(){
	  $user['Code']=0;
	  echo json_encode($user);
	}
    //购物车数量
	public function cartnum(){
	  $Mcartlist=$this->Mcartlist;
	  if(is_array($Mcartlist)){
          if(isset($Mcartlist['MoenyCount'])){          //roby 08-23此处是防止PC浏览器对微信端有影响，其实正常操作不会出现
              unset($Mcartlist['MoenyCount']);
          }
	  	  $cartnum['code']=0;
	      $cartnum['num']=count($Mcartlist);
	  }else{
	  	  $cartnum['code']=1;
	      $cartnum['num']=0;
	  }
      //var_dump($Mcartlist);
	  echo json_encode($cartnum);
	}
	//添加购物车
	public function addShopCart(){
		$ShopId=safe_replace($this->uri->segment(3));
		$ShopNum=safe_replace($this->uri->segment(4));
		$cartbs=safe_replace($this->uri->segment(5));//标识从哪里加的购物车

		$shopis=0;          //0表示不存在  1表示存在
		$Mcartlist=$this->Mcartlist;
		//if($ShopId==0 || $ShopNum==0){
		if($ShopId==0){	 //roby 08-06立即一元淘可能不添加1

		$cart['code']=1;   //表示添加失败

		}else{
		  if(is_array($Mcartlist)){
			foreach($Mcartlist as $key=>$val){
			   if($key==$ShopId){
			      if(isset($cartbs) && $cartbs=='cart'){
		            $Mcartlist[$ShopId]['num']=$ShopNum;
				  }else{
				    $Mcartlist[$ShopId]['num']=$val['num']+$ShopNum;
				  }
				  $shopis=1;
			   }else{
				  $Mcartlist[$key]['num']=$val['num'];
			   }
			}

		    }else{
				$Mcartlist =array();
				$Mcartlist[$ShopId]['num']=$ShopNum;
		    }

		    if($shopis==0){
		    	$Mcartlist[$ShopId]['num']=$ShopNum;
		    }

			_setcookie('Cartlist',json_encode($Mcartlist),'');
			$cart['code']=0;   //表示添加成功
		}

		$cart['num']=count($Mcartlist);    //表示现在购物车有多少条记录

		if($cart['num'] == 0){

		$cartkey="123";

		}
		
		echo json_encode($cart);

	}
	public function delCartItem(){
	   $ShopId=safe_replace($this->uri->segment(3));

	   $cartlist=$this->Mcartlist;

		if($ShopId==0){

		  $cart['code']=1;   //删除失败

		}else{
			   if(is_array($cartlist)){
			      if(count($cartlist)==1){
				     foreach($cartlist as $key=>$val){
					   if($key==$ShopId){
					     $cart['code']=0;
						    _setcookie('Cartlist','','');
						}else{
					     $cart['code']=1;
					   }
					 }

				  }else{
					   foreach($cartlist as $key=>$val){
							if($key==$ShopId){
							  $cart['code']=0;
							}else{
							  $Mcartlist[$key]['num']=$val['num'];
							}
						}
						_setcookie('Cartlist',json_encode($Mcartlist),'');
					}

				}else{
				   $cart['code']=1;   //删除失败
				}

		}
		echo json_encode($cart);
	}
	
	//检测用户是否已注册
	public function checkname(){
		$name= $this->uri->segment(3);
		if(!_checkmobile($name)){
			$user['state']=1;//_message("系统短息配置不正确!");
			 echo json_encode($user);
			 exit;
		}
		$member=$this->getRow('go_member', "`mobile` = '$name'");
		if(is_array($member)){
			if($member['mobilecode']==1 || $member['emailcode']==1){
			  $user['state']=1;//_message("该账号已被注册");
			}else{
			  $sql="DELETE from`go_member` WHERE `mobile` = '$name'";
			  $this->db->Query($sql);
			  $user['state']=0;
			}
		}else{
		    $user['state']=0;//表示数据库里没有该帐号
		}

	    echo json_encode($user);
	}
	//将数据注册到数据库
	public function userMobile(){
		$name= isset($_GET['username'])? $_GET['username']: $this->uri->segment(3);
		$pass= isset($_GET['password'])? md5($_GET['password']): md5(base64_decode($this->uri->segment(4)));
		$time=time();
		$decode = 0;
		//邮箱验证 -1 代表未验证， 1 验证成功 都不等代表等待验证
		$song = CZSONG;
		$ipaddress = _get_ip_dizhi();
		$sql="INSERT INTO `go_member`(`mobile`,password,img,emailcode,mobilecode,reg_key,yaoqing,time,money,user_ip)VALUES('$name','$pass','/statics/uploads/photo/member.jpg','-1','-1','$name','$decode','$time','$song','$ipaddress')";
		if(!$name || $this->db->Query($sql)){
			//注册成功
			$uid = $this->db->insert_id();
			$nowtime = time();
			$data1 = array(
				'uid' => $uid,
				'type' => 1,
				'pay' => '账户',
				'content' => '注册赠送',
				'money' => $song,
				'time' => $nowtime
			);
			$this->db->insert('go_member_account', $data1);			
			
			//header("location:".WEB_PATH."/mobile/user/".$regtype."check"."/"._encrypt($name));
			//exit;
			$userMobile['state']=0;
		}else{
			//_message("注册失败！");
			$userMobile['state']=1;
		}
	  echo json_encode($userMobile);
	}			
	//验证输入的手机验证码
	public function mobileregsn(){
	    $mobile= $this->uri->segment(3);
	    $checkcodes= $this->uri->segment(4);
		$member=$this->db->query("SELECT * FROM `go_member` WHERE `mobile` = '$mobile' LIMIT 1")->row_array();

		if(strlen($checkcodes)!=6){
		    //_message("验证码输入不正确!");
			$mobileregsn['state']=1;
			echo json_encode($mobileregsn);
			exit;
		}
		$usercode=explode("|",$member['mobilecode']);
		if($checkcodes!=$usercode[0]){
		   //_message("验证码输入不正确!");
			$mobileregsn['state']=1;
			echo json_encode($mobileregsn);
			exit;
		}


		$this->db->Query("UPDATE `go_member` SET mobilecode='1' where `uid`='$member[uid]'");
		$this->db->Query("UPDATE `go_member` SET score='100' where `uid`='$member[uid]'");	


		_setcookie("uid",_encrypt($member['uid']),60*60*24*7);
		_setcookie("ushell",_encrypt(md5($member['uid'].$member['password'].$member['mobile'].$member['email'])),60*60*24*7);

		 $mobileregsn['state']=0;
		 $mobileregsn['str']=1;

        echo json_encode($mobileregsn);
	}
			
		
}
