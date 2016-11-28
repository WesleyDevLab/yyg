<?php
require_once('global.fun.php');
class MY_Controller extends CI_Controller{
	function  __construct(){
		parent::__construct();
	}
	/*
	*	发送短信
	**/
	function _sendmobile($mobiles='',$content=''){
		//file_put_contents("m.txt", json_encode($config)."\r\n\n\r",FILE_APPEND);
		$mobiles=str_replace("，",',',$mobiles);
		$mobiles=str_replace(" ",'',$mobiles);
		$mobiles=trim($mobiles," ");
		$mobiles=trim($mobiles,",");
		require_once(ROOTPATH.'/app/libraries/sendmobile.class.php');
		$config=array();
		$config['mobile']=$mobiles;
		$config['content']= $content;
		$config['ext']='';
		$config['stime']='';
		$config['rrid']='';
		$sends = new sendmobile($config);
		$cok=$sends->init($config);
	
		if(!$cok){
			return array('-1','配置不正确!');
		}
		$sends->send();
		$sendarr=array($sends->error,$sends->v);
		return $sendarr;
	}	
	function send_mobile_reg_code($mobile=null,$uid=null){
			//if(!$uid)_message("发送用户手机认证码,用户ID不能为空！");
			if(!$mobile){
				$this->_message("发送用户手机认证码,手机号码不能为空!");
				return false;
			}
			
			$checkcodes=rand(100000,999999).'|'.time();//验证码
			$this->db->Query("UPDATE `go_member` SET mobilecode='$checkcodes' where `uid`='$uid'");				
			$checkcodes = explode("|",$checkcodes);
			$template = $this->db->query("select * from `go_caches` where `key` = 'template_mobile_reg'")->row_array();
		
			if(!$template){
				$content =  "你在惠玩车的短信验证码是:".strtolower($checkcodes[0]);
			}	
			if(empty($template['value'])){
				$content =  "你在惠玩车的短信验证码是:".strtolower($checkcodes[0]);
			}else{
				if(strpos($template['value'],"000000") == true){
						$content= str_ireplace("000000",strtolower($checkcodes[0]),$template['value']);			
				}else{
						$content = $template['value'].strtolower($checkcodes[0]);					
				}
			}
	    //测试时用
	    //$content ="您的验证码是:".strtolower($checkcodes[0])."。请不要把验证码泄露给其他人。";
			return $this->_sendmobile($mobile,$content);
	}	
	/**
	*	message 输出自定义错误页面
	*	$str 错误信息
	*	$url 返回页面的地址, 默认返回上一页
	*	$time 返回时间，默认3秒后返回
	*   $config 其他参数配置.类型为数组 $config['titlebg']='#549bd9',$config['title']='#fff',
	*/

	/*
	*	系统消息提示
	**/
	function _message($string=null,$defurl=null,$time=2){	
		if(empty($defurl)){
			$defurl = ":js:";
		}
		$time=intval($time);if($time<2){$time=2;}
		$data = array(
			'string' => $string,
			'time' => $time,
			'str_url_two' => array("url"=>G_WEB_PATH.'/admin/goods/admin_index',"text"=>"返回后台首页"),
			'defurl' => $defurl
		);
		$this->load->view('layout/message',$data);
		return false;
	}
	function _mobileMsg($string=null,$defurl=null,$time=2){	
		if(empty($defurl)){
			$defurl = ":js:";
		}
		$time=intval($time);if($time<2){$time=2;}
		$data = array(
			'string' => $string,
			'time' => $time,
			'str_url_two' => array("url"=>G_WEB_PATH,"text"=>"返回首页"),
			'defurl' => $defurl
		);
		$this->load->view('layout/mobilemsg',$data);
		return false;
	}	
	function tree($list,$pid=0,$level=0,$html='&nbsp;&nbsp;&nbsp;&nbsp;'){
	    static $tree = array();	    
	    foreach($list as $v){
	        if($v['parentid'] == $pid){
	        	if($pid!=0){
	        		$v['name'] = str_repeat($html,$level).'├─  '.$v['name'];
	        	}	            
	            $tree[$v['cateid']] = $v;
	            $this->tree($list,$v['cateid'],$level+1);
	        } 
	    }
	    return $tree;	

	}
	
