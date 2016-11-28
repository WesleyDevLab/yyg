<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends AdminBase {
	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('roby');	
	}	
	public function index(){
	}
	/*
		显示会员
		根据第四个参数显示不同类型会员
		@def 		默认会员
		@del 		删除会员
		@noreg 		未认证会员
		@b_qq 		QQ绑定会员
		@b_weibo 	微博绑定会员
		@b_taobao 	淘宝绑定会员
		@day_new	今日新增
		@day_shop	今日消费		
					....
		第五个参数排序字段
		uid,money,time,jingyan,score
					....
		第六个参数排序类型
		desc,asc
					....		
	*/
	/*商品分类列表*/
	public function lists(){
		//查找会员
		$where = $order = $where_list = $where_all = $where_p = '';
        $p = intval($this->input->get('per_page'));		//当前页数
        if(!$p){
        	$p=1;
        }
		$act =  htmlspecialchars(trim($this->input->get('act')));
		if($act=='form'){
			$p = 1;
		}
		$where_p .= "?p=".$p;
		$uid = intval($this->input->get('uid'));
		$tiaojian = htmlspecialchars(trim($this->input->get('tiaojian')));
		if($uid){
			$data['uid'] = $uid;
			$where .= " and m.uid= '".$uid."'";
			$where_p.="&uid=".$uid;
		}
		$username=htmlspecialchars(trim($this->input->get('username') ));
		if($username){
			$data['username'] = $username;
			$where .= " and (m.username like '%".$username."%' or m.mobile like '%".$username."%' )";
			$where_p.="&username=".$username;
		}
		$shouhuoren=htmlspecialchars(trim($this->input->get('shouhuoren')));
		if($shouhuoren){
			$data['shouhuoren'] = $shouhuoren;
			$where_list = " and d.shouhuoren like '%".$shouhuoren."%'";
			$where_p.="&shouhuoren=".$shouhuoren;
		}
		/*
		$email=htmlspecialchars(trim($_POST['email']));
		if($email){
			$where .= " and m.email like '%".$email."%'";
		}
		*/
		$mobile = htmlspecialchars(trim($this->input->get('mobile')));
		if($mobile){
			$data['mobile'] = $mobile;
			$where .= " and m.mobile like '%".$mobile."%'";
			$where_p.="&mobile=".$mobile;
		}
		$posttime1 = $this->input->get('posttime1');
		$posttime2 = $this->input->get('posttime2');

		$data['posttime1'] = $posttime1;
		$data['posttime2'] = $posttime2;
		$where_p.="&posttime1=".$posttime1."&posttime2=".$posttime2;	
				
		if($posttime1 && $posttime2){
			if($posttime2 < $posttime1){$this->_message("结束时间不能小于开始时间");return false;}			
			$where .= " and m.time > '".strtotime($posttime1)."' AND m.time < '".strtotime($posttime2)."'";
		}
		if($posttime1 && empty($posttime2)){				
			$where .= " and m.time > '".strtotime($posttime1)."'";
		}
		if($posttime2 && empty($posttime1)){				
			$where .= " and m.time < '".strtotime($posttime2)."'";
		}
		if(empty($posttime1) && empty($posttime2)){				
			$where .= false;
		}		
		if(intval($tiaojian)){
			switch($tiaojian){
				case '1':		//升序
				$where_list .= " order by reg_time asc";
				$all = $this->db->query("select uid from go_member as m where 1=1 $where $where_all");
				break;
				case '2':
				$where_list .= " order by reg_time desc";
				$all = $this->db->query("select uid from go_member as m where 1=1 $where $where_all");
				break;
				case '3':		//高级会员
				$where_list .= " and m.user_type=1";
				$all = $this->db->query("select uid from go_member as m where 1=1 and m.user_type=1 $where $where_all ");
				break;
				case '4':
				$where_list .= " and m.user_type=0";
				$all = $this->db->query("select uid from go_member as m where 1=1 and m.user_type=0  $where $where_all  ");
				break;	
			}
			$data['tiaojian'] = $tiaojian;
			$where_p.="&tiaojian=".$tiaojian;
		}else{
			if($shouhuoren){
				$all = $this->db->query("select *,m.uid as userid,m.time as reg_time,m.mobile as u_mobile from go_member as m left join go_member_dizhi as d on m.uid=d.uid where 1=1 $where $where_all  and d.shouhuoren like '%".$shouhuoren."%'");
			}else{
				$all = $this->db->query("select uid from go_member as m where 1=1 $where $where_all");
			}
			
		}


		if(empty($where_list)){
			$where_list .= "order by m.time desc";
		}			


		$data['p'] = $p;
		$total = $all->num_rows();
		$this->load->library('pagination');
		$where .= $order;
		$config['base_url'] = G_WEB_PATH.'/admin/member/lists'.$where_p;
		$config['total_rows'] = $total;
		$config['per_page'] = 10;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';	
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';		
		$config['first_link'] = '首页';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '尾页';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['use_page_numbers'] = TRUE;
		$config['cur_tag_open'] = '<li><span class="red">';
		$config['cur_tag_close'] = '</span></li>';	
		$config['page_query_string'] = TRUE;					
		$this->pagination->initialize($config);

        $data['pagebar'] = $this->pagination->create_links();       
        $page_size = $config['per_page'];
        $start = ($p-1) * $page_size;
		
        $data['list'] = $this->db->query("select *,m.uid as userid,m.time as reg_time,m.mobile as u_mobile from go_member as m left join go_member_dizhi as d on m.uid=d.uid and d.default='Y' where 1=1 $where $where_list limit $start, $page_size")->result_array();
		//print_r($data['list']);
		$this->load->view('admin/member_list',$data);

	}
	//添加会员
	public function addmem(){
		$id=$this->uri->segment(4);
		$submit = $this->input->post('dosubmit');
		$is_edit = false;
		$msg = '添加';
		$data = array();
		if(intval($id)){			//是编辑模式
			$msg = '编辑';
			$is_edit = true;
			$res['row'] = $this->getRow("go_member","uid='".$id."'");
		}
		$res['is_edit'] = $is_edit;		
		$res['msg'] = $msg;
		//print_r($this->input->post());exit;		
		if(isset($submit)){
			$username = htmlspecialchars($this->input->post('username'));
			$email = htmlspecialchars($this->input->post('email'));
			$mobile = htmlspecialchars($this->input->post('mobile'));
			$pass = htmlspecialchars($this->input->post('password'));
			$money = htmlspecialchars($this->input->post('money'));			
			$thumb = htmlspecialchars($this->input->post('thumg'));


			$emailcode=htmlspecialchars(trim($_POST['emailcode']));
			$mobilecode=htmlspecialchars(trim($_POST['mobilecode']));
			$qianming=htmlspecialchars(trim($_POST['qianming']));
			$membergroup=htmlspecialchars(trim($_POST['membergroup']));
			$time = time();



			if(!$mobile){$this->_message("请填写注册手机号码");return false;}
			if(!$is_edit){
				if(!$pass){$this->_message("请填写密码");return false;}	
			}
					
			 			
			$data = array(
			    'username' => $username,
			    'email' => $email,
			    'mobile' => $mobile,
			    'money' => $money,
			    'emailcode' => $emailcode,
			    'mobilecode' => $mobilecode,
			    'qianming' => $qianming,
			    'groupid' => $membergroup
			);
			if(!empty($thumb)){
				$data['img'] = $thumb;
			}else{
				if(!$is_edit){			//是新增
					$data['img'] = '/statics/uploads/photo/member.jpg';		//插入默认图片
				}
				
			}

			$pwd = safe_replace($pass);				//密码加密
	        $password=md5($pwd);			
			$data = (isset($data2)) ? array_merge($data,$data2) : $data;				
			if($is_edit){			//编辑
				$data['time'] = $res['row']['time'];
				$data['user_ip'] = $res['row']['user_ip'];
				$data['uid'] = $id;
				if(!$pass){			//编辑时密码为空，就是原密码
					$data['password'] = $res['row']['password'];
				}else{
					
					$data['password'] = $password;
				}
				if($res['row']['img']){			//原来就有图片
					if(!empty($thumb) && $thumb!='photo/member.jpg'){			
						unlink(ROOTPATH.$res['row']['img']);					
					}else{
						$data['img'] = $res['row']['img'];
					}					
				}				
				$flag = $this->db->replace('go_member', $data);
			}else{					
				//判断是否已存在
				if($email){
					$is_exist = $this->getRow("go_member","mobile='".$mobile."' or email='".$email."'");
				}else{
					$is_exist = $this->getRow("go_member","mobile='".$mobile."'");		
				}
		        
		        if($is_exist){
		        	if($email){
		        		$this-> _message("该邮箱已经被注册 ，请重新录入");
		        		return false;
		        	}
		        	if($mobile){
		        		$this-> _message("该手机号码已经被注册 ，请重新录入");
		        		return false;
		        	}	        	
		        }
		        $data['password'] = $password;
				$data['time'] = $time; 
				$iprow = $this->db->query("SELECT * FROM `go_ip` WHERE status=0 order by rand() limit 1")->row_array();
				$user_ip = $iprow['province'].'省'.$iprow['city'].'市,'.$iprow['ip'];
				$this->db->Query("UPDATE `go_ip` SET status='1' where `id`='$iprow[id]'");				
				$data['user_ip'] = $user_ip;
 				$flag = $this->db->insert('go_member', $data);
			}
			if($flag){			
				$this->_message("用户".$msg."成功!",G_WEB_PATH.'/admin/member/lists');
			}else{
				$this->_message("用户".$msg."失败!");
			}
			return false;									
		}	
		$this->load->view('admin/member_add',$res);
	}
	//充值记录
	public function recharge(){
		$type = htmlspecialchars($this->uri->segment(4));		//当前页数
		if(isset($_POST['sososubmit'])){
			$posttime1=isset($_POST['posttime1'])?$_POST['posttime1']:'';
			$posttime2=isset($_POST['posttime2'])?$_POST['posttime2']:'';
 
			if(!empty($posttime1) && !empty($posttime2)){ //如果2个时间都不为空
				$posttime1=strtotime($posttime1);
				$posttime2=strtotime($posttime2);
				if($posttime1 > $posttime2){
					$this->_message("前一个时间不能大于后一个时间");
				}
				$times= "1=1 and `time`>='$posttime1' AND `time`<='$posttime2'";
			}else{
				$times = "1=1";
			}
			$data['posttime1'] = $posttime1;
			$data['posttime2'] = $posttime2;
			$content = '';
			if($type=="cz"){
				$chongzhi=isset($_POST['chongzhi'])?$_POST['chongzhi']:'';
				if(!empty($chongzhi) && $chongzhi!='请选择充值来源'){
					$content=" AND `content`='$chongzhi'";
					$data['chongzhi'] = $chongzhi;
				}
				if(empty($chongzhi) || $chongzhi=='请选择充值来源'){
					$content=" AND (`content`='充值' or `content`='管理员修改金额' or `content`='使用佣金充值到用户账户' or `content`='使用余额宝充值到用户账户')";
				}				
			}
 
			
			$yonghu=isset($_POST['yonghu'])?$_POST['yonghu']:'';
			if(empty($yonghu) || $yonghu=='请选择用户类型'){
				$uid=' AND 1';
			}
			$yonghuzhi=isset($_POST['yonghuzhi'])?$_POST['yonghuzhi']:'';
			if($yonghu=='用户id'){
				if($yonghuzhi){
					$uid=" AND `uid`='$yonghuzhi'";
				}else{
					$uid=' AND 1';
				}
			}
			if($yonghu=='用户名称'){
				if($yonghuzhi){
					$user_uid=$this->db->query("select uid from `go_member` where `username`='$yonghuzhi'")->row_array();
					if($user_uid){
						$uid=" AND `uid`='$user_uid[uid]'";
					}else{
						$this->_message($yonghuzhi."用户不存在！");
						$uid=' AND 1';
					}
				}else{
					$uid=' AND 1';
				}
			}
			if($yonghu=='用户邮箱'){
				if($yonghuzhi){
					$user_uid=$this->db->query("select uid from `go_member` where `email`='$yonghuzhi'")->row_array();
					if($user_uid){
						$uid=" AND `uid`='$user_uid[uid]'";
					}else{
						$this->_message($yonghuzhi."用户不存在！");
						$uid=' AND 1';
					}
				}else{
					$uid=' AND 1';
				}
			}
			if($yonghu=='用户手机'){
				if($yonghuzhi){
					$user_uid=$this->db->query("select uid from `go_member` where `mobile`='$yonghuzhi'")->row_array();
					if($user_uid){
						$uid=" AND `uid`='$user_uid[uid]'";
					}else{
						$this->_message($yonghuzhi."用户不存在！");
						$uid=' AND 1';
					}
				}else{
					$uid=' AND 1';
				}
			}
			$data['yonghu'] = $yonghu;
			$data['yonghuzhi'] = $yonghuzhi;
			$wheres=$times.$content.$uid;
		}
		$num=20;
		switch($type){
			case 'cz':
			if(empty($wheres)){
				$total=$this->db->query("SELECT * FROM `go_member_account` WHERE (`content`='充值' or `content`='微信扫一扫充值' or `content`='使用佣金充值到用户账户' or `content`='微信公众号充值' or `content`='微信扫码充值' or `content`='支付宝扫码充值' or `content`='使用余额宝充值到用户账户') AND `type`='1'"); 
				$summoeny=$this->db->query("SELECT sum(money) sum_money FROM `go_member_account` WHERE (`content`='充值' or `content`='微信扫一扫充值' or `content`='使用佣金充值到用户账户' or `content`='微信公众号充值' or `content`='微信扫码充值' or `content`='支付宝扫码充值' or `content`='使用余额宝充值到用户账户') AND `type`='1'")->row_array(); 
			}else{
				$total=$this->db->query("SELECT *  FROM `go_member_account` WHERE $wheres"); 
				$summoeny=$this->db->query("SELECT sum(money) sum_money FROM `go_member_account` WHERE $wheres")->row_array(); 
			}			
			break;
			case 'xf':
			if(empty($wheres)){
				$total=$this->db->query("SELECT * FROM `go_member_go_record` WHERE 1"); 
				$summoeny=$this->db->query("SELECT sum(moneycount) sum_money FROM `go_member_go_record` WHERE 1")->row_array(); 
			}else{
				$total=$this->db->query("SELECT * FROM `go_member_go_record` WHERE $wheres"); 
				$summoeny=$this->db->query("SELECT sum(moneycount) sum_money FROM `go_member_go_record` WHERE $wheres")->row_array(); 
			}						
			break;
		}

		$total = $total->num_rows();
		$this->load->library('pagination');
		
		$config['base_url'] = G_WEB_PATH.'/admin/member/recharge/'.$type.'/page';
		$config['total_rows'] = $total;
		$config['per_page'] = 10;
		$config['num_tag_open'] = '<li>';
		$config['num_tag_close'] = '</li>';	
		$config['next_tag_open'] = '<li>';
		$config['next_tag_close'] = '</li>';
		$config['prev_tag_open'] = '<li>';
		$config['prev_tag_close'] = '</li>';		
		$config['first_link'] = '首页';
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['last_link'] = '尾页';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['use_page_numbers'] = TRUE;
		$config['cur_tag_open'] = '<li>';
		$config['cur_tag_close'] = '</li>';		
				
		$this->pagination->initialize($config);

        $data['pagebar'] = $this->pagination->create_links();
        $p = intval($this->uri->segment(6));		//当前页数
        if(!$p){
        	$p=1;
        }     
        $page_size = $config['per_page'];
        $start = ($p-1) * $page_size;

        if($type=='cz'){
			if(empty($wheres)){
				$recharge=$this->db->query("SELECT * FROM `go_member_account` WHERE (`content`='充值' or `content`='微信扫一扫充值' or `content`='使用佣金充值到用户账户' or `content`='微信公众号充值' or `content`='微信扫码充值' or `content`='支付宝扫码充值' or `content`='使用余额宝充值到用户账户') AND `type`='1' order by `time` desc limit $start, $page_size")->result_array(); 
			}else{
				$recharge=$this->db->query("SELECT * FROM `go_member_account` WHERE  $wheres order by `time` desc limit $start, $page_size")->result_array(); 
			}
			$data['list'] = $recharge;
        }else if($type=='xf'){
			if(empty($wheres)){
				$recharge=$this->db->query("SELECT * FROM `go_member_go_record` WHERE 1 order by `time` desc limit $start, $page_size")->result_array(); 
			}else{
				$recharge=$this->db->query("SELECT * FROM `go_member_go_record` WHERE  $wheres order by `time` desc limit $start, $page_size")->result_array(); 
			}
			$data['pay_list']=$recharge;       	 
        }

		$members=array();
		for($i=0;$i<count($recharge);$i++){
			$uid=$recharge[$i]['uid'];
			$member=$this->db->query("select * from `go_member` where `uid`='$uid'")->row_array();
			$members[$i]=$member['username'];	
			if(empty($member['username'])){
				if(!empty($member['email'])){
					$members[$i]=$member['email'];
				}
				if(!empty($member['mobile'])){
					$members[$i]=$member['mobile'];
				}
			}
		}
		$data['recharge'] = $recharge;
		$data['members'] = $members;	
		$data['summoeny'] = $summoeny;
		switch($type){
			case 'cz':
			$this->load->view('admin/member_recharge',$data);
			break;
			case 'xf':
			$this->load->view('admin/member_xf',$data);
			break;
		}		
	}


	
}
