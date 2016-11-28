<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*个人中心页面*/
class Home extends CheckHomeBase {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		
		if(__FUNCTION__!='userphotoup' and __FUNCTION__!='singphotoup'){
			if(!$this->userinfo){
				redirect(G_WEB_PATH.'/user/login');
			}
		}					
	}		
	//首页	
	public function index(){
		$data['curr'] = 'home';	
		$member=$this->userinfo;
		$title="我的用户中心";
		//$quanzi=$this->db->GetList("select * from `@#_quanzi_tiezi` order by id DESC LIMIT 5");

		//获取购买等级  购买新手  购买小将==
		$memberdj=$this->db->query("select * from `go_member_group`")->result_array();
	
		$jingyan=$member['jingyan'];
		if(!empty($memberdj)){
		    foreach($memberdj as $key=>$val){
			   if($jingyan>=$val['jingyan_start'] && $jingyan<=$val['jingyan_end']){
			   	$member['yungoudj']=$val['name'];
			   }
			}
		}
		$member['user'] = $this->get_user_name($member['uid']);
		$data['member'] = $member;
		$this->load->view('home/index',$data);
		$this->load->view('layout/footer2');
	}
	//我的晒单：已晒单
	public function singlelist(){
		$data['curr'] = 'home';
		$this->load->view('home/singlelist');
		$this->load->view('layout/footer2',$data);		
	}
	//编辑资料页面
	public function edit_user(){
		$data['curr'] = 'home';	
		$member=$this->userinfo;
		$title="我的用户中心";
		$member['user'] = $this->get_user_name($member['uid']);
		$data['member']= $member;
		$this->load->view('home/edit_user',$data);
		$this->load->view('layout/footer2');		
	}
	//编辑用户姓名
	public function edit_username(){
		$data['curr'] = 'home';
		$data['member']=$this->userinfo;
		$edit_usename = htmlspecialchars($this->input->post('edit_usename'));
		if($edit_usename){
			$this->db->query("UPDATE `go_member` SET `username`='".$edit_usename."' where uid='" . $data['member']['uid'] . "'");			
			$this->_mobileMsg("用户昵称编辑成功!",G_WEB_PATH.'/home');
			return false;
		}
		$this->load->view('home/edit_username',$data);
		$this->load->view('layout/footer2');
	}
	/*添加晒单*/
	public function singleinsert(){	
		$member=$this->userinfo;
		$data['curr'] = 'home';
		$this->load->view('home/singleinsert',$data);
		$this->load->view('layout/footer2');			
	}	
	//我的晒单：未晒单
	public function singlelister(){
		$member=$this->userinfo;
		$data['title']="我的晒单";
		$cord=$this->db->query("select * from `go_member_go_record` where `uid`='$member[uid]' and `huode` > '10000000'")->result_array();
		
		$shaidan=$this->db->query("select * from `go_shaidan` where `sd_userid`='$member[uid]' order by `sd_id`")->result_array();

		$sd_id = $r_id = array();
		foreach($shaidan as $sd){
			if(!empty($sd['sd_shopid'])){
				$sd_id[]=$sd['sd_shopid'];
			}
		}

		foreach($cord as $rd){
			if(!in_array($rd['shopid'],$sd_id)){
				$r_id[]=$rd['shopid'];
			}
		}
		if(!empty($r_id)){
			$rd_id=implode(",",$r_id);
			$rd_id = trim($rd_id,',');
		}else{
			$rd_id="0";
		}
		
		$record = $this->db->query("select a.shopid,a.id,b.title,b.thumb from `go_member_go_record` as a left join `go_goods` as b on a.shopid=b.id where a.shopid in ($rd_id) and a.`uid`='$member[uid]' and a.`huode`>'10000000' ORDER BY a.time desc limit 10")->result_array();

		$shaidan=$this->db->query("select * from `go_shaidan` where `sd_userid`='$member[uid]' order by `sd_id`")->result_array();		
		$data['curr'] = 'home';	
		$data['record'] = $record;
		$this->load->view('home/singlelister',$data);
		$this->load->view('layout/footer2',$data);		
	}
	//添加地址
	public function add(){
		$member=$this->userinfo;
		$title="收货地址";
		$member_dizhi=$this->db->query("select * from `go_member_dizhi` where uid='".$member['uid']."' limit 5")->result_array();
		foreach($member_dizhi as $k=>$v){		
			$member_dizhi[$k] = _htmtocode($v);
		}
		$count=count($member_dizhi);
		$data['curr'] = 'home';
		$this->load->view('home/add',$data);
		$this->load->view('layout/footer2',$data);
	}	
    //我的地址
    public function address(){
    	$data['curr'] = 'home';
		$member=$this->userinfo;
		$member_dizhi=$this->db->query("select * from `go_member_dizhi` where uid='".$member['uid']."' order by time desc")->result_array();

        if(!$member_dizhi){
            header("location: ".G_WEB_PATH."/home/add");
        }
        $data['member_dizhi'] = $member_dizhi;
		$this->load->view('home/address',$data);
		$this->load->view('layout/footer2',$data);
	}
    //roby重写编辑地址
    public function editadd(){
        $member=$this->userinfo;
        $id=$this->uri->segment(3);
        $id = abs(intval($id));
        $data['title']="收货地址";
        $data['curr']="";
        $member_dizhi=$this->getRow("go_member_dizhi","uid='".$member['uid']."' and id='".$id."'");
		$data['member_dizhi'] = $member_dizhi;
		$this->load->view('home/upaddroby',$data);
		$this->load->view('layout/footer2',$data);
    }
	//添加收货地址
	public function useraddress(){
		$member=$this->userinfo;
		$uid=$member['uid'];
		if(isset($_POST['submit'])){
			foreach($_POST as $k=>$v){
				$_POST[$k] = _htmtocode($v);
			}
			$sheng=isset($_POST['sheng']) ? $_POST['sheng'] : "";
			$shi=isset($_POST['shi']) ? $_POST['shi'] : "";
			$xian=isset($_POST['xian']) ? $_POST['xian'] : "";
			$jiedao=isset($_POST['jiedao']) ? $_POST['jiedao'] : "";
			//$youbian=isset($_POST['youbian']) ? $_POST['youbian'] : "";
			$shouhuoren=isset($_POST['shouhuoren']) ? $_POST['shouhuoren'] : "";
			$mobile=isset($_POST['mobile']) ? $_POST['mobile'] : "";
			//$tell=isset($_POST['tell']) ? $_POST['tell'] : "";
			$default = in_array($_POST['default'],array('Y','N')) ? $_POST['default'] : 'N';
			if($default=='Y'){
				$this->db->Query("UPDATE `go_member_dizhi` SET `default`='N' where uid='" . $member['uid'] . "'");				
			}
			$time=time();
			if($sheng==null or $jiedao==null or $shouhuoren==null or $mobile==null){
				//echo "带星号不能为空;";		//无带星号的东东
				echo "省份、详细地址、收货人、手机号码均不能为空";
				exit;
			}			
			if(!_checkmobile($mobile)){
				echo "手机号错误;";
				exit;
			}
			$member_dizhi=$this->db->query("select * from `go_member_dizhi` where `uid`='".$uid."'")->row_array();
			if(!$member_dizhi){
				$default="Y";
			}
			$this->db->Query("INSERT INTO `go_member_dizhi`(`uid`,`sheng`,`shi`,`xian`,`jiedao`,`youbian`,`shouhuoren`,`tell`,`mobile`,`default`,`time`)VALUES
			('$uid','$sheng','$shi','$xian','$jiedao','','$shouhuoren','','$mobile','$default','$time')");
			$this->_mobileMsg("收货地址添加成功",G_WEB_PATH."/home",3);
		}
	} 
	//删除地址
	public function deladdress(){
		$member=$this->userinfo;
		$id=$this->uri->segment(3);
		$id = abs(intval($id));
		$dizhi=$this->db->query("select * from `go_member_dizhi` where `uid`='$member[uid]' and `id`='$id'")->row_array();
		if(!empty($dizhi)){
			$this->db->Query("DELETE FROM `go_member_dizhi` WHERE `uid`='$member[uid]' and `id`='$id'");
			header("location:".G_WEB_PATH."/home/address");
		}else{
			echo $this->_message("删除失败",G_WEB_PATH."/home",0);
		}
	}	   
    //更新
	public function updateddress(){
		$member=$this->userinfo;
		$uid=$member['uid'];
		$id = $this->uri->segment(3);
		$id = abs(intval($id));
		if(isset($_POST['submit'])){
            $id = isset($_POST['id']) ? $_POST['id'] : "";
			$sheng=isset($_POST['sheng']) ? $_POST['sheng'] : "";
			$shi=isset($_POST['shi']) ? $_POST['shi'] : "";
			$xian=isset($_POST['xian']) ? $_POST['xian'] : "";
			$jiedao=isset($_POST['jiedao']) ? $_POST['jiedao'] : "";
			//$youbian=isset($_POST['youbian']) ? $_POST['youbian'] : "";
			$shouhuoren=isset($_POST['shouhuoren']) ? $_POST['shouhuoren'] : "";
			//$tell=isset($_POST['tell']) ? $_POST['tell'] : "";
			$mobile=isset($_POST['mobile']) ? $_POST['mobile'] : "";
			$default = in_array($_POST['default'],array('Y','N')) ? $_POST['default'] : 'N';
			$time=time();
			if($sheng==null or $jiedao==null or $shouhuoren==null or $mobile==null){
				echo "带星号不能为空;";
				exit;
			}			
			if(!_checkmobile($mobile)){
				echo "手机号错误;";
				exit;
			}
            $this->db->Query("UPDATE `go_member_dizhi` SET `default`='N' where uid='" . $member['uid'] . "'");
			$this->db->Query("UPDATE `go_member_dizhi` SET
			`uid`='".$uid."',
			`sheng`='".$sheng."',
			`shi`='".$shi."',
			`xian`='".$xian."',
			`jiedao`='".$jiedao."',
			`shouhuoren`='".$shouhuoren."',
			`default`='".$default."',
			`mobile`='".$mobile."' where `id`='".$id."'");
			$this->_mobileMsg("修改成功",G_WEB_PATH ."/home/address",3);
		}
	}    	
	//ajax请求更新默认收货地址
    public function ajax_addr()
    {
        $member=$this->userinfo;
        $uid=$member['uid'];
        $this->db->Query("UPDATE `go_member_dizhi` SET `default`='N' where uid='" . $member['uid'] . "'");
        $id = isset($_POST['id']) ? $_POST['id'] : "";
        $id = abs(intval($id));
        if (isset($id)) {
            $this->db->Query("UPDATE `go_member_dizhi` SET `default`='Y' where id='" . $id . "'");
        }
        exit( json_encode(array('code'=>200,'message'=>$id.'设置成功')) );
    }
	//购买记录
	public function userbuylist(){
		$data['curr'] = 'home';
		$this->load->view('home/userbuylist',$data);
		$this->load->view('layout/footer');			
	}
	//获得的商品
	public function orderlist(){
		$data['curr'] = 'home';
		$this->load->view('home/orderlist',$data);
		$this->load->view('layout/footer2');			
	}
 	//我的心愿商品
	public function mywish(){
		$data['curr'] = 'home';
		$this->load->view('home/mywish',$data);
		$this->load->view('layout/footer2');			
	} 
	//修改密码页面加载
	public function password(){
		$member=$this->userinfo;
		$this->load->view('home/password');
	}
	public function userpassword(){
		$member=$this->userinfo;
		$password=isset($_POST['password']) ? $_POST['password'] : "";
		$userpassword=isset($_POST['userpassword']) ? $_POST['userpassword'] : "";
		$userpassword2=isset($_POST['userpassword2']) ? $_POST['userpassword2'] : "";
		if($password==null or $userpassword==null or $userpassword2==null){
				echo "密码不能为空;";
				exit;
		}
		if(strlen($_POST['password'])<6 || strlen($_POST['password'])>20){
			echo "密码不能小于6位或者大于20位";
			exit;
		}
		if($_POST['userpassword']!=$_POST['userpassword2']){
			echo "新密码不一致";
			exit;
		}		
		$password=md5($password);
		$userpassword=md5($userpassword);
		if($member['password']!=$password){
			$this->_mobileMsg("原密码错误,请重新输入!",null,3);
		}else{
			$this->db->Query("UPDATE `go_member` SET password='".$userpassword."' where uid='".$member['uid']."'");
			_setcookie("uid","",time()-3600);
			_setcookie("ushell","",time()-3600);
			$this->_mobileMsg("密码修改成功,请重新登录!",G_WEB_PATH.'/user/login',3);
		}
	}
	//账户管理
	public function userbalance(){
		$member=$this->userinfo;
		$memberdj=$this->db->query("select * from `go_member_group`")->result_array();
		$jingyan=$member['jingyan'];
		if(!empty($memberdj)){
			foreach($memberdj as $key=>$val){
				if($jingyan>=$val['jingyan_start'] && $jingyan<=$val['jingyan_end']){
			    	$member['yungoudj']=$val['name'];
				}
			}
		}
		$title="账户记录";
		$data['member']=$member;
		$account=$this->db->query("select * from `go_member_account` where `uid`='$member[uid]' and `pay` = '账户' ORDER BY time DESC")->result_array();
        $czsum=0;
        $xfsum=0;
		if(!empty($account)){
			foreach($account as $key=>$val){
			  if($val['type']==1){
				$czsum+=$val['money'];
			  }else{
				$xfsum+=$val['money'];
			  }
			}
		}
		$data['czsum'] = $czsum;
		$data['xfsum'] = $xfsum;
		$data['curr'] = 'home';
		$this->load->view('home/userbalance',$data);
		$this->load->view('layout/footer2');	
	}
	//注意绑定：目前pc已禁止邮箱注册 ，所以不存在pc端的绑定，只需要将微信跟pc打通
	public function mobilecheck(){	
		$member=$this->userinfo;
		if(isset($_POST['submit'])){
			$shoujimahao =  base64_decode(_getcookie("mobilecheck"));
			if(!_checkmobile($shoujimahao)){
				$this->_mobileMsg("手机号码错误!");
				return false;
			}
			if(isset($_POST['verification_code'])){
				$checkcodes = $_POST['verification_code'];
			}else{
				$this->_mobileMsg("参数不正确!");
				return false;
			}			
			
			if(strlen($checkcodes)!=6){
				$this->_mobileMsg("验证码输入不正确!");
				return false;
			}
			$usercode=explode("|",$member['mobilecode']);	

			if($checkcodes!=$usercode[0]){
				$this->_mobileMsg("验证码输入不正确!");
				return false;
			}
			$member2=$this->db->query("select password,email,money,score,jingyan,yaoqing,mobilecode,uid,mobile,img from `go_member` where `mobile`='$shoujimahao' and `uid` != '$member[uid]'")->row_array();
			if($member2){			//该手机号码pc端注册过，需要统一将微信信息转移到pc[注：微信端未绑定手机不能参加购买]
				$new_money = $member['money'] + $member2['money'];
				$new_score = $member['score'] + $member2['score'];
				$new_jingyan = $member['jingyan'] + $member2['jingyan'];
				$new_yaoqing = $member['yaoqing'] + $member2['yaoqing'];
				$new_tx = $member['img'];
				if($member2['img']!='/statics/uploads/photo/member.jpg'){
					$new_tx = $member2['img'];
				}			
				$this->db->Query("UPDATE `go_member` SET `img`='$new_tx',`username`='$member[username]',`money`='$new_money',`score`='$new_score',`jingyan`='$new_jingyan',`yaoqing`='$new_yaoqing' where `uid`='$member2[uid]'");
				$this->db->Query("UPDATE `go_member_band` SET `b_uid`='$member2[uid]' where `b_uid`='$member[uid]'");
				$this->db->Query("UPDATE `go_member_account` SET `uid`='$member2[uid]' where `uid`='$member[uid]'");
				$this->db->Query("UPDATE `go_weixin_user` SET `uid`='$member2[uid]' where `uid`='$member[uid]'");

				$go_record = $this->getRow("go_member_go_record","uid='".$member['uid']."'",'id');
				$this->db->Query("UPDATE `go_member_go_record` SET `uid`='".$member2['uid']."' where `id`='".$go_record['id']."'");
				
				$go_xy = $this->getRow("go_xy","q_uid='".$member['uid']."'",'id');
				$this->db->Query("UPDATE `go_xy` SET `q_uid`='".$member2['uid']."' where `id`='".$go_xy['id']."'");

				$go_member_addmoney_record = $this->getRow("go_member_addmoney_record","uid='".$member['uid']."'",'id');
				$this->db->Query("UPDATE `go_member_addmoney_record` SET `uid`='".$member2['uid']."' where `id`='".$go_member_addmoney_record['id']."'");

				$go_shaidan = $this->getRow("go_shaidan","sd_userid='".$member['uid']."'",'sd_id');
				$this->db->Query("UPDATE `go_shaidan` SET `sd_userid`='".$member2['uid']."' where `sd_id`='".$go_shaidan['sd_id']."'");

				$go_shaidan_hueifu = $this->getRow("go_shaidan_hueifu","sdhf_userid='".$member['uid']."'",'id');
				$this->db->Query("UPDATE `go_shaidan_hueifu` SET `sdhf_userid`='".$member2['uid']."' where `id`='".$go_shaidan_hueifu['id']."'");
			
				$go_member_dizhi = $this->getRow("go_member_dizhi","uid='".$member['uid']."'",'id');
				$this->db->Query("UPDATE `go_member_dizhi` SET `uid`='".$member2['uid']."' where `id`='".$go_member_dizhi['id']."'");
				
				
				
                
                _setcookie("uid", _encrypt($member2['uid']), 60 * 60 * 24 * 7);
                _setcookie("ushell", _encrypt(md5($member2['uid'] . $member2['password'] . $member2['mobile'] . $member2['email'])), 60 * 60 * 24 * 7);	
                
                $this->db->Query("DELETE FROM `go_member` WHERE `uid`='".$member['uid']."'");		//删除手机记录
                unset($member);
                $member = $member2;			
			}else{					//未注册过，直接在该记录上用
				$this->db->Query("UPDATE `go_member` SET `mobilecode`='1',`mobile` = '$shoujimahao' where `uid`='$member[uid]'");
			}
			
			//淘豆、经验添加			
			$isset_user=$this->db->query("select `uid` from `go_member_account` where `content`='手机认证完善奖励' and `type`='1' and `uid`='$member[uid]' and (`pay`='经验' or `pay`='淘豆')")->result_array();	
			if(empty($isset_user)){

				$time=time();
				//$this->db->Query("insert into `go_member_account` (`uid`,`type`,`pay`,`content`,`money`,`time`) values ('$member[uid]','1','淘豆','手机认证完善奖励','$config[f_phonecode]','$time')");
				//$this->db->Query("insert into `go_member_account` (`uid`,`type`,`pay`,`content`,`money`,`time`) values ('$member[uid]','1','经验','手机认证完善奖励','$config[z_phonecode]','$time')");			
				//$this->db->Query("UPDATE `go_member` SET `score`=`score`+'$config[f_phonecode]',`jingyan`=`jingyan`+'$config[z_phonecode]' where uid='".$member['uid']."'");
			}
			_setcookie("uid",_encrypt($member['uid']));	
			_setcookie("ushell",_encrypt(md5($member['uid'].$member['password'].$member['mobile'].$member['email'])));		
			//淘豆、经验添加			
			$isset_user=$this->db->query("select `uid` from `go_member_account` where `pay`='手机认证完善奖励' and `type`='1' and `uid`='$member[uid]' or `pay`='经验'")->row_array();	
			if(empty($isset_user)){

				$time=time();
				//奖励roby	
				//$this->db->Query("insert into `go_member_account` (`uid`,`type`,`pay`,`content`,`money`,`time`) values ('$member[uid]','1','淘豆','手机认证完善奖励','$config[f_overziliao]','$time')");
				//$this->db->Query("insert into `go_member_account` (`uid`,`type`,`pay`,`content`,`money`,`time`) values ('$member[uid]','1','经验','手机认证完善奖励','$config[z_overziliao]','$time')");			
				//$mysql_model->Query("UPDATE `go_member` SET `score`=`score`+'$config[f_overziliao]',`jingyan`=`jingyan`+'$config[z_overziliao]' where uid='".$member['uid']."'");
				//$this->db->Query("UPDATE `go_member` SET score='100' where `uid`='$member[uid]'");	
			}			
			//echo "<script type='text/javascript'>alert('验证成功,请重新登录');</script>";
			$this->_mobileMsg("绑定成功！",G_WEB_PATH."/home");
		}else{
			$this->_mobileMsg("页面错误",null,3);
		}
	}	
	//绑定手机号码[已登录]
	public function mobilechecking(){
		$data['member'] = $this->userinfo;
		$data['curr'] = 'home';
		$this->load->view('home/mobilechecking',$data);
		$this->load->view('layout/footer2');		
	}
	//发送手机验证码
	public function sendmobilecode(){
		$mobile = $_POST['mobile'];
		$member=$this->userinfo;
		if( !empty($member['mobilecode']) ){
			$last_code_info = explode('|',$member['mobilecode']);
			if( isset($last_code_info[1]) && !empty($last_code_info[1]) && $last_send_time+60 > time() ){
				exit( json_encode(array('code'=>600,'msg'=>'操作过于频繁，请稍后再试。')) );
			}
		}
		if(!_checkmobile($mobile) || $mobile==null){
			exit( json_encode(array('code'=>700,'msg'=>'手机号码格式不正确。')) );
		}
		//验证码
		$result = $this->send_mobile_reg_code($mobile,$member['uid']);
		if($result[0]!=1){
			exit( json_encode(array('code'=>800,'msg'=>$ok[1])) );
		}else{
			_setcookie("mobilecheck",base64_encode($mobile));
			exit( json_encode(array('code'=>200,'msg'=>'发送成功。')) );
		}
	}
	//修改头像异步
	public function editImg(){
		$this->load->model('Comm');
		$this->Comm->debug('000');
		$id = isset($_POST['id']) ? $_POST['id'] : "";
		$img = isset($_POST['img']) ? $_POST['img'] : "";
		$targetFolder = '/statics/uploads/photo/'; // Relative to the root
		$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;
        if (!file_exists($targetPath)) {
            mkdir($targetPath);
        }	
        $ymd = date("Ymd");
        $targetFolder .= $ymd . "/";
        $targetPath .= $ymd . "/";
        if (!file_exists($targetPath)) {
            mkdir($targetPath);
        }		//创建日期仓库

        //处理data base64_encode 图片
		if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)){
		  $type = $result[2];
		  $file_before = date("YmdHis") . '_' . rand(10000, 99999);
		  $new_file_name = $file_before . '.' . $type;
		  $file_path = $targetPath . $new_file_name;  
		  $file_url = 	$targetFolder.$new_file_name;

        
		  $this->Comm->debug('111');
		  if (file_put_contents($file_path, base64_decode(str_replace($result[1], '', $img)))){
			//缩略处理
			$this->Comm->debug('222');	
			require_once(ROOTPATH.'/app/libraries/Image.php');
			$roby_img_obj = new Image();
            $roby_img_obj->open($file_path);
            $thumg_file_name = 'thumg_'. $new_file_name;
            $thumg_path = $targetPath . $thumg_file_name;
            $this->Comm->debug('333');	
            //$roby_img_obj->water($php_path . ADMIN_WATER, IMAGE_WATER_CENTER)->save($file_path);        //添加水印
            $roby_img_obj->thumb(120, 120)->save($thumg_path);
            $thumg_file_url = $targetFolder.$thumg_file_name;
            $this->Comm->debug('444');
		    $this->db->query("UPDATE `go_member` SET `img`='".$thumg_file_url."' where uid='" . $id . "'");				
		    $this->Comm->debug('555');
		    echo $thumg_file_url;
		  }  
		}





	}		 	
			
}