	//查找 某个分类对应的目录名
	function getCatDir($cateid){
		$root_path = ROOTPATH;
		$cat = $this->getRow('go_goods_cat', "cateid='".$cateid."'" , 'parentid,catdir');
		if($cat['parentid']){
			$parentcat = $this->getRow('go_goods_cat',"cateid='".$cat['parentid']."'",'catdir');
			$root_path .='/'.$parentcat['catdir'];
			/*
			if (!file_exists($root_path)) {
				mkdir($root_path);
			}
			*/
			$root_path.='/'.$cat['catdir'];
			/*
			if (!file_exists($root_path)) {
				mkdir($root_path);
			}
			*/			
			$url = $parentcat['catdir'].'/'.$cat['catdir'].'/'; 
		}else{
			$root_path .= '/'.$cat['catdir'];
			/*
			if (!file_exists($root_path)) {
				mkdir($root_path);
			}
			*/			
			$url = $cat['catdir'].'/';
		}
		return $url;		
	}
	//读取静态文件[商品详情],返回商品详情
	public function readHtml($goods){
		foreach($goods as $k=>$good){
			//判断静态文件是否存在，不存在构建
			$path_file = $this->getCatDir($good['cateid']).$good['id'].'.html';
			/*
			$root_file = ROOTPATH.'/'.$path_file;
			if (!file_exists($root_file)){		//还未生成静态文件，调用方法生成
				$this->detail($good['id'],$root_file);
			}
			*/
			$goods[$k]['good_url'] = G_WEB_PATH.'/'.$path_file;
		}
		return $goods;		
	}
	//商品详情页面
	private function detail($good_id,$root_file){
		$good_id =intval($good_id);
		$data['curr'] = '';
		if($good_id){
			$item = $this->getRow('go_goods',"id='".$good_id."' and status=0");
			
			if(!$item){
				return false;
			}
			$qishu = $this->getAll('go_goods',"sid='".$item['sid']."' order by qishu desc");			//获取所有期数
			$path_file = $this->getCatDir($item['cateid']);				//获取当前静态文件路径
			$data['good_dir'] = $path_file;
			$data['item'] = $item;
			$data['curr'] = '';
			$data['qishu'] = $qishu;
			$html = '';			
			$this->load->helper('file');
			$this->load->view('index/detail',$data);
			$this->load->view('layout/footer');
			$html=$this->output->get_output();
			if (!write_file($root_file, $html))
			{
				return false;
			}
			exit;
						
		}
		return false;	
	}

	
		
	//查找某个分类下面的所有子分类,并合成in语句
	function getChildCat($cateid, $is_self=0){
		$arr = array();
		if($cateid){
			if($is_self==1){
				$arr[] = $cateid;
			}			
			$list = $this->db->query("select cateid,parentid from go_goods_cat where parentid='".$cateid."' and  status=0 order by sort desc")->result_array();
			foreach($list as $row){
				$arr[]=$row['cateid'];
				$temp = $this->db->query("select cateid,parentid from go_goods_cat where parentid='".$row['cateid']."' and  status=0 order by sort desc")->result_array();
				if(count($temp)>0){
					$this->getChildCat($row['cateid']);
				}
				
			}
			return array_unique($arr);			
		}		

	}	
	//获得排过序的商品分组
	function getCatList( $type='0' ){
		if($type==2){			//显示所有分类：比如友情链接
			$categorys = $this->db->query("select cateid,parentid,name,sort,pic,url from go_goods_cat where status=0 order by sort desc")->result_array();
		}else{
			$categorys = $this->db->query("select cateid,parentid,name,sort,pic,url from go_goods_cat where status=0 and type=$type order by sort desc")->result_array();
		}
		return $this->tree($categorys,0,0);		
	}
	//获得品牌分类列表
	function getBrandList(){
        $categorys = $this->db->query("select id,cateid,name,sort,pic,url from go_goods_brand where status=0 order by sort desc")->result_array();
		return $categorys;			
	}
	function getRow($table, $where , $field='*'){
		$cateinfo=$this->db->query("SELECT $field FROM `".$table."` WHERE $where LIMIT 1")->row_array();
		return $cateinfo;
	}
	function getAll($table, $where, $field='*'){
		$list=$this->db->query("SELECT $field FROM `".$table."` WHERE $where")->result_array();
		return $list;		
	}
	function get_user($uid){
		$row = $this->getRow('go_member',"uid='".$uid."'",'uid,username,email,img,money');
		return $row;
	}	
	function get_user_name($uid='',$type='username',$key='sub'){
		//roby为了与member.index.html中账号保持一致调一下位置
		if(is_array($uid)){			
				if(isset($uid['username']) && !empty($uid['username'])){
	                if(isset($uid['mobile']) && !empty($uid['mobile'])){
	                    return $uid['username'];
	                }else{
	                    return $uid['username'];
	                }
				}
				if(isset($uid['mobile']) && !empty($uid['mobile'])){	
					if($key=='sub'){
						return $uid['mobile'] = substr($uid['mobile'],0,3).'****'.substr($uid['mobile'],7,4);
					}else{
						return $uid['mobile'];
					}
				}			
				if(isset($uid['email']) && !empty($uid['email'])){
					if($key=='sub'){
						$email = explode('@',$uid['email']);				
						return $uid['email'] = substr($uid['email'],0,2).'*'.$email[1];
					}else{
						return $uid['email'];
					}
				}
				return '';
		}else{		
			$uid = intval($uid);
			$info = $this->db->query("select username,email,mobile from `go_member` where `uid` = '$uid' limit 1")->row_array();	
			if(isset($info['username']) && !empty($info['username'])){
	                if(isset($info['mobile']) && !empty($info['mobile'])){
	                    return $info['username'];
	                }else{
	                    return $info['username'];
	                }
			} 
			if(isset($info['mobile']) && !empty($info['mobile'])){	
					if($key=='sub'){
						return $info['mobile'] = substr($info['mobile'],0,3).'****'.substr($info['mobile'],7,4);
					}else{
						return $info['mobile'];
					}
			} 		
			if(isset($info['email']) && !empty($info['email'])){	
				 if($key=='sub'){
					$email = explode('@',$info['email']);			
					return $info['email'] = substr($info['email'],0,2).'*'.$email[1];
				 }else{
					return $info['email'];
				 }
			}
			if(isset($info[$type]) && !empty($info[$type])){				
					return $info[$type];
			}
			return '';
		}
	}
	/*
	* 获取用户信息
	*/
	function get_user_key($uid='',$type='img',$size=''){
		if(is_array($uid)){
			if(isset($uid[$type])){		
				if($type=='img'){				
					$fk = explode('.',$uid[$type]);
					$h = array_pop($fk);
					if($size){
						return $uid[$type].'_'.$size.'.'.$h;
					}else{
						return $uid[$type];
					}
				}
				return $uid[$type];
			}
			return 'null';
		}else{
			$uid = intval($uid);
			$info = $this->db->query("select {$type} from `go_member` where `uid` = '$uid' limit 1")->row_array();
			if($type=='img'){				
					$fk = explode('.',$info[$type]);
					$h = array_pop($fk);
					if($size){
						return $info[$type].'_'.$size.'.'.$h;
					}else{
						return $info[$type];
					}
			}
			if(isset($info[$type])){			
				return $info[$type];
			}
			return 'null';
		}
	}	
		
	
}
 
class AdminBase extends MY_Controller{
	function  __construct(){
		parent::__construct();
		$this->base_url = $this->config->item('base_url');
		$this->load->helper('url');
		$this->CheckAdmin();
	}
	//判断用户是否登陆
	private function CheckAdmin(){
		$act = $this->router->fetch_method();
		if($act != 'login'){
			$check = $this->CheckAdminInfo();
			if(!$check)$this->_message("请登录后在查看页面",G_WEB_PATH.'/admin/user/login');
			
		}
	}
	//判断用户
	private function CheckAdminInfo($uid=null,$ashell=null){
		if($uid && $ashell){
			$CheckId = _encrypt($uid,'DECODE');
			$CheckAshell =  _encrypt($ashell,'DECODE');
		}else{			
			$CheckId=_encrypt(_getcookie("AID"),'DECODE');
			$CheckAshell=_encrypt(_getcookie("ASHELL"),'DECODE');
		}
		if(!$CheckId || !$CheckAshell){			
			return false;
		}				
		$info=$this->getRow('go_admin',"`uid` = '$CheckId'");	
		if(isset($_POST['dosubmit'])||isset($_POST['submit-1'])){
		if($info['mid']=='1'){
				$this->_message("测试帐号无修改权限!");
			}
		}
		
		if(!$info)return false;
		$infoshell = md5($info['username'].$info['userpass']).md5($_SERVER['HTTP_USER_AGENT']);
		if($infoshell!=$CheckAshell)return false;
		$this->AdminInfo=$info;
		return true;
	}		
}
//用户未登录，直接跳转 
class CheckHomeBase extends MY_Controller{	
	protected $userinfo=NULL;	
	public function __construct(){
		parent::__construct();
		$uid=intval(_encrypt(_getcookie("uid"),'DECODE'));		
		$ushell=_encrypt(_getcookie("ushell"),'DECODE');
		if(!$uid)$this->userinfo=false;
		$this->userinfo=$this->db->query("SELECT * from `go_member` where `uid` = '$uid'")->row_array();
		if(!$this->userinfo)$this->userinfo=false;	
	
		$shell=md5($this->userinfo['uid'].$this->userinfo['password'].$this->userinfo['mobile'].$this->userinfo['email']);		
		if($ushell!=$shell)$this->userinfo=false;
	}
	
	protected function checkuser($uid,$ushell){
		$uid=intval(_encrypt($uid,'DECODE'));
		$ushell=_encrypt($ushell,'DECODE');	
		if(!$uid)return false;
		if($ushell===NULL)return false;
		$this->userinfo=$this->db->query("SELECT * from `go_member` where `uid` = '$uid'")->row_array();
		if(!$this->userinfo){
			$this->userinfo=false;
			return false;
		}
		$shell=md5($this->userinfo['uid'].$this->userinfo['password'].$this->userinfo['mobile'].$this->userinfo['email']);
		if($ushell!=$shell){
			$this->userinfo=false;
			return false;
		}else{
			return true;
		}
		
	}
	public function get_user_info(){
		if($this->userinfo){
			return $this->userinfo;
		}else{
			return false;
		}
	}
	protected function HeaderLogin(){
		$this->_message("你还未登录，无权限访问该页！",G_WEB_PATH."/mobile/user/login");
	}	
	
}
class NoCheckHomeBase extends MY_Controller{
	function  __construct(){
		parent::__construct();	
	}	
}

